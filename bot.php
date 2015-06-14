 <?php
class Bot
 {              
  var $wlasciciel;   
  var $limitPodbic;
  var $czasPodbicia;
  var $aukcja   ;
  var $podbicia;
        
  function __construct($wlasciciel, $limitPodbic, $czasPodbicia)
  {
  $this->wlasciciel = $wlasciciel;     
  $this->limitPodbic = $limitPodbic;
    $this->czasPodbicia = $czasPodbicia;
    $this->podbicia = 0; 
  }
       
  function podbij() 
  {
         if ($wlasciciel->iloscKredytow >= $aukcja->wartoscPodbicia)
        {
         $aukcja->ostatnioLicytujacy = $aukcja->aktualnieProwadzacy;
         $aukcja->aktualnieProwadzacy = $this->wlasciciel   ;
         $wlasciciel->iloscKredytow = $wlasciciel->iloscKredytow - $aukcja->wartoscPodbicia       ;
         $podbicia++;
         }
  }
  
  function ustaw($aukcja)
  {
      if($limitPodbic < $podbicia && $wlasciciel->$iloscKredytow >=0 && $aukcja->$czasDoKonca > 0)
      {
           $this->aukcja = aukcja;   
      }                                                   
  }

       
 }
  ?> 