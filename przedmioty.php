<?php
	require_once("baza.php");
	
	$zapytanie = mysql_query("SELECT * FROM przedmioty");
	
	while ($wynik = mysql_fetch_assoc($zapytanie))
	{
		echo "<div class = \"przedmiot\">";
		echo "<div class = \"miniatura\"></div>";
		echo $wynik['nazwa']."<br>";
		echo str_replace(".", ",", ($wynik['cena'] / 100))."zł<br>";
		echo $wynik['prowadzacy']."<br>";
		echo "<button> Podbij </button>";
		echo "</div>";
	}
?>