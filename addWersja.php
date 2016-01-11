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
		<h1>jestem addWersja.php</h1>
		
		 <form action="/tryAddWersja.php" method="post">
		<table>
		
			<tr><td><label for="inp">Model:</label></td>
			<td><select name="Model_nazwa">
<?php //Kamil Cukrowski
$rows = db::query('select nazwa from Model;');
foreach($rows as $row) {
	echo "<option>".$row['nazwa']."</option>"."\n";
}
?>
			</select></td></tr>
							
			</table>
		
			<label for="inp">Nazwa wersji:</label>   <input type="text" name="Wersja_nazwa"><br>

			<input type="submit">
		</form>
	</body>
</html>
