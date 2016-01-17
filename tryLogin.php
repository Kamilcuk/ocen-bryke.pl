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
        <h1>jestem tryLogin.php</h1>

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
				}
				else
				{
					echo "<div class= 'error'>Logowanie nie powiodlo sie.<br></div>";
				}

				echo "Za chwile nastapi przekierowanie...";	
				echo "<script type='text/javascript'>
						setTimeout(function(){
							window.parent.location.href = window.parent.location.href;
						}, 1000);</script>";
			}
		?>

    </body>
</html>

