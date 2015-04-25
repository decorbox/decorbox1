<?php
//isversta i anglu
session_start();
 // gera knyga 23 skyrius
 //connected to displayCategories
include 'connect.php';

if(isset($_GET['lang']) && $_GET['lang']=='LT'){
		include 'content_LT.php';
	}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
		include 'content_EN.php';
	}else{
		include 'content_LT.php';
	}
//create safe values for use
$safe_item_id = @mysqli_real_escape_string($mysqli, $_GET['item_id']);
 //validate item
$get_item_sql = "SELECT c.id as cat_id, c.cat_title, c.cat_title_EN,si.item_title, si.qty, si.item_title_EN, si.item_price, si.item_desc, si.item_desc_EN,si.item_price_old ,si.item_image FROM store_items
AS si LEFT JOIN store_categories AS c on c.id = si.cat_id WHERE si.id = '".$safe_item_id."'"; //  pagal kategorijos ID gauna Kategorijos varda ir pan
$get_item_res = mysqli_query($mysqli, $get_item_sql) or die(mysqli_error($mysqli));
if (mysqli_num_rows($get_item_res) < 1) {
	//invalid item
	$display_block = "<p><em>Invalid item selection.</em></p>";
} else {
//valid item, get info
while ($item_info = mysqli_fetch_array($get_item_res)) {
	$cat_id = $item_info['cat_id'];
	if(isset($_GET['lang']) && $_GET['lang']=='LT'){
		$cat_title = mb_strtoupper($item_info['cat_title'], 'UTF-8');//geras didziosios
		$item_title = stripslashes($item_info['item_title']);
		$item_desc = stripslashes($item_info['item_desc']);
	}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
		$cat_title = mb_strtoupper($item_info['cat_title_EN'], 'UTF-8');//geras didziosios
		$item_title = stripslashes($item_info['item_title_EN']);
		$item_desc = stripslashes($item_info['item_desc_EN']);
	}else{
		$cat_title = mb_strtoupper($item_info['cat_title'], 'UTF-8');//geras didziosios
		$item_title = stripslashes($item_info['item_title']);
		$item_desc = stripslashes($item_info['item_desc']);
	}
	$item_price = $item_info['item_price'];
	$item_price_old = $item_info['item_price_old'];
	$discount = $item_price_old - $item_price;
	$item_image = $item_info['item_image'];
	$item_qty = $item_info['qty'];
}
if($item_qty == NULL OR $item_qty == 0){
	$item_qty = $txtno_item_qty;
}
$display_block = "
	<ol class='breadcrumb'>
	  <li><a href='index.php?lang=".$_GET['lang']."&cat_id=$cat_id'>$cat_title</a></li>
	  <li class='active'>$item_title</li>
	</ol>";

$display_block .= "<div class='text-center'><h1>$item_title</h1><hr></div>";
//make breadcrumb trail rodo linkus kuriame esi & display of item
$display_block .= "

<div class='row'>
	<div class='col-md-6 '>
		<div><img src='$item_image' class='img-responsive ' alt='$item_title'/></div>
	</div>
	<div class='col-md-6'>";
		if(!empty($item_price_old)){
			$display_block.="
			<p style='text-decoration: line-through;'><strong>$txtold_price:</strong>$item_price_old &euro;</p>
			<p><strong>$txtitemDiscount:</strong> $discount &euro;</p>";
		}
		$display_block.="
		<p><strong>$txtqty_available:</strong> $item_qty</p>
		<p><strong>$txtprice:</strong>$item_price &euro;</p>
		<form method='post' action='addtocart.php'>";

 
//free result
mysqli_free_result($get_item_res);
 


        $display_block .= "<label for='sel_item_qty'>$txtqty:</label>
        <input type='number' min='1' value='1'  name='sel_item_qty' id='sel_item_qty'>
		<input type='hidden' name='sel_item_id' value='".$_GET['item_id']."' >
		<button class='btn btn-success' type='submit' name='submit' value='submit'>$txtadd_to_basket</button>
		</form>
		<div class='row margin-top '>
			<p><strong>$txtdescription:</strong><br/>$item_desc</p>
		</div>
	</div>
</div>";


}
//close connection to MySQL

?>
<!DOCTYPE html>
<html>
<head>
	<?php //include 'library.php' ?>
	
<title>My Store</title>
<style type="text/css">
        label {font-weight: bold;}
</style>      
</head>
<body>

<div class="container">
<?php 
include 'header.php';
include'navbar.php';?>

<!--<?php echo $display_block; ?>-->
	<div class="row">
		<div class="col-md-9 ">
			<?php echo $display_block; ?>
		</div>
		<div class="col-md-3 right-bar-edit border-color">
			<?php include 'login.php';
			include 'showPriceWidget.php';
			include_once 'contactsWidget.php';
				include_once 'deliveryWidget.php';
				include_once 'facebookWidget.php';
				 ?>
		</div>
		

	</div>
	</div>
<div class="container">	
	<div class="row">
		<?php include 'footer.php'; ?>
	</div>
</div>
	
</body>
</html>