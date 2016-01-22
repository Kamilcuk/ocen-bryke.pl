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
		<h1>jestem find.php</h1>
		<form action="/tryFind.php" method="post">
		
		<table>
		 	Wyszukaj użytkownika:<BR>
			<tr><td><label for="inp">Nick użytkownika zawiera:</label></td>
			<td> <input type="text" name="nick"><br></td></tr>
			<input type='hidden' name='rodzaj' value='Uzytkownik'>
			<tr><td><input type="submit" value="Szukaj uzytkownika"></td></tr>
		</table>
		<BR><BR>
		<table>
			Wyszukaj samochów:<BR>
			
			<tr><td><label for="inp">Uzytkownika:</label></td>
			<td><select name='ID_uzytkownika'>
				<option selected="selected" value='-1'>dowolne</option>
				<?php $rows = db::query('select * from Uzytkownik ORDER BY nick;');
					foreach($rows as $row) {
					echo "<option value='".$row['ID_uzytkownika']."' >".$row['nick']."</option>"."\n";
				} ?>
			</select></td></tr>
			
			<tr><td><label for="inp">o marce:</label></td>
			<td><select name="Marka_nazwa">
				<option selected="selected" value='-1'>dowolne</option>
				<?php $rows = db::query('select DISCTINCT(*) from Marka ORDER BY nazwa;');
					foreach($rows as $row) {
					echo "<option >".$row['nazwa']."</option>"."\n";
				} ?>
			</select></td></tr>
			
		 	<tr><td><label for="inp">Model:</label></td>
			<td><select name="ID_modelu">
				<option selected="selected" value='-1'>dowolne</option>
				<?php $rows = db::query('select * from Model ORDER BY nazwa;');
					foreach($rows as $row) {
					echo "<option value='".$row['ID_modelu']."' >".$row['nazwa']."</option>"."\n";
				} ?>
			</select></td></tr>
			
			<tr><td><label for="inp">Wersja:</label></td>
			<td><select name="Wersja_nazwa">
				<option selected="selected" value='-1'>dowolne</option>
				<?php $rows = db::query('select DISTINCT(nazwa) from Wersja ORDER BY nazwa;');
					foreach($rows as $row) {
					echo "<option >".$row['nazwa']."</option>"."\n";
				} ?>
			</select></td></tr>
						
			<tr><td>Dane silnika:</tr></td>
			
			<tr><td><label for="inp">Symbol silnika:</label></td>
			<td><select name="Silnik_symbol">
				<option selected="selected" value='-1'>dowolne</option>
				<?php $rows = db::query('select DISTINCT(symbol) from Silnik ORDER BY symbol;');
					foreach($rows as $row) {
					echo "<option >".$row['symbol']."</option>"."\n";
				} ?>
			</select></td></tr>
			
			<tr><td><label for="inp">Pojemnosc:</label></td>
			<td><select name="Silnik_pojemnosc">
				<option selected="selected" value='-1'>dowolne</option>
				<?php $rows = db::query('select DISTINCT(pojemnosc) from Silnik ORDER BY pojemnosc;');
					foreach($rows as $row) {
					echo "<option >".$row['pojemnosc']."</option>"."\n";
				} ?>
			</select></td></tr>
			
			<tr><td><label for="inp">Zasilanie:</label></td>
			<td><select name="Silnik_zasilanie">
				<option selected="selected" value='-1'>dowolne</option>
				<?php $rows = db::query('select DISTINCT(zasilanie) from Silnik ORDER BY zasilanie;');
					foreach($rows as $row) {
					echo "<option >".$row['zasilanie']."</option>"."\n";
				} ?>
			</select></td></tr>
						
			<tr><td><label for="inp">Moc:</label></td>
			<td><select name="Silnik_moc">
				<option selected="selected" value='-1'>dowolne</option>
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
