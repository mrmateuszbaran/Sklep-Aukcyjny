<?php
	if (!isset($_SESSION['uzytkownik']))
	{
?>
		<form name = "form_login" method = "POST" action = "login.php">
			<table>
				<tr> 
					<td style = "width:55px;">
						Login: 
					</td>
					<td colspan = "2">
						<input name = "login" />
					</td>
				</tr>
				<tr> 
					<td>
						Hasło: 
					</td>
					<td colspan = "2">
						<input type = "password" name = "haslo" />
					</td>
				</tr>
				<tr> 
					<td colspan = "3">
						Pamiętaj logowanie
						<input type = "checkbox" name = "pamietaj" value = "true" /><br />
					</td>
				</tr>
				<tr> 
					<td colspan = "2" style = "width:150px; text-align:left;">
						<span class = "klikalne" onClick = "tresc('reset');">Reset hasła</span>
					</td>
					<td style = "width:80px;">
						<input type = "submit" value = "Zaloguj się" />
					</td>
				</tr>
			</table>
		</form>
		
<?php
	} else
	{
?>
		<div style = "border:0;">
		<a href = "?strona=logout" class = "text-link">Wyloguj [ <font color = "gold"><?php echo $_SESSION['uzytkownik']->login; ?></font> ]</a><hr />
		<span id = "uzytkownik-kredyty"><?php echo $_SESSION['uzytkownik']->kredyty; ?></span> kredytów.<br />
		<span class = "klikalne" onClick = "tresc('admin/panel')">Panel admina </span><br /> <hr />
		<img id = "powiadomienia" class = "klikalne" src = "powiadomienie.png" alt = "Powiadomienia" title = "Powiadomienia" onClick = "toggle_powiadomienia();">
		<img id = "wiadomosci" class = "klikalne" src = "wiadomosc.png" alt = "Wiadomości" title = "Wiadomości" onClick = "toggle_wiadomosci();"> <br />
		</div>
<?php
	}
?>