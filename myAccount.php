<?php
	require_once('user.inc');
    session_start();
?>
<html>
	<?php require_once('verify_try.inc'); ?>
	<head>
        <title>Oce&#324;-bryke.pl</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
	</head>
		<body class='frame'>
<br>
		 <div class='Login'>
		<?php /* Kamil */
		if ( isset($_GET['ID_uzytkownika']) ) {
			$info = db::query('select * from Uzytkownik where ID_uzytkownika = "'.
					db::escape($_GET['ID_uzytkownika']).'";');
			if ( count($info) == 0 ) {
				echo 'Nie ma takiego uzytkownika <BR></div></body></html>';
				exit(0);
			}
			$info = $info[0];
		} else {
			if ( $user != null ) {
				$info = $user->getInfo();
			}
		}
		if ( !isset($info) || $info == null ) {
			echo 'Blad w wykorzystaniu skryptu <BR>';
			exit(0);
		}	
		/* 4 przyapdki
		 * 1. gość -> nie może niczego edytować
		 * 2. użytkownik lub admin i jego konto -> może edytować swoje dane i usuwać konto
		 * 3. użytkownik i nie swoje konto -> nie może niczego edytować
		 * 4. admin -> nie może edytować danych i może usuwać każde konto
		 */
		if ( $user == null ) {
			$edit = false;
			$usun = false;
		} else if ( $user->getId() == $info['ID_uzytkownika'] ) {
			$edit = true;
			$usun = true;
		} else if ( $user->czyAdmin() ) {
			$edit = false;
			$usun = true;
		} else {
			$edit = false;
			$usun = false;
		}
	?>
		
			<form action="tryEditAccount.php?typ=edituzytkownika" method="post">
			<table><tr><td>
					<label for="inp">Nazwa użytkownika:</label>
				</td><td>
					<input type="text" name="name" value="<?php echo $info["nick"]?>" readonly>
				</td></tr>
				<tr><td>
			<?php if ( $usun ) { ?>
				<tr><td>
					<label for="inp">e-mail:</label>
				</td><td>
					<input type="e-mail" name="Uzytkownik_e_mail" placeholder="<?php echo $info["e-mail"]?>" 
					<?php  if ( !$edit ){ echo 'readonly'; }?> >
				</td></tr>
			<?php } ?>
				<tr><td>
					<label for="inp">Admin:</label>
				</td><td>
					<input type="text" placeholder="<?php if ( $info['admin'] ) { echo "Tak"; } else { echo "Nie"; } ?>" readonly>
				</td></tr>	
			<?php if ( $edit ) { ?>
				<tr><td>
					<label for="inp">Wprowadz hasło:</label>
				</td><td>
					<input type="password" name="Uzytkownik_haslo" >
				</td></tr><tr><td>
					<input type="submit" value="Wprowadź zmiany">
			<?php } ?>
			</td></tr></table>
			</form>
			
			<BR>
			<?php if ( $edit ) { ?>
			<form action="tryEditAccount.php?typ=zmienhaslo" method="post">
				<input type="hidden" name="name" value="<?php echo $info["nick"]?>" readonly>
			<table><tr><td>
					<label for="inp">Wprowadz stare hasło:</label>
				</td><td>
					<input type="password" name="Uzytkownik_haslo1" >
				</td></tr><tr><td>
					<label for="inp">Wprowadz nowe hasło:</label>
				</td><td>
					<input type="password" name="Uzytkownik_haslo2" >
				</td></tr><tr><td>
					<label for="inp">Nowe hasło ponownie:</label>
				</td><td>
					<input type="password" name="Uzytkownik_haslo3" >
				</td></tr><tr><td>
					<input type="submit" value="Zmien haslo">
			</td></tr></table>
			</form>
			<?php } ?>
			<BR>
			<?php if ($usun) { ?>
			<a href='tryUsunCokolwiek.php?tabela=uzytkownik&id=<?php echo $info['ID_uzytkownika']; ?>'>Usuń to konto!</a>
			<?php }?>
			<br>
			<?php if ( $user != null && $user->czyAdmin()) {
				if ( $info['admin'] == 0 ) {
					echo "<a href='tryEditAccount.php?typ=dajadmina&ID_uzytkownika={$info['ID_uzytkownika']}'; >Daj admina</a>";
				} else {
					echo "<a href='tryEditAccount.php?typ=odbierzadmina&ID_uzytkownika={$info['ID_uzytkownika']}'; >Odbierz admina</a>";
				}
			}?>
		 </div>
	</body>
</html>
