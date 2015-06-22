function toggle_login_box()
{
	var box = document.getElementById("login_box");
	if (box.style.opacity == "1")
	{
		box.style.opacity = "0";
	} else
	{
		box.style.opacity = "1";
	}
}

function sprawdz_form_rejestracja()
{
	var form = document.forms["form_rejestracja"];
	if (form.login.value.length < 6 || form.haslo.value.length < 6 ||
		form.imie.value.length < 3 || form.nazwisko.value.length < 2 ||
		form.kod1.value.length < 2 || form.kod2.value.length < 3 ||
		form.miejscowosc.value.length < 3 || form.ulica.value.lenght < 4)
	{
		alert("Uzupelnij wszystkie pola");
		return false;
	}
	
	//ajax zapytanie czy login już istnieje
	return true;
}

function toggle_listener(e, ktory)
{	
	var level = 0;
	for (var element = e.target; element; element = element.parentNode) {
		if (element.id === 'div_' + ktory || element.id == ktory) {
			return;
		}
		level++;
	}
	if (ktory == "powiadomienia")
		toggle_powiadomienia();
	else
		toggle_wiadomosci();
}

		
var funkcja_powiadomienia = function (e) { toggle_listener(e, "powiadomienia"); }
var funkcja_wiadomosci = function (e) { toggle_listener(e, "wiadomosci"); }
	
function toggle_powiadomienia()
{
	var div_powiadomienia = document.getElementById("div_powiadomienia");
	
	if (div_powiadomienia == null)
	{
		document.getElementById("powiadomienia").setAttribute("src", "powiadomienie.png");
		nowe_powiadomienia = false;
		// TODO
		// przeczytane = 1 w bazie!
		div_powiadomienia = document.createElement("div");
		div_powiadomienia.setAttribute("id", "div_powiadomienia");
		var img = document.createElement("img");
		img.setAttribute("src", "arrow_up.png");
		img.setAttribute("id", "arrow_powiadomienia");
		document.body.appendChild(img);
		div_powiadomienia.appendChild(document.createTextNode("Powiadomienia"));
		var hr = document.createElement("hr");
		hr.style.marginBottom = "0px";
		div_powiadomienia.appendChild(hr);
		// TODO
		// Diva z treścią zrobić w powiadomienia.php
		// Margines dodać do wewnętrznego diva, tak żeby nie nachodziło na napis "Powiadomienia"
		// Ograniczyć marginesy
		// Jeśli treści więcej to w powiadomienia.php dodać przycisk "Pokaż więcej" (np. max 20 powiadomień)
		
		// vvv zamienić na zapytanieAjax() (?) vvv
		zapytanieAjax("powiadomienia.php?niepotrzebne=usun", 
			function(odp) { 
				div_powiadomienia.innerHTML += odp;
				div_powiadomienia.onwheel = function(e) { 
												var div = document.getElementById("powiadomienia_tresc");
												if (e.deltaY < 0) 
													div.style.marginTop = (parseInt(div.style.marginTop) + div.firstChild.offsetHeight) + "px"; 
												else if (e.deltaY > 0)
													 div.style.marginTop = (parseInt(div.style.marginTop) - div.firstChild.offsetHeight) + "px"; 
												return false; 
											};
			});
		
		document.body.appendChild(div_powiadomienia);
		document.addEventListener('click', funkcja_powiadomienia, true);
	} else
	{
		while (div_powiadomienia.firstChild)
		{
			div_powiadomienia.removeChild(div_powiadomienia.firstChild);
		}
		document.body.removeChild(document.getElementById("arrow_powiadomienia"));
		document.body.removeChild(div_powiadomienia);
		document.removeEventListener("click", funkcja_powiadomienia, true);
	}
}

function toggle_wiadomosci()
{
	var div_wiadomosci = document.getElementById("div_wiadomosci");
	
	if (div_wiadomosci == null)
	{
		div_wiadomosci = document.createElement("div");
		div_wiadomosci.setAttribute("id", "div_wiadomosci");
		var img = document.createElement("img");
		img.setAttribute("src", "arrow_up.png");
		img.setAttribute("id", "arrow_wiadomosci");
		div_wiadomosci.appendChild(img);
		div_wiadomosci.appendChild(document.createTextNode("Wiadomości"));
		div_wiadomosci.appendChild(document.createElement("hr"));
		document.body.appendChild(div_wiadomosci);
		document.addEventListener('click', funkcja_wiadomosci, true);
	} else
	{
		while (div_wiadomosci.firstChild)
		{
			div_wiadomosci.removeChild(div_wiadomosci.firstChild);
		}
		div_wiadomosci.parentNode.removeChild(div_wiadomosci);
		document.removeEventListener("click", funkcja_wiadomosci, true);
	}
}

function init()
{
	ajax();
	ajax_powiadomienia();
	setInterval(function(){ ajax() }, 1000);
	setInterval(function(){ ajax_powiadomienia() }, 5000);
	//zapytanieAjax("powiadomienia.php?niepotrzebne=usun", function(odp) { document.powiadomienia_tresc = odp; });
}

function blink(element, czas) 
{ 
	czas = typeof czas !== 'undefined' ? czas : 400;
	var color = element.style.backGroundColor;
	if (color == "undefined" || color == null)
		color = "transparent";
	element.style.backgroundColor = "white"; 
	setTimeout(function() { element.style.backgroundColor = color; }, czas);
}

var nowe_powiadomienia = false;

function updatePowiadomienia(odp)
{
	// TODO
	// Aktualizuj toggle_powiadomienia jeśli nowe_powiadomienia
	var button = document.getElementById("powiadomienia");
	if (odp.length > 0)
	{
		if (!nowe_powiadomienia)
		{
			blink(button, 500);
			nowe_powiadomienia = true;
			button.setAttribute("src", "powiadomienie_new.png");
			console.log("nowe powiadomienia!");
		}
	} else
	{	
		console.log("brak nowe powiadomienia!");
	}
}

function ajax_powiadomienia()
{
	// TODO
	// Zamiast getpowiadomienia może użyć powiadomienia.php?
	zapytanieAjax("getpowiadomienia.php?niepotrzebne=usun", updatePowiadomienia )
}

// TODO
// Osobny ajax do powiadomień i wiadomości? Co 5-10 sek. Albo tutaj...
// Pobieramy z bazy powiadomienia
// A są dodawane do sesji i bazy danych w momencie gdy user wygrywa, albo gdy wchodzi na stronę już po wygranej

function ajax()
{
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var wynik = xmlhttp.responseText;
			var aukcje = document.getElementsByClassName("aukcja");
			var wynik = wynik.split(";");
			var login = wynik[0];
			for (var i = 1; i < wynik.length - 1; i++)
			{
				var split = wynik[i].split("|");
				var id = split[0].trim();
				var czasDoKonca = split[1].trim();
				var czasKoniec = split[2].trim();
				var cena = split[3].trim();
				var prowadzi = split[4].trim();
				var aukcja = document.getElementById("aukcja"+id);
				if (aukcja && czasDoKonca == "KONIEC!")
				{
					if (prowadzi == login)
					{
						//alert("Wygrałeś aukcję!");
						var pow = document.getElementById("powiadomienia");
						setTimeout(function() { blink(pow, 1250); }, 500);
					}
					blink(aukcja, 500);
					zniszcz(aukcja, 250, 750);
					break;
				}
				if (!aukcja && czasDoKonca != "KONIEC!" && _widok == "aukcje")
				{
					aukcja = dodaj_div_aukcja(split);
					//TODO
					//oddzielić funkcje panelu administratora od tych ze strony głównej!
					//dodawanie aukcji ulepszyć, w odpowiednie miejsce wrzucić
				}
				if (!aukcja)
					continue;
				var aukcjaCzasElement = aukcja.getElementsByClassName("aukcja-czas")[0];
				var aukcjaCenaElement = aukcja.getElementsByClassName("aukcja-cena")[0];
				var aukcjaProwadziElement = aukcja.getElementsByClassName("aukcja-prowadzi")[0];
				if (czasKoniec != aukcjaCzasElement.getAttribute("czasKoniec"))
				{
					blink(aukcjaCzasElement);
					blink(aukcjaCenaElement);
					aukcjaCzasElement.setAttribute("czasKoniec", czasKoniec);
					aukcjaCenaElement.innerHTML = cena / 100;
					aukcjaProwadziElement.innerHTML = prowadzi;
				}
				aukcjaCzasElement.innerHTML = czasDoKonca;
			}
		}
	};
	xmlhttp.open("GET","getinfo.php?t=" + Math.random(),true);
	xmlhttp.send();
}

function dodaj_div_aukcja(dane)
{
	var id = dane[0].trim();
	var czasDoKonca = dane[1].trim();
	var czasKoniec = dane[2].trim();
	var cena = dane[3].trim();
	var prowadzi = dane[4].trim();
	var obraz = "kredyty.png";		// TODO!
	var nazwa = "Nowa aukcja xD"; 	// TODO! Może dodawać w ajax() tylko dla nowych przedmiotów?
	var podbicie = 1; 				// TODO!
	
	
	var div_aukcja = document.createElement("div");
	div_aukcja.setAttribute("class", "aukcja");
	div_aukcja.setAttribute("id", "aukcja"+id);
	div_aukcja.innerHTML = "<div class = \"miniatura\">" +
							"<img src = \"img/przedmioty/"+obraz+"\"></div><br>"+nazwa+"<hr>" +
							"<span class = \"aukcja-cena\">"+cena/100+"</span> zł<br>Prowadzi: <span class = \"aukcja-prowadzi\">"+prowadzi+"</span><br>" +
							"<div class = \"aukcja-czas\" czasKoniec = \""+czasKoniec+"\">"+czasDoKonca+"</div><br>" +
							"<button class = \"aukcja-podbij\" onClick = \"podbij(this,'3');\"> Podbij (x "+podbicie+") </button></div>";
	document.getElementById("tresc_tresc").appendChild(div_aukcja);	// TODO
																	// Dodaj w odpowiednim miejscu!
																	// Uwzględnij stronicowanie...
																	// Pętla po wszystkich aukcjach na stronie?
	return div_aukcja;
}

function podbij(przycisk, aukcjaID)
{
	if (przycisk.disabled)
		return;
	przycisk.disabled = true;
	var color = przycisk.style.background;
	przycisk.style.background = "linear-gradient(to bottom,  #ffffff 0%,#dfefff 100%)";
	setTimeout(function() { przycisk.style.background = color; }, 250);
	setTimeout(function() { przycisk.disabled = false; }, 1000);
	
	var xmlhttp;
	if (window.XMLHttpRequest) { xmlhttp = new XMLHttpRequest(); } else { xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); }
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var odpowiedz = xmlhttp.responseText.split(";");
			var kredyty = odpowiedz[0].trim();
			blink(document.getElementById("uzytkownik-kredyty"));
			document.getElementById("uzytkownik-kredyty").innerHTML = kredyty;
		}
	};
	xmlhttp.open("GET","podbij.php?id="+aukcjaID+"&t=" + Math.random(),true);
	xmlhttp.send();
}

function zaznacz_rzad(rzad)
{
	rzad.style.background = "rgba(0, 0, 0, 0.25)";
}

function odznacz_rzad(rzad)
{
	rzad.style.background = "transparent";
}

function zaznacz_wszystko(checkbox)
{
	var form = checkbox.form;
	var inputs = form.getElementsByTagName('input');
	for (var i = 0; i < inputs.length - 1; i++) 
	{
		if (inputs[i].type == 'checkbox') 
		{
			if (checkbox.checked)
			{
				zaznacz_rzad(inputs[i].parentNode.parentNode);
				inputs[i].checked = true;
			}
			else
			{
				odznacz_rzad(inputs[i].parentNode.parentNode);
				inputs[i].checked = false;
			}
		}
	}
}

function edytuj_uzytkownikow(table)
{
	var rows = table.getElementsByTagName("tr");
	
	for (var i = 1; i < rows.length - 1; i++)
	{
		var checkbox = rows[i].getElementsByTagName("td")[0].childNodes[1];
		if (checkbox && checkbox.checked)
		{
			edytuj_uzytkownika(checkbox.parentNode);
		}
	}
}

function edytuj_uzytkownika(td)
{
	var tr = td.parentNode;
	
	if (tr.edit_row && tr.edit_row.aktywny)
	{
		while (tr.edit_row.firstChild)
			tr.edit_row.removeChild(tr.edit_row.firstChild);
		tr.edit_row.parentNode.removeChild(tr.edit_row);
		
		tr.edit_row.aktywny = false;
	} else
	{
		var edit_row = document.createElement("tr");
		edit_row.setAttribute("userlogin", tr.getAttribute("userLogin"));
		
		var names = new Array("imie", "nazwisko", "email", "telefon", "kredyty", "poziom");
		var colspans = new Array(4, 1, 1, 1, 1, 1, 1, 1);
		var j = 0;
		
		var login = tr.getElementsByClassName('login')[0].innerHTML.trim();
		
		for (var i = 0; i < colspans.length; i++)
		{
			var edit_td = document.createElement("td");
			edit_td.setAttribute("colspan", colspans[i]);
			if (i == 1)	
			{
				var save_icon = document.createElement("img");
				save_icon.setAttribute("src", "img/save.png");
				save_icon.setAttribute("class", "klikalne");
				save_icon.onclick = function() { okno_potwierdzenia("Czy jesteś pewien, że chcesz nadpisać dane użytkownika?", function() { zapisz_uzytkownika(edit_row) }); };
				edit_td.appendChild(save_icon);
			}
			if (i > 1)
			{
				var edit_input = document.createElement("input");
				edit_input.setAttribute("name", names[j]+"["+login+"]");
				edit_input.setAttribute("value", td.parentNode.getElementsByClassName(names[j++])[0].textContent.trim());
				edit_input.style.width = "100%";
				edit_td.appendChild(edit_input);
			}
			edit_row.appendChild(edit_td);
		}
		edit_row.style.background = "rgb(255,255,255)";
		td.parentNode.parentNode.insertBefore(edit_row, td.parentNode.nextSibling);
		setTimeout(function() { blink(edit_row, 150) }, 50);
		
		edit_row.aktywny = true;
		tr.edit_row = edit_row;
	}
}

function edytuj_przedmioty(table)
{
	var rows = table.getElementsByTagName("tr");
	
	for (var i = 1; i < rows.length - 1; i++)
	{
		var checkbox = rows[i].getElementsByTagName("td")[0].childNodes[1];
		if (checkbox && checkbox.checked)
		{
			edytuj_przedmiot(checkbox.parentNode);
		}
	}
}

function edytuj_przedmiot(td)
{
	var tr = td.parentNode;
	
	if (tr.edit_row && tr.edit_row.aktywny)
	{
		while (tr.edit_row.firstChild)
			tr.edit_row.removeChild(tr.edit_row.firstChild);
		tr.edit_row.parentNode.removeChild(tr.edit_row);
		
		tr.edit_row.aktywny = false;
	} else
	{
		var edit_row = document.createElement("tr");
		edit_row.setAttribute("przedmiotId", tr.getAttribute("przedmiotId"));
		
		var names = new Array("nazwa", "koszt", "ilosc", "kategoria", "obraz");
		var colspans = new Array(3, 1, 1, 1, 1, 1, 1);
		var j = 0;
		
		var przedmiotId = tr.getAttribute("przedmiotId");
		
		for (var i = 0; i < colspans.length; i++)
		{
			var edit_td = document.createElement("td");
			edit_td.setAttribute("colspan", colspans[i]);
			if (i == 1)	
			{
				var save_icon = document.createElement("img");
				save_icon.setAttribute("src", "img/save.png");
				save_icon.setAttribute("class", "klikalne");
				save_icon.onclick = function() { okno_potwierdzenia("Czy jesteś pewien, że chcesz nadpisać dane przedmiotu?", function() { zapisz_przedmiot(edit_row) }); };
				edit_td.appendChild(save_icon);
			}
			if (i > 1 && i < 5)
			{
				var edit_input = document.createElement("input");
				edit_input.setAttribute("name", names[j]+"["+przedmiotId+"]");
				edit_input.setAttribute("value", tr.getElementsByClassName(names[j++])[0].textContent.trim());
				edit_input.style.width = "100%";
				edit_td.appendChild(edit_input);
			} else if (i == 5)
			{
				var combo = document.createElement("select");
				combo.setAttribute("name", names[j++]);
				var kategorie = document.getElementsByTagName("kategoria");
				for (var k = 0; k < kategorie.length; k++)
				{
					var nazwa = kategorie[k].getAttribute("nazwa");
					var id = kategorie[k].getAttribute("id");
					var op = document.createElement("option");
					if (tr.getElementsByClassName(names[j-1])[0].textContent.trim() == nazwa)
						op.setAttribute("selected", "selected");
					op.appendChild(document.createTextNode(nazwa));
					op.setAttribute("value", id);
					combo.appendChild(op);
				}
				edit_td.appendChild(combo);
			} else if (i == 6)
			{
				var upload_btn = document.createElement("input");
				upload_btn.setAttribute("name", names[j++]);
				upload_btn.setAttribute("type", "file");
				upload_btn.setAttribute("id", "obraz["+przedmiotId+"]");
				//upload_btn.setAttribute("plik", tr.getElementsByClassName(names[j-1])[0].textContent.trim());
				var upload_label = document.createElement("label");
				upload_label.setAttribute("for", "obraz["+przedmiotId+"]");
				upload_label.appendChild(document.createTextNode(tr.getElementsByClassName(names[j-1])[0].textContent.trim()));
				upload_btn.onchange = function() { upload_label.textContent = upload_btn.value; };
			edit_td.appendChild(upload_btn);
				edit_td.appendChild(upload_label);
			}
			edit_row.appendChild(edit_td);
		}
		edit_row.style.background = "rgb(255,255,255)";
		td.parentNode.parentNode.insertBefore(edit_row, td.parentNode.nextSibling);
		setTimeout(function() { blink(edit_row, 150) }, 50);
		
		edit_row.aktywny = true;
		tr.edit_row = edit_row;
	}
}

var okno_potw = null;
var okno_potw_pokazane = false;
var okno_info_pokazane = false;

function okno_potwierdzenia(wiadomosc, f1, f2)
{
	if (okno_potw_pokazane)
	{
		alert("okno już jest!");
		return;
	}

	okno_potw_pokazane = true;

	var tlo = document.createElement("div");
	tlo.style.background = "rgba(0,0,0,0.75)";
	tlo.style.position = "fixed";
	tlo.style.width = "100%";
	tlo.style.height = "100%";
	tlo.style.left = "0";
	tlo.style.top = "0";
	
	var okno = document.createElement("div");
	okno.setAttribute("id", "okno-potwierdzenia");
	// STYL DO CSSA !
	okno.style.background = "rgba(0,0,0,0.75)";
	okno.style.border = "1px lightblue solid";
	okno.style.position = "fixed";
	okno.style.width = "250px";
	okno.style.height = "180px";
	okno.style.left = "50%";
	okno.style.top = "50%";
	okno.style.margin = "-90px 0px 0px -125px";
	okno.style.textAlign = "center";
	okno.style.padding = "5px";
	okno.style.color = "white";
	
	var gora = document.createElement("div");
	gora.setAttribute("id", "gora");
	gora.style.height = "100px";
	gora.style.display = "table-cell";
	gora.style.verticalAlign = "middle";
	var ok = document.createElement("img");
	ok.setAttribute("src", "img/ok.png");
	ok.setAttribute("class", "klikalne");
	ok.style.float = "left";
	ok.style.margin = "5px 0px 0px 10px";
	var nok = document.createElement("img");
	nok.setAttribute("src", "img/nook.png");
	nok.setAttribute("class", "klikalne");
	nok.style.float = "right";
	nok.style.margin = "5px 10px 0px 0px";
	gora.appendChild(document.createTextNode(wiadomosc));
	okno.appendChild(gora);
	okno.appendChild(document.createElement("hr"));
	okno.appendChild(ok);
	okno.appendChild(nok);
	
	document.body.appendChild(tlo);
	//document.body.appendChild(okno);
	tlo.appendChild(okno);
	
	okno_potw = okno;
	
	ok.onclick = function() { potwierdz(f1); };
	nok.onclick = function() { if (f2) potwierdz(f2); else potwierdz() };
}

function zniszcz(element, op1, op2)
{
	setTimeout(function() { element.style.opacity = "0"; }, op1);
	setTimeout(function() { element.parentNode.removeChild(element); }, op2);
}

function okno_informacji(wiadomosc)
{
	if (okno_info_pokazane)
	{
		alert("okno już jest!");
		return;
	}

	okno_info_pokazane = true;
	
	var okno = document.createElement("div");
	okno.setAttribute("id", "okno-informacji");
	// STYL DO CSSA !
	okno.style.background = "rgba(50,25,125,0.75)";
	okno.style.border = "1px lightblue solid";
	okno.style.position = "fixed";
	okno.style.width = "250px";
	okno.style.height = "180px";
	okno.style.left = "50%";
	okno.style.top = "50%";
	okno.style.margin = "-90px 0px 0px -125px";
	okno.style.textAlign = "center";
	okno.style.padding = "5px";
	okno.style.color = "white";
	
	var gora = document.createElement("div");
	gora.setAttribute("id", "gora");
	gora.style.width = "250px";
	gora.style.height = "100px";
	gora.style.display = "table-cell";
	gora.style.verticalAlign = "middle";
	var ok = document.createElement("img");
	ok.setAttribute("src", "img/ok.png");
	ok.setAttribute("class", "klikalne");
	ok.onclick = function() { ok.onclick = null; zniszcz(okno, 50, 750); setTimeout(function() { okno_info_pokazane = false; }, 750) };
	
	gora.appendChild(document.createTextNode(wiadomosc));
	okno.appendChild(gora);
	okno.appendChild(document.createElement("hr"));
	okno.appendChild(ok);
	
	document.body.appendChild(okno);
}

function okno_bledu(wiadomosc)
{
	
}

function zapisz_uzytkownika(tr)
{
	var login = tr.getAttribute("userLogin");
	var imie = tr.getElementsByTagName("input")[0].value;
	var nazwisko = tr.getElementsByTagName("input")[1].value;
	var email = tr.getElementsByTagName("input")[2].value;
	var telefon = tr.getElementsByTagName("input")[3].value;
	var kredyty = tr.getElementsByTagName("input")[4].value;
	var poziom = tr.getElementsByTagName("input")[5].value;
	
	var xmlhttp;
	if (window.XMLHttpRequest) { xmlhttp = new XMLHttpRequest(); } else { xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); }
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			if (parseInt(xmlhttp.responseText) > 0)
			{
				blink(tr);
				blink(tr.previousSibling);
				setTimeout(function() { 
					tr.previousSibling.getElementsByClassName("imie")[0].innerHTML = imie;
					tr.previousSibling.getElementsByClassName("nazwisko")[0].innerHTML = nazwisko;
					tr.previousSibling.getElementsByClassName("email")[0].innerHTML = email;
					tr.previousSibling.getElementsByClassName("telefon")[0].innerHTML = telefon;
					tr.previousSibling.getElementsByClassName("kredyty")[0].innerHTML = kredyty;
					tr.previousSibling.getElementsByClassName("poziom")[0].innerHTML = poziom;
					edytuj_uzytkownika(tr.previousSibling.getElementsByClassName("edytuj")[0]);
				}, 500);
			}
			else
			{
				okno_informacji(xmlhttp.responseText);
			}
		}
	};

	xmlhttp.open("POST","edytuj.php?co=user&t=" + Math.random(),true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("login="+login+"&imie="+imie+"&nazwisko="+nazwisko+"&email="+email+"&telefon="+telefon+"&kredyty="+kredyty+"&poziom="+poziom);
}

function zapisz_nowa_aukcja(tr)
{
	var start = tr.getElementsByTagName("input")[0].value;
	var koniec = tr.getElementsByTagName("input")[1].value;
	var cena = tr.getElementsByTagName("input")[2].value;
	var podbicie = tr.getElementsByTagName("input")[3].value;
	
	var xmlhttp;
	if (window.XMLHttpRequest) { xmlhttp = new XMLHttpRequest(); } else { xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); }
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			if (parseInt(xmlhttp.responseText) > 0)
			{
				blink(tr);
				tr.setAttribute("class", "aukcja");
				tr.setAttribute("aukcjaId", xmlhttp.responseText);
				
				tr.innerHTML = " <td> \
									<input type = \"checkbox\" name = \"zaznacz\" value = \""+xmlhttp.responseText+"\" />\
								</td>\
								<td> \
									<img src = \"img/addpen.png\" title = \"Dodaj przedmiot\" class = \"klikalne\" onClick = \"dodaj_aukcja_przedmiot(this.parentNode.parentNode);\" />\
								</td>\
								<td class = \"edytuj\"> \
									<img class = \"klikalne\" src = \"img/edit.png\" onClick = \"edytuj_aukcja(this.parentNode);\" /> \
								</td>\
								<td class = \"usun\"> \
									<img class = \"klikalne\" src = \"img/delete.png\" onClick = \"usun_aukcja_potwierdz(this.parentNode);\" /> \
								</td>\
								<td class = \"start\"> \
									"+start+"\
								</td>\
								<td class = \"koniec\"> \
									"+koniec+"\
								</td>\
								<td class = \"cena\"> \
									"+(parseInt(cena) > 0 ? cena : 0)+"\
								</td>\
								<td class = \"podbicie\"> \
									"+(parseInt(podbicie) > 0 ? podbicie : 1)+"\
								</td>\
								<td class = \"prowadzi\"> \
								</td>";
				tr.onmouseover = function() { zaznacz_rzad(this); };
				tr.onmouseout = function() { if (!this.childNodes[1].childNodes[1].checked) odznacz_rzad(this); };
			}
			else
			{
				okno_informacji(xmlhttp.responseText);
			}
		}
	};

	xmlhttp.open("POST","dodaj.php?co=aukcja&start="+start+"&koniec="+koniec+"&cena="+cena+"&podbicie="+podbicie+"&t=" + Math.random(),true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send();
}

function zapisz_aukcja(tr)
{
	var id = tr.getAttribute("aukcjaId");
	var start = tr.getElementsByTagName("input")[0].value;
	var koniec = tr.getElementsByTagName("input")[1].value;
	var cena = tr.getElementsByTagName("input")[2].value;
	var podbicie = tr.getElementsByTagName("input")[3].value;
	
	var xmlhttp;
	if (window.XMLHttpRequest) { xmlhttp = new XMLHttpRequest(); } else { xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); }
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			if (parseInt(xmlhttp.responseText) > 0)
			{
				blink(tr);
				blink(tr.previousSibling);
				setTimeout(function() { 
					tr.previousSibling.getElementsByClassName("start")[0].innerHTML = start;
					tr.previousSibling.getElementsByClassName("koniec")[0].innerHTML = koniec;
					tr.previousSibling.getElementsByClassName("cena")[0].innerHTML = cena;
					tr.previousSibling.getElementsByClassName("podbicie")[0].innerHTML = podbicie;
					edytuj_aukcja(tr.previousSibling.getElementsByClassName("edytuj")[0]);
				}, 500);
			}
			else
			{
				okno_informacji(xmlhttp.responseText);
			}
		}
	};

	xmlhttp.open("POST","edytuj.php?co=aukcja&t=" + Math.random(),true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("id="+id+"&start="+start+"&koniec="+koniec+"&cena="+cena+"&podbicie="+podbicie);
}

function zapisz_nowy_przedmiot(tr)
{
	var nazwa = tr.getElementsByTagName("input")[0].value;
	var koszt = tr.getElementsByTagName("input")[1].value;
	var ilosc = tr.getElementsByTagName("input")[2].value;
	var kategoria = tr.getElementsByTagName("select")[0].value;
	var obraz = tr.getElementsByTagName("input")[3].value;
	
	var xmlhttp;
	if (window.XMLHttpRequest) { xmlhttp = new XMLHttpRequest(); } else { xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); }
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			if (parseInt(xmlhttp.responseText) > 0)
			{
				blink(tr);
				tr.setAttribute("class", "przedmiot");
				tr.setAttribute("przedmiotId", xmlhttp.responseText);
				
				
				var combo = tr.getElementsByTagName("select")[0];
				var kategoriaString = combo.options[combo.selectedIndex].textContent.trim();
				
				tr.innerHTML = " <td> \
									<input type = \"checkbox\" name = \"zaznacz\" value = \""+xmlhttp.responseText+"\" />\
								</td>\
								<td> \
								</td>\
								<td class = \"edytuj\"> \
									<img class = \"klikalne\" src = \"img/edit.png\" onClick = \"edytuj_przedmiot(this.parentNode);\" /> \
								</td>\
								<td class = \"usun\"> \
									<img class = \"klikalne\" src = \"img/delete.png\" onClick = \"usun_przedmiot_potwierdz(this.parentNode);\" /> \
								</td>\
								<td class = \"nazwa\"> \
									"+nazwa+"\
								</td>\
								<td class = \"koszt\"> \
									"+koszt+"\
								</td>\
								<td class = \"ilosc\"> \
									"+ilosc+"\
								</td>\
								<td class = \"kategoria\"> \
									"+kategoriaString+"\
								</td>\
								<td class = \"obraz\"> \
									"+obraz+"\
								</td>";
				tr.onmouseover = function() { zaznacz_rzad(this); };
				tr.onmouseout = function() { if (!this.childNodes[1].childNodes[1].checked) odznacz_rzad(this); };
			}
			else
			{
				okno_informacji(xmlhttp.responseText);
			}
		}
	};

	xmlhttp.open("POST","dodaj.php?co=przedmiot&nazwa="+nazwa+"&koszt="+koszt+"&ilosc="+ilosc+"&kategoria="+kategoria+"&obraz="+obraz+"&t=" + Math.random(),true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send();
}

function zapisz_przedmiot(tr)
{
	var id = tr.getAttribute("przedmiotId");
	var nazwa = tr.getElementsByTagName("input")[0].value;
	var koszt = tr.getElementsByTagName("input")[1].value;
	var ilosc = tr.getElementsByTagName("input")[2].value;
	var kategoria = tr.getElementsByTagName("select")[0].value;
	var obraz = tr.getElementsByTagName("label")[0].innerHTML;
	//var obraz_input = tr.getElementsByTagName("input")[3];
	//var obraz = (obraz_input.value != "" ? obraz_input.value : obraz_input.getAttribute("plik"));
	
	var xmlhttp;
	if (window.XMLHttpRequest) { xmlhttp = new XMLHttpRequest(); } else { xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); }
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			if (parseInt(xmlhttp.responseText) > 0)
			{
				blink(tr);
				blink(tr.previousSibling);
				setTimeout(function() { 
					tr.previousSibling.getElementsByClassName("nazwa")[0].innerHTML = nazwa;
					tr.previousSibling.getElementsByClassName("koszt")[0].innerHTML = koszt;
					tr.previousSibling.getElementsByClassName("ilosc")[0].innerHTML = ilosc;
					var combo = tr.getElementsByTagName("select")[0];
					tr.previousSibling.getElementsByClassName("kategoria")[0].innerHTML = combo.options[combo.selectedIndex].textContent.trim();
					tr.previousSibling.getElementsByClassName("obraz")[0].innerHTML = obraz;
					edytuj_przedmiot(tr.previousSibling.getElementsByClassName("edytuj")[0]);
				}, 500);
			}
			else
			{
				okno_informacji(xmlhttp.responseText);
			}
		}
	};

	xmlhttp.open("POST","edytuj.php?co=przedmiot&t=" + Math.random(),true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("id="+id+"&nazwa="+nazwa+"&koszt="+koszt+"&ilosc="+ilosc+"&kategoria="+kategoria+"&obraz="+obraz);
}

function potwierdz(funkcja)
{
	if (funkcja)
		funkcja();
	while(okno_potw.firstChild)
		okno_potw.removeChild(okno_potw.firstChild);
	var tlo = okno_potw.parentNode;
	tlo.removeChild(okno_potw);
	document.body.removeChild(tlo);
	okno_potw_pokazane = false;
	okno_potw = null;
}

function usun_uzytkownikow(table)
{
	var rows = table.getElementsByTagName("tr");
	
	for (var i = 1; i < rows.length - 1; i++)
	{
		var checkbox = rows[i].getElementsByTagName("td")[0].childNodes[1];
		if (checkbox && checkbox.checked)
		{
			usun_uzytkownika(checkbox.parentNode);
		}
	}
}

function usun_uzytkownika(td)
{
	var login = td.parentNode.getElementsByClassName("login")[0].innerHTML.trim();
	
	var xmlhttp;
	if (window.XMLHttpRequest) { xmlhttp = new XMLHttpRequest(); } else { xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); }
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			if (parseInt(xmlhttp.responseText) > 0)
			{
				zniszcz(td.parentNode, 0, 500);
			} else 
			{
				okno_bledu(xmlhttp.responseText);
			}
		}
	};
	xmlhttp.open("GET","usun.php?co=user&login="+login+"&t=" + Math.random(),true);
	xmlhttp.send();
}

function usun_aukcje(table)
{
	var rows = table.getElementsByTagName("tr");
	
	for (var i = 1; i < rows.length - 1; i++)
	{
		var checkbox = rows[i].getElementsByTagName("td")[0].childNodes[1];
		if (checkbox && checkbox.checked)
		{
			usun_aukcja(checkbox.parentNode);
		}
	}
}

function usun_aukcja(td)
{
	var id = td.parentNode.getAttribute("aukcjaId");
	
	var xmlhttp;
	if (window.XMLHttpRequest) { xmlhttp = new XMLHttpRequest(); } else { xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); }
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			if (parseInt(xmlhttp.responseText) > 0)
			{
				//zniszcz(td.parentNode, 0, 500);
				var row = td.parentNode;
				while (row.nextSibling.className == "aukcja_przedmiot")
				{
					zniszcz(row, 0, 500);
					row = row.nextSibling;
				}
				zniszcz(row, 0, 500);
			} else 
			{
				okno_bledu(xmlhttp.responseText);
			}
		}
	};
	xmlhttp.open("GET","usun.php?co=aukcja&id="+id+"&t=" + Math.random(),true);
	xmlhttp.send();
}

function usun_przedmioty(table)
{
	var rows = table.getElementsByTagName("tr");
	
	for (var i = 1; i < rows.length - 1; i++)
	{
		var checkbox = rows[i].getElementsByTagName("td")[0].childNodes[1];
		if (checkbox && checkbox.checked)
		{
			usun_przedmiot(checkbox.parentNode);
		}
	}
}

function usun_przedmiot(td)
{
	var id = td.parentNode.getAttribute("przedmiotId");
	
	var xmlhttp;
	if (window.XMLHttpRequest) { xmlhttp = new XMLHttpRequest(); } else { xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); }
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			if (parseInt(xmlhttp.responseText) > 0)
			{
				zniszcz(td.parentNode, 0, 500);
			} else 
			{
				okno_bledu(xmlhttp.responseText);
			}
		}
	};
	xmlhttp.open("GET","usun.php?co=przedmiot&id="+id+"&t=" + Math.random(),true);
	xmlhttp.send();
}

function usun_uzytkownikow_potwierdz(table)
{
	okno_potwierdzenia("Czy na pewno chcesz usunąć wybranych użytkowników?", function() { usun_uzytkownikow(table); });
}

function usun_uzytkownika_potwierdz(td)
{
	okno_potwierdzenia("Czy na pewno chcesz usunąć wybranego użytkownika?", function() { usun_uzytkownika(td); });
}

function usun_aukcja_potwierdz(td)
{
	okno_potwierdzenia("Czy na pewno chcesz usunąć wybraną aukcję?", function() { usun_aukcja(td); });
}

function usun_aukcje_potwierdz(table)
{
	okno_potwierdzenia("Czy na pewno chcesz usunąć wybrane aukcje?", function() { usun_aukcje(table); });
}

function usun_przedmiot_potwierdz(td)
{
	okno_potwierdzenia("Czy na pewno chcesz usunąć wybrany przedmiot?", function() { usun_przedmiot(td); });
}

function usun_przedmioty_potwierdz(table)
{
	okno_potwierdzenia("Czy na pewno chcesz usunąć wybrane przedmioty?", function() { usun_przedmioty(td); });
}

function przywroc_haslo(td)
{
	var login = td.parentNode.getElementsByClassName("login")[0].innerHTML.trim();
	
	var xmlhttp;
	if (window.XMLHttpRequest) { xmlhttp = new XMLHttpRequest(); } else { xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); }
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			if (parseInt(xmlhttp.responseText) > 0)
			{
				okno_informacji(xmlhttp.responseText);	//kasuj to potem
			} else 
			{
				//okno_bledu(xmlhttp.responseText);
				okno_informacji(xmlhttp.responseText);	//kasuj to potem
			}
		}
	};
	xmlhttp.open("GET","przywroc.php?login="+login+"&t=" + Math.random(),true);
	xmlhttp.send();
}

function przywroc_haslo_potwierdz(td)
{
	okno_potwierdzenia("Czy na pewno chcesz zresetować hasło tego użytkownika?", function() { przywroc_haslo(td); });
}

function edytuj_aukcja(td)
{
	var tr = td.parentNode;
	
	if (tr.edit_row && tr.edit_row.aktywny)
	{
		while (tr.edit_row.firstChild)
			tr.edit_row.removeChild(tr.edit_row.firstChild);
		tr.edit_row.parentNode.removeChild(tr.edit_row);
		
		tr.edit_row.aktywny = false;
	} else
	{
		var edit_row = document.createElement("tr");
		edit_row.setAttribute("aukcjaId", tr.getAttribute("aukcjaId"));
		
		var names = new Array("start", "koniec", "cena", "podbicie", "prowadzi");
		var colspans = new Array(3, 1, 1, 1, 1, 1, 1);
		var j = 0;
		
		var id = tr.getAttribute('aukcjaId');
		
		for (var i = 0; i < colspans.length; i++)
		{
			var edit_td = document.createElement("td");
			edit_td.setAttribute("colspan", colspans[i]);
			if (i == 1)
			{
				var save_icon = document.createElement("img");
				save_icon.setAttribute("src", "img/save.png");
				save_icon.setAttribute("class", "klikalne");
				save_icon.onclick = function() { okno_potwierdzenia("Czy jesteś pewien, że chcesz nadpisać dane aukcji?", function() { zapisz_aukcja(edit_row) }); };
				edit_td.appendChild(save_icon);
			}
			if (i > 1 && i < colspans.length - 1)
			{
				var edit_input = document.createElement("input");
				edit_input.setAttribute("name", names[j]+"["+id+"]");
				edit_input.setAttribute("value", td.parentNode.getElementsByClassName(names[j++])[0].textContent.trim());
				edit_input.style.width = "100%";
				edit_td.appendChild(edit_input);
			}
			edit_row.appendChild(edit_td);
		}
		edit_row.style.backgroundColor = "rgb(255,255,255)";
		td.parentNode.parentNode.insertBefore(edit_row, td.parentNode.nextSibling);
		setTimeout(function() { blink(edit_row, 150) }, 50);
		
		edit_row.aktywny = true;
		tr.edit_row = edit_row;
	}
}


function edytuj_aukcje(table)
{
	var rows = table.getElementsByTagName("tr");
	
	for (var i = 1; i < rows.length - 1; i++)
	{
		var checkbox = rows[i].getElementsByTagName("td")[0].childNodes[1];
		if (checkbox && checkbox.checked)
		{
			edytuj_aukcja(checkbox.parentNode);
		}
	}
}

function zapytanieAjax(zapytanie, f_powodzenie, f_blad)
{
	var xmlhttp;
	if (window.XMLHttpRequest) { xmlhttp = new XMLHttpRequest(); } else { xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); }
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			if (f_powodzenie)
				f_powodzenie(xmlhttp.responseText);
		}
	};
	xmlhttp.open("GET", zapytanie+"&t=" + Math.random(), true);
	xmlhttp.send();
}

function dodaj_aukcja_przedmiot(tr)
{
	var last_row = tr;
	if (tr.nextSibling.className == "koniec")
	{
		last_row = last_row.nextSibling;
	} else
	{
		while(last_row.nextSibling.className != "koniec" && last_row.nextSibling.className != "aukcja")
		{
			last_row = last_row.nextSibling;
		}
	}
	
	var combo = document.createElement("select");
	var przedmioty = document.getElementsByTagName("przedmiot");
	for (var i = 0; i < przedmioty.length; i++)
	{
		var nazwa = przedmioty[i].getAttribute("nazwa");
		var id = przedmioty[i].getAttribute("id");
		var op = document.createElement("option");
		op.appendChild(document.createTextNode(nazwa));
		op.setAttribute("value", id);
		combo.appendChild(op);
	}
	
	var add_row = document.createElement("tr");
	add_row.style.backGroundColor = "rgba(255,255,255,0.5)";
	var add_td1 = document.createElement("td");
	add_td1.setAttribute("colspan", "8");
	add_td1.appendChild(combo);
	add_td1.style.textAlign = "right";
	var add_td2 = document.createElement("td");
	add_td2.setAttribute("colspan", "1");
	var add_delete = document.createElement("img");
	add_delete.setAttribute("src", "img/delete.png");
	add_delete.setAttribute("class", "klikalne");
	add_delete.onclick = function() { zniszcz(add_row, 0, 250); };
	var add_save = document.createElement("img");
	add_save.setAttribute("src", "img/save.png");
	add_save.setAttribute("class", "klikalne");
	add_save.onclick = function() { 	
									var aukcjaId = tr.getAttribute("aukcjaId");
									var przedmiotId = combo.value;
									zapytanieAjax("dodaj.php?co=aukcja_przedmiot&aukcja="+aukcjaId+"&przedmiot="+przedmiotId, 
												function(res) { 
													if (res != "1")
													{
														okno_bledu("Przedmiot już istnieje w tej aukcji!");
													}
													else 
													{
														add_row.innerHTML = "<tr>"+
														"<td colspan = \"8\" style = \"text-align:right;\">"+
															combo.options[combo.selectedIndex].innerHTML+
														"</td><td>"+
															"<img src = \"img/delete.png\" class = \"klikalne\" onClick = \"usun_aukcja_przedmiot(this.parentNode.parentNode);\" />"+
														"</td></tr>";
														add_row.setAttribute("class", "aukcja_przedmiot");
														add_row.setAttribute("przedmiotId", przedmiotId);
														add_row.setAttribute("aukcjaId", aukcjaId);
													}
												}); 
								};
	add_td2.appendChild(add_delete);
	add_td2.appendChild(add_save);
	add_row.appendChild(add_td1);
	add_row.appendChild(add_td2);
	tr.parentNode.insertBefore(add_row, last_row);
	blink(add_row, 50);	
}

function dodaj_aukcja(tr)
{
	var add_row = document.createElement("tr");
	add_row.style.backgroundColor = "rgba(255,255,255,0.75)";
	var add_td1 = document.createElement("td");
	add_td1.setAttribute("colspan", "2");
	var add_td2 = document.createElement("td");
	add_td2.setAttribute("colspan", "1");
	var add_td3 = document.createElement("td");
	add_td3.setAttribute("colspan", "1");
	var add_save = document.createElement("img");
	add_save.setAttribute("src", "img/save.png");
	add_save.setAttribute("class", "klikalne");
	add_save.onclick = function() { zapisz_nowa_aukcja(add_row) };
	var add_delete = document.createElement("img");
	add_delete.setAttribute("src", "img/delete.png");
	add_delete.setAttribute("class", "klikalne");
	add_delete.onclick = function() { zniszcz(add_row, 0, 250); };
	add_td2.appendChild(add_save);
	add_td3.appendChild(add_delete);
	add_row.appendChild(add_td1);
	add_row.appendChild(add_td2);
	add_row.appendChild(add_td3);
	var names = new Array("start", "koniec", "cena", "podbicie", "prowadzi");
	var colspans = new Array(1, 1, 1, 1, 1);
	var j = 0;
	
	for (var i = 0; i < colspans.length; i++)
	{
		var td = document.createElement("td");
		td.setAttribute("colspan", colspans[i]);
		if (i < colspans.length - 1)
		{
			var edit_input = document.createElement("input");
			edit_input.setAttribute("name", names[j++]);
			if (i < 2)
			{
				var data = new Date();
				var dataString = data.getFullYear()+"-"+(data.getMonth() < 10 ? "0"+data.getMonth() : data.getMonth())+"-"+
								(data.getDate() < 10 ? "0"+data.getDate() : data.getDate())+" "+
								(data.getHours() < 10 ? "0"+data.getHours() : data.getHours())+":"+
								(data.getMinutes() < 10 ? "0"+data.getMinutes() : data.getMinutes())+":"+
								(data.getSeconds() < 10 ? "0"+data.getSeconds() : data.getSeconds());
				edit_input.setAttribute("value", dataString);
			}
			edit_input.style.width = "100%";
			td.appendChild(edit_input);
		}
		add_row.appendChild(td);
	}
	tr.parentNode.insertBefore(add_row, tr);
}

function usun_aukcja_przedmiot(tr)
{
	var przedmiotId = tr.getAttribute("przedmiotId");
	var aukcjaId = tr.getAttribute("aukcjaId");
	
	zapytanieAjax("usun.php?co=aukcja_przedmiot&aukcja="+aukcjaId+"&przedmiot="+przedmiotId, 
					function(response) { 
						if (response == "1") 
							zniszcz(tr, 0, 500);
						else 
							okno_bledu(response);
					});
}

function dodaj_przedmiot(tr)
{
	var add_row = document.createElement("tr");
	add_row.style.backgroundColor = "rgba(255,255,255,0.75)";
	var add_td1 = document.createElement("td");
	add_td1.setAttribute("colspan", "2");
	var add_td2 = document.createElement("td");
	add_td2.setAttribute("colspan", "1");
	var add_td3 = document.createElement("td");
	add_td3.setAttribute("colspan", "1");
	var add_save = document.createElement("img");
	add_save.setAttribute("src", "img/save.png");
	add_save.setAttribute("class", "klikalne");
	add_save.onclick = function() { zapisz_nowy_przedmiot(add_row) };
	var add_delete = document.createElement("img");
	add_delete.setAttribute("src", "img/delete.png");
	add_delete.setAttribute("class", "klikalne");
	add_delete.onclick = function() { zniszcz(add_row, 0, 250); };
	add_td2.appendChild(add_save);
	add_td3.appendChild(add_delete);
	add_row.appendChild(add_td1);
	add_row.appendChild(add_td2);
	add_row.appendChild(add_td3);
	var names = new Array("nazwa", "koszt", "ilosc", "kategoria", "obraz");
	var colspans = new Array(1, 1, 1, 1, 1);
	var j = 0;
	
	for (var i = 0; i < colspans.length; i++)
	{
		var td = document.createElement("td");
		td.setAttribute("colspan", colspans[i]);
		if (i < 3)
		{
			var edit_input = document.createElement("input");
			edit_input.setAttribute("name", names[j++]);
			edit_input.style.width = "100%";
			td.appendChild(edit_input);
		} else if (i == 3)
		{
			var combo = document.createElement("select");
			combo.setAttribute("name", names[j++]);
			var kategorie = document.getElementsByTagName("kategoria");
			for (var i = 0; i < kategorie.length; i++)
			{
				var nazwa = kategorie[i].getAttribute("nazwa");
				var id = kategorie[i].getAttribute("id");
				var op = document.createElement("option");
				op.appendChild(document.createTextNode(nazwa));
				op.setAttribute("value", id);
				combo.appendChild(op);
			}
			td.appendChild(combo);
		} else
		{
			var upload_btn = document.createElement("input");
			upload_btn.setAttribute("name", names[j++]);
			upload_btn.setAttribute("type", "file");
			upload_btn.setAttribute("value", "Przeglądaj");
			td.appendChild(upload_btn);
		}
		add_row.appendChild(td);
	}
	tr.parentNode.insertBefore(add_row, tr);
}

function panel(widok)
{
	zapytanieAjax("admin/panel_tresc.php?widok="+widok, function(response) { document.getElementById('panel_tresc').innerHTML = response; });
}

var _widok = 'aukcje';

function tresc(widok)
{
	_widok = widok;
	zapytanieAjax("tresc.php?widok="+widok, function(response) { document.getElementById('tresc').innerHTML = response; });
}


function konto(co)
{
	zapytanieAjax("konto/konto_tresc.php?widok="+co, function(odp) { 
				document.getElementById("konto-tresc").innerHTML = odp; 
				init_sprawdz_formularz(document.forms['konto-'+co+'-form']); });
}

function konto_zapisz(form, login)
{
	var imie = form.imie.value;
	var nazwisko = form.nazwisko.value;
	var email = form.email.value;
	var telefon = form.telefon.value;
	
	zapytanieAjax("konto/edytuj.php?co=user&login="+login+"&imie="+imie+"&nazwisko="+nazwisko+"&email="+email+"&telefon="+telefon + 
					"&poziom=stay&kredyty=stay", function(odp) { /*okno_informacji("Zapisano dane");*/ });
}

function konto_zmien_haslo(form)
{
	var stare = form.stare.value;
	var nowe = form.nowe1.value;
	// TODO
	// AJAX POST!
	zapytanieAjax("konto/nowe_haslo.php?stare="+stare+"&nowe="+nowe, function(odp) { alert(odp); });
}

function konto_reset_potwierdz()
{
	okno_potwierdzenia("Czy jesteś pewien, że chcesz zresetować hasło?", function() { zapytanieAjax("reset.php?niepotrzebne=usun", function(odp) { alert(odp); }) });
}

function konto_usun_potwierdz()
{
	okno_potwierdzenia("Czy jesteś pewien, że chcesz usunąć swoje konto? Wszystkie kredyty przepadną bezpowrotnie!", 
						function() { 
							zapytanieAjax("konto/usun.php?niepotrzebne=usun", 
							function(odp) { 
								if (parseInt(odp) > 0) 
									location.reload(); 
							}) 
						});	
}

function sprawdz_formularz(form)
{
	if (!form)
		return;
	switch (form.name)
	{
		case "konto-dane-form":
			//sprawdz wszystkie pola
			var imie = form.imie.value;
			var nazwisko = form.nazwisko.value;
			var email = form.email.value;
			var telefon = form.telefon.value;
			if (imie.length < 2 || nazwisko.length < 2 || 
			//	!/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i.test(email) ||
				!/^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/.test(email) ||
				(telefon.length > 0 && telefon.length < 9) || /[a-z]/i.test(telefon))
				form.zapisz.disabled = true;
			else
				form.zapisz.disabled = false;				
			break;
		case "konto-haslo-form":
			var stare = form.stare;
			var nowe1 = form.nowe1;
			var nowe2 = form.nowe2;
			if (nowe1.value == nowe2.value && nowe1.value.length >= 6)
			{
				form.zapisz.disabled = false;
			} else
			{
				form.zapisz.disabled = true;
			}
			break;
		default:
	}
}

var sprawdz_formularz_interval = null;

function init_sprawdz_formularz(form)
{
	if (sprawdz_formularz_interval != null)
		clearInterval(sprawdz_formularz_interval);
	sprawdz_formularz_interval = setInterval(function() { sprawdz_formularz(form); }, 100);
}