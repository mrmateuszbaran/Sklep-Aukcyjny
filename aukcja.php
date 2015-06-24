<?php
	require_once("uzytkownik.inc");
	session_start();
	
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
	
	$zapytanie = mysql_query("SELECT * FROM aukcje WHERE id = '".$_GET['id']."' ");	
	echo "<div id = \"tresc_tresc\" style = \"font-size:20px; padding:15px; width:1150px;\">";
	
		$aukcja = mysql_fetch_assoc($zapytanie);
		//$aukcja = $aukcja[0];
	
		$przedmiot = mysql_fetch_assoc(mysql_query("SELECT * FROM przedmioty LEFT JOIN aukcja_przedmiot ON przedmioty.id = aukcja_przedmiot.przedmiotId 
													WHERE aukcja_przedmiot.aukcjaId = $aukcja[id]"));
													
		$faktura = mysql_fetch_assoc(mysql_query("SELECT * FROM faktury 
						JOIN faktura_przedmiot ON faktury.id = faktura_przedmiot.faktura 
						JOIN aukcja_przedmiot ON faktura_przedmiot.przedmiot=aukcja_przedmiot.przedmiotId 
					WHERE aukcja_przedmiot.aukcjaId = '$aukcja[id]'"));
			
		//echo "<div class = \"aukcja\" id = \"aukcja$aukcja[id]\">";
		echo "<div class = \"miniatura\" style = \"float:left; margin:10px;\">";
		if ($przedmiot['obraz'] != "" && file_exists("img/przedmioty/$przedmiot[obraz]"))
			echo "<img src = \"img/przedmioty/$przedmiot[obraz]\">";
		else
			echo "<img src = \"img/przedmioty/brak.png\">";
		echo "</div><br>";
		echo $przedmiot['nazwa']."<br>";
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
		echo "<div class = \"aukcja-czas\" style = \"font-size:25px;\" czasKoniec = \"$aukcja[czas_koniec]\">".$czas_do_konca."</div><br>";
		if ($czas_do_konca != "KONIEC!")
		{
			if (isset($aukcja['wartosc_podbicia']))
				echo "<button class = \"aukcja-podbij\" style = \"float:left; width:180px;\" onClick = \"podbij(this,'".$aukcja['id']."');\"> Podbij (x ".($aukcja[wartosc_podbicia]).") </button>";
			else
				echo "<button class = \"aukcja-podbij\" style = \"float:left; width:180px;\" onClick = \"podbij(this,'".$aukcja['id']."');\"> Podbij </button>";
		} else if ($aukcja['prowadzi'] == $_SESSION['uzytkownik']->login)
		{
			if ($faktura['oplacona'] == "0")
				echo "<button class = \"aukcja-podbij\" style = \"float:left; width:180px;\" onClick = \"zaplac('".$aukcja['id']."', 
									'".$aukcja['cena']."', '".$przedmiot['nazwa']."', '".$_SESSION['uzytkownik']->email."');\"> Zapłać </button>";
			else
			{
				echo "<a href=\"faktura.php?id=$faktura[id]\">";
				echo "<button class = \"aukcja-podbij\" style = \"float:left; width:180px;\"> Faktura </button>";
				echo "</a>";
			}
		}
		//echo "</div>";
		echo "<br><br><hr>";
		echo "<h4 style=\"margin:0px;\">Ostatnio podbijali:</h4>";
		
		echo "<ol>";
		$historiaZap = mysql_query("SELECT * FROM uzytkownik_aukcja WHERE aukcja = '$aukcja[id]' ORDER BY id DESC");
		while ($historia = mysql_fetch_assoc($historiaZap))
		{
			echo "<li>".$historia['uzytkownik']."</li>";
		}
		echo "</ol>";
		
	echo "</div>";
?>