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
		<?php
		// Kamil Cukrowski, poprzedni plik jest w kamil/test/tryUpload.php <- ta linia do wykasowania jest
		function fatal($str) {
			echo $str.'<br>';
			przekierowanie(20000);
			exit(-1);
		}
		$ret = false;
		if ( !isset($_GET['typ']) ) {
			fatal("Blad wykonywania skryptu : {$_GET['typ']}");
		}
		switch($_GET['typ']) {
		case "edituzytkownika":
			if ( !isset($_POST["Uzytkownik_e_mail"]) ) {
				fatal('Nie podano Uzytkownik_e_mail');
			}
			if ( !preg_match("/@/", $_POST["Uzytkownik_e_mail"])) {
				echo 'Nieprawidlowy adres email<br>';
				przekierowanie(20000);
				exit(0);
			}
			if ( !isset($_POST['Uzytkownik_haslo'])) {
				fatal('Nie wprowazdiles pierwszego hasla.');
			}
			if ( !$user->sprawdzHaslo($user->nick, $_POST['Uzytkownik_haslo']) ) {
				fatal('Wprowadzone hasło jest nieprawidłowe.');
			}
			$ret = db::query("UPDATE Uzytkownik ".
					" set `e-mail` = '".db::escape($_POST["Uzytkownik_e_mail"])."'".
					" where ID_uzytkownika = '".$user->getID()."'");
			if ( $ret ) {
				echo "Udalo sie!";
			} else {
				fatal('Nie udalo sie!');
			}
			break;
		case "zmienhaslo":
			if ( !isset($_POST['Uzytkownik_haslo1'])) {
				fatal('Nie wprowazdiles 1 hasla.');
			}
			if ( !isset($_POST['Uzytkownik_haslo2'])) {
				fatal('Nie wprowazdiles 2 hasla.');
			}
			if ( !isset($_POST['Uzytkownik_haslo3'])) {
				fatal('Nie wprowazdiles 3 hasla.');
			}
			if ( $_POST['Uzytkownik_haslo3'] != $_POST['Uzytkownik_haslo2'] ) {
				fatal('Wprowadzone nowe hasla różnią się');
			}
			if ( !$user->sprawdzHaslo($user->nick, $_POST['Uzytkownik_haslo1']) ) {
				fatal('Wprowadzone hasło jest nieprawidłowe.');
			}
			$nowehaslo = $_POST['Uzytkownik_haslo3'];
			$starehaslo = $_POST['Uzytkownik_haslo1'];
			$ret = $user->edytujHaslo($nowehaslo,$starehaslo);
			break;
		case "dajadmina":
			if ( !$user->czyAdmin() ) {
				fatal('nie jestes adminem! <BR>');
			}
			if ( !isset($_GET['ID_uzytkownika'])) {
				fatal("nie podales id <BR>");
			}
			$ret = db::query('update Uzytkownik set admin = 1 where ID_uzytkownika = '.$_GET['ID_uzytkownika']);
			break;
		case "odbierzadmina":
			if ( !$user->czyAdmin() ) {
				fatal('nie jestes adminem! <BR>');
			}
			if ( !isset($_GET['ID_uzytkownika'])) {
				fatal("nie podales id <BR>");
			}
			$ret = db::query('update Uzytkownik set admin = 0 where ID_uzytkownika = '.$_GET['ID_uzytkownika']);
			break;
		}
		if ( $ret ) {
			echo 'Udalo sie! <BR>';
			przekierowanie(500);
		} else {
			przekierowanie(20000);
		}
		?>
    </body>
</html>

	



