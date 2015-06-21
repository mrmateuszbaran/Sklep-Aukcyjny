<?php
	session_start();
	
	if (!isset($_SESSION['uzytkownik']))
	{
		echo "ERROR:Brak uprawnieñ!";
		exit();
	}
	
	require_once "../baza.php";
	
	switch($_GET['co'])
	{
		case "aukcja_przedmiot":
			$zapytanie = mysql_query("INSERT INTO aukcja_przedmiot VALUES ('".mysql_real_escape_string($_GET['aukcja'])."', '".
																			mysql_real_escape_string($_GET['przedmiot'])."')") or die(mysql_error());
			$wynik = mysql_affected_rows();
			break;
		case "aukcja":
			$zapytanie = mysql_query("INSERT INTO aukcje(czas_start, czas_koniec, cena, wartosc_podbicia) 
										VALUES (STR_TO_DATE('".mysql_real_escape_string($_GET['start'])."', '%Y-%m-%d %H:%i:%s'), 
												STR_TO_DATE('".mysql_real_escape_string($_GET['koniec'])."', '%Y-%m-%d %H:%i:%s'), 
												'".mysql_real_escape_string($_GET['cena'])."', 
												'".mysql_real_escape_string($_GET['podbicie'])."')") or die(mysql_error());
			$wynik = mysql_fetch_row(mysql_query("SELECT max(id) FROM aukcje"))[0];
			break;
		case "przedmiot":
			$zapytanie = mysql_query("INSERT INTO przedmioty(nazwa, koszt, ilosc, kategoria, obraz) 
										VALUES ('".mysql_real_escape_string($_GET['nazwa'])."', 
												'".mysql_real_escape_string($_GET['koszt'])."', 
												'".mysql_real_escape_string($_GET['ilosc'])."', 
												'".mysql_real_escape_string($_GET['kategoria'])."', 
												'".mysql_real_escape_string($_GET['obraz'])."')") or die(mysql_error());
			$wynik = mysql_fetch_row(mysql_query("SELECT max(id) FROM przedmioty"))[0];
			break;
		default;
			$wynik = "ERROR";
	}
	
	echo $wynik;

?>