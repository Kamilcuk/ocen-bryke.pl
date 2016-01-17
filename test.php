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
    if ( typeof Model_nazwa_innerHTML_orig == 'undefined' ) {
		Model_nazwa_innerHTML_orig = Model_nazwa.innerHTML;
    }
	var ID_marki = Marka_nazwa.options[Marka_nazwa.selectedIndex].value;
	Model_nazwa.innerHTML = Model_nazwa_innerHTML_orig;
	for(var i=Model_nazwa.options.length-1;i>-1;--i) {
		var option_Model = Model_nazwa.options[i];
		if ( option_Model.id !=  ID_marki ) {
			Model_nazwa.remove(i);
		}
	}
}
function onclickModel() {
	var Marka_nazwa = document.getElementsByName("Marka_nazwa")[0];
	var Model_nazwa = document.getElementsByName("Model_nazwa")[0];
	var Model_nazwa = document.getElementsByName("Model_nazwa")[0];
    if ( typeof Model_nazwa_innerHTML_orig == 'undefined' ) {
		Model_nazwa_innerHTML_orig = Model_nazwa.innerHTML;
    }
	var ID_marki = Marka_nazwa.options[Marka_nazwa.selectedIndex].value;
	Model_nazwa.innerHTML = Model_nazwa_innerHTML_orig;
	for(var i=Model_nazwa.options.length-1;i>-1;--i) {
		var option_Model = Model_nazwa.options[i];
		if ( option_Model.id !=  ID_marki ) {
			Model_nazwa.remove(i);
		}
	}
}
</script>

	</head>
	<body class='frame'>
		<h1>jestem addCar.php</h1>
<span id='test'></span>
		
		 <form action="/tryAddCar.php" method="post">
		<table>

		<tr><td><label for="inp">Marka:</label></td>		
		<td><select onclick="onclickMarka()" name="Marka_nazwa">
		<option disabled selected> -- select an option -- </option>
<?php //Kamil Cukrowski
$rows = db::query('select * from Marka;');
foreach($rows as $row) {
	echo "<option value=".$row['ID_marki']." >".$row['nazwa']."</option>"."\n";
}
?>
		</select></td>
		<td><a class='link2' target='content_iframe' href='addMarka.php' onClick="resizeUpdate()">Dodaj markę samochodu</a></td></tr>

		
			<tr><td><label for="inp">Model:</label></td>
			<td><select onclick="onclickModel()" name="Model_nazwa">
			<option disabled selected> -- select an option -- </option>
<?php //Kamil Cukrowski
$rows = db::query('select * from Model;');
foreach($rows as $row) {
	echo "<option value=".$row['ID_modelu']." id=".$row['ID_marki']." >".$row['nazwa']."</option>"."\n";
}
?>
			</select></td>
			
			<td><a class='link2' target='content_iframe' href='addModel.php' onClick="resizeUpdate()">Dodaj model samochodu</a></td></tr>
						
			<tr><td><label onclick="onclickWersja()" for="inp">Wersja:</label></td>
			<td><select name="Wersja_nazwa">
			<option disabled selected> -- select an option -- </option>
<?php //Kamil Cukrowski
$rows = db::query('select * from Wersja;');
foreach($rows as $row) {
	echo "<option value=".$row['ID_wersji']." id=".$row['ID_modelu'].">".$row['nazwa']."</option>"."\n";
}
?>
			</select></td>
			<td><a class='link2' target='content_iframe' href='addWersja.php' onClick="resizeUpdate()">Dodaj wersję samochodu</a></td></tr></tr>
						
			<tr><td><label for="inp">Symbol silnika:</label></td>		
			<td><select name="Silnik_symbol">
			<option disabled selected> -- select an option -- </option>
<?php //Kamil Cukrowski
$rows = db::query('select symbol from Silnik;');
foreach($rows as $row) {
	echo "<option>".$row['symbol']."</option>"."\n";
}
?>
			</select></td>
			<td><a class='link2' target='content_iframe' href='addSilnik.php' onClick="resizeUpdate()">Dodaj typ silnika</a></td></tr>

			</select></td></tr>
			
			</table>
		
			<label for="inp">Rok produkcji:</label>   <input type="number" name="rok_produkcji"><br>
			<label for="inp">przebieg:</label>   <input type="number" name="przebieg"><br>

			<input type="submit">
		</form>
	</body>
</html>
