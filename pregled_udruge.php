<?php
	session_start();
	include_once("baza.php");
			$v = otvoriVezu();
	
	
	
	
	if (isset($_SESSION["id"])) {
		$korisnik_session = $_SESSION["id"];
		$u3 = "SELECT * FROM aktivnost a, udruga u, sudionik s 
				WHERE s.aktivnost_id=a.aktivnost_id AND a.udruga_id=u.udruga_id 
				AND s.korisnik_id = '$korisnik_session';";
			$popis_aktivnosti = izvrsiUpit($v,$u3);
	}
			$id = $_GET['id'];
			$u5 = "SELECT * FROM udruga";
			$r5 = izvrsiUpit($v,$u5);
				
			$u = "SELECT u.naziv, u.opis, a.naziv FROM aktivnost a, udruga u 
			WHERE u.udruga_id = a.udruga_id AND u.udruga_id = '$id';";
			$opci_podaci_udruge = izvrsiUpit($v,$u);
			
			$u1 = "SELECT * FROM udruga WHERE udruga_id = '$id'";
			$opci_podaci_udruge_opis = izvrsiUpit($v,$u1);
			
			$u2 = "SELECT * FROM udruga WHERE udruga_id = '$id';";
			$naslov_udruge = izvrsiUpit($v,$u2);
			
			
			$u3 = "SELECT k.ime, k.prezime FROM korisnik k,  sudionik s
			WHERE k.korisnik_id = s.korisnik_id AND s.aktivnost_id = '$id'";
			$popis_svih = izvrsiUpit($v,$u3);
			
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
	<h3>
			<?php 
				if ($naslov_udruge->num_rows > 0) {
			// output data of each row
					while($row2 = mysqli_fetch_array($naslov_udruge)) {
						echo $row2['naziv'] . "<br><br>";
					break;
					}
				} ?>
	</h3>
			<?php
				if ($opci_podaci_udruge_opis->num_rows > 0) {
					// output data of each row
					while($row = mysqli_fetch_array($opci_podaci_udruge_opis)) {
						echo "<p>" . $row['opis'] . "</p><br>";
					break;
					}					
				} ?>
				<h4> Popis aktivnosti udruge: </h4> <br>
				
				<?php
				
				
				if (isset($_SESSION["tip"]) && $_SESSION["tip"] == 0) {
				}
				if ($opci_podaci_udruge->num_rows > 0) {
					// output data of each row
					while($row = mysqli_fetch_array($opci_podaci_udruge)) {
						echo "<p>" . $row['naziv'] . "</p>";
						
					} 
				}else {
						echo "Ova udruga trenutno nema aktivnosti.";
					}
				
				
			?>
				
					
				
	</div>
	</div>
	
	</body>
</html>
<?php
zatvoriVezu($v);
?>