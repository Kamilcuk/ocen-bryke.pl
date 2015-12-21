<?php
require_once('../szukaj.inc');
require_once('../debug.inc');
/**
 * szukaj( $array [, $sortuj] );
 * zmienna $array jest postaci:
 * 	$array=array(
 * 		"NAZWA_TABELI:[nazwa_kolumny_tej_tabeli:wartosc_tej_kolulmy][...]",
 * 		"NAZWA_KOLEJNEJ_TABELI:[nazwa_kolumny_tej_tabeli:wartosc_tej_kolulmy][...]",
 * 		[...]
 * 	)
 * zmienna sortuj jest postaci $sortuj="JAKAS_KOLUMNA_PIERWSZEJ_TABELI [,DESC,ASC]"
 */
// wyipsz wszystkie samochodu o marce fiat, posortuj ocenami pozytywnymi
echo "---------------- 1: <BR>";
$rows = szukaj(array("Samochod", "Marka:nazwa:Fiat"), "oceny_pozytywne");
print "<BR><pre>";print_r($rows);print "</pre><BR>";
// wypisz wszyskie samochodu o ID_marki = 1, posortuj ocenami pozytywnymi
echo "---------------- 2: <BR>";
$rows = szukaj(array("Samochod:ID_marki:1"), "oceny_pozytywne");
// można też zrobić w ten sposób: $rows = szukaj(array("Samochod", "Marka:ID_marki:1"), "oceny_pozytywne ASC"));
print "<BR><pre>";print_r($rows);print "</pre><BR>";
// wypisz wszystkie samochodu użytkonika o id 19, posortuj ID_markami od najmniejszego do największego
echo "---------------- 3: <BR>";
$rows = szukaj(array("Samochod", "Uzytkownik:ID_uzytkownika:19"), "ID_marki DESC");
print "<BR><pre>";print_r($rows);print "</pre><BR>";
// wypisz wszystkie samochody Kosiaka
echo "---------------- 4: <BR>";
$rows = szukaj(array("Samochod", "Uzytkownik:nick:kosiak"));
print "<BR><pre>";print_r($rows);print "</pre><BR>";
// wypisz wszytskie uzytkowników
echo "---------------- 5: <BR>";
$rows = szukaj(array("Uzytkownik"));
print "<BR><pre>";print_r($rows);print "</pre><BR>";
// wypisz komentarz użytkownika 27 do zdjęcia samochodu użytkonika o nicku Kamil
echo "---------------- 6: <BR>";
$rows = szukaj(array("Komentarz:ID_uzytkownika:27", "Zdjecie", "Samochod", "Uzytkownik:nick:kamil"));
print "<BR><pre>";print_r($rows);print "</pre><BR>";
// wypisz zdjęcia posortowane w kolejności od najnowszego do najstarszego
echo "---------------- 7: <BR>";
$rows = szukaj(array("Zdjecie"), "data_dodania");
print "<BR><pre>";print_r($rows);print "</pre><BR>";
// wypisz zdjęcia posortowane w kolejności od najstarszego 
echo "---------------- 8: <BR>";
$rows = szukaj(array("Zdjecie"), "data_dodania DESC");
print "<BR><pre>";print_r($rows);print "</pre><BR>";
// wypisz samochodu z uzytkownika o id 20 z 0 ocenami pozytywnymi
echo "---------------- 9: <BR>";
$rows = szukaj(array("Samochod:ID_uzytkownika:20:oceny_pozytywne:0"));
print "<BR><pre>";print_r($rows);print "</pre><BR>";

/*
 *  to poniżej to są różne stare testy
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
*/
?>