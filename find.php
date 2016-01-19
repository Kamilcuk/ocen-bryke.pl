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
			<tr><td><label for="inp">Nick użytkownika:</label></td>
			<td> <input type="text" name="nick"><br></td></tr>
			<tr><td><input type="submit" name='rodzaj' value="Uzytkownik"></td></tr>
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
			<td><select name="ID_marki">
				<option selected="selected" value='-1'>dowolne</option>
				<?php $rows = db::query('select * from Marka ORDER BY nazwa;');
					foreach($rows as $row) {
					echo "<option value='".$row['ID_marki']."' >".$row['nazwa']."</option>"."\n";
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
			<td><select name="ID_wersji">
				<option selected="selected" value='-1'>dowolne</option>
				<?php $rows = db::query('select * from Wersja ORDER BY nazwa;');
					foreach($rows as $row) {
					echo "<option value='".$row['ID_wersji']."' >".$row['nazwa']."</option>"."\n";
				} ?>
			</select></td></tr>
						
			<tr><td>Dane silnika:</tr></td>
			
			<tr><td><label for="inp">Symbol silnika:</label></td>
			<td><select name="ID_silnika">
				<option selected="selected" value='-1'>dowolne</option>
				<?php $rows = db::query('select * from Silnik ORDER BY symbol;');
					foreach($rows as $row) {
					echo "<option value='".$row['ID_silnika']."' >".$row['symbol']."</option>"."\n";
				} ?>
			</select></td></tr>
			
			<tr><td><label for="inp">Pojemnosc:</label></td>
			<td><select name="ID_silnika">
				<option selected="selected" value='-1'>dowolne</option>
				<?php $rows = db::query('select * from Silnik ORDER BY symbol;');
					foreach($rows as $row) {
					echo "<option value='".$row['ID_silnika']."' >".$row['pojemnosc']."</option>"."\n";
				} ?>
			</select></td></tr>
			
			<tr><td><label for="inp">Zasilanie:</label></td>
			<td><select name="ID_silnika">
				<option selected="selected" value='-1'>dowolne</option>
				<?php $rows = db::query('select * from Silnik ORDER BY symbol;');
					foreach($rows as $row) {
					echo "<option value='".$row['ID_silnika']."' >".$row['Zasilanie']."</option>"."\n";
				} ?>
			</select></td></tr>
						
			<tr><td><label for="inp">Moc:</label></td>
			<td><select name="ID_silnika">
				<option selected="selected" value='-1'>dowolne</option>
				<?php $rows = db::query('select * from Silnik ORDER BY symbol;');
					foreach($rows as $row) {
					echo "<option value='".$row['ID_silnika']."' >".$row['Moc']."</option>"."\n";
				} ?>
			</select></td></tr>
			
			<tr><td><input type="submit" name='rodzaj' value="Samochod"></td></tr>
		</table>
		
		</form>	
	</body>
</html>
