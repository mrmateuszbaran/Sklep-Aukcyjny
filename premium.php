<?php
	require_once "uzytkownik.inc";
	session_start();
	
	if (!isset($_SESSION['uzytkownik']))
	{
		echo "ERROR:Brak uprawnień!";
		exit();
	}
	
	require_once "baza.php";
	
	$poziom = ($_SESSION['uzytkownik']->poziom >= 9 ? ($_SESSION['uzytkownik']->poziom - 9) : $_SESSION['uzytkownik']->poziom);
	
	echo "<div id = \"tresc_tresc\" style = \"width:1180px; font-size:16px;\">";
	echo "<h1>Zakup konta premium</h1>";
	echo "<hr>";
	echo "Twój aktualny poziom: <font color = \"gold\" id = \"tresc-poziom\">";
	echo $poziom;
	echo "</font>";
	echo "<br>Zniżka na kredyty na twoim poziomie: ".($poziom * 5)."%";
	if ($poziom <= 3)
	{
		echo "<br>Zniżka na kredyty na kolejnym poziomie: ".(($poziom + 1) * 5)."%";
		echo "<br><br><button id = \"przyciskKupPremium\" onClick = \"kupPremium();\" style = \"font-size:18px;\">";
			echo "Wykup kolejny poziom (".(1000 + $poziom * 500)." kredytów) </button>";
	}
	else
		echo "<br>Posiadasz najwyższy możliwy poziom premium! Gratulacje!";
	echo "</div>";
	
?>