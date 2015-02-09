<?php
session_start();
include 'connect.php';

$sel_item_id = $_SESSION['sel_item_id']; //turi gauti id is addtocart.php


$display_block = "<p><em>You are viewing:</em><br/>
<strong><a href='index.php'>Pagrindinis</a> &gt;
krepšelis</strong></p>";
$display_block .= "<h1>Your Shopping Cart</h1>";


$get_session_sql = "SELECT * FROM store_shoppertrack WHERE session_id = '".$_COOKIE['PHPSESSID']."'";
$get_session_query = mysqli_query($mysqli, $get_session_sql) or die(mysqli_error($mysqli));
$session = mysqli_fetch_assoc($get_session_query);//tikrinu dabartine session IMA tik viena reiksme

if($session['session_id']==$_COOKIE['PHPSESSID']){
    $order_id=$session['id'];


//DISPLAY TABLE
//check for cart items based on user session id
$get_cart_sql = "SELECT st.order_id, si.item_title, si.item_price, si.id, st.sel_item_qty FROM
store_shoppertrack_items AS st LEFT JOIN store_items AS si ON si.id = st.sel_item_id WHERE order_id ='".$order_id."'";
$get_cart_res = mysqli_query($mysqli, $get_cart_sql) or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_cart_res) < 1) {
	//print message
	$display_block .= "<p>You have no items in your cart.
	Please <a href=\"displayCategories.php\">continue to shop</a>!</p>";
} else {
//get info and build cart display
$display_block .= <<<END_OF_TEXT
<table class="table table-bordered table-hover table-condensed">
<tr>
<th>Title</th>
<th>Price</th>
<th>Qty</th>
<th>Total Price</th>
<th>Action</th>
</tr>
END_OF_TEXT;

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





$display_block .= <<<END_OF_TEXT
<tr>
<td>$item_title <br></td>
<td>\$ $item_price <br></td>
<td>$item_qty <br></td>
<td>\$ $total_price</td>
<td><a href="removefromcart.php?id=$item_id">remove</a></td>
</tr>
END_OF_TEXT;
}//end of while




$_SESSION['full_qty'] = $full_qty;//turi perduoti i checkout
$_SESSION['full_price'] = $full_price;
//setcookie('total_item_qty', $full_qty);//perduoda i checkout
$display_block .= "</table>";

}//end of else
$display_block .= $full_price;//checkout.php idet i action
$display_block .= <<<END_OF_TEXT
<form method="post" action="">
END_OF_TEXT;
//atvaizdavimas i lenteles baigiasi/ toliau irasymas i duombaze!!!
$get_cart_sql = "SELECT st.order_id, si.item_title, si.item_price, si.id, st.sel_item_qty, st.sel_item_id FROM
	store_shoppertrack_items AS st LEFT JOIN store_items AS si ON si.id = st.sel_item_id WHERE order_id ='".$order_id."'";
$get_cart_res1 = mysqli_query($mysqli, $get_cart_sql) or die(mysqli_error($mysqli));

//jei checkout irasom naujus uzsakymo duomenis
if(isset($_POST['submit_form'])){

	//istrinam praeitus duomenis siame uzsakyme
	$delete_previous_sql = "DELETE FROM store_orders_items_item WHERE order_id ='".(int)$order_id."'";
	mysqli_query($mysqli, $delete_previous_sql) or die(mysqli_error($mysqli));

	//irasome is naujos visus
	while ($cart_info1 = mysqli_fetch_array($get_cart_res1)) {

		$add_item_sql = "INSERT INTO store_orders_items_item
	        (order_id, item_id, item_qty, item_price) VALUES ('".$order_id."',
	        '".$cart_info1['sel_item_id']."',
	        '".$cart_info1['sel_item_qty']."',
	        '".$cart_info1['item_price'] * $cart_info1['sel_item_qty']."')";
	    $add_item_res = mysqli_query($mysqli, $add_item_sql) or die(mysqli_error($mysqli));

	}//end of main while
}//end of if isset submit
}//}//end of if session


$display_block .= <<<END_OF_TEXT
<input type="hidden" name="full_price" value="$full_price"/>
<button type="submit" name="submit_form" value="submit"> Checkout </button>

</form>
END_OF_TEXT;


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
<style type="text/css">
table {
	border: 1px solid black;
	border-collapse: collapse;
	}
	th {
	border: 1px solid black;
	padding: 6px;
	font-weight: bold;
	background: #ccc;
	text-align: center;
	}
	td {
	border: 1px solid black;
	padding: 6px;
	vertical-align: top;
	text-align: center;
	}
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
		<div class="col-md-12 border-color">
			<?php echo $display_block; ?>
		</div>


	</div>
	</div>


</body>
</html>