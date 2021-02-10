<?php 
include "bdd.php";

if(isset($_SESSION['id'])) {
	$id_session = $_SESSION['id'];

	if(isset($_SESSION['id_u'], $_SESSION['id_groupe'], $_SESSION['id_crea']) AND !empty($_SESSION['id_u']) AND !empty($_SESSION['id_groupe']) AND !empty($_SESSION['id_crea'])) {
		$id_u = $_SESSION['id_u'];
		$id_groupe = $_SESSION['id_groupe'];
		$id_crea = $_SESSION['id_crea'];

		if($id_crea == $id_session) {
			$del = $bdd->prepare("DELETE FROM groupes_membres WHERE id_groupe = ? AND id_membre = ?");
			$del->execute(array($id_groupe, $id_u));
			header("Location: mod_groupe.php?id=$id_groupe");
		}
	}
}


 ?>