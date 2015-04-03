<?php

if(isset($_GET['lang']) && $_GET['lang']=='LT'){
        include 'content_LT.php';
    }else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
        include 'content_EN.php';
    }else{
        include 'content_LT.php';
    }

$display_block = "";
$display_block .= "<h1 class='text-center'>$txtmain_page</h1>";
$display_block .="
<div class='row'>
	
		";
			$get_ideas_gallery="SELECT * FROM ideas_gallery";
			$get_ideas_gallery_res = mysqli_query($mysqli, $get_ideas_gallery) or die(mysqli_error($mysqli));

			while($inf = mysqli_fetch_array($get_ideas_gallery_res)){
				$ideas_image = $inf['ideas_image'];
				$ideas_cat_id = $inf['cat_id'];
				$ideas_subcat_id = $inf['subcat_id'];

				if(isset($_GET['lang']) && $_GET['lang']=='LT'){
			        $ideas_title = $inf['title'];
					$ideas_description = $inf['description'];
			    }else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
			        $ideas_title = $inf['title_EN'];
					$ideas_description = $inf['description_EN'];
			    }else{
			        $ideas_title = $inf['title'];
					$ideas_description = $inf['description'];
			    }
				
				//jei nera subcategoriju daryt nuoroda i kategorijos galerija
				if($ideas_subcat_id==NULL){
					$display_block .="
					<a href='gallery.php?lang=".$_GET['lang']."&cat_id=".$ideas_cat_id."'>
						<div class=' border-color ideas-border margin-bottom15'>
							<div class='col-md-6-edit'>
								<img width='100%' class='mainContentImgRadius' height='150px' src='$ideas_image'></img>
							</div>

							<div class=' overflowHidden panel panel-success ideas-edit'>
								<div class=' text-center  panel-heading'>
									
									<label class='panel-title'>$ideas_title</label>
									
								</div>
								<div class=' panel-body panel-body-edit'>	
									<p>$ideas_description</p>
								</div>
							</div>
						</div>
					</a>";
				}else{
					$display_block .="
					<a href='gallery.php?lang=".$_GET['lang']."&cat_id=".$ideas_cat_id."&subcat_id=".$ideas_subcat_id."'>
						<div class=' border-color ideas-border margin-bottom15'>
							<div class='col-md-6-edit '>
								<img width='100%' class='mainContentImgRadius' height='150px' src='$ideas_image'></img>
							</div>

							<div class=' overflowHidden panel panel-success ideas-edit'>
								<div class=' text-center  panel-heading'>
									
									<label class='panel-title'>$ideas_title</label>
									
								</div>
								<div class=' panel-body panel-body-edit'>	
									<p>$ideas_description</p>
								</div>
							</div>
						</div>
					</a>";
					}
				}//end of while
				
				
	$display_block.="			
		
		
	
</div>";

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Decorbox</title>

	</head>
	<body>

	<div class="row">
		<div class="col-md-12 border-color">
				<?php echo $display_block; ?>


			
		</div>	
	</div>


	</body>

</html>