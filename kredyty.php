<?php
	require_once "uzytkownik.inc";
	session_start();
	
	if (!isset($_SESSION['uzytkownik']))
	{
		echo "ERROR:Brak uprawnień!";
		exit();
	}
	
	require_once "baza.php";
	
	$poziom = ($_SESSION['uzytkownik']->poziom >= 9 ? ($_SESSION['uzytkownik']->poziom - 9) : $_SESSION['uzytkownik']->poziom);
	$znizka = ($poziom * 5);
	
	echo "<div id = \"tresc_tresc\" style = \"width:1180px; font-size:16px;\">";
	echo "<h1>Zakup kredytów</h1>";
	echo "<hr>";
	echo "<table cellspacing = \"0\" id = \"kup-kredyty-table\">";
	echo "<tr><td>PAKIET</td><td>CENA</td><td></td>";
	echo "<tr><td>50 kredytów</td><td>".(15 * ((100 - $znizka) / 100.0))."zł</td><td>
			<button onClick = \"kupKredyty('50', '".(1500 * ((100 - $znizka) / 100.0))."', '".$_SESSION['uzytkownik']->email."');\">Kup</button></td>";
	echo "<tr><td>200 kredytów</td><td>".(40 * ((100 - $znizka) / 100.0))."zł</td><td>
			<button onClick = \"kupKredyty('200', ".(4000 * ((100 - $znizka) / 100.0))."', '".$_SESSION['uzytkownik']->email."');\">Kup</button></td>";
	echo "<tr><td>1000 kredytów</td><td>".(130 * ((100 - $znizka) / 100.0))."zł</td><td>
			<button onClick = \"kupKredyty('1000', '".(13000 * ((100 - $znizka) / 100.0))."', '".$_SESSION['uzytkownik']->email."');\">Kup</button></td>";
	echo "<tr><td>5000 kredytów</td><td>".(650 * ((100 - $znizka) / 100.0))."zł</td><td>
			<button onClick = \"kupKredyty('5000', '".(65000 * ((100 - $znizka) / 100.0))."', '".$_SESSION['uzytkownik']->email."');\">Kup</button></td>";
	echo "<tr class = \"elitarny\"><td>10000 kredytów</td><td>".(1000 * ((100 - $znizka) / 100.0))."zł</td><td>
			<button onClick = \"kupKredyty('10000', '".(100000 * ((100 - $znizka) / 100.0))."', '".$_SESSION['uzytkownik']->email."');\">Kup</button></td>";
	echo "</table>";
	echo "<br></div>";
	
?>