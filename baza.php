<?php
define("POSLUZITELJ","localhost");
define("BAZA_KORISNIK","iwa_2015");
define("BAZA_LOZINKA","foi2015");
define("BAZA","iwa_2015_vz_projekt");

function otvoriVezu(){
	$veza = mysqli_connect(POSLUZITELJ,BAZA_KORISNIK,BAZA_LOZINKA);
	
	if(!$veza){
		echo "GREŠKA: 
		kod spajanja u datoteci baza.php funkcija otvoriVezu: 
		".mysqli_connect_error();
	}
	
	mysqli_select_db($veza, BAZA);
	
	if(mysqli_error($veza)!==""){
		echo "GREŠKA: 
		kod odabira baze u datoteci baza.php funkcija otvoriVezu: 
		".mysqli_error($veza);
	}
	
	mysqli_set_charset($veza, "utf8");
	
	if(mysqli_error($veza)!==""){
		echo "GREŠKA: 
		kod postavljanja kodne stranice u datoteci baza.php funkcija otvoriVezu: 
		".mysqli_error($veza);
	}
	
	return $veza;
}

function izvrsiUpit($veza,$upit){
	$rezultat = mysqli_query($veza,$upit);
	
	if(!$rezultat){
		echo "GREŠKA: 
		kod upita u datoteci baza.php funkcija otvoriVezu: "
		.$upit." : ".mysqli_error($veza);
	}
	
	return $rezultat;
}

function zatvoriVezu($veza){
	mysqli_close($veza);
}
?>