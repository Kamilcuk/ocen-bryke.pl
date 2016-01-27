<?php
	require_once('user.inc');
    session_start();
?>
<html>
	<?php require_once('verify.inc'); ?>
	<head>
        <title>Oce&#324;-bryke.pl</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
        <script type='text/javascript'>
function onclickMarka() {
	var Marka_nazwa = document.getElementsByName("Marka_nazwa")[0];
	var Model_nazwa = document.getElementsByName("Model_nazwa")[0];
	var ID_marki = Marka_nazwa.options[Marka_nazwa.selectedIndex].value;

    // reset other
    Model_nazwa.selectedIndex = 0;
	
    if ( Marka_nazwa.selectedIndex == 0 ) {
		return;
    }
	
	for(var i=Model_nazwa.options.length-1;i>-1;--i) {
		var option_Model = Model_nazwa.options[i];
		option_Model.disabled = option_Model.id !=  ID_marki;
	}
}
		</script>
	</head>
	<body class='frame'>
	<br>
			<form action="/tryAddWersja.php" method="post">
			<table>		<tr><td><label for="inp">Marka:</label></td>		
		<td><select onclick="onclickMarka()" name="Marka_nazwa">
		<option disabled selected> -- select an option -- </option>
<?php //Kamil Cukrowski
$rows = db::query('select * from Marka;');
foreach($rows as $row) {
	echo "<option value=".$row['ID_marki']." >".$row['nazwa']."</option>"."\n";
}
?>
		</select>
		</td></tr>

		
			<tr><td><label for="inp">Model:</label></td>
			<td><select onclick="onclickModel()" name="Model_nazwa">
			<option disabled selected> -- select an option -- </option>
<?php //Kamil Cukrowski
$rows = db::query('select * from Model;');
foreach($rows as $row) {
	echo "<option value=".$row['ID_modelu']." id=".$row['ID_marki']." >".$row['nazwa']."</option>"."\n";
}
?>
			</select>
			</td></tr>
		
			<tr><td>
			<label for="inp">Nazwa wersji:</label>
			</td><td>   
			<input type="text" name="Wersja_nazwa"><br>
			</td></tr><tr><td>
			<input type="submit" value='Dodaj wersję'>
		</td></tr></table>
		</form>
	</body>
</html>
