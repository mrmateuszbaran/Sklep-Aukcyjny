<?php
	require_once("uzytkownik.inc");
	session_start();

	require_once("baza.php");
	date_default_timezone_set('Europe/Warsaw');
	
	
	$zapytanie = mysql_query("SELECT * FROM powiadomienia WHERE uzytkownik = '".$_SESSION['uzytkownik']->login."' AND przeczytane = 0");
	
	while ($powiadomienie = mysql_fetch_assoc($zapytanie))
	{
		echo $powiadomienie['typ'].";".$powiadomienie['tresc'].";".$powiadomienie['aukcja'].";".$powiadomienie['faktura'];
	}
?>