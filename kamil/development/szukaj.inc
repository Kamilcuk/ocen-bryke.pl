<?php
require_once('db.inc');
function szukaj(array $args = array(), $sortuj=null) {
	$query = null;
	$where = null;
	$lastTable = null;
	foreach($args as $arg) {
		$pieces = explode(':', $arg);
		$thisTable = $pieces[0];

		$idColumn = (new db())->getFirstColumnName($thisTable);
		if ( $query == null ) {
			$query = "select ".$thisTable.".* from ".$thisTable;
		} else {
			$query = $query." INNER JOIN ".$thisTable.
			" ON `".$lastTable."`.`".$idColumn."` = `".$thisTable."`.`".$idColumn."` ";
		}
		
		array_shift($pieces);
		while ( sizeof($pieces) >= 2 ) {
			$addWhere = " `".$thisTable."`.`".$pieces[0]."` = '".$pieces[1]."' ";
			if ( $where != null ) {
				$where = $where." AND ".$addWhere;
			} else {
				$where = $addWhere;
			}
			array_shift($pieces);
			array_shift($pieces);
		}
		
		
		$lastTable = $thisTable;
	}
	if ( $where != null )
		$query = $query." where ".$where;
	if ( $sortuj != null )
		$sortuj = " ORDER BY ".$sortuj.' ';
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
/*
echo "-- 1: ".sizeof(szukaj(array("Samochod", "Marka:nazwa:Fiat"), "oceny_pozytywne ASC"))."\n";
echo "-- 2: ".sizeof(szukaj(array("Samochod:ID_marki:1"), "oceny_pozytywne ASC"))."\n";
echo "-- 3: ".sizeof(szukaj(array("Samochod", "Uzytkownik:ID_uzytkownika:19"), "oceny_pozytywne ASC"))."\n";
echo "-- 4: ".sizeof(szukaj(array("Samochod", "Uzytkownik:nick:kamil"), "oceny_pozytywne ASC"))."\n";
echo "-- 5: ".sizeof(szukaj(array("Samochod", "Uzytkownik:nick:kosiak"), "oceny_pozytywne ASC"))."\n";
echo "-- 6: ".sizeof(szukaj(array("Uzytkownik")))."\n";
echo "-- 7: ".sizeof(szukaj(array("Komentarz:ID_uzytkownika:27", "Zdjecie", "Samochod", "Uzytkownik:nick:kamil")))."\n";
*/
?>