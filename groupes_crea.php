<?php
include "bdd.php";

if(isset($_SESSION['id'])) {

if(isset($_POST['formgroupe'])) {
	if(isset($_POST['nom']) AND !empty($_POST['nom'])) {

		$nom_exist = $bdd->prepare("SELECT * FROM groupes WHERE nom = ?");
		$nom_exist->execute(array($_POST['nom']));
		$nom1 = $nom_exist->rowCount();
		
		if($nom1 == 0) {

			$nom = htmlspecialchars($_POST['nom']);

			$nom_length = strlen($nom);

			if($nom_length <= 50) {

			if(isset($_POST['mdp'], $_POST['mdp2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {

				$mdp = sha1($_POST['mdp']);
				$mdp2 = sha1($_POST['mdp2']);

				if($mdp == $mdp2) {

					$ins = $bdd->prepare("INSERT INTO groupes(nom, code_groupe, id_createur) VALUES(?, ?, ?)");
					$ins->execute(array($nom, $mdp, $_SESSION['id']));
					$req_id = $bdd->query("SELECT id FROM groupes WHERE nom = '$nom'"); 
					$req = $req_id->fetch();
					$id_groupe = $req['id'];
					$msg = "Votre groupe a bien été crée ! ";
					header("Location: groupes.php?id=$id_groupe");
				} else {
					$msg = "Vos deux codes ne correspondent pas...";
				}
			} else {
				$msg = "Veuillez définir un code d'accès au groupe...";
			}

			} else {
				$msg = "Le nom doit contenir moins de 50 caractères !";
			}

		} else {
			$msg = "Ce nom est déjà utilisé...";
		}

	} else {
		$msg = "Veuillez préciser un nom pour votre groupe...";
	}
}

 ?>
 <!DOCTYPE html>
 <html>
 <div class="gradient">
 <head>
 	<title>Création d'un groupe</title>
 	<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="jquery.mCustomScrollbar.min.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

 </head>
 <body style="background-color: #eeeeee;">
 
<header class="header_profil">

      <img src="images/Yato 1.png"  height="60px" style="margin-left: 50px; margin-top: 10px;">
      <a href="mailto:yato.network@gmail.com"><img src="images/emaillogo.png" height="30px" style="margin-left: 0px; margin-bottom: 10px;"></a>
            
        <a class="deja3" style="padding: 5px; margin-top: 40px; float: right; margin-right: 25px; margin-left: 20px;" href="profil.php?id=<?= $_SESSION['id'] ?>"><font color="orange">M</font><font color="yellow">on</font> <font color="lightgreen">es</font><font color="cyan">pa</font><font color="yellow">ce</font> <font color="black"><i>!</i></font></a>    	
        <a class="deja3" style="float: right; margin-top: 40px; padding: 5px;" href="deconnexion.php">Se déconnecter</a>
          
</header>
 
    <div class="container" align="center">
    	<br><br><br><br>
    	<form method="POST" class="formu">
    		<label style="color: #008DA6; font-size: 18px;">Nom du groupe : </label><input type="text" name="nom" class="grp" style="display: inline;">
    		<br><br><br>
    		<label style="color: #008DA6; font-size: 18px;">Code d'accès au groupe <font color="#004a99"><b>*</b></font> : </label><input type="password" name="mdp" class="grp" style="display: inline;">
    		<br><br><br>
    		<label style="color: #008DA6; font-size: 18px;">Confirmez le code d'accès : </label><input type="password" name="mdp2" class="grp" style="display: inline;">
    		<br><br>
    		<?php if(isset($msg)) { echo $msg; } ?>
    		<br>
    		<input type="submit" class="basic" value="Créer le groupe !" name="formgroupe">
    	</form><br>
    	<p style="color: #004a99; font-size: 18px;"><i>* Vous partagez ce code d'accès à ceux que vous voulez qu'il/elle puisse rejoindre le groupe !</i></p>
    
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
 
 </div>

 </body>
</div> 

 </html>

 <?php } else {
 	header("Location: index.php");
 } ?>