<?php

	require_once "../baza.php";

	$zapytanie = mysql_query("SELECT * FROM aukcje");
	
	$przedmioty_zap = mysql_query("SELECT * FROM przedmioty");
	while ($przedmiot = mysql_fetch_assoc($przedmioty_zap))
	{
		echo "<przedmiot nazwa = \"$przedmiot[nazwa]\" id = \"$przedmiot[id]\"></przedmiot>\n";
	}
	
	// form
	echo <<<HEREDOC
	<form name = "admin-aukcje-form">
	<table id = "admin-aukcje" cellspacing = "0">
		<tr>
			<td colspan = "4" style = "width:15px;"></td>
			<td style = "width:140px;">Start</td>
			<td style = "width:140px;">Koniec</td>
			<td style = "width:80px;">Cena</td>
			<td style = "width:60px;">Podbicie</td>
			<td style = "width:120px;">Prowadzi</td>
		</tr>
HEREDOC;
	
	
	while ($aukcja = mysql_fetch_assoc($zapytanie))
	{	
		echo <<<HEREDOC
		<tr class = "aukcja_tr" aukcjaId = "$aukcja[id]" onMouseOver = "zaznacz_rzad(this);" 
					onMouseOut = "if (!this.childNodes[1].childNodes[1].checked) odznacz_rzad(this);">
			<td>
				<input type = "checkbox" name = "zaznacz" value = "$aukcja[id]" />
			</td>
			<td>
				<img src = "img/addpen.png" title = "Dodaj przedmiot" class = "klikalne" onClick = "dodaj_aukcja_przedmiot(this.parentNode.parentNode);" />
			</td>
			<td class = "edytuj">
				<img class = "klikalne" src = "img/edit.png" onClick = "edytuj_aukcja(this.parentNode);" /> 
			</td>
			<td class = "usun">
				<img class = "klikalne" src = "img/delete.png" onClick = "usun_aukcja_potwierdz(this.parentNode);" /> 
			</td>
			<td class = "start">
				$aukcja[czas_start]
			</td>
			<td class = "koniec">
				$aukcja[czas_koniec]
			</td>
			<td class = "cena">
				$aukcja[cena]
			</td>
			<td class = "podbicie">
				$aukcja[wartosc_podbicia]
			</td>
			<td class = "prowadzi">
				$aukcja[prowadzi]
			</td>
		</tr>
HEREDOC;
		$przedmioty_zap = mysql_query("SELECT * FROM przedmioty JOIN aukcja_przedmiot ON przedmioty.id = aukcja_przedmiot.przedmiotId
													WHERE aukcjaId = '$aukcja[id]'");
		while ($przedmiot = mysql_fetch_assoc($przedmioty_zap))
		{
			echo <<<HEREDOC
			<tr class = "aukcja_przedmiot" style = "background-color:rgba(255,255,255,0.5);" przedmiotId = "$przedmiot[id]" aukcjaId = "$aukcja[id]">
			<td colspan = "8" style = "text-align:right;"> $przedmiot[nazwa] </td>
			<td>
				<img src = "img/delete.png" class = "klikalne" onClick = "usun_aukcja_przedmiot(this.parentNode.parentNode);" />
			</td>
			</tr>
HEREDOC;
		}
	}
	echo <<<HEREDOC
		<tr class = "koniec">
		<td>
			<input type = "checkbox" id = "admin-aukcje-selectall" name = "zaznacz" class = "select-all" value = "!wszystko" onClick = "zaznacz_wszystko(this);" />
			<label for = "admin-aukcje-selectall"></label>
		</td>
		<td>
			<img src = "img/add.png" class = "klikalne" onClick = "dodaj_aukcja(this.parentNode.parentNode);" />
		</td>
		<td>
			<img src = "img/editall.png" class = "klikalne" onClick = "edytuj_aukcje(this.parentNode.parentNode.parentNode);" />
		</td>
		<td>
			<img src = "img/deleteall.png" class = "klikalne" onClick = "usun_aukcje_potwierdz(this.parentNode.parentNode.parentNode);" />
		</td>
		<td colspan = "7">
		</td>
		</tr>
		</table>
		</form>
HEREDOC;
	
?>