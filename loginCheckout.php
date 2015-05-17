<?php 
//http://php.about.com/od/finishedphp1/ss/php_login_code.htm
//Connects to your Database 
ob_start();
include 'connect.php';

if(isset($_GET['lang']) && $_GET['lang']=='LT'){
        include 'content_LT.php';
    }else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
        include 'content_EN.php';
    }else{
        include 'content_LT.php';
    }

$passErr = $userErr = '';
 
if(isset($_COOKIE['ID_my_site']))
 //if there is, it logs you in and directes you to the members page
 { 
 	$username = $_COOKIE['ID_my_site']; 
 	$pass = $_COOKIE['Key_my_site'];

 	$check = mysqli_query($mysqli, "SELECT * FROM users WHERE username = '$username'")or die(mysqli_error());
 }//if the login form is submitted 

else if (isset($_POST['submitLog'])) { // if form has been submitted
	 // makes sure they filled it in

	if(!$_POST['username'] | !$_POST['pass']) {
		echo "<div class='alert alert-danger alert-dismissible' role='alert'>
		 	<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
		 	<p>$txterror_fill_all_fields</p>
			</div>";
	 	}

	 // checks it against the database
	if (!get_magic_quotes_gpc()) {
	 		$_POST['username'] = addslashes($_POST['username']);
	 	}
	$check = mysqli_query($mysqli,"SELECT * FROM users WHERE username = '".$_POST['username']."'")or die(mysqli_error());

	//Gives error if user dosen't exist
	$check2 = mysqli_num_rows($check);
	

	if ($check2 == 0) {
	 		$userErr = "<div class='alert alert-danger alert-dismissible' role='alert'>
		 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
		 		<p>$txterror_user_not_exist</p>
				</div>";
	 	}
	
	$info = mysqli_fetch_array( $check );
	$_POST['pass'] = stripslashes($_POST['pass']);
	$info['password'] = stripslashes($info['password']);
 	$_POST['pass'] = md5($_POST['pass']);

	 	if ($_POST['pass'] != $info['password']) {
	 		$passErr = "<div class='alert alert-danger alert-dismissible' role='alert'>
		 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
		 		<p>$txterror_pass</a></p>
				</div>";

	 	}
		 else 
		 	{ 
		 		
			 // if login is ok then we add a cookie 
			$_POST['username'] = stripslashes($_POST['username']); 
			//$hour = time() + 360000;  
			setcookie('ID_my_site', $_POST['username']); 
			setcookie('Key_my_site', $_POST['pass']);
			//then redirect them to the members area 
			//header("Location: members.php"); 
			//include 'members.php';
			echo("<meta http-equiv='refresh' content='0'>"); //Refresh page nes kai prijungi iskart nerodo user meniu reikia reflesh
		//https://www.daniweb.com/web-development/php/threads/69676/error-use-of-undefined-constant-help

	 		}
	//end of while check 

} //end of, if form submitted


if(isset($_COOKIE['ID_my_site'])){
	
	
	$sql = "SELECT * FROM users WHERE username = '$username' ";
	$user_info_res = mysqli_query($mysqli, $sql) or die(mysql_error($mysqli));
	while ($user_info = mysqli_fetch_array($user_info_res)) {
		$vardas= $user_info['name'];
		$adresas= $user_info['address'];
		$country = $user_info['country'];
		$city= $user_info['city'];
		$zip= $user_info['zip'];
		$phone= $user_info['phone'];
		$email= $user_info['email'];
	}
	
$shipping_total_login = $shipping_total;
	$get_order_id_sql = "SELECT id FROM store_shoppertrack WHERE session_id = '".$_COOKIE['PHPSESSID']."'";
	$run_order_id_res = mysqli_query($mysqli, $get_order_id_sql) or die(mysqli_error($mysqli));
	while($info = mysqli_fetch_array( $run_order_id_res)) 	 
 		{ 
 			$order_id = $info['id'];
 		} 
 		//setcookie("order_id", $order_id); //perduoda i checkout success

	if(isset($_POST['submitLogin'])){
		
		$delete_error = "UPDATE store_orders SET order_id = NULL WHERE order_id != 'NULL' ";//sometimes doublicates order id reason: sometimes after delete store_stoppertrack when order is submited
		$delete_error_res = mysqli_query($mysqli, $delete_error) or die(mysqli_error($mysqli));	//temporary order_id(shoppertrack id) resets value from 1 		
		$sql = "INSERT INTO store_orders (authorization, item_total, order_address, order_city, order_date, order_email,
		order_name, order_tel, order_zip, shipping_total, order_id,status, country) VALUES ('".$username."', 
											
		'".$_COOKIE['full_qty']."',
		'".$adresas."',
		'".$city."',
		now(),
		'".$email."',
		'".$vardas."',
		'".$phone."',
		'".$zip."',
		'".$shipping_total_login."',
		'".$order_id."',
		'2',
		'".$country."')";
/*shipping total galima idet - siuntimo kaina*/
	$write_in_db = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

	$get_real_order_id = "SELECT id FROM store_orders where order_id = '".$order_id."'";
	$get_real_order_id_res = mysqli_query($mysqli, $get_real_order_id) or die(mysqli_error($mysqli));
	$get_real_order_id_fetch = mysqli_fetch_assoc($get_real_order_id_res);
	$real_order_id = $get_real_order_id_fetch['id'];//tikras order id is store orders
	setcookie("order_id", $real_order_id); //perduoda i checkout success

	$insert_orders_items = "INSERT INTO store_orders_items (order_id, sel_item_qty, sel_item_price) VALUES ('".$real_order_id."', '".$_COOKIE['full_qty']."', '".$shipping_total_login."')";
 	$insert_orders_items_res = mysqli_query($mysqli, $insert_orders_items) or die(mysqli_error($mysqli));


	$get_cart_sql = "SELECT st.order_id, si.item_title, si.item_title_EN, si.item_price, si.id, st.sel_item_qty, st.sel_item_id FROM
	store_shoppertrack_items AS st LEFT JOIN store_items AS si ON si.id = st.sel_item_id WHERE order_id ='".$order_id."'";
	$get_cart_res1 = mysqli_query($mysqli, $get_cart_sql) or die(mysqli_error($mysqli));

//jei checkout irasom naujus uzsakymo duomenis


	//istrinam praeitus duomenis siame uzsakyme
	$delete_previous_sql = "DELETE FROM store_orders_items_item WHERE order_id ='".(int)$real_order_id."'";//bandyk unset session id kai nuperku galutinai preke. kad perkant nauja butu nauajs order ID
	mysqli_query($mysqli, $delete_previous_sql) or die(mysqli_error($mysqli));
//IDETI HISTORY LENTELE ir is cia perkelti i history
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
	
	//delete items from shoppertrack when order is completed
	$delete_compeleted_items_sql = "DELETE FROM store_shoppertrack WHERE session_id = '".$_COOKIE['PHPSESSID']."' ";
	$delete_rez = mysqli_query($mysqli, $delete_compeleted_items_sql);
	header("Location: checkout_success.php?lang=".$_GET['lang'].""); //kai login submit permeta i kita puslapi
	
	} 
//user info
	echo"
	<div class='row'>
			<Label class='col-md-7'>$txtinput_name:</label>
			<div class='col-md-5'><p> $vardas </p>
			</div>
		</div>

		<div class='row'>
			<Label class='col-md-7'>$txtaddress:</label>
			<div class='col-md-5'><p> $adresas </p>
			</div>
		</div>

		<div class='row'>
			<Label class='col-md-7'>$txtcity:</label>
			<div class='col-md-5'><p> $city </p>
			</div>
		</div>

		<div class='row'>
			<Label class='col-md-7'>$txtzip:</label>
			<div class='col-md-5'><p> $zip </p>
			</div>
		</div>

		<div class='row'>
			<Label class='col-md-7'>$txtcountry:</label>
			<div class='col-md-5'><p> $country </p>
			</div>
		</div>

		<div class='row'>
			<Label class='col-md-7'>$txtphone:</label>
			<div class='col-md-5'><p> $phone </p>
			</div>
		</div>
		<div class='row'>
			<Label class='col-md-7'>$txtemail:</label>
			<div class='col-md-5'><p> $email </p>
			</div>
		</div>
		<div class='row'>
			<Label class='col-md-7'>$txtfull_price:</label>
			<div class='col-md-5 '><label>$shipping_total_login &euro;</label>
			</div>
		</div>
		<div class='row'>
			<form method='post' action=".$_SERVER['PHP_SELF']."?lang=".$_GET['lang']. " >
					<div>
						<a href='logoutCheckout.php?lang=".$_GET['lang']."' role='button' class='btn btn-primary pull-left'>$txtlog_out</a>
						<button type='submit' value'Reg' class='btn btn-primary pull-right' name='submitLogin' >$txtorder_items</button>
					</div> </form>
				</div>";
	

}
else {

 ?> 
 <!DOCTYPE HTML>
<html>
<head>
	
</head>
<body>

<div class="row">
	<div class="col-md-12">
		<form class="form-horizontal" action="<?php echo $_SERVER["PHP_SELF"].'?lang='.$_GET["lang"] ; ?>" method="post">
			<div class="form-group">
				<div class="row margin-top">
					<label for="inputUsername3" class="col-md-4 control-label"><?php echo $txtusername; ?></label>
					<div class="col-md-8">
						<input type="text" name="username" class="form-control" id="inputUsername3" placeholder="<?php echo $txtusername; ?>">
							<span class="error"><?php echo $userErr;?></span>
					</div>
				</div>	

				<div class="row margin-top">
					<label for="inputPass3" class="col-md-4 control-label"><?php echo $txtpassword; ?></label>
					<div class="col-md-8">
						<input type="password" name="pass" class="form-control" id="inputPass3" placeholder="<?php echo $txtpassword; ?>">
						<span class="error"><?php echo $passErr;?></span>
					</div>
				</div>
				<div class="row margin-top">
					<div class="pull-right">
						<a href="register.php?lang=<?php echo $_GET['lang'] ?>" role='button' class='btn btn-success'><?php echo $txtregister; ?></a>
						<button type="submit" value"Register" name="submitLog" class="btn btn-success"><?php echo $txtlogin; ?></button>
					</div> 
				</div>
			</div>
		</form>
	</div>

</div>
</body>
</html>
<?php } ?>