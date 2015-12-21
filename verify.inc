<?php
	if(isset($_SESSION["user"]))
	{
		$user = $_SESSION["user"];

		if(!$user->zweryfikujLogin())
		{
			header("Location: logout.php");
			die();
		}
	}
	else
	{
		header("Location: logout.php");
		die();
	}
?>
