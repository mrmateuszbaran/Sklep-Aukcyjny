 <?php
class Aukcja
 {         
  var $czasDoKonca;   
  var $aktualnieProwadzacy;
  var $ostatniLicytujacy;
  var $cena;
  var $wartoscPodbicia;
  var $przedmiot;
        
  function __construct($czasDoKonca, $aktualnieProwadzacy, $ostatniLicytujacy, $przedmiot)
  {
  $this->czasDoKonca = $czasDoKonca;     
  $this->aktualnieProwadzacy = $aktualnieProwadzacy;
  $this->ostatniLicytujacy = $ostatniLicytujacy;
  $this->przedmiot = $przedmiot;
   $this->cena = $przedmiot->$cenaMinimalne;
  }
       

       
 }
  ?> 