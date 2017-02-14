<?php
	session_start();	
		include_once("baza.php");
		if(!isset($_SESSION["id"])){
		header("Location: prijava.php");
		exit();
		}
		if(!isset($_SESSION["tip"])){
			header("Location: index.php");
			exit();
		}else if(!($_SESSION["tip"] < 2) && $_SESSION["id"]!=$_GET["id"]){
			header("Location: index.php");
			exit();
		}
		$korisnik_id = $_SESSION["id"];
			$v = otvoriVezu();
			$u = "SELECT * FROM udruga WHERE moderator_id = '$korisnik_id' ";
			$r = izvrsiUpit($v,$u);
		
			$u1 = "SELECT * FROM udruga";
			$r1 = izvrsiUpit($v,$u1);
		
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
		<div class="opis-udruge">
			<h3> Pregled aktivnosti po udrugama </h3><br><br>
			<table style="width: 100%;">
				<tr>
					<th>Naziv</th><th>Opis udruge</th>
				</tr>
				<?php
					if ($_SESSION["tip"] == 0) {
						while($redak = mysqli_fetch_array($r1)){
						echo "<tr>";
						echo "<td><a href=\"aktivnosti_udruge.php?id=".$redak[0]."\">".$redak["naziv"]."</a></td>";
						echo "<td>".$redak["opis"]."</td>";
						echo "</tr>";
						echo "<td colspan=\"2\">"  . "<a href=\"dodavanje_nove.php?id=".$redak[0]."\">". "Dodavanje nove aktivnosti" ."</a></td>" ;
						} 
					} else {
						while($redak = mysqli_fetch_array($r)){
						echo "<tr>";
						echo "<td><a href=\"aktivnosti_udruge.php?id=".$redak[0]."\">".$redak["naziv"]."</a></td>";
						echo "<td>".$redak["opis"]."</td>";
						echo "</tr>";
						echo "<td colspan=\"2\">"  . "<a href=\"dodavanje_nove.php?id=".$redak[0]."\">". "Dodavanje nove aktivnosti" ."</a></td>" ;
					}
						}
				?>
			</table>
		</div>	
		</div>
	</body>
</html>
<?php
zatvoriVezu($v);
?>