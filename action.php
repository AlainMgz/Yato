<?php 
include "bdd.php";

if(isset($_SESSION['id'])) {

if(isset($_GET['t'],$_GET['id']) AND !empty($_GET['t']) AND !empty($_GET['id'])) {
	$getid = (int) $_GET['id'];
	$gett = (int) $_GET['t'];

	$id_session = $_SESSION['id'];

	$check = $bdd->prepare('SELECT id FROM articles WHERE id = ?');
	$check->execute(array($getid));

	if($check->rowCount() == 1) {
		if($gett == 1) {
			$check_like = $bdd->prepare('SELECT id FROM likes WHERE id_article = ? AND id_membre = ?');
			$check_like->execute(array($getid,$id_session));
			
			$del = $bdd->prepare('DELETE FROM dislikes WHERE id_article = ? AND id_membre = ?');
			$del->execute(array($getid, $id_session));

			if($check_like->rowCount() == 1) {
				$del = $bdd->prepare('DELETE FROM likes WHERE id_article = ? AND id_membre = ?');
				$del->execute(array($getid, $id_session));

			} else {
				$ins = $bdd->prepare('INSERT INTO likes (id_article, id_membre) VALUES (?, ?)');
				$ins->execute(array($getid, $_SESSION['id']));
			}

			
		} elseif($gett == 2) {
			$check_like = $bdd->prepare('SELECT id FROM dislikes WHERE id_article = ? AND id_membre = ?');
			$check_like->execute(array($getid, $id_session));

			$del = $bdd->prepare('DELETE FROM likes WHERE id_article = ? AND id_membre = ?');
			$del->execute(array($getid, $id_session));

			if($check_like->rowCount() == 1) {
			$del = $bdd->prepare('DELETE FROM dislikes WHERE id_article = ? AND id_membre = ?');
			$del->execute(array($getid, $id_session));

			} else {
				$ins = $bdd->prepare('INSERT INTO dislikes (id_article, id_membre) VALUES (?, ?)');
				$ins->execute(array($getid,$id_session));
			}
		}
		header('Location: article.php?id='.$getid);
	} else { ?>
	<script type="text/javascript">
		function al() {
			alert('Cette article n\'existe pas | <a href="profil.php?id=<?= $_SESSION['id'] ?>">Retour sur mon profil</a> ')
		}
	</script>
	<?php } 

}  else { ?>
	<script type="text/javascript">
		function aler() {
			alert('Cette article est mauvais | <a href="profil.php?id=<?= $_SESSION['id'] ?>">Retour sur mon profil</a> ')
		}
	</script>
	<?php } 
}

?>

