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
		<h1>jestem addCar.php</h1>
		
		 <form action="/tryAddCar.php" method="post">
		<table>
		
			<tr><td><label for="inp">Model:</label></td>
			<td><select name="Model_nazwa">
<?php //Kamil Cukrowski
$rows = db::query('select nazwa from Model;');
foreach($rows as $row) {
	echo "<option value=\"".$row['ID_modelu']."\">".$row['nazwa']."</option>"."\n";
}
?>
			</select></td>
			
			<td><a class='link2' target='content_iframe' href='addModel.php' onClick="resizeUpdate()">Dodaj model samochodu</a></td></tr>
						
			<tr><td><label for="inp">Wersja:</label></td>
			<td><select name="Wersja_nazwa">
<?php //Kamil Cukrowski
$rows = db::query('select nazwa from Wersja;');
foreach($rows as $row) {
	echo "<option>".$row['nazwa']."</option>"."\n";
}
?>
			</select></td>
			<td><a class='link2' target='content_iframe' href='addWersja.php' onClick="resizeUpdate()">Dodaj wersję samochodu</a></td></tr></tr>
			
			<tr><td><label for="inp">Marka:</label></td>		
			<td><select name="Marka_nazwa">
<?php //Kamil Cukrowski
$rows = db::query('select nazwa from Marka;');
foreach($rows as $row) {
	echo "<option>".$row['nazwa']."</option>"."\n";
}
?>
			</select></td>
			<td><a class='link2' target='content_iframe' href='addMarka.php' onClick="resizeUpdate()">Dodaj markę samochodu</a></td></tr>
						
			<tr><td><label for="inp">Symbol silnika:</label></td>		
			<td><select name="Silnik_symbol">
<?php //Kamil Cukrowski
$rows = db::query('select symbol from Silnik;');
foreach($rows as $row) {
	echo "<option>".$row['symbol']."</option>"."\n";
}
?>
			</select></td>
			<td><a class='link2' target='content_iframe' href='addSilnik.php' onClick="resizeUpdate()">Dodaj typ silnika</a></td></tr>
		
			<tr><td><label for="inp">Marka_nazwa:</label></td>
			<td><select name="Marka_nazwa">
<?php //Kamil Cukrowski
$rows = db::query('select nazwa from Marka;');
foreach($rows as $row) {
	echo "<option>".$row['nazwa']."</option>"."\n";
}
?>
			</select></td></tr>
			
			</table>
		
			<label for="inp">Rok produkcji:</label>   <input type="number" name="rok_produkcji"><br>
			<label for="inp">przebieg:</label>   <input type="number" name="przebieg"><br>

			<input type="submit">
		</form>
	</body>
</html>
