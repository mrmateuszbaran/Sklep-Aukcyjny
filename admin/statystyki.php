<?php
	require_once("baza.php");
	
	$najdrozszy_przedmiot = mysql_query("select przedmioty.nazwa as nazwaprzedmiotu, aukcje.cena as cenaaukcji from aukcje join aukcja_przedmiot on aukcje.id=aukcja_przedmiot.aukcja join przedmioty on aukcja_przedmiot.przedmiot=przedmioty.id where aukcje.czas_koniec<NOW() and aukcje.cena=(select max(aukcje.cena) from aukcje join aukcja_przedmiot on aukcje.id=aukcja_przedmiot.aukcja join przedmioty on aukcja_przedmiot.przedmiot=przedmioty.id where aukcje.czas_koniec<NOW());");
	$natanszy_przedmiot = mysql_query("select przedmioty.nazwa as nazwaprzedmiotu, aukcje.cena as cenaaukcji from aukcje join aukcja_przedmiot on aukcje.id=aukcja_przedmiot.aukcja join przedmioty on aukcja_przedmiot.przedmiot=przedmioty.id where aukcje.czas_koniec<NOW() and aukcje.cena=(select min(aukcje.cena) from aukcje join aukcja_przedmiot on aukcje.id=aukcja_przedmiot.aukcja join przedmioty on aukcja_przedmiot.przedmiot=przedmioty.id where aukcje.czas_koniec<NOW());");
	$najczestsza_kategoria = mysql_query("select count(*) as ilosckategorii, kategorie.nazwa as nazwakategorii from aukcje join aukcja_przedmiot on aukcje.id=aukcja_przedmiot.aukcja join przedmioty on aukcja_przedmiot.przedmiot=przedmioty.id join kategorie on przedmioty.kategoria=kategorie.id where aukcje.czas_koniec<NOW() group by kategorie.id order by count(*) desc;");
	$ilosc_aukcji = mysql_query("select count(*) as iloscaukcji from aukcje where aukcje.czas_koniec<NOW();");
	$ilosc_uzytkownikow = mysql_query("select count(*) as iloscuzytkownikow from uzytkownicy;");
	$srednia_cena = mysql_query("select sum(cena)/count(*) as srednia from aukcje where aukcje.czas_koniec<NOW();");
	$najczestszy_uzytkownik = mysql_query("select uzytkownicy.login as nazwauzytk , count(*) as iloscaukcji from uzytkownicy join uzytkownik_aukcja on uzytkownicy.login=uzytkownik_aukcja.uzytkownik join aukcje on uzytkownik_aukcja.aukcja=aukcje.id where aukcje.czas_koniec<NOW() group by uzytkownicy.login order by iloscaukcji desc;");
	$zysk30dni = mysql_query("select (sum(aukcje.cena)-sum(przedmioty.koszt)) as zysk from aukcje join aukcja_przedmiot on aukcje.id=aukcja_przedmiot.przedmiot join przedmioty on aukcja_przedmiot.przedmiot=przedmioty.id where czas_koniec<NOW() and czas_koniec>date_sub(now(), interval 30 day)");
	$zysk365dni = mysql_query("select (sum(aukcje.cena)-sum(przedmioty.koszt)) as zysk from aukcje join aukcja_przedmiot on aukcje.id=aukcja_przedmiot.przedmiot join przedmioty on aukcja_przedmiot.przedmiot=przedmioty.id where czas_koniec<NOW() and czas_koniec>date_sub(now(), interval 365 day);");
	$zysk = mysql_query("select (sum(aukcje.cena)-sum(przedmioty.koszt)) as zysk from aukcje join aukcja_przedmiot on aukcje.id=aukcja_przedmiot.przedmiot join przedmioty on aukcja_przedmiot.przedmiot=przedmioty.id where czas_koniec<NOW();");
	$zyskwmiesiacu = mysql_query("select (sum(aukcje.cena)-sum(przedmioty.koszt)) as zysk from aukcje join aukcja_przedmiot on aukcje.id=aukcja_przedmiot.przedmiot join przedmioty on aukcja_przedmiot.przedmiot=przedmioty.id where czas_koniec<NOW() and czas_koniec>date_sub(now(), interval day(now()) day);");
	$zyskwroku = mysql_query("select (sum(aukcje.cena)-sum(przedmioty.koszt)) as zysk from aukcje join aukcja_przedmiot on aukcje.id=aukcja_przedmiot.przedmiot join przedmioty on aukcja_przedmiot.przedmiot=przedmioty.id where czas_koniec<NOW() and czas_koniec>date_sub(now(), interval dayofyear(now()) day);");

	
	$najprz = mysql_fetch_assoc($najdrozszy_przedmiot);
	echo "najdroższy przedmiot: ".$najprz['nazwaprzedmiotu']." ".($najprz['cenaaukcji']/100)." zł <br>";
	
	$njtprz = mysql_fetch_assoc($natanszy_przedmiot);
	echo "najtańszy przedmiot: ".$njtprz['nazwaprzedmiotu']." ".($njtprz['cenaaukcji']/100)." zł<br>";
	
	$srcen = mysql_fetch_assoc($srednia_cena);
	echo "średnia cena przedmiotów: ".(round(($srcen['srednia']/100),2))." zł<br>";
	
	$najkat = mysql_fetch_assoc($najczestsza_kategoria);
	echo "najpopularniejsza kategoria: ".$najkat['nazwakategorii']." - ".$najkat['ilosckategorii']." przedmioty<br>";
	
	$ilauk = mysql_fetch_assoc($ilosc_aukcji);
	echo "ilość zakończonych aukcji: ".$ilauk['iloscaukcji']."<br>";
	
	$iluzy = mysql_fetch_assoc($ilosc_uzytkownikow);
	echo "ilość użytkowników: ".$iluzy['iloscuzytkownikow']." <br>";
	
	$najuzy = mysql_fetch_assoc($najczestszy_uzytkownik);
	echo "najcześciej kupujący użytkowników: ".$najuzy['nazwauzytk']." - ".$najuzy['iloscaukcji']." aukcji<br>";
	
	$zyskm = mysql_fetch_assoc($zyskwmiesiacu);
	echo "zysk w tym miesiącu: ".($zyskm['zysk']/100)." zł <br>";
	
	$zyskr = mysql_fetch_assoc($zyskwroku);
	echo "zysk w tym roku: ".($zyskr['zysk']/100)." zł <br>";
	
	$zysk30 = mysql_fetch_assoc($zysk30dni);
	echo "zysk z ostatnich 30 dni: ".($zysk30['zysk']/100)." zł <br>";
	
	$zysk365 = mysql_fetch_assoc($zysk365dni);
	echo "zysk z ostatnich 365 dni: ".($zysk365['zysk']/100)." zł <br>";
	
	$zys = mysql_fetch_assoc($zysk);
	echo "zysk od poczatku istnienia: ".($zys['zysk']/100)." zł <br>";
?>