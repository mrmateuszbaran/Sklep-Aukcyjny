<?php
	require_once("baza.php");
	require_once("uzytkownik.inc");
	session_start();
	
	if (isset($_SESSION['uzytkownik']))
	{
		unset($_SESSION['uzytkownik']);
	} else
	{
		$zapytanie = mysql_query("SELECT * FROM uzytkownicy WHERE login = '$_POST[login]'");
		if (mysql_num_rows($zapytanie) > 0)
		{
			$zapytanie = mysql_query("SELECT * FROM uzytkownicy WHERE login = '$_POST[login]' AND haslomd5 = md5('$_POST[haslo]')");
			if (mysql_num_rows($zapytanie) > 0)
			{
				if ($_POST['pamietaj'] == "true")
					setcookie("sklep-login", $_POST['login'], time()+60*60*24*100,'/');
				$rezultat = mysql_fetch_array($zapytanie);
				$adres = "null";
				$_SESSION['uzytkownik'] = new Uzytkownik($rezultat['login'], $rezultat['imie'], $rezultat['nazwisko'], $adres, $rezultat['email'], 
																	$rezultat['haslomd5'], $rezultat['kredyty'], $rezultat['poziom']);
			} else
			{
				$_SESSION['error'] .= "Złe hasło!;";
			}
		} else
		{
			$_SESSION['error'] .= "Nie ma takiego konta!;";
		}
	}
	
	header("Location: index.php");
	exit();
	
?>