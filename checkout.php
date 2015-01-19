<?php 
session_start();
include 'connect.php';

$safe_sel_item_authorization = $_COOKIE['PHPSESSID']; //reikia vartotojo login
$item_total_price= $_POST['full_price']; // ir total_qty suskaiciuot
$shipping_total = 4;
//$full_qty = $_POST['full_qty'];
//$item_total_qty= $_POST['item_total']; //$_POST['item_total'];

echo "$item_total_price:::$item_total_qty";

/*if(isset($_POST['add'])){
	$safe_sel_item_authorization = $_COOKIE['PHPSESSID']; //reikia vartotojo login
	$safe_sel_item_total= $_POST['$full_price']; //$_POST['item_total'];
	$safe_order_address = $_POST['order_address'];
	$safe_order_city =	$_POST['order_city'];
	$safe_order_email = $_POST['order_email'];
	$safe_order_name = $_POST['order_name'];
	$safe_order_tel = $_POST['order_tel'];
	$safe_order_zip = $_POST['order_zip'];
	$safe_shipping_total = 4; //
	$safe_shipping_status = "pending"; //
	$id='';
	
$item_total_price= $_POST['$full_price'];//
// ir sql pakeist i login id
*/
	



//start input validation
// define variables and set to empty values
$nameErr = $phoneErr = $zipErr =$emailErr = "";
$name = $email = $address = $city = $tel = $zip = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["name"])) {
     //$nameErr = "Name is required";
   } else {
     $name = test_input($_POST["name"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
       $nameErr = "<div class='alert alert-danger alert-dismissible' role='alert'>
 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
 		<p>Only letters and white space available</p>
		</div>"; 
     }
   }
   
   if (empty($_POST["email"])) {
     //$emailErr = "Email is required";
   } else {
     $email = test_input($_POST["email"]);
     // check if e-mail address is well-formed
     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $emailErr = "
       <div class='alert alert-danger alert-dismissible' role='alert'>
 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
 		<p>Invalid email</p>
		</div>";

       //$emailErr = "Invalid email format"; 
     }
   }
     if(preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $tel)) {
 		$phoneErr = "
 		<div class='alert alert-danger alert-dismissible' role='alert'>
 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
 		<p>Invalid phone number</p>
		</div>";
		}  

	if(preg_match("#[0-9]{5}#", $zip)) {
 		$zipErr = "
 		<div class='alert alert-danger alert-dismissible' role='alert'>
 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
 		<p>Blogas pašto kodas</p>
		</div>";
		}  	

}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
// end input validation

//insert into DB
$sql = "INSERT INTO store_orders (authorization, id, item_total, order_address, order_city, order_date, order_email,
	order_name, order_tel, order_zip, shipping_total, status) VALUES ('".$_COOKIE['PHPSESSID']."', 
	FALSE,										
	'".$item_total_qty."',
	'".$address."',
	'".$city."',
	now(),
	'".$email."',
	'".$name."',
	'".$tel."',
	'".$zip."',
	'".$shipping_total."',
	'laukiama')";

$write_in_db = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
mysqli_close($mysqli);

?> 

<!DOCTYPE HTML>
<html>
<head>
<?php include 'library.php';?>
</head>
<body>

<form class="form-horizontal" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
	<div class="form-group">
		<div class="row margin-top">
			<label for="inputName3" class="col-md-2 control-label">Vardas ir pavardė</label>
			<div class="col-md-7">
				<input type="text" name="name" class="form-control" id="inputName3" placeholder="Vardas ir pavardė">
				<span class="error"><?php echo $nameErr;?></span>
			</div>
		</div>

		<div class="row margin-top">	
			<label for="inputCity3" class="col-md-2 control-label">Miestas</label>
			<div class="col-md-7">
				<input type="text" name="city" class="form-control" id="inputCity3" placeholder="Miestas">
				<span class="error"><?php echo $nameErr;?></span>
			</div>
		</div>	

		<div class="row margin-top">	
			<label for="inputAddress3" class="col-md-2 control-label">Adresas</label>
			<div class="col-md-7">
				<input type="text" name="address" class="form-control" id="inputAddress3" placeholder="Adresas">
			</div>
		</div>	

		<div class="row margin-top">	
			<label for="inputEmail3" class="col-md-2 control-label">El.Pašto adresas</label>
			<div class="col-md-7">
				<input type="email" name="email" class="form-control" id="inputEmail3" placeholder="El.Pašto adresas">
				<span class="error"><?php echo $emailErr;?></span>
			</div>
		</div>	

		<div class="row margin-top">	
			<label for="inputPhone3" class="col-md-2 control-label">Telefono numeris</label>
			<div class="col-md-7">
				<input type="text" name="tel" class="form-control" id="inputPhone3" placeholder="Telefono numeris">
				<span class="error"><?php echo $phoneErr;?></span>
			</div>
		</div>	
		
		<div class="row margin-top">	
			<label for="inputZip3" class="col-md-2 control-label">Pašto kodas</label>
			<div class="col-md-7">
				<input type="text" name="zip" class="form-control" id="inputZip3" placeholder="Pašto kodas">
				<span class="error"><?php echo $zipErr;?></span>
			</div>
		</div>	

		<div class="row margin-top">
			<div class="col-md-1 col-md-offset-8">
				<button type="submit" value"Submit" name="submit" class="btn btn-default">Submit</button>
			</div>
		</div>
	</div>

	
</form>


</body>
</html>

