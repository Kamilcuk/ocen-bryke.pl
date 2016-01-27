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
if(!isset($_POST['Marka_nazwa'])) {
	fatal("nie podales Marka_nazwa");
}
$ret = $user->actionDodaj("Marka", array(
		"nazwa" => $_POST['Marka_nazwa'],
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

