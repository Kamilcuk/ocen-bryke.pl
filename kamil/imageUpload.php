<?php
require_once('settings.inc');
require_once('db.inc');
require_once('user.inc');
require_once('szukaj.inc');
/**
 * Uploaduje zdjęcie do folderu danego w $settings['imageUploadDir']
 * @param unknown $user object user, musi być zalogowany
 * @param unknown $ID_samochodu zdjęcie dotyczy jakiegoś samochodu
 * @param unknown $_FILE zmienna zwraca przez php -> $_FILES['twojStringWIpucieWHTMLu']
 * @return positive non-zero numeric on success, reszta on false
 */
function upload_image($user=null, $ID_samochodu=null, $_FILE=null, $opis="") {

	// config
	global $settings;
	$debug = $settings['debug'];
	$imageUploadDir = $settings['imageUploadDir']; 
	// koniec configu

	// based on http://www.w3schools.com/php/php_file_upload.asp
	if ( $user == null || $ID_samochodu == null || $_FILE == null ) {
		echo __FILE__.__LINE__." złe parametry <BR>";
		return;
	}
	if ( !is_object($user) ) {
		echo __FILE__.__LINE__." złe parametry <BR>";
		return;
	}
	if ( !is_array($_FILE) ) {
		echo __FILE__.__LINE__." złe parametry <BR>";
		return;
		
	}
	if ( !is_numeric($ID_samochodu) ) {
		echo __FILE__.__LINE__." złe parametry ID_samochodu=".$ID_samochodu." <BR>";
		return;	
	}
	
	if ( !$user->zalogowany || !is_string($user->nick) ) {
		echo __FILE__.__LINE__.":user nie jest zalogowany<br>";
		return;
	}
	$imageFileType = pathinfo($_FILE["name"], PATHINFO_EXTENSION);
	$imageSize = getimagesize($_FILE["tmp_name"]);
	//$targetFile = tempnam($targetDir, $user->nick."_").".".$imageFileType;
	// if ( dirname($targetFile) ==  sys_get_temp_dir() ) { return; }

	if ( !is_writable($imageUploadDir) ) {
		echo __FILE__.__LINE__."target dir jest nie writable <br>";
		return;
	}
	if ( !$imageSize ) {
		echo __FILE__.__LINE__."To nie jest fotka.<br>";
		return;
	}
	if( !preg_match("/jpg|png|jpeg|jpe|gif/i", $imageFileType) ) {
		echo __FILE__.__LINE__."Dozwolne typy plikow to jpg, png, jpe, gif.<br>";
		return;
	}
	if($_FILE["size"] > 500000) {
		echo __FILE__.__LINE__."Plik zbyt duzy (max 500 kb).<br>";
		return;
	}
	// sprawdź czy to jest samochód tego użytkownika
	$rows = szukaj(array("Samochod:ID_samochodu:".$ID_samochodu.":ID_uzytkownika:".$user->getId()));
	if ( sizeof($rows) != 1 ) {
		echo "Dany użytkownik o ID_uzytkownika: ".$user->getId()." nie posiada samochodu ";
		echo " o ID_samochodu równym ".$ID_samochodu."<br>";
		return;
	}
	
	// ALL OK, możemy w końcu coś zrobić
	// dodajemy zdjęcie z tymczasowym położeniem do bazy danych przez usera
	$tmpName = $_FILE["tmp_name"]; // aktualne tmp położenie naszego zdjęcia
	$ret = $user->actionDodaj("Zdjecie", array(
			"ID_samochodu" => $ID_samochodu, 
			"URL" => $tmpName,
			"opis" => $opis,
	));
	if ( $ret == false ) {
		echo __FILE__.__LINE__."Error w dodawaniu zdjęcia przy user->actionDodaj";
		return false;
	}
	if ( $debug ) {
		echo __FILE__.__LINE__."<br>";
		print_r(szukaj(array("Zdjecie:ID_samochodu:".$ID_samochodu.":URL:".$tmpName)));
		echo "<br>";
	}
	
	// pobierz id zdjęcie tego cośmy go wgrali przed chwilą
	$ID_zdjecia = szukaj(array("Zdjecie:ID_samochodu:".$ID_samochodu.":URL:".$tmpName))[0]["ID_zdjecia"];
	if ( !isset($ID_zdjecia) ) {
		echo __FILE__.__LINE__."Cos zajebiscie nie tak! ID_zdjecia nie istnieje! <br>";
		print_r(szukaj(array("Zdjecie:ID_samochodu:".$ID_samochodu.":URL:".$targetFile)));
		return false;
	}
	
	// tworzymy nazwy plików w odniesieniu do katalogu root i katalogu www zawierające ID_zdjiecia
	$targetFileRoot = $imageUploadDir.$user->nick."_".$ID_zdjecia.".".$imageFileType;
	$targetFile = str_replace('/srv/http/', '', $targetFileRoot);
	// uploadujemy plik
	if( !move_uploaded_file($_FILE["tmp_name"], $targetFileRoot) ) {
		echo __FILE__.__LINE__."Wystapil problem podczas wrzucania fotki :(<br>";
		$user->actionUsun("Zdjecie", $ID_zdjecia);
		return false;
	}
	// updatujemy baze danych z prawidłowym linkiem
	if ( !db::query("UPDATE Zdjecie set `URL` = '".$targetFile."' where `ID_zdjecia` = '".$ID_zdjecia."'") ) {
		echo __FILE__.__LINE__."dbquery2 error ? nie wiem jaki URL zdjecia = ".$targetFile."<br>";
		$user->actionUsun("Zdjecie", $ID_zdjecia);
		return false;
	}
	if ( $debug ) {
		echo "Fotka ".basename($_FILE["name"])." <br>";
		echo " zostala wrzucona jako url w bazie : ".$targetFile." jako plik w ".$targetFileRoot."<BR>";
		echo " zapisana w bazie danych: <BR>";
		print_r(szukaj(array("Zdjecie:ID_samochodu:".$ID_samochodu.":URL:".$targetFile)));
	}
	return $ID_zdjecia;
}
?>
