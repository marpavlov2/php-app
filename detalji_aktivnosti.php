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
		}
		
			$id = $_GET['id'];
			$v = otvoriVezu();
			$u = "SELECT datum_kreiranja, vrijeme_kreiranja, datum_odrzavanja, vrijeme_odrzavanja, naziv, opis FROM aktivnost
			WHERE aktivnost_id = '$id'";
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
			<h3> Detalji o aktivnosti </h3> <br><br>
			
			<?php while($row = mysqli_fetch_array($r)) {
						echo $row['naziv'] . "<br><br>";
						echo $row['opis'] . "<br><br>";
						echo "Datum i vrijeme održavanja aktivnosti su: " . date('d.m.Y',strtotime($row['datum_odrzavanja']))   . " u " . $row['vrijeme_odrzavanja']  . "<br><br>";
						echo "Datum i vrijeme kreiranja aktivnosti su: " . date('d.m.Y',strtotime($row['datum_kreiranja']))   . " u " . $row['vrijeme_kreiranja']  . "<br><br>";
					}
				echo '<a  href="sudionici.php?id='.$id.'">Svi sudionici aktivnosti</a>';
			?>
			<button class="nazad"><a href="moje_aktivnosti.php"> Prethodna stranica </a></button>
			
		</div>
		</div>
	</body>
</html>
<?php
zatvoriVezu($v);
?>