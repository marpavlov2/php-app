
function validacija(){
	var greske = "";
	var ime = document.getElementById("ime").value;
	var prezime = document.getElementById("prezime").value;
//	alert(ime+" "+prezime);
	var prvoSlovoIme = ime[0];
	if(ime == "")
	{
		greske += "Niste unjeli prezime<br/>";
	} else if(prvoSlovoIme !== prvoSlovoIme.toUpperCase())
	{
		greske += "Prvo slovo imena nije veliko <br/>";
	}
	
	var prvoSlovoPrezime = prezime[0];
	if(prezime == "")
	{
		greske += "Niste unjeli ime<br/>";
	} else if(prvoSlovoPrezime !== prvoSlovoPrezime.toUpperCase())
	{
		greske += "Prvo slovo prezimena nije veliko <br/>";
	}
	
	var lozinka = document.getElementById("lozinka").value;
	var korime = document.getElementById("korime").value;
	if(lozinka == "")
	{
		greske += "Nije unesena lozinka!<br>";
	}
	else if(lozinka.length < 6){
		greske += "Lozinka mora sadržavati minimum 6 znakova!<br>";
	}
	if(korime == "")
	{
		greske += "Korisničko ime nije unešeno!<br>";
	}
	else if(korime.length < 6){
		greske += "Korisničko ime mora sadržavati minimum 6 znakova!<br>";
	}
	document.getElementById("greske").innerHTML = greske;
	
	if(greske.length!=0)
	{
		return false;
	}
}

