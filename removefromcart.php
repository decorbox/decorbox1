<?php
session_start();
include 'connect.php';
if (isset($_GET['id'])) {
	$order_id = $_SESSION['order_id'];//gauna is showcart
	

//create safe values for use
$safe_id = mysqli_real_escape_string($mysqli, $_GET['id']);

$delete_item_sql = "DELETE FROM store_shoppertrack_items WHERE sel_item_id = '".$safe_id."' and order_id ='".$order_id."'";
$delete_item_res = mysqli_query($mysqli, $delete_item_sql) or die(mysqli_error($mysqli));

$delete_store_orders_sql = "DELETE FROM store_orders_items WHERE order_id = '".$safe_id."'";
$delete_store_orders_res = mysqli_query($mysqli, $delete_store_orders_sql) or die(mysqli_query($mysqli));



//close connection to MySQL
mysqli_close($mysqli);
//redirect to showcart page
header("Location: showcart.php");
exit;
} else {
//send them somewhere else
header("Location: displayCategories.php");
exit;
}
?>