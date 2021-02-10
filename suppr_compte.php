<?php 
include "bdd.php";

if(isset($_SESSION['id'])) {
	$id_session = $_SESSION['id'];
	$req_mdp = $bdd->query("SELECT * FROM membres WHERE id = '$id_session'");
	$mdp_valide = $req_mdp->fetch();
	$mdp_valide2 = $mdp_valide['motdepasse'];
	echo $mdp_valide2."<br>";

	if(isset($_POST['form_suppr'])) {
		if(isset($_POST['mdp']) AND !empty($_POST['mdp'])) {
			$mdp = sha1($_POST['mdp']);
			
			if($mdp == $mdp_valide2) {
				$delete_compte = $bdd->prepare("DELETE FROM membres WHERE id = ?");
				$delete_compte->execute(array($id_session));
				$erreur = "Votre compte a bien été supprimé, <a href=\"index.php\">retour sur la page d'accueille</a>";
			}
		}
	}



?>
<!DOCTYPE html>
<html>
<head>
	<title>Suppression de compte</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body style="background-color: #eeeeee">
	<?php include "header.php"; ?>
	<br>
	<h2 style="text-align: center;">Veuillez entrer votre mot de passe afin de supprimer définitivement votre compte</h2>
	<br><br>
	<div align="center">
	<form method="POST" class="formu">
		<input class="basic" type="password" name="mdp" placeholder="Votre mot de passe" style="width: 200px;">
		<input type="submit" name="form_suppr" value="Confirmez">
	</form>
	      <?php
      if(isset($erreur))
      {
        echo "<font color='red'>" .$erreur."</font><br>";
      }
       ?>
</div>
</body>
</html>
<?php }

 ?>