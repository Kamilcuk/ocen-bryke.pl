<?php
// Kamil Cukrowski 2015.11.27 11:40
// kosiak 2015.11.30
require_once('db.inc');
require_once('szukaj.inc');
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

	function updateActivity() {
		$_SESSION['LAST_ACTIVITY'] = time();
	}

	function zweryfikujLogin() {
		$ip = $_SERVER['REMOTE_ADDR'];
		if(isset($_SESSION['IP']) && strcmp($ip, $_SESSION['IP']) !== 0) {
			$this->wyloguj();
			return false;
		}

		if(isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $this->timeout)) {
			return true;
		}

		$this->updateActivity();
		return true;
	}
	function sprawdzHaslo($user, $pass) {
		$user = db::escape($user);
		$row = db::queryone('SELECT hash, salt FROM `'.$this->table.'` where nick = \''.$user.'\'');
		return password_verify($pass . $row['salt'], $row['hash']);
	}
	function zaloguj($user, $pass) {
		$ip = $_SERVER['REMOTE_ADDR'];
		$_SESSION['IP'] = $ip;
		$this->updateActivity();

		if($this->sprawdzHaslo($user, $pass)) {
			$this->nick = $user;
			$this->zalogowany = true;
			return true;
		} else {
			$this->nick = NULL;
			$this->zalogowany = false;
			return false;
		}
	}
	function wyloguj()
	{		
		if ( !$this->zalogowany ) return false;
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

		$salt = substr(md5(uniqid(rand(), TRUE)), 0, 32);
		$saltedPass = $pass . $salt;
		$hashedPass = password_hash($saltedPass, PASSWORD_BCRYPT);

		return db::queryone(
				'INSERT INTO `'.$this->table.'` (`nick`, `hash`, `salt`, `e-mail`) VALUES (\''.$user.'\', \''.$hashedPass.'\', \''.$salt.'\',  \''.$email.'\');');
	}
	function usun() {
		if ( !$this->zalogowany ) return false;
		$this->wyloguj();
		return db::queryone('DELETE FROM `'.$this->table.'` WHERE nick = \''.$this->nick.'\';');
	}
	// --------------------- pobieranie info
	function getInfo() {
		if ( !$this->zalogowany ) return false;
		return db::queryone('SELECT * from `'.$this->table.'` WHERE nick=\''.$this->nick.'\'');
	}
	function getId() {
		if ( !$this->zalogowany ) return false;
		if ( $this->id == null )
			$this->id = db::query('SELECT ID_uzytkownika FROM `'.$this->table.'` WHERE nick = \''.$this->nick.'\';')
				[0]["ID_uzytkownika"];
		return $this->id;
	}
	// ------------------- EDYCJA
	function edytuj($name, $value) {
		if ( !$this->zalogowany ) return false;

		$this->updateActivity();

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
	function edytujHaslo($noweHaslo, $oldPass) {
		if ( !$this->zalogowany ) return false;

		$this->updateActivity();

		if ( !$this->sprawdzHaslo($this->nick, $oldPass) ) {
			return false;
		}

		$pass = db::escape($noweHaslo);
		if(!empty($ret)) {
			return false;
		}
		$hashedPass = password_hash($pass, PASSWORD_BCRYPT);

		// TO DO : SQL QUERY -----------------------------
		return false;
	}
	
	// ------------------- Działania -------------------------
	function actionDodaj($table = null, array $vals = array()) {
		if ( !$this->zalogowany ) return false;
		if ( $table == null || sizeof($vals) == 0 ) { 
			echo __FILE__.__LINE__."actionDodaj: zle argumenty. <br>"; 
			return; 
		}

		$this->updateActivity();

		
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
		
		switch ($table) {
			case "Samochod":
			case "Komentarz":
			case "Ocena_komentarza":
			case "Ocena_samochodu":
				// TODO sprawdzanie wartości
				return db::insertInto($table, "ID_uzytkownika, ".$columns, $this->getId().", ".$values);
			case "Marka":
			case "Model":
			case "Silnik":
			case "Wersja":
				return db::insertInto($table, $columns, $values);
			case "Zdjecie":
				// pobierz ID_samochodu podane w wierszu polecen 
				if ( !isset($vals["ID_samochodu"]) ) {
					echo "Nie podałeś ID_samochodu przy dodawaniu zdjęcia <br>";
					return false;
				}
				$ID_samochodu = $vals["ID_samochodu"];
				if ( !is_numeric($ID_samochodu) ) {
					echo "Wartość ID_samochodu przy dodawniau zdjęcia nie jest liczbą.";
					return false;
				}
				// sprawdź czy to jest nasz samochod
				if ( !$this->actionSprawdzCzyMoje("Samochod", $ID_samochodu) ) {
					echo "Dany użytkownik o ID_uzytkownika: ".$this->getId()." nie posiada samochodu ";
					echo " o ID_samochodu równym ".$ID_samochodu."<br>";
					return false;
				}
				return db::insertInto($table, "ID_uzytkownika, ".$columns, $this->getId().", ".$values);
		}
		return false;
	}
	function actionUsun($table = null, $id = null) {
		if ( !$this->zalogowany ) return false;
		if ( $table == null || $id == null ) {
			echo __FILE__.__LINE__.": zle argumenty. <br>";
			return;
		}

		$this->updateActivity();

		switch ($table) {
			case "Samochod":
			case "Komentarz":
			case 'Zdjecie';
				break;
			default:
				return false;
		}
		if ( !$this->actionSprawdzCzyMoje($table, $id) ) {
			echo __FILE__.__LINE__."To nie moja ".$table." o id ".$id."nie moge tego wykasować! <br>";
			return false;
		}
		if ( $table == "Zdjecie" ) {
			// kasowanie zdjęcia.
			$rows = szukaj(array($table.":".db::getFirstColumnName($table).":".$id.":ID_uzytkownika:".$this->getId()));
			$file = '/srv/http/'.$rows[0]['url'];
			if ( !file_exists($file) ) {
				echo __FILE__.' cos nie tak, zdjecie '.$file.'nie istnieje! <BR>';
			}
			if ( !unlink($file) ) {
				echo __FILE__.' Error podczas usuwania zdjęcia '.$file.' <BR>';
			}
		}
		return db::deleteFrom($table,
				"`".db::getFirstColumnName($table)."` = '".$id."' AND `ID_uzytkownika` = '".$this->getId()."'");
	}
	function actionSprawdzCzyMoje($table, $id) {
		if ( !$this->zalogowany ) return false;

		$this->updateActivity();

		$rows = szukaj(array($table.":".db::getFirstColumnName($table).":".$id.":ID_uzytkownika:".$this->getId()));
		if ( sizeof($rows) == 1 ) {
			return true;
		} else {
			return false;
		}
	}
	/*
	function actionEdytuj($table, $id, array $vals = array()) {
		if ( !$this->zalogowany ) return false;
		if ( sizeof($vals) == 0 || !is_string($table) || !is_numeric($id) ) {
			echo __FILE__.__LINE__." zły parametr do edycji '.$table.' <BR>";
			return false;
		}

		$this->updateActivity();

		switch ($table) {
			case "Samochod":
			case "Komentarz":
			case 'Zdjecie';
			break;
			default:
				return false;
		}
		if ( !$this->actionSprawdzCzyMoje($table, $id) ) {
			echo __FILE__.__LINE__."To nie moja ".$table." o id ".$id."nie moge tego wykasować! <br>";
			return false;
		}
		
		$set = null; // ma UPDATE inną urwał składnie... :/
		foreach($vals as $key => $val) {
			if ( $set != NULL ) {
				$set .= " AND ";
			}
			$set .= "`".db::escape($key)."` = '".db::escape($val)."'";
		}

		switch ($table) {
			case "Samochod":
				// można edytować tylko ID_marki, ID_modelu, ID_wersji, ID_silnika, rok_produkcji i przebieg
				// UFFFFFFF! jak to zrobić?
				foreach($vals as $key => $val) {
					switch($key) {
						case 'ID_marki':
						case 'ID_modelu': 
						case 'ID_wersji':
						case 'ID_silnika':
						case 'rok_produkcji':
						case 'przebieg':
							break;
						default:
							echo __FILE__.__LINE__." zły parametr do edycji '.$table.' <BR>";
							return false;
					}
				}
				if ( sizeof($vals) > 6 ) {
					echo __FILE__.__LINE__." zły parametr do edycji '.$table.' <BR>";
					return false;
				}
				break;
			case "Komentarz":
				// można edytować tylko treść komentarza
				if ( !isset($vals['tresc']) || sizeof($vals) > 2 ) {
					echo __FILE__.__LINE__." zły parametr do edycji '.$table.' <BR>";
					return false;
				}
				break;
			case 'Zdjecie';
				// mozna edytować tylko opis
				if ( !isset($vals['opis']) || sizeof($vals) > 2 ) {
						echo __FILE__.__LINE__." zły parametr do edycji '.$table.' <BR>";
					return false;
				}
				break;
			default:
				return false;
		}
		return db::update($table, $set, $id);
	}
	*/
	// -------------------- EOF Działania --------------------------
	// ---------------- dodaj Gówno -- na razie korzystamy z actionDodaj() powyzej
	/*
	 function dodajKomentarz($ID_zdjecia, $tresc) {
	 $tresc = "'".db::escape($tresc)."'";
	 $ID_zdjecia = "'".db::escape($ID_zdjecia)."'";
	 return db::insertInto("Komentarz",
	 "ID_zdjecia, ID_uzytkownika, tresc",
	 $ID_zdjecia.", ".$this->getId().", ".$tresc);
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
	db: query: UPDATE `Uzytkownik` SET ip=NULL, sessid=NULL WHERE nick = 'dupa' LIMIT 1 => query returned true
Zostales wylogowany.
Za chwile nastapi przekierowanie...
	 function dodajWersja() {
	
	 }
	function dodajZdjecie($ID_samochodu, $url) {
		
	
	}
	*/
	// ------------------------------
}
?>
