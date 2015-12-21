<?php
// versja 0.3
$settings = array (
		'host' => '127.0.0.1',
		'user' => 'projekt',
		'pass' => 'projekt123',
		'database' => 'projekt'
);
class db {
	private $mysqli = NULL;
	public function __construct(array $arguments = array()) {
		$this->connect();
	}
	function __destruct() {
		$this->disconnect();
	}
	function connect() {
		if ( $this->mysqli != NULL ) {
			return;
		}
		global $settings;
		$this->mysqli = new mysqli(
				$settings['host'],
				$settings['user'],
				$settings['pass'],
				$settings['database']);
		/* check connection */
		if ($this->mysqli->connect_errno) {
			printf("DB MYSQLI Connect failed: %s \n", $this->mysqli->connect_error);
			exit();
		}
	}
	function disconnect() {
		if ( $this->mysqli != NULL ) {
			$this->mysqli->close();
			$this->mysqli = NULL;
		}
	}
	function query($query) {
		$result = $this->mysqli->query($query);
		if ( !is_object($result) ) return $result;
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$result->close();
		return $row;
	}
	function getcon() {
		return $this->mysqli;
	}
	function escape($string) {
		return mysqli_real_escape_string($this->mysqli, $string);
	}
};
class Uzytkownik {
	private $table = 'Uzytkownik';
	private $nick = NULL;
	private static $db;
	public function __construct(array $arguments = array()) {
		static::$db = new db();
	}
	function sprawdzHaslo($user, $pass) {
		$user = static::$db->escape($user); 
		$row = static::$db->query('SELECT haslo FROM `'.$this->table.'` where nick = \''.$user.'\'');
		if ( $pass == $row['haslo'] ) {
			return true;
		} else {
			return false;
		}
	}
	function zaloguj($user, $pass) {
		$user = static::$db->escape($user);
		$pass = static::$db->escape($pass);
		if ( $this->sprawdzHaslo($user, $pass) ) {
			$this->nick = $user;
			return true;
		} else {
			$this->nick = NULL;
			return false;
		}
	}
	function wyloguj() {
		$this->nick = NULL;
	}
	function dodaj($user, $pass, $email) {
		$db->query(
				'INSERT INTO `'.$this->table.'` (`nick`, `haslo`, `e-mail`)'.
				'VALUES (\''.static::$db->escape($user).
				'\', \''.static::$db->escape($pass).
				'\', \''.static::$db->escape($email).'\');');
	}
	function pobierzInfo() {
		if ( $this->nick == NULL ) return NULL;
		return static::$db->query('SELECT * from `'.$this->table.'` WHERE nick=\''.$this->nick.'\'');
	}
	function edytuj($name, $value) {
		if ( $this->nick == NULL ) return;
		$name = static::$db->escape($name);
		$value = static::$db->escape($value);
		if ( $name == "ID_uzytkownika" ||
				$name == "nick" || 
				$name == "haslo") {
			return;
		}
		static::$db->query('UPDATE `'.$this->table.'` WHERE nick = \''.$this->nick.
				'\' SET \''.$name.'\' =  \''.$value.'\';');
	}
	function usun() {
		if ( $this->nick == NULL ) return;
		$this->wyloguj();
		static::$db->query('DELETE FROM `'.$this->table.'` WHERE nick = \''.$this->nick.'\';');
	}
	function getID() {
		if ( $this->nick == NULL ) return;
		static::$db->query('SELECT ID_uzytkownika FROM `'.$this->table.'` WHERE nick = \''.$this->nick.'\';');
	}
}
class Samochod {
	
};
?>




