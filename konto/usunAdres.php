<?php
	require_once "../uzytkownik.inc";
	session_start();
	require_once "../baza.php";
	
	if (!isset($_SESSION['uzytkownik']))
	{
		echo "ERROR:Brak uprawnień!";
		exit();
	}
	
	
	mysql_query("DELETE FROM adresy WHERE id = '".mysql_real_escape_string($_GET['id'])."'") or die(mysql_error());
	echo "sukces";
	
?>