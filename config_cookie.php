<?php


if(!isset($_SESSION['id']) AND isset($_COOKIE['mail'],$_COOKIE['password']) AND !empty($_COOKIE['mail']) AND !empty($_COOKIE['password']))
{
  $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ?  AND motdepasse = ?");
  $requser -> execute(array($_COOKIE['mail'], $_COOKIE['password']));
  $userexist = $requser->rowCount();
  if($userexist == 1)
  {

    $userinfo = $requser->fetch();
    $_SESSION['id']  = $userinfo['id'];
    $_SESSION['pseudo'] = $userinfo['pseudo'];
    $_SESSION['mail'] = $userinfo['mail'];
    header("Location: profil.php?id=".$_SESSION['id']);
  }
}

?>
