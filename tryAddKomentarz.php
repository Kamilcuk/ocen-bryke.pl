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
        <h1>jestem tryAddKomentarz.php</h1>
        
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
} else {
	echo 'Nie udalo sie!<br>';
}
			echo "Za chwile nastapi przekierowanie...<script type='text/javascript'>
	setTimeout(function() {
		window.parent.location.href = window.parent.location.href;
	}, 1000);</script>";
		?>
    </body>
</html>

