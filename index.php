<?php
include "bdd.php";


  if(isset($_POST['forminscription']))
  {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $mail = htmlspecialchars($_POST['mail']);
    $mdp = sha1($_POST['mdp']);
    $mdp2 = sha1($_POST['mdp2']);


    if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']))
    {

      $pseudolength = strlen($pseudo);
      if($pseudolength <= 20)
        {
          $reqpseudo = $bdd->prepare("SELECT * FROM membres WHERE pseudo =?");
          $reqpseudo->execute(array($pseudo));
          $pseudoexist = $reqpseudo->rowCount();
          if($pseudoexist == 0)
          {


            if(filter_var($mail, FILTER_VALIDATE_EMAIL))
            {
              $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ? ");
              $reqmail->execute(array($mail));
              $mailexist = $reqmail->rowCount();
              if($mailexist == 0)
              {
                  if($mdp == $mdp2)
                  {

                    
                    $ins_mbr = $bdd->prepare("INSERT INTO membres(pseudo, mail, motdepasse, avatar, biographie, img1, img2, img3, img4, confirmkey, confirme) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $ins_mbr->execute(array($pseudo, $mail, $mdp, 0, 0, 0, 0, 0, 0, 0, 0));
                    header("Location: inscri_photo.php");
                    $_SESSION['pseudo'] = $pseudo;
                    $_SESSION['mail'] = $mail;

                  }
                  else
                  {
                    $erreur = "Vos mots de passes ne correspondent pas !";
                  }

                }
                else {
                  $erreur = "Adresse mail déja utilisée !";
                }
            }
            else
            {
              $erreur = "Votre adresse mail n'est pas valide !";
            }
          }
          else
          {
            $erreur = "Pseudo déjà  utilisée !";
          }
        }
      else
      {
        $erreur = "Votre pseudo ne doit pas dépasser 20 charactères !";
      }

    }
    else
    {
      $erreur = "Tous les champs doivent être complétés !";
    }

  }


  if(isset($_POST['formconnexion']))
{
  $mailconnect = htmlspecialchars($_POST['mailconnect']);
  $mdpconnect = sha1($_POST['mdpconnect']);
    if(!empty($mailconnect) AND !empty($mdpconnect))
    {
      $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ?  AND motdepasse = ?");
      $requser -> execute(array($mailconnect, $mdpconnect));
      $userexist = $requser->rowCount();
      if($userexist == 1)
      {

        $userinfo = $requser->fetch();
        if($userinfo['confirme'] == 1) {


        $_SESSION['id']  = $userinfo['id'];
        $_SESSION['pseudo'] = $userinfo['pseudo'];
        $_SESSION['mail'] = $userinfo['mail'];
        header("Location: profil.php?id=".$_SESSION['id']);
        } else {
          $error = "Votre compte n'est pas activé, veuillez vérifier vos mails !";
        }
      }

      else
      {
        $error = "Mail ou mot de passe non valide !";
      }
    }
    else
    {
      $error = "Tous les champs doivent être complétés !";
    }
}

?>
<!DOCTYPE html>
<html>

  <div class="gradient">
  <body>
  <head>

    <link rel="shortcut icon" href="images/Yato-16x16b (2).ico">
    <link rel="stylesheet" type="text/css" href="diapo - Copie.css">
    <script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Yato !</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="jquery.mCustomScrollbar.min.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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

   <header class="header_index">

      <form method="POST" action="" class="formu_connect">
        <input style="margin-top: 10px" class="basic mail" placeholder="Mail" type="email" name="mailconnect">
        <input class="basic pass" placeholder="Mot de passse" type="password" name="mdpconnect">
        <input type="submit" name="formconnexion" value="Se connecter"><br>
         <?php
       if(isset($error))
      {
        echo "<font color='red'>" .$error."</font>";
      }
       ?>
      </form>


      <img src="images/Yato 1.png"  height="60px" style="margin-left: 50px; margin-top: 10px;">
      <a href="mailto:yato.network@gmail.com"><img src="images/emaillogo.png" height="30px" style="margin-left: 20px; margin-bottom: 10px;"></a>
    </header>

    <div class="inscri_index" align="left"
    height: auto; padding-bottom: 30px; margin-left: ; color: #008299;">

    <h1 style="display: inline-block; margin-left: 35%;">Bienvenue sur<img src="images/Yato 2.png"; height="40px"; style="margin-left: 10px; margin-top: 5px; margin-bottom: -10px;"></h1>
    <br>
<h3 style="margin-left: 100px; display: inline; margin-top: -0px;">Inscrivez-vous pour commencer !</h3>
<br>
<br>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th width="384" align="left" valign="top" scope="col"> <div class="encadre" style="margin-left: 50px;" align="center">
      <form method="POST" action="" class="formu">
        <table>

          <tr>

            <td>
              <input class="inscriform user2 preums" type="text" placeholder="Votre Pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>"/>
            </td>
          </tr>
            <tr>

            <td>
              <input class="inscriform mail2" type="email" placeholder="Votre E-mail" id="mail" name="mail"  value="<?php if(isset($mail)) { echo $mail; } ?>"/>
            </td>
        </tr>

    <tr>

    <td>
      <input class="inscriform pass2" type="password" placeholder="Votre mot de passe" id="mdp" name="mdp"/>
    </td>
</tr>
<tr>

<td>
  <input class="inscriform pass2" type="password" placeholder="Confirmez - Mot de passe" id="mdp2" name="mdp2"/>
</td>
</tr>
</table>

      <?php
      if(isset($erreur))
      {
        echo "<font color='red'>" .$erreur."</font><br>";
      }
       ?>

<input type="submit" title="Insrivez-vous... GRATUITEMENT !" name="forminscription" value="Je m'inscris !">
      </form>


    </div>&nbsp;</th>
        <td align="left" valign="top" scope="col">
   <div class="propos">

   <font color="black">
   <p>Petite histoire de <b>Yato<font color="yellow"> <i>!</i></font></b> :
      <br>
  - Tu sais qui est le meilleur dans la classe en informatique ?<br>
  - Tu ne vas pas me dire que c'est toi ?<br>
  - Ben oui.<br>
  - Peux-tu me faire alors quelque-chose sur internet où l'on peut communiquer avec la famille et les potes sans pubs et autres s........ ?<br>
  - Sans problèmes.<br>
  - Si tu y arrives, le père Noël n'oubliera pas un joli ordinateur dans son traînot.<br>
  - D'accord, paris conclut.<br>
  - Top-là. Mais tu me laisses ajouter quelques couleurs.
  </p>

</font>
    </div>&nbsp;</td>
      </tr>
    </table>

   </div>
<br>
<section id="slideshow">

  <div class="container2">
    <div class="c_slider"></div>
    <div class="slider">



      <a href="#" target="_blank"><figure>
<div style="
width: 640px; height: 360px;
background-image: url(images/yato1.png);
background-position: center;
background-size: auto 360px;
background-repeat: no-repeat;"

></div>
        <figcaption style="color: #684ED9;"><b>Créez votre groupe !</b></figcaption>

      </figure></a><!--
      --><a href="#" target="_blank"><figure>
<div style="
width: 640px; height: 360px;
background-image: url(images/yato3.png);
background-position: center;
background-size: auto 360px;
background-repeat: no-repeat;"

></div>
        <figcaption style="color: #684ED9;"><b>Echangez et partagez avec les membres de votre groupe</b></figcaption>
      </figure></a><!--
      --><a href="#" target="_blank"><figure>
<div style="
width: 640px; height: 360px;
background-image: url(images/yato2.png);
background-position: center;
background-size: auto 360px;
background-repeat: no-repeat;"

></div>
        <figcaption style="color: #684ED9;"><b>Exprimez-vous dans un article !</b></figcaption>

      </figure></a><!--
      --><a href="#" target="_blank"><figure>
<div style="
width: 640px; height: 360px;
background-image: url(images/yato4.png);
background-position: center;
background-size: auto 360px;
background-repeat: no-repeat;"

></div>
        <figcaption style="color: #684ED9;"><b>Discutez et publiez vos photos sur votre espace personnel !</b></figcaption>
      </figure></a>
    </div>
  </div>

  <span id="timeline"></span>

</section>

  <footer class="contact_us">®oute-du-roi <br>Pour tout contact, veuillez écrire à cette adresse : <a class="deja3" href="mailto:yato.network@gmail.com">yato.network@gmail.com</a></footer><br><br><br><br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

 </body>
</div>
</html>
