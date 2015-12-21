<?php
// Kamil Cukrowski 2015.11.27 12:14
// Kamil Cukrowski 2015.11.27 11:40
// ta funkcja ma wszystko statyczne, bo potrzebujemy tylko jednego połączenia
// z bazą danych (po co nam kilka połączeń z bazą? )
require_once('settings.inc');
class db {
	private static $mysqli = NULL;
	private static $instances = 0;
	private static $debug = 0;
	static function setDebug($num) {
		if ( is_numeric($num) )
			static::$debug = $num;
	}
	public function __construct(array $arguments = array()) {
		db::connect();
	}
	function __destruct() {
	}
	static function connect() {
		if ( self::$mysqli != NULL ) return;
		global $settings;
		self::$mysqli= new mysqli(
				$settings['host'],
				$settings['user'],
				$settings['pass'],
				$settings['database']);
		/* check connection */
		if (self::$mysqli->connect_errno) {
			printf("DB MYSQLI Connect failed: %s \n", self::$mysqli->connect_error);
			exit();
		}
	}
	static function disconnect() {
		if ( self::$mysqli != NULL ) {
			self::$mysqli->close();
			self::$mysqli = NULL;
		}
	}
	static function query($query) {
		db::connect();
		if ( static::$debug ) echo "db: query: ".$query." => ";
		$result = self::$mysqli->query($query);
		if ( static::$debug ) {
			if ( !is_object($result) ) {
				if ( $result == true ) {
					echo "query returned true <br>\n";
				} else { 
					echo "query returned false <br>\n";
				}
			} else {
				echo "query returned object <br>\n";
			}
		}
		if ( !is_object($result) ) {
			if ( $result == true ) { 
				return $result;
			} else {
				if ( self::$mysqli->error ) {
					echo "db: mysqli->error: \"".self::$mysqli->error."\" \n";
				}
				return $result;
			}
		}
		$rows = array();
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$rows[] = $row;
		}
		$result->close();
		return $rows;
	}
	static function escape($string) {
		db::connect();
		return mysqli_real_escape_string(self::$mysqli, $string);
	}
	// -----------------------------------------------
	// pozostałe funkcje korzystają z query
	static function queryone($query) {
		$ret = db::query($query);
		if ( is_array($ret) )
			return $ret[0];
		else
			return $ret;
	}
	static function getColumnNames($table) {
		$table = db::escape($table);
		return db::query("SHOW COLUMNS FROM ".$table)[0];
	}
	static function getFirstColumnName($table) {
		return db::getColumnNames($table)["Field"];
	}
	static function insertInto($table, $columns, $values) {
		$table = db::escape($table);
		//$columns = db::escape($columns);
		//$values = db::escape($values);
		return db::query("INSERT INTO `".$table."` (".$columns.") VALUES(".$values.")");
	}
	static function deleteFrom($table, $warunek) {
		$table = db::escape($table);
		//$warunek = db::escape($warunek);
		return db::query("DELETE FROM ".$table." WHERE ".$warunek);
	}
	static function deleteWithId($table, $id) {
		return db::deleteFrom($table, db::getFirstColumnName($table)." = ".$id);
	}
};
function __shutdown_db_callback() {
	db::disconnect();
}
register_shutdown_function('__shutdown_db_callback');
db::connect();
?>