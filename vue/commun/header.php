<!DOCTYPE html>
<html lang="en">
	
	<head>
		<title>Anima Protect - Votre clinique vétérinaire</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
		<script type="text/javascript" src="ressources/js/slider.js"></script>
		<script type="text/javascript" src="ressources/js/simply-toast.min.js"></script>
		<link rel="stylesheet" type="text/css" href="ressources/css/style.css" />
		<link rel="stylesheet" href="ressources/css/style_slider.css" type="text/css" />
		<link rel="stylesheet" type="text/css" href="ressources/css/simply-toast.min.css" />
	</head>
	
	<body>
		<div id="top"></div>
		
		<div id="wrapper">
		
			<header>
				<div id="logo">
					<?php include('logo.php')?>
				</div>
				<div id="social">
					<?php include('social.php')?>
				</div>
				<nav>
					<?php include('controleur/core/connexionCtrl.php')?>
					<?php include('navigation.php')?>
				</nav>
			</header>
			
			<aside>
				<div id="presentation">
					<?php include('presentation.php')?>
				</div>
				<div id="slide">
					<?php include('slide.php')?>
				</div>
			</aside>

		<?php
			include("controleur/core/sousMenuCtrl.php");
		?>
		
		<article>
		