<?php include "bdd.php";

$id = $_SESSION['id'];

$info_autre = $_SESSION['info_autre'];

$id_3 = $_SESSION['id_3'];
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 	<link rel="stylesheet" type="text/css" href="style.css">
 </head>
 <body>
 	     <h3>Textes de <?= $info_autre['pseudo'] ?> : </h3>

    <?php  $articles = $bdd->query("SELECT * FROM articles WHERE id_ecrivain = '$id_3' ORDER BY date_time_publication DESC"); ?>
     <ul>
       <?php while($art = $articles->fetch()) { 
      
        ?>
         <li><a class="deja" href="article.php?id=<?= $art['id'] ?>"><?= $art['titre']?></a></li>
          
         <?php } ?>
     </ul>
 </body>
 </html>