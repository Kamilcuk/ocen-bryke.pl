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

		<a class='link2' target='content_iframe' href='addCar.php' onClick="resizeUpdate()">Dodaj samochód</a>
	
<?php //Kamnil Cukrowski
//sdb::setDebug(10);
$cars = db::query('select * from Samochod where ID_uzytkownika = '.$user->getID());
foreach($cars as $car) {
	echo "<div class='car'><ul>";
	echo "<li>Wersja:".
		db::queryone('select nazwa from Wersja where ID_wersji = '.$car['ID_wersji'])['nazwa'].'</li>';
	echo "<li>Silnik:".
		db::queryone('select symbol from Silnik where ID_silnika = '.$car['ID_silnika'])['symbol'].'</li>';
	echo "<li>Model:".
		db::queryone('select nazwa from Model where ID_modelu = '.$car['ID_modelu'])['nazwa'].'</li>';
	echo "<li>Ilosc ocen pozytywnych:".
		$car['oceny_pozytywne'].'</li>';
	echo "<li>Marka:".
		db::queryone('select nazwa from Marka where ID_marki = '.$car['ID_marki'])['nazwa'].'</li>';
	echo "<li>Ilosc ocen negatywnych:".
		$car['oceny_negatywne'].'</li>';
	echo "<li>Przebieg:".
		$car['przebieg'].'</li>';
	echo "<li>Rok produkcji:".
		$car['rok_produkcji'].'</li>';
	echo "</ul>";
	
	// zdjecia :D niech sie wyswietlaja!
	$pics = db::query('select * from Zdjecie where ID_samochodu = '.$car['ID_samochodu']);
	echo "<ul>";
	foreach($pics as $pic) {
		echo "<li>Zdjecie:".
			'<img src="'.$pic['url'].'" title="'.$pic['opis'].'"></li>';
	}
	echo "</ul>";
	
	echo '<br>';
	echo '<a href="addZdjecie.php?ID_smochodu='.$car['ID_samochodu'].'">';
	echo 'Dodaj fotke do tego samochodu</a>';
	echo '<br>';
	
	echo "</div>";


}
?>
<?php //Kamil Cukrowski nie wiem co to jest tu ponizej: 
/*
		
<div class='Labels'>
			<label for="inp">Marka:</label>
			<label for="inp">Model:</label>
			<label for="inp">Typ nadwozia:</label>
			<label for="inp">Silnik:</label>
			<label for="inp">Pojemność:</label>
			<label for="inp">Zasilanie:</label>
			<label for="inp">Moc:</label>
			<label for="inp">Symbol:</label>	
		 </div>
		 
		 <div class='Labels'>
			<ul>
			<li>dupa</li>
			<li>dupa</li>
			<li>dupa</li>
			<li>dane:</li>
			<li>dupa</li>
			<li>dupa</li>
			<li>dupa</li>
			<li>dupa</li>
		 </ul>
		 </div>
		 */
?>
	</body>
</html>
