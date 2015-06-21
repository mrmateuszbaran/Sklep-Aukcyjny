<?php
	require_once "../uzytkownik.inc";
	session_start();
	
	if (!isset($_SESSION['uzytkownik']))
	{
		echo "ERROR:Brak uprawnień!";
		exit();
	}
	
	require_once "../baza.php";
	
?>
<form name = "konto-haslo-form">
	<table id = "konto-haslo-tabela" class = "konto-tabela">
		<tr>
			<td>Aktualne hasło: </td><td><input type = "password" name = "stare" /></td>
		</tr>
		<tr>
			<td>Nowe hasło: </td><td><input type = "password" name = "nowe1" /></td>
		</tr>
		<tr>
			<td>Nowe hasło: </td><td><input type = "password" name = "nowe2" /></td>
		</tr>
		<tr><td></td><td></td></tr>
		<tr>
			<td></td><td><input type = "submit" name = "zapisz" value = "Zapisz" onClick = "konto_zmien_haslo(this.form); return false;" disabled = "disabled" /></td>
		</tr>
	</table>
</form>