<?php
	require_once("uzytkownik.inc");
	session_start();
	require_once("baza.php");
	

	
	$faktura = mysql_query("SELECT 
								adresy.kod_pocztowy as kod_pocztowy, 
								adresy.ulica as ulica, 
								adresy.miejscowosc as miejscowosc, 
								adresy.nr_domu as nr_domu, 
								adresy.nr_mieszkania as nr_mieszkania, 
								aukcje.cena as cena_przedmiotu,
								faktury.id as id_faktury, 
								faktury.data as data_faktury, 
								przedmioty.id as id_przedmiotu, 
								przedmioty.nazwa as nazwa_przedmiotu, 
								uzytkownicy.imie as imie, 
								uzytkownicy.nazwisko, 
								uzytkownicy.email 
							FROM 
									adresy 
								JOIN faktury ON adresy.id=faktury.adres 
								JOIN faktura_przedmiot ON faktury.id=faktura_przedmiot.faktura 
								JOIN przedmioty ON faktura_przedmiot.przedmiot=przedmioty.id 
								JOIN aukcja_przedmiot ON przedmioty.id=aukcja_przedmiot.przedmiotId
								JOIN aukcje ON aukcja_przedmiot.aukcjaId=aukcje.id 
								JOIN uzytkownik_aukcja ON aukcje.id=uzytkownik_aukcja.aukcja 
								JOIN uzytkownicy ON uzytkownik_aukcja.uzytkownik=uzytkownicy.login 
							WHERE faktury.id = '$_GET[id]' AND uzytkownicy.login = '".$_SESSION['uzytkownik']->login."'") or die(mysql_error());
	
	$wynik = mysql_fetch_assoc($faktura);
	
		echo "<table width=\"100%\" >";
		echo "<tr><td align=\"center\" width=\"50%\">";
		echo "Sprzedawca <br>Sklep aukcyjny <br>www.projektwieik.pl <br><br>";
		echo "Kupujący<br>";
		echo $wynik['imie']." ".$wynik['nazwisko']."<br>";
		echo $wynik['ulica']." ".$wynik['nr_domu'];
		if($wynik['nr_mieszkania'])
		{
			echo "/".$wynik['nr_mieszkania']."<br>";
		}
		else
		{
			echo "<br>";
		}
		echo ((int)($wynik['kod_pocztowy']/1000))."-";
		if($wynik['kod_pocztowy']%1000 <100)
		{			
			if($wynik['kod_pocztowy']%1000 <10)
			{
				echo "00".$wynik['kod_pocztowy']%1000;
			}
			else
			{
				echo "0".$wynik['kod_pocztowy']%1000;
			}
		}
		else
		{
			echo $wynik['kod_pocztowy']%1000;
		}
		echo " ".$wynik['miejscowosc']."<br><br>";
		echo "</td><td align=\"center\" width=\"50%\">";
		echo "<b>Faktura VAT</b> nr ".$wynik['id_faktury']."<br>";
		echo "<i>Oryginał</i> <br><br>";
		echo "Data wystawienia: ".$wynik['data_faktury']." <br>";
		echo "</td></tr></table>";
		echo "<br><br><br>";
	
	$i=1;
	$suma=0;
	echo "<table border=\"1\ width=\"100%\" align=\"center\" >
				<tr bgcolor=\"#BBBBBB\">
					<td width=\"40px\">lp.</td>
					<td width=\"50%\">nazwa</td>
					<td width=\"40px\">ilość</td>
					<td width=\"100px\">cena</td>
					<td width=\"100px\">cena bez VAT</td>
					
				</tr>";
	do
	{
		echo "	<tr>
					<td align=\"center\">".$i."</td>
					<td align=\"center\">".$wynik['nazwa_przedmiotu']."</td>
					<td align=\"center\">1</td>
					<td align=\"center\">".($wynik['cena_przedmiotu'] / 100)." zł</td>
					<td align=\"center\">".round((($wynik['cena_przedmiotu'] / 100)*0.77), 2)." zł</td>
				</tr>";
				$i++;
				$suma+=($wynik['cena_przedmiotu'] / 100);
	} while($wynik = mysql_fetch_assoc($faktura));
		echo "	<tr>
					<td colspan=\"3\" align=\"right\">razem</td>
					<td align=\"center\">".$suma." zł</td>
					<td></td>
				</tr>";
	echo "</table>";
	echo "<br><br><br><br>";
	echo "<table width=\"100%\" ><tr>";
	echo "<td align=\"center\" width=\"50%\">";
	echo "................................................ <br>";
	echo "podpis kupujacego";
	echo "</td>";
	echo "<td align=\"center\" width=\"50%\">";
	echo "................................................ <br>";
	echo "podpis sprzedajacego";
	echo "</td></tr></table>";
	
	
	
	
	/*//DOMPDF
	require_once '/dompdf/dompdf_config.inc.php';
	//$htmlString = file_get_contents("faktura.php?id=1");
	$htmlString = ob_get_clean();
	 
	$dompdf = new DOMPDF();
	$dompdf->load_html($htmlString);
	$dompdf->set_paper("A4");
	$dompdf->render();
	$out =  $dompdf->output();
	file_put_contents("sample.pdf", $out);
	/**/
	
?>