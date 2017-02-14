<?php

if(isset($_GET["odjava"])){
		session_start();
		unset($_SESSION["id"]);
		unset($_SESSION["ime"]);
		
		session_destroy();
		setcookie("prijava", "", time()-3600);
}
	//$greska="";
	if(isset($_POST["korime"])){
		if(empty($_POST["korime"]) || empty($_POST["lozinka"])){
			$greska="Nisi unio korisničko ime ili lozinku.";
		}else{
			include_once("baza.php");
			
			$v = otvoriVezu();
			$password = $_POST['lozinka'];
			
			
			$u = "SELECT * FROM korisnik WHERE korisnicko_ime='".$_POST["korime"]."' 
										   AND lozinka='".$password."'";
			
			$r = izvrsiUpit($v,$u);
			$broj = mysqli_num_rows($r);
			if($broj === 1){
				
				setcookie("prijava",$_POST["korime"]);
				zatvoriVezu($v);
				$redak = mysqli_fetch_array($r);
				session_start();
				$_SESSION["id"] = $redak["korisnik_id"];
				$_SESSION["tip"] = $redak["tip_id"];
				$_SESSION["ime"] = $redak["ime"];
				$_SESSION["prezime"] = $redak["prezime"];
				header("Location: index.php");
				exit();
			}else{
				$greska = "Korisničko ime ili lozinka nije ispravno.";
				zatvoriVezu($v);
			}
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
		<div class="wrapper">
		<div class="prijava">
		<header>
			<h1>Prijava korisnika</h1>
		</header>
		
		
		<section id="sadrzaj">
			<div style="color:red;">
				<?PHP
					if(isset($greska)) {
						echo $greska;
					}
				?>
			</div>
			<form name="forma" id="forma" method="POST" 
			action="prijava.php" >
				<label for="korime">Korisničko ime: </label>
				<input class="forma-stil" name="korime" id="korime" type="text" />
				<br/>
				<label for="lozinka">Lozinka: </label>
				<input class="forma-stil" name="lozinka" id="lozinka" type="password" />
				<br/>
				<input class="forma-stil" type="submit" name="submit" id="submit" 
					   value="Prijava" />
					  
			</form>
		</section>
		</div>
	</body>
</html>
