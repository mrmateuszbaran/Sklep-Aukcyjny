<?php
	require_once "../uzytkownik.inc";
	session_start();
	require_once "../baza.php";
	
	echo "<tr><td>Miejscowość:</td><td><input type = \"text\" name = \"miejscowosc\" /></td></tr>";
	echo "<tr><td>Ulica:</td><td><input type = \"text\" name = \"ulica\" /></td></tr>";
	echo "<tr><td>Nr domu:</td><td><input type = \"text\" name = \"nr_domu\" /></td></tr>";
	echo "<tr><td>Nr mieszkania*:</td><td><input type = \"text\" name = \"nr_mieszkania\" /></td></tr>";
	echo "<tr><td>Kod pocztowy.:</td><td><input type = \"text\" name = \"kod_pocztowy\" /></td></tr>";
	echo "<tr><td>Województwo:</td><td><input type = \"text\" name = \"wojewodztwo\" /></td></tr>";
	echo "<tr><td></td><td></td></tr>";
	echo "<tr><td><img src = \"./img/delete.png\" class = \"klikalne\" onClick = \"usun_adres(this);\"></td>
			<td><input type = \"submit\" name = \"zapisz\" value = \"Zapisz\" adresId = \"adres0\" onClick = \"zapisz_adres(this); return false;\"></td></tr>";
	
?>