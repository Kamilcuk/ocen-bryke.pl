<?php
require_once('../db.inc');
(new db())->setDebug(1);
function szukaj($table, $gdzie=null, $rozroznianego=null, $potym=null, $sortuj=null) {
	$db = new db();
	$table = $db->escape($table);
	$gdzie = $db->escape($gdzie);
	$rozroznianego = $db->escape($rozroznianego);
	$potym = $db->escape($potym);
	$sortuj = $db->escape($sortuj);
	$where=null;
	$sort=null;
	if ( $gdzie != null ) {
		$row = szukaj($gdzie, NULL, $rozroznianego, $potym, "", "")[0];
		$id = array_values($row)[0];
		$key = array_keys($row)[0];
		$where = " `".$key."` = '".$id."' ";
	} else {
		if ( $rozroznianego != null && $potym != null )
			$where = " `".$rozroznianego."` = '".$potym."' ";
	}
	if ( $where != null )
		$where = " where ".$where;
	if ( $sortuj != null )
		$sort = " ORDER BY ".$sortuj.' ';
	return (new db())->query("select * from ".$table.$where.$sort);
};
function szukaj2(array $args = array(), $sortuj=null) {
	if ( sizeof($args) > 1 ) {
		$myargs = array_shift($args);
		$array = szukaj2($args);
		if ( sizeof($array) == null ) return array();
		print_r($array);
		$row = $array[0];
		$id = array_values($row)[0];
		$key = array_keys($row)[0];
		$where = " `".$key."` = '".$id."' ";
		$pieces = explode(':', $myargs);
		$table = $pieces[0];
		if ( sizeof($pieces) > 2 ) {
			$where =  $where." AND `".$pieces[1]."` = '".$pieces[2]."' ";
		}			
	} else {
		$pieces = explode(':', $args[0]);
		$table = $pieces[0];
		$where = sizeof($pieces) > 2 ? " `".$pieces[1]."` = '".$pieces[2]."' " : null;		
	}
	if ( $where != null )
		$where = " where ".$where;
	if ( $sortuj != null )
		$sortuj = " ORDER BY ".$sortuj.' ';
	return (new db())->query(
			"select * from `".$table."`".$where.$sortuj);
}
function getFirstColumn($table) {
	return (new db())->query("SHOW COLUMNS FROM ".$table)[0]["Field"];
}
function szukaj3(array $args = array(), $sortuj=null) {
	$query = null;
	$where = null;
	$lastTable = null;
	foreach($args as $arg) {
		$pieces = explode(':', $arg);
		$thisTable = $pieces[0];
		
		$idColumn = getFirstColumn($thisTable);
		if ( $query == null ) {
			$query = "select ".$thisTable.".* from ".$thisTable;
		} else {
			$query = $query." INNER JOIN ".$thisTable.
				" ON `".$lastTable."`.`".$idColumn."` = `".$thisTable."`.`".$idColumn."` ";
		}
		if ( sizeof($pieces) > 2 ) {
			$addWhere = " `".$thisTable."`.`".$pieces[1]."` = '".$pieces[2]."' ";
			if ( $where != null ) {
				$where = $where." AND ".$addWhere;
			} else {
				$where = $addWhere;
			}
		}
		$lastTable = $thisTable;
	}
	if ( $where != null )
		$query = $query." where ".$where;
	return (new db())->query($query);
}
function szukaj4(array $args = array(), $sortuj=null) {
	$query = null;
	$where = null;
	foreach($args as $arg) {
		$pieces = explode(':', $arg);
		$oneTable = $pieces[0];
		if ( sizeof($pieces) > 1 ) {
			$twoTable = $pieces[1];
			$idColumn = getFirstColumn($twoTable);
		}
		if ( $query == null ) {
			$query = "select ".$oneTable.".* from ".$oneTable;
		} else {
			$query = $query." INNER JOIN ".$twoTable.
				" ON `".$oneTable."`.`".$idColumn."` = `".$twoTable."`.`".$idColumn."` ";
		}
		if ( sizeof($pieces) > 3 ) {
			$addWhere = " `".$twoTable."`.`".$pieces[2]."` = '".$pieces[3]."' ";
			if ( $where != null ) {
				$where = $where." AND ".$addWhere;
			} else {
				$where = $addWhere;
			}
		}
	}
	if ( $where != null )
		$query = $query." where ".$where;
	return (new db())->query($query);
}
//$rows = szukaj2(array("Samochod", "Marka:ID_marki:1"));
//foreach($rows as $row) print_r($row);
//$rows = szukaj2(array("Komentarz:ID_uzytkownika:26", "Zdjecie", "Samochod", "Uzytkownik:nick:kamil"));
//foreach($rows as $row) print_r($row);
//$rows = szukaj2(array("Komentarz:ID_uzytkownika:27", "Zdjecie", "Samochod", "Uzytkownik:nick:kamil"));
//foreach($rows as $row) print_r($row);
//$rows = szukaj3(array("Komentarz:ID_uzytkownika:27", "Zdjecie", "Samochod", "Uzytkownik:nick:kamil"));
//$rows = szukaj3(array("Samochod", "Uzytkownik:nick:kamil"));
//foreach($rows as $row) print_r($row);
//$rows = szukaj4(array("Komentarz:Komentarz:ID_uzytkownika:27", "Komentarz:Zdjecie", 
//		"Zdjecie:Samochod", "Samochod:Uzytkownik:nick:kamil"));
//foreach($rows as $row) print_r($row);
//$rows = szukaj3(array("Komentarz:ID_uzytkownika:27", "Zdjecie:ID_zdjecia:3", "Samochod", "Uzytkownik:nick:kamil"));
//foreach($rows as $row) print_r($row);

//echo "-- 1: ".sizeof(szukaj2(array("Marka", "Samochod:ID_samochodu:5", "Uzytkownik:nick:kamil"), "oceny_pozytywne ASC"))."\n";

/*echo "-- 1: ".sizeof(szukaj("Samochod", "Marka", "nazwa", "Fiat", "oceny_pozytywne ASC"))."\n";
echo "-- 2: ".sizeof(szukaj("Samochod", null, "ID_marki", "1", "oceny_pozytywne ASC"))."\n";
echo "-- 3: ".sizeof(szukaj("Samochod", "Uzytkownik", "ID_uzytkownika", "19", "oceny_pozytywne ASC"))."\n";
echo "-- 4: ".sizeof(szukaj("Samochod", "Uzytkownik", "nick", "kamil", "oceny_pozytywne ASC"))."\n";
echo "-- 4: ".sizeof(szukaj("Samochod", "Uzytkownik", "nick", "kosiak", "oceny_pozytywne ASC"))."\n";
echo "-- 4: ".sizeof(szukaj("Samochod", "Uzytkownik", "nick", "kosiak", "oceny_pozytywne ASC"))."\n";
echo "-- 4: ".sizeof(szukaj("Komentarz", "Uzytkownik", "nick", "kamil", "oceny_pozytywne ASC"))."\n";
echo "-- 4: ".sizeof(szukaj("Komentarz", "Samochod", "ID_uzytkownika", "19", "oceny_pozytywne ASC"))."\n";
echo "-- 4: ".sizeof(szukaj("Uzytkownik"))."\n";*/


?>