<?php
	if (!isset($_SESSION['uzytkownik']))
	{
?>

	<span class = "klikalne"> Rejestracja </span>
	<span class = "klikalne"> Opinie klientów </span>
	<span class = "klikalne"> O nas </span>
	<span class = "klikalne"> Kontakt </span>
		
<?php
	} else
	{
?>
		
	<span class = "klikalne" onClick = "tresc('konto/index');"> Moje konto </span>
	<span class = "klikalne"> Opinie klientów </span>
	<span class = "klikalne"> O nas </span>
	<span class = "klikalne"> Kontakt </span>

<?php
	}
?>