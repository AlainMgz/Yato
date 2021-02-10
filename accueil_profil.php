<?php 
include "bdd.php";

if(isset($_SESSION['id'])) {


?>

<html>
<head>
	<title></title>
	<!--<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>-->
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<br>
	<div class="new_box" align="left">
<?php 	$id_session = $_SESSION['id'];
	$msg_nn_lu = $bdd->query("SELECT * FROM messages WHERE id_destinataire = '$id_session' AND lu = 0");
	while ($msg = $msg_nn_lu->fetch()) { 
	
	$id_recu = $msg['id_expediteur'];
	$pseudo = $bdd->query("SELECT * FROM membres WHERE id = '$id_recu'"); ?>
		
		<?php while ($p = $pseudo->fetch()) { ?>
			<p class="new_msg">Nouveau message de <?= $p['pseudo'] ?></p>
		<?php }


	}

	 if($msg_nn_lu->rowCount() == 0) { ?>
		<p class="new_msg">Vous n'avez pas de nouveaux messages...</p>
	<?php } ?>
	</div>
</body>
</html>

<?php } else {
	header("Location: index.php");
} ?>