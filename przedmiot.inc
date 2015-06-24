
<?php
class Przedmiot
 {    
  var $nazwa;
  var $opis;
  var $cenaPoczatkowa;
  var $cenaMinimalna;
  var $ktoDodal;
        
  function __construct($nazwa , $opis , $cenaPoczatkowa, $cenaMinimalna, $ktoDodal)
  {
  $this->nazwa = $nazwa;
  $this->opis = $opis;
  $this->cenaPoczatkowa = $cenaPoczatkowa ;
  $this->cenaMinimalna = $cenaMinimalna;
  $this->ktoDodal = $ktoDodal;
  }
       
 
       
 }
  ?> 