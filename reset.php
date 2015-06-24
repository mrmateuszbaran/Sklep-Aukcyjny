<div id = "tresc_tresc">
	<form name = "form_reset" method = "POST" style = "background-color:rgba(0,0,0,0.25); width:260px; margin:auto; margin-top:25px; 
		padding:20px; border:1px black solid; text-align:center;" onSubmit = "return false;">
		<table style = "margin:auto;">
			<tr>
				<td>Login: </td><td><input type = "text" name = "login"></td>
			</tr>
			<tr>
				<td>E-mail: </td><td><input type = "text" name = "email"></td>
			</tr>
			<tr><td></td><td style = "text-align:right;">
				<input type = "submit" onClick = "if (sprawdz_form_reset()) resetuj_haslo(this.form);" name = "resetuj" value = "Resetuj" style = "padding:5px; margin:5px;">
				</td>
			</tr>
		</table>
	</form>
</div>