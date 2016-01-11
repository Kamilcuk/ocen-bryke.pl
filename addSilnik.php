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
		<h1>jestem addSilnik.php</h1>
		
		 <form action="/tryAddSilnik.php" method="post">
		<table>
			<label for="inp">Symbol:</label>   <input type="text" name="Silnik_symbol"><br>
			<label for="inp">Pojemnosc:</label>   <input type="number" name="Silnik_pojemnosc"><br>
			<label for="inp">Zasilanie:</label></td>
			<select name="Silnik_zasilanie">
<?php //Kamil Cukrowski
// get enum values
$sql = "SHOW COLUMNS FROM `Silnik` LIKE 'zasilanie';";
$result = db::query($sql);
$option_array = explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $result[0]['Type']));
// i wyswietlanei
foreach($option_array as $row) {
	echo "<option>".$row."</option>"."\n";
}
?>
			</select>
			<label for="inp">Moc:</label>   <input type="number" name="Silnik_moc"><br>
			

			<input type="submit">
		</form>
	</body>
</html>
