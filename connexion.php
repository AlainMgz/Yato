<?php
include "bdd.php";

include_once('config_cookie.php');

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

        if(isset($_POST['rememberme'])) {
          setcookie('email',$mailconnect,time()+365*24*3600,null,null,false,true);
          setcookie('password',$mdpconnect,time()+365*24*3600,null,null,false,true);
        }
        
        $_SESSION['id']  = $userinfo['id'];
        $_SESSION['pseudo'] = $userinfo['pseudo'];
        $_SESSION['mail'] = $userinfo['mail'];
        $id = $userinfo['id'];
        
        header("Location: profil.php?id=$id");
      } else {
        $erreur = "Votre compte n'est pas activé, veuillez vérifier vos mails !";
      }
    }

      else
      {
        $erreur = "Mail ou mot de passe non valide !";
      }
    }
    else
    {
      $erreur = "Tous les champs doivent être complétés !";
    }
}
?>
<html>
  <head>
    <script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
    <meta charset="utf-8">
    <title>Connexion - </title>
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
  <body style="background-color: #eeeeee;">
    <header class="header_profil">
      
      
      <a href="index.php"><img src="images/Yato 1.png"  height="60px" style="margin-left: 50px; margin-top: 10px;"></a>
      <a href="mailto:yato.network@gmail.com"><img src="images/emaillogo.png" height="40px" style="margin-left: 00px; margin-top: 0px;"></a>
    </header>
    <section class="connect">


    <div class="checkbox" align="center">
      <p style="color: #008DA6">Votre compte a été crée avec succès, veuillez vous connecter pour accéder à votre espace membre !</p>
      <h2 style="color: #008DA6">Connexion</h2>
      <br>
      <form method="POST" action="" class="formu">
        <input class="basic mail" type="email" name="mailconnect" placeholder="Mail" value="" style="width: 300px; " /><br>
        <input class="basic pass" type="password" name="mdpconnect" placeholder="Mot de Passe" value="" style="width: 300px;"/><br>
        <input type="submit" name="formconnexion" value="Se connecter"/>
        <br>
        
      </form>
      <?php
      if(isset($erreur))
      {
        echo "<font color='red'>" .$erreur."</font>";
      }
       ?><br>
       <a  class="deja" href="index.php">Pas de compte ? Créez-en un ici !</a>
    </div>

    </section>
  </body>
</html>
