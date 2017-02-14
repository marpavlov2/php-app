<?php
	session_start();	
		include_once("baza.php");
			$v = otvoriVezu();
			$id = $_GET['id'];
			
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
		if(empty($greska)) {
			$poruka="Ažurirali ste aktivnost";
			$upit = "UPDATE udruga SET `moderator_id`='".$moderator."', `naziv`='".$naziv."', `opis`='".$opis."' WHERE `udruga_id` = ".$id;
			izvrsiUpit($v,$upit);
			}
	}
	$u = "SELECT * FROM udruga WHERE udruga_id = '$id'";
			$r = izvrsiUpit($v,$u);
			$rezultat_ispis = mysqli_fetch_array($r);
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
			<form name="forma" id="forma" method="POST" 
			action="<?php echo $_SERVER["PHP_SELF"]."?id=".$id; ?>" >
				
				
				<label for="naziv">Naziv udruge: </label>
				<input class="forma-stil" name="naziv" id="naziv" type="text" value="<?php echo $rezultat_ispis['naziv']; ?>" />
				<br/>
				<label for="opis">Opis udruge </label>
				<input class="forma-stil" name="opis" id="opis" type="text" value="<?php echo $rezultat_ispis['opis']; ?>" />
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
			
		</div>	
		</div>
	</body>
</html>
<?php
zatvoriVezu($v);
?>