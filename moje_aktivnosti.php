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
		}
	
	
	
			$v = otvoriVezu();
	if (isset($_SESSION["id"])) {
		$korisnik_session = $_SESSION["id"];
		$u3 = "SELECT * FROM aktivnost a, udruga u, sudionik s 
				WHERE s.aktivnost_id=a.aktivnost_id AND a.udruga_id=u.udruga_id 
				AND s.korisnik_id = '$korisnik_session';";
			$popis_aktivnosti = izvrsiUpit($v,$u3);
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
			<h3> Moje aktivnosti </h3> <br><br>
			
			<form name="forma" id="forma" method="POST" class="forma"
					action="<?php echo $_SERVER["PHP_SELF"] ?>" >
			
			<label for="ime" class="infos">Filtiranje po nazivu udruge: </label>
					<input class="forma-stil" name="ime" id="ime" type="text" placeholder="npr. Planinarska udruga Varaždin" />
					<input class="forma-stil" type="submit" name="submit" id="submit" 
						   value="Unesi" />	
			<label for="ime" class="infos">Filtiranje po vremenu i datumu održavanja: </label> <br><br>
			<label for="ime">Unesite datum početka aktivnosti: </label>
					<input class="forma-stil" name="datum_p" id="datum_p" type="date" placeholder="dd.mm.gggg" />
			<label for="ime">Unesite datum kraja aktivnosti: </label>
					<input class="forma-stil" name="datum_k" id="datum_k" type="date" placeholder="dd.mm.gggg"/>
			<label for="ime">Unesite vrijeme početka aktivnosti: </label>
					<input class="forma-stil" name="vrijeme_p" id="vrijeme_p" type="text" placeholder="hh:mm:ss" />
			<label for="ime">Unesite vrijeme kraja aktivnosti: </label>
					<input class="forma-stil" name="vrijeme_k" id="vrijeme_k" type="text" placeholder="hh:mm:ss" />
					<input class="forma-stil" type="submit" name="submit" id="submit" 
						   value="Unesi" />	
			</form>
			
				
		<?php  if (isset($_SESSION["id"]) && $popis_aktivnosti->num_rows > 0) {
				echo "Popis aktivnosti na kojima ste prijavljeni: <br><br>" ;	
				 ?>
						<table style="width:100%">
							<tr>
								<th>Aktivnost</th><th>Naziv udruge</th>
							</tr>
						<?php
		if (isset($_POST['datum_p'])&& isset($_POST['datum_k']) && isset($_POST['vrijeme_k']) && isset($_POST['vrijeme_p'])) {
			$datum1 = date("Y-m-d", strtotime( $_POST['datum_p']));
			$datum2 = date("Y-m-d", strtotime( $_POST['datum_k']));
			$vrijeme1 = $_POST['vrijeme_p'];
			$vrijeme2 = $_POST['vrijeme_k'];
			
			$u4 = "SELECT * FROM aktivnost a, udruga u, sudionik s 
				WHERE s.aktivnost_id=a.aktivnost_id AND a.udruga_id=u.udruga_id
				AND s.korisnik_id = '$korisnik_session' AND `datum_odrzavanja` BETWEEN '$datum1' AND '$datum2'
				AND `vrijeme_odrzavanja` BETWEEN '$vrijeme1' AND '$vrijeme2' AND s.korisnik_id = '$korisnik_session' ; ";
				$filterdate = izvrsiUpit($v,$u4);
				
				while($row3 = mysqli_fetch_array($filterdate)) {
				echo "<tr>";
				echo "<td><a class=\"detalji\" href=\"detalji_aktivnosti.php?id=".$row3[0]."\">".$row3[6]."</a></td>";
				echo "<td>".$row3['naziv']."</td>";
				echo "</tr>";
				}
				
		} 
		
		if (isset($_POST['submit']) && !empty($_POST['submit'])) {
			$naziv = $_POST['ime'];
			if (!empty($naziv)) {
				$u4 = "SELECT * FROM aktivnost a, udruga u, sudionik s 
				WHERE s.aktivnost_id=a.aktivnost_id AND a.udruga_id=u.udruga_id
				AND s.korisnik_id = '$korisnik_session' AND u.naziv LIKE '%$naziv%' ;";
				$popis_aktivnosti1 = izvrsiUpit($v,$u4);
			
			while($row3 = mysqli_fetch_array($popis_aktivnosti1)) {
				echo "<tr>";
				echo "<td><a class=\"detalji\" href=\"detalji_aktivnosti.php?id=".$row3[0]."\">".$row3[6]."</a></td>";
				echo "<td>".$row3['naziv']."</td>";
				echo "</tr>";
				}
				
			$popis_aktivnosti2 = mysqli_num_rows($popis_aktivnosti1);
			if($popis_aktivnosti2 >= 1){
					echo "Uspjesno filtrirano po nazivu";
				}else{
					echo "Ne postoji unesena udruga!";
				}
			
			} 
		} 
		else {
			while($row3 = mysqli_fetch_array($popis_aktivnosti)) {
				echo "<tr>";
				echo "<td><a class=\"detalji\" href=\"detalji_aktivnosti.php?id=".$row3[0]."\">".$row3[6]."</a></td>";
				echo "<td>".$row3['naziv']."</td>";
				echo "</tr>";
				}
			}
		
		?></table>
		<?php	} else {echo "Nemate prijavljenih aktivnosti!";} 	?>
		
		</div>
		</div>
	</body>
</html>
<?php
zatvoriVezu($v);
?>