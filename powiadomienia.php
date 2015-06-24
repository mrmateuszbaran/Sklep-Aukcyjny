<?php
	require_once "uzytkownik.inc";
	require_once "baza.php";
	session_start();
	
	if (!isset($_SESSION['uzytkownik']))
	{
		die("ERROR:Brak uprawnień!");
	}
	
	$zapytanie = mysql_query("SELECT * FROM powiadomienia WHERE uzytkownik = '".$_SESSION['uzytkownik']->login."'");
	
	echo "<div style = \"margin:0; border:0px; width:100%; height: 180px; overflow-y: scroll;\" id = \"powiadomienia_tresc\">";
	
	while ($powiadomienie = mysql_fetch_assoc($zapytanie))
	{
		if ($_GET['przeczytane'] == "true")
		{
			mysql_query("UPDATE powiadomienia SET przeczytane = 1 WHERE id = '".$powiadomienie['id']."'");
		}
		switch ($powiadomienie['typ'])
		{
			case "wygrana":
				$tresc = "Wygrałeś aukcję! ";
				$widok = "aukcja";
				$param = $powiadomienie['aukcja'];
				break;
			case "koniec_aukcji":
				$tresc = "Nie wygrałeś aukcji! ";
				$widok = "aukcja";
				$param = $powiadomienie['aukcja'];
				break;
			case "faktura":
				$tresc = "Wystawiono fakturę!";	// $faktura[numer]!
				$widok = "faktura";
				$param = $powiadomienie['faktura'];
				break;
			default:	// TODO: Wiadomości osobno bo są w innym oknie!
				$tresc = $powiadomienie['tresc'];
		}
		
		if (!$powiadomienie['przeczytane'])
			echo "<div class = \"klikalne powiadomienie powiadomienie-".$powiadomienie['typ']."-nowe\" onClick = \"tresc('".$widok."', '".$param."');\">";
		else
			echo "<div class = \"klikalne powiadomienie powiadomienie-".$powiadomienie['typ']."\" onClick = \"tresc('".$widok."', '".$param."');\">";
		echo $tresc;
		echo "</div>";
	}
	
	echo "</div>";
?>