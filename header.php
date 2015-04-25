

<?php

include 'library.php';
include 'connect.php';
?>
<script>
    jQuery(document).ready(function ($) {

        var _SlideshowTransitions = [{
		$Duration:600,
		x:1,
		y:-1,
		$Delay:50,
		$Cols:8,$Rows:4,
		$SlideOut:true,
		$ChessMode:{$Column:3,$Row:12},
		$Easing:{$Left:$JssorEasing$.$EaseInCubic,$Top:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2 }];
        var options = {
            $DragOrientation: 3,
            $AutoPlay: true,
            $SlideDuration: 1500,
            $AutoPlayInterval: 4500,
            $SlideshowOptions: {                                //Options which specifies enable slideshow or not
                $Class: $JssorSlideshowRunner$,                 //Class to create instance of slideshow
                $Transitions: _SlideshowTransitions,            //Transitions to play slide, see jssor slideshow transition builder
                $TransitionsOrder: 1,                           //The way to choose transition to play slide, 1 Sequence, 0 Random
                $ShowLink: 2,                                   //0 After Slideshow, 2 Always
                $ContentMode: false                             //Whether to trait content as slide, otherwise trait an image as slide
            }
        };
        var jssor_slider1 = new $JssorSlider$('slider1', options);
    });
</script>
<?php
//http://www.jssor.com/development/slider-with-loading-screen-jquery.html
//http://www.jssor.com/development/tool-slideshow-transition-viewer.html

$display_block1="";
$display_block1.="
<div class='row '>
        <div class=' pull-right'>
        <form method='GET' >
            <button class='btn btn-primary' name='lang' value='LT'>LT</button> 
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
        <div id='slider1' style='position: relative; top: 0px; left: 0px; width: 760px; height: 200px;'>
            <div u='slides' style='cursor: move; position: absolute; overflow: hidden; left: 0px; top: 0px; width: 760px; height: 200px;'>";
            
            $slide_photo = "SELECT * FROM slides_gallery";
            $slide_photo_res = mysqli_query($mysqli, $slide_photo);
            while($photo = mysqli_fetch_array($slide_photo_res)){
                $img = $photo['slide_image'];
                //neta title EN
                $title = $photo['image_title'];
               
                                                                //height tai aukstis skaidriu http://deelay.me/900/http://www.decorbox.lt/
                $display_block1.="<div><img u='image' width='100%' height='200px' src='$img'></div>";
                
            }
        
              
    $display_block1.="        
            </div>
        </div>
    </div>
            
</div>";


echo $display_block1;
