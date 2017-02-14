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
			$u = "SELECT * FROM korisnik"; 
			$r = izvrsiUpit($v,$u);
			$upit = "SELECT * FROM tip_korisnika";
			$tipovi = izvrsiUpit($v,$upit);
			$greska = "";
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
			<h3> Editiranje korisnika </h3> <br><br>
			<a href="novi_korisnik.php"> Dodavanje novog korisnika </a> <br> <br> 
			
				<form name="forma" id="forma" method="POST" class="forma"
					action="<?php echo $_SERVER["PHP_SELF"] ?>" >
					<label for="ime">Ime: </label>
					<input class="forma-stil" name="ime" id="ime" type="text" />
					<br/>
					<label for="tip_id">Tip korisnika: </label>
					<select name="tip_id" id="tip_id">
					<?php
						while($row2 = mysqli_fetch_array($tipovi))
						{
							echo "<option value=\"".$row2["tip_id"]."\"";
							if ($row2["tip_id"] == 0)
								{
								echo " selected=\"selected\" ";
							}
							echo ">".$row2["naziv"]."</option>";
						}
						
					?>
				</select>
				
					<input class="forma-stil" type="submit" name="submit" id="submit" 
						   value="Unesi" />	
				</form>
				
						<table style="width:100%">
							<tr>
								<th>Ime</th><th>Prezime</th><th>Tip_id</th><th>id</th>
							</tr>
					<?php
						if(!isset($_POST['ime']) || empty($_POST['ime']) )
						{
							$greska.= "Unesite ime!<br>";
							
						}
						if(!isset($_POST['tip_id']))
						{
							$greska.= "Unesite tip_id!<br>";
							
						}
						if (isset($_POST['submit']) && !empty($greska)) {
							echo $greska;
						}
						if (isset($_POST['submit']) && empty($greska)) {
						$ime = $_POST['ime'];
						$tip_id = $_POST['tip_id'];
						$u2 ="SELECT * FROM korisnik WHERE ime LIKE '%$ime%' AND tip_id= '$tip_id'";
						$r2 = izvrsiUpit($v,$u2);
						
						while($redak = mysqli_fetch_array($r2)) {
							echo "<tr>";
							echo "<td>" . $redak['ime'] ."</td>";
							echo "<td>".$redak[5]."</td>";
							echo "<td>".$redak['tip_id']."</td>";
							echo "<td><a href=\"editiranje_korisnika.php?id=".$redak[0]."\">".$redak[0]."</a></td>";
							echo "</tr>";
						
					} $broj = mysqli_num_rows($r2);
						if($broj >= 1){
							echo "Uspjesno filtrirano";
						}else{
							echo "Ne postoji korisnik sa navedenim unosom!";
							
						}
					} 				
						else {
							$ime = "";
							$prezime = "";
					
					while($redak = mysqli_fetch_array($r)) {
						echo "<tr>";
						echo "<td>" . $redak['ime'] ."</td>";
						echo "<td>".$redak[5]."</td>";
						echo "<td>".$redak['tip_id']."</td>";
						echo "<td><a href=\"editiranje_korisnika.php?id=".$redak[0]."\">".$redak[0]."</a></td>";
						echo "</tr>";
					}
						}
						
						
					?></table>
					
			
		</div>
		</div>
	</body>
</html>
<?php
zatvoriVezu($v);
?>