
<?php
ob_start(); //http://stackoverflow.com/questions/9707693/warning-cannot-modify-header-information-headers-already-sent-by-error
//geriause knyga 22 skurius
include_once 'connect.php';
include_once 'library.php';

$display_block = "<div class='row'> <div class='col-md-12 col-lg-12 col-sm-12 col-xs-12'>
	<h1 class='text-center'>Kategorijos</h1> </div></div>";
//show categories first
$get_cats_sql = "SELECT id, cat_title FROM store_categories ORDER BY sorting_id";
$get_cats_res = mysqli_query($mysqli, $get_cats_sql) or die(mysqli_error($mysqli));



	$display_block.="
	<div class='panel-group' id='accordion' role='tablist' aria-multiselectable='true'>";
	$countID = 0;//used for collapse id
while ($cats = mysqli_fetch_array($get_cats_res)) //display categories
	{
	$cats_id = $cats['id'];
	$cats_title = $cats['cat_title']; 

	//get total items
	$get_total_num_sql="SELECT COUNT(*) AS total FROM store_items WHERE cat_id = '".$cats_id."'";
	$query = mysqli_query($mysqli, $get_total_num_sql) or die(mysql_error($mysqli));
	$result = mysqli_fetch_array($query);
	$total = $result['total'];
	$total_items = ceil($total); 
	

	//display accordion menu
	$display_block .= "
		<div class=' list-group-margin list-group '>
		    <div class='text-center ' >
		    	<label class='panel-title list-group-title-color menuBody' style='width:100%;' >";
		    	//show active categories manu
		    	if(isset($_GET['cat_id']) && $cats_id == $_GET['cat_id'] && !isset($_GET['subcat_id'])){
		    		$display_block.="<a class='list-group-item list-menuitem active'  href='".$_SERVER['PHP_SELF']. "?cat_id=".$cats_id."'><div class='row'><div class='col-md-10 col-lg-10 col-sm-10 col-xs-10'>$cats_title </div><div class='col-md-2 col-lg-2 col-sm-2 col-xs-2 '> <span class='badge'>$total_items</span></div></div></a>";	
		    	}else if(isset($_GET['subcat_id'])){ //if subcat is isset remove ACTIVE Class
		    		$display_block.="<a class='list-group-item  list-menuitem'  href='".$_SERVER['PHP_SELF']. "?cat_id=".$cats_id."'><div class='row'><div class='col-md-10 col-lg-10 col-sm-10 col-xs-10'>$cats_title </div><div class='col-md-2 col-lg-2 col-sm-2 col-xs-2 '> <span class='badge'>$total_items</span></div></div></a>";
		    	}
		    	else{//not active categories menu AND active submenu
		    		$display_block.="<a class='list-group-item  list-menuitem'  href='".$_SERVER['PHP_SELF']. "?cat_id=".$cats_id."'><div class='row'><div class='col-md-10 col-lg-10 col-sm-10 col-xs-10'>$cats_title </div><div class='col-md-2 col-lg-2 col-sm-2 col-xs-2 '> <span class='badge'>$total_items</span></div></div></a>";
		    	}

		    	
	$display_block.=" </label>
				
			</div>";
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
       					$sub_title = $subcat['subcat_title'];
       					
       					//get total sub items
						$get_total_num_sql="SELECT COUNT(*) AS totalSub FROM store_items WHERE cat_id = '".$cats_id."' AND subcat_id='".$sub_id."'";
						$query = mysqli_query($mysqli, $get_total_num_sql) or die(mysql_error($mysqli));
						$result = mysqli_fetch_array($query);
						$total = $result['totalSub'];
						$total_sub_items = ceil($total);
						


       					$display_block.="<div class='text-center ' >
					    	<label class='submenuBody float-right' >";
					    	//display subcategories
					    	//active subcategory
						if(isset($_GET['subcat_id']) && $sub_id == $_GET['subcat_id']){
					    	$display_block.="<a class='list-group-item list-subitem active'  href='".$_SERVER['PHP_SELF']."?cat_id=".$cats_id."&subcat_id=".$sub_id."' ><div class='row'> <div class='col-md-10 col-lg-10 col-sm-10 col-xs-10'> $sub_title </div> <div class='col-md-2 col-lg-2 col-sm-2 col-xs-2'> <span class='badge'>$total_sub_items </span></div></div></a>";
						}else{//not active subcategory
							$display_block.="<a class='list-group-item list-subitem'  href='".$_SERVER['PHP_SELF']."?cat_id=".$cats_id."&subcat_id=".$sub_id."' ><div class='row'> <div class='col-md-10 col-lg-10 col-sm-10 col-xs-10'> $sub_title </div> <div class='col-md-2 col-lg-2 col-sm-2 col-xs-2'> <span class='badge'>$total_sub_items </span></div></div></a>";
						}

					$display_block.="</label>
							</div>";	
	       				}
    $display_block.="
    			
     		</div>
     	</div>"; 
	}
$display_block.="
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
		<div class="col-md-3 categ-width border-color">
			<?php  
				echo $display_block;
			?>
		</div>
		<div class="col-md-6 border-color">
			<?php  
				include_once 'showCategoriesItems.php';
			?>
		</div>
		<div class="col-md-3 border-color">
			<?php include_once 'login.php';  
				include_once 'showPriceWidget.php';
				include_once 'facebookWidget.php';
			?>
		</div>

	</div>
	
</body>
</html>