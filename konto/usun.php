<?php
	require_once "../uzytkownik.inc";
	session_start();
	
	if (!isset($_SESSION['uzytkownik']))
	{
		echo "ERROR:Brak uprawnień!";
		exit();
	}
	
	require_once "../baza.php";
	
	$zapytanie = mysql_query("DELETE FROM uzytkownicy WHERE login = '".$_SESSION['uzytkownik']->login."'");
	$wynik = mysql_affected_rows();
	
	if ($wynik > 0)
	{
		unset($_SESSION['uzytkownik']);
	}

	echo $wynik;
	
?>