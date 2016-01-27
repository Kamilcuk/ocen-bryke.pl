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
			if(isset($_POST['name']))
			{
				$name = htmlspecialchars($_POST['name']);
				$pass = htmlspecialchars($_POST['pass']);

				$user = new user();

				if($user->zaloguj($name, $pass))
				{
					echo "<div class= 'ok'>Logowanie udane. Witaj, $name <br></div>";
					$_SESSION['user'] = $user;
					przekierowanie(500);
				}
				else
				{
					echo "<div class= 'error'>Logowanie nie powiodlo sie.<br></div>";
					przekierowanie(20000);
				}
			}
		?>

    </body>
</html>

