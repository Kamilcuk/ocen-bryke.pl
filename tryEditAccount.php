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
        <h1>jestem tryAddZdjecie.php</h1>
		<?php
			// Kamil Cukrowski, poprzedni plik jest w kamil/test/tryUpload.php <- ta linia do wykasowania jest
			function fatal($str) {
				echo $str.'<br>';
				exit -1;
			}
			if ( !isset($_POST["Uzytkownik_e_mail"]) ) {
				fatal('Nie podano Uzytkownik_e_mail');
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
				echo "Nie udalo sie!";
			}
		?>
    </body>
</html>

	



