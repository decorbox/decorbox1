<?php
session_start();
include 'connect.php';

if(isset($_POST['submit_form'])){
	$shipping = $_SESSION['shipping'];

	$order_id = $_SESSION['order_id'];
	$get_cart_sql1 = "SELECT st.order_id, si.item_title, si.item_price, si.id, st.sel_item_qty FROM
	store_shoppertrack_items AS st LEFT JOIN store_items AS si ON si.id = st.sel_item_id WHERE order_id ='".$order_id."'";
	$get_cart_res1 = mysqli_query($mysqli, $get_cart_sql1) or die(mysqli_error($mysqli));
	setcookie('europeShip', $_POST['sendEurope']);
	//$full_price1= 0;
	//$full_qty1=0;
	while ($cart1_info = mysqli_fetch_array($get_cart_res1)) {
		$item_id1 = $cart1_info['id'];//nenaudojamas
		//$item_title = stripslashes($cart1_info['item_title']);
		//$item_price1 = $item_price1 + $_POST["price$item_id1"];
		$item_qty1 = $_POST["qty$item_id1"];
		//$full_qty1 =  $full_qty1 + $item_qty1;
		//$total_price1 = sprintf("%.02f", $_POST["price$item_id1"] * $_POST["qty$item_id1"]);
		//$full_price1 = sprintf("%.02f", $full_price1+$total_price1);

		//update shopper track
		$update_shoppertrack_items_sql = "UPDATE store_shoppertrack_items SET sel_item_qty='".$item_qty1."' WHERE sel_item_id='".$item_id1."' AND order_id='".$order_id."'";
		$update_shoppertrack_items_res = mysqli_query($mysqli, $update_shoppertrack_items_sql);
	}




	header("Location: checkout.php?lang=".$_GET['lang']."");
}else{
	header("Location: showcart.php?lang=".$_GET['lang']."");
}
?>