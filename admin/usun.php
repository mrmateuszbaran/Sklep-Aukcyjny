<?php
	session_start();
	
	if (!isset($_SESSION['uzytkownik']))
	{
		echo "ERROR:Brak uprawnień!";
		exit();
	}
	
	require_once "../baza.php";

	switch($_GET['co'])
	{
		case "user":
			mysql_query("DELETE FROM uzytkownicy WHERE login = '".mysql_real_escape_string($_GET['login'])."'");
			$wynik = mysql_affected_rows();
			break;
		case "aukcja":
			mysql_query("DELETE FROM aukcja_przedmiot WHERE aukcjaId = '".mysql_real_escape_string($_GET['id'])."'");
			mysql_query("DELETE FROM aukcje WHERE id = '".mysql_real_escape_string($_GET['id'])."'");
			$wynik = mysql_affected_rows();
			break;
		case "przedmiot":
			mysql_query("DELETE FROM aukcja_przedmiot WHERE przedmiotId = '".mysql_real_escape_string($_GET['id'])."'");
			mysql_query("DELETE FROM przedmioty WHERE id = '".mysql_real_escape_string($_GET['id'])."'");
			$wynik = mysql_affected_rows();
			break;
		case "aukcja_przedmiot":
			$zapytanie = mysql_query("DELETE FROM aukcja_przedmiot WHERE aukcjaId = '".mysql_real_escape_string($_GET['aukcja'])."' AND
																przedmiotId = '".mysql_real_escape_string($_GET['przedmiot'])."'");
			$wynik = mysql_affected_rows();
			break;
		default:
			$wynik = "ERROR:Niepoprawny parametr \"co\"";
	}

	echo $wynik;
	
?>