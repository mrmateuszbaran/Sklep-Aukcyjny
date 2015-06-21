<?php
	require_once "../uzytkownik.inc";
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
	//$zapytanie = mysql_query("UPDATE uzytkownicy SET haslomd5 = md5('".$nowe."') WHERE login = '".$_SESSION['uzytkownik']->login."'");
	$wynik = mysql_affected_rows();
	
	$headers = 'From: Sklep Aukcyjny <tech@projektwieik.pl>' . "\r\n" .
				'Reply-To: Sklep Aukcyjny <tech@projektwieik.pl>' .
				'X-Mailer: PHP/' . phpversion();
	if (!mail($_SESSION['uzytkownik']->email, 'Nowe hasło na projektwieik.pl', $nowe, $headers))
	{
		$error = error_get_last();
		echo htmlspecialchars_decode($error['message']);
	}
	
	echo $wynik;
	
?>