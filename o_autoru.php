<?php
	session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sportske udruge</title>
		<meta charset="UTF-8" />
		<meta name="autor" content="Mario Pavlovic"/>
		<meta name="datum" content="06.06.2016."/>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	<body>
		<?php
			include("meni.php");
		if (!empty($_COOKIE["prijava"])) {
			?> <div class="second-meni"> 
			<p><?php echo "Prijavljen korisnik: ".$_COOKIE["prijava"]; ?> </p>	
			<div class="clear"></div>
		</div>
		<?php }?>
		<div class="wrapper">
			
				<div class="profilna">
					<img src="slike\profilna.jpg" alt="Mario Pavlovic" height="400" width="300"> 
				</div>
				
				<div class="o-meni">
					<h3> Mario Pavlović </h3>
					<p> Broj indeksa: 41912/13-R</p>
					<p> Centar: Varaždin </p>
					<p> Akademska godina upisa: 2015/2016 </p>
					<a href="mailto:marpavlov2@foi.hr">Pošalji Mail</a>
				</div>
				<div class="clear"></div>
		</div>
		
		
	</body>
</html>