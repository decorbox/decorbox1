<?php
session_start();
include 'connect.php';

$sel_item_id = $_SESSION['sel_item_id']; //turi gauti id is addtocart.php


$display_block = "
<ol class='breadcrumb'>
  <li><a href='index.php'>Pagrindinis</a></li>
  <li class='active'>Krepšelis</li>
</ol>";
$display_block .= "<div class='text-center'> <h1>Your Shopping Cart</h1></div>";


$get_session_sql = "SELECT * FROM store_shoppertrack WHERE session_id = '".$_COOKIE['PHPSESSID']."'";
$get_session_query = mysqli_query($mysqli, $get_session_sql) or die(mysqli_error($mysqli));
$session = mysqli_fetch_assoc($get_session_query);//tikrinu dabartine session IMA tik viena reiksme

if($session['session_id']==$_COOKIE['PHPSESSID']){
    $order_id=$session['id'];
    $_SESSION['order_id'] = $order_id;//perduoda i removecart.php

	//DISPLAY TABLE
	//check for cart items based on user session id
	$get_cart_sql = "SELECT st.order_id, si.item_title, si.item_price, si.id, st.sel_item_qty FROM
	store_shoppertrack_items AS st LEFT JOIN store_items AS si ON si.id = st.sel_item_id WHERE order_id ='".$order_id."'";
	$get_cart_res = mysqli_query($mysqli, $get_cart_sql) or die(mysqli_error($mysqli));

	if (mysqli_num_rows($get_cart_res) < 1) {
		//print message
		$display_block .= "<p>Nėra prekių jūsų krepšelyje.
		Prašome <a href=\"index.php\">tęsti apsipirkimą</a>!</p>";
	} else {
	//get info and build cart display
	$display_block .= "
	<table class='table table-bordered table-hover table-condensed'>
	<tr>
	<th class='text-center'>Title</th>
	<th class='text-center'>Price</th>
	<th class='text-center'>Qty</th>
	<th class='text-center'>Total Price</th>
	<th class='text-center'>Action</th>
	</tr>";

		// info is shoppertrack
		$full_qty=0;
		$full_price=0;
		while ($cart_info = mysqli_fetch_array($get_cart_res)) {
		$item_id = $cart_info['id'];//nenaudojamas
		$item_title = stripslashes($cart_info['item_title']);
		$item_price = $cart_info['item_price'];
		$item_qty = $cart_info['sel_item_qty'];
		$full_qty =  $full_qty + $item_qty;
		$total_price = sprintf("%.02f", $item_price * $item_qty);
		$full_price = sprintf("%.02f", $full_price+$total_price); //galutine kaina

		/*$select_item_id_sql = "SELECT sel_item_id FROM store_shoppertrack_items WHERE order_id = '".$id."'";
		$item_id = mysqli_query($mysqli, $select_item_id_sql) or die($mysqli_query($mysqli));//
	*/	//$safe_item_id = mysqli_real_escape_string($mysqli, $_GET['sel_item_id']);





	$display_block .= "
	<tr class='text-center'>
	<td>$item_title <br></td>
	<td>&euro; $item_price <br></td>
	<td>$item_qty <br></td>
	<td>&euro; $total_price</td>
	<td><a class='btn btn-danger' type='button' href='removefromcart.php?id=$item_id'>Remove</a></td>
	</tr>";
	}//end of while




	$_SESSION['full_qty'] = $full_qty;//turi perduoti i checkout
	$_SESSION['full_price'] = $full_price;
	//setcookie('total_item_qty', $full_qty);//perduoda i checkout
	$display_block .= "</table>";

	}//end of else
	if(isset($full_price)){
		$display_block .= $full_price;//checkout.php idet i action
	}
	$display_block .= "
	<form method='post' action='checkout.php'>";


}//}//end of if session

if(isset($full_price)){
$display_block .= "
<input type='hidden' name='full_price' value='$full_price'/>
<button class='btn btn-success btn-lg' type='submit' name='submit_form' value='submit'>Checkout</button>
</form>";
}

//free result
mysqli_free_result($get_cart_res);

//close connection to MySQL
mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html>
<head>
	<?php include 'library.php' ?>
<title>My Store</title>

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
		<div class="col-md-12 border-color">
			<?php echo $display_block; ?>
		</div>


	</div>
	</div>


</body>
</html>