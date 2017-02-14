<?php
	session_start();	
		include_once("baza.php");
			$v = otvoriVezu();
			$poruka = "";
			$greska = "";
			
	if(isset($_POST["submit"]))	{
		
		$naziv = $_POST["naziv"];
		$opis = $_POST["opis"];
		$moderator = $_POST["moderator_id"];
		$greska = "";
		if(!isset($naziv) || empty($naziv))
		{
			$greska.= "Unesite naziv!<br>";
			
		}
		if(!isset($opis) || empty($opis))
		{
			$greska.= "Unesite opis!<br>";
			
		}
		if(empty($greska)) 
		{
			$poruka="Kreirali ste udrugu";
			$upit = "INSERT INTO udruga 
					   (moderator_id,naziv,opis) 
				VALUES ('".$_POST["moderator_id"]."',
						'".$_POST["naziv"]."',
						'".$_POST["opis"]."');";
			
			izvrsiUpit($v,$upit);
			
			
		}
	}
	
	$u1 = "SELECT * FROM korisnik WHERE tip_id=1";
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
			
			<h3> Editiranje udruge </h3> <br> <br>
			<?php echo $poruka. "<br><br>";?>
			<form name="forma" id="forma" method="POST" 
			action="<?php echo $_SERVER["PHP_SELF"]?>" >
				
				
				<label for="naziv">Naziv udruge: </label>
				<input class="forma-stil" name="naziv" id="naziv" type="text" value="" />
				<br/>
				<label for="opis">Opis udruge </label>
				<input class="forma-stil" name="opis" id="opis" type="text" value="" />
				<br/>
				<label for="tip_id">Odabir moderatora: </label>
				<select name="moderator_id" id="moderator_id">
					<?php
						while($row = mysqli_fetch_array($r1))
						{
							echo "<option value=\"".$row["korisnik_id"]."\"";
							
							echo ">".$row["korisnicko_ime"]."</option>";
						}
					?>
				</select>
				<br/> <br/>
							
				<input class="potvrdi" type="submit" name="submit" id="submit" 
					   value="Unesi" />
			</form>
			<?php echo $greska; ?>
			
		</div>	
		</div>
	</body>
</html>
<?php
zatvoriVezu($v);
?>