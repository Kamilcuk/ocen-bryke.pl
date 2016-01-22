<?php
// zadaniem tego pliku jest sprawdzenie czy uzytkownik jest zalogowany
// tzn ten plik mozna requierowac kiedy moze uzytkownik jest zalogowany a moze nie jest
	if(isset($_SESSION["user"]))
	{
		$user = $_SESSION["user"];

		if(!$user->zweryfikujLogin())
		{
			header("Location: logout.php");
			die();
		}
	} else {
		$user = NULL;
	}
?>
