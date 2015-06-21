<?php

	echo "<form name = \"konto-dane-form\" method = \"POST\">";
	echo "<table id = \"konto-dane-tabela\"  class = \"konto-tabela\">";
	echo "<tr><td>Login:</td><td><input type = \"text\" name = \"login\" value = \"".$_SESSION[uzytkownik]->login."\" disabled /></td></tr>";
	echo "<tr><td>Imię:</td><td><input type = \"text\" name = \"imie\" value = \"".$_SESSION[uzytkownik]->imie."\" /></td></tr>";
	echo "<tr><td>Nazwisko:</td><td><input type = \"text\" name = \"nazwisko\" value = \"".$_SESSION[uzytkownik]->nazwisko."\" /></td></tr>";
	echo "<tr><td>E-mail:</td><td><input type = \"text\" name = \"email\" value = \"".$_SESSION[uzytkownik]->email."\" /></td></tr>";
	echo "<tr><td>Nr tel.:</td><td><input type = \"text\" name = \"telefon\" value = \"".$_SESSION[uzytkownik]->telefon."\" /></td></tr>";
	echo "<tr><td>Kredyty:</td><td><input type = \"text\" name = \"kredyty\" value = \"".$_SESSION[uzytkownik]->kredyty."\" disabled /></td></tr>";
	echo "<tr><td>Poziom:</td><td><input type = \"text\" name = \"poziom\" value = \"".$_SESSION[uzytkownik]->poziom."\" disabled /></td></tr>";
	echo "<tr><td></td><td></td></tr>";
	echo "<tr><td></td><td><input type = \"submit\" name = \"zapisz\" value = \"Zapisz\" onClick = \"konto_zapisz(this.form, '".
																					$_SESSION['uzytkownik']->login."'); return false;\"></td></tr>";
	echo "</table>";
	echo "</form>";
	
?>