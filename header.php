
<?php
include 'library.php';
include 'connect.php';
?>
<script type="text/javascript">
	$(document).ready(function(){
  $('.slider1').bxSlider({
    slideWidth: 500,
    //autoHover: true,
    minSlides: 3,
    mode: 'horizontal',
    maxSlides: 3,
    slideMargin: 1,
    speed: 4000,
    pause: 0,
    //Speed: 88000,
     
    //ticker: true,
    

	auto: true
	//captions:true
    
  });
});
//https://github.com/stevenwanderski/bxslider-4
</script>
<?php

$display_block1="";
$display_block1.="
<div class='row '>
		<div class=' pull-right'>
		<form method='GET' >
			<button  class='btn btn-primary' name='lang' value='LT'>LT</button> 
			<button class='btn btn-primary' name='lang' value='EN'>EN</button>
		</form>
		</div>
	</div>";
$display_block1.="
<div class='row header-edit'>
	<div class='col-md-4-edit pull-left'>
		<a href = 'index.php?lang=".$_GET['lang']."'>
			<img class='img-responsiv' width='100%' height='200px' src='images/decorbox/logo.png'>
		</a>
	</div>

	<div class='col-md-8-edit '>
		<div class='slider1'>";
			$slide_photo = "SELECT * FROM slides_gallery";
			$slide_photo_res = mysqli_query($mysqli, $slide_photo);
			while($photo = mysqli_fetch_array($slide_photo_res)){
				$img = $photo['slide_image'];
				//neta title EN
			    $title = $photo['image_title'];
			   
																//height tai aukstis skaidriu
				$display_block1.="<div class='slide' ><img width='350px' height='200px'  ATL='$title' title='$title' src='$img'></div>";
			}
		
		      
	$display_block1.="	      
		</div>
	</div>
			
</div>";


//echo "3 prekes per eilute .KONTAKTAI ir  Turite klausimų? +370 627 00354. ruzava su ryskia ruda spava (teksto spalva, linijos 3F1515
//F888BB),pagrindiniam lange specialus pasiulymas butu  prekes su nuolaida. ant pagrinidio dar galerijos pora fotkiu, kai jas paspaudi rodo kategorijos arba subcat galerija. priminimas: kai galutinai bus paruosta duomenu baze resetinti ID laukus nes gali dubliuotis jei visus duomenis is ten istrynsiu. per kiek dienu pristatymas? ideti nuotrauku galerija paspaudus ant kategorijos butu mygtukas, headeryje skaidres, po krepseliu idet widgetu,  kai vartotojas padaro uzsakyma turi nusiusti i el pasta informacija, kai adminas patvirtina uzsakyma i el pasta turi nusiusti vartotojui kad uzsakymas patvirtintas, ";
echo $display_block1;
