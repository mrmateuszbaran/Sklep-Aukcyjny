<?php
	require_once "../baza.php";
	
	$zapytanie = mysql_query("SELECT * FROM adresy WHERE uzytkownik = '".$_SESSION['uzytkownik']->login."'") or print(mysql_error());
	
	echo "<form name = \"konto-adresy-form\" method = \"POST\">";
	while ($adres = mysql_fetch_assoc($zapytanie))
	{
		echo "<table class = \"konto-tabela\">";
		echo "<tr><td>Miejscowość:</td><td><input type = \"text\" name = \"miejscowosc\" value = \"".$adres['miejscowosc']."\" /></td></tr>";
		echo "<tr><td>Ulica:</td><td><input type = \"text\" name = \"ulica\" value = \"".$adres['ulica']."\" /></td></tr>";
		echo "<tr><td>Nr domu:</td><td><input type = \"text\" name = \"nr_domu\" value = \"".$adres['nr_domu']."\" /></td></tr>";
		echo "<tr><td>Nr mieszkania*:</td><td><input type = \"text\" name = \"nr_mieszkania\" value = \"".$adres['nr_mieszkania']."\" /></td></tr>";
		echo "<tr><td>Kod pocztowy.:</td><td><input type = \"text\" name = \"kod_pocztowy\" value = \"".$adres['kod_pocztowy']."\" /></td></tr>";
		echo "<tr><td>Województwo:</td><td><input type = \"text\" name = \"wojewodztwo\" value = \"".$adres['wojewodztwo']."\" /></td></tr>";
		echo "<tr><td></td><td></td></tr>";
		echo "<tr><td><img src = \"./img/delete.png\" class = \"klikalne\" onClick = \"usun_adres(this);\"></td>
				<td><input type = \"submit\" name = \"zapisz\" value = \"Zapisz\" adresId = \"adres".$adres['id']."\" onClick = \"zapisz_adres(this); return false;\"></td></tr>";
		echo "</table>";
	}
	echo "</form>";
	echo "<img src = \"./img/add_big.png\" class = \"klikalne\" onClick = \"dodaj_adres(this);\"><br>";
	
?>
* - może pozostać puste