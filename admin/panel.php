<style>
	option {
		transition: none !important;
	}

	div.przedmiot, div.aukcja_tr, div.uzytkownik {
		width: 100%;
	}
	div.przedmiot > div, div.aukcja_tr > div, div.uzytkownik > div {
		display: inline-block;
	}
	#admin-przedmioty, #admin-aukcje, #admin-uzytkownicy {
		border: 1px black solid;
	}
	#admin-przedmioty tr:first-child, #admin-aukcje tr:first-child, #admin-uzytkownicy tr:first-child {
		background: #ccc;
	}
	#admin-przedmioty td, #admin-aukcje td, #admin-uzytkownicy td {
		border: 1px black solid;
		padding: 5px;
	}
	#admin-przedmioty input[type=text]:disabled, #admin-aukcje input[type=text]:disabled, #admin-uzytkownicy input[type=text]:disabled {
		background: transparent;
		border: 0px red solid;
		color: black;
	}
	.select-all {
		display:none;
	}

	.select-all + label{
		background:url('img/select-all-false.png') no-repeat;
		height: 16px;
		width: 16px;
		display:inline-block;
		padding: 0 0 0 0px;
		margin-left: 3px;
	}

	.select-all:checked + label{
		background:url('img/select-all-true.png') no-repeat;
		height: 16px;
		width: 16px;
		display:inline-block;
		padding: 0 0 0 0px;
	}
	input[type=file]{
		width:95px;
		color:transparent;
	}
	#panel_menu {
		color: white;
		background: #4A788D;
		border: 1px black solid;
		width: 190px;
		padding: 5px;
		margin-left: 9px;
		float: left;
	}
	#panel_menu > span {
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
	#panel_tresc {
		color: white;
		background: #4A788D;
		border: 1px green solid;
		width: 960px;
		padding: 5px;
		text-align: center;
		display: inline-block;
	}
	#panel_tresc table {
		margin: auto;
		margin-bottom: 10px;
	}
	#panel_tresc > form td {
		background: rgba(0,0,0,0.25);
	}
</style>

<?php
	require_once "uzytkownik.inc";
	require_once "baza.php";
	session_start();
	
	if (!isset($_SESSION['uzytkownik']))
	{
		echo "ERROR:Brak uprawnień!";
		exit();
	}

	echo "<div style = \"width:100%; border:0px;\">";
		echo 	"<div id = \"panel_menu\">
					<span class = \"klikalne\" onClick = \"panel('uzytkownicy');\">Użytkownicy</span><br />
					<span class = \"klikalne\" onClick = \"panel('aukcje');\">Aukcje</span><br />
					<span class = \"klikalne\" onClick = \"panel('przedmioty');\">Przedmioty</span><br />
				</div>
				<div id = \"panel_tresc\">";
					include "uzytkownicy.php";
		echo 	"</div>";
	echo "</div>";
	
?>