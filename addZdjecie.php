<?php
	require_once('user.inc');
	session_start();
?>
<html>
	<?php require_once('verify.inc') ?>
	<head>
        <title>Oce&#324;-bryke.pl</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
	</head>
	<body class='frame'>
        <h1>jestem addZdjecie.php</h1>
        <?php if ( !isset($_GET['ID_samochodu']) ) {
        	echo '$_GET[ID_samochodu] jest niepodane!. <br>';
        	exit(0);
        }?>
		<h1>Dodajesz zdjęcie do samochodu poniżej:</h1><BR>
		
	<form class= 'Login' action="/tryAddZdjecie.php?ID_samochodu=<?php echo $_GET['ID_samochodu'];?>" method="post" enctype="multipart/form-data">
		<label for="inp">Plik ze zdjęciem:</label> <input type="file" name="uploadedFile">
		<label for="inp">Opis do zdjecia:</label> <input type="text" name="Zdjecie_opis">
		
		<input type="submit" name="submit" value="Wrzuc fotke"><br>
		</form>
		<BR>
		
		<?php // wyswietlamy informacje o tym samochodzie w ifram-ie ?>
		<article>
			<iframe id='content_iframe' name='content_iframe' 
				src='myCars.php?ID_samochodu=<?php echo $_GET['ID_samochodu'];?>' onLoad="resizeUpdate()"></iframe>
		</article>

	</body>
</html>
