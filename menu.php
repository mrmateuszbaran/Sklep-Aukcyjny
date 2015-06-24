<?php
	if (!isset($_SESSION['uzytkownik']))
	{
?>

	<span class = "klikalne" onClick = "tresc('rejestracja');"> Rejestracja </span>
	<span class = "klikalne" onClick = "tresc('onas');"> O nas </span>
	<span class = "klikalne" onClick = "tresc('kontakt');"> Kontakt </span>
		
<?php
	} else
	{
?>
		
	<span class = "klikalne" onClick = "tresc('konto/index');"> Moje konto </span>
	<span class = "klikalne" onClick = "tresc('premium');"> Premium [<font color = "gold" id = "menu-poziom"><?php echo ($_SESSION['uzytkownik']->poziom >= 9 ? ($_SESSION['uzytkownik']->poziom - 9) : $_SESSION['uzytkownik']->poziom) ?></font>] </span>
	<span class = "klikalne" onClick = "tresc('onas');"> O nas </span>
	<span class = "klikalne" onClick = "tresc('kontakt');"> Kontakt </span>

<?php
	}
?>