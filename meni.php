
<nav id="navigacija">
<div class="main_meni">
	<ul>
		<li><a href="index.php" >Početna stranica</a></li>
		<li><a href="o_autoru.php">O autoru</a></li>
		
	</ul>
	
</div>
<div class="korisnik">
	<ul>
		<?php if(!isset($_SESSION["id"])){?> 
		<li><a href="prijava.php" class="veza">Prijava</a></li> 
		<li><a href="registracija.php" class="veza">Reg korisnik</a></li><br/>
	<?php } else { ?>
		<li><a href="prijava.php?odjava=1" class="veza">Odjava</a></li>
		<li><a href="moje_aktivnosti.php" class="veza">Moje aktivnosti</a></li>
		<?php if ($_SESSION["tip"] == 1) { ?>
		<li><a href="pregled_aktivnosti.php" class="veza">Editiranje aktivnosti</a></li>
		<?php }?>
	<?php 
	if ($_SESSION["tip"] == 0) { ?>
		<li><a href="pregled_aktivnosti.php" class="veza">Editiranje aktivnosti</a></li>
		<li><a href="korisnici.php" class="veza">Korisnici</a></li>
		<li><a href="podaci.php" class="veza">Podaci</a></li>
	<?php }
	
	} 
	
	?>
	
		
		
		
	</ul>
	
	
</div>
<div class="clear"></div>
</nav>
