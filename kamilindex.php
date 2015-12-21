<?php
    session_start();
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Oce&#324;-bryke.pl</title>
		<link rel='stylesheet' type='text/css' href='style.css'>
		
		<script type='text/javascript'>
			function resizeUpdate()
			{
				iframe = document.getElementById('content_iframe');
				iframe.style.height = '0px';
				contentHeight = iframe.contentWindow.document.body.scrollHeight;
				iframe.style.height = contentHeight + 'px';
				wrapper = document.getElementById('wrapper');
				wrapper.style.height = '200px';
				wrapHeight = contentHeight + 50;
				wrapper.style.height = wrapHeight + 'px';
			}
		</script
	</head>
	<body id='main-body'>	

		<header>
			<h1 class='title'>Ocen-bryke.pl</h1>
		</header>

		<div id='wrapper'>
			<nav>

				<ul class='navbar'>
					<li class='navbar'>
						<div id='triangle-topright'></div>
					</li>
					<li class='navbar'>
						<a class='navbar_link' target='content_iframe' href='news.php' onClick="resizeUpdate()">
							Nowe
						</a>
					</li> <!-- TODO - to sie zmienia w zaleznosci czy zalogowany -->
					<li class='navbar'>
						<?php
							if(isset($_SESSION["loggedIn"])) 
							{ 
								echo "<a class='navbar_link' target='content_iframe' href='logout.php' onClick='resizeUpdate()'>
										Wyloguj<br>("; echo $_SESSION["name"]; echo ")
									</a>";
							} 
							else 
							{
								echo "<a class='navbar_link' target='content_iframe' href='login.php' onClick='resizeUpdate()'>
										Zaloguj
									</a>"; 
							}
						?>
					</li>
					<li class='navbar'>
						<a class='navbar_link' target='content_iframe' href='find.php' onClick="resizeUpdate()">
							Wyszukaj
						</a>
					</li>
					<li class='navbar'>
						<div id='triangle-topleft'></div>
					</li>
				</ul>

			</nav>
			<article>
				<iframe id='content_iframe' name='content_iframe' src='news.php' onLoad="resizeUpdate()"></iframe>
			</article>


		</div>
	</body>
</html>



