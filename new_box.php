<?php 
include "bdd.php";
 ?>
 <!DOCTYPE html>
 <html>
 <head>
   <title></title>
 </head>
 <body>
 <?php   $id_session = $_SESSION['id'];

$msg_nn_lu = $bdd->query("SELECT * FROM messages WHERE id_destinataire = '$id_session' AND lu = 0");
  
  while ($msg = $msg_nn_lu->fetch()) { 
  
  $id_recu = $msg['id_expediteur'];
  $pseudo = $bdd->query("SELECT * FROM membres WHERE id = '$id_recu'"); ?>
    
    <?php while ($p = $pseudo->fetch()) { ?>
      <p class="new_msg">Nouveau message de <b><?= $p['pseudo'] ?></b></p>
    <?php }


  }

   if($msg_nn_lu->rowCount() == 0) { ?>
    <p class="new_msg">Vous n'avez pas de nouveaux messages...</p>
  <?php } ?>
 </body>
 </html>