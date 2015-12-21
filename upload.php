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
        <h1>jestem upload.php</h1>
		
		<form action="/tryUpload.php" method="post" enctype="multipart/form-data">
		zdjecie: <input type="file" name="uploadedFile" id="uploadedFile"><br>
		ID_samochodu: <input type="number" name="ID_samochodu" id="ID_samochodu"><br>
		<input type="submit" name="submit" value="Wrzuc fotke"><br>
		</form>

	</body>
</html>
