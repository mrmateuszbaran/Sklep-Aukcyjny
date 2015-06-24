<?php
	require_once("baza.php");

	$zapytanie = mysql_query("SELECT * FROM uzytkownicy WHERE login = '".mysql_real_escape_string($_GET['login'])."' 
											AND email = '".mysql_real_escape_string($_GET['email'])."'") or die(mysql_error());
	
	function randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
	{
		$str = '';
		$count = strlen($charset);
		while ($length--) {
			$str .= $charset[mt_rand(0, $count-1)];
		}
		return $str;
	}
	
	$nowe = randString(10);
	
	if (mysql_num_rows($zapytanie) == 0)
	{
		echo "Niepoprawne dane użytkownika!";
	} else
	{
		$wynik = mysql_fetch_row($zapytanie);
		if (@mail($wynik['email'], "Nowe hasło na projektwieik.pl", $nowe))
		{
			echo "sukces";
		} else
		{
			echo "Nie udało się wysłać maila z hasłem! ".$nowe;
		}
		mysql_query("UPDATE uzytkownicy SET haslomd5 = md5('$nowe') WHERE login = '".mysql_real_escape_string($_GET['login'])."'") or die (mysql_error());
	}

?>