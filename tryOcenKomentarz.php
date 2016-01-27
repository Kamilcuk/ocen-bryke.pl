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
if(!isset($_GET['ocena'])) {
	fatal('nie podales oceny');
}
if( !is_numeric($_GET['ocena'])) {
	fatal('ocena nie liczba');
}
switch($_GET['tabela']) {
	case 'Komentarz':
		$tmp = db::query("select * from Ocena_komentarza where ID_uzytkownika = ".$user->getID().
				' AND ID_komentarza = '.$id);
		if ( count($tmp) == 0 ) {
			// dodajemy ocene komentarza
			$ret = $user->actionDodaj('Ocena_komentarza', array(
					'ID_komentarza' => $id,
					'wartosc' => $_GET['ocena'],
			));
		} else {
			// edytujemy ocene komentarza
			$ret = db::query("UPDATE Ocena_komentarza SET wartosc = ".$_GET['ocena'].
					" where ID_oceny_komentarza = '".$tmp[0]['ID_oceny_komentarza']."' ");
		}
		break;
	case 'Samochod':
		$tmp = db::query("select * from Ocena_samochodu where ID_uzytkownika = ".$user->getID().
				' AND ID_samochodu = '.$id);
		if ( count($tmp) == 0 ) {
			// dodajemy ocene komentarza
			$ret = $user->actionDodaj('Ocena_samochodu', array(
					'ID_samochodu' => $id,
					'wartosc' => $_GET['ocena'],
			));
		} else {
			// edytujemy ocene komentarza
			$ret = db::query("UPDATE Ocena_samochodu SET wartosc = ".$_GET['ocena'].
					" where ID_oceny_samochodu = '".$tmp[0]['ID_oceny_samochodu']."' ");
		}
		break;
}		
if ( $ret ) {
	echo 'Udalo sie ocenic '.$_GET['tabela'].'<br>';
	przekierowanie(500);
} else { 
	echo 'Nie udalo sie ocenic '.$_GET['tabela'].'<br>';
	przekierowanie(20000);
}
		?>
    </body>
</html>

