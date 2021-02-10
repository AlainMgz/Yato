<?php 
include "bdd.php";

if(isset($_SESSION['id'])) {
	$id_session = $_SESSION['id'];

	if(isset($_GET['id']) AND !empty($_GET['id'])) {
		$id_groupe = $_GET['id'];
		$req_id_crea = $bdd->query("SELECT * FROM groupes WHERE id = '$id_groupe'");
		$id_createur = $req_id_crea->fetch();
		$id_crea = $id_createur['id_createur'];

		if($id_crea == $id_session) {

			if(isset($_POST['form_mod'])) {
				if(isset($_POST['q_ex']) AND !empty($_POST['q_ex'])) {
					$pseudo = $_POST['q_ex'];
					$req_id = $bdd->query("SELECT * FROM membres WHERE pseudo = '$pseudo'");
					if($req_id->rowCount() == 1) {
						$id = $req_id->fetch();
						$id_u = $id['id'];

						if($id_u != $id_session) {
							$deja_mbr_grp = $bdd->query("SELECT * FROM groupes_membres WHERE id_membre = '$id_u' AND id_groupe = '$id_groupe'");
							if($deja_mbr_grp->rowCount() == 1) {

								$_SESSION['id_u'] = $id_u;
								$_SESSION['id_groupe'] = $id_groupe;
								$_SESSION['id_crea'] = $id_crea;

								$msg = "Voulez-vous vraiment exclure ".$pseudo."<br><a href=\"exclure.php\" class=\"deja3\">OUI</a>&nbsp;&nbsp;<a href=\"mod_groupe.php?id=$id_groupe\" class=\"deja3\">NON</a>";

							} else {
								$msg = "Cette utilisateur n'est pas membre de votre groupe";
							}

						} else {
							$msg = "Vous ne pouvez pas vous exclure !";
						}

					} else {
						$msg = "Cette utilisateur n'existe pas";
					}
				}
			}




?>
<!DOCTYPE html>
<html>

<head>
	<title>Yato !</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>

<div class="gradient">

 <header class="header_profil">

      <img src="images/Yato 1.png"  height="60px" style="margin-left: 50px; margin-top: 10px;">
      <a href="mailto:yato.network@gmail.com"><img src="images/emaillogo.png" height="30px" style="margin-left: 0px; margin-bottom: 10px;"></a>
            
        <a class="deja3" style="padding: 5px; margin-top: 40px; float: right; margin-right: 25px; margin-left: 20px;" href="profil.php?id=<?= $_SESSION['id'] ?>"><font color="orange">M</font><font color="yellow">on</font> <font color="lightgreen">es</font><font color="cyan">pa</font><font color="yellow">ce</font> <font color="black"><i>!</i></font></a>      
        <a class="deja3" style="float: right; margin-top: 40px; padding: 5px;" href="deconnexion.php">Se déconnecter</a>
          
 </header>

	<div align="center" class="content_mod">
		<h2 style="color: #008299">Vous êtes le créateur du groupe : <b><i> <font color="black"> <?= $id_createur['nom'] ?></i></b></h2></font>
		<h4 style="color: #008299">Vous pouvez modifié le groupe ci-dessous</h4>
		<br><br>
		<form class="formu" method="POST">
			<label style="color: #008299">Entrez le pseudo d'un utilisateur que vous souhaitez exclure : </label><br><br>
			<input type="text" name="q_ex" class="basic user"><br>
			<input type="submit" name="form_mod" value="Rechercher">
			<br>
			<?php if(isset($msg)) { echo "<font color=\"red\">".$msg."<font>"; } ?>
			<br><br><br>
			<a href="groupe.php?id=<?= $id_groupe ?>" class="deja3">Retour sur la page du groupe</a>
			<br><br><br><br><br><br>
			<a href="suppr_grp.php?grp=<?= $id_groupe ?>" class="deja3">Supprimer le groupe</a>
		</form>
	</div>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</div>
</body>

</html>

	<?php

		}

	}
}

 ?>