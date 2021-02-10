<?php 
include "bdd.php";

if(isset($_GET['pseudo'], $_GET['key']) AND !empty($_GET['pseudo']) AND !empty($_GET['key'])) {

	$pseudo = htmlspecialchars(urldecode($_GET['pseudo']));
	$key = $_GET['key'];


	$requser = $bdd->prepare("SELECT * FROM membres WHERE pseudo = ? AND confirmkey = ?");
	$requser->execute(array($pseudo, $key));
	$user_exist = $requser->rowCount();

	if($user_exist == 1) {
		$user = $requser->fetch();
		if($user['confirme'] == 0) {
			$updateuser = $bdd->prepare("UPDATE membres SET confirme = 1 WHERE pseudo = ? AND confirmkey = ?");
			$updateuser->execute(array($pseudo, $key));
			header("Location: connexion.php");
		} else {
			echo "<br>Votre compte à déjà été confirmé | <a class=\"deja\" href=\"connexion.php\">Se connecter</a>";
		}

	} else {
		echo "Cette utilisateur n'existe pas";
	}
} ?>
<link rel="stylesheet" type="text/css" href="style.css">