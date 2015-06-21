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
	// if no "?" then add "?" instead of "&"
	xmlhttp.open("GET", zapytanie+"&t=" + Math.random(), true);
	xmlhttp.send();
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
	ok.setAttribute("src", "../img/ok.png");
	ok.setAttribute("class", "klikalne");
	ok.style.float = "left";
	ok.style.margin = "5px 0px 0px 10px";
	var nok = document.createElement("img");
	nok.setAttribute("src", "../img/nook.png");
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

function konto(co)
{
	zapytanieAjax("konto_tresc.php?widok="+co, function(odp) { 
				document.getElementById("konto-tresc").innerHTML = odp; 
				init_sprawdz_formularz(document.forms['konto-'+co+'-form']); });
}

function konto_zapisz(form, login)
{
	var imie = form.imie.value;
	var nazwisko = form.nazwisko.value;
	var email = form.email.value;
	var telefon = form.telefon.value;
	
	zapytanieAjax("edytuj.php?co=user&login="+login+"&imie="+imie+"&nazwisko="+nazwisko+"&email="+email+"&telefon="+telefon + 
					"&poziom=stay&kredyty=stay", function(odp) { /*okno_informacji("Zapisano dane");*/ });
}

function konto_zmien_haslo(form)
{
	var stare = form.stare.value;
	var nowe = form.nowe1.value;
	// TODO
	// AJAX POST!
	zapytanieAjax("nowe_haslo.php?stare="+stare+"&nowe="+nowe, function(odp) { alert(odp); });
}

function konto_reset_potwierdz()
{
	okno_potwierdzenia("Czy jesteś pewien, że chcesz zresetować hasło?", function() { zapytanieAjax("reset.php?niepotrzebne=usun", function(odp) { alert(odp); }) });
}

function konto_usun_potwierdz()
{
	okno_potwierdzenia("Czy jesteś pewien, że chcesz usunąć swoje konto? Wszystkie kredyty przepadną bezpowrotnie!", 
						function() { 
							zapytanieAjax("usun.php?niepotrzebne=usun", 
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