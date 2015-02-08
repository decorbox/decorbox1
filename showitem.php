<?php
session_start();
 // gera knyga 23 skyrius
 //connected to displayCategories
include 'connect.php';
$display_block = "<h1>My Store - Item Detail</h1>";
//create safe values for use
$safe_item_id = mysqli_real_escape_string($mysqli, $_GET['item_id']);
 //validate item
$get_item_sql = "SELECT c.id as cat_id, c.cat_title, si.item_title, si.item_price, si.item_desc, si.item_image FROM store_items
AS si LEFT JOIN store_categories AS c on c.id = si.cat_id WHERE si.id = '".$safe_item_id."'"; //  pagal kategorijos ID gauna Kategorijos varda ir pan
$get_item_res = mysqli_query($mysqli, $get_item_sql) or die(mysqli_error($mysqli));
if (mysqli_num_rows($get_item_res) < 1) {
//invalid item
$display_block .= "<p><em>Invalid item selection.</em></p>";
} else {
//valid item, get info
while ($item_info = mysqli_fetch_array($get_item_res)) {
$cat_id = $item_info['cat_id'];
$cat_title = mb_strtoupper($item_info['cat_title'], 'UTF-8');//geras didziosios
$item_title = stripslashes($item_info['item_title']);
$item_price = $item_info['item_price'];
$item_desc = stripslashes($item_info['item_desc']);
$item_image = $item_info['item_image'];
}
 
//make breadcrumb trail rodo linkus kuriame esi & display of item
$display_block .= <<<END_OF_TEXT
<p><em>You are viewing:</em><br/>
<strong><a href="index.php?cat_id=$cat_id">$cat_title</a> &gt;
$item_title</strong></p>
<div style="float: left;"><img src="$item_image" class="img-responsive imgSize" alt="$item_title"/></div>
<div style="float: left; padding-left: 12px">
<p><strong>Description:</strong><br/>$item_desc</p>
<p><strong>Price:</strong> \$$item_price</p>
<form method="post" action="addtocart.php">
END_OF_TEXT;
 
//free result
mysqli_free_result($get_item_res);
 


        $display_block .= "<p><label for=\"sel_item_qty\">Select Quantity:</label>
       <select id=\"sel_item_qty\" name=\"sel_item_qty\">";
       
        for($i=1; $i<20; $i++){
                $display_block .= "<option value=\"".$i ."\">".$i."</option>";
        }
       
 $display_block .= <<<END_OF_TEXT
</select></p>
<input type="hidden" name="sel_item_id" value="$_GET[item_id]" />
<button type="submit" name="submit" value="submit"> Add to Cart</button>
</form>
</div>
END_OF_TEXT;
}
//close connection to MySQL
mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html>
<head>
	<?php include 'library.php' ?>
<title>My Store</title>
<style type="text/css">
        label {font-weight: bold;}
</style>      
</head>
<body>


<div class="container">
	<div class="row">
		<div class="col-md-12 border-color">
			<h1>Header</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 border-color">
			<p>up meniu</p>
		</div>
	</div>
<!--<?php echo $display_block; ?>-->
	<div class="row">
		<div class="col-md-9 border-color">
			<?php echo $display_block; ?>
		</div>
		<div class="col-md-3 border-color">
			<?php include 'showPriceWidget.php' ?>
		</div>
		

	</div>
	</div>
</body>
</html>