
<?php


include 'connect.php';


$display_block = "<h3>Your shopping cart</h3>";
//get widget info
$get_cart_sql = "SELECT st.id, si.item_price, st.sel_item_qty FROM
store_shoppertrack AS st LEFT JOIN store_items AS si ON si.id = st.sel_item_id WHERE session_id ='".$_COOKIE['PHPSESSID']."'";
$get_cart_res = mysqli_query($mysqli, $get_cart_sql) or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_cart_res) < 1) {
	//print message
	$display_block .= "<p>You have no items in your cart.</p>";
}
else {
	$full_price=0; 
	$full_qty=0;
	while ($cart_info = mysqli_fetch_array($get_cart_res)) {
	$id = $cart_info['id'];
	$item_price = $cart_info['item_price'];
	$item_qty = $cart_info['sel_item_qty'];
	$full_qty =  $full_qty + $item_qty; //galutinis kiekis
	$total_price = sprintf("%.02f", $item_price * $item_qty); 
	$full_price = sprintf("%.02f", $full_price+$total_price); //galutine kaina

	
	}
	$display_block .= "Total qty: $full_qty <br>";
	$display_block .= "Total price: $full_price <br>";
	$display_block .= "<a href='showcart.php'>Show Cart</a>";	
}



				

mysqli_free_result($get_cart_res);

?>
<!DOCTYPE HTML>
<html>
	<head>
	<?php include 'library.php';?>
	</head>
	<body>
	<?php echo $display_block?>
			
		
	</div>
	</body>
</html>