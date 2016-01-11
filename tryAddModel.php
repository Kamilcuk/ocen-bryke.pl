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
if(!isset($_POST['Marka_nazwa'])) {
	fatal("nie podales Marka_nazwa");
}
if(!isset($_POST['Silnik_symbol'])) {
	fatal("nie podales Silnik_symbol");
}
// silnik rozpoznajemy po symbolu
$ID_silnika=db::queryone("select * from Silnik where symbol = '".
		db::escape($_POST['Silnik_symbol'])."';")['ID_silnika'];
// marke rozpoznajemy 
$ID_marki=db::queryone("select * from Marka where nazwa = '".
		db::escape($_POST['Marka_nazwa'])."';")['ID_marki'];
// dodajemy
$ret = $user->actionDodaj("Model", array(
		"ID_marki" => $ID_marki,
		"ID_silnika" => $ID_silnika,
		"nazwa" => $_POST['Model_nazwa'],
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

