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
        <h1>jestem tryAddWersja.php</h1>
        
        <?php // Kamil Cukrowski

function fatal($str) {
	echo $str.'</br>';
	exit(-1);
}
if(!isset($_POST['Model_nazwa'])) {
	fatal("nie podales nazwy modelu");
}
if(!isset($_POST['Wersja_nazwa'])) {
	fatal("nie podales przebieg");
}

// ID_model rozpoznajemy po nazwie modelu
$ID_modelu=db::queryone("select * from Model where nazwa = '".
		db::escape($_POST['Model_nazwa'])."';")['ID_modelu'];
// dodajemy
$ret = $user->actionDodaj("Wersja", array(
		"ID_modelu" => $ID_modelu,
		"nazwa" => $_POST['Wersja_nazwa'],
));
if ( $ret ) {
	echo 'Udalo sie!<br>';
} else {
	echo 'Nie udalo sie!<br>';
}
// i tyle
		?>

		<?php

				echo "Za chwile nastapi przekierowanie...";
				echo "<script type='text/javascript'>
					setTimeout(function()
					{
						window.parent.location.reload()
					}, 2000);</script>";
			
		?>

    </body>
</html>

