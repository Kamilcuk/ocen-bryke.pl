<?php
	require_once('user.inc');
    session_start();
?>
<html>
	<?php require_once('verify.inc'); ?>
	<head>
        <title>Oce&#324;-bryke.pl</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
	</hed>
	<body class='frame'>
		<h1>jestem myCars.php</h1>

		<a href="upload.php">Dodaj fotke (TEST UPLOADU, NORMALNIE FOTKI CHCEMY DODAWAC DO SAMOCHODOW!)</a>
		<a class='link' target='content_iframe' 
				href='addCar.php' onClick="resizeUpdate()">
				Dodaj brykę
			</a>
		<div class='Labels'>
			<label for="inp">Marka:</label>
			<label for="inp">Model:</label>
			<label for="inp">Typ nadwozia:</label>
			<label for="inp">Silnik:</label>
			<label for="inp">Pojemność:</label>
			<label for="inp">Zasilanie:</label>
			<label for="inp">Moc:</label>
			<label for="inp">Symbol:</label>	
		 </div>
		 
		 <div class='Labels'>
			<ul>
			<li>dupa</li>
			<li>dupa</li>
			<li>dupa</li>
			<li>dane:</li>
			<li>dupa</li>
			<li>dupa</li>
			<li>dupa</li>
			<li>dupa</li>
		 </ul>
		 </div>
	</body>
</html>
