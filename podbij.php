<?php
	require_once("baza.php");
	require_once("uzytkownik.inc");
	session_start();
	
	if (!isset($_SESSION['uzytkownik']))
	{
		echo "ERROR:Brak uprawnień!";
		exit();
	}
	
	date_default_timezone_set('Europe/Warsaw');
	
	$zapytanie = mysql_query("SELECT * FROM aukcje WHERE id = '".mysql_real_escape_string($_GET['id'])."'");
	$uzytkownik = mysql_fetch_assoc(mysql_query("SELECT * FROM uzytkownicy WHERE login = '".$_SESSION['uzytkownik']->login."'")) or print(mysql_error());
	$aukcja = mysql_fetch_assoc($zapytanie) or print(mysql_error());
	if (isset($aukcja['wartosc_podbicia']))
		$wartosc = $aukcja['wartosc_podbicia'];
	else
		$wartosc = 1;
	
	if ($aukcja['czas_koniec'] <= date("Y-m-d H:i:s"))
		die("ERROR:Aukcja już się zakończyła!");
	
	if ($uzytkownik['kredyty'] >= $aukcja['wartosc_podbicia'])
	{
		$_SESSION['uzytkownik']->kredyty = ($uzytkownik['kredyty'] - $wartosc);
		mysql_query("UPDATE uzytkownicy SET kredyty = '".($uzytkownik['kredyty'] - $wartosc)."' WHERE login = '".$_SESSION['uzytkownik']->login."'") or print(mysql_error());
		mysql_query("UPDATE aukcje SET cena = '".($aukcja['cena'] + $wartosc)."', prowadzi = '".$uzytkownik['login']."' WHERE id = '".$aukcja['id']."'") or print(mysql_error());
		mysql_query("UPDATE aukcje SET czas_koniec = '".date('Y-m-d H:i:s',(strtotime($aukcja['czas_koniec']) + 5))."' WHERE id = '".$aukcja['id']."'") or print(mysql_error());
		echo ($uzytkownik['kredyty'] - $aukcja['wartosc_podbicia']).";".($aukcja['cena'] + $wartosc);
	} else
	{
		echo "ERROR:Niewystarczająca ilość kredytów!";
	}
?>