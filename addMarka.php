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
		<h1>jestem addMarka.php</h1>
		
		 <form action="/tryAddMarka.php" method="post">
		<table>
			<label for="inp">Nazwa nowej marki:</label>   <input type="text" name="Marka_nazwa"><br>
			<input type="submit">
		</form>
	</body>
</html>
