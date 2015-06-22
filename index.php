<?php
	//ob_clean();
	//$content = "<page>".file_get_contents("test.html")."</page>";
	
	
	/*//DOMPDF

	require_once '/dompdf/dompdf_config.inc.php';
	$htmlString = file_get_contents("test.html");
	 
	$dompdf = new DOMPDF();
	$dompdf->load_html($htmlString);
	$dompdf->set_paper("A4");
	$dompdf->render();
	$out =  $dompdf->output();
	file_put_contents("sample.pdf", $out);
	/**/
	
	
	///////////////////////////////////////
	require_once("uzytkownik.inc");
	session_start();

	
	//session_destroy();
	//unset($_SESSION);
	//include 'db.php';	// baza danych
	
	if (!isset($_SESSION['init']))
	{
		//unset($_SESSION);
		session_regenerate_id();
		$_SESSION['init'] = $_SERVER['REMOTE_ADDR'];
	}
	
	if ($_GET['strona'] == "logout")
	{
		unset($_SESSION['uzytkownik']);
		header("Location: index.php");
	}
	
	if (isset($_SESSION['error']))
	{
		$errors = explode(";", $_SESSION['error']);
		foreach ($errors as $error)
		{
			echo $error;
		}
		unset($_SESSION['error']);
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel = "stylesheet" type = "text/css" href = "styl.css">
	<script src = "funkcje.js" type = "text/javascript"></script>
	<title>Projekt ISI - Sklep Aukcyjny</title>
</head>

<body onLoad = "init();">

	<div id = "kontener">
		<a href = "index.php">
			<div id = "logo"></div>
		</a>
			
		<div id = "login_box">
			<?php
				include "login_box.php";
			?>
		</div>

		<div id = "menu">
			<?php 
				include "menu.php";
			?>
		</div>

		<div id = "kategorie">
			<!-- PHP! Dynamicznie z bazy! -->
			<a href = "#"> Wszystko </a>
			<div style = "border:1px rgba(0,0,0,0.25) solid; width:0px; margin:0px 2px 0px 5px; line-height:47px;"> &nbsp; </div>
			<a href = "#"> Elektronika </a>
			<div style = "border:1px rgba(0,0,0,0.25) solid; width:0px; margin:0px 2px 0px 2px; line-height:47px;"> &nbsp; </div>
			<a href = "#"> Odzież </a>
			<div style = "border:1px rgba(0,0,0,0.25) solid; width:0px; margin:0px 2px 0px 2px; line-height:47px;"> &nbsp; </div>
			<a href = "#"> AGD </a>
			<div style = "border:1px rgba(0,0,0,0.25) solid; width:0px; margin:0px 2px 0px 2px; line-height:47px;"> &nbsp; </div>
			<a href = "#"> Drobiazgi </a>
			
			<a href = "#" style = "float:right;"> Kredyty </a>
			<div style = "border:0px; box-shadow:1px 0px 1px #2a586d, 2px 0px 2px #2a586d; width:1px; margin-right:3px; line-height:48px; float:right;"> &nbsp; </div>
		</div>

		<div id = "tresc">
			<div id = "tresc_szukaj">
			<?php 
				include "szukaj.php";
			?>
			</div>
			<div id = "tresc_tresc">
			<?php 
				include "przedmioty.php";
			?>
			</div>
		</div>
	</div>
</body>

</html>
<?php
	//session_destroy();
?>