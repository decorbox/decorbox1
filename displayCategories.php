<?php
//geriause knyga 22 skurius
include 'connect.php';

$display_block = "<h1>My Categories</h1>
<p>Select a category to see its items.</p>";
//show categories first
$get_cats_sql = "SELECT id, cat_title FROM store_categories ORDER BY cat_title";
$get_cats_res = mysqli_query($mysqli, $get_cats_sql) or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_cats_res) < 1) {
$display_block = "<p><em>Sorry, no categories to browse.</em></p>";
} else 
{
while ($cats = mysqli_fetch_array($get_cats_res)) //display categories
	{
	$cats_id = $cats['id'];
	$cats_title = $cats['cat_title']; 
	$display_block .= "<p><strong><a href=\"".$_SERVER['PHP_SELF']. "?cat_id=".$cats_id."\">".$cats_title."</a></strong><br/></p>"; 

	}

}
//free results
mysqli_free_result($get_cats_res);
//close connection to MySQL
mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html>
<head>
	<php include 'library.php';?>
	
<title>My Categories</title>
</head>
<body>
<!--<?php echo $display_block; ?> -->
	<div class="row">
		<div class="col-md-3 border-color">
			<?php  
				echo $display_block;
				 ?>
		</div>
		<div class="col-md-6 border-color">
			<?php  
					
				
					include 'showCategoriesItems.php';

					//include 'mainContent.php';// kad roduty main is pradziu
					
					
					
			?>
		</div>
		<div class="col-md-3 border-color">
			<?php include 'login.php';  
				include 'showPriceWidget.php';
			?>
		</div>

	</div>
</div>	
</body>
</html>