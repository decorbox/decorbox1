
<?php
ob_start(); 

include_once 'connect.php';
//include_once 'library.php';


$display_block = "";

//show categories first
if(isset($_GET['lang']) && $_GET['lang']=='LT'){
	$get_cats_sql = "SELECT id, cat_title FROM store_categories WHERE sorting_id !='99999999' AND sorting_id !='88888888' ORDER BY sorting_id";
}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
	$get_cats_sql = "SELECT id, cat_title_EN FROM store_categories WHERE sorting_id !='99999999' AND sorting_id !='88888888' ORDER BY sorting_id";
}else{
$get_cats_sql = "SELECT id, cat_title FROM store_categories WHERE sorting_id !='99999999' AND sorting_id !='88888888' ORDER BY sorting_id";
}
$get_cats_res = mysqli_query($mysqli, $get_cats_sql) or die(mysqli_error($mysqli));



	$display_block.="
	<div class='panel-group' id='accordion' role='tablist' aria-multiselectable='true'>";
	$countID = 0;//used for collapse id
while ($cats = mysqli_fetch_array($get_cats_res)) //display categories
	{
		$cats_id = $cats['id'];
		if(isset($_GET['lang']) && $_GET['lang']=='LT'){
			$cats_title = $cats['cat_title']; 
		}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
			$cats_title = $cats['cat_title_EN']; 
		}else{
			$cats_title = $cats['cat_title']; 
		}
		
	

	//display accordion menu
	$display_block .= "
		<div class=' list-group-margin list-group '>
		    
		    	<label class='panel-title  list-group-title-color ' style='width:100%;' >";
		    	//show active categories manu
		    	if(isset($_GET['cat_id']) && $cats_id == $_GET['cat_id'] && !isset($_GET['subcat_id'])){
		    		$display_block.="<a class='list-group-item list-group-item-edit list-menuitem active'  href='?lang=".$_GET['lang']. "&cat_id=".$cats_id."'><div class='row'><div class='col-md-12 col-lg-12 col-sm-12 col-xs-12'>$cats_title </div></div></a>";	
		    	}else if(isset($_GET['subcat_id'])){ //if subcat is isset remove ACTIVE Class
		    		$display_block.="<a class='list-group-item list-group-item-edit list-menuitem'  href='?lang=".$_GET['lang']."&cat_id=".$cats_id."'><div class='row'><div class='col-md-12 col-lg-12 col-sm-12 col-xs-12'>$cats_title </div></div></a>";
		    	}
		    	else{//not active categories menu AND active submenu
		    		$display_block.="<a class='list-group-item list-group-item-edit list-menuitem'  href='?lang=".$_GET['lang']."&cat_id=".$cats_id."'><div class='row'><div class='col-md-12 col-lg-12 col-sm-12 col-xs-12'>$cats_title </div></div></a>";
		    	}

		    	
	$display_block.=" </label>
				
			";
			//collapse subcategories when is isset
			if (isset($_GET['cat_id']) && $cats_id == $_GET['cat_id']) {
	                $display_block.="  <div id='".$cats_id."' class='panel-collapse collapse in ' > ";
			} else {//no collapse
					$display_block.=" <div id='".$cats_id."' class='panel-collapse collapse' > ";
			}
					//show subcategories title
					
       				$subcat_sql="SELECT * FROM store_subcategories where cat_id='".$cats_id."'";
       				$subcat_res= mysqli_query($mysqli, $subcat_sql);
       				
       				//show subcats
       				while($subcat = mysqli_fetch_array($subcat_res)){
       					
       					$sub_id = $subcat['subcat_id'];
       					if(isset($_GET['lang']) && $_GET['lang']=='LT'){
							$sub_title = $subcat['subcat_title']; 
						}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
							$sub_title = $subcat['subcat_title_EN']; 
						}else{
							$sub_title = $subcat['subcat_title']; 
						}
       					
   
       					$display_block.="<div class='float-left' >
					    	<label class='submenuBody float-right' >";
					    	//display subcategories
					    	//active subcategory
						if(isset($_GET['subcat_id']) && $sub_id == $_GET['subcat_id']){
					    	$display_block.="<a class='list-group-item list-group-item-edit list-subitem active'  href='?lang=".$_GET['lang']."&cat_id=".$cats_id."&subcat_id=".$sub_id."' ><div class='row'> <div class='col-md-10 col-lg-10 col-sm-10 col-xs-10'> $sub_title </div> </div></a>";
						}else{//not active subcategory
							$display_block.="<a class='list-group-item list-group-item-edit list-subitem'  href='?lang=".$_GET['lang']."&cat_id=".$cats_id."&subcat_id=".$sub_id."' ><div class='row'> <div class='col-md-10 col-lg-10 col-sm-10 col-xs-10'> $sub_title </div> </div></a>";
						}

					$display_block.="</label>
							</div>";	
	       				}
    $display_block.="
    			
     		</div>
     	</div>"; 
	}
//rent category 
	$display_block.="
		<div class=' list-group-margin list-group '>
		    
		    	<label class='panel-title  list-group-title-color ' style='width:100%;' >";
			if(isset($_GET['rent']) ){
		    		$display_block.="<a class='list-group-item list-group-item-edit list-menuitem active'  href='?lang=".$_GET['lang']. "&rent=true'><div class='row'><div class='col-md-12 col-lg-12 col-sm-12 col-xs-12'>$txtcategory_rent </div></div></a>";	
		    	}
		    	else{//not active categories menu 
		    		$display_block.="<a class='list-group-item list-group-item-edit list-menuitem'  href='?lang=".$_GET['lang']."&rent=true'><div class='row'><div class='col-md-12 col-lg-12 col-sm-12 col-xs-12'>$txtcategory_rent </div></div></a>";
		    	}

$display_block.="
			</label>
		</div>

	</div>";	 

//free results
mysqli_free_result($get_cats_res);
//close connection to MySQL
mysqli_close($mysqli);
	
?>
<!DOCTYPE html>
<html>
<body>
	<div class="row">
		<div class="col-md-3 ">
			<div class=" col-padding categ-width border-color">
				<?php  
					echo $display_block;	
				?>	
			</div>
			<div class="hidden-sm hidden-xs">
			<?php include 'specialOffersItemSlideWidget.php'; ?>
			</div>
		</div> 

		<div class="  col-md-6-editBLOGAS col-md-6 col-sm-9 "> 
			<?php  
				include_once 'showCategoriesItems.php'; 

			?>
		</div>

		<div class="col-md-3 col-lg-3 hidden-sm hidden-xs right-bar-edit border-color">
			<?php include 'login.php';  
				include 'showPriceWidget.php'; 
				include_once 'contactsWidget.php';
				include_once 'deliveryWidget.php';
				include_once 'facebookWidget.php';
			?>
		</div>

	</div>
	
</body>
</html>