<?php
	require_once "../uzytkownik.inc";
	session_start();
	require_once "../baza.php";
	
	if (!isset($_SESSION['uzytkownik']))
	{
		echo "ERROR:Brak uprawnień!";
		exit();
	}
	
	$id = $_GET['id'];
	
	$nr_mieszkania = (($_GET['nr_mieszkania'] == "") ? "NULL" : mysql_real_escape_string($_GET['nr_mieszkania']));
	
	mysql_query("REPLACE INTO adresy(id, kod_pocztowy, ulica, miejscowosc, wojewodztwo, nr_domu, nr_mieszkania, uzytkownik) 
									VALUES ('$id', '".mysql_real_escape_string($_GET['kod_pocztowy'])."', '".mysql_real_escape_string($_GET['ulica'])."',
									'".mysql_real_escape_string($_GET['miejscowosc'])."', '".mysql_real_escape_string($_GET['wojewodztwo'])."',
									'".mysql_real_escape_string($_GET['nr_domu'])."', $nr_mieszkania, 
									'".$_SESSION['uzytkownik']->login."')") or die(mysql_error());
	echo "sukces";
	echo mysql_insert_id();
	
?>