<?php 
include "bdd.php";



$id_session = $_SESSION['id'];

$userinfo = $_SESSION['userinfo'];


 ?>
 <?php
      if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) //Quand on est connecter sur son profil
      {
        $msg_nn_lu = $bdd->query("SELECT * FROM messages WHERE id_destinataire = '$id_session' AND lu = 0");

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
  <title>Mon profil</title>
</head>
<body>
  
<div class="banniere">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th width="15%" align="center" valign="middle" scope="col"><?php if(!empty($userinfo['avatar'])) { ?>
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
        <?php } ?></th>
    <td width="85%" rowspan="2" valign="top" scope="col"><div class="bio_court" color: #2c3e50;"><?php echo $userinfo['biographie']; ?></td>
    
  </tr>
  <tr>
    <td align="center" valign="middle">
     <div class="pseudo"><?php echo $userinfo['pseudo']; ?>
     
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
    <div class="profil" style="padding-bottom: 25px;">
  
  <?php $userinfo = $_SESSION['userinfo']; 
  $img1 = $userinfo['img1'];
  $img2 = $userinfo['img2'];
  $img3 = $userinfo['img3'];
  $img4 = $userinfo['img4'];
?>

      <div class="slider2">
      
   <?php  if($img1 != 0) {

  $dimensions1 = getimagesize("membres/diapo/$img1");
?>

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
      

      </a><?php } 

      if($img2 != 0) {
      
        $dimensions2 = getimagesize("membres/diapo/$img2");


      ?><!--
      --><a href="membres/diapo/<?php echo $userinfo['img2'] ?>" target="_blank">
<div class="special" style="
width: 49%; height: 255px;
background-image: url(membres/diapo/<?php echo $userinfo['img2'] ?>);
background-position: center;
background-size:<?php if($dimensions2[0] >= $dimensions2[1]) { ?> auto 100% <?php } else { ?> 100% auto <?php }?>;
background-repeat: no-repeat;
display: inline-block;
float: right;" 

></div>
        
      </a><?php } 
      if($img3 != 0) {

       $dimensions3 = getimagesize("membres/diapo/$img3");



      ?><!--
      --><a href="membres/diapo/<?php echo $userinfo['img3'] ?>" target="_blank">
<div class="special" style="
width: 49%; height: 255px;
background-image: url(membres/diapo/<?php echo $userinfo['img3'] ?>);
background-position: center;
background-size:<?php if($dimensions3[0] >= $dimensions3[1]) { ?> auto 100% <?php } else { ?> 100% auto <?php }?>;
background-repeat: no-repeat;
display: inline-block;
float: left;" 

></div>
        

      </a><?php } 
      if($img4 != 0) {
        $dimensions4 = getimagesize("membres/diapo/$img4");

      ?><!--
      --><a href="membres/diapo/<?php echo $userinfo['img4'] ?>" target="_blank">
<div class="special" style="
width: 49%; height: 255px;
background-image: url(membres/diapo/<?php echo $userinfo['img4'] ?>);
background-position: center;
background-size: <?php if($dimensions4[0] >= $dimensions4[1]) { ?> auto 100% <?php } else { ?> 100% auto <?php }?>;
background-repeat: no-repeat;
display: inline-block;
float: right;" 

></div>
        
      </a><?php } ?>
    </div>
    

  <br>

<form class="formu" enctype="multipart/form-data" method="POST">
    
  <label style="font-size: 15px;">Photo de diapo n°1 : </label><input type="file" name="img1"/>
  <label style="font-size: 15px;">Photo de diapo n°2 : </label><input type="file" name="img2">
  <label style="font-size: 15px;">Photo de diapo n°3 : </label><input type="file" name="img3">
  <label style="font-size: 15px;">Photo de diapo n°4 : </label><input type="file" name="img4">
  <input type="submit" value="Envoyer" name="">
  </form>
<?php if(isset($msg)) { echo "<font color='red'>" .$msg."</font>"; } ?>
     

     </div>
     <?php } else {
      echo "t nul";
     } ?>
</body>
</td>
</tr>
</table>
</div>
</html>