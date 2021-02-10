<?php
include "bdd.php";

if(isset($_SESSION['id']))
{
  $requser = $bdd->prepare('SELECT * FROM membres WHERE id=?');
  $requser->execute(array($_SESSION['id']));
  $user = $requser->fetch();
  

  if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo'])
  {
    $newpseudo = htmlspecialchars($_POST['newpseudo']);
    $newpseudolength = strlen($newpseudo);
    if($newpseudolength <= 20)
      {
        $reqnewpseudo = $bdd->prepare("SELECT * FROM membres WHERE pseudo =?");
        $reqnewpseudo->execute(array($newpseudo));
        $newpseudoexist = $reqnewpseudo->rowCount();
        if($newpseudoexist == 0)
        {

          $insertpseudo = $bdd->prepare("UPDATE membres SET pseudo = ? WHERE id = ?");
          $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
          header('Location: profil.php?id='.$_SESSION['id']);
        }
        else {
          $msg ="Pseudo déjà utilisé !";
        }
      }
      else {
        $msg = "Votre pseudo dois contenir moins de 20 charactères !";
      }
  }

  if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail'])
  {

    $newmail = htmlspecialchars($_POST['newmail']);

    if(filter_var($newmail, FILTER_VALIDATE_EMAIL))
    {
      $reqnewmail = $bdd->prepare("SELECT * FROM membres WHERE mail =?");
      $reqnewmail->execute(array($newmail));
      $newmailexist = $reqnewmail->rowCount();
      if($newmailexist == 0)
      {

    $insertmail = $bdd->prepare("UPDATE membres SET mail = ? WHERE id = ?");
    $insertmail->execute(array($newmail, $_SESSION['id']));
    header('Location: profil.php?id='.$_SESSION['id']);
      }
      else
      {
        $msg = "Adresse e-mail déjà utilisée !";
      }
    }
    else {
      $msg = "Adresse mail non valide";
    }



  }

  if(isset($_POST['newmdp']) AND !empty($_POST['newmdp']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2']))
  {
    $mdp = sha1($_POST['newmdp']);
    $mdp2 = sha1($_POST['newmdp2']);

    if($mdp == $mdp2)
    {
      $insertmdp = $bdd->prepare("UPDATE membres SET motdepasse = ? WHERE id = ?");
      $insertmdp->execute(array($mdp, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
    }
    else {
      $msg = "Vos deux mots de passes ne correspondent pas";
    }


  }

  if(isset($_POST['bio']) AND !empty($_POST['bio'])) {
    $bio = htmlspecialchars($_POST['bio']);
    $biolength = strlen($bio);
    if($biolength <= 250) {

      $ins_bio = $bdd->prepare("UPDATE membres SET biographie = ? WHERE id = ?");
      $ins_bio->execute(array($bio, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);

    } else {
       $msg = "Votre biographie ne doit pas dépasser 250 caractères !";

    }


  } 

  if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name']))
  {
    $taillemax = 2097152;
    $extensionvalide = array('jpg', 'jpeg', 'gif', 'png');
    if($_FILES['avatar']['size'] <= $taillemax)
    {
      $extensionupload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
      if(in_array($extensionupload, $extensionvalide))
      {
        $chemin = "membres/avatar/".$_SESSION['id'].".".$extensionupload;
        $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
        if($resultat)
        {
          $updateavatar = $bdd->prepare('UPDATE membres SET avatar = :avatar WHERE id = :id');
          $updateavatar->execute(array(
            'avatar' => $_SESSION['id'].".".$extensionupload,
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
      $msg = "Votre photo ne doit pas dépasser 2 Mo";
    }

  }





?>
<html>
  <div class="gradient">
  <head>
    <script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Profil de <?php echo $user['pseudo']; ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="jquery.mCustomScrollbar.min.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript">
      $(function() {
        $(".formu_pv").submit(function() {
          
          message = $(this).find("input[name=message]").val();
          $.post("pv.php", {message: message},function(data){           
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

    
  </head>
  <body style="background-color: #fffff2;">
    
    <header class="header_profil">

      <img src="images/Yato 1.png"  height="60px" style="margin-left: 50px; margin-top: 10px;">
      <a href="mailto:yato.network@gmail.com"><img src="images/emaillogo.png" height="30px" style="margin-left: 0px; margin-bottom: 10px;"></a>
            
        <a class="deja3" style="padding: 5px; margin-top: 40px; float: right; margin-right: 25px; margin-left: 20px;" href="profil.php?id=<?= $_SESSION['id'] ?>"><font color="orange">M</font><font color="yellow">on</font> <font color="lightgreen">es</font><font color="cyan">pa</font><font color="yellow">ce</font> <font color="black"><i>!</i></font></a>      
        <a class="deja3" style="float: right; margin-top: 40px; padding: 5px;" href="deconnexion.php">Se déconnecter</a>
          
</header>

    <div align="center" style="width: 100%;" class="edition">


    <div class="content">
      <div >
      <h2>Edition de mon profil</h2>

        <form  action="" enctype="multipart/form-data" method="POST" class="formu">

          <input class="basic user" type="text" name="newpseudo" placeholder="pseudo" value="<?php echo $user['pseudo']; ?>"/><br>

          <input class="basic mail" type="email" name="newmail" placeholder="Mail" value="<?php echo $user['mail']; ?>"/><br>

          <input class="basic pass" type="password" name="newmdp" placeholder="Nouveau - Mot de passe" value=""/><br>

          <input class="basic pass" type="password" name="newmdp2" placeholder="Confirmez - Mot de passe" value=""/><br>

          <label>Ma mini-bio :</label><br><textarea style="width: 400px;" name="bio" class="text basic" placeholder="Ecrivez ici votre mini biographie (250 car. max!)" ><?php echo $user['biographie']; ?> </textarea><br><br>

          <label class="basic2" >Photo de profil :</label><input type="file" name="avatar" value="" />

          <br><br>
          <?php if(isset($msg)) { echo "<font color='red'>" .$msg."</font>"; } ?>
          <br>
          <input type="submit" name="" value="Mettre à jour mon profil">





        </form>
        <br><br>
        <a href="suppr_compte.php" class="deja8">Supprimer son compte</a>
        
    </div>
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
</div>
</html>
<?php
}
else {
  header("Location: connexion.php");
}

 ?>
