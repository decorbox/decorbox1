<?php 
session_start();
include 'connect.php';
include 'library.php';

if(isset($_GET['lang']) && $_GET['lang']=='LT'){
        include 'content_LT.php';
    }else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
        include 'content_EN.php';
    }else{
        include 'content_LT.php';
    }

include 'sendOrderEmail.php';

$order_id= $_COOKIE['order_id'];//good(not temp) order id(real order id)

$select_user_info="SELECT * FROM store_orders WHERE id='".$order_id."'";
$select_user_info_res= mysqli_query($mysqli, $select_user_info);


/*
//send email
$to = "deivassx@gmail.com";//buyer email ".$_POST['email']."
$subject = "Prekė užsakyta";

$get_cart_email_sql = "SELECT st.order_id, si.item_title, si.item_price, si.id, st.sel_item_qty FROM
	store_shoppertrack_items AS st LEFT JOIN store_items AS si ON si.id = st.sel_item_id WHERE order_id ='".$order_id."'";
$get_cart_email_res = mysqli_query($mysqli, $get_cart_email_sql) or die(mysqli_error($mysqli));
$email="";
$email .= "
		<table class='table table-bordered table-condensed'>
			<tr>
				<th class='text-center'>Pavadinimas</th>
				<th class='text-center'>Kaina</th>
				<th class='text-center'>Kiekis</th>
				<th class='text-center'>Visa kaina</th>
			</tr>";


		// info is shoppertrack
		$full2_qty=0;
		$full2_price=0;
		while ($cart2_info = mysqli_fetch_array($get_cart_email_res)) {
		$item2_id = $cart2_info['id'];//nenaudojamas
		$item2_title = stripslashes($cart2_info['item_title']);
		$item2_price = $cart2_info['item_price'];
		$item2_qty = $cart2_info['sel_item_qty'];
		$full2_qty =  $full2_qty + $item2_qty;
		$total2_price = sprintf("%.02f", $item2_price * $item2_qty);
		$full2_price = sprintf("%.02f", $full2_price+$total2_price); //galutine kaina

//TABLE DATA
	$email .= "
	<tr class='text-center'>
		<td>$item2_title</td>
		<td>&euro; $item2_price</td>
		<td>$item2_qty</td>
		<td>&euro; $total2_price </td>
	</tr>";
	}//end of while

$email.="
	<tr style='color:red;'>
		<td class='text-right' colspan='3'><div><label>Siuntimo kaina:</label></div></td>
		<td class='text-center'><strong>&euro;<span>" . $_SESSION['shipping'] .  "</span></strong></td>
	</tr>
	<tr style='color:red;'>
		<td class='text-right' colspan='3'><div><label>Galutinė kaina:</label></div></td>
		<td class='text-center'><strong >&euro;<span>" . $full2_price .  "</span></strong></td>
	</tr>
</table>
<p>Banko informacija</p>

";
// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <decorbox@gmail.com>' . "\r\n";

mail($to,$subject,$email,$headers);
//end of email
//echo $email;
*/
$email="";//galima priskirti tas pacias reiksmes is display block

$display_block="";
$display_block="<h2 class='text-center'>$txtorder_success_heading</h2>";
while($user = mysqli_fetch_assoc($select_user_info_res)){//buvo array
	$user_name=$user['order_name'];
	$user_address = $user['order_address'];
	$user_country = $user['country'];
	$user_city = $user['order_city'];
	$user_zip = $user['order_zip'];
	$user_tel = $user['order_tel'];
	$user_email = $user['order_email'];
	$shipping_total = $user['shipping_total'];


$display_block.="
	<div class='row'>
		<div class='col-md-6'>
			<div class='row border-color'>
				<div class='col-md-12 text-center'>
					<label>$txtorder_success_delivery_heading</label>
				</div>

			</div>
			<div class='row'>
				<Label class='col-md-5'>$txtinput_name:</label>
				<div class='col-md-7'><p> $user_name</p>
				</div>
			</div>

			<div class='row'>
				<Label class='col-md-5'>$txtaddress:</label>
				<div class='col-md-7'><p> $user_address</p>
				</div>
			</div>

			<div class='row'>
				<Label class='col-md-5'>$txtcity:</label>
				<div class='col-md-7'><p> $user_city</p>
				</div>
			</div>

			<div class='row'>
				<Label class='col-md-5'>$txtzip:</label>
				<div class='col-md-7'><p> $user_zip</p>
				</div>
			</div>

			<div class='row'>
				<Label class='col-md-5'>$txtcountry:</label>
				<div class='col-md-7'><p> $user_country</p>
				</div>
			</div>

			<div class='row'>
				<Label class='col-md-5'>$txtphone:</label>
				<div class='col-md-7'><p> $user_tel</p>
				</div>
			</div>
			<div class='row'>
				<Label class='col-md-5'>$txtemail:</label>
				<div class='col-md-7'><p> $user_email</p>
				</div>
			</div>
		</div>

		<div class='col-md-6'>
			<div class='row border-color'>
				<div class='col-md-12 text-center'>
					<label>$txtpayment_info</label>
				</div>

			</div>

			<div class='row'>
				<Label class='col-md-5 '>$txtrecipient:</label>
				<div class='col-md-7'><p> MB „Viskas jūsų šventei“ </p>
				</div>
			</div>

			<div class='row'>
				<Label class='col-md-5'>$txtbank_number:</label>
				<div class='col-md-7'><p> LT077300010142612531</p>
				</div>
			</div>

			<div class='row'>
				<Label class='col-md-5'>$txtpayment_purpose:</label>
				<div class='col-md-7'><p> $txtorder Nr. $order_id $txtpayment</p>
				</div>
			</div>

			<div class='row'>
				<Label class='col-md-5'>$txtpayment_order:</label>
				<div class='col-md-7'><p>$shipping_total &euro;</p>
				</div>
			</div>
		</div>
	</div>	

	<div class='row'>
		<div class='col-md-12 border-color text-center'>
	<label>$txtitem_info</label>
		</div>
	<div>	
	<div class='row'>";
	}
	$get_cart_email_sql = "SELECT st.order_id, si.item_title, si.item_title_EN , si.item_price, si.id, st.item_qty FROM
	store_orders_items_item AS st LEFT JOIN store_items AS si ON si.id = st.item_id WHERE order_id ='".$order_id."'";
$get_cart_email_res = mysqli_query($mysqli, $get_cart_email_sql) or die(mysqli_error($mysqli));

$display_block .= "

		<table class='table table-bordered table-condensed'>
			<tr>
				<th class='text-center'>$txttitle</th>
				<th class='text-center'>$txtprice</th>
				<th class='text-center'>$txtqty</th>
				<th class='text-center'>$txtsum</th>
			</tr>";


		// info is shoppertrack
		$full2_qty=0;
		$full2_price=0;
		while ($cart2_info = mysqli_fetch_array($get_cart_email_res)) {
		$item2_id = $cart2_info['id'];//nenaudojamas

		if(isset($_GET['lang']) && $_GET['lang']=='LT'){
        	$item2_title = stripslashes($cart2_info['item_title']);
	    }else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
	        $item2_title = stripslashes($cart2_info['item_title_EN']);
	    }else{
	        $item2_title = stripslashes($cart2_info['item_title']);
	    }
		
		$item2_price = $cart2_info['item_price'];
		$item2_qty = $cart2_info['item_qty'];
		$full2_qty =  $full2_qty + $item2_qty;
		$total2_price = sprintf("%.02f", $item2_price * $item2_qty);
		$full2_price = sprintf("%.02f", $full2_price+$total2_price); //galutine kaina

//TABLE DATA
	$display_block .= "
	<tr class='text-center'>
		<td><p>$item2_title</p></td>
		<td><p>$item2_price &euro;</p></td>
		<td><p>$item2_qty</p></td>
		<td><p>$total2_price &euro;</p></td>
	</tr>";

	
	}//end of while
	$shipping = 0;

//jei yra siuntimas i uzsienio salis pridet kaina uzsienyje
	if(isset($_COOKIE['europeShip'])){
		$shipping += $_SESSION['shippingEuropean'];
	}else{//jei i lietuva pridet lietuvos kaina
		if($full2_price<$_SESSION['totalShippingPrice']){
			$shipping += $_SESSION['shipping'];
		}
	}

$display_block.="
	<tr style='color:red;'>
		<td class='text-right' colspan='3'><div><label>$txtdelivery:</label></div></td>
		<td class='text-center'><p><strong><span>" . $shipping .  "</span>&euro;</strong></p></td>
	</tr>
	<tr style='color:red;'>
		<td class='text-right' colspan='3'><div><label>$txtfull_price:</label></div></td>
		<td class='text-center'><p><strong ><span>" . ($full2_price + $shipping) .  "</span>&euro;</strong></p></td>
	</tr>
</table>
<div class='row'>
	<div class='col-md-offset-9 col-md-3'>
		<a href='index.php?lang=".$_GET['lang']."' role='button' class='btn btn-primary'>$txtback_to_mainpage</a>
	</div>
</div>";

unset($_SESSION['order_id']);
unset($_SESSION['sel_item_id']);
unset($_SESSION['name']);
unset($_SESSION['email']);
unset($_SESSION['address']);
unset($_SESSION['city']);
unset($_SESSION['tel']);
unset($_SESSION['zip']);


$delete_temp_order_id = "UPDATE store_orders SET order_id = NULL WHERE id='".$order_id."'";//make temp order id to NULL
$delete_temp_order_id_res = mysqli_query($mysqli, $delete_temp_order_id);

?>

<!DOCTYPE HTML>
<html>

<body>
<div class="container">
	<?php 
	include 'header.php';
	include 'navbar.php'; ?>

	<div class="row">
		<div class="col-md-12 border-color margin-bottom60">	<!--body-->
			
			<?php echo $display_block; ?>
			
		</div>
	</div>
</div>


</body>
</html>

