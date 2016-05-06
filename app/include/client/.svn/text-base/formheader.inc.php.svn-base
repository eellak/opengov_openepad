<?php
$title=($cfg && is_object($cfg))?$cfg->getTitle():'Δράση 3';
header("Content-Type: text/html; charset=UTF-8\r\n");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title><?=Format::htmlchars($title)?></title>

    <link rel="stylesheet" type="text/css" href="./styles/citizenform.css" />
	<link rel="stylesheet" type="text/css" href="./styles/ui-lightness/jquery-ui-1.8.9.custom.css"  />	
	<link rel="stylesheet" type="text/css" href="./styles/jquery.ui.selectmenu.css"  media="screen" title="no title" charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="./styles/validationEngine.jquery.css"  media="screen" title="no title" charset="utf-8" />
	<!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="./styles/iehacks.css" />
	<![endif]-->
	<!--[if IE 7]><link rel="stylesheet" type="text/css" href="./styles/ie7hacks.css" />
	<![endif]-->
	<!--[if IE 6]><link rel="stylesheet" type="text/css" href="./styles/ie6hacks.css" />
	<![endif]-->
	
	<script language="javascript" type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script language="javascript" type="text/javascript">
        // Load jQuery
        google.load("jquery", "1.4.4");
        google.load("jqueryui", "1.8.7");
  
	</script>

		

</head>


<body id="page">
	<!-- wrapper -->
	<div class="rapidxwpr floatholder">

		<!-- header -->
		<div id="header">

			<!-- logo -->
			<div id="logo">
				
			</div>
			<!-- / logo -->
			
		</div>
		<!-- / header -->

   <!-- main body -->
		<div id="middle">
			<div class="background layoutleft">

				<!-- mainmenu -->
				<div id="mainmenu" class="clearingfix">
					<ul>
					
						<li><?php get_home_link(); ?></li> <?php /*  */ ?>

						<li><a href="index.php" >Οδηγίες συμμετοχής & Υπηρεσίες</a></li>
						<li><a href="citizenform.php"  class="active">Υποβολη Μηνύματος</a></li>
						<? if($thisclient && is_object($thisclient) && $thisclient->isValid()) {?>
						<li><a href="tickets.php" >Μηνύματα που έχω υποβάλλει</a></li>
						<li><a href="logout.php" >Έξοδος</a></li>
						<?}else {?>
						<li><a href="citizenview.php" >Τελευταια Μηνυματα</a></li>
						<?}?>
						
					</ul>

				</div>
				<!-- / mainmenu -->

 
