<?php
include "bdd.php";

$id_session = $_SESSION['id'];

$id_3 = $_SESSION['id_3'];

$q = $_SESSION['q'];



 ?>

 <html>
 <head>   
  <meta charset="utf-8">
   <link rel="stylesheet" type="text/css" href="style.css">
   <script type="text/javascript">
      $(function() {
        $(".formu_pv").submit(function() {
          
          message = $(this).find("input[name=message]").val();
          $.post("pv.php", {message: message},function(data){ 
            
            $('#window').load('window.php');
            
          });

          return false
        })
      });
    </script>
   <title></title>

 </head>
 <body>       <a class="deja5 btn4" href="#"><p align="center"><?= $q ?></p></a>

       <br>

         <div align="center" id="messages_rec">
   

  <?php
  $allmsg = $bdd->query("SELECT * FROM messages WHERE id_expediteur IN ($id_session, $id_3) AND id_destinataire IN ($id_session, $id_3) ORDER BY id DESC");
  $pseudo_exp = $bdd->query("SELECT * FROM membres WHERE id = $id_3");
  $p_exp = $pseudo_exp->fetch();


  while ($all = $allmsg->fetch()) { 


    
    if($_SESSION['id'] == $all['id_destinataire']) {

      $emoji_replace = array(':)',':-)',':D', ':-D', ';P', ';-P' );
      $emoji_new = array('<img src="images/smiley_sourire.png" />', '<img src="images/smiley_sourire.png" />', '<img src="images/smiley_rires.png" />', '<img src="images/smiley_rires.png" />', '<img src="images/smiley_langue.png" />', '<img src="images/smiley_langue.png" />');
      $all['message'] = str_replace($emoji_replace, $emoji_new, $all['message']);

    
    ?>

    <p align="left" class="message_rec"><b> <?php echo $p_exp['pseudo']; ?></b> : <?php echo $all['message']; ?> </p>

      
    
     <?php 
    }
    elseif ($_SESSION['id'] == $all['id_expediteur']) {

    $emoji_replace = array(':)',':-)',':D', ':-D', ';P', ';-P' );
    $emoji_new = array('<img src="images/smiley_sourire.png" />', '<img src="images/smiley_sourire.png" />', '<img src="images/smiley_rires.png" />', '<img src="images/smiley_rires.png" />', '<img src="images/smiley_langue.png" />', '<img src="images/smiley_langue.png" />');
    $all['message'] = str_replace(':)', '<img src="images/smiley_sourire.png" />', $all['message']);
     ?>
      <p align="right" class="message_env"><b><?php echo "Moi"; ?></b> : <br><?php echo $all['message']; ?> </p>

   <?php }
      
 
    } ?>
  


  
</div>
<script>

  </script>

  <form class="formu_pv" method="POST">
  <input style="margin-left: 8px; margin-top: 5px; width: 60%;" type="text" class="basic" name="message" id="msg1" placeholder="Votre message">&nbsp;
 <input type="submit" value="Envoyer" name="envoieMessage" style="width: 30%">
 <div id="loader" style="display: none;"><img src="images/ajax-loader.gif" alt="Loading..."></div>
 </form>
 <?php
      if(isset($erreur)) { echo '<span style="color:red">'.$erreur.'</span>'; } 
  ?>

  
       <script type="text/javascript" src="cherche_utilisateur.js"></script>
           <script type="text/javascript">
      $('.btn4').click(function() {
        $('.content_profil').load('profil_autre.php').hide().fadeIn('slow');
          
        
      });
    </script>
 </body>
 </html>