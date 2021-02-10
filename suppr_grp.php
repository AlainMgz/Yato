<?php 
include "bdd.php";

if(isset($_SESSION['id'])) {
	$id_session = $_SESSION['id'];

	if(isset($_GET['grp']) AND !empty($_GET['grp'])) {
		$id_groupe = $_GET['grp'];
		$req_crea = $bdd->query("SELECT * FROM groupes WHERE id = '$id_groupe'");
		$info_grp = $req_crea->fetch();
		$id_crea = $info_grp['id_createur'];

		if($id_crea == $id_session) {
			$del_grp = $bdd->prepare("DELETE FROM groupes WHERE id = ?");
			$del_grp->execute(array($id_groupe));
			$del_mbr = $bdd->prepare("DELETE FROM groupes_membres WHERE id_groupe = ?");
			$del_mbr->execute(array($id_groupe));
			?><script>
				alert("Le groupe a bien été supprimé !")
			</script><?php
			header("Location: profil.php?id=$id_session");
		} else {
			echo "Vous ne pouvez pas supprimé un groupe dont vous n'êtes pas le créateur !";
		}
	} else {
		header("Location: profil.php?id=$id_session");
	}
} else {
	header("Location: index.php");
}



 ?>