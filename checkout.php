<?php 
session_start();
include 'connect.php';

$safe_sel_item_authorization = $_COOKIE['PHPSESSID']; //reikia vartotojo login arba session id kai nesiregistruoja
$item_total_price= $_SESSION['full_price']; // ir total_qty suskaiciuot
$shipping_total = $item_total_price;//prideti skaiciu galima tai bus- siuntimo kaina
//$full_qty = $_POST['full_qty'];
$item_total_qty= $_SESSION['full_qty']; //$_POST['item_total'];

	
 		

$display_block = "<p><em>You are viewing:</em><br/>
<strong><a href='index.php'>Pagrindinis</a> &gt;
<a href='showcart.php'>krepšelis</a> &gt;
siuntimas</strong></p>";
//$iraso=false;//iduom baze

// ir sql pakeist i login id
$input_error=false;
//start input validation
// define variables and set to empty values
$nameErr = $phoneErr = $zipErr =$emailErr = $addressErr=$cityErr= "";
$name = $email= $address =$city= $tel = $zip= "";
$_SESSION['name'] = $name;
$_SESSION['email'] = $email;
$_SESSION['address'] = $address;
$_SESSION['city'] = $city;
$_SESSION['tel'] = $tel;
$_SESSION['zip'] = $zip;
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (isset($_POST['submitForm'])){//tikrina ar nera tusciu lauku jei yra meta klaida
	


	
	if(empty($_POST['address'])){
		//$addresErr = "Addres is required";
	}
	else{
		$address = test_input($_POST['address']);
		$_SESSION['address'] = $address;// kad formoj liktu reiksmes po rr	
	}

	if(empty($_POST['city'])){
		//$cityErr = "Addres is required";
	}
	else{
		$city = test_input($_POST['city']);	
		$_SESSION['city']= $city;
	}	
	
    if (empty($_POST['name'])) {
     //$nameErr = "Name is required";
   	} else {
    $name = test_input($_POST['name']);
    $_SESSION['name'] = $name;//kad kai reflesinu puslapi formoj liktu reiksmes jei butu error
    // check if name only contains letters and whitespace

    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
    	
       $nameErr = "<div class='alert alert-danger alert-dismissible' role='alert'>
 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
 		<p>Only letters and white space available</p>
		</div>"; 
		$input_error=true;
     	}
   	}

   	if (empty($_POST['city'])) {
     //$cityErr = "Name is required";
   	} else {
    	$city = test_input($_POST['city']);
    	$_SESSION['city'] = $city;
     	// check if name only contains letters and whitespace
    	if (!preg_match("/^[a-zA-Z ]*$/",$city)) {
	        $cityErr = "<div class='alert alert-danger alert-dismissible' role='alert'>
	 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	 		<p>Only letters and white space available</p>
			</div>"; 
			$input_error=true;
     		}
   		}
   	
  	if (empty($_POST['email'])) {
    //$emailErr = "Email is required";
   	} else {
	    $email = test_input($_POST['email']);
	    $_SESSION['email'] = $email;
	    // check if e-mail address is well-formed
	    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	       $emailErr = "
	        <div class='alert alert-danger alert-dismissible' role='alert'>
	 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	 		<p>Invalid email</p>
			</div>";
			$input_error=true;
	       //$emailErr = "Invalid email format"; 
	     	}
	   }
	if(empty($_POST['tel'])){
		//$phoneErr= "phone is required";
		}else{
			$tel = test_input($_POST['tel']); 
			$_SESSION['tel'] = $tel;
		    if(!preg_match("/^(([\+]?370)|(8))[\s-]?\(?[0-9]{2,3}\)?[\s-]?([0-9]{2}[\s-]?){2}?[0-9]{1,2}$/", $tel)) {
		 		$phoneErr = "
		 		<div class='alert alert-danger alert-dismissible' role='alert'>
		 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
		 		<p>Invalid phone number</p>
				</div>";
				$input_error=true;
				}
				
			}	 
	if(empty($_POST['zip'])){
		//$zipErr = "Addres is required";
		}
		else{
			$zip = test_input($_POST['zip']);
			$_SESSION['zip'] = $zip;
			if(!preg_match("#[0-9]{5}#", $zip)) {
		 		$zipErr = "
		 		<div class='alert alert-danger alert-dismissible' role='alert'>
		 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
		 		<p>Blogas pašto kodas</p>
				</div>";
				$input_error=true;

				}	
			}

	//		if($irasoCheck==false){	
		if(isset($name) AND $name==''){
    		$nameErr= "<div class='alert alert-danger alert-dismissible' role='alert'>
	 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	 		<p>Tušti laukai negalimi, prašome užpildyti</p>
			</div>";
			$input_error=true;
		}
		if(isset($email) AND $email==''){
    		$emailErr= "<div class='alert alert-danger alert-dismissible' role='alert'>
	 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	 		<p>Tušti laukai negalimi, prašome užpildyti</p>
			</div>";
			$input_error=true;
		}
		if(isset($address) AND $address==''){
    		$addressErr= "<div class='alert alert-danger alert-dismissible' role='alert'>
	 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	 		<p>Tušti laukai negalimi, prašome užpildyti</p>
			</div>";
			$input_error=true;
		}
		if(isset($city) AND $city==''){
    		$cityErr= "<div class='alert alert-danger alert-dismissible' role='alert'>
	 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	 		<p>Tušti laukai negalimi, prašome užpildyti</p>
			</div>";
			$input_error=true;
		}
		if(isset($tel) AND $tel==''){
    		$phoneErr= "<div class='alert alert-danger alert-dismissible' role='alert'>
	 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	 		<p>Tušti laukai negalimi, prašome užpildyti</p>
			</div>";
			$input_error=true;
		}

	//}

}//end request method post


function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
// end input validation

if(isset($_POST['submitForm'])){// TEST JEI neuzpildyta
	/*if(isset($name) AND $name==''){
	echo "<div class='alert alert-danger alert-dismissible' role='alert'>
	<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	<p>Blogas pašto kodas</p>
	</div>";
	}*/
	if($input_error!=true){// jei nera input error iraso i duombaze
		unset($_COOKIE[$name]);
		unset($_COOKIE[$email]);//isima cookies kad einant antra karta ir spaudus submit ant tusciu lauku rodytu klaidas
		unset($_COOKIE[$address]);
		unset($_COOKIE[$tel]);
		unset($_COOKIE[$zip]);
		unset($_COOKIE[$city]);
		//$iraso=true;
	//insert into DB//id isemiau is sql

	//select order_id from database
	$get_order_id_sql = "SELECT id FROM store_shoppertrack WHERE session_id = '".$_COOKIE['PHPSESSID']."'";
	$run_order_id_res = mysqli_query($mysqli, $get_order_id_sql) or die(mysqli_error($mysqli));
	while($info = mysqli_fetch_array( $run_order_id_res)) 	 
 		{ 
 			$order_id = $info['id'];
 		} 


	$sql = "INSERT INTO store_orders (authorization, item_total, order_address, order_city, order_date, order_email,
		order_name, order_tel, order_zip, shipping_total, order_id,status) VALUES ('".$_COOKIE['PHPSESSID']."', 
											
		'".$item_total_qty."',
		'".$address."',
		'".$city."',
		now(),
		'".$email."',
		'".$name."',
		'".$tel."',
		'".$zip."',
		'".$shipping_total."',
		'".$order_id."',
		'2')";

	$write_in_db = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
	//delete items from shoppertrack when order is completed
	$delete_compeleted_items_sql = "DELETE FROM store_shoppertrack WHERE session_id = '".$_COOKIE['PHPSESSID']."' ";
	$delete_rez = mysqli_query($mysqli, $delete_compeleted_items_sql);
	header('Location: checkout_success.php');
	}
}

//delete zero values in database
$delete_orders_zero_sql = "DELETE FROM store_orders WHERE order_name = '' AND order_address='' AND order_email='' ";
$delete_orders_zero_res = mysqli_query($mysqli, $delete_orders_zero_sql) or die(mysqli_error($mysqli)); 



 ?>


<!DOCTYPE HTML>
<html>
<head>
<?php include 'library.php';?>
</head>
<body>
<div class="container">
	<div class="row"><!-- header-->
		<div class="col-md-12 border-color">
			<h1>Header</h1>
		</div>
	</div>

	<div class="row"><!--meniu-->
		<div class="col-md-12 border-color">
			<p>up meniu</p>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 border-color">	<!--body-->
		<?php echo $display_block ?>
			<div class="row">
				<div class="col-md-4 border-color">
					<h4>Pirkti kaip registruotas vartotojas</h4>
					
					<!--<?php echo $display_login?>-->
					<?php include 'loginCheckout.php' ?>

				</div>

				<div class="col-md-8 border-color"><!--formos ilgis-->

					<form class="form-horizontal" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
						<div class="form-group">
							<div class="row margin-top">
							<h4>Pirkti be registracijos <hr></h4>
								<label for="inputName3" class="col-md-4 control-label">Vardas ir pavardė</label>
								<div class="col-md-8">
									<input type="text" name="name" value="<?php echo $_SESSION['name'];?>" class="form-control" id="inputName3" placeholder="Vardas ir pavardė">							
									<span class="error"><?php echo $nameErr;?></span>
								</div>
							</div>

							<div class="row margin-top">	
								<label for="inputCity3" class="col-md-4 control-label">Miestas</label>
								<div class="col-md-8">
									<input type="text" name="city" value="<?php echo $_SESSION['city']; ?>" class="form-control" id="inputCity3" placeholder="Miestas">
									<span class="error"><?php echo $cityErr ;?></span>
								</div>
							</div>	

							<div class="row margin-top">	
								<label for="inputAddress3" class="col-md-4 control-label">Adresas</label>
								<div class="col-md-8">
									<input type="text" name="address" value="<?php echo $_SESSION['address']; ?>" class="form-control" id="inputAddress3" placeholder="Adresas">
									<span class="error"><?php echo $addressErr;?></span>
								</div>
							</div>	

							<div class="row margin-top">	
								<label for="inputEmail3" class="col-md-4 control-label">El.Pašto adresas</label>
								<div class="col-md-8">
									<input type="email" name="email" value="<?php echo $_SESSION['email']; ?>" class="form-control" id="inputEmail3" placeholder="El.Pašto adresas">
									<span class="error"><?php echo $emailErr;?></span>
								</div>
							</div>	

							<div class="row margin-top">	
								<label for="inputPhone3" class="col-md-4 control-label">Telefono numeris</label>
								<div class="col-md-8">
									<input type="text" name="tel" value="<?php echo $_SESSION['tel']; ?>" class="form-control" id="inputPhone3" placeholder="Telefono numeris">
									<span class="error"><?php echo $phoneErr;?></span>
								</div>
							</div>	
							
							<div class="row margin-top">	
								<label for="inputZip3" class="col-md-4 control-label">Pašto kodas</label>
								<div class="col-md-8">
									<input type="text" name="zip" value="<?php echo $_SESSION['zip']; ?>" class="form-control" id="inputZip3" placeholder="Pašto kodas">
									<span class="error"><?php echo $zipErr;?></span>
								</div>
							</div>	
							<div class="row">
								<Label class="col-md-4 control-label">Galutinė suma:</label>
								<div class="col-md-6 margin-top">&euro; <?php echo $shipping_total ?><br>
								</div>
							</div>
							<div class="row margin-top">
								<div class="col-md-1 col-md-offset-8">
									<button type="submit" value"Submit" name="submitForm" class="btn btn-default">Užsakyti be registracjos</button>
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

