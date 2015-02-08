<?php 
session_start();
include 'connect.php';
/*
//select order_id from database
	$get_order_id_sql = "SELECT order_id FROM store_orders WHERE authorization = '".$_COOKIE['ID_my_site']."'";
	$run_order_id_res = mysqli_query($mysqli, $get_order_id_sql) or die(mysqli_error($mysqli));
	while($info = mysqli_fetch_array( $run_order_id_res)) 	 
 		{ 
 			$order_id = $info['order_id'];
 		} 
//check for cart items based on user session id
$get_cart_sql = "SELECT st.order_id, si.item_title, si.item_price, st.sel_item_qty FROM
store_orders_items AS st LEFT JOIN store_items AS si ON si.id = st.sel_item_id WHERE order_id ='".$order_id."'";
$get_cart_res = mysqli_query($mysqli, $get_cart_sql) or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_cart_res) < 1) {
	//print message
	$display_block .= "<p>You have no items in your cart.
	Please <a href=\"displayCategories.php\">continue to shop</a>!</p>";
} else {
//get info and build cart display
$display_block = <<<END_OF_TEXT
<table class="table table-bordered table-hover table-condensed">
<tr>
<th>Title</th>
<th>Price</th>
<th>Qty</th>
<th>Total Price</th>
<th>Action</th>
</tr>
END_OF_TEXT;
	// info is store_orders_item
	
	while ($cart_info = mysqli_fetch_array($get_cart_res)) {
	$id = $cart_info['order_id'];
	$item_title = stripslashes($cart_info['item_title']);
	$item_price = $cart_info['item_price'];
	$item_qty = $cart_info['sel_item_qty'];
	 
	
	$select_item_id_sql = "SELECT sel_item_id FROM store_orders_items WHERE id = '".$id."'";
	$item_id = mysqli_query($mysqli, $select_item_id_sql) or die($mysqli_query($mysqli));//
	//$safe_item_id = mysqli_real_escape_string($mysqli, $_GET['sel_item_id']);


$display_block .= <<<END_OF_TEXT
<tr>
<td>$item_title <br></td>
<td>\$ $item_price <br></td>
<td>$item_qty <br></td>

<td><a href="removefromcart.php?id=$id">remove</a></td>
</tr>
END_OF_TEXT;
}


$display_block .= "</table>";

}
//$display_block .= $full_price;*/
?>


<!DOCTYPE HTML>
<html>
<head>
<?php include 'library.php';?>
</head>
<body>
<div class="container">
	<div class="row"><!-- header-->
		<div class="col-md-12 border-color">
			<h1>Header</h1>
		</div>
	</div>

	<div class="row"><!--meniu-->
		<div class="col-md-12 border-color">
			<p>up meniu</p>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 border-color">	<!--body-->
			<p>Sveikiname nusipirke preke. Čia bus banko informacija. <a href="index.php"> Grįžkite į pagrindinį puslapį</a></p>

			<?php echo $display_block ?>
		</div>
	</div>
</div>


</body>
</html>

