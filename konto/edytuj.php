<?php
	// TODO
	// Przerobiæ na samo zapisywanie danych konta
	// I dodaæ zabezpieczenie ¿eby user móg³ edytowaæ tylko swoje konto
	// Poza tym chyba pasuje jednak POSTEM przesy³aæ
	require_once "../uzytkownik.inc";
	session_start();
	
	if (!isset($_SESSION['uzytkownik']))
	{
		echo "ERROR:Brak uprawnieñ!";
		exit();
	}

	require_once "../baza.php";
	
	switch($_GET['co'])
	{
		case "user":
			$login = mysql_real_escape_string($_GET['login']);
			$imie = mysql_real_escape_string($_GET['imie']);
			$nazwisko = mysql_real_escape_string($_GET['nazwisko']);
			$email = mysql_real_escape_string($_GET['email']);
			$telefon = mysql_real_escape_string($_GET['telefon']);
			$poziom = mysql_real_escape_string($_GET['poziom']);
			$kredyty = mysql_real_escape_string($_GET['kredyty']);
			// parametryzuj zapytanie a nie dodawaj jakieœ "stay"
			if ($poziom == "stay")
				$poziom = $_SESSION['uzytkownik']->poziom;
			if ($kredyty == "stay")
				$kredyty = $_SESSION['uzytkownik']->kredyty;
			$zapytanie = mysql_query("UPDATE uzytkownicy SET imie='$imie',nazwisko='$nazwisko',email='$email',
											telefon='$telefon',poziom='$poziom',kredyty='$kredyty' WHERE login='$login'") or die(mysql_error());
			$wynik = mysql_affected_rows();
			break;
		case "aukcja":
			$aukcjaId = mysql_real_escape_string($_GET['id']);
			$start = mysql_real_escape_string($_GET['start']);
			$koniec = mysql_real_escape_string($_GET['koniec']);
			$cena = mysql_real_escape_string($_GET['cena']);
			$podbicie = mysql_real_escape_string($_GET['podbicie']);
			$zapytanie = mysql_query("UPDATE aukcje SET czas_start=STR_TO_DATE('$start', '%Y-%m-%d %H:%i:%s'),
														czas_koniec=STR_TO_DATE('$koniec', '%Y-%m-%d %H:%i:%s'),
														cena='$cena', wartosc_podbicia='$podbicie' WHERE id='$aukcjaId'") or print(mysql_error());
			$wynik = mysql_affected_rows();
			break;
		case "przedmiot":
			$przedmiotId = mysql_real_escape_string($_GET['id']);
			$nazwa = mysql_real_escape_string($_GET['nazwa']);
			$koszt = mysql_real_escape_string($_GET['koszt']);
			$ilosc = mysql_real_escape_string($_GET['ilosc']);
			$kategoria = mysql_real_escape_string($_GET['kategoria']);
			$obraz = mysql_real_escape_string($_GET['obraz']);
			$zapytanie = mysql_query("UPDATE przedmioty SET nazwa='$nazwa', koszt='$koszt', ilosc='$ilosc', 
															kategoria='$kategoria', obraz='$obraz' WHERE id='$przedmiotId'") or print(mysql_error());
			$wynik = mysql_affected_rows();
			break;
		default:
			$wynik = "ERROR:Niepoprawny parametr \"co\"";
	}

	echo $wynik;
?>