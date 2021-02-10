<?php
include "bdd.php";


if(isset($_SESSION['id'])) {

$id_session = $_SESSION['id'];

$id_3 = $_SESSION['id_3'];

extract($_POST); // extract du deuxième formulaire

if(isset($message) AND !empty($message)) {

$message = htmlspecialchars($message);


$sql = $bdd->prepare("INSERT INTO messages(id_expediteur, id_destinataire, message, lu) VALUES(?, ?, ?, ?)");
$sql->execute(array($id_session, $id_3, $message, 0)); // la variable id_3 est obtenue grâce au premier formulaire
 
	

	} else {
		echo "Veuillez entrez votre message";
	}

}

  if(isset($erreur)) { echo '<span style="color:red">'.$erreur.'</span>'; } ?>

