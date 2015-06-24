<?php
	require_once("baza.php");
	date_default_timezone_set('Europe/Warsaw');
	
	function dateDiff($date1timestamp, $date2timestamp)
	{		
	   $all = round(($date1timestamp - $date2timestamp));
	   $d = floor ($all / 86400);
	   $h = floor (($all - $d * 86400) / 3600);
	   $m = floor (($all - ($d * 86400) - ($h * 3600)) / 60);
	   $s = $all - ($d * 86400) - ($h * 3600) - ($m * 60);
	   $h = ($d*24+$h);
	   if ($h < 10)
		   $h = "0".($h);
	   if ($m < 10)
		   $m = "0".$m;
	   if ($s < 10)
		   $s = "0".$s;
	   return "$h:$m:$s";
	}
	if (isset($_GET['kategoria']) && $_GET['kategoria'] != "undefined")
	{
		$kategoria = mysql_fetch_assoc(mysql_query("SELECT id FROM kategorie WHERE nazwa = '".$_GET['kategoria']."'"));
		$zapytanie = mysql_query("SELECT * FROM aukcje WHERE czas_koniec > NOW() AND kategoria = '".$kategoria['id']."' ORDER BY czas_koniec ");	
	} else
		$zapytanie = mysql_query("SELECT * FROM aukcje WHERE czas_koniec > NOW() ORDER BY czas_koniec ");	
	
	$ile = mysql_num_rows($zapytanie);
	$strona = 1;
	$ile_na_stronie = 20;
	
	
	if ($ile == 0)
	{
		echo "<h1> Brak aukcji, proszę sprawdzić później! </h1>";
	}
	
	if ($ile > $ile_na_stronie)	
	{
		$stron = ceil($ile / $ile_na_stronie);
		$zapytanie = mysql_query("SELECT * FROM aukcje LIMIT $ile_na_stronie");
	}
	
	while ($aukcja = mysql_fetch_assoc($zapytanie))
	{
		$przedmiot = mysql_fetch_assoc(mysql_query("SELECT * FROM przedmioty LEFT JOIN aukcja_przedmiot ON przedmioty.id = aukcja_przedmiot.przedmiotId 
													WHERE aukcja_przedmiot.aukcjaId = $aukcja[id]"));
		echo "<div class = \"aukcja\" id = \"aukcja$aukcja[id]\">";
		echo "<div class = \"miniatura klikalne\" onClick = \"tresc('aukcja','$aukcja[id]');\">";
		if ($przedmiot['obraz'] != "" && file_exists("img/przedmioty/$przedmiot[obraz]"))
			echo "<img src = \"img/przedmioty/$przedmiot[obraz]\">";
		else
			echo "<img src = \"img/przedmioty/brak.png\">";
		echo "</div><br>";
		echo $przedmiot['nazwa']."<hr>";
		echo "<span class = \"aukcja-cena\">".str_replace(".", ",", ($aukcja['cena'] / 100))."</span> zł<br>";
		if (isset($aukcja['prowadzi']))
			echo "Prowadzi: <span class = \"aukcja-prowadzi\">".$aukcja['prowadzi']."</span><br>";
		else
			echo "<span>Licytuj pierwszy!</span><br>";
		
		$diff = strtotime($aukcja['czas_koniec']) - time();
		if ($diff > 0)
			$czas_do_konca = dateDiff(strtotime($aukcja['czas_koniec']), time());
		else
			$czas_do_konca = "KONIEC!";
		echo "<div class = \"aukcja-czas\" czasKoniec = \"$aukcja[czas_koniec]\">".$czas_do_konca."</div><br>";
		if (isset($aukcja['wartosc_podbicia']))
			echo "<button class = \"aukcja-podbij\" onClick = \"podbij(this,'".$aukcja['id']."');\"> Podbij (x ".($aukcja[wartosc_podbicia]).") </button>";
		else
			echo "<button class = \"aukcja-podbij\" onClick = \"podbij(this,'".$aukcja['id']."');\"> Podbij </button>";
		echo "</div>";
	}
	echo "<br><br>";
	for ($i = 1; $i <= $stron; $i++)
	{
		if ($strona == $i)
			echo "$i";
		else
			echo "<a class = \"stronicowanie\">$i</a>";
	}
?>