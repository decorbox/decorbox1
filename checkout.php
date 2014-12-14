<?php 
session_start();
include 'connect.php';

//not working yet
$sel_item_id = $_SESSION['sel_item_id']; //turi gauti id is addtocart.php


/*
MINDAUGO
// check if product already exits
+            $get_product_sql = "SELECT * FROM `store_shoppertrack` WHERE `sel_item_id` = '" . (int)$safe_sel_item_id . "' AND `session_id` = '" . $_COOKIE['PHPSESSID'] . "'";
+            $product_query = mysqli_query($mysqli, $get_product_sql);
+            $product = mysqli_fetch_assoc($product_query);
+            if (isset($product['sel_item_qty']) && $product['sel_item_qty'] > 0) {
+               // update cart product
+               $update_cart_sql = "UPDATE `store_shoppertrack`
+                    SET `sel_item_qty` = `sel_item_qty` + '" . (float)$safe_sel_item_qty . "'
+                    WHERE `sel_item_id` = '" . (int)$safe_sel_item_id . "' AND `session_id` = '" . $_COOKIE['PHPSESSID'] . "'";
+                $update_to_cart_res = mysqli_query($mysqli, $update_cart_sql) or die(mysqli_error($mysqli));
+            } else {
+                //add info to cart table
+                $addtocart_sql = "INSERT INTO store_shoppertrack
+                    (session_id, sel_item_id, sel_item_qty, date_added) VALUES ('".$_COOKIE['PHPSESSID']."',
+                    '".$safe_sel_item_id."',
+                    '".$safe_sel_item_qty."', now())";
+                $addtocart_res = mysqli_query($mysqli, $addtocart_sql) or die(mysqli_error($mysqli));
+            }








*/



/*if(isset($_POST['add'])){
	$safe_sel_item_authorization = $_COOKIE['PHPSESSID']; //reikia vartotojo login
	$safe_sel_item_total= 21; //$_POST['item_total'];
	$safe_order_address = $_POST['order_address'];
	$safe_order_city =	$_POST['order_city'];
	$safe_order_email = $_POST['order_email'];
	$safe_order_name = $_POST['order_name'];
	$safe_order_tel = $_POST['order_tel'];
	$safe_order_zip = $_POST['order_zip'];
	$safe_shipping_total = 4; //
	$safe_shipping_status = "pending"; //
	$id='';
// ir sql pakeist i login id
	$sql = "INSERT INTO store_orders (session_id,'', item_total, order_address, order_city, order_email,
	order_name, order_tel, order_zip, shipping_total, status) VALUES ('".$_COOKIE['PHPSESSID']."', 
	'".$id."',										
	'".$safe_sel_item_total."',
	'".$safe_order_address."',
	'".$safe_order_city."',
	'".$safe_order_email."',
	'".$safe_order_name."',
	'".$safe_order_tel."',
	'".$safe_order_zip."',
	'".$safe_shipping_total."',
	'".$safe_shipping_status."', now())";

$write_in_db = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
mysql_close($mysqli);
}
?>
<form method="post" action="<?php $_PHP_SELF ?>">
	<table width="400px" border="0">
		<tr>
			<td>Vardas ir Pavardė</td>
			<td><input name="order_name" type="text" id="order_name"></td>
			<td>adresas</td>
			<td><input name="order_address" type="text" id="order_address"></td>
			<td>miestas</td>
			<td><input name="order_city" type="text" id="order_city"></td>
			<td>email</td>
			<td><input name="order_email" type="text" id="order_email"></td>
			<td>tel</td>
			<td><input name="order_tel" type="text" id="order_tel"></td>
			<td>zip</td>
			<td><input name="order_zip" type="text" id="order_zip"></td>


			<input name="add" type="submit" id="add" value="Add Person">
			</td>
		</tr>
		</table>

</form> */