
<?php

include 'connect.php';


	$display_block = "<h3>Pirkinių krepšelis</h3>";
                
//get order_id
$get_order_id_sql = "SELECT id FROM store_shoppertrack WHERE session_id = '".$_COOKIE['PHPSESSID']."'";
$run_order_id_res = mysqli_query($mysqli, $get_order_id_sql) or die(mysqli_error($mysqli));
while($info = mysqli_fetch_array( $run_order_id_res))    
{ 
    $order_id = $info['id'];
} 

//get widget info
if (isset($order_id)) {

	$get_cart_sql = "SELECT st.order_id, si.item_price, st.sel_item_qty FROM
	store_shoppertrack_items AS st LEFT JOIN store_items AS si ON si.id = st.sel_item_id WHERE order_id ='".$order_id."'"; 
	$get_cart_res = mysqli_query($mysqli, $get_cart_sql) or die(mysqli_error($mysqli));
					
	if (mysqli_num_rows($get_cart_res) < 1) {
		//print message
		$display_block .= "<p>Krepšelyje prekių nėra</p>";
	}
	else {
		$full_price=0; 
		$full_qty=0;
		while ($cart_info = mysqli_fetch_array($get_cart_res)) {
			$id = $cart_info['order_id'];
			$item_price = $cart_info['item_price'];
			$item_qty = $cart_info['sel_item_qty'];
			$full_qty =  $full_qty + $item_qty; //galutinis kiekis
			$total_price = sprintf("%.02f", $item_price * $item_qty); 
			$full_price = sprintf("%.02f", $full_price+$total_price); //galutine kaina
		}
		$display_block .= "Prekių kiekis: $full_qty <br>";
		$display_block .= "Galutinė kaina: $full_price <br>";
		$display_block .= "<a href='showcart.php'>Rodyti krepšelį</a>";	
	}


	mysqli_free_result($get_cart_res);
}

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