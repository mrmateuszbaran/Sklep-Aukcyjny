<?php

	require_once "../baza.php";
	
	$zapytanie = mysql_query("SELECT * FROM przedmioty");
	
	$kategorie_zap = mysql_query("SELECT * FROM kategorie");
	while ($kategoria = mysql_fetch_assoc($kategorie_zap))
	{
		echo "<kategoria nazwa = \"$kategoria[nazwa]\" id = \"$kategoria[id]\"></kategoria>\n";
	}
	
	echo <<<HEREDOC
	<form name = "admin-przedmioty-form">
	<table id = "admin-przedmioty" cellspacing = "0">
		<tr>
			<td colspan = "4" style = "width:15px;"></td>
			<td style = "width:140px;">Nazwa</td>
			<td style = "width:140px;">Koszt (gr)</td>
			<td style = "width:80px;">Ilość</td>
			<td style = "width:60px;">Kategoria</td>
			<td style = "width:120px;">Obraz</td>
		</tr>
HEREDOC;
	
	
	while ($przedmiot = mysql_fetch_assoc($zapytanie))
	{	
		$kategoria = mysql_fetch_row(mysql_query("SELECT nazwa FROM kategorie WHERE id = '$przedmiot[kategoria]'"));
		$kategoria = $kategoria[0];
		echo <<<HEREDOC
		<tr class = "przedmiot" przedmiotId = "$przedmiot[id]" onMouseOver = "zaznacz_rzad(this);" 
					onMouseOut = "if (!this.childNodes[1].childNodes[1].checked) odznacz_rzad(this);">
			<td>
				<input type = "checkbox" name = "zaznacz" value = "$przedmiot[id]" />
			</td>
			<td>
			</td>
			<td class = "edytuj">
				<img class = "klikalne" src = "img/edit.png" onClick = "edytuj_przedmiot(this.parentNode);" /> 
			</td>
			<td class = "usun">
				<img class = "klikalne" src = "img/delete.png" onClick = "usun_przedmiot_potwierdz(this.parentNode);" /> 
			</td>
			<td class = "nazwa">
				$przedmiot[nazwa]
			</td>
			<td class = "koszt">
				$przedmiot[koszt]
			</td>
			<td class = "ilosc">
				$przedmiot[ilosc]
			</td>
			<td class = "kategoria">
				$kategoria
			</td>
			<td class = "obraz">
				$przedmiot[obraz]
			</td>
		</tr>
HEREDOC;
	}
	echo <<<HEREDOC
		<tr class = "koniec">
		<td>
			<input type = "checkbox" id = "admin-przedmioty-selectall" name = "zaznacz" class = "select-all" value = "!wszystko" onClick = "zaznacz_wszystko(this);" />
			<label for = "admin-przedmioty-selectall"></label>
		</td>
		<td>
			<img src = "img/add.png" class = "klikalne" onClick = "dodaj_przedmiot(this.parentNode.parentNode);" />
		</td>
		<td>
			<img src = "img/editall.png" class = "klikalne" onClick = "edytuj_przedmioty(this.parentNode.parentNode.parentNode);" />
		</td>
		<td>
			<img src = "img/deleteall.png" class = "klikalne" onClick = "usun_przedmioty_potwierdz(this.parentNode.parentNode.parentNode);" />
		</td>
		<td colspan = "7">
		</td>
		</tr>
		</table>
		</form>
HEREDOC;
	
?>