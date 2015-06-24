<?php
	require_once "../baza.php";
	
	$zapytanie = mysql_query("SELECT * FROM aukcje WHERE czas_koniec < NOW() AND prowadzi = '".$_SESSION['uzytkownik']->login."'") or print(mysql_error());
	
	if (mysql_num_rows($zapytanie) == 0)
	{
		echo "<h2> Brak wygranych aukcji! </h2>";
	}
	
	while ($aukcja = mysql_fetch_assoc($zapytanie))
	{
		$przedmiot = mysql_fetch_assoc(mysql_query("SELECT * FROM przedmioty LEFT JOIN aukcja_przedmiot ON przedmioty.id = aukcja_przedmiot.przedmiotId 
													WHERE aukcja_przedmiot.aukcjaId = $aukcja[id]"));
		echo "<div class = \"aukcja klikalne\" onClick = \"tresc('aukcja', '$aukcja[id]');\">";
		echo "<div class = \"miniatura\">";
		if ($przedmiot['obraz'] != "" && file_exists("../img/przedmioty/$przedmiot[obraz]"))	// ładuj miniatury AJAXem!
			echo "<img src = \"img/przedmioty/$przedmiot[obraz]\">";
		else
			echo "<img src = \"img/przedmioty/brak.png\">";
		echo "</div><br>";
		echo $przedmiot['nazwa']."<hr>";
		echo "<span class = \"aukcja-cena\">".str_replace(".", ",", ($aukcja['cena'] / 100))."</span> zł<br>";
		echo "</div>";
		//print_r($aukcja);
	}
	
?>