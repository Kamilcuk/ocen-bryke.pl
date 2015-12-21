<?php
	require_once('user.inc');
	session_start();
?>
<html>
    <head>
        <title>Oce&#324;-bryke.pl</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
    </hed>
    <body class='frame'>
        <h1>jestem tryRegister.php</h1>

		<?php
			if(isset($_POST['name']))
			{
				$name = htmlspecialchars($_POST['name']);
				$email = htmlspecialchars($_POST['email']);
				$pass = htmlspecialchars($_POST['pass']);
				$passRepeat = htmlspecialchars($_POST['passR']);

				$user = new user();

				if($pass != $passRepeat)
				{
					echo "<div class= 'error'> Podane hasla sie nie zgadzaja!!!<br></div>";
				}
				else
				{
					if($user->zarejestruj($name, $pass, $email))
					{
						echo "<div class= 'ok'>Rejestracja udana.<br></div>";
					}
					else
					{
						echo "<div class= 'error'>Rejestracja nieudana. Nick zajety.<br></div>";
					}
				}

				echo "Za chwile nastapi przekierowanie...";
				echo "<script type='text/javascript'>
					setTimeout(function()
					{
						window.parent.location.reload()
					}, 2000);</script>";
			}
		?>

    </body>
</html>

