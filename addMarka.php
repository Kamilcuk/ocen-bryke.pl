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
		
		 <form action="/tryAddMarka.php" method="post">
		<table>
			<tr><td>
				<label for="inp">Nazwa nowej marki:</label>
			</td><td>
				<input type="text" name="Marka_nazwa"><br>
			</td></tr><tr><td>
				<input type="submit" value='Dodaj marke'>
			</td></tr></table>
		</form>
	</body>
</html>
