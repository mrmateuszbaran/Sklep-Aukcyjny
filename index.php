<?php
	require_once("uzytkownik.inc");
	session_start();
	require_once("baza.php");
	
	if (!isset($_SESSION['init']))
	{
		session_regenerate_id();
		$_SESSION['init'] = $_SERVER['REMOTE_ADDR'];
	}
	
	if ($_GET['strona'] == "logout")
	{
		unset($_COOKIE['sklep-login']);
		setcookie('sklep-login', null, -1, '/');
		unset($_SESSION['uzytkownik']);
		header("Location: index.php");
	}
	
	if (isset($_COOKIE['sklep-login']))
	{
		$user = $_COOKIE['sklep-login'];
		$zapytanie = mysql_query("SELECT * FROM uzytkownicy WHERE login = '$user'");
		$rezultat = mysql_fetch_array($zapytanie);
		$adres = "null";
		$_SESSION['uzytkownik'] = new Uzytkownik($rezultat['login'], $rezultat['imie'], $rezultat['nazwisko'], $adres, $rezultat['email'], 
															$rezultat['haslomd5'], $rezultat['kredyty'], $rezultat['poziom']);
	}
	
	if (isset($_SESSION['error']))
	{
		$errors = explode(";", $_SESSION['error']);
		foreach ($errors as $error)
		{
			echo "<script>okno_informacji('".$error."');</script>";
		}
		unset($_SESSION['error']);
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

<body onLoad = "init();">

	<div id = "kontener">
		<a href = "index.php">
			<div id = "logo"></div>
		</a>
			
		<div id = "login_box">
			<?php
				include "login_box.php";
			?>
		</div>

		<div id = "menu">
			<?php 
				include "menu.php";
			?>
		</div>

		<div id = "kategorie">
			<span class = "klikalne" onClick = "tresc('aukcje');"> Wszystko </span>
			<div style = "border:1px rgba(0,0,0,0.25) solid; width:0px; margin:0px 2px 0px 5px; line-height:47px;"> &nbsp; </div>
			<span class = "klikalne" onClick = "tresc('aukcje', 'Elektronika');"> Elektronika </span>
			<div style = "border:1px rgba(0,0,0,0.25) solid; width:0px; margin:0px 2px 0px 2px; line-height:47px;"> &nbsp; </div>
			<span class = "klikalne" onClick = "tresc('aukcje', 'Odzież');"> Odzież </span>
			<div style = "border:1px rgba(0,0,0,0.25) solid; width:0px; margin:0px 2px 0px 2px; line-height:47px;"> &nbsp; </div>
			<span class = "klikalne" onClick = "tresc('aukcje', 'AGD');"> AGD </span>
			<div style = "border:1px rgba(0,0,0,0.25) solid; width:0px; margin:0px 2px 0px 2px; line-height:47px;"> &nbsp; </div>
			<span class = "klikalne" onClick = "tresc('aukcje', 'Drogiazgi');"> Drobiazgi </span>
			
			<span class = "klikalne" style = "float:right;" onClick = "tresc('kredyty');"> Kredyty </span>
			<div style = "border:0px; box-shadow:1px 0px 1px #2a586d, 2px 0px 2px #2a586d; width:1px; margin-right:3px; line-height:48px; float:right;"> &nbsp; </div>
		</div>

		<div id = "tresc">
			<script>tresc('aukcje');</script>
		</div>
	</div>
	<div id = "stopka">
		Sklep aukcyjny @ 2015<br> Mateusz Baran, Piotr Frey, Sylwia Jakubas, Bartosz Klink, Andrzej Lekki 
	</div>
</body>

</html>