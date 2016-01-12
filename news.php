<?php
	require_once('user.inc');
    session_start();
?>
<html>
	<?php require_once('verify_easy.inc'); ?>
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
	echo '<table border="1" style="border: 1px solid black">';
	
	echo '<tr>';
	$uzytkownik = db::query('select * from Uzytkownik where ID_uzytkownika = '.$pic['ID_uzytkownika'])[0];
	$samochod = db::query('select * from Samochod where ID_samochodu = '.$pic['ID_samochodu'])[0];
	echo '<td><img src="'.$pic['url'].'" title="'.$pic['opis'].'" style="width:100px;height:100px;">'.
		'</td>';
    echo '<td>Zdjecie nalezy do uzytkownika o nicku: <br>'.$uzytkownik['nick'].
    	'<br>Zostalo dodane dnia:<br>'.$pic['data_dodania'].'<br>'.
    	'Ocena samochodu to: '.
    		db::query('select SUM(wartosc) as t from Ocena_samochodu where ID_samochodu = '.$samochod['ID_samochodu'])[0]['t'].
    	'</td>';
    echo '<td>Zdjecie nalezy do samochodu marki: <br>'.
    	db::query('select * from Marka where ID_marki = '.$samochod['ID_marki'])[0]['nazwa'].
    	'</td>';
    echo '</tr>';
    
    echo '<tr>';
    if ( $user != NULL ) {
    	echo '<td>'.'Dodaj komentarz do samochodu: '.
	    	'<form action="/tryAddKomentarz.php?ID_zdjecia='.$pic['ID_zdjecia'].'" method="post">'.
    		'<textarea name="tresc" cols="40" rows="2"></textarea>'.
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
		    	echo 'Twoja ocena tego samochodu to: '.$tmp[0]['wartosc'].'<br>';
    		}
    		echo '<a href="tryOcenKomentarz.php?ocena=1&tabela=Samochod&id='.$samochod['ID_samochodu'].
	    		'">Ocen pozytywnie samochod</a><br>';
    		echo '<a href="tryOcenKomentarz.php?ocena=-1&tabela=Samochod&id='.$samochod['ID_samochodu'].
	    		'">Ocen negatywnie samochod</a><br>';
    		echo '</td>';
    	}
    }
    echo '</tr>';

    $komentarze = db::query('select * from Komentarz where ID_zdjecia = '.$pic['ID_zdjecia']
    		.' order by data_dodania desc');
    foreach($komentarze as $kom) {
    	echo '<tr>';
    	echo '<td>Komentarz uzytkownika: '.
	    	db::query('select * from Uzytkownik where ID_uzytkownika = '.$kom['ID_uzytkownika'])[0]['nick'].
	    	'<br> dodany w dniu: '.$kom['data_dodania'].
	    	'<br> Ocena komentarza: '.
	    		db::query('select SUM(wartosc) as t from Ocena_komentarza where ID_komentarza = '.$kom['ID_komentarza'])[0]['t'].
	    	'</td>';
    	echo '<td>Tresc komentarza: <br>'.$kom['tresc'].'</td>';
    	
    	echo '<td>';
    	if ( $user != NULL ) {
    		if ( $user->getID() == $kom['ID_uzytkownika'] ) {
    			// to jest komentarz tego uzytkownika
    			// moze go usunac
    			echo '<a href="tryUsunCokolwiek.php?tabela=Komentarz&id='.$kom['ID_komentarza'].'">'.
    				'Usun swoj komentarz</a>';
    		} else {
    			// to nie jest komentarz zalogowanego uzytkownika
    			// moze go ocenic
    			// A moze juz ocenił?
    			$tmp = db::query("select * from Ocena_komentarza where ID_uzytkownika = ".$user->getID().
    					' AND ID_komentarza = '.$kom['ID_komentarza']);
    			if ( count($tmp) != 0 ) {
    				echo 'Twoja ocena tego komentarza to: '.$tmp[0]['wartosc'].'<br>';
    			}
    			echo '<a href="tryOcenKomentarz.php?ocena=1&tabela=Komentarz&id='.$kom['ID_komentarza'].
    				'">Ocen pozytywnie komentarz</a><br>';
    			echo '<a href="tryOcenKomentarz.php?ocena=-1&tabela=Komentarz&id='.$kom['ID_komentarza'].
    				'">Ocen negatywnie komentarz</a><br>';
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
