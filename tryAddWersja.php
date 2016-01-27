<?php
	require_once('user.inc');
	session_start();
?>
<html>
	<?php require_once('verify.inc'); ?>
    <head>
        <title>Oce&#324;-bryke.pl</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
    </head>
    <body class='frame'>
<br>
        
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
// dodajemy
$ret = $user->actionDodaj("Wersja", array(
		"ID_modelu" => $_POST['Model_nazwa'],
		"nazwa" => $_POST['Wersja_nazwa'],
));
if ( $ret ) {
	echo 'Udalo sie!<br>';
	przekierowanie(500);
} else {
	echo 'Nie udalo sie!<br>';
	przekierowanie(3000);
}
		?>

    </body>
</html>

