<?php
	require_once('user.inc');
	session_start();
?>
<html>
	<?php require_once('verify.inc') ?>
	<head>
        <title>Oce&#324;-bryke.pl</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
	</hed>
	<body class='frame'>
        <h1>jestem addZdjecie.php</h1>
		
		<form action="/tryAddZdjecie.php" method="post" enctype="multipart/form-data">
		<?php // Kamil ID_samochodu dostajemy w poscie ?>
		<input type="hidden" name="ID_samochodu" value="<?php echo $_GET['ID_samochodu']?>"><br>
		Plik ze zdjęciem: <input type="file" name="uploadedFile"><br>
		Opis do zdjecia: <input type="text" name="Zdjecie_opis"><br>
		
		<input type="submit" name="submit" value="Wrzuc fotke"><br>
		</form>

	</body>
</html>
