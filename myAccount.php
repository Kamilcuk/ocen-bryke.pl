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
		<h1>jestem myAccount.php</h1>
		 <div class='Login'>
	<?php /* Kamil */
		//db::setDebug(10); 
		if ( isset($_GET['ID_uzytkownika']) ) {
			$info = db::query('select * from Uzytkownik where ID_uzytkownika = "'.
					db::escape($_GET['ID_uzytkownika']).'";');
			if ( count($info) == 0 ) {
				echo 'Nie ma takiego uzytkownika <BR></div></body></html>';
				exit(0);
			}
			$info = $info[0];
		} else {
			$info = $user->getInfo();
		}
		
		// edit jest prawda jesli jestesmy wlascicielem danych
		$edit = ( $user->getId() == $info['ID_uzytkownika'] );
	?>
	
			<form action="tryEditAccount.php" method="post">
			<label for="inp">Nazwa użytkownika:</label>
				<input type="text" placeholder="<?php echo $info["nick"]?>" readonly><br>
			<label for="inp">e-mail:</label>
				<input type="e-mail" name="Uzytkownik_e_mail" placeholder="<?php echo $info["e-mail"]?>" 
					<?php if ( !$edit ) { echo 'readonly'; } ?> ><br>
			<label for="inp">Admin:</label>
				<input type="number" placeholder="<?php echo $info['admin']?>" readonly><br>
				
			<?php if ( $edit ) { ?>
			<label for="inp">Wprowadz hasło:</label>
				<input type="text" name="Uzytkownik_haslo" ><br>
			<input type="submit" value="Wprowadź zmiany">
			</form>
			<?php } ?>
			
		 </div>
	</body>
</html>
