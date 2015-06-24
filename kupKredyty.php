<?php
	require_once "uzytkownik.inc";
	session_start();
	
	if (!isset($_SESSION['uzytkownik']))
	{
		echo "ERROR:Brak uprawnień!";
		exit();
	}
	
	require_once "baza.php";
	
	$ile = $_GET['ile'];
	$kredyty = mysql_fetch_row(mysql_query("SELECT kredyty FROM uzytkownicy WHERE login = '".$_SESSION['uzytkownik']->login."'"));
	
	mysql_query("UPDATE uzytkownicy SET kredyty = '".($kredyty+$ile)."' WHERE login = '".$_SESSION['uzytkownik']->login."'") or die(mysql_error());
	$_SESSION['uzytkownik']->kredyty = ($kredyty + $ile);
	
	echo "sukces";
	
?>