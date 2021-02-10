<?php
include "bdd.php";

$mode_edition = 0;



if(isset($_GET['id']) AND !empty($_GET['id'])) {
  $mode_edition = 1;
  $edit_id = htmlspecialchars($_GET['id']);
  $edit_article = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
  $edit_article->execute(array($edit_id));

  if($edit_article->rowCount() == 1) {

    $edit_article = $edit_article->fetch();

  } else {
    die('Erreur : cette article n\'existe pas');
  }
}



if(isset($_SESSION['id'])) {

if(isset($_POST['article_titre'], $_POST['article_contenu'])) {
  if(!empty($_POST['article_titre']) AND !empty($_POST['article_contenu'])) {
    $article_titre = htmlspecialchars($_POST['article_titre']);
    $article_contenu = htmlspecialchars($_POST['article_contenu']);

    if($mode_edition == 0) {
    $ins = $bdd->prepare('INSERT INTO articles (id_ecrivain, titre, contenu, date_time_publication)
    VALUES (?, ?, ?, NOW())');
    $ins->execute(array($_SESSION['id'], $article_titre, $article_contenu));
    header('Location: profil.php?id='.$_SESSION['id']);
    $erreur = "Votre article a bien été posté";
  } else {
    $getid = intval($_GET['id']);

    $session_id = intval($_SESSION['id']);
    $req_id_ecrivain = $bdd->query("SELECT id_ecrivain FROM articles WHERE id = '$getid'");


    $id_info = $req_id_ecrivain->fetch();



    if(isset($_SESSION['id']) AND $_SESSION['id'] == $id_info['id_ecrivain'])
    {



    $update = $bdd->prepare('UPDATE articles SET titre = ?, contenu = ?, date_time_publication = NOW() WHERE id = ?');
    $update->execute(array($article_titre, $article_contenu, $edit_id));
    header("Location: article.php?id=".$edit_id);
    $erreur = "Votre article a bien été mis à jour !";
  }
  else {
    $erreur = "Vous ne pouvez pas modifié l'article de quelqu'un d'autre";
  }
  }


  } else {
    $erreur = 'Veuillez remplir tous les champs !';
  }
}
 ?>


<html>
  

 <div class="gradient">
 <head>


    <script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
    <meta charset="utf-8">
    <title>Menu</title>
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
  
  <header class="header_profil">

      <img src="images/Yato 1.png"  height="60px" style="margin-left: 50px; margin-top: 10px;">
      <a href="mailto:yato.network@gmail.com"><img src="images/emaillogo.png" height="30px" style="margin-left: 0px; margin-bottom: 10px;"></a>
            
        <a class="deja3" style="padding: 5px; margin-top: 40px; float: right; margin-right: 25px; margin-left: 20px;" href="profil.php?id=<?= $_SESSION['id'] ?>"><font color="orange">M</font><font color="yellow">on</font> <font color="lightgreen">es</font><font color="cyan">pa</font><font color="yellow">ce</font> <font color="black"><i>!</i></font></a>      
        <a class="deja3" style="float: right; margin-top: 40px; padding: 5px;" href="deconnexion.php">Se déconnecter</a>
          
</header>

    <div class="content_redaction" align="center" style="width: 100%;">
    <form class="formu" method="POST" >
      <br>
      <input class="basic" type="text" placeholder="Titre" name="article_titre" <?php if($mode_edition == 1) { ?> value="<?= $edit_article['titre'] ?>"<?php } ?>>
      <br>
      <textarea name="article_contenu" class="text2" placeholder="Contenu de votre article"><?php if($mode_edition == 1) { ?><?= $edit_article['contenu'] ?><?php } ?></textarea>
      <br><br>
      <input type="submit" name="" value="Publier votre article">
    </form>
  </div>
    <br>
    <?php
    if(isset($erreur))
    {
      echo "<font color='red'>" .$erreur."</font>";
    }
     ?>
  </body>
</font>
</h3>
</a>
</header>
</div>
</html>

<?php
} else {
  header("Location: connexion.php");
}
 ?>
