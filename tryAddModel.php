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
	przekierowanie(20000);
	exit(-1);
}
if( !isset($_POST['ID_marki']) || !isset($_POST['Model_nazwa']) ) {
	fatal("nie podales Silnik_symbol");
}
// dodajemy
$ret = $user->actionDodaj("Model", array(
		"ID_marki" => $_POST['ID_marki'],
		"nazwa" => $_POST['Model_nazwa'],
));
if ( $ret ) {
	echo 'Udalo sie!<br>';
	przekierowanie(500);
} else {
	echo 'Nie udalo sie!<br>';
}
		?>

    </body>
</html>

