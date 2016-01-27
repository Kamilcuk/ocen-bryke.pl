<?php
	require_once('user.inc');
	session_start();
?>
<html>
	<?php require_once('verify.inc'); ?>
    <head>
        <title>Oce&#324;-bryke.pl</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
    </head>
    <body class='frame'>
<br>
		<?php
			// Kamil Cukrowski, poprzedni plik jest w kamil/test/tryUpload.php <- ta linia do wykasowania jest
			function fatal($str) {
				echo $str.'<br>';
				exit -1;
			}
			if ( !isset($_GET["ID_samochodu"]) ) {
				fatal('Nie podano ID_samochodu do zdjecia');
			}
			if ( !isset($_POST["Zdjecie_opis"]) ) {
				fatal('Nie podano Zdjecie_opis do zdjecia');
			}
			require_once('kamil/imageUpload.php');
			$ret = upload_image($user, $_GET["ID_samochodu"], 
					$_FILES["uploadedFile"], $_POST['Zdjecie_opis']);
			if ( !is_numeric($ret) ) {
				fatal('Upload zdjecia nieudany!');
			}
			echo 'Upload zdjecia udany! <BR>';
			
			echo "Za chwile nastapi przekierowanie...<script type='text/javascript'>
	setTimeout(function() {
		window.parent.location.href = window.parent.location.href;
	}, 500);</script>";
		?>

    </body>
</html>

	



