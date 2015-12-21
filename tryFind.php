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
        <h1>jestem tryFind.php</h1>

		<?php

				echo "Za chwile nastapi przekierowanie...";
				echo "<script type='text/javascript'>
					setTimeout(function()
					{
						window.parent.location.reload()
					}, 2000);</script>";
			
		?>

    </body>
</html>

