<?php 
include "bdd.php";

if(isset($_SESSION['id'])) {
	$id_session = $_SESSION['id'];
	if(isset($_GET['grp']) AND !empty($_GET['grp'])) {
		$id_groupe = $_GET['grp'];
		$delete_mbr = $bdd->prepare("DELETE FROM groupes_membres WHERE id_membre = ? AND id_groupe = ? ");
		$delete_mbr->execute(array($id_groupe, $id_session));
		header("Location: profil.php?id=$id_session");
	} else {
		header("Location: profil.php?id=$id_session");
	}
} else {
	header("Location: index.php");
}




 ?>