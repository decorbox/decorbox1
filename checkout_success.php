<?php 
session_start();
include 'connect.php';
include 'library.php';
$order_id= $_COOKIE['order_id'];
print_r($_COOKIE);
print_r($_SESSION);

$select_user_info="SELECT * FROM store_orders WHERE order_id='".$order_id."'";
$select_user_info_res= mysqli_query($mysqli, $select_user_info);

$display_block="";
$display_block="<h2 class='text-center'>Jūsų užsakymas sėkmingai priimtas. Ačiū kad perkate pas mus!</h2>";
while($user = mysqli_fetch_assoc($select_user_info_res)){//buvo array
	$user_name=$user['order_name'];
	$user_address = $user['order_address'];
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
					<label>Siuntimo informacija1</label>
				</div>

			</div>
			<div class='row'>
				<Label class='col-md-5 '>Vardas ir pavardė:</label>
				<div class='col-md-7'> $user_name <br>
				</div>
			</div>
			<div class='row'>
				<Label class='col-md-5'>Adresas:</label>
				<div class='col-md-7'> $user_address <br>
				</div>
			</div>
			<div class='row'>
				<Label class='col-md-5'>Miestas:</label>
				<div class='col-md-7'> $user_city <br>
				</div>
			</div>
			<div class='row'>
				<Label class='col-md-5'>Pašto kodas:</label>
				<div class='col-md-7'> $user_zip <br>
				</div>
			</div>
			<div class='row'>
				<Label class='col-md-5'>Telefono Nr.:</label>
				<div class='col-md-7'> $user_tel <br>
				</div>
			</div>
			<div class='row'>
				<Label class='col-md-5'>El. Paštas:</label>
				<div class='col-md-7'> $user_email <br>
				</div>
			</div>
		</div>

		<div class='col-md-6'>
			<div class='row border-color'>
				<div class='col-md-12 text-center'>
					<label>Apmokėjimo informacija</label>
				</div>

			</div>

			<div class='row'>
				<Label class='col-md-5 '>Gavėjas:</label>
				<div class='col-md-7'> Decorbox <br>
				</div>
			</div>

			<div class='row'>
				<Label class='col-md-5'>Sąskaitos numeris:</label>
				<div class='col-md-7'> LT55555555(SwedBank) <br>
				</div>
			</div>

			<div class='row'>
				<Label class='col-md-5'>Mokėjimo paskirtis:</label>
				<div class='col-md-7'> $order_id <br>
				</div>
			</div>

			<div class='row'>
				<Label class='col-md-5'>Mokėjimo suma:</label>
				<div class='col-md-7'>&euro; $shipping_total <br>
				</div>
			</div>

			<div class='row'>
				<Label class='col-md-5'>Įmonės kodas:</label>
				<div class='col-md-7'> 548481 <br>
				</div>
			</div>
		</div>
	</div>	

	<div class='row'>
		<div class='col-md-12 border-color text-center'>
	<label>Prekės informacija</label>
		</div>
	<div>	
	<div class='row'>";
	}
	$get_cart_email_sql = "SELECT st.order_id, si.item_title, si.item_price, si.id, st.item_qty FROM
	store_orders_items_item AS st LEFT JOIN store_items AS si ON si.id = st.item_id WHERE order_id ='".$order_id."'";
$get_cart_email_res = mysqli_query($mysqli, $get_cart_email_sql) or die(mysqli_error($mysqli));

$display_block .= "

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
		$item2_qty = $cart2_info['item_qty'];
		$full2_qty =  $full2_qty + $item2_qty;
		$total2_price = sprintf("%.02f", $item2_price * $item2_qty);
		$full2_price = sprintf("%.02f", $full2_price+$total2_price); //galutine kaina

//TABLE DATA
	$display_block .= "
	<tr class='text-center'>
		<td>$item2_title</td>
		<td>&euro; $item2_price</td>
		<td>$item2_qty</td>
		<td>&euro; $total2_price </td>
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
		<td class='text-right' colspan='3'><div><label>Siuntimo kaina:</label></div></td>
		<td class='text-center'><strong>&euro;<span>" . $shipping .  "</span></strong></td>
	</tr>
	<tr style='color:red;'>
		<td class='text-right' colspan='3'><div><label>Galutinė kaina:</label></div></td>
		<td class='text-center'><strong >&euro;<span  id='all-total'>" . ($full2_price + $shipping) .  "</span></strong></td>
	</tr>
</table>
<div class='row'>
	<div class='col-md-offset-9 col-md-3'>
		<a href='index.php' role='button' class='btn btn-primary'>Grįžkite į pagrindinį puslapį</a>
	</div>
</div>";
//unset($_SESSION['']);

?>

<!DOCTYPE HTML>
<html>

<body>
<div class="container">
	<div class="row"><!-- header-->
		<div class="col-md-12 border-color">
			<h1>Header</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 border-color">	<!--body-->
			
			<?php echo $display_block; ?>
			
		</div>
	</div>
</div>


</body>
</html>

