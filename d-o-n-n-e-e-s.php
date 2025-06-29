<?php 
include "bdd.php";

$nbr_mbr = $bdd->query("SELECT * FROM membres");
echo "<b>Nombre de membres : ".$nbr_mbr->rowCount()."</b><br><br><br>";
while($mails = $nbr_mbr->fetch()) {

	if($mails['confirme'] == 1) {
		echo "<b>Confirmés : </b>".$mails['mail']."&nbsp; - &nbsp;".$mails['pseudo']."<br>";
	} else if($mails['confirme'] == 0) {
		echo "<p style=\"margin-left: 100px;\"><b>Non confirmés : </b>".$mails['mail']."&nbsp; - &nbsp;".$mails['pseudo']."<br></p>";
	}

	
} ?>
