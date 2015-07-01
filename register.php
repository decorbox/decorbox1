<?php 
//Connects to your Database 
//isversta i EN
ob_start();
 include 'connect.php';
 include 'library.php';
?>
<script type="text/javascript">
	$(document).ready(function() {
  	$(".selectOption").select2({ minimumResultsForSearch: Infinity });//run sorting, INFINITY PASLEPE SEARCH BAR
});
</script>
 
<?php
if(isset($_GET['lang']) && $_GET['lang']=='LT'){
        include 'content_LT.php';
    }else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
        include 'content_EN.php';
    }else{
        include 'content_LT.php';
    }

$display_block="";
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
 		<p>$txterror_fill_all_fields</p>
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

 $emailcheck = $_POST['email'];
 $echeck = mysqli_query($mysqli, "SELECT email FROM users WHERE email = '$emailcheck'") or die(mysqli_error());
 $echeck2 = mysqli_num_rows($echeck);

 //if the name exists it gives an error
 if ($check2 != 0) {
 		$userErr = "<div class='alert alert-danger alert-dismissible' role='alert'>
 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
 		<p>$txterror_user ".$_POST['username']." $txterror_exist</p>
		</div>"; 
		$input_error=true;
 		}

if ($echeck2 != 0) {	
 	$emailErr = "<div class='alert alert-danger alert-dismissible' role='alert'>
 	<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
 	<p>$txterror_email_exist ".$_POST['email']." $txterror_exist</p>
	</div>"; 
	$input_error=true;
 	}		

 // this makes sure both passwords entered match
 	if ($_POST['pass'] != $_POST['pass2']) {
 		$passErr = "<div class='alert alert-danger alert-dismissible' role='alert'>
 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
 		<p>$txterror_incorect_pass</p>
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
	 		<p>$txterror_only_letters</p>
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
	 		<p>$txterror_email</p>
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
		 		<p>$txterror_phone</p>
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
		 		<p>$txterror_zip</p>
				</div>";
				$input_error=true;

				}	
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
	unset($_SESSION[$name]);
	unset($_SESSION[$email]);//isima cookies kad einant antra karta ir spaudus submit ant tusciu lauku rodytu klaidas
	unset($_SESSION[$address]);
	unset($_SESSION[$tel]);
	unset($_SESSION[$zip]);
	unset($_SESSION[$city]);

 // now we insert it into the database/ isset paziuri ar yra reiksme
 if (isset($_POST['submitReg'])) { 
 	$insert = "INSERT INTO users (username, password, role, name, address, city, zip, phone, email, date, country) 
 	VALUES ('".$_POST['username']."', '".$_POST['pass']."', '2', '".$_POST['name']."', '".$_POST['address']."', 
 		'".$_POST['city']."', '".$_POST['zip']."', '".$_POST['tel']."', '".$_POST['email']."', now(), '".$_POST['country']."')";

 	$add_member = mysqli_query($mysqli, $insert);
 	
	}
		
}
 if($input_error==true || !isset($_POST['submitReg'])){
 	$display_block.="
 	<div class='row'>
		<div class='col-md-9 '>
			<form class='form-horizontal' action=".$_SERVER['PHP_SELF']."?lang=".$_GET['lang']." method='post'>
				<div class='form-group'>
					<div class='row margin-top'>
						<label for='inputUsername3' class='col-md-4 control-label'>$txtusername<span style='color: red; padding-left: 2px;'>*</span></label>
						<div class='col-md-8'>
							<input type='text' name='username' class='form-control' required id='inputUsername3' placeholder='Prisijungimo vardas'>
								<span class='error'>$userErr</span>
						</div>
					</div>	

					<div class='row margin-top'>
						<label for='inputPass3' class='col-md-4 control-label'>$txtpassword<span style='color: red; padding-left: 2px;'>*</span></label>
						<div class='col-md-8'>
							<input type='password' name='pass' required class='form-control' id='inputPass3' placeholder='$txtpassword'>
							<span class='error'>$passErr</span>
						</div>
					</div>

					<div class='row margin-top'>
						<label for='inputPass3' required class='col-md-4  control-label'>$txtrepeat_pass<span style='color: red; padding-left: 2px;'>*</span></label>
						<div class='col-md-8'>
							<input type='password' name='pass2' required class='form-control' id='inputPass3' placeholder='$txtrepeat_pass'>
							<span class='error'>$passErr</span>
						</div>
					</div>
		
					<div class='row margin-top'>
						<label class='col-md-4 control-label'>$txtinput_name<span style='color: red; padding-left: 2px;'>*</span></label>
						<div class='col-md-8'>
							<input type='text' name='name' value='".$_SESSION['name']."' required class='form-control' id='inputName3' placeholder='$txtinput_name'>							
							<span class='error'>$nameErr</span>
						</div>
					</div>

					<div class='row margin-top'>	
						<label for='inputAddress3' class='col-md-4 control-label'>$txtaddress<span style='color: red; padding-left: 2px;'>*</span></label>
						<div class='col-md-8'>
							<input type='text' name='address' required value='".$_SESSION['address']."' class='form-control' id='inputAddress3' placeholder='$txtaddress'>
							<span class='error'>$addressErr</span>
						</div>
					</div>	

					<div class='row margin-top'>	
						<label for='inputCity3' class='col-md-4 control-label'>$txtcity<span style='color: red; padding-left: 2px;'>*</span></label>
						<div class='col-md-8'>
							<input type='text' name='city' required value='".$_SESSION['city']."' class='form-control' id='inputCity3' placeholder='$txtcity'>
							<span class='error'>$cityErr</span>
						</div>
					</div>

					<div class='row margin-top'>	
						<label for='inputZip3' class='col-md-4 control-label'>$txtzip <span style='color: red; padding-left: 2px;'>*</span></label>
						<div class='col-md-8'>
							<input type='text' name='zip' required value='".$_SESSION['zip']."' class='form-control' id='inputZip3' placeholder='$txtzip'>
							<span class='error'>$zipErr</span>
						</div>
					</div>

					<div class='row margin-top'>
					<label for='inputCity3' class='col-md-4 control-label'>$txtcountry<span style='color: red; padding-left: 2px;'>*</span></label>
						<div class='col-md-8'>
							<select class='selectOption' required style='width:100%'  name='country'>";
								

								$get_cat = "SELECT * FROM countries";
								$get_cat_rs= mysqli_query($mysqli, $get_cat);
						$display_block.= "<option value='Lithuania'>Lithuania</option>";
								while($info = mysqli_fetch_array($get_cat_rs)){
									$id=$info['id'];
									$title=$info['country'];
									if($id!=15){//jei ne lietuvos ID
							$display_block.= "<option value='".$title."'>$title</option>";
									}
								}

						$display_block.="		
							</select>
						</div>
					</div>					

					<div class='row margin-top'>	
						<label for='inputPhone3' class='col-md-4 control-label'>$txtphone<span style='color: red; padding-left: 2px;'>*</span></label>
						<div class='col-md-8'>
							<input type='text' name='tel' required value='".$_SESSION['tel']."' class='form-control' id='inputPhone3' placeholder='$txtphone'>
							<span class='error'>$phoneErr</span>
						</div>
					</div>	

					

					<div class='row margin-top'>	
						<label for='inputEmail3' class='col-md-4 control-label'>$txtemail<span style='color: red; padding-left: 2px;'>*</span></label>
						<div class='col-md-8'>
							<input type='email' name='email' required value='".$_SESSION['email']."' class='form-control' id='inputEmail3' placeholder='$txtemail'>
							<span class='error'>$emailErr</span>
						</div>
					</div>	

						 
					<div class='row margin-top'>
						<div class='col-md-1 col-md-offset-8'>
							<button type='submit' value'Register' name='submitReg' class='btn btn-success'>$txtregister</button>
						</div> 
					</div>


				</div>
			</form>
		</div><!--end register body-->

 	";
 }else{
 	$display_block.="
 	
		<div class='col-md-9 border-color text-center'>
 			<h1 class='text-center'>$txtregister_success</h1>
 			<label ><a href='index.php'> $txtregister_success_link</a></label>
 		</div>
 	";
 	}
 	?>
	

<!DOCTYPE HTML>
<html>
<head>
<title>Register</title>
	
	
</head>
<body>
<div class="container">
<?php 
	include 'header.php';
	include 'navbar.php';
	echo $display_block; ?>	
 
	<div class="col-md-3 hidden-xs hidden-sm right-bar-edit border-color">
		<?php 
			include_once 'login.php';  
			include 'showPriceWidget.php';
			include_once 'contactsWidget.php';
			include_once 'deliveryWidget.php';
			include_once 'facebookWidget.php';
		 ?>
	</div>
</div>

<div class="container">
	<div class="row">
		<?php include 'footer.php'; ?>
	</div>
</div>
</body>
</html>



  
