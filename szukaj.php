<?php
	require_once("baza.php");
	
	//$_SESSION['przedmioty_kategoria'] = ;
	
	$zapytanie = mysql_query("SELECT * FROM przedmioty"); // WHERE
?>

<form name = "szukaj-form" id = "szukaj-form" method = "POST">

Cena (zł) <br />
<input type = "text" name = "szukaj-cena-od" placeholder = "od" /> 
-
<input type = "text" name = "szukaj-cena-do" placeholder = "do" /><br />
<br />
Czas do końca (sekundy) <br />
<input type = "text" name = "szukaj-czas-od" placeholder = "od" /> 
-
<input type = "text" name = "szukaj-czas-do" placeholder = "do" /> 
<br /><br />
<input class = "align-right" type = "submit" name = "szukaj-zastosuj" value = "Zastosuj">

</form>