<?php
	require_once "uzytkownik.inc";
	session_start();
	
	if (!isset($_SESSION['uzytkownik']))
	{
		echo "ERROR:Brak uprawnień!";
		exit();
	}
	
	require_once "baza.php";
	
	$poziomabs = $_SESSION['uzytkownik']->poziom;
	$poziom = ($poziomabs >= 9 ? ($poziomabs - 9) : $poziomabs);
	if ($poziom > 3)
		die("Masz już maksymalny poziom premium");
	
	$kredyty = mysql_fetch_row(mysql_query("SELECT kredyty FROM uzytkownicy WHERE login = '".$_SESSION['uzytkownik']->login."'"));
	$kredyty = $kredyty[0];
	$koszt = 1000 + $poziom * 500;
	if ($kredyty < $koszt)
		die("Niewystarczająca ilość kredytów!");
	else
	{
		mysql_query("UPDATE uzytkownicy SET kredyty = '".($kredyty-$koszt)."', poziom = '".($poziomabs+1)."' WHERE login = '".$_SESSION['uzytkownik']->login."'") or die(mysql_error());
		$_SESSION['uzytkownik']->poziom = ($poziomabs + 1);
		$_SESSION['uzytkownik']->kredyty = ($kredyty - $koszt);
	}
	
	echo "sukces";
	
?>