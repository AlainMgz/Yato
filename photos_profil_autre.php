<?php include "bdd.php"; ?>

<html>
<head>
	<meta charset="UTF-8">
	<title></title>
	
	
	<link rel="stylesheet" href="style.css" />
</head>
<body>
	<?php 
	if(isset($_SESSION['id'], $_SESSION['info_autre'])) {

	$info_autre = $_SESSION['info_autre']; 
	$img1 = $info_autre['img1'];
	$img2 = $info_autre['img2'];
	$img3 = $info_autre['img3'];
	$img4 = $info_autre['img4'];
?>
<div class="slider2">
      
   <?php  if($img1 != 0) {

  $dimensions1 = getimagesize("membres/diapo/$img1");
?>

      <a href="membres/diapo/<?php echo $info_autre['img1'] ?>" target="_blank">
<div class="special" style="
width: 49%; height: 255px;
background-image: url(membres/diapo/<?php echo $info_autre['img1'] ?>);
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
      --><a href="membres/diapo/<?php echo $info_autre['img2'] ?>" target="_blank">
<div class="special" style="
width: 49%; height: 255px;
background-image: url(membres/diapo/<?php echo $info_autre['img2'] ?>);
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
      --><a href="membres/diapo/<?php echo $info_autre['img3'] ?>" target="_blank">
<div class="special" style="
width: 49%; height: 255px;
background-image: url(membres/diapo/<?php echo $info_autre['img3'] ?>);
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
      --><a href="membres/diapo/<?php echo $info_autre['img4'] ?>" target="_blank">
<div class="special" style="
width: 49%; height: 255px;
background-image: url(membres/diapo/<?php echo $info_autre['img4'] ?>);
background-position: center;
background-size: <?php if($dimensions4[0] >= $dimensions4[1]) { ?> auto 100% <?php } else { ?> 100% auto <?php }?>;
background-repeat: no-repeat;
display: inline-block;
float: right;" 

></div>
        
      </a><?php } ?>
    </div>
		


</body>
</html>
<?php } else {
	header("Location: index.php");
} ?>
