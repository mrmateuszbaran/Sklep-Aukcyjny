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
	
	//ajax zapytanie czy login ju¿ istnieje
	return true;
}