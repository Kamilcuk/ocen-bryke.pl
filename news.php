<?php
	require_once('user.inc');
    session_start();
?>
<html>
	<head>
        <title>Oce&#324;-bryke.pl</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
	</head>
	<body class='frame'>
		<h1>jestem news.php</h1>
		CO JEST DO ZROBIENIA:

	<br>CUKIER
		<ul>
		<li> poprawic uprawnienia do folderu /uploads/ (wymaga to sudo, wiec ja nie moge); obecnie jest
		777 ale to nie jest dobre ofc.
http://stackoverflow.com/questions/25422366/php-move-uploaded-file-permission-denied-permission-set-to-755
		w skrocie chown ten folder na php usera i daj mu 755
		<li> w tryUpload.php trzeba dodac query ktory dodaje fotke do samochodu po nazwie czy jak tam 
chcesz
		<li> wlasciwie to skrypt powinien sam nadawac zdjeciom nazwy na podstawie ostatniego ID_zdjecia w 
tabeli
		</ul>

	<br>PATRYK
		<ul>
		<li> no trzeba te wszystkie pliki .php jakos poladnic bo sa brzydkie
		<li> jesli jakas stronka ma wymagac tego ze user jest zalogowany, to zostaw w niej
		require_once('verify.inc'); jesli nie ma tego wymagac to ta linijke usun.
		<li> no i cala reszta ofc do zrobienia
		</ul>

		
		
	</body>
</html>
