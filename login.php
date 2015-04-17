<?php
	session_start();
	
	require_once("baza.php");
	
	if (isset($_SESSION['login']))
	{
		unset($_SESSION['login']);
	} else
	{
		// baza danych
		$zapytanie = mysql_query("SELECT * FROM konta WHERE login = '$_POST[login]'");
		if (mysql_num_rows($zapytanie) > 0)
		{
			$zapytanie = mysql_query("SELECT * FROM konta WHERE login = '$_POST[login]' AND haslomd5 = md5('$_POST[haslo]')");
			if (mysql_num_rows($zapytanie) > 0)
			{
				echo "Login git!<br>";
				$_SESSION['login'] = $_POST['login'];
			} else
			{
				echo "Złe hasło!<br>";
			}
		} else
		{
			echo "Nie ma takiego konta!<br>";
		}
	}
	
	header("Location: /");
	exit();
	
?>