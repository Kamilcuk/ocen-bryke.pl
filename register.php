<?php
	session_start();
?>
<html>
	<head>
		<title>Nowosci</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
	</hed>
	<body class='frame'>
        <h1>jestem register.php</h1>
	<div class="Login">	
		<form action="/tryRegister.php" method="post">
		<label for="inp">Nazwa użytkownika:</label>   <input type="text" name="name"><br>
		<label for="inp">e-mail: </label>  <input type="text" name="email"><br>
		<label for="inp">Hasło (min 8 znaków):</label> <input type="password" name="pass"><br>
		<label for="inp">Powtórz hasło:</label> <input type="password" name="passR"><br><br>
		<input type="submit">
		</form>
	</div>	
	</body>
</html>
