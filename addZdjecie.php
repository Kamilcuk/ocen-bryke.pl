<?php
	require_once('user.inc');
	session_start();
?>
<html>
	<?php require_once('verify.inc') ?>
	<head>
        <title>Oce&#324;-bryke.pl</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
	</hed>
	<body class='frame'>
        <h1>jestem addZdjecie.php</h1>
		<h1>Dodajesz zdjęcie do samochodu poniżej:</h1><BR>
		
	<form class= 'Login' action="/tryAddZdjecie.php?ID_samochodu=<?php echo $_GET['ID_samochodu'];?>" method="post" enctype="multipart/form-data">
		<label for="inp">Plik ze zdjęciem:</label> <input type="file" name="uploadedFile">
		<label for="inp">Opis do zdjecia:</label> <input type="text" name="Zdjecie_opis">
		
		<input type="submit" name="submit" value="Wrzuc fotke"><br>
		</form>
		<BR>
		
		<?php // Kamil ID_samochodu dostajemy w poscie 
// to jest to samo co w myCars.php, tylko że ID_samochodu jest tylko ten co go dodajemy
$cars = db::query('select * from Samochod where ID_samochodu = '.$_GET['ID_samochodu']);

foreach($cars as $car) {

	echo '<table class="tab" border="1" style="border: 1px solid black">';
	echo '<tr ><td class="row4">Wersja:'.'</td><td class="row4">'.
		db::queryone('select nazwa from Wersja where ID_wersji = '.$car['ID_wersji'])['nazwa'].'</td>';
	// zdjecia :D niech sie wyswietlaja!
	$pics = db::query('select * from Zdjecie where ID_samochodu = '.$car['ID_samochodu']);
	
	foreach($pics as $pic) {
		echo '<td class="img" rowspan = "6">'.
		    "Zdjecie:".
			'<img src="'.$pic['url'].'" title="'.$pic['opis'].
			'" style="max-width:350px;max-height:350px;" ><br><br>'."\n";
		echo '<a class = "Link2" href="tryUsunCokolwiek.php?tabela=Zdjecie&id='.$pic['ID_zdjecia'].'">';
		echo 'Usun to Zdjecie</a></td>';
		echo '<br>';
	}
	echo '<tr><td class="row4">Silnik:'.'</td><td class="row4">'.
		db::queryone('select symbol from Silnik where ID_silnika = '.$car['ID_silnika'])['symbol'].'</td>';
	echo '</tr>'."\n";
	echo '<tr><td class="row4">Model:'.'</td><td class="row4">'.
		db::queryone('select nazwa from Model where ID_modelu = '.$car['ID_modelu'])['nazwa'].'</td>';
	echo '</tr>'."\n";
	echo '<tr><td class="row4">Marka:'.'</td><td class="row4">'.
		db::queryone('select nazwa from Marka where ID_marki = '.$car['ID_marki'])['nazwa'].'</td>';
	echo '</tr>'."\n";
	echo '<tr><td class="row4">Przebieg:'.'</td> <td class="row4">'.
		$car['przebieg'].'</td>'."\n";
	echo '<tr><td class="row4">Rok produkcji:'.'</td><td class="row4">'.
		$car['rok_produkcji'].'</td>'."\n";
	echo '<tr><td class="row4">Ocena samochodu:'.'</td><td class="row4">'.
			getOcena('Samochod',$car['ID_samochodu']).'</td>'."\n";
	echo '<td><a id="usunToZdjecie'.$car['ID_samochodu'].'" class="err3" '.
			'href="tryUsunCokolwiek.php?tabela=Zdjecie&id='.$pic['ID_zdjecia'].'">';
		echo 'Usun to Zdjecie</a></tr>'."\n";
	echo '<tr><td colspan="2"><a class = "Link2" href="addZdjecie.php?ID_samochodu='.$car['ID_samochodu'].'">';
	echo 'Dodaj fotke do tego samochodu</a></td>'."\n";
	echo '<td><a class = "err3" href="tryUsunCokolwiek.php?tabela=samochod&id='.$car['ID_samochodu'].'">';
	echo 'Usun ten samochód</a></td>'."\n";
	
	echo "</table>";
	
	/*
	echo '<a class = "Link2" href="addZdjecie.php?ID_samochodu='.$car['ID_samochodu'].'">';
	echo 'Dodaj fotke do tego samochodu</a>';
	echo '<a class = "Link2" href="tryUsunCokolwiek.php?tabela=samochod&id='.$car['ID_samochodu'].'">';
	echo 'Usun ten samochód</a>';
	echo '<br>';
	*/
	echo "</div>";


}
?>

	</body>
</html>
