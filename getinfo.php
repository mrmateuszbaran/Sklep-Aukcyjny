<?php
	require_once("uzytkownik.inc");
	session_start();

	require_once("baza.php");
	date_default_timezone_set('Europe/Warsaw');
	
	function dateDiff($date1timestamp, $date2timestamp)
	{		
	   $all = round(($date1timestamp - $date2timestamp));
	   $d = floor ($all / 86400);
	   $h = floor (($all - $d * 86400) / 3600);
	   $m = floor (($all - ($d * 86400) - ($h * 3600)) / 60);
	   $s = $all - ($d * 86400) - ($h * 3600) - ($m * 60);
	   $h = ($d*24+$h);
	   if ($h < 10)
		   $h = "0".($h);
	   if ($m < 10)
		   $m = "0".$m;
	   if ($s < 10)
		   $s = "0".$s;
	   return "$h:$m:$s";
	}
	// TODO
	// Dodaj kredyty tutaj
	if (isset($_SESSION['uzytkownik']))
		echo $_SESSION['uzytkownik']->login.";";
	else 
		echo "x;";
	
	$zapytanie = mysql_query("SELECT * FROM aukcje WHERE czas_koniec >= NOW()");
	
	while ($aukcja = mysql_fetch_assoc($zapytanie))
	{
		$diff = strtotime($aukcja['czas_koniec']) - time();
		if ($diff > 0)
			$czas_do_konca = dateDiff(strtotime($aukcja['czas_koniec']), time());
		else
		{
			$czas_do_konca = "KONIEC!";
			mysql_query("INSERT INTO powiadomienia(typ, przeczytane, uzytkownik, aukcja) VALUES ('wygrana', 0, '".$_SESSION['uzytkownik']->login."', '$aukcja[id]')");
		}
		echo $aukcja['id']."|".$czas_do_konca."|".$aukcja['czas_koniec']."|".$aukcja['cena']."|".$aukcja['prowadzi'].";";
	}
?>