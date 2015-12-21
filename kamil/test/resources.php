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
	private $timeout = 30;	// timeout in seconds
	public $nick = NULL;
	public $zalogowany = false;
	
	// WAZNE: ta funkcje nalezy wywolywac za kazdym razem gdy chce sie cos zrobic na serwie
	function zweryfikujLogin()
	{
		$row =static::$db->query('SELECT sessid, ip, last_action FROM `'.$this->table.'` WHERE nick =  \''.$this->nick.'\' LIMIT 1');
		$ip = $_SERVER['REMOTE_ADDR'];
		$sessid = session_id();
		$last_action = $row['last_action'];
	
		$row2 = static::$db->query('SELECT TIMESTAMPDIFF(SECOND, \''.$last_action.'\', NOW())');
		$timeDiff = reset($row2); // this resets pointer of array and returns first element of it (which is time diff)
	
		if($ip==$row['ip'] and $sessid==$row['sessid'] and $timeDiff<$this->timeout)
		{
			// update last_action so we prolong the timeout
			static::$db->query('UPDATE `'.$this->table.'` SET last_action=CURRENT_TIMESTAMP() WHERE nick = \''.$this->nick.'\' LIMIT 1');
			return true;
		}
		else
		{
			$this->wyloguj();
			return false;
		}
	}
	public function __construct(array $arguments = array()) {
		static::$db = new db();
	}	
	function __destruct() {
		unset(static::$db);
	}
	function sprawdzHaslo($user, $pass) {
		$user = static::$db->escape($user); 
		$row = static::$db->query('SELECT haslo FROM `'.$this->table.'` where nick = \''.$user.'\'');
		return password_verify($pass, $row['haslo']);
	}
	function zaloguj($user, $pass)
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		$sessid = session_id();
	
		if($this->sprawdzHaslo($user, $pass))
		{
			$this->nick = $user;
			$this->zalogowany = true;
	
			static::$db->query('UPDATE `'.$this->table.'` SET ip=\''.$ip.'\', sessid=\''.$sessid.'\', last_action=CURRENT_TIMESTAMP() WHERE nick = \''.$this->nick.'\' LIMIT 1');
			return true;
		}
		else
		{
			$this->nick = NULL;
			$this->zalogowany = false;
			return false;
		}
	}
	function wyloguj()
	{
		static::$db->query('UPDATE `'.$this->table.'` SET ip=NULL, sessid=NULL WHERE nick = \''.$this->nick.'\' LIMIT 1');
		$this->nick = NULL;
		$this->zalogowany = false;
	}
	function dodaj($user, $pass, $email)
	{
		$user = static::$db->escape($user);
		$pass = static::$db->escape($pass);
		$email = static::$db->escape($email);
		$ret = static::$db->query('SELECT * FROM `'.$this->table.'` WHERE nick=\''.$user.'\';');
		if(!empty($ret)) {
			return false;
		}
		$hashedPass = password_hash($pass, PASSWORD_BCRYPT);
		static::$db->query('INSERT INTO `'.$this->table.'` (`nick`, `haslo`, `e-mail`) VALUES (\''.$user.'\', \''.$hashedPass.'\', \''.$email.'\');');
		return true;
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




