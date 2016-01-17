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
        <h1>jestem logout.php</h1>

		<?php
			if(isset($_SESSION["user"]))
			{
				$user = $_SESSION["user"];
				if($user->zalogowany) $user->wyloguj();
			}

			session_unset();
			session_destroy();

			echo "Zostales wylogowany.<br>Za chwile nastapi przekierowanie...";

            echo "<script type='text/javascript'>
            	setTimeout(function()
                {
                   window.parent.location.href = window.parent.location.href;
                }, 2000);</script>";
		?>
	</body>
</html>
