<?php 
include "bdd.php";


if(isset($_SESSION['pseudo'], $_SESSION['mail'])) {

$pseudo = $_SESSION['pseudo'];
$mail = $_SESSION['mail'];

$id_session = $bdd->query("SELECT id FROM membres WHERE pseudo = '$pseudo'");
$id = $id_session->fetch();
$id = $id['id'];


if(isset($_POST['forminscri'])) {
	  


		    

          $longueur_key = 12;
          $key = "";
          for($i=1;$i<$longueur_key;$i++) {
            $key .= mt_rand(0,9);
          }

            

                     
                        
                        $updatekey = $bdd->prepare('UPDATE membres SET confirmkey = :confirmkey WHERE id = :id');
                        $updatekey->execute(array('confirmkey' => $key, 'id' => $id));
                    $msg = "Un mail de confirmation vous a été envoyé à l'adresse $mail, veuillez le suivre pour activer votre compte. Pensez à vérifier vos indésirables et si vous ne triuvez pas le mail, contactez-nous à ce mail : yato.network@gmail.com";
                      $header="MIME-Version: 1.0\n";
                      $header.='From:"Yato ! Team"<support@pagewebalain.tk>'."\n";
                      $header.='Content-Type:text/html; charset="ISO-8859-1"'."\n";
                      $header.='Content-Transfer-Encoding: 8bit'; 

                      $message='
                      <!DOCTYPE html>
                      <html>
                      <body>
                        <div align="center">
                        <img src="http://pagewebalain.tk/images/banniere.jpg"><br><br>
                        <p>Bonjour, /n/nVotre compte est prêt, il n\'y  plus qu\'a l\'activer pour que vous puissiez y accéder. Pour ce faire apuuyer sur le bouton ci-dessous :</p>
                        <a href="http://pagewebalain.tk/confirme.php?pseudo='.urlencode($pseudo).'&key='.$key.'"><img src="http://www.pagewebalain.tk/images/btn.jpg" width="200px"></a> 
                        <br><br>
                        <p>Nous vous souhaitons de passer d\'agréables moments sur Yato !</p>

                        </div>
                      </body>
                      </html>
                      ';
                      mail($mail, "Confirmation de compte", $message, $header);

   if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name']))
  {
    $taillemax = 2097152;
    $extensionvalide = array('jpg', 'jpeg', 'gif', 'png');
    if($_FILES['avatar']['size'] <= $taillemax)
    {
      $extensionupload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
      if(in_array($extensionupload, $extensionvalide))
      {
        $chemin = "membres/avatar/".$id.".".$extensionupload;
        $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
        if($resultat)
        {
           $updateavatar = $bdd->prepare('UPDATE membres SET avatar = :avatar WHERE id = :id');
                      $updateavatar->execute(array(
                        'avatar' => $id.".".$extensionupload,
                        'id' => $id));
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

  if(isset($_POST['bio']) AND !empty($_POST['bio'])) {
        $bio = htmlspecialchars($_POST['bio']);
        $biolength = strlen($bio);
        if($biolength <= 250) {
        $updatebio = $bdd->prepare('UPDATE membres SET biographie = :biographie WHERE id = :id');
                        $updatebio->execute(array('biographie' => $bio, 'id' => $id));
        } else {
           $msg = "Votre biographie ne doit pas dépasser 250 caractères !";

        }


      }


}
} else {
  header("Location: index.php");
}

 ?>


 <html>
 <head>
 	<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    
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
 	<title>Page Web Alain - Ajouter une photo de profil</title>
 </head>
 <body style="background-color: #eeeeee;">
 	<header class="header_index">

    
     
       <img src="images/Yato 1.png"  height="60px" style="margin-left: 50px; margin-top: 10px;">
       <a href="mailto:yato.network@gmail.com"><img src="images/emaillogo.png" height="30px" style="margin-left: -20px; margin-top: 0px;"></a>
      
    </header>
 	<div class="container" align="center" style="background-color: #FFFFF2; padding-bottom: 500px;">
 		<br>
 		<form method="POST" enctype="multipart/form-data" class="formu">
 			<label style="color: #000040; float: left; margin-left: 230px; font-size: 23px;">Ma description :</label><br><br><textarea style="width: 500px; height: 200px; float: left; margin-left: 50px;" name="bio" class="text basic" placeholder="Ecrivez ici votre mini biographie (250 car. max!)" ></textarea>

          <br><br><br><label style="color: #000040; font-size: 23px;" class="basic2" >Photo de profil :</label><br><br><input type="file" name="avatar" value="" /><br><br><br><br><br><br>

          <input type="submit" name="forminscri" value="S'inscrire !">
 			
 		</form>
          <?php
      if(isset($msg))
      {
        echo "<font color='red'>" .$msg."</font><br>";
      }
       ?>
 	</div>
 </body>
 </html>