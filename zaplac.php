<?php

$posid = 7974; # ID Partnera

$klucz_klienta = '0f1445b8d9dd9b6cc8bb314b1dac534a'; # klucz transakcyjny

$bkey = pack('H*',$klucz_klienta); # postac binarna klucza transakcyjnego

$amount = $_GET['cena']; # kwota transakcji wyrażona w groszach

$description = urlencode($_GET['nazwa']); # słowny opis transakcji

$email = urlencode($_GET['email']); # adres e-mail Klienta

# Adres internetowy URL Channel do powiadomień kanałem międzyserwerowym. 
# jeśli URL Channel jest wpisany w ustawieniach konta, 
# można pozostawić pusty ciąg znaków
$URLC = urlencode('http://sklep.projektwieik.pl'); 

# adres internetowy powrotu do serwera Partnera po zakończonej transakcji:
$url_return = urlencode('http://sklep.projektwieik.pl'); 

# unikalny parametr transakcji nadany przez Partnera:
$control = urlencode($_GET['id']); 

# wygenerowanie podpisu:
$checksum  = md5($posid . '&' . $amount . '&'. $description . '&' . $email . '&' . $URLC . '&' . $url_return . '&' . $control . '&' . $bkey ); # podpis transakcji

# URL z kompletem danych i podpisem:

$url = 'https://platnosci-online.pl/payment.php?posid=7974&URLC=http%3A%2F%2Fsklep.projektwieik.pl&amount='.$amount.'&description='.$description.'&control='.$control.'&email='.$email.'&url_return=http%3A%2F%2Fsklep.projektwieik.pl&checksum='.$checksum.'';//01aeb0bf023a40df2a81c071331cedd4

header("Location: ".$url);
//echo $url."<br>";
//echo "<a href = \"$url\">Płać i płacz!</a>";
?>