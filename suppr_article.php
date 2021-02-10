<?php
include "bdd.php";

$edit_id = htmlspecialchars($_GET['id']);
$edit_article = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
$edit_article->execute(array($edit_id));

if($edit_article->rowCount() == 1) {

  $edit_article = $edit_article->fetch();




$getid = intval($_GET['id']);

$session_id = intval($_SESSION['id']);
$req_id_ecrivain = $bdd->query("SELECT id_ecrivain FROM articles WHERE id = '$getid'");


$id_info = $req_id_ecrivain->fetch();



if(isset($_SESSION['id']) AND $_SESSION['id'] == $id_info['id_ecrivain'])
{


  $suppr_id = htmlspecialchars($_GET['id']);
   $suppr = $bdd->prepare('DELETE FROM articles WHERE id = ?');
   $suppr->execute(array($suppr_id));





?> <br> <?php
  header("Location: profil.php?id=".$session_id);
}


 else {
   header("Location: connexion.php");
 }

} else {
  die('Erreur : cette article n\'existe pas. Bien essayé :)');

}

 ?>
