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
			$v = otvoriVezu();
			$id = $_GET['id'];
			
		if(isset($_POST["submit"]))
		{
		$naziv = $_POST["naziv"];
		$opis = $_POST["opis"];
		$datum_o = $_POST["datum_o"];
		$vrijeme_o = $_POST["vrijeme_o"];
		$datum = $_POST["datum"];
		$vrijeme = $_POST["vrijeme"];
		$newDate = date("Y-m-d", strtotime($datum_o));
		$newDate1 = date("Y-m-d", strtotime($datum));
		$newTime = date('H:i:s',strtotime($vrijeme_o));
		$greska = "";
		if(!isset($naziv) || empty($naziv))
		{
			$greska.= "Unesite naziv!<br>";
			
		}
		if(!isset($opis) || empty($opis))
		{
			$greska.= "Unesite opis!<br>";
			
		}
		
		if(!isset($datum_o) || empty($datum_o))
		{
			$greska.= "Unesite datum održavanja!<br>";
			
		}
		if(!isset($vrijeme_o) || empty($vrijeme_o))
		{
			$greska.= "Unesite vrijeme održavanja!<br>";
			
		}
		if(!isset($datum) || empty($datum))
		{
			$greska.= "Unesite vrijeme kreiranja!<br>";
			
		}
		if(!isset($vrijeme) || empty($vrijeme))
		{
			$greska.= "Unesite vrijeme kreiranja!<br>";
			
		}
		if(empty($greska)) 
		{	
			$poruka="Ažurirali ste aktivnost";
			$upit = "UPDATE aktivnost SET `naziv`='".$naziv."', `opis`='".$opis."', `datum_kreiranja`='".$newDate1."', `vrijeme_kreiranja`='".$vrijeme."', `datum_odrzavanja`='".$newDate.
			"', `vrijeme_odrzavanja`='".$newTime ."' WHERE `aktivnost_id` = ".$id;
			$izvrsi = izvrsiUpit($v,$upit);
			
		} 
	} 
	$u = "SELECT * FROM aktivnost a, udruga u 
			WHERE u.udruga_id = a.udruga_id AND u.moderator_id = 2 AND a.aktivnost_id = '$id' ";
			$r = izvrsiUpit($v,$u);
			$rezultat_ispis = mysqli_fetch_array($r);
			
			$u1 = "SELECT k.ime, k.prezime FROM korisnik k,  sudionik s
			WHERE k.korisnik_id = s.korisnik_id AND s.aktivnost_id = '$id'";
			$r2 = izvrsiUpit($v,$u1);
			$rezultat_ispis2 = mysqli_fetch_array($r2);
			
			$u1 = "SELECT k.ime, k.prezime FROM korisnik k,  sudionik s
			WHERE k.korisnik_id = s.korisnik_id AND s.aktivnost_id = '$id'";
			$ispis = izvrsiUpit($v,$u1);
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
			
			<h3> Editiranje aktivnosti </h3> <br> <br>
			<form name="forma" id="forma" method="POST" 
			action="<?php echo $_SERVER["PHP_SELF"]."?id=".$id; ?>" >
				
				
				<label for="naziv">Naziv aktivnosti: </label>
				<input class="forma-stil" name="naziv" id="naziv" type="text" value="<?php echo $rezultat_ispis[6]; ?>" />
				<br/>
				<label for="opis">Opis aktivnosti </label>
				<input class="forma-stil" name="opis" id="opis" type="text" value="<?php echo $rezultat_ispis[7]; ?>" />
				<br/>
				<label for="sudionici">Pregled sudionika: </label>
				
					
					<?php
						while($row = mysqli_fetch_array($ispis))
						{
							echo $row['ime'] . " " . $row['prezime'] . ", ";
							
						}
						
						
						
					?>
				
				<br><br>
				
				<label for="datum_o">Datum održavanja: </label>
				<input class="forma-stil" name="datum_o" id="datum_o" type="text" value="<?php echo date("d-m-Y", strtotime($rezultat_ispis['datum_odrzavanja'])); ?>" />
				<br/>
				<label  for="vrijeme_o">Vrijeme održavanja: </label>
				<input class="forma-stil" name="vrijeme_o" id="vrijeme_o" type="text" value="<?php echo date('H:i:s',strtotime($rezultat_ispis['vrijeme_odrzavanja'])); ?>" />
				<br/>
				<label for="datum">Datum kreiranja </label>
				<input class="forma-stil" name="datum" id="datum" type="text" value="<?php echo date("d-m-Y", strtotime($rezultat_ispis['datum_kreiranja'])); ?>" />
				<br/>
				<label for="vrijeme">Vrijeme kreiranja</label>
				<input class="forma-stil" name="vrijeme" id="vrijeme" type="text" value="<?php echo date('H:i:s',strtotime($rezultat_ispis['vrijeme_kreiranja'])); ?>" />
				<br/>
				
				<input class="potvrdi" type="submit" name="submit" id="submit" 
					   value="Unesi" />
			</form>
			
		</div>	
		</div>
	</body>
</html>
<?php
zatvoriVezu($v);
?>