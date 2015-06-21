<?php
	require_once "../uzytkownik.inc";
	session_start();
	
	if (!isset($_SESSION['uzytkownik']))
	{
		echo "ERROR:Brak uprawnień!";
		exit();
	}
	
	require_once "../baza.php";
	
	$stare = mysql_real_escape_string($_GET['stare']);
	$nowe = mysql_real_escape_string($_GET['nowe']);
	if (mysql_num_rows(mysql_query("SELECT * FROM uzytkownicy WHERE login = '".$_SESSION['uzytkownik']->login."' AND haslomd5 = MD5('".$stare."')")) < 1)
	{
		die("ERROR:Niepoprawne hasło!");
	}
	$zapytanie = mysql_query("UPDATE uzytkownicy SET haslomd5 = md5('".$nowe."') WHERE login = '".$_SESSION['uzytkownik']->login."'");
	$wynik = mysql_affected_rows();

	echo $wynik;
	
?>