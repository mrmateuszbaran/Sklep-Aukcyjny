<?php
	require_once("baza.php");
	
	if (isset($_POST['rejestruj']))
	{
		// usunac po dodaniu sprawdzenia w funkcji JS
		$zapytanie = mysql_query("SELECT * FROM konta WHERE login = '$_POST[login]'");
		if (mysql_num_rows($zapytanie) > 0)
		{
			echo "Konto o takim loginie już istnieje!<br>";
		} else
		{
		// ------------------------------------------
			mysql_query("INSERT INTO konta VALUES('$_POST[login]', md5('$_POST[haslo]'), '$_POST[imie]', '$_POST[nazwisko]', '$adres')");
			echo "Pomyślnie utworzono konto!<br>";
		}
	}
?>

<form name = "form_rejestracja" method = "POST" style = "background-color:lightgray; width:260px; margin:auto; padding:20px; border:1px black solid; text-align:right;"
	onSubmit = "return sprawdz_form_rejestracja();">
	<div style = "float:left; line-height:32px; display:inline-block; margin:auto;">
		Login: <br>
		Hasło: <br>
		Imię: <br>
		Nazwisko: <br>
		Kod pocztowy: <br>
		Miejscowość: <br>
		Ulica i nr domu:  <br>
	</div>
	<input name = "login"><br>
	<input type = "password" name = "haslo"><br>
	<input name = "imie"><br>
	<input name = "nazwisko"><br>
	<input name = "kod1" maxlength = "2" style = "width:20px;">-<input name = "kod2" maxlength = "3" style = "width:30px;"><br>
	<input name = "miejscowosc"><br>
	<input name = "ulica"><br><br>
	<input type = "submit" name = "rejestruj" value = "Rejestruj" style = "padding:10px;">
</form>