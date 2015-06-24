<?php

#####################################
# parametry stałe

# Twój klucz transakcyjny
$klucz_klienta = '0f1445b8d9dd9b6cc8bb314b1dac534a';

# klucz w formie binarnej
$bkey = pack('H*' , $klucz_klienta);

# Twój ID Partnera w systemie Płatności
# Ta wartość jest dla każdego Partnera inna.
# Znajdziesz ją w Panelu Administracyjnym w ustawieniach konta.
$posid = 7974;


#####################################
# parametry wejściowe z oprogramowania sklepu:

# unikalny numer zamówienia
$numer_zamowienia = 1432;	// id aukcji z GET po AJAXie

# wartość zamówienia wyrażona w polskich nowych złotych (PLN)
$suma_zamowienia = 120 ;	// cena aukcji

# adres e-mail Klienta dokonujšcego transakcji
$email = 'mrmateuszbaran@gmail.com';	

# domena sklepu internetowego.
$domena = 'www.sklep.projektwieik.pl';

# nazwa strony powrotu Klienta do sklepu
$url_platnosci = 'index.php';


######################################
# Zasadnicza część skryptu.
#
# Wygenerowanie kompletnego adresu internetowego
# aby przekierować Klienta na stronę serwera Płatności.
#

# przeliczenie wartości zamówienia na grosze
$amount = $suma_zamowienia * 100;

# generowanie unikalnego identyfikatora
$control .= 'zamowienie_'.$numer_zamowienia;

# wygenerowanie kwerendy SQL zapisującej dane do bazy

$sql_text = "INSERT INTO transakcje
(control, czas_zakupu, amount, zamowienie)
VALUES
('".$control."', now(), '".$amount."', '".$numer_zamowienia."'); ";

# zapisanie transakcji do bazy danych
$a = mysql_query($sql_text); # zapisz dane do bazy
$id_rekordu = mysql_insert_id(); # zapamiętaj ID zapisanego rekordu

# słowny opis transakcji:
$description = urlencode('Opłata za zamówienie nr ' . $numer_zamowienia);

# pełny adres internetowy powrotu do sklepu z parametrem ID transakcji:
$url_return = urlencode('http://'.$domena.'/'.$url_platnosci.'?idp='.$id_rekordu.'');

# podpisanie danych do transakcji:
$checksum  = md5($posid . '&' . $amount . '&' . $description . '&' . $email . '&' . $URLC . '&' . $url_return . '&' . $control . '&' . $bkey);

# wygenerowanie linku z zestawem danych oraz podpisem:
$url = 'https://platnosci-online.pl/payment.php?posid='.$posid.'&URLC='.$URLC.'&amount='.$amount.'&description='.$description.'&control='.$control
.'&email='.$email.'&url_return='.$url_return.'&checksum='.$checksum.'';

# przekierowanie przeglądarki do serwera Płatności:
header('Location: '.$url.'');

# koniec skryptu
exit();

?>