<?php include "bdd.php";

$id = $_SESSION['id'];

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<title></title>
</head>
<body>
	<h3>Mes textes : </h3>

       <?php  $articles = $bdd->query("SELECT * FROM articles WHERE id_ecrivain = '$id' ORDER BY date_time_publication DESC"); ?>
        <ul class="liste_article">
          <?php while($a = $articles->fetch()) { 
            
            ?>
            <li><a class="deja" href="article.php?id=<?= $a['id'] ?>"><?= $a['titre']?></a> |
              <a class="deja" href="redaction.php?id=<?= $a['id'] ?>">Modifier</a> |
              <a class="deja8" href="suppr_article.php?id=<?= $a['id'] ?>">Supprimer</a></li>
              
              
            <?php } ?>
        </ul>
</body>
</html>