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
			if(isset($_SESSION["user"]))
			{
				$user = $_SESSION["user"];
				if($user->zalogowany) $user->wyloguj();
			}

			session_unset();
			session_destroy();

			echo "Zostales wylogowany.<br>";
        	przekierowanie(500);
		?>
	</body>
</html>
