<?php 
//Connects to your Database 
 include 'connect.php';


$input_error=false;
//start input validation
// define variables and set to empty values
$nameErr = $phoneErr = $zipErr =$passErr=$userErr=$emailErr = $addressErr=$cityErr= "";
$name = $email= $address =$city= $tel = $zip= "";
$_SESSION['name'] = $name;
$_SESSION['email'] = $email;
$_SESSION['address'] = $address;
$_SESSION['city'] = $city;
$_SESSION['tel'] = $tel;
$_SESSION['zip'] = $zip;


if (isset($_POST['submitReg'])){//tikrina ar nera tusciu lauku jei yra meta klaida
	
	if (!$_POST['username'] | !$_POST['pass'] | !$_POST['pass2'] ) {
 		echo "<div class='alert alert-danger alert-dismissible' role='alert'>
 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
 		<p>Prašome užpildyti visus laukus</p>
		</div>"; 
		$input_error=true;
 	}

 // checks if the username is in use

 	if (!get_magic_quotes_gpc()) {

 		$_POST['username'] = addslashes($_POST['username']);

 	}
 $usercheck = $_POST['username'];
 $check = mysqli_query($mysqli, "SELECT username FROM users WHERE username = '$usercheck'") or die(mysqli_error());
 $check2 = mysqli_num_rows($check);

 //if the name exists it gives an error
 if ($check2 != 0) {
 		
 		$userErr = "<div class='alert alert-danger alert-dismissible' role='alert'>
 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
 		<p>Toks vartotojas ".$_POST['username']." jau egzistuoja</p>
		</div>"; 
		$input_error=true;
 		}

 // this makes sure both passwords entered match
 	if ($_POST['pass'] != $_POST['pass2']) {
 		$passErr = "<div class='alert alert-danger alert-dismissible' role='alert'>
 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
 		<p>Neatitinka slaptažodžiai</p>
		</div>"; 
		$input_error=true;
 	}

 	// here we encrypt the password and add slashes if needed

 	$_POST['pass'] = md5($_POST['pass']);
 	if (!get_magic_quotes_gpc()) {
 		$_POST['pass'] = addslashes($_POST['pass']);
 		$_POST['username'] = addslashes($_POST['username']);
 		}


	
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
		$_SESSION['city'] = $city;
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


}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
// end input validation

if($input_error!=true){
	unset($_COOKIE[$name]);
	unset($_COOKIE[$email]);//isima cookies kad einant antra karta ir spaudus submit ant tusciu lauku rodytu klaidas
	unset($_COOKIE[$address]);
	unset($_COOKIE[$tel]);
	unset($_COOKIE[$zip]);
	unset($_COOKIE[$city]);

	
 // now we insert it into the database/ isset paziuri ar yra reiksme
 if (isset($_POST['submitReg'])) { 
 	$insert = "INSERT INTO users (username, password, role, name, address, city, zip, phone, email, date) 
 	VALUES ('".$_POST['username']."', '".$_POST['pass']."', '2', '".$_POST['name']."', '".$_POST['address']."', 
 		'".$_POST['city']."', '".$_POST['zip']."', '".$_POST['tel']."', '".$_POST['email']."', now())";

 	$add_member = mysqli_query($mysqli, $insert);
	}
		
}
 	?>

 <!--<h1>Registered</h1>

 <p>Thank you, you have registered - you may now <a href="login.php">login</a>.</p>
-->
	

<!DOCTYPE HTML>
<html>
<head>
<title>Bootstrap test</title>
	<?php 
		include 'library.php';
		include 'connect.php';
	?>
	
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-md-12 border-color">
			<h1>Header</h1>
		</div>
	</div>
		
	<div class="row">
		<div class="col-md-12 border-color">
			<p>up meniu</p>
		</div>
	</div>
		
	<div class="row">
		<div class="col-md-9">
			<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<div class="form-group">
					<div class="row margin-top">
						<label for="inputUsername3" class="col-md-3 control-label">Prisijungimo vardas</label>
						<div class="col-md-7">
							<input type="text" name="username" class="form-control" id="inputUsername3" placeholder="Prisijungimo vardas">
								<span class="error"><?php echo $userErr;?></span>
						</div>
					</div>	

					<div class="row margin-top">
						<label for="inputPass3" class="col-md-3 control-label">Slaptažodis</label>
						<div class="col-md-7">
							<input type="password" name="pass" class="form-control" id="inputPass3" placeholder="Įveskite slaptažodį">
							<span class="error"><?php echo $passErr;?></span>
						</div>
					</div>

					<div class="row margin-top">
						<label for="inputPass3" class="col-md-3 control-label">Pakartokite slaptažodį</label>
						<div class="col-md-7">
							<input type="password" name="pass2" class="form-control" id="inputPass3" placeholder="Pakartokite slaptažodį">
							<span class="error"><?php echo $passErr;?></span>
						</div>
					</div>
		
					<div class="row margin-top">
						<label for="inputName3" class="col-md-3 control-label">Vardas ir pavardė</label>
						<div class="col-md-7">
							<input type="text" name="name" value="<?php echo $_SESSION['name'];?>" class="form-control" id="inputName3" placeholder="Vardas ir pavardė">							
							<span class="error"><?php echo $nameErr;?></span>
						</div>
					</div>

					<div class="row margin-top">	
						<label for="inputCity3" class="col-md-3 control-label">Miestas</label>
						<div class="col-md-7">
							<input type="text" name="city" value="<?php echo $_SESSION['city']; ?>" class="form-control" id="inputCity3" placeholder="Miestas">
							<span class="error"><?php echo $cityErr ;?></span>
						</div>
					</div>	

					<div class="row margin-top">	
						<label for="inputAddress3" class="col-md-3 control-label">Adresas</label>
						<div class="col-md-7">
							<input type="text" name="address" value="<?php echo $_SESSION['address']; ?>" class="form-control" id="inputAddress3" placeholder="Adresas">
							<span class="error"><?php echo $addressErr;?></span>
						</div>
					</div>	

					<div class="row margin-top">	
						<label for="inputEmail3" class="col-md-3 control-label">El.Pašto adresas</label>
						<div class="col-md-7">
							<input type="email" name="email" value="<?php echo $_SESSION['email']; ?>" class="form-control" id="inputEmail3" placeholder="El.Pašto adresas">
							<span class="error"><?php echo $emailErr;?></span>
						</div>
					</div>	

					<div class="row margin-top">	
						<label for="inputPhone3" class="col-md-3 control-label">Telefono numeris</label>
						<div class="col-md-7">
							<input type="text" name="tel" value="<?php echo $_SESSION['tel']; ?>" class="form-control" id="inputPhone3" placeholder="Telefono numeris">
							<span class="error"><?php echo $phoneErr;?></span>
						</div>
					</div>	
					
					<div class="row margin-top">	
						<label for="inputZip3" class="col-md-3 control-label">Pašto kodas</label>
						<div class="col-md-7">
							<input type="text" name="zip" value="<?php echo $_SESSION['zip']; ?>" class="form-control" id="inputZip3" placeholder="Pašto kodas">
							<span class="error"><?php echo $zipErr;?></span>
						</div>
					</div>
						 
					<div class="row margin-top">
						<div class="col-md-1 col-md-offset-8">
							<button type="submit" value"Register" name="submitReg" class="btn btn-default">Submit</button>
						</div> <!-- padaryt kai submitinu kad rodytu pop up windows http://nakupanda.github.io/bootstrap3-dialog/ -->
					</div>


				</div>
			</form>
		</div><!--end register body-->

		<div class="col-md-3">
			<?php include 'showPriceWidget.php'; ?>
		</div>
	</div>

</body>
</html>

 
 


  
