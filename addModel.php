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
		<h1>jestem addModel.php</h1>
		 <form action="/tryAddModel.php" method="post">
		 <table>
			
			<tr><td><label for="inp">Marka:</label></td>		
			<td><select name="Marka_nazwa">
<?php //Kamil Cukrowski
$rows = db::query('select nazwa from Marka;');
foreach($rows as $row) {
	echo "<option>".$row['nazwa']."</option>"."\n";
}
?>
			</select></td></tr>

			<tr><td><label for="inp">Symbol silnika:</label></td>		
			<td><select name="Silnik_symbol">
<?php //Kamil Cukrowski
$rows = db::query('select symbol from Silnik;');
foreach($rows as $row) {
	echo "<option>".$row['symbol']."</option>"."\n";
}
?>
			</select></td></tr>
			
			</table>
		
			<label for="inp">Nazwa modelu:</label>   <input type="text" name="Model_nazwa"><br>

			<input type="submit">
		</form>
	</body>
</html>
