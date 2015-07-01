<?php 
//http://php.about.com/od/finishedphp1/ss/php_login_code.htm
//Connects to your Database 
ob_start();
include 'connect.php';
//include_once 'library.php';
$passErr = $userErr = '';

if(isset($_GET['lang']) && $_GET['lang']=='LT'){
        include 'content_LT.php';
    }else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
        include 'content_EN.php';
    }else{
        include 'content_LT.php';
    }

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
		 		<p>$txterror_user_no_exist</p>
				</div>";
	 	}
	
	 $info = mysqli_fetch_array( $check );

	 	$_POST['pass'] = stripslashes($_POST['pass']);

	 	$info['password'] = stripslashes($info['password']);

	 	$_POST['pass'] = md5($_POST['pass']);

	 	if (isset($_POST['pass']) && $_POST['pass'] != $info['password']) {
	 		$passErr = "<div class='alert alert-danger alert-dismissible' role='alert'>
		 		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
		 		<p>$txterror_pass</a></p>
				</div>"; 
	 	}
		 else 
		 	{ 
		 		
			 // if login is ok then we add a cookie 
			$_POST['username'] = stripslashes($_POST['username']); 
			//$hour = time() + 20000;  
			setcookie('ID_my_site', $_POST['username']); 
			setcookie('Key_my_site', $_POST['pass']);
	
			include 'members.php';
			echo("<meta http-equiv='refresh' content='0'>"); 
	 		}
	//end of while check 

} //end of, if form submitted

echo "<!-- Reset pass Modal -->
<div class='modal fade' id='resetPass' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog '>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>$txtrecover_pass</h4>
			</div>
			<form class='form-horizontal' method='post'>
				<div class='modal-body'>
					<div class='form-group'>
						<div class='row margin-top'>
							<div class='col-md-12'>
								<input type='email' placeholder='$txtemail' required class='form-control text-center' name='inputEmail'>
								<p>* $txtsent_pass_email</p>
							</div>
						</div>
						
					</div>				
				</div>

			<div class='modal-footer'>
				<button type='button' class='btn btn-default' data-dismiss='modal'>$txtclose</button>
			 	<button type='submit' name='submitResetPass' value='Submit' class='btn btn-primary'>$txtsend</button>
		  	</div>
		  	</form>
		</div>
	</div>
</div>";

if(isset($_POST['submitResetPass'])){
	$check_email = "SELECT email FROM users WHERE email = '".$_POST['inputEmail']."'";
	$check_email_res = mysqli_query($mysqli, $check_email) or die(mysqli_error($mysqli));
	$check_rows = mysqli_num_rows($check_email_res);

	if($check_rows == 0){
		echo "<div class='alert alert-danger alert-dismissible' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <p>$txterror_email_exist $txterror_no_exist</p>
        </div>";	
	}else{
		$tokenLength = 30;//get random string/token
		$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $tokenLength);

		$set_token = "UPDATE users SET temp_pass_reset_token = '".$randomString."' WHERE email = '".$_POST['inputEmail']."'";
		$set_token_res = mysqli_query($mysqli, $set_token) or die(mysqli_error($mysqli));
		//$link= $_SERVER['PHP_SELF']."?lang=".$_GET['lang']."&token=".$randomString;
		$link= "decorbox.lt/resetPass.php?lang=".$_GET['lang']."&token=".$randomString;
		echo "<div class='alert alert-success alert-dismissible' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        	<p>Prašome pasitikrinti savo el. paštą</p>
        </div>";

		$to = $_POST['inputEmail'];
		$subject = "Slaptažodžio keitimas Decorbox.lt";
		$message = "
		<html>
			<head>
				<title>Slaptažodžio keitimas</title>
			</head>
			<body>
				<a href='".$link."'>Jei norite pakeisti slaptažodį paspauskite ant šios nuorodos</a>
			</body>
		</html>
		";
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		// More headers
		$headers .= 'From: <decorbox.lt@gmail.com>' . "\r\n";
		mail($to,$subject,$message,$headers);//send email
	}
}
if(isset($_GET['token'])){//redirect to reset password page
	header("Location: resetPass.php?lang=".$_GET['lang']."&token=".$_GET['token']."");
}

if(isset($_COOKIE['ID_my_site'])){
	include 'membersMobile.php';
}	 
else{
 ?> 
 <!DOCTYPE HTML>
<html>

<body>
<div class="">
	<div class=' margin-top20 panel panel-success'>
		<div class='panel-heading'>
			<h3 class='panel-title text-center'><?php echo $txtlogin; ?></h3>
		</div>	
		
		<div class='panel-body '>
			<form  action="<?php echo $_SERVER['PHP_SELF']."?lang=".$_GET['lang'].""; ?>" method="post">
				<div class="form-group">
					<div class="row margin-top">
						<label for="inputUsername3" ><?php echo $txtusername; ?></label>
							<input type="text" name="username" class="form-control" id="inputUsername3" placeholder="<?php echo $txtusername; ?>">
							<span class="error"><?php echo $userErr;?></span>
						
					</div>	

					<div class="row margin-top">
						<label for="inputPass3"><?php echo $txtpassword; ?></label>
							<input type="password" name="pass" class="form-control" id="inputPass3" placeholder="<?php echo $txtpassword; ?>">
							<span class="error"><?php echo $passErr;?></span>
						
					</div>
					<div class="row margin-top">
						<div>

							<a href="register.php?lang=<?php echo $_GET['lang'] ?>" role='button' class='btn btn-success'><?php echo $txtregister; ?></a>
							<button type="submit" value"Register" name="submitLog" class="btn btn-success"><?php echo $txtlogin; ?></button>
							<div>
							<a href="#resetPass" data-toggle='modal' data-target='#resetPass'><?php echo $txtforget_pass; ?></a>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>
<?php }
?>