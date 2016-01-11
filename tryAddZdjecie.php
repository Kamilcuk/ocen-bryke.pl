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
        <h1>jestem tryAddZdjecie.php</h1>

		<?php
			// Kamil Cukrowski, poprzedni plik jest w kamil/test/tryUpload.php <- ta linia do wykasowania jest
			require_once('kamil/imageUpload.php');
			$ret = upload_image($user, $_POST["ID_samochodu"], $_FILES["uploadedFile"]);
			if ( !is_numeric($ret) ) {
				echo 'Upload nieudany! <BR>';
			} else {
				echo 'Upload udany! <BR>';
			}
		?>

    </body>
</html>

	



