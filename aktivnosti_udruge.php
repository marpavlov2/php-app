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
		include_once("baza.php");
			$v = otvoriVezu();
			$id = $_GET['id'];
			$u = "SELECT * FROM aktivnost a, udruga u 
			WHERE u.udruga_id = a.udruga_id AND u.moderator_id = 2 AND a.udruga_id = ". $id ;
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
		<div class="opis-udruge">	
			<h3> Editiranje aktivnosti udruge </h3> <br> <br>
			
				<?php
					if($r->num_rows > 0) {?>
				<table style="width: 100%;">
				<tr>
					<th>id</th><th>Aktivnost</th>
				</tr>

					<?php
					while($redak = mysqli_fetch_array($r)){
						echo "<tr>";
						echo "<td>".$redak['aktivnost_id']."</td>";
						echo "<td><a href=\"editiranje_aktivnosti.php?id=".$redak[0]."\">".$redak[6]."</a></td>";
						echo "</tr>";
						}
					}
					else { echo "Odabrana udruga trenutno nema aktivnosti";}
				?>
				</table>
			<br>	
		</div>
		</div>
		
	</body>
</html>
<?php
zatvoriVezu($v);
?>