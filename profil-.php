<?php
include "bdd.php";

          
        

if(isset($_SESSION['id'])) {

$id_session = $_SESSION['id'];

if(isset($_GET['id']) AND $_GET['id'] > 0) {
  $msg_nn_lu = $bdd->query("SELECT * FROM messages WHERE id_destinataire = '$id_session' AND lu = 0");
  $getid = intval($_GET['id']);
  $requser = $bdd->prepare('SELECT * FROM membres WHERE id=?');
  $requser->execute(array($getid));
  $userinfo = $requser->fetch();
  $_SESSION['userinfo'] = $userinfo;

  $nbr_msg = $bdd->query('SELECT * FROM messages WHERE id_destinataire = '.$_SESSION['id'].' AND lu = 0');
  $nbr_message = $nbr_msg->rowCount();




if(isset($_FILES['img1']) AND !empty($_FILES['img1']['name']))
  {
    $taillemax = 6291456;
    $extensionvalide = array('jpg', 'jpeg', 'gif', 'png');
    if($_FILES['img1']['size'] <= $taillemax)
    {
      $extensionupload = strtolower(substr(strrchr($_FILES['img1']['name'], '.'), 1));
      if(in_array($extensionupload, $extensionvalide))
      {
        $chemin = "membres/diapo/".$_SESSION['id']."_1.".$extensionupload;
        $resultat = move_uploaded_file($_FILES['img1']['tmp_name'], $chemin);
        if($resultat)
        {
          $updateavatar = $bdd->prepare('UPDATE membres SET img1 = :img1 WHERE id = :id');
          $updateavatar->execute(array(
            'img1' => $_SESSION['id']."_1.".$extensionupload,
            'id' => $_SESSION['id']

          ));
          // header('Location: profil.php?id='.$_SESSION['id']);
        }
        else
        {
            $msg = "Erreur lors l'importaion de votre fichier";
        }
      }
      else {
        $msg = "Le format de votre photo n'est pas compatible";
      }
    }
    else {
      $msg = "Votre photo ne doit pas dépasser 6 Mo";
    }

  } 
  

  if(isset($_FILES['img2']) AND !empty($_FILES['img2']['name']))
  {
    $taillemax = 6291456;
    $extensionvalide = array('jpg', 'jpeg', 'gif', 'png');
    if($_FILES['img2']['size'] <= $taillemax)
    {
      $extensionupload = strtolower(substr(strrchr($_FILES['img2']['name'], '.'), 1));
      if(in_array($extensionupload, $extensionvalide))
      {
        $chemin = "membres/diapo/".$_SESSION['id']."_2.".$extensionupload;
        $resultat = move_uploaded_file($_FILES['img2']['tmp_name'], $chemin);
        if($resultat)
        {
          $updateavatar = $bdd->prepare('UPDATE membres SET img2 = :img2 WHERE id = :id');
          $updateavatar->execute(array(
            'img2' => $_SESSION['id']."_2.".$extensionupload,
            'id' => $_SESSION['id']

          ));
          header('Location: profil.php?id='.$_SESSION['id']);
        }
        else
        {
            $msg = "Erreur lors l'importaion de votre fichier";
        }
      }
      else {
        $msg = "Le format de votre photo n'est pas compatible";
      }
    }
    else {
      $msg = "Votre photo ne doit pas dépasser 6 Mo";
    }

  }

  if(isset($_FILES['img3']) AND !empty($_FILES['img3']['name']))
  {
    $taillemax = 6291456;
    $extensionvalide = array('jpg', 'jpeg', 'gif', 'png');
    if($_FILES['img3']['size'] <= $taillemax)
    {
      $extensionupload = strtolower(substr(strrchr($_FILES['img3']['name'], '.'), 1));
      if(in_array($extensionupload, $extensionvalide))
      {
        $chemin = "membres/diapo/".$_SESSION['id']."_3.".$extensionupload;
        $resultat = move_uploaded_file($_FILES['img3']['tmp_name'], $chemin);
        if($resultat)
        {
          $updateavatar = $bdd->prepare('UPDATE membres SET img3 = :img3 WHERE id = :id');
          $updateavatar->execute(array(
            'img3' => $_SESSION['id']."_3.".$extensionupload,
            'id' => $_SESSION['id']

          ));
          header('Location: profil.php?id='.$_SESSION['id']);
        }
        else
        {
            $msg = "Erreur lors l'importaion de votre fichier";
        }
      }
      else {
        $msg = "Le format de votre photo n'est pas compatible";
      }
    }
    else {
      $msg = "Votre photo ne doit pas dépasser 6 Mo";
    }

  }

  if(isset($_FILES['img4']) AND !empty($_FILES['img4']['name']))
  {
    $taillemax = 6291456;
    $extensionvalide = array('jpg', 'jpeg', 'gif', 'png');
    if($_FILES['img4']['size'] <= $taillemax)
    {
      $extensionupload = strtolower(substr(strrchr($_FILES['img4']['name'], '.'), 1));
      if(in_array($extensionupload, $extensionvalide))
      {
        $chemin = "membres/diapo/".$_SESSION['id']."_4.".$extensionupload;
        $resultat = move_uploaded_file($_FILES['img4']['tmp_name'], $chemin);
        if($resultat)
        {
          $updateavatar = $bdd->prepare('UPDATE membres SET img4 = :img4 WHERE id = :id');
          $updateavatar->execute(array(
            'img4' => $_SESSION['id']."_4.".$extensionupload,
            'id' => $_SESSION['id']

          ));
          header('Location: profil.php?id='.$_SESSION['id']);
        }
        else
        {
            $msg = "Erreur lors l'importaion de votre fichier";
        }
      }
      else {
        $msg = "Le format de votre photo n'est pas compatible";
      }
    }
    else {
      $msg = "Votre photo ne doit pas dépasser 6 Mo";
    }

  }


?>
<html>
  <head>

    <script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Profil de <?php echo $userinfo['pseudo']; ?> (<?= $msg_nn_lu->rowCount()  ?>)</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="jquery.mCustomScrollbar.min.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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

    <script src="jquery.mCustomScrollbar.concat.min.js"></script>
    <script>
      (function($){
        $(window).on("load",function(){
          $("body").mCustomScrollbar({
            theme:'minimal-dark'
           });
          });
        })(jQuery);

      </script>

    
  <style type="text/css">
<!--
#container .content_profil .banniere table tr td {
	font-size: 26px;
	color: #E0EEE2;
}
-->
  </style>
  </head>
<body style="background-color: #fffff2;">
    <?php include"header.php" ?>
<div id="container"> 
    <div class="menu_profil" align="center">

      <?php
      if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) //Quand on est connecter sur son profil
      {

       ?>
       <br>
       <a class="deja3 btn10" href="editionprofil.php">Modifier mon profil</a>

       <br>
       <br>
       <br>
       <a href="groupes_crea.php" class="deja3">Créer un groupe</a>
       <br>
       <br>
       <br>
       <a class="deja3" href="redaction.php">Rédiger un article</a>
      
        
       
     
       <br><br>
       <p class="deja3">Chercher un utilisateur </p>
       
       <div class="bar_open">
        
       <form  class="formu_cherche" method="POST">

       <input type="search" placeholder="Entrez un pseudo" name="q" value="" class="basic">
       <br><br>
       <input type="submit" name="" value="Rechercher" class="submit2">
       
       </form>
        <?php 
     $profil_autre = $bdd->query('SELECT pseudo FROM membres ORDER BY id DESC');
    if(isset($_POST['q']) And !empty($_POST['q'])) {
      $q = htmlspecialchars($_POST['q']);
      $_SESSION['q'] = $q;

        $profil_autre = $bdd->query('SELECT pseudo FROM membres WHERE pseudo LIKE  "'.$q.'" ORDER BY id DESC');


        $id_autre = $bdd->query('SELECT * FROM membres WHERE pseudo LIKE "'.$q.'" ORDER BY id DESC');
        $id_2 = $id_autre->fetch();
        $_SESSION['info_autre'] = $id_2;
        $id_3 = $id_2['id'];
        $_SESSION['id_3'] = $id_3;

        $id_session = $_SESSION['id'];



     ?>         <?php if($profil_autre->rowCount() > 0 && $id_3 != $_SESSION['id']) { ?>
    
      <?php while($p = $profil_autre->fetch()) { ?>
        <p class="btn4 msg">Profil <font color="#684ED9"><b><?= $p['pseudo'] ?></b>: </font> </p>
        <?php }
      } else { ?>
        Pas d'utilisateur correspondant à votre recherche <strong>"<?= $q ?>"</strong>;
    <?php  } ?>
     

   <?php } ?>
  
       </div>
<br>
<p style="margin-top: 0px;" class="deja3">Chercher un groupe</p>
<div class="bar_open">
  <form class="formu_cherche" method="POST">
    <input type="search" placeholder="Nom d'un groupe" name="grp" value="" class="basic">
    <br><br>
       <input type="submit" name="" value="Rechercher" class="submit2">
  </form>
  <?php 
  $groupe = $bdd->query("SELECT nom FROM groupes ORDER BY nom DESC");
  if(isset($_POST['grp']) AND !empty($_POST['grp'])) {
   $grp = htmlspecialchars($_POST['grp']);
   $grps = $bdd->query('SELECT nom FROM groupes WHERE nom LIKE  "'.$grp.'" ORDER BY id DESC');
   $groupes = $bdd->query('SELECT * FROM groupes WHERE nom LIKE  "'.$grp.'" ORDER BY id DESC');
   $all_grp = $groupes->fetch();
   $id_grp = $all_grp['id'];
   $nom_grp = $all_grp['nom'];

        ?>         <?php if($grps->rowCount() == 1) { 
    
       while($grp_1 = $grps->fetch()) { ?>
        <font color="#684ED9"><a class="deja7" href="groupes.php?id=<?= $id_grp ?>"><b><?= $nom_grp ?></b></a></font>
        
        <?php }
      } else { ?>
        Pas de groupe correspondant à votre recherche <strong>"<?= $grp ?>"</strong>;
    <?php  } ?>
     

   <?php } ?>

</div>
<br>
       
     </div>
    <div class="content_profil" align="center" style="overflow: auto;">

      <div class="banniere">



<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="15%" align="center" valign="middle" scope="col"><?php if(!empty($userinfo['avatar'])) { ?>
        <?php 
        $avatar = $userinfo['avatar'];
        $dimensions = getimagesize("membres/avatar/$avatar");
         ?>
        <div class="photo_profil" style="width: 90px; 
          height: 90px;
          overflow: hidden; 

float: left;
background-image: url(membres/avatar/<?php echo $userinfo['avatar'] ?>);
background-position: center;
background-size: <?php if($dimensions[0] >= $dimensions[1]) { ?> auto 90px <?php } else { ?> 90px auto <?php }?>;
background-repeat: no-repeat;
z-index: 2;
border-radius: 15px;
    "></div>
        <?php } ?></td>
    <td width="85%" rowspan="2" valign="top" scope="col">
      <div class="bio_court"><?= $userinfo['biographie']; ?></div></td>
  </tr>
 
 <tr>
    <td width="15%" align="center" valign="middle">
     <div class="pseudo">
      <?php echo $userinfo['pseudo']; ?>
     </div>
    </td>
  </tr>

  <tr>
    <td colspan="2" align="center" valign="bottom">... </td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="bottom"><div align="center" class="nav_profil btn11">Textes</div>&nbsp;<div class="nav_profil btn12">Photos</div></td>
    </tr>
  </table>




        <script type="text/javascript">
      $('.btn11').click(function() {
        $('.profil').load('mes_articles.php').hide().fadeIn('slow');
         
        
      });
    </script>
        <script type="text/javascript">
      $('.btn12').click(function() {
        $('.profil').load('photos_profil.php').hide().fadeIn('slow');
         
        
      });
    </script>
      </div>
      <div class="profil" style="padding-bottom: 0px;">
        <?php $userinfo = $_SESSION['userinfo']; 
  $img1 = $userinfo['img1'];
  $img2 = $userinfo['img2'];
  $img3 = $userinfo['img3'];
  $img4 = $userinfo['img4'];

  if($img1 != 0 && $img2 != 0 && $img3 != 0 && $img4 != 0) {

  $dimensions1 = getimagesize("membres/diapo/$img1");

  $dimensions2 = getimagesize("membres/diapo/$img2");

  $dimensions3 = getimagesize("membres/diapo/$img3");

  $dimensions4 = getimagesize("membres/diapo/$img4");
  
  ?>
        <br>
        <div class="slider2"> 
        <a href="membres/diapo/<?php echo $userinfo['img1'] ?>" target="_blank">
          <div class="special" style="
width: 49%; height: 255px;
background-image: url(membres/diapo/<?php echo $userinfo['img1'] ?>);
background-position: center;
background-size:<?php if($dimensions1[0] >= $dimensions1[1]) { ?> auto 100% <?php } else { ?> 100% auto <?php }?>;
background-repeat: no-repeat;
display: inline-block;
float: left;" 

></div>
          </a>
          <!--
      -->
          <a href="membres/diapo/<?php echo $userinfo['img2'] ?>" target="_blank">
            <div class="special" style="
width: 49%; height: 255px;
background-image: url(membres/diapo/<?php echo $userinfo['img2'] ?>);
background-position: center;
background-size:<?php if($dimensions2[0] >= $dimensions2[1]) { ?> auto 100% <?php } else { ?> 100% auto <?php }?>;
background-repeat: no-repeat;
display: inline-block;
float: right;" 

></div>
          </a><br>
          <!--
      -->
          <a href="membres/diapo/<?php echo $userinfo['img3'] ?>" target="_blank">
            <div class="special" style="
width: 49%; height: 255px;
background-image: url(membres/diapo/<?php echo $userinfo['img3'] ?>);
background-position: center;
background-size:<?php if($dimensions3[0] >= $dimensions3[1]) { ?> auto 100% <?php } else { ?> 100% auto <?php }?>;
background-repeat: no-repeat;
display: inline-block;
float: left;" 

></div>
          </a>
          <!--
      -->
          <a href="membres/diapo/<?php echo $userinfo['img4'] ?>" target="_blank">
            <div class="special" style="
width: 49%; height: 255px;
background-image: url(membres/diapo/<?php echo $userinfo['img4'] ?>);
background-position: center;
background-size: <?php if($dimensions4[0] >= $dimensions4[1]) { ?> auto 100% <?php } else { ?> 100% auto <?php }?>;
background-repeat: no-repeat;
display: inline-block;
float: right;" 

></div>
          </a> </div>

        <?php } else {
  echo "<br><br><br>Vous n'avez pas publié de photos, faites-le dès maintenant avec le formulaire ci-dessous :";
} ?>
        <br>
        <br>
        <form class="formu" enctype="multipart/form-data" method="POST">
          <label style="font-size: 15px;">Photo de diapo n°1 : </label>
          <input type="file" name="img1"/>
          <br>
          <label style="font-size: 15px;">Photo de diapo n°2 : </label>
          <input type="file" name="img2">
          <br>
          <label style="font-size: 15px;">Photo de diapo n°3 : </label>
          <input type="file" name="img3">
          <br>
          <label style="font-size: 15px;">Photo de diapo n°4 : </label>
          <input type="file" name="img4">
          <br>
          <input type="submit" value="Envoyer" name="input">
        </form>
        <?php if(isset($msg)) { echo "<font color='red'>" .$msg."</font>"; } ?>
      </div>
    </div>
    <div class="left_side_chat">
      <div class="new_box" id="new_box" align="left">
        <?php   $id_session = $_SESSION['id'];
  
  while ($msg = $msg_nn_lu->fetch()) { 
  
  $id_recu = $msg['id_expediteur'];
  $pseudo = $bdd->query("SELECT * FROM membres WHERE id = '$id_recu'"); ?>
        <?php while ($p = $pseudo->fetch()) { ?>
        <p class="new_msg">Nouveau message de <b>
          <?= $p['pseudo'] ?> 
        </b></p>
        <?php }


  }

   if($msg_nn_lu->rowCount() == 0) { ?>
        <p class="new_msg">Vous n'avez pas de nouveaux messages...</p>
        <?php } ?>
      </div>
      <script>
    setInterval('load_box()', 3000);
    function load_box() {
      $('#new_box').load('new_box.php');
    }

  </script>
     <div class="window" id="window" align="left">

       <a class="deja5 btn4" href="#"><p align="center"><?= $q ?></p></a>

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
    setInterval('load_message()', 3000);
    function load_message() {
      $('#messages_rec').load('load_msg.php');
    }

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
     </div>
     <?php
      }
      
      ?>
</div>
    </div>
    <script type="text/javascript">
      $('.btn4').click(function() {
        $('.content_profil').load('profil_autre.php').hide().fadeIn('slow');
          
        
      });
    </script>
    <script type="text/javascript">
      $('.btn5').click(function() {
        $('.content_profil').load('mon_profil.php').hide().fadeIn('slow');
         
        
      });
    </script>
          
  </body>
</html>
<?php
  }


 } else {
  header('Location: index.php');
 }
?>
