<?php
	if (!$db)
		require_once "../baza.php";

	$zapytanie = mysql_query("SELECT * FROM uzytkownicy");
	
	// form
	echo <<<HEREDOC
	<form name = "admin-uzytkownicy-form">
	<table id = "admin-uzytkownicy" cellspacing = "0">
		<tr>
			<td colspan = "4" style = "width:15px;"></td>
			<td style = "width:80px;">Login</td>
			<td style = "width:100px;">Imię</td>
			<td style = "width:120px;">Nazwisko</td>
			<td style = "width:160px;">e-mail</td>
			<td style = "width:80px;">Telefon</td>
			<td style = "width:60px;">Kredyty</td>
			<td style = "width:20px;">Poziom</td>
		</tr>
HEREDOC;
	
	
	while ($uzytkownik = mysql_fetch_assoc($zapytanie))
	{	// kolumna czy konto aktywowane!
		// wysuń inputy po kliknięciu w "edytuj"!
		echo <<<HEREDOC
		<tr class = "uzytkownik" userLogin = "$uzytkownik[login]" onMouseOver = "zaznacz_rzad(this);" 
					onMouseOut = "if (!this.childNodes[1].childNodes[1].checked) odznacz_rzad(this);">
			<td>
				<input type = "checkbox" name = "zaznacz" value = "$uzytkownik[login]" />
			</td>
			<td class = "resetpass">
				<img class = "klikalne" src = "img/refresh.png" onClick = "przywroc_haslo_potwierdz(this.parentNode);" />
			</td>
			<td class = "edytuj">
				<img class = "klikalne" src = "img/edit.png" onClick = "edytuj_uzytkownika(this.parentNode);" /> 
			</td>
			<td class = "usun">
				<img class = "klikalne" src = "img/delete.png" onClick = "usun_uzytkownika_potwierdz(this.parentNode);" /> 
			</td>
			<td class = "login">
				$uzytkownik[login]
			</td>
			<td class = "imie">
				$uzytkownik[imie]
			</td>
			<td class = "nazwisko">
				$uzytkownik[nazwisko]
			</td>
			<td class = "email">
				$uzytkownik[email]
			</td>
			<td class = "telefon">
				$uzytkownik[telefon]
			</td>
			<td class = "kredyty">
				$uzytkownik[kredyty]
			</td>
			<td class = "poziom">
				$uzytkownik[poziom]
			</td>
		</tr>
HEREDOC;

		//print_r($uzytkownik);
		//echo "<hr>";;
	}
	echo <<<HEREDOC
		<tr>
		<td>
			<input type = "checkbox" id = "admin-uzytkownicy-selectall" name = "zaznacz" class = "select-all" value = "!wszystko" onClick = "zaznacz_wszystko(this);" />
			<label for = "admin-uzytkownicy-selectall"></label>
		</td>
		<td>
		</td>
		<td>
			<img src = "img/editall.png" class = "klikalne" onClick = "edytuj_uzytkownikow(this.parentNode.parentNode.parentNode);" />
		</td>
		<td>
			<img src = "img/deleteall.png" class = "klikalne" onClick = "usun_uzytkownikow_potwierdz(this.parentNode.parentNode.parentNode);" />
		</td>
		<td colspan = "7">
		</td>
		</tr>
		</table>
		</form>
HEREDOC;
	
?>