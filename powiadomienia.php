<?php
	require_once "uzytkownik.inc";
	require_once "baza.php";
	session_start();
	
	if (!isset($_SESSION['uzytkownik']))
	{
		die("ERROR:Brak uprawnień!");
	}
	
	$zapytanie = mysql_query("SELECT * FROM powiadomienia WHERE uzytkownik = '".$_SESSION['uzytkownik']->login."' AND przeczytane = 0");
	
	echo "<div style = \"margin:0; border:0px; width:100%;\" id = \"powiadomienia_tresc\">";
	
	while ($powiadomienie = mysql_fetch_assoc($zapytanie))
	{
		switch ($powiadomienie['typ'])
		{
			case "wygrana":
				$tresc = "Wygrałeś aukcję! ";	// + nazwa ? albo nic?
				break;
			case "koniec_aukcji":
				$tresc = "Nie wygrałeś aukcji! ";
				break;
			case "faktura":
				$tresc = "Wystawiono fakturę nr ".$powiadomienie['faktura'];	// $faktura[numer]!
				break;
			default:	// TODO: Wiadomości osobno bo są w innym oknie!
				$tresc = $powiadomienie['tresc'];
		}
		
		if (!$powiadomienie['przeczytane'])
			echo "<div class = \"klikalne powiadomienie powiadomienie-".$powiadomienie['typ']."-nowe\">";
		else
			echo "<div class = \"klikalne powiadomienie powiadomienie-".$powiadomienie['typ']."\">";
		echo $tresc;
		echo "</div>";
		//print_r($powiadomienie);
		//update set przeczytane (onclick)
		//echo "<hr>";
		
		// LOOOOOOOOOOOOOOOOOL Po usunięciu tego bloczki nie mają 100 width.......................................................
		// if (!$powiadomienie['przeczytane'])
			// echo "<div class = \"klikalne powiadomienie powiadomienie-".$powiadomienie['typ']."-nowe\">";
		// else
			// echo "<div class = \"klikalne powiadomienie powiadomienie-".$powiadomienie['typ']."\">";
		// echo $tresc;
		// echo "</div>";
		//////////////////////
	}
	
	echo "</div>";
?>