<?php
	session_start();
	
	if (!isset($_SESSION['uzytkownik']))
	{
		echo "ERROR:Brak uprawnień!";
		exit();
	}
	
	require_once "../baza.php";

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
	$zapytanie = mysql_query("UPDATE uzytkownicy SET haslomd5 = md5('".$nowe."') WHERE login = '".mysql_real_escape_string($_GET['login'])."'");
	$wynik = mysql_affected_rows();
	
	mail('matek_2@op.pl', 'Nowe hasło na projektwieik.pl', $nowe) or die(htmlspecialchars_decode(error_get_last()['message']));

	echo $wynik;
	
?>