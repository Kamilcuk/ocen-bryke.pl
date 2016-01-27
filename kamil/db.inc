<?php
// Kamil Cukrowski 2015.11.27 12:14
require_once('settings.inc');
class db {
	private static $mysqli = NULL;
	private static $instances = 0;
	private static $debug = 0;
	static function setDebug($num) {
		if ( is_numeric($num) )
			static::$debug = $num;
	}
	public function __construct() {
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
		return db::query("INSERT INTO `".$table."` (".$columns.") VALUES(".$values.")");
	}
	static function deleteFrom($table, $warunek) {
		$table = db::escape($table);
		return db::query("DELETE FROM ".$table." WHERE ".$warunek);
	}
	static function deleteWithId($table, $id) {
		if ( !is_numeric($id) ) return false;
		return db::deleteFrom($table, db::getFirstColumnName($table)." = ".$id);
	}
	static function update($table, $set, $id) {
		$table = db::escape($table);
		$id = db::escape($id);
		if ( !is_numeric($id) ) return false;
		return db::query("UPDATE `".$table."` SET ".$set." WHERE `".db::getFirstColumnName($table)."` = '".$id."'");
	}
	static function getEnumValues( $table, $field )
	{
		db::setDebug(10);
		$table = db::escape($table);
		$field = db::escape($field);
	    $type = db::query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )[0]['Type'];
	    preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
	    $enum = explode("','", $matches[1]);
	    return $enum;
	}
};

/**
 * Pomocnicza funkcja do pobierania oceny. Mały wrapper, który 
 * przeciwdziała bugowi. Jak nie ma ani jednej oceny, to wyświetla ocenę '0'. :D
 * @param unknown $tabelaParametr określa czego ocenę pobieramy - samochodu czy zdjęcia czy komentarza.
 * Parametr czego jest nazwą tabeli.
 * @param unknown $id Id tego, co ocenę pobieramy
 */
function getOcena($tabela=NULL, $id=NULL) {
	if ( !is_numeric($id) ) {
		echo __FILE__.":".__LINE__."id nie numeric<BR>";
		return 'ERR';
	}
	switch($tabela) {
		case 'Samochod':
			$ret=db::query('select SUM(wartosc) as t from Ocena_samochodu where ID_samochodu = '.$id)[0]['t'];
			break;
		case 'Komentarz':
			$ret=db::query('select SUM(wartosc) as t from Ocena_komentarza where ID_komentarza = '.$id)[0]['t'];
			break;
	}
	return $ret == NULL ? '0' : $ret;
	
}
/**
 * pomocniczas funkcja przekirowywuje po czasie $czas w ms
 */
function przekierowanie($czas = 2000) {
	echo "Za chwile nastapi przekierowanie...";
	echo "<script type='text/javascript'>
					setTimeout(function()
					{
						window.parent.location.href = window.parent.location.href;
					}, ".$czas.");</script>";
}

register_shutdown_function('db::disconnect');
db::connect();
?>