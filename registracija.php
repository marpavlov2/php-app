<?php
	include_once("baza.php");
	$v = otvoriVezu();
	$greska="";
	
	
	if(isset($_POST["korime"])){
		if(empty($_POST["korime"]) || empty($_POST["lozinka"]) || empty($_POST["ime"]) || empty($_POST["prezime"]) || empty($_POST["email"])){
			$greska="Nisi unio sve podatke.";
		}else{
			$greska="Korisnik uspješno registriran!";
			//mail();
			
			
		
			$u = "INSERT INTO korisnik 
					   (tip_id,ime,prezime,email,korisnicko_ime,lozinka, slika) 
				VALUES (2,'".$_POST["ime"]."',
						'".$_POST["prezime"]."',
						'".$_POST["email"]."',
						'".$_POST["korime"]."',
						'".$_POST["lozinka"]."',
						'".$_POST["slika"]."');";
			//echo $u;
			$r = izvrsiUpit($v,$u);
			
		}
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
		<?PHP
			include("meni.php");
		?>
		<header>
			<h1>Registracija korisnika</h1>
		</header>
		<div class="wrapper"> 
		
		<form name="forma" id="forma" method="POST" class="forma"  enctype="multipart/form-data
			action="<?php echo $_SERVER["PHP_SELF"] ?> onsubmit="return validacija();" >
				<div id="greske"></div>
				<label for="ime">Ime: </label>
				<input class="forma-stil" name="ime" id="ime" type="text"  required="required"/>
				<br/>
				<label for="prezime">Prezime: </label>
				<input class="forma-stil" name="prezime" id="prezime" type="text"  required="required"/>
				<br/>
				
				<label for="email">e-mail</label>
				<input class="forma-stil" name="email" id="email" type="email" required="required" />
				<br/>
				<label for="korime">Korisničko ime: </label>
				<input class="forma-stil" name="korime" id="korime" type="text" required="required" />
				<br/>
				<label for="loznika">Lozinka: </label>
				<input class="forma-stil" name="lozinka" id="lozinka" type="password" required="required" />
				<br/>
				<label for="slika">Slika: </label>
				<input name="slika" id="slika" 
					type="file" /><br/>
				<input type="hidden" name="MAXLENGTH" 
					value="2024" /><br/>
				<input class="forma-stil" type="submit" name="submit" id="submit" 
					   value="Unesi" />
					
				<?php echo $greska ?>	
							
			</form>
			
			
		</div>
		<script src="provjera.js"></script>
	</body>
</html>
<?php
zatvoriVezu($v);
?>