<?php
	session_start();
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
	
		include_once("baza.php");
			$v = otvoriVezu();
			
			$greska = "";
			$date = date("Y.m.d");	
						
			if(isset($_POST["korime"])){
		if(empty($_POST["korime"]) || empty($_POST["lozinka"]) || empty($_POST["ime"]) || empty($_POST["prezime"]) || empty($_POST["email"])){
			$greska="Nisi unio sve podatke.";
		}else{
			$greska="Korisnik registriran!";
			//mail();
			
			
		
			$u = "INSERT INTO korisnik 
					   (tip_id,ime,prezime,email,korisnicko_ime,lozinka) 
				VALUES ('".$_POST["tip_id"]."',
						'".$_POST["ime"]."',
						'".$_POST["prezime"]."',
						'".$_POST["email"]."',
						'".$_POST["korime"]."',
						'".$_POST["lozinka"]."');";
			//echo $u;
			$r = izvrsiUpit($v,$u);
			
		}
	}
	$upit = "SELECT * FROM tip_korisnika";
	$tipovi = izvrsiUpit($v,$upit);
			
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
			
			<h3> Dodavanje novog korisnika </h3> <br> <br>
			<form name="forma" id="forma" method="POST" class="forma"
			action="<?php echo $_SERVER["PHP_SELF"] ?>" >
			<label for="tip_id">Tip korisnika: </label>
			<select name="tip_id" id="tip_id">
					<?php
						while($row = mysqli_fetch_array($tipovi))
						{
							echo "<option value=\"".$row["tip_id"]."\"";
							
							echo ">".$row["naziv"]."</option>";
						}
					?>
				</select>
				<br/> <br/>
				<label for="ime">Ime: </label>
				<input class="forma-stil" name="ime" id="ime" type="text" />
				<br/>
				<label for="prezime">Prezime: </label>
				<input class="forma-stil" name="prezime" id="prezime" type="text" />
				<br/>
				<label for="email">e-mail</label>
				<input class="forma-stil" name="email" id="email" type="email" />
				<br/>
				<label for="korime">Korisničko ime: </label>
				<input class="forma-stil" name="korime" id="korime" type="text" />
				<br/>
				<label for="loznika">Lozinka: </label>
				<input class="forma-stil" name="lozinka" id="lozinka" type="password" />
				<br/>
				<input class="forma-stil" type="submit" name="submit" id="submit" 
					   value="Unesi" />			   
			</form>
			
		</div>	
		</div>
	</body>
</html>
<?php
zatvoriVezu($v);
?>