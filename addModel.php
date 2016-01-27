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
<br>
		 <form action="/tryAddModel.php" method="post">
		 <table>
			
			<tr>
				<td><label for="inp">Marka:</label></td>		
				<td><select name="ID_marki">
<?php //Kamil Cukrowski
$rows = db::query('select * from Marka order by Nazwa;');
foreach($rows as $row) {
	echo "<option value='".$row['ID_marki']."'>".$row['nazwa']."</option>"."\n";
}
?>
				</select>
			</tr><td>
				<label for="inp">Nazwa modelu:</label>
			</td><td>
				<input type="text" name="Model_nazwa">
			</td></tr>
			<tr><td>
					<input type="submit" value='Dodaj model'>
			</td></tr>
		</table>
		</form>
	</body>
</html>
