<?php
	require_once('user.inc');
	session_start();
?>
<html>
    <head>
        <title>Oce&#324;-bryke.pl</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
    </head>
    <body class='frame'>
<br>

		<?php
			//db::setDebug(10);
			if(isset($_POST['name'])) {
				
				$name = htmlspecialchars($_POST['name']);
				$email = htmlspecialchars($_POST['email']);
				$pass = htmlspecialchars($_POST['pass']);
				$passRepeat = htmlspecialchars($_POST['passR']);
				if ( !preg_match("/@/", $email)) {
					echo 'Nieprawidlowy adres email<br>';
					przekierowanie(20000);
					exit(0);
				}

				$user = new user();

				if($pass != $passRepeat) {
					echo "<div class='error'>Podane hasla sie nie zgadzaja!!!<br></div>";
				} else {
					$ret = $user->zarejestruj($name, $pass, $email);
					if ( is_numeric($ret) && $ret == -1 ) {
						echo "<div class= 'error'>Rejestracja nieudana.<br>Istnieje uzytkownik o takim nicku.<BR></div>";
						przekierowanie(20000);
					} else if ( is_numeric($ret) && $ret == -2 ) {
						echo "<div class= 'error'>Rejestracja nieudana.<br>Podany adres email jest juz zarejestrowany<BR></div>";
						przekierowanie(20000);
					} else if ( $ret == false ) {
						echo "<div class= 'error'>Rejestracja nieudana.<br></div>";
						przekierowanie(20000);
					} else {
						echo "<div class= 'ok'>Rejestracja udana.<br></div>";
						przekierowanie(5000);
					}
				}
			}
		?>

    </body>
</html>

