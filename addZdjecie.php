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
		<form action="/tryAddZdjecie.php?ID_samochodu=<?php echo $_GET['ID_samochodu'];?>" method="post" enctype="multipart/form-data">
		Plik ze zdjęciem: <input type="file" name="uploadedFile"><br>
		Opis do zdjecia: <input type="text" name="Zdjecie_opis"><br>
		
		<input type="submit" name="submit" value="Wrzuc fotke"><br>
		</form>
		<BR>
		
		<?php // Kamil ID_samochodu dostajemy w poscie 
// to jest to samo co w myCars.php, tylko że ID_samochodu jest tylko ten co go dodajemy
$cars = db::query('select * from Samochod where ID_samochodu = '.$_GET['ID_samochodu']);
foreach($cars as $car) {
	echo '<table border="1" style="border: 1px solid black">';
	echo '<tr class="tab"><td class="row4">Wersja:'.'</td><td class="row4">'.
		db::queryone('select nazwa from Wersja where ID_wersji = '.$car['ID_wersji'])['nazwa'].'</td>';
	// zdjecia :D niech sie wyswietlaja!
	$pics = db::query('select * from Zdjecie where ID_samochodu = '.$car['ID_samochodu']);
	echo '<td rowspan = "8">';
	foreach($pics as $pic) {
		echo "Zdjecie:".
			'<img class= "img" src="'.$pic['url'].'" title="'.$pic['opis'].'"</td>';
		echo '<a class = "Link2" href="tryUsunCokolwiek.php?tabela=Zdjecie&id='.$pic['ID_zdjecia'].'">';
		echo 'Usun to Zdjecie</a>';
		echo '<br>';
	}
	echo '</tr>';
	echo '<tr class="tab"><td class="row4">Silnik:'.'</td><td class="row4">'.
		db::queryone('select symbol from Silnik where ID_silnika = '.$car['ID_silnika'])['symbol'].'</td>';
	echo '</tr>';
	echo '<tr class="tab"><td class="row4">Model:'.'</td><td class="row4">'.
		db::queryone('select nazwa from Model where ID_modelu = '.$car['ID_modelu'])['nazwa'].'</td>';
	echo '</tr>';
	echo '<tr class="tab"><td class="row4">Marka:'.'</td><td class="row4">'.
		db::queryone('select nazwa from Marka where ID_marki = '.$car['ID_marki'])['nazwa'].'</td>';
	echo '</tr>';
	echo '<tr class="tab"><td class="row4">Przebieg:'.'</td> <td class="row4">'.
		$car['przebieg'].'</td>';
	echo '<tr class="tab"><td class="row4">Rok produkcji:'.'</td><td class="row4">'.
		$car['rok_produkcji'].'</td>';
	echo '<tr class="tab"><td class="row4">Ocena samochodu:'.'</td><td class="row4">'.
			getOcena('Samochod',$car['ID_samochodu']).'</td>';
	
	
	echo "</table>";
	
	
	echo '<a class = "Link2" href="addZdjecie.php?ID_samochodu='.$car['ID_samochodu'].'">';
	echo 'Dodaj fotke do tego samochodu</a>';
	echo '<a class = "Link2" href="tryUsunCokolwiek.php?tabela=samochod&id='.$car['ID_samochodu'].'">';
	echo 'Usun ten samochód</a>';
	echo '<br>';
	
	echo "</div>";


}
?>

	</body>
</html>
