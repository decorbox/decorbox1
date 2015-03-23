<?php
session_start();
include 'connect.php';
$shipping = 2.70;//shipping price LT
$totalShippingPrice= 30; //shipping discounts over 30eur
$shippingEuropean = 16.40; //shipping price EU
$_SESSION['totalShippingPrice']= $totalShippingPrice;
$_SESSION['shipping'] = $shipping;//perduoda i checkout_proccess
$_SESSION['shippingEuropean'] = $shippingEuropean;

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
  <li><a href='index.php'>Pagrindinis</a></li>
  <li class='active'>Krepšelis</li>
</ol>";
$display_block .= "<div class='text-center'> <h1>Pirkinių krepšelis</h1></div>";


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
	//get info and build cart display action='checkout.php' 
	$display_block .= "
	<form method='post' action='checkout_proccess.php' >
		<table class='table table-bordered table-hover table-condensed'>
			<tr>
				<th class='text-center'>Pavadinimas</th>
				<th class='text-center'>Kaina</th>
				<th class='text-center'>Kiekis</th>
				<th class='text-center'>Visa kaina</th>
				<th class='text-center'>Veiksmai</th>
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

//TABLE DATA
	$display_block .= "
	<tr class='text-center'>
		<td>$item_title <br></td>
		<td>&euro; $item_price <br></td>
		<input type='hidden' id='cost".$item_id."' value='".$item_price."' name='price".$item_id."'/>
		<td> <input type='number' class='text-center' min='1' step='any' id='amount".$item_id."'  onchange='updateProductPrice($item_id)' name='qty".$item_id."' value='$item_qty'></td>
		<td><span id='total".$item_id."' >" . $total_price . "</span> &euro;</td>
		<td><a class='btn btn-danger' type='button' href='removefromcart.php?id=$item_id'>Pašalinti</a></td>
	</tr>";

	
	}//end of while
	if(isset($full_price)){
		$shipping_check=0;
		if($full_price<$totalShippingPrice){
			$shipping_check += $shipping;
		}
$display_block.="

	<tr>
		<td class='text-right' colspan='3'><div><label>Siuntimo kaina Lietuvoje (nuo &euro;30 siuntimas NEMOKAMAS!):</label></div></td>
		<td style='color:red;' class='text-center'><strong>&euro;<span id='shipping'>" . $shipping_check .  "</span></strong></td>
	</tr>
	<tr>
		<td class='text-right' colspan='3'><div><label>Galutinė siuntimo kaina Lietuvoje:</label></div></td>
		<td style='color:red;' class='text-center'><strong >&euro;<span  id='all-total'>" . ($full_price + $shipping_check) .  "</span></strong></td>
	</tr>
	<div class='row'>
		<td class='text-right' colspan='3'><div><label>Siuntimo kaina kitose ES šalyse:</label></div></td>
		<div class='checkbox'>
			
		<td class='text-center'>
			<label>
				<input type='checkbox' name='sendEurope' value='1' onchange='updateTotalPrices();'> <strong> &euro;<span>" . $shippingEuropean .  "</span></strong>
			</label>
		</td>

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
	<button class='btn btn-success col-md-offset-10 text-center btn-lg' type='submit' name='submit_form' value='submit'>Siuntimas</button>
</form>";
}
//free result
//mysqli_free_result($get_cart_res);

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

	
<!--<?php echo $display_block; ?>-->
	<div class="row">
		<div class="col-md-12 border-color">
			<?php echo $display_block; ?>
		</div>


	</div>
	</div>


</body>
</html>