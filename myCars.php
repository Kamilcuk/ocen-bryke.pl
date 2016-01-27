<?php
	require_once('user.inc');
    session_start();
?>
<html>
	<?php require_once('verify_try.inc'); ?>
	<head>
        <title>Oce&#324;-bryke.pl</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
	</head>
	<body class='frame'>
<br>

<?php if ( !isset($_GET['ID_uzytkownika']) && !isset($_GET['ID_samochodu']) ) { ?>
		<a class='link2' target='content_iframe' href='addCar.php' onClick="resizeUpdate()">
			Dodaj nowy samochód</a>
		<br>
<?php } ?>

<script  type='text/javascript'>
var ba = [];
function incSuper(ID_samochodu) {
	for (var i = 0; i < ba.length; i++) {
		if ( ba[i].ID_samochodu == ID_samochodu ) {
			break;
		}
	}
	if ( i == ba.length ) {
		return;
	}

	var b = ba[i];
	if ( b.index >= b.pics.length ) {
		b.index = 0;
	}
	var pic = b.pics[b.index];
	
	document.getElementById('image'+b.ID_samochodu).src = pic.url;
	document.getElementById('image'+b.ID_samochodu).title = pic.opis;
	document.getElementById('ZdjecieIndicator'+b.ID_samochodu).innerHTML = b.index+1;
	var usun = document.getElementById('usunToZdjecie'+b.ID_samochodu);
	if ( typeof usun != undefined && usun != null ) {
		usun.href = 'tryUsunCokolwiek.php?tabela=Zdjecie&id='+pic.ID_zdjecia.toString();
	}
		
	++b.index;
}
</script>

<?php //Kamnil Cukrowski

// ------------- pobierz samochody ------------------
//db::setDebug(10);
$order=' ORDER BY ID_samochodu DESC;';
if ( isset($_GET['ID_uzytkownika']) ) {
	// wyświetlamy wszystki samochodu tego użytkownika
	$cars = db::query('select * from Samochod where ID_uzytkownika = "'.db::escape($_GET['ID_uzytkownika']).'"'.$order);
} elseif ( isset($_GET['ID_samochodu']) ) {
	// wyswietlamy tylko ten samochod
	$cars = db::query('select * from Samochod where ID_samochodu = "'.db::escape($_GET['ID_samochodu']).'"'.$order);
} else {
	// wyswietlamy samochodu zalogowanego uzytkownika
	$cars = db::query('select * from Samochod where ID_uzytkownika = "'.$user->getID().'"'.$order);
}

// ------------------------- petla po samochodach ----------------------
foreach($cars as $car) {
	$pics = db::query('select * from Zdjecie where ID_samochodu = '.$car['ID_samochodu']);
	$uzytkownik = db::query('select * from Uzytkownik where ID_uzytkownika = '.$car['ID_uzytkownika'])[0];
	$wersja = db::query('select * from Wersja where ID_wersji = '.$car['ID_wersji'])[0];
	$model = db::query('select * from Model where ID_modelu = '.$wersja['ID_modelu'])[0];
	$marka = db::query('select * from Marka where ID_marki = '.$model['ID_marki'])[0];
	$silnik = db::query('select * from Silnik where ID_silnika = '.$car['ID_silnika'])[0];

	// dodajemy do tablicy bc wszsystkie informacje do javascriptu
	echo "<script  type='text/javascript'> \n".
		"	ba.push({ID_samochodu:".$car['ID_samochodu'].",index:1,pics:".json_encode($pics)."}); \n".
		"</script> \n";

	
	// ----------- cale wyswietlanie ponizej ------------
	echo '<table class="tab">'."\n";
	echo '<tr><td class="row4">Marka:'.' '.$marka['nazwa'].'</td>'."\n";
	
	if ( count($pics) > 0 ) {
		$pic=$pics[0];
		
		// wyswietl jednego pica z buttonem do przelanczania
		echo '<td class="img" rowspan = "6">';
		
		echo '<table><tr><td align="center">';
		echo 'Zdjecie: <span id="ZdjecieIndicator'.$car['ID_samochodu'].'">1</span> / '.count($pics);
		echo '</td></tr><tr><td align="center">';
		echo '<button type = "button" onclick="incSuper('.$car['ID_samochodu'].')" >Następne zdjęcie </button>';
		echo '</td></tr><tr><td align="center">';
		echo '<img id="image'.$car['ID_samochodu'].'" src="'.$pic['url'].'" title="'.$pic['opis'].'" style="max-width:350px;max-height:350px;">';
		echo '</td></tr></table>';
		
		echo '</td>';
	} else {
		echo '<td class="img" rowspan = "6"> Brak zdjec samochodu. </td>';
	}
	echo '</tr>';


	echo '<tr><td class="row4">Model:'.' '.$model['nazwa'].'</td></tr>'."\n";
	echo '<tr><td class="row4">Wersja:'.' '.$wersja['nazwa'].'</td></tr>'."\n";
	echo '<tr><td class="row4">Symbol silnika:'.' '.$silnik['symbol'].'</td></tr>'."\n";
	echo '<tr><td class="row4">Pojemnosc:'.' '.$silnik['pojemnosc'].'</td></tr>'."\n";
	echo '<tr><td class="row4">Zasilanie:'.' '.$silnik['zasilanie'].'</td></tr>'."\n";
	echo '<tr><td class="row4">Moc:'.' '.$silnik['moc'].'</td></tr>'."\n";	
	echo '<tr><td class="row4">Przebieg:'.' '.$car['przebieg'].'</td>'."\n";
	echo '<tr><td class="row4">Rok produkcji:'.' '.$car['rok_produkcji'].'</td>'."\n";
	
	echo '<tr><td class="row4">Ocena samochodu:'.' '.
		getOcena('Samochod',$car['ID_samochodu']).'</td>'."\n";
	
		
	// ----------------- edycja i usuwanie-------------------
	// nie gość i ( samochód użytkownika lub admin ) -> może usuwać samochód i usuwać zdjęcia
	if ( $user != null && 
			( $user->sprawdzCzyMoje('Samochod',$car['ID_samochodu']) ||
			$user->czyAdmin() ) ) {
		$usun = true;
	} else {
		$usun = false;
	}
	// samochód użytkownika -> może dodawać zdjęcia
	if ( $user != null && $user->sprawdzCzyMoje('Samochod',$car['ID_samochodu']) ) {
		$edit = true;
	} else {
		$edit = false;
	}
	
	//if ( $user->sprawdzCzyMoje('Samochod',$car['ID_samochodu'])) {
	if ( $usun && count($pics) > 0 ) {
		echo '<td><a id="usunToZdjecie'.$car['ID_samochodu'].'" class="err3" '.
			'href="tryUsunCokolwiek.php?tabela=Zdjecie&id='.$pic['ID_zdjecia'].'">';
		echo 'Usun to Zdjecie</a></td>'."\n";
	}
	echo '<tr><td>';
	if ( $edit ) {
		echo '<a class = "Link2" href="addZdjecie.php?ID_samochodu='.$car['ID_samochodu'].'">';
		echo 'Dodaj zdjęcie samochodu</a>'."\n";
	}
	echo '</td><td>';
	if ( $usun ) {
		echo '<a class = "err3" href="tryUsunCokolwiek.php?tabela=Samochod&id='.$car['ID_samochodu'].'">';
		echo 'Usun samochód</a>'."\n";
	}
	echo '</td></tr>';
	
	echo "</table>";
	
	echo '<br>';
	
	echo "</div>";
}
?>
	</body>
</html>
