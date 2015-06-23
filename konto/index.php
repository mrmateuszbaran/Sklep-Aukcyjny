<style>
	h1 {
		font-family: Cambria;
	}
	#konto-menu {
		color: white;
		background: #4A788D;
		border: 1px black solid;
		width: 190px;
		text-align: center;
		padding: 5px;
		float: left;
		margin-left: 9px;
	}
	#konto-menu > span {
		width: 150px;
		display: inline-block;
		background: linear-gradient(to top,  #4A788D 0%, #b0c2ca 100%); /* W3C */
		border: 1px #b0c2ca solid;
		border-radius: 10px;
		font-family: Myriad Pro;
		color: white;
		text-shadow: 0px 0px 1px black, 0px 0px 2px black, 0px 0px 5px black;
		margin: 5px 0px;
		padding: 5px;
	}
	#konto-menu > span:last-child {
		background: linear-gradient(to top,  #9A687D 0%, #f0929a 100%); /* W3C */
		border: 1px #f0929a solid;
	}
	#konto-tresc {
		color: white;
		background: #4A788D;
		border: 1px green solid;
		xmargin-left: 225px;
		width: 960px;
		padding: 5px;
		text-align: center;
		display: inline-block;
	}
	.konto-tabela {
		background: rgba(0, 0, 0, 0.25);
		border: 1px black solid;
		margin: 15px auto;
		padding: 5px;
		display: inline-block;
		margin: 5px;
	}
	.konto-tabela td:first-child {
		padding-right: 25px;
		text-align: right;
	}
	.konto-tabela td:nth-child(2) {
		text-align: right;
	}
	button:hover:enabled, input[type=submit]:hover:enabled {
		box-shadow: inset 0px 0px 25px #e0f2fa;
	}
	button:disabled, input[type=submit]:disabled {
		background: gray; 
		cursor: default;
	}
	.aukcja {
		margin: 10px;
		padding: 5px;
		background-color: rgba(0, 0, 0, 0.25);
		border-radius: 10px;
		min-width: 200px;
		min-height: 150px;
		box-shadow: 1px 1px 2px black;
		display: inline-block;
		text-align: center;
	}

	.miniatura {
		background-color: rgba(255, 255, 255, 0.5);
		overflow: hidden;
		width: 160px;
		height: 120px;
		position: relative;
		border-radius: 5px;
		margin: auto;
	}

	.miniatura > img {
		position: absolute;
		top: -100%;
		bottom: -100%;
		left: -100%;
		right: -100%;
		margin: auto;
		width: 160px;
		height: auto;
		min-height: 100%;
		min-width: 100%;
	}

	.align-right {
		float: right;
	}

	.aukcja-cena {
		font-size: 24px;
		font-weight: bold;
	}

	.stronicowanie {
		margin: 5px;
		color: #e0f2fa;
		text-shadow: 0px 0px 1px blue, 0px 0px 1px violet, 0px 0px 2px black;
	}
</style>

<?php
	require_once("uzytkownik.inc");
	session_start();
	
	echo "<div style = \"width:100%; border:0px;\">";
		echo "<div id = \"konto-menu\">";
			echo "<span class = \"klikalne\" onClick = \"konto('dane');\">Dane konta</span><br />";
			echo "<span class = \"klikalne\" onClick = \"konto('adresy');\">Moje adresy</span><br />";
			echo "<span class = \"klikalne\" onClick = \"konto('wygrane');\">Wygrane aukcje</span><br />";
			echo "<span class = \"klikalne\" onClick = \"konto('haslo');\">Zmień hasło</span><br />";
			echo "<span class = \"klikalne\" onClick = \"konto_usun_potwierdz();\">Usuń konto</span>";
		echo "</div>";
		echo "<div id = \"konto-tresc\">";
			include "dane.php";
		echo "</div>";
	echo "</div>";
	
?>
<script>init_sprawdz_formularz(document.forms[0]);</script>