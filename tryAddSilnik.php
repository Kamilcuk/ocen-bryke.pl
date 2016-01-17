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
        <h1>jestem tryAddSilnik.php</h1>
        
        <?php // Kamil Cukrowski

function fatal($str) {
	echo $str.'</br>';
	exit(-1);
}
if(!isset($_POST['Silnik_symbol'])) {
	fatal("nie podales Silnik_symbol");
}
if(!isset($_POST['Silnik_pojemnosc'])) {
	fatal("nie podales Silnik_pojemnosc");
}
if(!isset($_POST['Silnik_zasilanie'])) {
	fatal("nie podales Silnik_zasilanie");
}
if(!isset($_POST['Silnik_moc'])) {
	fatal("nie podales Silnik_moc");
}
// dodajemy
$ret = $user->actionDodaj("Silnik", array(
		"symbol" => $_POST['Silnik_symbol'],
		"pojemnosc" => $_POST['Silnik_pojemnosc'],
		"zasilanie" => $_POST['Silnik_zasilanie'],
		"moc" => $_POST['Silnik_moc'],
));
if ( $ret ) {
	echo 'Udalo sie!<br>';
} else {
	echo 'Nie udalo sie!<br>';
}

			
			echo "Za chwile nastapi przekierowanie...<script type='text/javascript'>
	setTimeout(function() {
		window.parent.location.href = window.parent.location.href;
	}, 500);</script>";
		?>

    </body>
</html>

