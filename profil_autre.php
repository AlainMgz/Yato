<?php 
include "bdd.php";

$id_3 =$_SESSION['id_3'];


$info_autre = $_SESSION['info_autre'];
 ?>
<html>
<head>
	<title></title>
	 <script type="text/javascript">
     $(function() {
      $(".btn6").click(function() {

      	var id3 = $(this).attr('followedid');
      	
      		$.ajax({
      			url: 'follow.php',
      			data: { followedid: id3 },
      			type: "GET"
      		})
      		.done(function (data, textStatus, jqxhr) {
      			
      			
      					$('.content_profil').load('profil_autre.php').fadeIn('slow');
      				
      		})
      		.fail(function (jqxhr) {
      			
      			alert('Erreur');
      		});
      	
      });
     });
    </script>
</head>
<body>

<div>       
<div class="banniere">      
        
   
 
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th width="15%" align="center" valign="middle" scope="col"><?php 
        $avatar = $info_autre['avatar'];
        $dimensions = getimagesize("membres/avatar/$avatar");


         ?>
        <?php if(!empty($info_autre['avatar'])) { ?>
        <div class="photo_profil" style="width: 90px; 
          height: 90px;
          overflow: hidden; 

float: left;
background-image: url(membres/avatar/<?php echo $info_autre['avatar'] ?>);
background-position: center;
background-size: <?php if($dimensions[0] >= $dimensions[1]) { ?> auto 90px <?php } else { ?> 90px auto <?php }?>;
background-repeat: no-repeat;
z-index: 2;
border-radius: 15px;
    "></div>
        <?php } ?>
   	  </th>
    <td width="85%" rowspan="2" valign="top" scope="col">
      <div class="bio_court"><?php echo $info_autre['biographie']; ?></div></td>
  </tr>
 
 <tr>
    <td align="center" valign="middle">
     <div class="pseudo">
      <?php echo $info_autre['pseudo']; ?>
     </div>
    </td>
  </tr>

  <tr>
    <td colspan="2" align="center" valign="bottom">... </td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="bottom"><div class="nav_profil btn11">Textes 
      <?= $info_autre['pseudo'] ?>
    </div>
    <div class="nav_profil btn12">Photos
      <?= $info_autre['pseudo'] ?>
    </div></td>
    </tr>
  </table>

   
<script type="text/javascript">
      $('.btn11').click(function() {
        $('.profil').load('articles_autre_liste.php').hide().fadeIn('slow');
         
        
      });
</script>
          
<script type="text/javascript">
      $('.btn12').click(function() {
        $('.profil').load('photos_profil_autre.php').hide().fadeIn('slow');
         
        
      });
</script>
 
    </div>
    <div class="profil" style="padding-bottom: 0px;">
  
  <?php   $info_autre = $_SESSION['info_autre']; 
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
       
      </div>
  </div>
      

     <script type="text/javascript">
      $('.btn5').click(function() {
        $('.content_profil').load('mon_profil.php').hide().fadeIn('slow');
         
        
      });
    </script>
    
</body>
</html>