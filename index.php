<?php
	session_start();	
		include_once("baza.php");
			$v = otvoriVezu();
			$u = "SELECT * FROM udruga";
			$r = izvrsiUpit($v,$u);
?>
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
			
			<h2> Pregled udruga </h2>
			
			<?php
			if (isset($_SESSION["tip"]) && $_SESSION["tip"] == 0) {
							echo "<div class=\"kreiranje_nove\"><a href=\"kreiranje_udruge.php\"> Kreiranje udruge </a></div>";
				}
						
				while($row = mysqli_fetch_array($r)) {
					echo 
					"<div class='naziv_udruge'>
						<h3><a href=\"pregled_udruge.php?id=".$row[0]."\">" . $row["naziv"]. "</a></h3>";
						if (isset($_SESSION["tip"]) && $_SESSION["tip"] == 0) {
							echo "<a href=\"editiranje_udruge.php?id=".$row[0]."\"> Editiranje udruge </a>";
						}
						
						
					echo "</div>";
				}			
			?>
			
		</div>
		
	</body>
</html>
<?php
zatvoriVezu($v);
?>