<?php
	require_once('user.inc');
	session_start();
?>
<html>
    <head>
        <title>Oce&#324;-bryke.pl</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
                <script type='text/javascript'>
                function resizeUpdate(index)
                {
                       parent_iframe = parent.document.getElementById('content_iframe');
                       parent_doc = parent_iframe.contentDocument || parent_iframe.contentWindow.document;
                       iframe = parent_doc.getElementById('content_iframe_' + index);

                       iframe.style.height = '0px';
                       contentHeight = iframe.contentWindow.document.body.scrollHeight;
                       iframe.style.height = contentHeight + 'px';
                       wrapper = parent_doc.getElementById('wrapper_' + index);
                       wrapper.style.height = '100px';
                       wrapHeight = contentHeight + 10;
                       wrapper.style.height = wrapHeight + 'px';
                }
                </script>
    </head>
    <body class='frame'>
<br>
<?php
if ( !isset($_POST['rodzaj']) ) {
	//echo "_POST[rodzaj] = '{$_POST['rodzaj']}' <BR>";
	przekierowanie(500);
	exit(0);
}
//db::setDebug(10); echo 'POST[rodzaij] = '.$_POST['rodzaj'].'<BR>';
switch($_POST['rodzaj']) {
	case 'Uzytkownik':
		$rows=db::query("select * from Uzytkownik where nick like '%".db::escape($_POST['nick'])."%';");
		//print_r($rows); echo "<BR>";
		$i = 0;
		foreach($rows as $row) {
			//print_r($row); echo "<BR>";
			echo "<article id='wrapper_$i'>
					<iframe id='content_iframe_$i' name='content_iframe'
						src='myAccount.php?ID_uzytkownika=".$row['ID_uzytkownika']."' onLoad='resizeUpdate($i)'>
					</iframe>
				</article>";
			$i = $i + 1;
		}
		break;
	case 'Samochod':
		$str=null;
		$innerjoin=null;
		$innerjoin .= ' inner join Wersja on Wersja.ID_wersji = Samochod.ID_wersji
				inner join Model on Model.ID_modelu = Wersja.ID_modelu
				inner join Marka on Marka.ID_marki = Model.ID_marki 
				inner join Silnik on Silnik.ID_silnika = Samochod.ID_silnika ';
		if ( $_POST['ID_uzytkownika'] != -1 ) {
			if ( $str != null ) { $str .= 'AND'; }
			$str .= " Samochod.ID_uzytkownika = '".db::escape($_POST['ID_uzytkownika'])."' ";
		}
		if ( $_POST['Marka_nazwa'] != -1 ) {
			if ( $str != null ) { $str .= 'AND'; }
			$str .= " Marka.nazwa = '".db::escape($_POST['Marka_nazwa'])."' ";
		}
		if ( $_POST['ID_modelu'] != -1 ) {
			if ( $str != null ) { $str .= 'AND'; }
			$str .= " Samochod.ID_modelu = '".db::escape($_POST['ID_modelu'])."' ";
		}
		if ( $_POST['Wersja_nazwa'] != -1 ) {
			if ( $str != null ) { $str .= 'AND'; }
			$str .= " Wersja.nazwa = '".db::escape($_POST['Wersja_nazwa'])."' ";
		}
		if ( $_POST['Silnik_symbol'] != -1 ) {
			if ( $str != null ) { $str .= 'AND'; }
			$str .= " Silnik.symbol = '".db::escape($_POST['Silnik_symbol'])."' ";
		}
		if ( $_POST['Silnik_pojemnosc'] != -1 ) {
			if ( $str != null ) { $str .= 'AND'; }
			$str .= " Silnik.pojemnosc = '".db::escape($_POST['Silnik_pojemnosc'])."' ";
		}
		if ( $_POST['Silnik_zasilanie'] != -1 ) {
			if ( $str != null ) { $str .= 'AND'; }
			$str .= " Silnik.zasilanie = '".db::escape($_POST['Silnik_zasilanie'])."' ";
		}
		if ( $_POST['Silnik_moc'] != -1 ) {
			if ( $str != null ) { $str .= 'AND'; }
			$str .= " Silnik.moc = '".db::escape($_POST['Silnik_moc'])."' ";
		}
		if ( $str != null ) {
			$str = ' WHERE '.$str;
		}
		//echo $str."<BR>";
		$rows=db::query('SELECT ID_samochodu FROM Samochod '.$innerjoin.' '.$str.' ORDER BY ID_uzytkownika;');
		$i = 0;
		foreach($rows as $row) {
			//print_r($row); echo "<BR>";
			echo "<article id='wrapper_$i'>
					<iframe id='content_iframe_$i' name='content_iframe'
						src='myCars.php?ID_samochodu=".$row['ID_samochodu']."' onLoad='resizeUpdate($i)'>
					</iframe>
				</article>";
			$i = $i + 1;
		}
		break;
}
?>


    </body>
</html>

