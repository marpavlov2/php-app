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
		}else if($_SESSION["tip"] != 0 && $_SESSION["id"]!=$_GET["id"]){
			header("Location: index.php");
			exit();
		} 
			$v = otvoriVezu();
			if (isset($_POST['ime'])) {
				$upit_ime = "SELECT count(*), k.korisnicko_ime FROM korisnik k, sudionik s 
						WHERE k.korisnik_id = s.korisnik_id
						GROUP BY s.korisnik_id ORDER BY korisnicko_ime";
						$sort_ime = izvrsiUpit($v,$upit_ime);
				$upit_naziv = "SELECT count(*), u.naziv FROM aktivnost a, udruga u
						WHERE u.udruga_id=a.udruga_id
						GROUP BY a.udruga_id ORDER BY naziv";
						$sort_naziv = izvrsiUpit($v,$upit_naziv);
			} else if (isset($_POST['broj'])){
				$upit_broj = "SELECT count(*), k.korisnicko_ime FROM korisnik k, sudionik s 
						WHERE k.korisnik_id = s.korisnik_id
						GROUP BY s.korisnik_id ORDER BY count(*)";
				$sort_broj = izvrsiUpit($v,$upit_broj);
			
			
			$upit_broj2 = "SELECT count(*), u.naziv FROM aktivnost a, udruga u
			WHERE u.udruga_id=a.udruga_id
			GROUP BY a.udruga_id ORDER BY count(*)";
			$sort_broj2 = izvrsiUpit($v,$upit_broj2);
				
			} else {
				$upit_ime2 = "SELECT count(*), k.korisnicko_ime FROM korisnik k, sudionik s 
						WHERE k.korisnik_id = s.korisnik_id
						GROUP BY s.korisnik_id";
				$sort_ime2 = izvrsiUpit($v,$upit_ime2);
				$upit_broj2 = "SELECT count(*), u.naziv FROM aktivnost a, udruga u
				WHERE u.udruga_id=a.udruga_id
				GROUP BY a.udruga_id";
				$sort_broj2 = izvrsiUpit($v,$upit_broj2);
				
			}
			
			
			
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
					<form name="forma" id="forma" method="POST" class="forma1"
							action="<?php echo $_SERVER["PHP_SELF"] ?>" >
							<input class="sortiranje" type="submit" name="ime" id="submit" 
								   value="Soritranje po imenu" />
							<input class="sortiranje" type="submit" name="broj" id="submit" 
							 value="Soritranje po broju" />
					</form>
					<br><br>
			
			<h3> Sortiranje korisnika </h3> <br><br>
			
					<table style="width:100%">
							<tr>
								<th>Korisnik</th><th>Broj aktivnosti</th>
							</tr>
					<?php
					
					if (isset($_POST['ime'])) {
					while($redak1 = mysqli_fetch_array($sort_ime)) {
						echo "<tr>";
						echo "<td>" . $redak1[1] ."</td>";
						echo "<td>".$redak1[0]."</td>";
						echo "</tr>";
						}
					}
					else if (isset($_POST['broj'])) {
						while($redak1 = mysqli_fetch_array($sort_broj)) {
						echo "<tr>";
						echo "<td>" . $redak1[1] ."</td>";
						echo "<td>".$redak1[0]."</td>";
						echo "</tr>";
					} } else {
						while($redak1 = mysqli_fetch_array($sort_ime2)) {
						echo "<tr>";
						echo "<td>" . $redak1[1] ."</td>";
						echo "<td>".$redak1[0]."</td>";
						echo "</tr>";
						
					} } 
										
					?></table>
					
					<br> <br>
					<h3> Sortiranje udruga </h3> <br><br>
					<table style="width:100%">
							<tr>
								<th>Naziv udruge</th><th>Broj aktivnosti</th>
							</tr>
					<?php if (isset($_POST['ime'])) {
					while($redak2 = mysqli_fetch_array($sort_naziv)) {
						echo "<tr>";
						echo "<td>" . $redak2[1] ."</td>";
						echo "<td>".$redak2[0]."</td>";
						echo "</tr>";
						}
					}
					else if (isset($_POST['broj'])) {
						while($redak2 = mysqli_fetch_array($sort_broj2)) {
						echo "<tr>";
						echo "<td>" . $redak2[1] ."</td>";
						echo "<td>".$redak2[0]."</td>";
						echo "</tr>";
					}} else {
						while($redak1 = mysqli_fetch_array($sort_broj2)) {
						echo "<tr>";
						echo "<td>" . $redak1[1] ."</td>";
						echo "<td>".$redak1[0]."</td>";
						echo "</tr>";
						
					}}
					?> </table>
			
		</div>
		</div>
	</body>
</html>
<?php
zatvoriVezu($v);
?>