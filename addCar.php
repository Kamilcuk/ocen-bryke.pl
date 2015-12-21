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
		<h1>jestem addCar.php</h1>
		
		 <form action="/tryAddCar.php" method="post">
		<table>
			<tr><td><label for="inp">Marka:</label></td>
			<td><select name="Marka">
				<option selected="selected">Fiat</option>
				<option>FSO</option>
				<option>Łada</option>
			<option>Inny</option>
			</select></td></tr>
		 <tr><td><label for="inp">Model:</label></td>
			<td><select name="Model">
				<option selected="selected">126p</option>
				<option>dupa</option>
				<option>dupa</option>
			<option>Inny</option>
			</select></td></tr>
		<tr><td><label for="inp">Typ nadwozia:</label></td>
			<td><select name="Marka">
				<option selected="selected">Coupe</option>
				<option>dupa</option>
				<option>dupa</option>
			<option>Inny</option>
			</select></td></tr>
		
		<tr><td><label for="inp">Silnik:</label></td></tr>
		
		<tr><td><label for="inp">Pojemność:</label></td>
			<td><select name="Marka">
				<option selected="selected">1100 cm^3</option>
				<option>dupa</option>
				<option>dupa</option>
			<option>Inny</option>
			</select></td></tr>
		<tr><td><label for="inp">Zasilanie:</label></td>
			<td><select name="Marka">
				<option selected="selected">Hybryda</option>
				<option>dupa</option>
				<option>dupa</option>
			<option>Inny</option>
			</select></td></tr>	
		<tr><td><label for="inp">Moc:</label></td>
			<td><select name="Marka">
				<option selected="selected">210 KM</option>
				<option>dupa</option>
				<option>dupa</option>
			<option>Inny</option>
			</select></td></tr>	
		<tr><td><label for="inp">Symbol:</label></td>
			<td><select name="Marka">
				<option selected="selected">dupa</option>
				<option>dupa</option>
				<option>dupa</option>
			<option>Inny</option>
			</select></td></tr>
			<tr><td><input type="submit" value="Dodaj auto"></td></tr>
		</table>
		</form>	
		
	</body>
</html>
