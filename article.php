<?php
include "bdd.php";

if(isset($_SESSION['id'])) {


if(isset($_GET['id']) AND !empty($_GET['id'])) {
  $get_id = htmlspecialchars($_GET['id']);

  $article = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
  $article->execute(array($get_id));

  if($article->rowCount() == 1) {
    $article = $article->fetch();
    $id = $article['id'];
    $titre = $article['titre'];
    $contenu = nl2br($article['contenu']);

    $likes = $bdd->prepare('SELECT id FROM likes WHERE id_article = ?');
    $likes->execute(array($id));
    $likes = $likes->rowCount();


    $dislikes = $bdd->prepare('SELECT id FROM dislikes WHERE id_article = ?');
    $dislikes->execute(array($id));
    $dislikes = $dislikes->rowCount();

  } else{
    die("Cet article n'existe pas");
  }

} else {
    die('Erreur');
  }

?>


 <!DOCTYPE html>
 <html>
 <div class="gradient">
 <head>
    <script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
    <meta charset="utf-8">
    <title>Article "<?= $titre ?>"</title>
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
     
      <a class="deja2" href="profil.php?id=<?= $_SESSION['id'] ?>"><h3><font color="orange">M</font><font color="yellow">on</font> <font color="lightgreen">es</font><font color="cyan">pa</font><font color="yellow">ce</font> <font color="black"><i>!</i></font></h3></a> <a class="deja2" href="deconnexion.php"><h3>Se déconnecter</h3></a>
 <img src="images/Yato 1.png"  height="60px" style="margin-left: 50px; margin-top: 10px;">
 <a href="mailto:yato.network@gmail.com"><img src="images/emaillogo.png" height="30px" style="margin-left: 0px; margin-bottom: 10px;"></a>
    </header>
    <div class="content_article" align="left">
    <h1 style="margin-left: 32%;"><?= $titre ?></h1>
    <p style="margin-right: 20%; margin-left: 30%;"><?= $contenu ?></p>

 <?php   $check_like = $bdd->prepare('SELECT id FROM likes WHERE id_article = ? AND id_membre = ?');
      $check_like->execute(array($get_id,$_SESSION['id']));
if($check_like->rowCount() == 1) { ?>

    <a class="deja" href="action.php?t=1&id=<?= $get_id ?>" style="margin-left: 32%;">Je n'aime plus</a> (<?= $likes ?>) |
    <a class="deja" href="action.php?t=2&id=<?= $get_id ?>" >Je n'aime pas</a> (<?= $dislikes ?>)
    <?php } else { ?>
      <a class="deja" href="action.php?t=1&id=<?= $get_id ?>" style="margin-left: 32%;">J'aime</a> (<?= $likes ?>) |
    <a class="deja" href="action.php?t=2&id=<?= $get_id ?>" >Je n'aime pas</a> (<?= $dislikes ?>)
  <?php  } ?>

</div>
</body>
</div>
 </html>


<?php }
else {
  echo "Nul";
//  header("Location: connexion.php");
} ?>
