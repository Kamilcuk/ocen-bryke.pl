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
//db::setDebug(10); echo $_GET['tabela'].'<BR>'.$_GET['id'].'<BR>';

$ret = false;
function fatal($str) {
	echo $str.'</br>';
	exit(-1);
}
if(!isset($_GET['tabela'])) {
	fatal("nie podales Co_usuwamy");
}
if(!isset($_GET['id'])) {
	fatal("nie podales ID_do_usuniecia");
}
$id = $_GET['id'];
if( !is_numeric($id) ) {
	fatal("ID_do_usuniecia to nie numer");
}

/// BOOM!
$ret = $user->actionUsun($_GET['tabela'], $id);

if ( $ret ) {
	echo "Udalo sie usunać.<br>";
	przekierowanie(100);
} else { 
	echo "Nie udalo sie usunać.<br>";
	przekierowanie(20000);
}
		?>

    </body>
</html>

