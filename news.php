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
		<h1>jestem news.php</h1>
		Najnowsze dodane samochody:<br>
		
		<?php //Kamil
$pics = db::query('select * from Zdjecie order by data_dodania desc');
foreach($pics as $pic) {
	$uzytkownik = db::query('select * from Uzytkownik where ID_uzytkownika = '.$pic['ID_uzytkownika'])[0];
	$samochod = db::query('select * from Samochod where ID_samochodu = '.$pic['ID_samochodu'])[0];
	$wersja = db::query('select * from Wersja where ID_wersji = '.$samochod['ID_wersji'])[0];
	$model = db::query('select * from Model where ID_modelu = '.$wersja['ID_modelu'])[0];
	$marka = db::query('select * from Marka where ID_marki = '.$model['ID_marki'])[0];
	$silnik = db::query('select * from Silnik where ID_silnika = '.$samochod['ID_silnika'])[0];
	
	
	echo '<table class="tab">';
	
	echo '<tr>';
	echo '<td class="row" colspan="3" >Zdjecie nalezy do uzytkownika o nicku: <b>'.
			"<a href='myAccount.php?ID_uzytkownika={$uzytkownik['ID_uzytkownika']}'>{$uzytkownik['nick']}</a>".
    	'</b><br>Zostalo dodane dnia: '.$pic['data_dodania'].'<br>'.
    	'Ocena samochodu to: <b>'.getOcena('Samochod',$pic['ID_samochodu']).
    	'</b></td></tr>';
		
	echo '<tr><td class="row" colspan="3">Zdjecie nalezy do samochodu marki: '.
			'<b>'.$marka['nazwa'].'</b></td>';
    echo '</tr>';
	echo '<td class="img"colspan="3"> <img src="'.$pic['url'].'" title="'.$pic['opis'].'" style="max-width:300px;max-height:300px;">'.
		'</td></tr>';
		
    
    echo '<tr>';
    if ( $user != NULL ) {
    	echo '<td class="row2" colspan="2">'.'Dodaj komentarz do samochodu: '.
	    	'<form action="/tryAddKomentarz.php?ID_zdjecia='.$pic['ID_zdjecia'].'" method="post">'.
    		'<textarea name="tresc" cols="60" rows="3"></textarea>'.'<br>'.
    		'<input type="submit">'.
    		'</form>'.
    		'</td>';
    	
    	// jesli to nie jset moj samochod
    	if ( !$user->actionSprawdzCzyMoje('Samochod',$samochod['ID_samochodu']) ) {
    		// to moge go ocenic! :D
    		
    		echo '<td>';
    		$tmp = db::query("select * from Ocena_samochodu where ID_uzytkownika = ".$user->getID().
    				' AND ID_samochodu = '.$samochod['ID_samochodu']);
    		if ( count($tmp) != 0 ) {
		    	echo 'Twoja ocena tego samochodu to: <b>'.$tmp[0]['wartosc'].'</b><br>';
    		}
    		echo '<a class = "ok2" href="tryOcenKomentarz.php?ocena=1&tabela=Samochod&id='.$samochod['ID_samochodu'].
	    		'">Ocen pozytywnie samochod</a>';
    		echo '<a class = "err2" href="tryOcenKomentarz.php?ocena=-1&tabela=Samochod&id='.$samochod['ID_samochodu'].
	    		'">Ocen negatywnie samochod</a>';
    		echo '</td>';
    	}
    }
    echo '</tr>';

    $komentarze = db::query('select * from Komentarz where ID_zdjecia = '.$pic['ID_zdjecia']
    		.' order by data_dodania desc');
    foreach($komentarze as $kom) {
    	echo '<tr>';
    	echo '<td>Komentarz uzytkownika: <br>'.
	    	db::query('select * from Uzytkownik where ID_uzytkownika = '.$kom['ID_uzytkownika'])[0]['nick'].
	    	'<br> dodany w dniu:<br>
			'.$kom['data_dodania'].
	    	'<br> Ocena komentarza: '.getOcena('Komentarz',$kom['ID_komentarza']).
	    	'</td>';
    	echo '<td  class="row3"><label class="label2"> Tresc komentarza: </label><br>'.$kom['tresc'].'</td>';
    	
    	echo '<td>';
    	if ( $user != NULL ) {
    		// jesli jestesmy adminem lub wlascicielem komentarza, to mozemy usunąć komentarz :D
    		if ( $user->czyAdmin() || $user->getID() == $kom['ID_uzytkownika'] ) {
    			echo '<a class="err2" href="tryUsunCokolwiek.php?tabela=Komentarz&id='.$kom['ID_komentarza'].'">'.
    				'Usun komentarz</a>';
    		}
    		// jesli to nie nasz komentarz, to możemy go ocenić
    		if ( $user->getID() != $kom['ID_uzytkownika'] ) {
    			// A moze juz ocenił?
    			$tmp = db::query("select * from Ocena_komentarza where ID_uzytkownika = ".$user->getID().
    					' AND ID_komentarza = '.$kom['ID_komentarza']);
    			if ( count($tmp) != 0 ) {
    				echo 'Twoja ocena to: '.$tmp[0]['wartosc'].'<br>';
    			}
    			echo '<a class = "ok2" href="tryOcenKomentarz.php?ocena=1&tabela=Komentarz&id='.$kom['ID_komentarza'].
    				'">Ocen pozytywnie komentarz</a>';
    			echo '<a class = "err2" href="tryOcenKomentarz.php?ocena=-1&tabela=Komentarz&id='.$kom['ID_komentarza'].
    				'">Ocen negatywnie komentarz</a>';
    		}
    	}
    	echo '</td>';
    	
    	echo '</tr>';
    }
    
	echo "</table>";
	echo "<br>";
}
?>
		
	</body>
</html>
