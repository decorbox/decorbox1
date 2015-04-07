<?php 
ob_start();
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

$safe_sel_item_authorization = $_COOKIE['PHPSESSID']; //reikia vartotojo login arba session id kai nesiregistruoja
//$item_total_price= $_SESSION['full_price']; // ir total_qty suskaiciuot
//select order_id from database
	$get_order_id_sql = "SELECT id FROM store_shoppertrack WHERE session_id = '".$_COOKIE['PHPSESSID']."'";
	$run_order_id_res = mysqli_query($mysqli, $get_order_id_sql) or die(mysqli_error($mysqli));
	while($info = mysqli_fetch_array( $run_order_id_res)) 	 
 		{ 
 			$order_id = $info['id'];
 		} 
 	//setcookie("order_id", $order_id); //perduoda i checkout success

 	$get_cart_sql1 = "SELECT st.order_id, si.item_title, si.item_title_EN, si.item_price, si.id, st.sel_item_qty FROM
	store_shoppertrack_items AS st LEFT JOIN store_items AS si ON si.id = st.sel_item_id WHERE order_id ='".$order_id."'";
	$get_cart_res1 = mysqli_query($mysqli, $get_cart_sql1) or die(mysqli_error($mysqli));

	$full_price1=0;
	$totalShippingPrice = $_SESSION['totalShippingPrice'];//gauna max kaina nuo kurios nereik moket shipping
	$full_qty1=0;
	while ($cart1_info = mysqli_fetch_array($get_cart_res1)) {
		$item_id1 = $cart1_info['id'];//nenaudojamas
		//$item_title = stripslashes($cart1_info['item_title']);
		//$item_price1 = $item_price1 + $_POST["price$item_id1"];
		$item_qty1 = $cart1_info['sel_item_qty'];
		$full_qty1 =  $full_qty1 + $item_qty1;
		$total_price1 = sprintf("%.02f", $cart1_info['item_price'] * $cart1_info['sel_item_qty']);
		$full_price1 = sprintf("%.02f", $full_price1+$total_price1);

	}

	//jei yra siuntimas i uzsienio salis pridet kaina uzsienyje
	if(isset($_COOKIE['europeShip'])){
		$full_price1 += $_SESSION['shippingEuropean'];
	}else{//jei i lietuva pridet lietuvos kaina
		if($full_price1<$totalShippingPrice){
			$full_price1 += $_SESSION['shipping'];
		}
	}

 	

//$item_total_price = $full_price1;
//$shipping_total =0;
$shipping_total = $full_price1;//prideti skaiciu galima tai bus- siuntimo kaina

//$full_qty = $_POST['full_qty'];
//$item_total_qty= $_SESSION['full_qty']; //$_POST['item_total'];
setcookie("full_qty", $full_qty1);
$item_total_qty = $full_qty1;


$display_block = "
<ol class='breadcrumb'>
  <li><a href='index.php?lang=".$_GET['lang']."'>$txtmain_page</a></li>
  <li><a href='showcart.php?lang=".$_GET['lang']."'>$txtshopping_cart</a></li>
  <li class='active'>$txtsending</li>
</ol>";
//$iraso=false;//iduom baze

// ir sql pakeist i login id
$input_error=false;
//start input validation
// define variables and set to empty values
$nameErr = $phoneErr = $zipErr =$emailErr = $addressErr=$cityErr= "";
$name = $email= $address =$city= $tel = $country =$zip= "";


$_SESSION['name'] = $name;
$_SESSION['email'] = $email;
$_SESSION['address'] = $address;
$_SESSION['city'] = $city;
$_SESSION['tel'] = $tel;
$_SESSION['zip'] = $zip;
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (isset($_POST['submitForm'])){//tikrina ar nera tusciu lauku jei yra meta klaida
	


	if(!empty($_POST['country'])){
		$country = $_POST['country'];
	}
	if(!empty($_POST['address'])){
		$address = test_input($_POST['address']);
		$_SESSION['address'] = $address;// kad formoj liktu reiksmes po rr	
	}

	if(!empty($_POST['city'])){
		$city = test_input($_POST['city']);	
		$_SESSION['city']= $city;
	}	
	
    if (!empty($_POST['name'])) {
	    $name = test_input($_POST['name']);
	    $_SESSION['name'] = $name;//kad kai reflesinu puslapi formoj liktu reiksmes jei butu error
    // check if name only contains letters and whitespace

    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
    	
       $nameErr = "<div class='alert alert-danger alert-dismissible' role='alert'>
 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
 		<p>$txterror_only_letters</p>
		</div>"; 
		$input_error=true;
     	}
   	}

   	if (!empty($_POST['city'])) {
    	$city = test_input($_POST['city']);
    	$_SESSION['city'] = $city;
     	// check if name only contains letters and whitespace
    	if (!preg_match("/^[a-zA-Z ]*$/",$city)) {
	        $cityErr = "<div class='alert alert-danger alert-dismissible' role='alert'>
	 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	 		<p>$txterror_only_letters</p>
			</div>"; 
			$input_error=true;
     		}
   		}
   	
  	if (!empty($_POST['email'])) {
	    $email = test_input($_POST['email']);
	    $_SESSION['email'] = $email;
	    // check if e-mail address is well-formed
	    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	       $emailErr = "
	        <div class='alert alert-danger alert-dismissible' role='alert'>
	 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	 		<p>$txterror_email</p>
			</div>";
			$input_error=true;
	       //$emailErr = "Invalid email format"; 
	     	}
	   }
	if(!empty($_POST['tel'])){
			$tel = test_input($_POST['tel']); 
			$_SESSION['tel'] = $tel;
		    if(!preg_match("/^(([\+]?370)|(8))[\s-]?\(?[0-9]{2,3}\)?[\s-]?([0-9]{2}[\s-]?){2}?[0-9]{1,2}$/", $tel)) {
		 		$phoneErr = "
		 		<div class='alert alert-danger alert-dismissible' role='alert'>
		 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
		 		<p>$txterror_phone</p>
				</div>";
				$input_error=true;
				}
				
			}	 
	if(!empty($_POST['zip'])){
			$zip = test_input($_POST['zip']);
			$_SESSION['zip'] = $zip;
			if(!preg_match("#[0-9]{5}#", $zip)) {
		 		$zipErr = "
		 		<div class='alert alert-danger alert-dismissible' role='alert'>
		 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
		 		<p>$txterror_zip</p>
				</div>";
				$input_error=true;

				}	
			}
}//end request method post


function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
// end input validation

if(isset($_POST['submitForm'])){// TEST JEI neuzpildyta

	if($input_error!=true){// jei nera input error iraso i duombaze
		
 	$delete_error = "UPDATE store_orders SET order_id = NULL WHERE order_id != 'NULL' ";//sometimes doublicates order id reason: sometimes after delete store_stoppertrack when order is submited
		$delete_error_res = mysqli_query($mysqli, $delete_error) or die(mysqli_error($mysqli));	//temporary order_id(shoppertrack id) resets value from 1 		


	$sql = "INSERT INTO store_orders (authorization, item_total, order_address, order_city, order_date, order_email,
		order_name, order_tel, order_zip, shipping_total, order_id,status, country) VALUES ('-Neregistruotas-', 
											
		'".(int)$item_total_qty."',
		'".$address."',
		'".$city."',
		now(),
		'".$email."',
		'".$name."',
		'".$tel."',
		'".$zip."',
		'".$shipping_total."',
		'".$order_id."',
		'2',
		'".$country."')";

	$write_in_db = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

	$get_real_order_id = "SELECT id FROM store_orders where order_id = '".$order_id."'";
	$get_real_order_id_res = mysqli_query($mysqli, $get_real_order_id) or die(mysqli_error($mysqli));
	$get_real_order_id_fetch = mysqli_fetch_assoc($get_real_order_id_res);
	$real_order_id = $get_real_order_id_fetch['id'];//tikras order id is store orders
	setcookie("order_id", $real_order_id); //perduoda i checkout success

	$insert_orders_items = "INSERT INTO store_orders_items (order_id, sel_item_qty, sel_item_price) VALUES ('".$real_order_id."', '".$item_total_qty."', '".$shipping_total."')";
 	$insert_orders_items_res = mysqli_query($mysqli, $insert_orders_items) or die(mysqli_error($mysqli));
//ikopijuota
	$get_cart_sql = "SELECT st.order_id, si.item_title, si.item_price, si.id, st.sel_item_qty, st.sel_item_id FROM
	store_shoppertrack_items AS st LEFT JOIN store_items AS si ON si.id = st.sel_item_id WHERE order_id ='".$order_id."'";
$get_cart_res1 = mysqli_query($mysqli, $get_cart_sql) or die(mysqli_error($mysqli));

//jei checkout irasom naujus uzsakymo duomenis


	//istrinam praeitus duomenis siame uzsakyme
	$delete_previous_sql = "DELETE FROM store_orders_items_item WHERE order_id ='".$real_order_id."'";
	mysqli_query($mysqli, $delete_previous_sql) or die(mysqli_error($mysqli));

	//irasome is naujos visus
	while ($cart_info1 = mysqli_fetch_array($get_cart_res1)) {

		$add_item_sql = "INSERT INTO store_orders_items_item
	        (order_id, item_id, item_qty, item_price) VALUES ('".$real_order_id."',
	        '".$cart_info1['sel_item_id']."',
	        '".$cart_info1['sel_item_qty']."',
	        '".$cart_info1['item_price'] * $cart_info1['sel_item_qty']."')";
	    $add_item_res = mysqli_query($mysqli, $add_item_sql) or die(mysqli_error($mysqli));

	}//end of main while

	

	//delete items from shoppertrack when order is completed
	$delete_shoppertrack_tems = "DELETE FROM store_shoppertrack_items WHERE order_id ='".$order_id."'";
	$delete_items_rez = mysqli_query($mysqli, $delete_shoppertrack_tems);

	$delete_compeleted_items_sql = "DELETE FROM store_shoppertrack WHERE session_id = '".$_COOKIE['PHPSESSID']."' ";
	$delete_rez = mysqli_query($mysqli, $delete_compeleted_items_sql);

	unset($_COOKIE[$name]);
	unset($_COOKIE[$email]);//isima cookies kad einant antra karta ir spaudus submit ant tusciu lauku rodytu klaidas
	unset($_COOKIE[$address]);
	unset($_COOKIE[$tel]);
	unset($_COOKIE[$zip]);
	unset($_COOKIE[$city]);

	header("Location: checkout_success.php?lang=".$_GET['lang']."");
	//header("Location: test.php?lang=".$_GET['lang']."");
	}
}

//delete zero values in database
/* GERAS
$delete_orders_zero_sql = "DELETE FROM store_orders WHERE order_name = '' AND order_address='' AND order_email='' ";
$delete_orders_zero_res = mysqli_query($mysqli, $delete_orders_zero_sql) or die(mysqli_error($mysqli)); 
*/


 ?>


<!DOCTYPE HTML>
<html>

<body>
<div class="container">
	<script type="text/javascript">
		$(document).ready(function() {
		  	$(".selectOption").select2({ minimumResultsForSearch: Infinity });//run sorting, INFINITY PASLEPE SEARCH BAR
		});
		</script>
	<?php 
	include 'header.php';
	include 'navbar.php'; ?>
			
	

	<div class="row">
		<div class="col-md-12 border-color">	<!--body-->
		<?php echo $display_block;
		//echo $email;
		 
		 ?>

			<div class="row">
				<div class="col-md-5 border-color">
					<h4 class="text-center"><?php echo $txtbuy_register_user; ?> <hr></h4>
					
					<!--<?php echo $display_login?>-->
					<?php include "loginCheckout.php" ?>

				</div>

				<div class="col-md-7 border-color"><!--formos ilgis-->

					<form class="form-horizontal" method="post" action="<?php $_SERVER['PHP_SELF']."?lang=".$_GET['lang']."" ?>">
						<div class="form-group">
							<div class="row margin-top">
							<h4 class="text-center"><?php echo $txtbuy_nonregister_user; ?> <hr></h4>
								<label for="inputName3" class="col-md-5 control-label"><?php echo $txtinput_name; ?><span style='color: red; padding-left: 2px;'>*</span></label>
								<div class="col-md-7">
									<input type="text" name="name" required value="<?php echo $_SESSION['name'];?>" class="form-control" id="inputName3" placeholder="<?php echo $txtinput_name; ?>">							
									<span class="error"><?php echo $nameErr;?></span>
								</div>
							</div>

							<div class="row margin-top">	
								<label for="inputAddress3" class="col-md-5 control-label"><?php echo $txtaddress; ?><span style='color: red; padding-left: 2px;'>*</span></label>
								<div class="col-md-7">
									<input type="text" required name="address" value="<?php echo $_SESSION['address']; ?>" class="form-control" id="inputAddress3" placeholder="<?php echo $txtaddress; ?>">
									<span class="error"><?php echo $addressErr;?></span>
								</div>
							</div>

							<div class="row margin-top">	
								<label for="inputCity3" class="col-md-5 control-label"><?php echo $txtcity; ?><span style='color: red; padding-left: 2px;'>*</span></label>
								<div class="col-md-7">
									<input type="text" required name="city" value="<?php echo $_SESSION['city']; ?>" class="form-control" id="inputCity3" placeholder="<?php echo $txtcity; ?>">
									<span class="error"><?php echo $cityErr;?></span>
								</div>
							</div>	

							<div class="row margin-top">	
								<label for="inputZip3" class="col-md-5 control-label"><?php echo $txtzip; ?><span style='color: red; padding-left: 2px;'>*</span></label>
								<div class="col-md-7">
									<input type="text"  name="zip" required value="<?php echo $_SESSION['zip']; ?>" class="form-control" id="inputZip3" placeholder="<?php echo $txtzip; ?>">
									<span class="error"><?php echo $zipErr;?></span>
								</div>
							</div>

							<div class="row margin-top">	
								<label for="inputCity3" class="col-md-5 control-label"><?php echo $txtcountry; ?><span style='color: red; padding-left: 2px;'>*</span></label>
								<div class="col-md-7">
									<select class='selectOption ' required style='width:100%'  name='country'>>
									<?php 

									$get_cat = "SELECT * FROM countries";
									$get_cat_rs= mysqli_query($mysqli, $get_cat);
										echo "<option value='Lithuania'>Lithuania</option>";
									while($info = mysqli_fetch_array($get_cat_rs)){
										$id=$info['id'];
										$title=$info['country'];
										if($id!=15){//jei ne lietuvos ID
											echo "<option value='".$title."'>$title</option>";
										}
									}

									?>
									</select>									
								</div>
							</div>	

							<div class="row margin-top">	
								<label for="inputPhone3" class="col-md-5 control-label"><?php echo $txtphone; ?><span style='color: red; padding-left: 2px;'>*</span></label>
								<div class="col-md-7">
									<input type="text" name="tel" required value="<?php echo $_SESSION['tel']; ?>" class="form-control" id="inputPhone3" placeholder="<?php echo $txtphone; ?>">
									<span class="error"><?php echo $phoneErr;?></span>
								</div>
							</div>

							<div class="row margin-top">	
								<label for="inputEmail3" class="col-md-5 control-label"><?php echo $txtemail; ?><span style='color: red; padding-left: 2px;'>*</span></label>
								<div class="col-md-7">
									<input type="email" name="email" required value="<?php echo $_SESSION['email']; ?>" class="form-control" id="inputEmail3" placeholder="<?php echo $txtemail; ?>">
									<span class="error"><?php echo $emailErr;?></span>
								</div>
							</div>	
								
							<div class="row">
								<Label class="col-md-5 control-label"><?php echo $txtfull_price; ?>:</label>
								<div class="col-md-7 margin-top"><label><?php echo $shipping_total ?>&euro;</label>
								</div>
							</div>
							<div class="row margin-top">
								<div class="col-md-1 col-md-offset-8">
									<button type="submit" value"Submit" name="submitForm" class="btn btn-primary"><?php echo $txtorder_nonregister_user; ?></button>
								</div>
							</div>
						</div>
					</form>
				</div> <!-- end of form	input-->
			</div>
		</div>

			
	</div>
</div>


</body>
</html>
