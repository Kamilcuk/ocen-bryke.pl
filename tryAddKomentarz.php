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
if(!isset($_GET['ID_zdjecia'])) {
	fatal("nie podales ID_zdjecia");
}
if(!isset($_POST['tresc'])) {
	fatal("nie podales tresc");
}

// dodajemy
$ret = $user->actionDodaj("Komentarz", array(
		"ID_zdjecia" => $_GET['ID_zdjecia'],
		"tresc" => $_POST['tresc'],
));
if ( $ret ) {
	echo 'Udalo sie!<br>';
	przekierowanie(100);
} else {
	echo 'Nie udalo sie!<br>';
	przekierowanie(20000);
}
		?>
    </body>
</html>

