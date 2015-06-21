<?php
	require_once "../baza.php";
	
	$zapytanie = mysql_query("SELECT * FROM adresy WHERE uzytkownik = '".$_SESSION['uzytkownik']->login."'") or print(mysql_error());
	
	while ($adres = mysql_fetch_assoc($zapytanie))
	{
		print_r($adres);
	}
	
?>