<?php
	require_once('user.inc');
    session_start();
?>
<html>
	<?php require_once('verify.inc'); ?>
	<head>
        <title>Oce&#324;-bryke.pl</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
        <SPAN id='debug'></SPAN>

<script type='text/javascript'>
function onclickMarka() {
	var Marka_nazwa = document.getElementsByName("Marka_nazwa")[0];
	var Model_nazwa = document.getElementsByName("Model_nazwa")[0];
	var Wersja_nazwa = document.getElementsByName("Wersja_nazwa")[0];
	var Silnik_symbol = document.getElementsByName("Silnik_symbol")[0];
	var ID_marki = Marka_nazwa.options[Marka_nazwa.selectedIndex].value;

    // reset other
    Model_nazwa.selectedIndex = 0;
    Wersja_nazwa.selectedIndex = 0;
    Silnik_symbol.selectedIndex = 0;
	
    if ( Marka_nazwa.selectedIndex == 0 ) {
		return;
    }
	
	for(var i=Model_nazwa.options.length-1;i>-1;--i) {
		var option_Model = Model_nazwa.options[i];
		option_Model.disabled = option_Model.id !=  ID_marki;
	}
}
function onclickModel() {
	var Marka_nazwa = document.getElementsByName("Marka_nazwa")[0];
	var Model_nazwa = document.getElementsByName("Model_nazwa")[0];
	var Wersja_nazwa = document.getElementsByName("Wersja_nazwa")[0];
	var Silnik_symbol = document.getElementsByName("Silnik_symbol")[0];
	var ID_modelu  = Model_nazwa.options[Model_nazwa.selectedIndex].value;

    // reset other
    Wersja_nazwa.selectedIndex = 0;
    Silnik_symbol.selectedIndex = 0;
    
    if ( Model_nazwa.selectedIndex == 0 ) {
		return;
    }    
    
	for(var i=Wersja_nazwa.options.length-1;i>-1;--i) {
		var option_Wersja_nazwa = Wersja_nazwa.options[i];
		option_Wersja_nazwa.disabled = option_Wersja_nazwa.id != ID_modelu;
	}
	
	// znajdz ID_silnika na podstawie ID_modelu
	for(var i=silniki.length-1;i>-1;--i) {
		if ( silniki[i].ID_modelu == ID_modelu )
			break;
	}
	if ( i == -1 ) {
		document.getElementById("debug").innerHTML = 
			'Blad w bazie danych! ID_modelu:'+ID_modelu+' i:'+i+"<BR>";
		return;
	}
	var ID_silnika = silniki[i].ID_silnika;
	for(var i=Silnik_symbol.options.length-1;i>-1;--i) {
		var option_Silnik_symbol = Silnik_symbol.options[i];
		option_Silnik_symbol.disabled = option_Silnik_symbol.value != ID_silnika;
	}
	
}

<?php //Kamil
$rows = db::query('select Model.ID_modelu, Samochod.ID_silnika from Samochod inner join Silnik on Samochod.ID_silnika = Silnik.ID_silnika inner join Wersja on Wersja.ID_wersji = Samochod.ID_wersji inner join Model on Wersja.ID_modelu = Model.ID_modelu;');
echo "var silniki = ".json_encode($rows)."; \n";
?>

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
						
			<tr><td><label for="inp">Wersja:</label></td>
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
						
			<tr><td><label for="inp">Symbol silnika tego modelu:</label></td>		
			<td><select name="Silnik_symbol">
			<option disabled selected> -- select an option -- </option>
<?php //Kamil Cukrowski
$rows = db::query('select * from Silnik;');
foreach($rows as $row) {
	echo "<option value='".$row['ID_silnika']."' >".$row['symbol']."</option>"."\n";
}
?>
			</select></td>
			<td><a class='link2' target='content_iframe' href='addSilnik.php' onClick="resizeUpdate()">Dodaj typ silnika</a></td></tr>

			</select></td></tr></table>
		
			<label for="inp">Rok produkcji:</label> <input type="number" name="rok_produkcji" placeholder=1999 ><br>
			<label for="inp">przebieg:</label><input type="number" name="przebieg" placeholder=10000 ><br>

			<input type="submit">
		</form>
	</body>
</html>
