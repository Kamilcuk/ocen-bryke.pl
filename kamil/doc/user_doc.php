<?php
require_once('../user.inc');
require_once('../szukaj.inc');
require_once('../debug.inc');

$ID_zdjecia = 32;

// logujemy użytkonika dupa
echo " -------------------------------  1 <BR>";
$user = new user("dupa", "dupa");
$ret = $user->getInfo();
print "<BR><pre>";print_r($ret);print "</pre><BR>";

// dodajemy komentarz do zdjęcie o id 2 , komnatarz o treści "dupa"
echo " ------------------------------- 2 <BR>";
$user->actionDodaj("Komentarz", array("ID_zdjecia" => $ID_zdjecia, "tresc" => "dupa"));

// dodajemy samochód o parametrach poniżej
echo " ------------------------------- 3 <BR>";
$user->actionDodaj("Samochod", array(
		"ID_modelu" => 1,
		"ID_wersji" => 1,
		"ID_silnika" => 1,
		"ID_marki" => 1,
		"rok_produkcji" => 1999,
		"przebieg" => "15"
));

// dodajemy kolejjny samochód, o innym silniku
echo " ------------------------------- 4 <BR>";
$user->actionDodaj("Samochod", array(
		"ID_modelu" => 1,
		"ID_wersji" => 1,
		"ID_silnika" => 2,
		"ID_marki" => 1,
		"rok_produkcji" => 1999,
		"przebieg" => "15"
));

// znajdujemy samochódy naszego użytkonika
echo " ------------------------------- 5 <BR>";
$rows = szukaj(array("Samochod:ID_uzytkownika:".$user->getId()));
print "<BR><pre>";print_r($rows);print "</pre><BR>";

// usuwamy wszystkie jego samochody, a jak!
echo " ------------------------------- 6 <BR>";
foreach($rows as $row ) {
	echo __FILE__.__LINE__.': user->actionusun("samochod", '.$row["ID_samochodu"].'); <BR>';
	$user->actionUsun("Samochod", $row["ID_samochodu"]);
}

// znajdujemy komentarze naszego użytkonika dotyczący zdjęcia numer 2
echo " ------------------------------- <BR>";
$rows = szukaj(array("Komentarz:ID_zdjecia:".$ID_zdjecia.":ID_uzytkownika:".$user->getId() ));
print "<BR><pre>";print_r($rows);print "</pre><BR>";

// usuwamy te komentarze (jest(powinnien być) tylko jeden, ale pętla się wykonuje)
echo " ------------------------------- 7 <BR>";
foreach($rows as $row ) {
	echo __FILE__.__LINE__.': user->actionusun("Komentarz", '.$row["ID_komentarza"].'); <BR>';
	$user->actionUsun("Komentarz", $row["ID_komentarza"]);
} 

echo " ------------------------------- 8 <BR>";
$user= new user("kamil", "kamil");
// zmien opis do mojego zdjęcia
$user->actionEdytuj("Zdjecie", $ID_zdjecia, array("opis" => "dupa dupa dupa"));

?>