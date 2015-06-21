<?php
	session_start();
	
	require_once $_SERVER['DOCUMENT_ROOT']."/isi2/baza.php";
	
	
	switch ($_GET['co'])
	{
		case "przedmioty":
			$zapytanie = mysql_query("SELECT nazwa FROM przedmioty");
			while ($przedmiot = mysql_fetch_row($zapytanie)[0])
			{
				$wynik .= $przedmiot.";";
			}
			break;
		default:
			$wynik = "ERROR";
	}
	
	$wynik = substr($wynik, 0, -1);
	echo $wynik;
	
?>