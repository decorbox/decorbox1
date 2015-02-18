<?php 
//http://php.about.com/od/finishedphp1/ss/php_login_code.htm
//Connects to your Database 
include 'connect.php';

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
		 	<p>Prašome užpildyti visus laukus</p>
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
		 		<p>Toks vartotojas neegzistuoja prašome <a href=register.php>Užsiregistruoti</a></p>
				</div>";
	 	}
	
	$info = mysqli_fetch_array( $check );
	$_POST['pass'] = stripslashes($_POST['pass']);
	$info['password'] = stripslashes($info['password']);
 	$_POST['pass'] = md5($_POST['pass']);

	 	if ($_POST['pass'] != $info['password']) {
	 		$passErr = "<div class='alert alert-danger alert-dismissible' role='alert'>
		 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
		 		<p>Neteisingai ivestas slaptažodis</a></p>
				</div>";

	 	}
		 else 
		 	{ 
		 		
			 // if login is ok then we add a cookie 
			$_POST['username'] = stripslashes($_POST['username']); 
			$hour = time() + 3600;  
			setcookie('ID_my_site', $_POST['username'], $hour); 
			setcookie('Key_my_site', $_POST['pass'], $hour);
			//then redirect them to the members area 
			//header("Location: members.php"); 
			//include 'members.php';
			echo("<meta http-equiv='refresh' content='0'>"); //Refresh page nes kai prijungi iskart nerodo user meniu reikia reflesh
		//https://www.daniweb.com/web-development/php/threads/69676/error-use-of-undefined-constant-help

	 		}
	//end of while check 

} //end of, if form submitted


if(isset($_COOKIE['ID_my_site'])){
	
	echo "Tavo siuntimo informacija: <hr>";
	$sql = "SELECT * FROM users WHERE username = '$username' ";
	$user_info_res = mysqli_query($mysqli, $sql) or die(mysql_error($mysqli));
	while ($user_info = mysqli_fetch_array($user_info_res)) {
		$vardas= $user_info['name'];
		$adresas= $user_info['address'];
		$city= $user_info['city'];
		$zip= $user_info['zip'];
		$phone= $user_info['phone'];
		$email= $user_info['email'];
	}

	$get_order_id_sql = "SELECT id FROM store_shoppertrack WHERE session_id = '".$_COOKIE['PHPSESSID']."'";
	$run_order_id_res = mysqli_query($mysqli, $get_order_id_sql) or die(mysqli_error($mysqli));
	while($info = mysqli_fetch_array( $run_order_id_res)) 	 
 		{ 
 			$order_id = $info['id'];
 		} 

	if(isset($_POST['submitLogin'])){
		
		$insert_orders_items = "INSERT INTO store_orders_items (order_id, sel_item_qty, sel_item_price) VALUES ('".$order_id."', '".$_SESSION['full_qty']."', '".$shipping_total."')";
 		$insert_orders_items_res = mysqli_query($mysqli, $insert_orders_items) or die(mysqli_error($mysqli));
		
		$sql = "INSERT INTO store_orders (authorization, item_total, order_address, order_city, order_date, order_email,
		order_name, order_tel, order_zip, shipping_total, order_id,status) VALUES ('".$username."', 
											
		'".$_SESSION['full_qty']."',
		'".$adresas."',
		'".$city."',
		now(),
		'".$email."',
		'".$vardas."',
		'".$phone."',
		'".$zip."',
		'".$shipping_total."',
		'".$order_id."',
		'2')";
/*shipping total galima idet - siuntimo kaina*/
	$write_in_db = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

	$get_cart_sql = "SELECT st.order_id, si.item_title, si.item_price, si.id, st.sel_item_qty, st.sel_item_id FROM
	store_shoppertrack_items AS st LEFT JOIN store_items AS si ON si.id = st.sel_item_id WHERE order_id ='".$order_id."'";
	$get_cart_res1 = mysqli_query($mysqli, $get_cart_sql) or die(mysqli_error($mysqli));

//jei checkout irasom naujus uzsakymo duomenis


	//istrinam praeitus duomenis siame uzsakyme
	$delete_previous_sql = "DELETE FROM store_orders_items_item WHERE order_id ='".(int)$order_id."'";//bandyk unset session id kai nuperku galutinai preke. kad perkant nauja butu nauajs order ID
	mysqli_query($mysqli, $delete_previous_sql) or die(mysqli_error($mysqli));
//IDETI HISTORY LENTELE ir is cia perkelti i history
	//irasome is naujos visus
	while ($cart_info1 = mysqli_fetch_array($get_cart_res1)) {

		$add_item_sql = "INSERT INTO store_orders_items_item
	        (order_id, item_id, item_qty, item_price) VALUES ('".$order_id."',
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
	header('Location: checkout_success.php'); //kai login submit permeta i kita puslapi
	} 
//user info
	echo"
	<div class='row'>
			<Label class='col-md-6'>Vardas ir pavardė:</label>
			<div class='col-md-6'> $vardas <br>
			</div>
		</div>
		<div class='row'>
			<Label class='col-md-6'>Adresas:</label>
			<div class='col-md-6'> $adresas <br>
			</div>
		</div>
		<div class='row'>
			<Label class='col-md-6'>Miestas:</label>
			<div class='col-md-6'> $city <br>
			</div>
		</div>
		<div class='row'>
			<Label class='col-md-6'>Pašto kodas:</label>
			<div class='col-md-6'> $zip <br>
			</div>
		</div>
		<div class='row'>
			<Label class='col-md-6'>Telefono Nr.:</label>
			<div class='col-md-6'> $phone <br>
			</div>
		</div>
		<div class='row'>
			<Label class='col-md-6'>El. Paštas:</label>
			<div class='col-md-6'> $email <br>
			</div>
		</div>
		<div class='row'>
			<Label class='col-md-6'>Galutinė suma:</label>
			<div class='col-md-6 '>&euro; $shipping_total<br>
			</div>
		</div>
		<div class='row'>
			<form method='post'action=".$_SERVER['PHP_SELF']. " >
					<div>
						<button type='submit' value'Reg' class='btn btn-default' name='submitLogin' >Užsakyti</button>
					</div> </form>
				</div>";
	

}
else {

 ?> 
 <!DOCTYPE HTML>
<html>
<head>
	<?php include 'library.php' ?>
</head>
<body>

<div class="row">
	<div class="col-md-12">
		<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<div class="form-group">
				<div class="row margin-top">
					<label for="inputUsername3" class="col-md-4 control-label">Vartotojo vardas</label>
					<div class="col-md-8">
						<input type="text" name="username" class="form-control" id="inputUsername3" placeholder="Prisijungimo vardas">
							<span class="error"><?php echo $userErr;?></span>
					</div>
				</div>	

				<div class="row margin-top">
					<label for="inputPass3" class="col-md-4 control-label">Slaptažodis</label>
					<div class="col-md-8">
						<input type="password" name="pass" class="form-control" id="inputPass3" placeholder="Įveskite slaptažodį">
						<span class="error"><?php echo $passErr;?></span>
					</div>
				</div>
				<div class="row margin-top">
					<div class="col-md-1 col-md-offset-8">
						<button type="submit" value"Register" name="submitLog" class="btn btn-default">Prisijungti</button>
					</div> <!-- padaryt kai submitinu kad rodytu pop up windows http://nakupanda.github.io/bootstrap3-dialog/ -->
				</div>
			</div>
		</form>
	</div>

</div>
</body>
</html>
<?php } ?>