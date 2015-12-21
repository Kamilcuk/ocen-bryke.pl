<?php
// Kamil Cukrowski 2015.11.27 11:40
require_once('../db.inc');
require_once('../szukaj.inc');
db::setDebug(1);
class user {
	private $table = 'Uzytkownik';
	private $timeout = 60;	// timeout in seconds
	public $nick = NULL;
	public $zalogowany = false;
	private $id = null;
	public function __construct($name = null, $pass = null) {
		if ( $name != null && $pass != null )
			$this->zaloguj($name, $pass);
	}
	// WAZNE: ta funkcje nalezy wywolywac za kazdym razem gdy chce sie cos zrobic na serwie
	function zweryfikujLogin() {
		$row = db::queryone('SELECT sessid, ip, last_action FROM `'.$this->table.'` WHERE nick =  \''.$this->nick.'\' LIMIT 1');
		$ip = $_SERVER['REMOTE_ADDR'];
		$sessid = session_id();
		$last_action = $row['last_action'];

		$row2 = db::queryone('SELECT TIMESTAMPDIFF(SECOND, \''.$last_action.'\', NOW())');
		$timeDiff = reset($row2); // this resets pointer of array and returns first element of it (which is time diff)

		if($ip==$row['ip'] and $sessid==$row['sessid'] and $timeDiff<$this->timeout) {
			// update last_action so we prolong the timeout
			return db::queryone('UPDATE `'.$this->table.
					'` SET last_action=CURRENT_TIMESTAMP() WHERE nick = \''.$this->nick.'\' LIMIT 1');
		} else {
			$this->wyloguj();
			return false;
		}
	}
	function sprawdzHaslo($user, $pass) {
		$user = db::escape($user);
		$row = db::queryone('SELECT haslo FROM `'.$this->table.'` where nick = \''.$user.'\'');
		return password_verify($pass, $row['haslo']);
	}
	function zaloguj($user, $pass) {
		if ( isset($_SERVER['REMOTE_ADDR']) )
			$ip = $_SERVER['REMOTE_ADDR'];
		else
			$ip = "localhost";
		$sessid = session_id();

		if($this->sprawdzHaslo($user, $pass)) {
			$this->nick = $user;
			$this->zalogowany = true;

			db::queryone('UPDATE `'.$this->table.'` SET ip=\''.$ip.'\', sessid=\''.$sessid.'\', last_action=CURRENT_TIMESTAMP() WHERE nick = \''.$this->nick.'\' LIMIT 1');
			return true;
		} else {
			$this->nick = NULL;
			$this->zalogowany = false;
			return false;
		}
	}
	function wyloguj()
	{		
		db::queryone('UPDATE `'.$this->table.'` SET ip=NULL, sessid=NULL WHERE nick = \''.$this->nick.'\' LIMIT 1');
		$this->nick = NULL;
		$this->zalogowany = false;
	}
	// ---------------------------
	function zarejestruj($user, $pass, $email)
	{
		$user = db::escape($user);
		$pass = db::escape($pass);
		$email = db::escape($email);
		$ret = db::queryone('SELECT * FROM `'.$this->table.'` WHERE nick=\''.$user.'\';');
		if(!empty($ret)) {
			return false;
		}
		$hashedPass = password_hash($pass, PASSWORD_BCRYPT);
		return db::queryone(
				'INSERT INTO `'.$this->table.'` (`nick`, `haslo`, `e-mail`) VALUES (\''.$user.'\', \''.$hashedPass.'\', \''.$email.'\');');
	}
	function usun() {
		if ( $this->nick == NULL ) return;
		$this->wyloguj();
		return db::queryone('DELETE FROM `'.$this->table.'` WHERE nick = \''.$this->nick.'\';');
	}
	// --------------------- pobieranie info
	function getInfo() {
		if ( $this->nick == NULL ) return NULL;
		return db::queryone('SELECT * from `'.$this->table.'` WHERE nick=\''.$this->nick.'\'');
	}
	function getId() {
		if ( $this->nick == NULL ) return;
		if ( $this->id == null )
			$this->id = db::queryone('SELECT ID_uzytkownika FROM `'.$this->table.'` WHERE nick = \''.$this->nick.'\';')
				["ID_uzytkownika"];
		return $this->id;
	}
	// ------------------- EDYCJA
	function edytuj($name, $value) {
		if ( $this->nick == NULL ) return;
		$name = db::escape($name);
		$value = db::escape($value);
		if ( $name == "ID_uzytkownika" ||
				$name == "nick" ||
				$name == "haslo") {
					return;
				}
		return db::queryone('UPDATE `'.$this->table.'` WHERE nick = \''.$this->nick.
						'\' SET \''.$name.'\' =  \''.$value.'\';');
	}
	function edytujHaslo($noweHaslo) {
		// TO DO
		return false;
	}
	// ------------------- Działania
	function actionDodaj($table, array $vals = array()) {
		// $user->actionDodaj("Komentarz", array("ID_komentarza" => 2, "tresc" => "15"));
		$columns = null;
		$values = null;
		foreach($vals as $key => $val) {
			if ( $columns != NULL ) {
				$columns .= " , ";
				$values .= " , ";
			}
			$columns .= "`".db::escape($key)."`";
			$values  .= "'".db::escape($val)."'";
		}
		if ( !$this->zalogowany ) return;
		switch ($table) {
			case "Samochod":
			case "Komentarz":
				return db::insertInto($table, "ID_uzytkownika, ".$columns, $this->getID().", ".$values);
			case "Marka":
			case "Model":
			case "Wersja":
				return db::insertInto($table, $columns, $values);
		}
		return false;
	}
	function actionUsun($table, $id) {
		if ( !$this->zalogowany ) return false;
		switch ($table) {
			case "Samochod":
			case "Komentarz":
				break;
			default:
				return false;
		}
		return db::deleteFrom($table,
				"`".db::getFirstColumnName($table)."` = '".$id."' AND `ID_uzytkownika` = '".$this->getId()."'");
	}
	
	// ---------------- dodaj Gówno -- na razie korzystamy z actionDodaj() powyzej
	/*
	function dodajKomentarz($ID_zdjecia, $tresc) {
		$tresc = "'".db::escape($tresc)."'";
		$ID_zdjecia = "'".db::escape($ID_zdjecia)."'";
		return db::insertInto("Komentarz", 
				"ID_zdjecia, ID_uzytkownika, tresc",
				$ID_zdjecia.", ".$this->getID().", ".$tresc);	
	}
	function dodajMarka($nazwa) {
		return db::insertInto("Marka", "nazwa", db::escape($nazwa));	
	}
	function dodajModel($ID_marki, $ID_silnika, $nazwa) {
		return db::insertInto("Marka", 
				"ID_marki, ID_silnika, nazwa", 
				db::escape($ID_marki).",".db::escape($ID_silnika).",".db::escape($nazwa));
	}
	function dodajOcenaKomentarza() {
		
	}
	function dodajOcenaSamochodu() {
		
	}
	function dodajSamochod() {
		
	}
	function dodajSilnik() {
		
	}
	function dodajWersja() {
		
	}
	*/
	function dodajZdjecie() {
		
	}
	// ------------------------------
}

// test
$user = new user("dupa", "dupa");
echo "ID: ".$user->getId()."\n";
$user->actionDodaj("Komentarz", array("ID_zdjecia" => 2, "tresc" => "15"));
$user->actionDodaj("Samochod", array(
		"ID_modelu" => 1,
		"ID_wersji" => 1,
		"ID_silnika" => 1,
		"ID_marki" => 1,
		"rok_produkcji" => 1999,
		"przebieg" => "15"
));
$user->actionDodaj("Samochod", array(
		"ID_modelu" => 1,
		"ID_wersji" => 1,
		"ID_silnika" => 2,
		"ID_marki" => 1,
		"rok_produkcji" => 1999,
		"przebieg" => "15"
));
$rows = szukaj(array("Samochod", "Uzytkownik:ID_uzytkownika:".$user->getId()));
print_r($rows);

foreach($rows as $row ) {
	$user->actionUsun("Samochod", $row["ID_samochodu"]);
}
$rows = szukaj(array("Komentarz:ID_zdjecia:2:ID_uzytkownika:".$user->getId() ));
print_r($rows);
foreach($rows as $row ) {
	$user->actionUsun("Komentarz", $row["ID_komentarza"]);
}

?>