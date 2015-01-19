
<?php
session_start();

include 'connect.php';
$safe_cat_id = mysqli_real_escape_string($mysqli, $_GET['cat_id']); //gaunu paspaustos categorijos id 
//$safe_cats_id = $_SESSION['cat_id'];
$get_cat_title_sql = "SELECT cat_title FROM store_categories WHERE id='".$safe_cat_id."'";
$get_cat_title_res = mysqli_query($mysqli, $get_cat_title_sql) or die(mysqli_error($mysqli)); 


//get category name
while ($title = mysqli_fetch_array($get_cat_title_res)){
	$cat_title = $title['cat_title'];	
	}

//get items
$get_items_sql = "SELECT id, item_title, item_price, item_image FROM store_items WHERE cat_id = '".$safe_cat_id."' ORDER BY item_title";
$get_items_res = mysqli_query($mysqli, $get_items_sql) or die(mysqli_error($mysqli));


$display_block = "<h1>$cat_title</h1>";
//display items grid
while ($items = mysqli_fetch_array($get_items_res)) 
	{
	$item_id = $items['id'];
	$item_title = stripslashes($items['item_title']);
	$item_price = $items['item_price'];
	$item_image = $items['item_image'];

	$display_block .= 
	"<div class='col-md-5  margin-top border-color'> 
	<a href=\"showitem.php?item_id=".$item_id."\">" .$item_title."</a><br>
	<img src=".$item_image." width='100px'></img>
	\$".$item_price." <br>

	<form method='post' action='addtocart.php'>
	<p><label for=\"sel_item_qty\">Select Quantity:</label>
	<select id=\"sel_item_qty\" name=\"sel_item_qty\">";
		        		
	for($i=1; $i<20; $i++){
	 	$display_block .= "<option value=\"".$i."\">".$i."</option><br>";
	 	} 
			        	
$display_block .= <<<END_OF_TEXT
</select></p>
<input type='hidden' name='sel_item_id' value="$item_id" />
<button type='submit' name='submit' value='send'> Add to Cart</button>
</form>
</div>

END_OF_TEXT;

}//end mysql fetch array				

mysqli_free_result($get_items_res);

?>
<!DOCTYPE HTML>
<html>
	<head>
	<?php include 'library.php';?>
	</head>
	<body>
	<?php echo $display_block?>

	</body>
</html>