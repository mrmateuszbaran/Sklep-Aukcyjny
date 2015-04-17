 <?php
	session_start();
	//session_destroy();
	//session_unset();
	
	print_r($_SESSION);

	if (!isset($_SESSION['init']))
	{
		session_unset();
		session_regenerate_id();
		$_SESSION['init'] = $_SERVER['REMOTE_ADDR'];
		print_r($_SESSION);
	}

?> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel = "stylesheet" type = "text/css" href = "styl.css">
	<script src = "funkcje.js" type = "text/javascript"></script>
	<title>Projekt ISI - Sklep Aukcyjny</title>
</head>

<body>

<div id = "naglowek">
	<a href = "/" id = "logo">Strona główna</a>
	<ul>
		<a href = "#"> <li> Info </li> </a>
		<?php 
			if (!isset($_SESSION['login']))
			{
				echo "<a href = \"#\" onClick = \"toggle_login_box();\"> <li> Zaloguj </li> </a>";
				echo "<a href = \"?strona=rejestracja\"> <li> Zarejestruj </li> </a>";
			} else
				echo "<a href = \"login.php\"> <li> Wyloguj &lt;".$_SESSION['login']."&gt; </li> </a>";
		?>
	</ul>
</div>
	
<div id = "login_box">
	<form name = "form_login" method = "POST" action = "login.php">
		Login: <input name = "login"><br>
		Hasło: <input type = "password" name = "haslo"><br>
		Pamiętaj mnie <input type = "checkbox" name = "pamietaj">
		<input type = "submit" value = "Zaloguj się"><br>
	</form>
</div>

<div id = "menu">
	<ul>
		<li> <a href = "/"> Wszystko </a> </li>
		<li> <a href = "#"> Elektronika </a> </li>
		<li> <a href = "#"> Sprzęt AGD </a> </li>
		<li> <a href = "#"> Drobiazgi </a> </li>
		<li> <a href = "#"> Super okazje </a> </li>
	</ul>
</div>

<div id = "tresc">
<?php
	switch ($_GET['strona'])
	{
		case "logowanie": 
		case "rejestracja":
			include ($_GET['strona'].".php");
			break;
		default: 
			include "przedmioty.php";
	}
?>
</div>	<!-- TRESC -->

</body>

</html>