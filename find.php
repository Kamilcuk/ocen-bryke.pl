<?php
	require_once('user.inc');
    session_start();
?>
<html>
	<head>
        <title>Oce&#324;-bryke.pl</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
	</head>
	<body class='frame'>
<br>
		<form action="/tryFind.php" method="post">
		
		<table>
		 	Wyszukaj użytkownika:<BR>
			<tr><td><label for="inp">Nick użytkownika zawiera:</label></td>
			<td> <input type="text" name="nick"><br></td></tr>
			<input type='hidden' name='rodzaj' value='Uzytkownik'>
			<tr><td><input type="submit" value="Szukaj uzytkownika"></td></tr>
		</table>
		</form>
		<?php //nie usuwaj tutaj form, bo nie bedzie szukajka dzialac, to na gorze jest do uzytkownika, a na dole jest do samochodu ?>
		<form action="/tryFind.php" method="post">
		<BR><BR>
		<table>
			Wyszukaj samochów:<BR>
			
			<tr><td><label for="inp">użytkownika:</label></td>
			<td><select class='findphpselect' name='ID_uzytkownika'>
				<option selected="selected" value='-1'>dowolnego</option>
				<?php $rows = db::query('select * from Uzytkownik ORDER BY nick;');
					foreach($rows as $row) {
					echo "<option value='".$row['ID_uzytkownika']."' >".$row['nick']."</option>"."\n";
				} ?>
			</select></td></tr>
			
			<tr><td><label for="inp">marki:</label></td>
			<td><select class='findphpselect' name="Marka_nazwa">
				<option selected="selected" value='-1'>dowolnej</option>
				<?php $rows = db::query('select * from Marka ORDER BY nazwa;');
					foreach($rows as $row) {
					echo "<option >".$row['nazwa']."</option>"."\n";
				} ?>
			</select></td></tr>
			
		 	<tr><td><label for="inp">modelu:</label></td>
			<td><select class='findphpselect' name="ID_modelu">
				<option selected="selected" value='-1'>dowolnego</option>
				<?php $rows = db::query('select * from Model ORDER BY nazwa;');
					foreach($rows as $row) {
					echo "<option value='".$row['ID_modelu']."' >".$row['nazwa']."</option>"."\n";
				} ?>
			</select></td></tr>
			
			<tr><td><label for="inp">wersji:</label></td>
			<td><select class='findphpselect' name="Wersja_nazwa">
				<option selected="selected" value='-1'>dowolnej</option>
				<?php $rows = db::query('select DISTINCT(nazwa) from Wersja ORDER BY nazwa;');
					foreach($rows as $row) {
					echo "<option >".$row['nazwa']."</option>"."\n";
				} ?>
			</select></td></tr>
						
			<tr><td>O danym silniku:</tr></td>
			
			<tr><td><label for="inp">Symbolu silnika:</label></td>
			<td><select class='findphpselect' name="Silnik_symbol">
				<option selected="selected" value='-1'>dowolnym</option>
				<?php $rows = db::query('select DISTINCT(symbol) from Silnik ORDER BY symbol;');
					foreach($rows as $row) {
					echo "<option >".$row['symbol']."</option>"."\n";
				} ?>
			</select></td></tr>
			
			<tr><td><label for="inp">Pojemności:</label></td>
			<td><select class='findphpselect' name="Silnik_pojemnosc">
				<option selected="selected" value='-1'>dowolnej</option>
				<?php $rows = db::query('select DISTINCT(pojemnosc) from Silnik ORDER BY pojemnosc;');
					foreach($rows as $row) {
					echo "<option >".$row['pojemnosc']."</option>"."\n";
				} ?>
			</select></td></tr>
			
			<tr><td><label for="inp">Zasilaniu:</label></td>
			<td><select class='findphpselect' name="Silnik_zasilanie">
				<option selected="selected" value='-1'>dowolnym</option>
				<?php $rows = db::query('select DISTINCT(zasilanie) from Silnik ORDER BY zasilanie;');
					foreach($rows as $row) {
					echo "<option >".$row['zasilanie']."</option>"."\n";
				} ?>
			</select></td></tr>
						
			<tr><td><label for="inp">Mocy:</label></td>
			<td><select class='findphpselect' name="Silnik_moc">
				<option selected="selected" value='-1'>dowolnej</option>
				<?php $rows = db::query('select DISTINCT(moc) from Silnik ORDER BY moc;');
					foreach($rows as $row) {
					echo "<option >".$row['moc']."</option>"."\n";
				} ?>
			</select></td></tr>
			
			<input type='hidden' name='rodzaj' value='Samochod'>
			<tr><td><input type="submit" value="Szukaj samochodu"></td></tr>
		</table>
		
		</form>	
	</body>
</html>
