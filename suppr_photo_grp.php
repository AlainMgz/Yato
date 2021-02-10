<?php 
include "bdd.php";

if(isset($_SESSION['id'])) {
	$id_session = $_SESSION['id'];

	if(isset($_GET['grp'], $_GET['img']) AND !empty($_GET['grp']) AND !empty($_GET['img'])) {
		$id_grp = $_GET['grp'];
		

		$img = $_GET['img'];

	$req_exp = $bdd->query("SELECT * FROM photos_groupes WHERE id_groupe = '$id_grp' AND photo = '$img'");
	$exp = $req_exp->fetch();
	

		 if($id_session == $exp['id_expediteur']) {

		$delete_img = $bdd->prepare("DELETE FROM photos_groupes WHERE id_groupe = ? AND photo = ?");
		$delete_img->execute(array($id_grp, $img));
		header("Location: groupes.php?id=$id_grp");


		} else {
			echo "Vous ne pouvez pas supprimer la photo de quelqu'un d'autre ! <a href=\"profil.php?id=$id_session\">Revenir sur son profil</a> ";
		}
	} else {
		header("Location: profil.php?id=$id_session ");
	}

} else {
	header("Location: index.php");
}




 ?>