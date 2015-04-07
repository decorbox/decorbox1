<?php
include 'connect.php';
include 'library.php';

if(isset($_GET['lang']) && $_GET['lang']=='LT'){
        include 'content_LT.php';
    }else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
        include 'content_EN.php';
    }else{
        include 'content_LT.php';
    }

$display_block ="";
$display_block.="
<!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
<div id='blueimp-gallery' class='blueimp-gallery ' data-use-bootstrap-modal='false'>
    <!-- The container for the modal slides -->
    <div class='slides'></div>
    <!-- Controls for the borderless lightbox -->
    <h3 class='title'></h3>
    <a class='prev'>‹</a>
    <a class='next'>›</a>
    <a class='close'>×</a>
    <a class='play-pause'></a>
    <ol class='indicator'></ol>
    <!-- The modal dialog, which will be used to wrap the lightbox content -->
    <div class='modal fade'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' aria-hidden='true'>&times;</button>
                    <h4 class='modal-title'></h4>
                </div>
                <div class='modal-body next'></div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-default pull-left prev'>
                        <i class='glyphicon glyphicon-chevron-left'></i>
                        Previous
                    </button>
                    <button type='button' class='btn btn-primary next'>
                        Next
                        <i class='glyphicon glyphicon-chevron-right'></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
";


$display_block.="<div class='container'>
<div class='row  text-center' id='links'>
    <div class='col-lg-12 ' >
        <h1 class='page-header'>$txtgallery</h1>
    </div>";
//rodo subkategorjos nuotraukas
if(isset($_GET['cat_id']) && isset($_GET['subcat_id'])){
    $show_photo="SELECT * FROM category_gallery WHERE cat_id='".$_GET['cat_id']."' AND subcat_id='".$_GET['subcat_id']."' ORDER BY id DESC";
    $show_photo_res=mysqli_query($mysqli, $show_photo);

    if(mysqli_num_rows($show_photo_res)>1){
        while($photo = mysqli_fetch_array($show_photo_res)){
            $img = $photo['category_image'];
            $title = $photo['image_title'];//nereik anglu
            
           
            $display_block.="
            <div class='col-md-3 col-sm-3 img-responsive galleryImgSize '>
                <a href='$img'  title='".$title."' data-gallery>
                    <img src='$img' class='galleryImgSize' alt='".$title."'>
                </a>
            </div>";
            }
        }else{
            $display_block.="<h1 class='text-center'>$txtno_gallery_photo</h1><br>
            <a href='index.php?lang=".$_GET['lang']."'>$txtback_to_mainpage</a>";
        }
   $display_block.="     
    </div>";
 //rodo kategorijos nuotraukas
}else if(isset($_GET['cat_id']) && !isset($_GET['subcat_id'])){
    $show_photo="SELECT * FROM category_gallery WHERE cat_id='".$_GET['cat_id']."'";
    $show_photo_res=mysqli_query($mysqli, $show_photo);
        
    if(mysqli_num_rows($show_photo_res)>1){
        while($photo = mysqli_fetch_array($show_photo_res)){
            $img = $photo['category_image'];
            if(isset($_GET['lang']) && $_GET['lang']=='LT'){
                $title = $photo['image_title'];
            }else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
                $title = $photo['image_title_EN'];
            }else{
                $title = $photo['image_title'];
            }
            
            $display_block.="
            <div class='col-md-3 col-sm-3 img-responsive galleryImgSize '>
                <a href='$img'  title='".$title."' data-gallery>
                    <img src='$img' class='galleryImgSize' alt='".$title."'>
                </a>
            </div>";
            }
        }else{
            $display_block.="<h1 class='text-center'>$txtno_gallery_photo</h1><br>
            <a href='index.php?lang=".$_GET['lang']."'>$txtback_to_mainpage</a>";
        }
   $display_block.="     
    </div></div>";
}
echo "<div class='container'>";
 //include_once 'header.php'; 
 include_once 'navbar.php';
 echo "</div>";
echo $display_block;
?>