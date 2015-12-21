<?php
require_once('db.inc');
require_once('user.inc');
require_once('szukaj.inc');
function upload_image($user=null, $ID_samochodu=null, $_FILE=null) {

	// config
	$targetDir = "/srv/http/uploads/images/";
	// koniec configu

	// based on http://www.w3schools.com/php/php_file_upload.asp
	global $settings;
	$debug = $settings['debug'];
	if ( $user == null || $ID_samochodu == null || $_FILE == null ) {
		echo __FILE__.__LINE__." złe parametry <BR>";
		return;
	}
	if ( !is_object($user) || !is_array($_FILE) || !is_numeric($ID_samochodu) ) {
		echo __FILE__.__LINE__." złe parametry <BR>";
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

	if ( !is_writable($targetDir) ) {
		echo __FILE__.__LINE__."target dir jest nie writable <br>";
		return;
	}
	if ( !$imageSize ) {
		echo __FILE__.__LINE__."To nie jest fotka.<br>";
		return;
	}
	if($imageFileType!="jpg" && $imageFileType!="png" && $imageFileType!="jpeg" && $imageFileType!="gif") {
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
	$tmpName = $_FILE["tmp_name"]; // aktualne tmp położenie naszego zdjęcia
	$ret = $user->actionDodaj("Zdjecie", array("ID_samochodu" => $ID_samochodu, "URL" => $tmpName));
	if ( $ret == false ) {
		echo __FILE__.__LINE__."Error w dodawaniu zdjęcia przy user->actionDodaj";
		return;
	}
	echo "<br>";print_r(szukaj(array("Zdjecie:ID_samochodu:".$ID_samochodu.":URL:".$tmpName)));echo "<br>";
	$ID_zdjecia = szukaj(array("Zdjecie:ID_samochodu:".$ID_samochodu.":URL:".$tmpName))[0]["ID_zdjecia"];
	if ( !isset($ID_zdjecia) ) {
		echo "Cos zajebiscie nie tak! ID_zdjecia nie istnieje! <br>";
		print_r(szukaj(array("Zdjecie:ID_samochodu:".$ID_samochodu.":URL:".$targetFile)));
		return;
	}
	$targetFileRoot = $targetDir.$user->nick."_".$ID_zdjecia.".".$imageFileType;
	$targetFile = str_replace('/srv/http/', '', $targetFileRoot);
	if( !move_uploaded_file($_FILE["tmp_name"], $targetFileRoot) ) {
		echo "Wystapil problem podczas wrzucania fotki :(<br>";
		$user->actionUsun("Zdjecie", $ID_zdjecia);
		return;
	}
	if ( !db::query("UPDATE Zdjecie set `URL` = '".$targetFile."' where `ID_zdjecia` = '".$ID_zdjecia."'") ) {
		echo "dbquery2 error ? nie wiem jaki URL zdjecia = ".$targetFile."<br>";
		$user->actionUsun("Zdjecie", $ID_zdjecia);
		return;
	}
	if ( $debug ) {
		echo "Fotka ".basename($_FILE["name"])." <br>";
		echo " zostala wrzucona jako url w bazie : ".$targetFile." jako plik w ".$targetFileRoot."<BR>";
		echo " zapisana w bazie danych: <BR>";
		print_r(szukaj(array("Zdjecie:ID_samochodu:".$ID_samochodu.":URL:".$targetFile)));
	}
	return $ID_zdjecia;
}
/*print_r($_FILES);
print_r($_FILES);
$user = new user("kamil", "kamil");
echo "<br>\n";
$ID_zdjecia = upload_image($user, $_POST["ID_samochodu"], $_FILES["uploadedFile"]);*/
?>
