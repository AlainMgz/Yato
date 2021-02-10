<?php
include "bdd.php";

$id_session = $_SESSION['id'];

$id_3 = $_SESSION['id_3'];




 ?>

 <html>
 <head>
   <title></title>
   <meta charset="utf-8">
   <link rel="stylesheet" type="text/css" href="style.css">
 </head>
 <body><?php
   $allmsg = $bdd->query("SELECT * FROM messages WHERE id_expediteur IN ($id_session, $id_3) AND id_destinataire IN ($id_session, $id_3) ORDER BY id DESC");
  $pseudo_exp = $bdd->query("SELECT * FROM membres WHERE id = $id_3");
  $p_exp = $pseudo_exp->fetch();
    while ($all = $allmsg->fetch()) { 
    
      $emoji_replace = array(':)',':-)',':D', ':-D', ';P', ';-P' );
      $emoji_new = array('<img src="images/smiley_sourire.png" />', '<img src="images/smiley_sourire.png" />', '<img src="images/smiley_rires.png" />', '<img src="images/smiley_rires.png" />', '<img src="images/smiley_langue.png" />', '<img src="images/smiley_langue.png" />');
      $all['message'] = str_replace($emoji_replace, $emoji_new, $all['message']);
    
    if($_SESSION['id'] == $all['id_destinataire']) {

    ?>
    
    <p align="left" class="message_rec"><b> <?php echo $p_exp['pseudo']; ?></b> : <?php echo $all['message']; ?> </p>
    <?php $set = $bdd->prepare("UPDATE messages SET lu = ? WHERE id = ?");
          $set->execute(array(1, $all['id'])); 

    ?>
      
    
     <?php 
    }
    elseif ($_SESSION['id'] == $all['id_expediteur']) { ?>

      <p align="right" class="message_env"><b><?php echo "Moi"; ?></b> : <br> <?php if($all['lu'] == 1) { ?> <i><?php echo $all['message']; ?> </i><br><p style="float: right; margin-top: -15px; margin-right: 10px; color: grey; font-size: 13px;"><i>Lu !</i></p> <?php } else { echo $all['message']; } ?></p>

   <?php }
      
 
    } ?>
 </body>
 </html>