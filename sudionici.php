<?php
	session_start();	
		include_once("baza.php");
			$id = $_GET['id'];
			$v = otvoriVezu();
			$u = "SELECT k.ime, k.prezime FROM korisnik k,  sudionik s
WHERE k.korisnik_id = s.korisnik_id AND s.aktivnost_id = '$id'";
			$r = izvrsiUpit($v,$u);
			
			
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
			<h3> Sudionici na aktivnosti </h3> <br><br>
			
						<table style="width:100%">
							<tr>
								<th>Ime</th><th>Prezime</th>
							</tr>
						<?php
						while($row = mysqli_fetch_array($r)) {
						echo "<tr>";
						echo "<td>" . $row['ime'] ."</td>";
						echo "<td>".$row['prezime']."</td>";
						echo "</tr>";
					}
					?></table>
			<button class="nazad"><a href="moje_aktivnosti.php"> Nazad na moje aktivnosti </a></button>
		</div>
		</div>
	</body>
</html>
<?php
zatvoriVezu($v);
?>