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
	<?php
		if(isset($_SESSION["user"]))
		{
		   $user = $_SESSION["user"];
		   $info=$user->getInfo();
		   $string=implode(' ',$info); 
		   $nick=$info["nick"];
		   $email=$info["e-mail"];
		   
		   //$wiek=$info[""];
		   
		}
		?>
		<body class='frame'>
		<h1>jestem myAccount.php</h1>
		 <div class='Login'>
			<form action="coś do zmiany.php" method="userData">
			<label for="inp">Nazwa użytkownika:</label><input type="text" name = "newNick" placeholder= <?php echo $nick?>><br>
			<label for="inp">e-mail:</label><input type="text" name = "newEmail" placeholder=<?php echo $email?>><br>
			<label for="inp">wiek:</label><input type="text" name = "newAge" placeholder="18"><br>
			<label for="inp">ranga ?:</label><br> 
			<input type="submit" value="Wprowadź zmiany">
			<a class='link' target='content_iframe' 
				href='addCar.php' onClick="resizeUpdate()">
				Dodaj brykę
			</a>
		
		 </div>
		
	</body>
</html>
