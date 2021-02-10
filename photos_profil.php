
<?php include "bdd.php";
if(isset($_SESSION['id'])) {
 ?>


<html>
<head>
	<meta charset="UTF-8">
	<title></title>
	
	
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
	<?php $userinfo = $_SESSION['userinfo']; 
	$img1 = $userinfo['img1'];
	$img2 = $userinfo['img2'];
	$img3 = $userinfo['img3'];
	$img4 = $userinfo['img4'];
?>

<div class="slider2">
      
   <?php  if($img1 != 0) {

  $dimensions1 = getimagesize("membres/diapo/$img1");
?>

      <a href="membres/diapo/<?php echo $userinfo['img1'] ?>" target="_blank">
<div class="special" style="
width: 49%; height: 255px;
background-image: url(membres/diapo/<?php echo $userinfo['img1'] ?>);
background-position: center;
background-size:<?php if($dimensions1[0] >= $dimensions1[1]) { ?> auto 100% <?php } else { ?> 100% auto <?php }?>;
background-repeat: no-repeat;
display: inline-block;
float: left;" 

></div>
      

      </a><?php } 

      if($img2 != 0) {
      
        $dimensions2 = getimagesize("membres/diapo/$img2");


      ?><!--
      --><a href="membres/diapo/<?php echo $userinfo['img2'] ?>" target="_blank">
<div class="special" style="
width: 49%; height: 255px;
background-image: url(membres/diapo/<?php echo $userinfo['img2'] ?>);
background-position: center;
background-size:<?php if($dimensions2[0] >= $dimensions2[1]) { ?> auto 100% <?php } else { ?> 100% auto <?php }?>;
background-repeat: no-repeat;
display: inline-block;
float: right;" 

></div>
        
      </a><?php } 
      if($img3 != 0) {

       $dimensions3 = getimagesize("membres/diapo/$img3");



      ?><!--
      --><a href="membres/diapo/<?php echo $userinfo['img3'] ?>" target="_blank">
<div class="special" style="
width: 49%; height: 255px;
background-image: url(membres/diapo/<?php echo $userinfo['img3'] ?>);
background-position: center;
background-size:<?php if($dimensions3[0] >= $dimensions3[1]) { ?> auto 100% <?php } else { ?> 100% auto <?php }?>;
background-repeat: no-repeat;
display: inline-block;
float: left;" 

></div>
        

      </a><?php } 
      if($img4 != 0) {
        $dimensions4 = getimagesize("membres/diapo/$img4");

      ?><!--
      --><a href="membres/diapo/<?php echo $userinfo['img4'] ?>" target="_blank">
<div class="special" style="
width: 49%; height: 255px;
background-image: url(membres/diapo/<?php echo $userinfo['img4'] ?>);
background-position: center;
background-size: <?php if($dimensions4[0] >= $dimensions4[1]) { ?> auto 100% <?php } else { ?> 100% auto <?php }?>;
background-repeat: no-repeat;
display: inline-block;
float: right;" 

></div>
        
      </a><?php } ?>
    </div>
		

	<br>

<form class="formu" enctype="multipart/form-data" method="POST">
		
	<label style="font-size: 15px;">Photo de diapo n°1 : </label><input type="file" name="img1"/>
	<label style="font-size: 15px;">Photo de diapo n°2 : </label><input type="file" name="img2">
	<label style="font-size: 15px;">Photo de diapo n°3 : </label><input type="file" name="img3">
	<label style="font-size: 15px;">Photo de diapo n°4 : </label><input type="file" name="img4">
	<input type="submit" value="Envoyer" name="">
	</form>
<?php if(isset($msg)) { echo "<font color='red'>" .$msg."</font>"; } ?>
</body>
</html>
<?php } ?>