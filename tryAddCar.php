<?php
	require_once('user.inc');
	session_start();
?>
<html>
	<?php require_once('verify.inc'); ?>
    <head>
        <title>Oce&#324;-bryke.pl</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
    </hed>
    <body class='frame'>
        <h1>jestem tryAddCar.php</h1>
        
        <?php // Kamil Cukrowski

function fatal($str) {
	echo $str.'</br>';
	exit(-1);
}
if(!isset($_POST['Model_nazwa'])) {
	fatal("nie podales nazwy modelu");
}
if(!isset($_POST['Wersja_nazwa'])) {
	fatal("nie podales Wersja_nazwa");
}
if(!isset($_POST['Silnik_symbol'])) {
	fatal("nie podales Silnik_symbol");
}
if(!isset($_POST['Marka_nazwa'])) {
	fatal("nie podales Marka_nazwa");
}
if(!isset($_POST['rok_produkcji'])) {
	fatal("nie podales rok_produkcji");
}
if(!isset($_POST['przebieg'])) {
	fatal("nie podales przebieg");
}

/*
// ID_model rozpoznajemy po nazwie modelu
$ID_modelu=db::queryone("select * from Model where nazwa = '".
		db::escape($_POST['Model_nazwa'])."';")['ID_modelu'];
// ID_wersji rozpoznajemy po nazwie wersji
$ID_wersji=db::queryone("select * from Wersja where nazwa = '".
		db::escape($_POST['Wersja_nazwa'])."';")['ID_wersji'];
// silnik rozpoznajemy po symbolu
$ID_silnika=db::queryone("select * from Silnik where symbol = '".
		db::escape($_POST['Silnik_symbol'])."';")['ID_silnika'];
// marke rozpoznajemy 
$ID_marki=db::queryone("select * from Marka where nazwa = '".
		db::escape($_POST['Marka_nazwa'])."';")['ID_marki'];
// dodajemy
$ret = $user->actionDodaj("Samochod", array(
		"ID_modelu" => $ID_modelu,
		"ID_wersji" => $ID_wersji,
		"ID_silnika" => $ID_silnika,
		"ID_marki" => $ID_marki,
		"rok_produkcji" => $_POST['rok_produkcji'],
		"przebieg" => $_POST['przebieg'],
));
*/

// dodajemy
$ret = $user->actionDodaj("Samochod", array(
		"ID_modelu" => $_POST['Model_nazwa'],
		"ID_wersji" => $_POST['Wersja_nazwa'],
		"ID_silnika" => $_POST['Silnik_symbol'],
		"ID_marki" =>$_POST['Marka_nazwa'],
		"rok_produkcji" => $_POST['rok_produkcji'],
		"przebieg" => $_POST['przebieg'],
));

if ( $ret ) {
	echo 'Udalo sie!<br>';
	$timeout=2000;
} else {
	echo 'Nie udalo sie!<br>';
	$timeout=20000;
}

echo "Za chwile nastapi przekierowanie...<script type='text/javascript'>
	setTimeout(function() {
		window.parent.location.href = window.parent.location.href;
	}, ".$timeout.");</script>";
?>

    </body>
</html>

