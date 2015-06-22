<?php

class Uzytkownik
{
	var $login;
	var $imie;
	var $nazwisko;
	var $adres;
	var $email;
	var $haslo;
	var $kredyty;
	var $poziom;
	
	public function __construct($login, $imie, $nazwisko, $adres, $email, $haslo, $kredyty, $poziom)
	{
		$this->login = $login;
		$this->imie = $imie;
		$this->nazwisko = $nazwisko;
		$this->adres = $adres;
		$this->email = $email;
		$this->haslo = $haslo;
		$this->kredyty = $kredyty;
		$this->poziom = $poziom;
	}
	
	function zmienHaslo(String $nowe)
	{
		return false;
	}
	
	//function wyswietlAukcje(Aukcja $aukcja)
	//{
	//}
}

?>