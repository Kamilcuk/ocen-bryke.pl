<?php
	require_once('user.inc');
    session_start();
?>
<html>

	<head>
        <title>Oce&#324;-bryke.pl</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
	</hed>
	<body class='frame'>
		<h1>jestem find.php</h1>
		 <form action="/tryFind.php" method="post">
		<table>
			<tr><td><label for="inp">Użytkownik:</label></td>
			<td> <input type="text" name="name"><br></td></tr>
			
			<tr><td><label for="inp">Marka:</label></td>
			<td><select name="Marka">
				<option selected="selected">Wybierz</option>
				<?php //Kamil Cukrowski
					$rows = db::query('select nazwa from Marka;');
					foreach($rows as $row) {
					echo "<option>".$row['nazwa']."</option>"."\n";
				}
				?>
			</select></td></tr>
		 <tr><td><label for="inp">Model:</label></td>
			<td><select name="Model">
			<option selected="selected">Wybierz</option>
		<?php //Kamil Cukrowski
			$rows = db::query('select nazwa from Model;');
			foreach($rows as $row) {
			echo "<option>".$row['nazwa']."</option>"."\n";
		}
		?>
			</select></td></tr>
		<tr><td><label for="inp">Wersja:</label></td>
			<td><select name="Marka">
			<option selected="selected">Wybierz</option>
<?php //Kamil Cukrowski
$rows = db::query('select nazwa from Wersja;');
foreach($rows as $row) {
	echo "<option>".$row['nazwa']."</option>"."\n";
}
?>
			</select></td></tr>
		
		<tr><td><label for="inp">Silnik:</label></td></tr>
		
		<tr><td><label for="inp">Pojemność:</label></td>
			<td><select name="Marka">
				<option selected="selected">Wybierz</option>
				<option>dupa</option>
				<option>dupa</option>
			<option>Inny</option>
			</select></td></tr>
		<tr><td><label for="inp">Zasilanie:</label></td>
			<td><select name="Marka">
				<option selected="selected">Wybierz</option>
				<option>dupa</option>
				<option>dupa</option>
			<option>Inny</option>
			</select></td></tr>	
		<tr><td><label for="inp">Moc:</label></td>
			<td><select name="Marka">
				<option selected="selected">Wybierz</option>
				<option>dupa</option>
				<option>dupa</option>
			<option>Inny</option>
			</select></td></tr>	
		<tr><td><label for="inp">Symbol:</label></td>
			<td><select name="Marka">
				<option selected="selected">Wybierz</option>
<?php //Kamil Cukrowski
$rows = db::query('select symbol from Silnik;');
foreach($rows as $row) {
	echo "<option>".$row['symbol']."</option>"."\n";
}
?>
			</select></td></tr>
			<tr><td><input type="submit" value="Wyszukaj"></td></tr>
		</table>
		</form>	
	</body>
</html>
