<?php
	session_start();
?>
<html>
	<head>
        <title>Oce&#324;-bryke.pl</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
	</hed>
	<body class='frame'>
        <h1>jestem login.php</h1>
    <div class='Login'>		
		<form action="/tryLogin.php" method="post">
		<label for="inp">Twój nick:</label> 
		<input type="text" name="name"><br>
		<label for="inp">Hasło:</label>
		<input type="password" name="pass"><br><br>
		<input type="submit"><br><br>
		</form>
	<a class='link' target='content_iframe' 
		href='register.php' onClick="resizeUpdate()">
		Zarejestruj
	</a>	
		
	</body>
</html>
