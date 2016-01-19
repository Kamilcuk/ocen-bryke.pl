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
		<h1>jestem test.php</h1>
		<form action="/test2.php?proste=1" method="post">
			Wyszukaj we wszystkich polach:<br>
			Wpisz słowo lub frazę: <input type='text' name='pole'><br>
			<input type="submit"> <BR>
		</form><BR>
		<form action="/test2.php?proste=0" method="post">
			Wpisz słowo lub frazę: <input type='text' name='pole'><br>
			<input type="submit"> <BR>
		</form><BR>
	</body>
</html>
