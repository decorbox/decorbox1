<?php 
//http://php.about.com/od/finishedphp1/ss/php_login_code.htm
//Connects to your Database 
include_once 'connect.php';
include_once 'library.php';
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
			include 'members.php';
			echo("<meta http-equiv='refresh' content='0'>"); //Refresh page nes kai prijungi iskart nerodo user meniu reikia reflesh
		//https://www.daniweb.com/web-development/php/threads/69676/error-use-of-undefined-constant-help

	 		}
	//end of while check 

} //end of, if form submitted


if(isset($_COOKIE['ID_my_site'])){
	include 'members.php';
}	 
else {
	
 ?> 
 <!DOCTYPE HTML>
<html>

<body>
<div class="row">
	<div class="col-md-12">
		<form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<div class="form-group">
				<div class="row margin-top">
					<label for="inputUsername3" >Vartotojo vardas</label>
						<input type="text" name="username" class="form-control" id="inputUsername3" placeholder="Prisijungimo vardas">
						<span class="error"><?php echo $userErr;?></span>
					
				</div>	

				<div class="row margin-top">
					<label for="inputPass3">Slaptažodis</label>
						<input type="password" name="pass" class="form-control" id="inputPass3" placeholder="Įveskite slaptažodį">
						<span class="error"><?php echo $passErr;?></span>
					
				</div>
				<div class="row margin-top">
					<div>
						
						<a href="register.php">
						   <button type="link" class="btn btn-default" value="Registruotis" />Registruotis
						</a>
						<button type="submit" value"Register" name="submitLog" class="btn btn-default">Prisijunkti</button>
					</div> <!-- padaryt kai submitinu kad rodytu pop up windows http://nakupanda.github.io/bootstrap3-dialog/ -->
				</div>
			</div>
		</form>
	</div>
</div>
</body>
</html>
<?php } 
?>