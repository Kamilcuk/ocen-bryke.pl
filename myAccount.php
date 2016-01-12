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
	<?php /* Kamil */ $info=$user->getInfo(); ?>
		<body class='frame'>
		<h1>jestem myAccount.php</h1>
		 <div class='Login'>
			<form action="tryEditAccount.php" method="post">
			<label for="inp">Nazwa użytkownika:</label>
				<input type="text" placeholder="<?php echo $info["nick"]?>" readonly><br>
			<label for="inp">e-mail:</label>
				<input type="e-mail" name="Uzytkownik_e_mail" placeholder="<?php echo $info["e-mail"]?>"><br>
			<label for="inp">wiek:</label>
				<input type="number" name="Uzytkownik_wiek" placeholder="<?php echo $info['wiek']?>"><br>
			<label for="inp">Ranga:</label>
				<input type="number" placeholder="<?php echo $info['ranga']?>" readonly><br>
			<label for="inp">Admin:</label>
				<input type="number" placeholder="<?php echo $info['admin']?>" readonly><br>
			<input type="submit" value="Wprowadź zmiany">
			</form>
		 </div>
	</body>
</html>
