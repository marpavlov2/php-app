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
			$greska = "";
			$date = date("Y.m.d");	
			$uspjeh	= "";
			if(isset($_POST["submit"]))
				
	{
		$naziv = $_POST["naziv"];
		$opis = $_POST["opis"];
		
		$datum_o = $_POST["datum_o"];
		$vrijeme_o = $_POST["vrijeme_o"];
		$newDate = date("Y-m-d", strtotime($datum_o));
	
		$greska = "";
		if(!isset($naziv) || empty($naziv))
		{
			$greska.= "Unesite naziv!<br>";
			
		}
		
		if(!isset($_POST["korisnici"]) || empty($_POST["korisnici"]))
		{
			$greska.= "Unesite sudionike! <br>";
			
		}
		if(!isset($datum_o) || empty($datum_o))
		{
			$greska.= "Unesite datum održavanja!<br>";
			
		}
		if(!isset($vrijeme_o) || empty($vrijeme_o))
		{
			$greska.= "Unesite vrijeme održavanja!<br>";
			
		}
	
		if(empty($greska))  
		{
			$poruka="Unjeli ste novu aktivnost";
			$u = "INSERT INTO aktivnost
					   (udruga_id,datum_kreiranja,vrijeme_kreiranja,datum_odrzavanja,vrijeme_odrzavanja, naziv, opis) 
				VALUES ('$id',
						'$date',
						'".date("H:i:s")."',
						'$newDate',						
						'".$_POST["vrijeme_o"]."',
						'".$_POST["naziv"]."',
						'".$_POST["opis"]."'); ";
			//echo $u;
			$r = izvrsiUpit($v,$u);
			$upit = "SELECT * FROM korisnik ";
			$korisnici = izvrsiUpit($v,$upit);
			$uspjeh = "Uspješno dodana nova aktivnost";
			
		}
	}
	$u3 = "SELECT * FROM korisnik WHERE korisnik_id > 2 ORDER BY ime";
			$r3 = izvrsiUpit($v,$u3);
	$u = "SELECT * FROM aktivnost a, udruga u 
			WHERE u.udruga_id = a.udruga_id AND u.moderator_id = 2 AND a.aktivnost_id = '$id' ";
			$r = izvrsiUpit($v,$u);
			$rezultat_ispis = mysqli_fetch_array($r);
			
			$u1 = "SELECT k.ime, k.prezime FROM korisnik k,  sudionik s
			WHERE k.korisnik_id = s.korisnik_id AND s.aktivnost_id = '$id'";
			$r2 = izvrsiUpit($v,$u1);
			
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
			
			<h3> Dodavanje nove aktivnosti </h3> <br> <br>
			<?php echo "<p style=\"color: red; font-size: 20px; margin-bottom: 5px;\">" . $greska . "</p>" ?>
			<form name="forma" id="forma" method="POST" 
			action="<?php echo $_SERVER["PHP_SELF"]."?id=".$id; ?>" >
				
				
				<label for="naziv">Naziv aktivnosti: </label>
				<input class="forma-stil" name="naziv" id="naziv" type="text" value="" />
				<br/>
				<label for="opis">Opis aktivnosti </label>
				<input class="forma-stil" name="opis" id="opis" type="text" value="" />
				<br/>
				
				
				<label for="datum_o">Datum održavanja: </label>
				<input class="forma-stil" name="datum_o" id="datum_o" type="text" value="" placeholder="npr. 06.05.2016" />
				<br/>
				<label  for="vrijeme_o">Vrijeme održavanja: </label>
				<input class="forma-stil" name="vrijeme_o" id="vrijeme_o" type="text" value="" placeholder="npr. 18:05:03"/>
				<br/>
				<label for="datum">Datum kreiranja </label>
				<input class="forma-stil" name="datum" id="datum" type="text" value="Postavlja se automatski" disabled/>
				<br/>
				<label for="vrijeme">Vrijeme kreiranja</label>
				<input class="forma-stil" name="vrijeme" id="vrijeme" type="text" value="Postavlja se automatski" disabled/>
				<br/>
				<label for="sudionici">Pregled sudionika: </label>
				
					
				<?php
						while($row = mysqli_fetch_array($r3))
						{
							echo "<p style=\"display: inline-block; margin-right: 15px;\">
								<input type=\"checkbox\" id=\"korisnici[]\" name=\"korisnici[]\" value=\"$row[0]\" />  $row[4]  $row[5]  
									</p>";
							
						}
						
							 
							
							if (isset($_POST['korisnici']) && !empty($naziv) && !empty($datum_o) && !empty($vrijeme_o)){
							
							foreach ($_POST["korisnici"] as $korisnik1){
							$u5 = "INSERT INTO sudionik
							(aktivnost_id,korisnik_id) 
							VALUES (LAST_INSERT_ID() ,'$korisnik1');"; 	
							$r = izvrsiUpit($v,$u5);
							
							
							
							}
							
						}
						
					?>
				
				<br><br>
				
				<input class="potvrdi" type="submit" name="submit" id="submit" 
					   value="Unesi" />
			</form>
			<br>
			<?php echo $uspjeh;?>
			
		</div>	
		</div>
	</body>
</html>
<?php
zatvoriVezu($v);
?>