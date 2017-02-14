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
	$veza = otvoriVezu();
	
	$id_update_korisnik = $_GET['id'];
	
	if(isset($_POST["submit"]))
	{
		$korime = $_POST["korime"];
		$lozinka = $_POST["lozinka"];
		$ime = $_POST["ime"];
		$prezime = $_POST["prezime"];
		$email = $_POST["email"];
		$tip_id = $_POST["tip_id"];
		$greska = "";
		if(!isset($korime) || empty($korime))
		{
			$greska.= "Unesite korisničko ime!<br>";
			
		}
		if(!isset($lozinka) || empty($lozinka))
		{
			$greska.= "Unesite lozinku!<br>";
			
		}
		if(!isset($ime) || empty($ime))
		{
			$greska.= "Unesite ime! <br>";
			
		}
		if(!isset($prezime) || empty($prezime))
		{
			$greska.= "Unesite prezime!<br>";
			
		}
		if(!isset($email) || empty($email))
		{
			$greska.= "Unesite email!<br>";
			
		}
		if(empty($greska))
		{
			$poruka="Ažurirali ste korisnika";
			$upit = "UPDATE korisnik SET `tip_id`=".$tip_id
			.", `ime`='".$ime."',`prezime`='".$prezime."', `email`='".$email."', `korisnicko_ime`='".$korime
			."', `lozinka`='".$lozinka."' WHERE korisnik_id = ".$id_update_korisnik;
			izvrsiUpit($veza,$upit);
			
		}
	}
	
	$upit = "SELECT * FROM korisnik WHERE korisnik_id = ".$id_update_korisnik;
	$rezultat = izvrsiUpit($veza,$upit);
	$rezultat_ispis = mysqli_fetch_assoc($rezultat);
	
	$upit = "SELECT * FROM tip_korisnika";
	$tipovi = izvrsiUpit($veza,$upit);
	
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
		<div class="wrapper">
			<div class="opis-udruge">
			<h3> Editiranje korisnika </h3> <br><br>
			
			<form name="forma" id="forma" method="POST" 
			action="<?php echo $_SERVER["PHP_SELF"]."?id=".$id_update_korisnik; ?>" >
				<label for="tip_id">Tip korisnika: </label>
				<select name="tip_id" id="tip_id">
					<?php
						while($row = mysqli_fetch_array($tipovi))
						{
							echo "<option value=\"".$row["tip_id"]."\"";
							if($rezultat_ispis['tip_id'] == $row["tip_id"])
							{
								echo " selected=\"selected\" ";
							}
							echo ">".$row["naziv"]."</option>";
						}
					?>
				</select>
				<br/> <br/>
				<label for="ime">Ime: </label>
				<input class="forma-stil" name="ime" id="ime" type="text" value="<?php echo $rezultat_ispis['ime']; ?>" />
				<br/>
				<label for="prezime">Prezime: </label>
				<input class="forma-stil" name="prezime" id="prezime" type="text" value="<?php echo $rezultat_ispis['prezime']; ?>" />
				<br/>
				<label for="email">e-mail</label>
				<input class="forma-stil" name="email" id="email" type="text" value="<?php echo $rezultat_ispis['email']; ?>" />
				<br/>
				<label for="korime">Korisničko ime: </label>
				<input class="forma-stil" name="korime" id="korime" type="text" value="<?php echo $rezultat_ispis['korisnicko_ime']; ?>" />
				<br/>
				<label for="loznika">Lozinka: </label>
				<input class="forma-stil" name="lozinka" id="lozinka" type="password" value="<?php echo $rezultat_ispis['lozinka']; ?>" />
				<br/>
				<input class="forma-stil" type="submit" name="submit" id="submit" 
					   value="Unesi" />
			</form>
			<button class="nazad"><a href="korisnici.php"> Nazad </a></button>
		</div>
		</div>
	</body>
</html>
<?php
zatvoriVezu($veza);
?>