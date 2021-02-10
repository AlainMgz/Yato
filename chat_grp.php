<?php
include "bdd.php";


 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

            
            <?php
            $id_groupe = $_SESSION['groupe'];
  $allmsg = $bdd->query("SELECT * FROM msg_grp WHERE id_groupe = '$id_groupe' ORDER BY id DESC");



  while ($all = $allmsg->fetch()) { 


    
    if($_SESSION['id'] != $all['id_expediteur']) {

      $emoji_replace = array(':)',':-)',':D', ':-D', ';P', ';-P' );
      $emoji_new = array('<img src="images/smiley_sourire.png" />', '<img src="images/smiley_sourire.png" />', '<img src="images/smiley_rires.png" />', '<img src="images/smiley_rires.png" />', '<img src="images/smiley_langue.png" />', '<img src="images/smiley_langue.png" />');
      $all['message'] = str_replace($emoji_replace, $emoji_new, $all['message']);

    $p_expediteur = $bdd->prepare("SELECT * FROM membres where id = ?");
    $p_expediteur->execute(array($all['id_expediteur']));
    $p_exp = $p_expediteur->fetch();
    ?>

    <p align="left" style="margin-top: 20px;" class="message_rec_grp"><b> <?php echo $p_exp['pseudo']; ?></b> : <?php echo $all['message']; ?> </p>

      
    
     <?php 
    }
    elseif ($_SESSION['id'] == $all['id_expediteur']) {

    $emoji_replace = array(':)',':-)',':D', ':-D', ';P', ';-P' );
    $emoji_new = array('<img src="images/smiley_sourire.png" />', '<img src="images/smiley_sourire.png" />', '<img src="images/smiley_rires.png" />', '<img src="images/smiley_rires.png" />', '<img src="images/smiley_langue.png" />', '<img src="images/smiley_langue.png" />');
    $all['message'] = str_replace(':)', '<img src="images/smiley_sourire.png" />', $all['message']);
     ?>
      <p align="right" style="margin-top: 20px;" class="message_env_grp"><b><?php echo "Moi"; ?></b> : <br><?php echo $all['message']; ?> </p>

   <?php }
      
 
    } ?>
         
          
                    <script>
    setInterval('load_chat()', 2000);
    function load_chat() {
      $('#messages_rec').load('chat_grp.php');
    }

  </script>

</body>
</html>