<?php
	session_start();
?>
<html>
	<head>
        <title>Oce&#324;-bryke.pl</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
	</head>
	<body class='frame'>
<br>
    <div class='Login'>		
		<form action="/tryLogin.php" method="post">
		<table><tr><td>
		<label for="inp">Twój nick:</label>
		</td><td> 
		<input type="text" name="name">
		</td></tr><tr><td>
		<label for="inp">Hasło:</label>
		</td><td>
		<input type="password" name="pass">
		</td></tr><tr><td>
		<input type="submit" value='Zaloguj'>
		</td></tr></table>
		</form>
		<a class='link' target='content_iframe' 
			href='register.php' onClick="resizeUpdate()">
			Zarejestruj
		</a>	
	</div>
		
	</body>
</html>
