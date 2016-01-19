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
		<h1>jestem test2.php</h1>
<?php
if ( !isset($_GET['proste'] ) {
	echo 'cos nie tak!<BR>';
	exit(0);
}
if ( $_GET['proste'] == 1 ) {
	$pole = db::escape( $_POST['POLE'] );
	db::query('select ')
}
?>
	</body>
</html>
