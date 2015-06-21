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
		case "user":
			$login = mysql_real_escape_string($_POST['login']);
			$imie = mysql_real_escape_string($_POST['imie']);
			$nazwisko = mysql_real_escape_string($_POST['nazwisko']);
			$email = mysql_real_escape_string($_POST['email']);
			$telefon = mysql_real_escape_string($_POST['telefon']);
			$poziom = mysql_real_escape_string($_POST['poziom']);
			$kredyty = mysql_real_escape_string($_POST['kredyty']);
			if ($poziom == "stay")
				$poziom = $_SESSION['uzytkownik']->poziom;
			if ($kredyty == "stay")
				$kredyty = $_SESSION['uzytkownik']->kredyty;
			$zapytanie = mysql_query("UPDATE uzytkownicy SET imie='$imie',nazwisko='$nazwisko',email='$email',
											telefon='$telefon',poziom='$poziom',kredyty='$kredyty' WHERE login='$login'");
			$wynik = mysql_affected_rows();
			break;
		case "aukcja":
			$aukcjaId = mysql_real_escape_string($_POST['id']);
			$start = mysql_real_escape_string($_POST['start']);
			$koniec = mysql_real_escape_string($_POST['koniec']);
			$cena = mysql_real_escape_string($_POST['cena']);
			$podbicie = mysql_real_escape_string($_POST['podbicie']);
			$zapytanie = mysql_query("UPDATE aukcje SET czas_start=STR_TO_DATE('$start', '%Y-%m-%d %H:%i:%s'),
														czas_koniec=STR_TO_DATE('$koniec', '%Y-%m-%d %H:%i:%s'),
														cena='$cena', wartosc_podbicia='$podbicie' WHERE id='$aukcjaId'") or print(mysql_error());
			$wynik = mysql_affected_rows();
			break;
		case "przedmiot":
			$przedmiotId = mysql_real_escape_string($_POST['id']);
			$nazwa = mysql_real_escape_string($_POST['nazwa']);
			$koszt = mysql_real_escape_string($_POST['koszt']);
			$ilosc = mysql_real_escape_string($_POST['ilosc']);
			$kategoria = mysql_real_escape_string($_POST['kategoria']);
			$obraz = mysql_real_escape_string($_POST['obraz']);
			$zapytanie = mysql_query("UPDATE przedmioty SET nazwa='$nazwa', koszt='$koszt', ilosc='$ilosc', 
															kategoria='$kategoria', obraz='$obraz' WHERE id='$przedmiotId'") or print(mysql_error());
			$wynik = mysql_affected_rows();
			break;
		default:
			$wynik = "ERROR:Niepoprawny parametr \"co\"";
	}

	echo $wynik;
?>