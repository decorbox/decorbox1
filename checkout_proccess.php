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
	$qty_error = false;
	while ($cart1_info = mysqli_fetch_array($get_cart_res1)) {
		$item_id1 = $cart1_info['id'];//nenaudojamas

		$item_qty1 = $_POST["qty$item_id1"];
		
		$check_qty = "SELECT qty, item_title, item_title_EN FROM store_items WHERE id = '".$item_id1."'";
		$check_qty_res = mysqli_query($mysqli, $check_qty) or die(mysqli_error($mysqli));
		$check_qty_assoc = mysqli_fetch_assoc($check_qty_res);
		$check_store_qty = $check_qty_assoc['qty']; //check and compare item qty
		$check_title_assoc = mysqli_fetch_assoc($check_qty_res);

		if(isset($_GET['lang']) && $_GET['lang']=='LT'){
			$check_store_title = $check_qty_assoc['item_title'];
		}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
			$check_store_title = $check_qty_assoc['item_title_EN'];
		}else{
			$check_store_title = $check_qty_assoc['item_title'];
		}
		

		if($item_qty1 <= $check_store_qty){
			//update shopper track

			$update_shoppertrack_items_sql = "UPDATE store_shoppertrack_items SET sel_item_qty='".$item_qty1."' WHERE sel_item_id='".$item_id1."' AND order_id='".$order_id."'";
			$update_shoppertrack_items_res = mysqli_query($mysqli, $update_shoppertrack_items_sql);
		}else{
			$qty_error = true;
			if($check_store_qty == NULL OR $check_store_qty == 0){
				header("Location: showcart.php?lang=".$_GET['lang']."&error=true&qty=none&title=".$check_store_title."");
			}else{
			header("Location: showcart.php?lang=".$_GET['lang']."&error=true&qty=".$check_store_qty."&title=".$check_store_title."");
			}
		}

		
	}



	if($qty_error != true){
		header("Location: checkout.php?lang=".$_GET['lang']."");
	}
	
}else{
	header("Location: showcart.php?lang=".$_GET['lang']."");
}
?>