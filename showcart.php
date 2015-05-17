<?php

ob_start();
session_start();
include 'connect.php';
$shipping = 2.70;//shipping price LT
$totalShippingPrice= 30; //shipping discounts over 30eur
$shippingEuropean = 16.40; //shipping price EU
$_SESSION['totalShippingPrice']= $totalShippingPrice;
$_SESSION['shipping'] = $shipping;//perduoda i checkout_proccess
$_SESSION['shippingEuropean'] = $shippingEuropean;

if(isset($_GET['lang']) && $_GET['lang']=='LT'){
		include 'content_LT.php';
	}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
		include 'content_EN.php';
	}else{
		include 'content_LT.php';
	}

?>
<script type="text/javascript"> //table
	function updateProductPrice(id) {
		var x = isNumber($('#cost'+id).val()) ? $('#cost'+id).val() : 0;
		var y = isNumber($('#amount'+id).val()) ? $('#amount'+id).val() : 1;
		x = parseFloat(x);
		y = parseInt(y) < 1 ? 1 : parseInt(y);
		$('#amount'+id).val(y);
		var total = x * y;
		total = roundToPosition(total, 2);
		$('#total'+id).text(total);
		updateTotalPrices();	
	}

	function updateTotalPrices() {
		var total_price = getTotalPrice();
		var shipping_lt = 0;
		if ($('input[name="sendEurope"]').prop('checked')) {
			total_price += getShippingEU();
		} else {
			shipping_lt = getShippingLT(total_price);
			total_price += shipping_lt;
		}
		shipping_lt = roundToPosition(shipping_lt, 2);
		$('#shipping').text(shipping_lt);
		total_price = roundToPosition(total_price, 2);
		$('#all-total').text(total_price);
	}

	function isNumber(n) {
  		return !isNaN(parseFloat(n)) && isFinite(n);
	}

	function roundToPosition(number, position) {
		number = parseFloat(number);
		number = number * (Math.pow(10, position));
		number = Math.round(number);
		number = number / (Math.pow(10, position));
		return number;
	}

	function getTotalPrice() {
		var total_price = 0.0;
		$('span[id^="total"]').each(function(){
			total_price += parseFloat($(this).text());
		});
		return total_price;
	}

	function getShippingEU() {
		return  <?php echo $shippingEuropean; ?>;
	}

	function getShippingLT(total_price) {
		if (total_price < <?php echo $totalShippingPrice; ?>) {
			return <?php echo $shipping; ?>;
		} else {
			return 0;
		}

	}


</script>
<?php


$sel_item_id = $_SESSION['sel_item_id']; //turi gauti id is addtocart.php


$display_block = "
<ol class='breadcrumb'>
  <li><a href='index.php?lang=".$_GET['lang']."'>$txtmain_page</a></li>
  <li class='active'>$txtshopping_cart</li>
</ol>";
$display_block .= "<div class='text-center'> <h1>$txtshopping_cart</h1></div>";

if(isset($_GET['error']) && $_GET['error']== 'true' && isset($_GET['qty']) && $_GET['qty'] !='none' && isset($_GET['title'])){
	$display_block.= "<div class='alert alert-danger alert-dismissible' role='alert'>
 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
 		<p>$txtattension_available1  - ".$_GET['title']." $txtattension_available_qty1 ".$_GET['qty']."</p>
		</div>"; 
}else if(isset($_GET['error']) && $_GET['error']== 'true' && isset($_GET['qty']) && $_GET['qty'] =='none' && isset($_GET['title'])){
	$display_block.= "<div class='alert alert-danger alert-dismissible' role='alert'>
 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
 		<p>$txtno_qty_available - ".$_GET['title']."</p>
		</div>"; 
}


$get_session_sql = "SELECT * FROM store_shoppertrack WHERE session_id = '".$_COOKIE['PHPSESSID']."'";
$get_session_query = mysqli_query($mysqli, $get_session_sql) or die(mysqli_error($mysqli));
$session = mysqli_fetch_assoc($get_session_query);//tikrinu dabartine session IMA tik viena reiksme

if($session['session_id']==$_COOKIE['PHPSESSID']){
    $order_id=$session['id'];
    $_SESSION['order_id'] = $order_id;//perduoda i removecart.php

	//DISPLAY TABLE
	//check for cart items based on user session id
	$get_cart_sql = "SELECT st.order_id, si.item_title, si.item_title_EN, si.item_price, si.id, st.sel_item_qty FROM
	store_shoppertrack_items AS st LEFT JOIN store_items AS si ON si.id = st.sel_item_id WHERE order_id ='".$order_id."'";
	$get_cart_res = mysqli_query($mysqli, $get_cart_sql) or die(mysqli_error($mysqli));

	if (mysqli_num_rows($get_cart_res) < 1) {
		//print message
		$display_block .= "<p>$txtno_basket_items
		$txtplease <a href='index.php?lang=".$_GET['lang']."'>$txtcontinue_shopping</a>!</p>";
	} else {
	//get info and build cart display action='checkout.php' 
	$display_block .= "
	<form method='post' action='checkout_proccess.php?lang=".$_GET['lang']."' >
		<table class='table table-bordered table-hover table-condensed'>
			<tr>
				<th class='text-center'>$txttitle</th>
				<th class='text-center'>$txtprice</th>
				<th class='text-center'>$txtqty</th>
				<th class='text-center'>$txttotal_price</th>
				<th class='text-center'>$txtactions</th>
			</tr>";


		// info is shoppertrack
		$full_qty=0;
		$full_price=0;
		while ($cart_info = mysqli_fetch_array($get_cart_res)) {
		$item_id = $cart_info['id'];//nenaudojamas
		
		if(isset($_GET['lang']) && $_GET['lang']=='LT'){
			$item_title = stripslashes($cart_info['item_title']);
		}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
			$item_title = stripslashes($cart_info['item_title_EN']);
		}else{
			$item_title = stripslashes($cart_info['item_title']);
		}

		$item_price = $cart_info['item_price'];
		$item_qty = $cart_info['sel_item_qty'];
		$full_qty =  $full_qty + $item_qty;
		$total_price = sprintf("%.02f", $item_price * $item_qty);
		$full_price = sprintf("%.02f", $full_price+$total_price); //galutine kaina

//TABLE DATA
	$display_block .= "
	<tr class='text-center'>
		<td><p>$item_title</p></td>
		<td><p>$item_price &euro;</p></td>
		<input type='hidden' id='cost".$item_id."' value='".$item_price."' name='price".$item_id."'/>
		<td> <input type='number' class='text-center' min='1' step='any' id='amount".$item_id."'  onchange='updateProductPrice($item_id)' name='qty".$item_id."' value='$item_qty'></td>
		<td><p><span id='total".$item_id."' >" . $total_price . "</span>&euro;</p></td>
		<td><a class='btn btn-danger' type='button' href='removefromcart.php?lang=".$_GET['lang']."&id=$item_id'>$txtremove</a></td>
	</tr>";

	
	}//end of while
	if(isset($full_price)){
		$shipping_check=0;
		if($full_price<$totalShippingPrice){
			$shipping_check += $shipping;
		}
$display_block.="

	<tr>
		<td class='text-right' colspan='3'><div><p>$txtdelivery_info_lt:</p></div></td>
		<td class='text-center'><p><strong><span id='shipping'>" . $shipping_check .  "</span>&euro;<strong></p></td>
	</tr>
	<tr>
		<div class='row'>
		<td class='text-right' colspan='3'><div><p>$txtdelivery_info_eu:</p></div></td>
		<div class='checkbox'>
			
		<td class='text-center'>
			<label>
				<input type='checkbox' name='sendEurope' value='1' onchange='updateTotalPrices();'>  <span>" . $shippingEuropean .  "</span>&euro;
			</label>
		</td>
		
	</tr>
	<tr>
	<td class='text-right' colspan='3'><div><label>$txttotal_price:</label></div></td>
		<td class='text-center'><h3><strong><span  id='all-total'>" . ($full_price + $shipping_check) .  "</span>&euro;</strong></h3></td>

	</tr>";
	
	}
	$display_block .= "</table>";

	}
	$display_block.="

	";
	


}
if(isset($full_price)){
$display_block .= "
<input type='hidden' name='full_price' value='$full_price'/>
	<button class='btn btn-success col-md-offset-10 text-center btn-lg' type='submit' name='submit_form' value='submit'>$txtsending</button>
</form>";
}


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
	
<?php
	include 'header.php';
	 include 'navbar.php'; ?>


	<div class="row">
		<div class="col-md-9">
			<?php echo $display_block; ?>
		</div>

		<div class="col-md-3 right-bar-edit border-color">
		<?php 
			include_once 'login.php';  
				
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