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
        <h1>jestem tryFind.php</h1>
<?php
if ( !isset($_POST['rodzaj']) ) {
	echo '$_POST[rodzaj]<BR>';
	exit(0);
}
db::setDebug(10);
switch($_POST['rodzaj']) {
	case 'Uzytkownik':
		$rows=db::query("select * from Uzytkownik where nick like '%".db::escape($_POST['nick'])."%';");
		//print_r($rows); echo "<BR>";
		foreach($rows as $row) {
			//print_r($row); echo "<BR>";
			echo "<article>
					<iframe id='content_iframe' name='content_iframe' 
						src='myAccount.php?ID_uzytkownika=".$row['ID_uzytkownika']."' onLoad='resizeUpdate()'>
					</iframe>
				</article>";
		}
		break;
	case 'Samochod':
		$str=null;
		if ( $_POST['ID_marki'] != -1 ) {
			if ( $str != null ) { $str .= 'AND'; }
			$str .= " ID_marki = '".$_POST['ID_marki']."' ";
		}
		if ( $_POST['ID_modelu'] != -1 ) {
			if ( $str != null ) { $str .= 'AND'; }
			$str .= " ID_modelu = '".$_POST['ID_modelu']."' ";
		}
		if ( $_POST['ID_wersji'] != -1 ) {
			if ( $str != null ) { $str .= 'AND'; }
			$str .= " ID_wersji = '".$_POST['ID_wersji']."' ";
		}
		if ( $_POST['ID_silnika'] != -1 ) {
			if ( $str != null ) { $str .= 'AND'; }
			$str .= " ID_silnika = '".$_POST['ID_silnika']."' ";
		}
		if ( $_POST['ID_uzytkownika'] != -1 ) {
			if ( $str != null ) { $str .= 'AND'; }
			$str .= " ID_uzytkownika = '".$_POST['ID_uzytkownika']."' ";
		}
		if ( $str != null ) {
			$str = ' WHERE '.$str;
		}
		echo $str."<BR>";
		
		$rows=db::query('SELECT * FROM Samochod '.$str.' ORDER BY ID_uzytkownika;');
		foreach($rows as $row) {
			//print_r($row); echo "<BR>";
			echo "<article>
					<iframe id='content_iframe' name='content_iframe'
						src='myCars.php?ID_samochodu=".$row['ID_samochodu']."' onLoad='resizeUpdate()'>
					</iframe>
				</article>";
		}
		break;
}
?>


    </body>
</html>

