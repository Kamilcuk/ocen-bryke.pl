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
        <h1>jestem tryUpload.php</h1>

		<?php
			// based on http://www.w3schools.com/php/php_file_upload.asp

			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["uploadedFile"]["name"]);
			$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

			$uploadOK = 1;
			if(isset($_POST["submit"]))
			{
				$check = getimagesize($_FILES["uploadedFile"]["tmp_name"]);
				if(!$check)
				{
					echo "To nie jest fotka.<br>";
					$uploadOK = 0;
				}
			}
			if(file_exists($target_file))
			{
				echo "Plik juz istnieje.<br>";
				$uploadOK = 0;
			}
			if($_FILES["uploadedFile"]["size"] > 500000)
			{
				echo "Plik zbyt duzy (max 500 kb).<br>";
				$uploadOK = 0;
			}
			if($imageFileType!="jpg" && $imageFileType!="png" && $imageFileType!="jpeg" && $imageFileType!="gif")
			{
				echo "Dozwolne typy plikow to jpg, png, jpe, gif.<br>";
				$uploadOK = 0;
			}

			if($uploadOK==0)
			{
				echo "Upload nieudany :(<br>";
			}
			else
			{
				if(move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $target_file))
				{
					echo "Fotka " . basename($_FILES["uploadedFile"]["name"]) . " zostala wrzucona!";
				}
				else
				{
					echo "Wystapil problem podczas wrzucania fotki :(<br>";
				}
			}
		?>

    </body>
</html>

