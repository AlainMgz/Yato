<?php include "bdd.php";

if(isset($_SESSION['id'])) {
    $h = date("Y-m-d-H-i-s");

  if(isset($_GET['id']) AND !empty($_GET['id'])) {
  
  $id_session = $_SESSION['id'];
  $id_groupe = $_GET['id'];
  $deja_mbr = $bdd->prepare("SELECT * FROM groupes_membres WHERE id_membre = ? AND id_groupe = ?");
  $deja_mbr->execute(array($id_session, $id_groupe));
  $deja = $deja_mbr->rowCount();

  if(isset($_POST['formcode'])) {
    if(isset($_POST['code']) AND !empty($_POST['code'])) {

      $code = sha1($_POST['code']);
      $reqcode = $bdd->prepare("SELECT * FROM groupes WHERE id = ?");
      $reqcode->execute(array($id_groupe));
      $req = $reqcode->fetch();
      
      if($code == $req['code_groupe']) {
        $ins_mbr = $bdd->prepare("INSERT INTO groupes_membres(id_membre, id_groupe) VALUES(?, ?)");
        $ins_mbr->execute(array($id_session, $id_groupe));
        header("Location: groupes.php?id=$id_groupe");
          
      } else {
        $msg = "Code non valide...";
      }


    } else {
      $msg = "Veuillez entrer le code...";
    }
  }

  if(isset($_POST['article']) AND !empty($_POST['article'])) {
    $article = htmlspecialchars($_POST['article']);
    
    $ins_art = $bdd->prepare("INSERT INTO articles_groupes(id_ecrivain, id_groupe, article) VALUES(?, ?, ?)");
    $ins_art->execute(array($_SESSION['id'], $id_groupe, $article));
  }

  $article_grp = $bdd->query("SELECT * FROM articles_groupes WHERE id_groupe = '$id_groupe' ORDER BY id DESC ");


  if(isset($_FILES['img']) AND !empty($_FILES['img'])) {

    $taillemax = 6291456;
    $extensionvalide = array('jpg', 'jpeg', 'gif', 'png');
    if($_FILES['img']['size'] <= $taillemax)
    {
      $extensionupload = strtolower(substr(strrchr($_FILES['img']['name'], '.'), 1));
      if(in_array($extensionupload, $extensionvalide))
      {
                  $nbr_photos = $bdd->query("SELECT * FROM photos_groupes WHERE id_groupe = '$id_groupe'");
          $nbr = $nbr_photos->rowCount();

                 $longueur_nbr = 20;
          $nombre = "";
          for($i=1;$i<$longueur_nbr;$i++) {
            $nombre .= mt_rand(0,9);
          }
         $chemin = "groupes/img/" .$id_groupe."_".$nombre."_".$h.".".$extensionupload;
        $resultat = move_uploaded_file($_FILES['img']['tmp_name'], $chemin);
        if($resultat)
        {

          if(isset($_POST['descriptif']) AND !empty($_POST['descriptif'])) {
            $descriptif = htmlspecialchars($_POST['descriptif']);
            $des_length = strlen($descriptif);

            if($des_length < 255) {

          $updateavatar = $bdd->prepare('INSERT INTO photos_groupes(id_groupe, id_expediteur, photo, descriptif) VALUES(:id_groupe, :id_expediteur, :photo, :descriptif)');
          $updateavatar->execute(array(
            'id_groupe' => $id_groupe,
            'id_expediteur' => $_SESSION['id'],
            'photo' => $id_groupe."_".$nombre."_".$h.".".$extensionupload,
            'descriptif' => $descriptif
            

          ));
          } else {
            $msg = "Votre descriptif ne doit pas dépasser 255 caractères";
          }
         } else {
             $descriptif = "0";
                       $updateavatar = $bdd->prepare('INSERT INTO photos_groupes(id_groupe, id_expediteur, photo, descriptif) VALUES(:id_groupe, :id_expediteur, :photo, :descriptif)');
          $updateavatar->execute(array(
            'id_groupe' => $id_groupe,
            'id_expediteur' => $_SESSION['id'],
            'photo' => $id_groupe."_".$nombre."_".$h.".".$extensionupload,
            'descriptif' => $descriptif
            
            ));
             
         }
         
        }
        else
        {
            $msg = "Erreur lors l'importaion de votre fichier";
        }
      }
      
        
      
    }
    else {
      $msg = "Votre photo ne doit pas dépasser 2 Mo";
    }

  
  }

  $photo = $bdd->query("SELECT * FROM photos_groupes WHERE id_groupe = '$id_groupe' ORDER BY id DESC");
  

  if(isset($_POST['msg_groupe']) AND !empty($_POST['msg_groupe'])) {

    $msg1 = htmlspecialchars($_POST['msg_groupe']);

    $ins = $bdd->prepare("INSERT INTO msg_grp(message, id_expediteur, id_groupe) VALUES(?, ?, ?)");
    $ins->execute(array($msg1, $id_session, $id_groupe));
  }


 ?>

<!DOCTYPE html>
<html>


 <head>
  <title>Groupe</title>
  <script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="jquery.mCustomScrollbar.min.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 
</head>
 <body>
 <div class="gradient">
  
  <header class="header_profil">

      <img src="images/Yato 1.png"  height="60px" style="margin-left: 50px; margin-top: 10px;">
      <a href="mailto:yato.network@gmail.com"><img src="images/emaillogo.png" height="30px" style="margin-left: 0px; margin-bottom: 10px;"></a>
            
        <a class="deja3" style="padding: 5px; margin-top: 40px; float: right; margin-right: 25px; margin-left: 20px;" href="profil.php?id=<?= $_SESSION['id'] ?>"><font color="orange">M</font><font color="yellow">on</font> <font color="lightgreen">es</font><font color="cyan">pa</font><font color="yellow">ce</font> <font color="black"><i>!</i></font></a>      
        <a class="deja3" style="float: right; margin-top: 40px; padding: 5px;" href="deconnexion.php">Se déconnecter</a>
          
</header>
  

    
  <?php
  
  if($deja == 0) { ?>
    <div align="center">
      <h1 style="color: #008DA6">Vous n'êtes pas membre de ce groupe !</h1>
      <h5 style="color: #008DA6">Veuillez inscrire le code d'accès de ce groupe pour y entrer...</h5>
      <form class="formu" method="POST">
        <label>Code d'accès : </label><input type="password" name="code" class="grp" style="display: inline;">
        <br>
        <?php if(isset($msg)) { echo $msg; } ?>
        <br><br>
        <input type="submit" name="formcode" value="Suivant">
      </form>
    </div>
    <?php } elseif($deja == 1) { 
      $reqnom = $bdd->prepare("SELECT * FROM groupes WHERE id = ?");
      $reqnom->execute(array($id_groupe));
      $nom_groupe = $reqnom->fetch();
      $id_crea = $nom_groupe['id_createur'];
      
      $p_crea = $bdd->query("SELECT * FROM membres WHERE id = '$id_crea'");
      $p = $p_crea->fetch();
      
  ?>
    <div class="menu_groupe" align="center">

          <?php if($id_crea == $id_session) { ?><br><a class="deja3" href="mod_groupe.php?id=<?= $id_groupe ?>">Modifier le groupe</a><br><?php } ?>
              <div align="center" style="width: 100%; height: 800px; float: left;">
      <?php $req_mbr = $bdd->query("SELECT * FROM groupes_membres WHERE id_groupe = '$id_groupe' ORDER BY id_membre DESC");
      $nbr_mbr = $req_mbr->rowCount();
      
      ?>
      <p style="margin-top: 0px; font-size: 14px; color: #000000;"><BR><B> MEMBRES (<?= $nbr_mbr ?>)</B></p>
      <div style="width: 90%; height: 90%; margin-bottom: 5px; overflow: auto;">
        <?php 
        while ($mbr = $req_mbr->fetch()) { 
          $id_mbr = $mbr['id_membre'];
          
          $req_ps = $bdd->query("SELECT * FROM membres WHERE id = '$id_mbr' ORDER BY id");
          while ($pseudo = $req_ps->fetch()) { 
            $img_avatar = $pseudo['avatar'];
            $dimensions = getimagesize("membres/avatar/$img_avatar");



            ?>
          
          <div class="photo_groupes_membres" style="width: 50px; 
height: 50px; 
margin-top: 0px;
overflow: hidden; 
 
float: left;
background-image: url(membres/avatar/<?php echo $pseudo['avatar'] ?>);
background-position: center;
background-size: <?php if($dimensions[0] >= $dimensions[1]) { ?> auto 50px <?php } else { ?> 50px auto <?php }?>;
background-repeat: no-repeat;
display: inline;
border-radius: 15px;
    "></div>
    <br> <p style="display: inline;"><?php echo $pseudo['pseudo'] ?></p>
    <br><br>
    <?php   } ?>
          
     <?php  }
         ?>
      </div>
      </div>
     <br><br>

      

      
     
       <br><br><br><br><br><br><br>
    
    

      










      <br><br><br><br><br><br>

       <a class="deja8" href="quitter_grp.php?grp=<?= $id_groupe ?>">Quitter le groupe</a>
       <br><br>

     </div>
      <div align="center" style="height: auto; " >
        
        <div class="left_side_chat" style="float: left;">
          <div class="new_box" id="new_box">
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
          </div>
            <script>
    setInterval('load_box()', 3000);
    function load_box() {
      $('#new_box').load('new_box.php');
    }

  </script>
          <h3 style="color: #008DA6">Discussions du groupe</h3>
          <div class="window_open" style="background-color: #5ac0d3;  margin-top: -10px;">
            <br><br><br>
            <div align="center" id="messages_rec">
            <?php
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
          </div>  
          
          <form class="formu_pv" method="POST">
            <input type="text" name="msg_groupe" class="basic" style="width: 65%; height: 20px; margin-top: 13px; float: left; margin-left: 10px;">

            <input type="submit" name="envoieMsg" style="margin-top: 17px; width: 22%; float: left; margin-left: 8px;">
          </form>
        </div>

        <?php $_SESSION['groupe'] = $id_groupe; ?>
                    <script>
    setInterval('load_chat()', 2000);
    function load_chat() {
      $('#messages_rec').load('chat_grp.php');
    }

  </script>
          <br><br><br>

        </div>
        <div class="content_groupe"> 

          <div class="banniere" style="margin-right: 0%;">
            
          <form class="formu" method="POST" enctype="multipart/form-data" style="width: 100%; height: 150px; margin-bottom: 20px; margin-right: 0px;">
              <img src="images/Groupe.png" height="40px" style="float: center; margin-top: 5px; margin-left: 0px;">
               <p style="color: #0080c0; float: center; margin-top: -5px; font-size: 26px; margin-left: 0px; font-family: times"><i><?= $nom_groupe['nom'] ?></i>&nbsp;<br>
             <input type="text" name="descriptif" placeholder="Décrivez votre photo (255 car. max !)" class="basic" style="float: center; height: 20px; width: 300px; margin-top: 15px; margin-left: 0px; margin-right: 0px; font-size: 16px; display: inline">&nbsp;<br>         
            <input type="file" name="img" style="float: center; margin-top: 5px; margin-left: 5px; font-size: 16px; margin-right: 5px; display: inline;">      
            <input type="submit" name="" style="float: center; margin-top: 0px; margin-left: 0px; margin-right: 0px; display: inline;">&nbsp;<br></p>
          <?php if(isset($msg)) { echo $msg; } ?>
          </form><br>

          </div>
        </div>
     
        <div class="mur">
        
            <div class="nav_img" align="center">
              <div style="font-size: 18px; line-height: 24px; margin-bottom: 5px; color: black; ">Photos du groupe...   
              <div style="overflow: auto; height: 1100px; width: 100%;">
              <?php 
              while ($img = $photo->fetch()) { 
                $p_ph = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
                $p_ph->execute(array($img['id_expediteur']));
                $pseudo_ph = $p_ph->fetch();

                ?>
               <div class="photos">
                <div style="font-size: 17px; line-height: 22px; float: center; color: black; margin-bottom: 0px;">
                  <b><?= $pseudo_ph['pseudo'];  ?></b><br>
                  <i>"<?= $img['descriptif'] ?>"</i>
                  <?php if($pseudo_ph['pseudo'] == $_SESSION['pseudo']) { ?> <a href="suppr_photo_grp.php?grp=<?= $id_groupe ?>&img=<?= $img['photo'] ?>"><img src="images/bin.png" width="40px" height="40px" style="float: right; margin-top: -20px;"></a> <?php }?><br>
                  
         
              

              <a href="groupes/img/<?php echo $img['photo'] ?>" style="text-decoration: none;" target="_blank"><img src="groupes/img/<?php echo $img['photo'] ?>" title="Cliquez pour afficher en plein écran" class="photo_groupes" style="
         
              max-width: 100%;
              max-height: 100%;
              overflow: auto; 
              border-radius: 25px;">
               
              </a>

            </div>
            </div> 
            <?php } 

              ?>
               </div>
               </div>
            </div>
          </div>
            
         
        

        
      

      

     <?php }

  ?>



 </html>
<?php } else {
  header("Location: groupes_crea.php");
}
 } else {
  header("Location: index.php");
 } ?>