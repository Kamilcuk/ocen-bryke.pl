<?php
	require_once('user.inc');
    session_start();
?>
<html>
	<?php require_once('verify.inc'); ?>
	<head>
        <title>Oce&#324;-bryke.pl</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
	</hed>
	<body class='frame'>
		<h1>jestem myCars.php</h1>

		<a class='link2' target='content_iframe' href='addCar.php' onClick="resizeUpdate()">
			Dodaj nowy samochód</a>
		<br>
<?php //Kamnil Cukrowski
//sdb::setDebug(10);
$cars = db::query('select * from Samochod where ID_uzytkownika = '.$user->getID());
foreach($cars as $car) {
	echo '<table class="tab" border="1" style="border: 1px solid black">';
	echo '<tr ><td class="row4">Wersja:'.'</td><td class="row4">'.
		db::queryone('select nazwa from Wersja where ID_wersji = '.$car['ID_wersji'])['nazwa'].'</td>';
	// zdjecia :D niech sie wyswietlaja!
	
	$pics = db::query('select * from Zdjecie where ID_samochodu = '.$car['ID_samochodu']);
	foreach($pics as $pic) {
		echo '<td class="img" rowspan = "6"> Zdjecie:<br>'.
			'<img src="'.$pic['url'].'" title="'.$pic['opis'].'" style="max-width:350px;max-height:350px;".<br><br>';
		echo '</td></tr>';
	}
	echo '<tr><td class="row4">Silnik:'.'</td><td class="row4">'.
		db::queryone('select symbol from Silnik where ID_silnika = '.$car['ID_silnika'])['symbol'].'</td>';
	echo '</tr>';
	echo '<tr><td class="row4">Model:'.'</td><td class="row4">'.
		db::queryone('select nazwa from Model where ID_modelu = '.$car['ID_modelu'])['nazwa'].'</td>';
	echo '</tr>';
	echo '<tr><td class="row4">Marka:'.'</td><td class="row4">'.
		db::queryone('select nazwa from Marka where ID_marki = '.$car['ID_marki'])['nazwa'].'</td>';
	echo '</tr>';
	echo '<tr><td class="row4">Przebieg:'.'</td> <td class="row4">'.
		$car['przebieg'].'</td>';
	echo '<tr><td class="row4">Rok produkcji:'.'</td><td class="row4">'.
		$car['rok_produkcji'].'</td>';
	echo '<tr><td class="row4">Ocena samochodu:'.'</td><td class="row4">'.
			getOcena('Samochod',$car['ID_samochodu']).'</td>';
	echo '<td><a class = "err3" href="tryUsunCokolwiek.php?tabela=Zdjecie&id='.$pic['ID_zdjecia'].'">';
		echo 'Usun to Zdjecie</a></tr>';
	echo '<tr><td colspan="2"><a class = "Link2" href="addZdjecie.php?ID_samochodu='.$car['ID_samochodu'].'">';
	echo 'Dodaj fotke do tego samochodu</a></td>';
	echo '<td><a class = "err3" href="tryUsunCokolwiek.php?tabela=samochod&id='.$car['ID_samochodu'].'">';
	echo 'Usun ten samochód</a></td>';
	
	echo "</table>";
	
	
	
	echo '<br>';
	
	echo "</div>";


}
?>
	</body>
</html>
