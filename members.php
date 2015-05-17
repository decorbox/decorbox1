<?php 
//isvertsta EN
//Connects to your Database 
include 'connect.php';
if(isset($_GET['lang']) && $_GET['lang']=='LT'){
        include 'content_LT.php';
    }else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
        include 'content_EN.php';
    }else{
        include 'content_LT.php';
    }
?>
<script type="text/javascript">
	$(document).ready(function() {
$('.tableStuff').dataTable();
});

</script>

<script type="text/javascript">
	$(document).ready(function() {
  	$(".selectOption").select2({ minimumResultsForSearch: Infinity });//run sorting, INFINITY PASLEPE SEARCH BAR
});
</script>
 

<?php

//update user info
if(isset($_POST['submitUpdate'])){
	$update_user_sql = "UPDATE users
    SET name = '" . $_POST['name'] . "', address = '".$_POST['address']."', city = '".$_POST['city']."', country = '".$_POST['editCountry']."', zip = '".$_POST['zip']."',
    phone = '".$_POST['tel']."', email = '".$_POST['email']."'
    WHERE username = '" . $_COOKIE['ID_my_site'] . "'";

    $update_users_res = mysqli_query($mysqli, $update_user_sql) or die(mysqli_error($mysqli));
}




//checks cookies to make sure they are logged in 
if(isset($_COOKIE['ID_my_site'])) 
	{ 
		
 	$username = $_COOKIE['ID_my_site']; 
 	$pass = $_COOKIE['Key_my_site']; 
 	$check = mysqli_query($mysqli, "SELECT * FROM users WHERE username = '$username'")or die(mysqli_error()); 
 	while($info = mysqli_fetch_array( $check )) 	 
 		{ 
 //if the cookie has the wrong password, they are taken to the login page 
 		if ($pass != $info['password']) 
 			{ 			//header("Location: login.php"); //login 
 				include 'login.php';
 			} 

 //otherwise they are shown the admin area	 
 		else 
 			{ 
 				//add user info to the fields
 			$sql = "SELECT * FROM users WHERE username = '$username' ";
			$user_info_res = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
			while ($user_info = mysqli_fetch_array($user_info_res)) {
				$vardas= $user_info['name'];
				$adresas= $user_info['address'];
				$country = $user_info['country'];
				$city= $user_info['city'];
				$zip= $user_info['zip'];
				$phone= $user_info['phone'];
				$email= $user_info['email'];
				}
 			

 			//ziuri kiek order id usernamas turi
 		
			/*<!-- Button  modal -->*/
			echo"			
			<!-- Modal -->
				<div class='modal fade' id='myModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
				  <div class='modal-dialog modal-lg'>
				    <div class='modal-content'>
				     	<div class='modal-header'>
				        	<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				        	<h4 class='modal-title text-center' id='myModalLabel'>$txtmy_menu</h4>
				     	</div>

				     	<div class='modal-body'>     <!--TABS--> 	
							<ul class='nav nav-tabs' id='tabContent'>
				        		<li class='active'><a href='#profile' data-toggle='tab'>$txtmy_profile</a></li>
				        		<li><a href='#užsakymai' data-toggle='tab'>$txtorders</a></li>
				        		<li><a href='#pass' data-toggle='tab'>$txtchange_password</a></li>
				        		
							</ul>
				      		<div class='tab-content'>
				        		<div class='tab-pane active' id='profile'> 
				        <!--PROFILIS-->
				        			<div class=' border-color'> <!--forma-->

										<form class='form-horizontal' method='post'> 
											<div class='form-group'>
												<div class='row margin-top'>
												
													<label for='inputName3' class='col-md-4 control-label'>$txtinput_name <span style='color: red; padding-left: 2px;'>*</span></label>
													<div class='col-md-8'>
														<input type='text' name='name' required value='$vardas' class='form-control' id='inputName3' >							
														
													</div>
												</div>

												<div class='row margin-top'>	
													<label for='inputAddress3' class='col-md-4 control-label'>$txtaddress <span style='color: red; padding-left: 2px;'>*</span></label>
													<div class='col-md-8'>
														<input type='text' name='address' required value='$adresas' class='form-control' id='inputAddress3' >
														
													</div>
												</div>

												<div class='row margin-top'>	
													<label for='inputCity3' class='col-md-4 control-label'>$txtcity <span style='color: red; padding-left: 2px;'>*</span></label>
													<div class='col-md-8'>
														<input type='text' name='city' required value='$city' class='form-control' id='inputCity3' >
														
													</div>
												</div>

												<div class='row margin-top'>	
													<label for='inputZip3' class='col-md-4 control-label'>$txtzip <span style='color: red; padding-left: 2px;'>*</span></label>
													<div class='col-md-8'>
														<input type='text' name='zip' required value='$zip' class='form-control' id='inputZip3' >
														
													</div>
												</div>	

												<div class='row margin-top'>
													<label class='col-md-4 control-label'>$txtcountry <span style='color: red; padding-left: 2px;'>*</span></label>
													<div class='col-md-8'>
														<select class='selectOption' required id='addCountry' style='width:100%'  name='editCountry'>";
													
														//get all categories for select option
														$select_country_sql = "SELECT country FROM countries";
														$select_country_res = mysqli_query($mysqli, $select_country_sql) or die(mysqli_error($mysqli));
																
														//selected category
														echo "<option  value='".$country."'>$country</option>";
															while($cat = mysqli_fetch_array($select_country_res)){
																if($country!=$cat['country']){
																	
																	$disp_country = $cat['country'];
																	echo "<option  value='".$disp_country."'>$disp_country</option>";
																} 
															}
																							
											echo"	</select>
													</div>
												</div>

													
												<div class='row margin-top'>	
													<label for='inputPhone3' class='col-md-4 control-label'>$txtphone <span style='color: red; padding-left: 2px;'>*</span></label>
													<div class='col-md-8'>
														<input type='text' name='tel' required value='$phone' class='form-control' id='inputPhone3' >
														
													</div>
												</div>
												

												<div class='row margin-top'>	
													<label for='inputEmail3' class='col-md-4 control-label'>$txtemail <span style='color: red; padding-left: 2px;'>*</span></label>
													<div class='col-md-8'>
														<input type='email' required name='email' value='$email' class='form-control' id='inputEmail3' >
														
													</div>
												</div>	


												<div class='row margin-top'>
													<div class='col-md-1 col-md-offset-8'>
														<button type='submit' value'Submit' name='submitUpdate' class='btn btn-success'>$txtupdate</button>
													</div>
												</div>
											</div>
										</form>
									</div> <!-- end of form	input-->
		
				      			</div> <!-- end of profile tab -->
				     <!--UZSAKYMAI-->   
				        		<div class='tab-pane' id='užsakymai'>
				       			<table class='table tableStuff table-bordered table-hover table-condensed'>
				       				<thead>
										<tr>
											<th class='text-center'>$txttitle</th>
											<th class='text-center'>$txtqty</th>
											<th class='text-center'>$txtprice</th>
											<th class='text-center'>$txtorder_date</th>
											<th class='text-center'>$txtstatus</th>
										</tr>
									</thead>
									<tbody>";
									//atvaizduoja uzsakymus
									$get_order_id_by_username = "SELECT id, status, order_date FROM store_orders WHERE authorization = '".$username."' ORDER BY id DESC";
 									$get_id_by_username_res= mysqli_query($mysqli, $get_order_id_by_username) or die(mysqli_error($mysqli));

 									while($order_id_by_username = mysqli_fetch_array($get_id_by_username_res)){
 										$status = $order_id_by_username['status'];
 										$order_date = $order_id_by_username['order_date'];
	 					 


	 								$get_cart_sql = "SELECT so.item_id, so.item_price, so.item_qty, si.item_title, si.item_title_EN FROM
									store_orders_items_item AS so LEFT JOIN store_items AS si ON si.id = so.item_id WHERE order_id ='".$order_id_by_username['id']."'"; 
									$get_cart_res = mysqli_query($mysqli, $get_cart_sql) or die(mysqli_error($mysqli));	//status dar reikia
										while($show_items=mysqli_fetch_array($get_cart_res)){

											if(isset($_GET['lang']) && $_GET['lang']=='LT'){
										        $item_title=$show_items['item_title'];
										    }else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
										        $item_title=$show_items['item_title_EN'];
										    }else{
										        $item_title=$show_items['item_title'];
										    }
										
										$item_qty=$show_items['item_qty'];
										$item_price=$show_items['item_price'];
										
								echo"<tr class='text-center'>
										<td>$item_title</td>
										<td>$item_qty</td>
										<td>$item_price &euro;</td>
										<td>$order_date</td>
										<td>$status</td>
									</tr>";
									 	}//end of while show items 
									}//end of while order id 
								echo"</tbody>
								</table>	
				       			</div> 

				        		
							
							<div class='tab-pane' id='pass'> 
				        <!--Password-->
				        		<div class=' border-color'> <!--forma-->
									<form class='form-horizontal' method='post'> 
										<div class='form-group'>
											<form method='POST'>

										        <div class='form-group'>
										            
										            <div class='row margin-top'>	
														<label for='inputEmail3' class='col-md-4 control-label'>$txtcurrent_pass <span style='color: red; padding-left: 2px;'>*</span></label>
														<div class='col-md-6'>
															<input type='password' required name='currentPass' class='form-control' >
														</div>
													</div>

													<div class='row margin-top'>	
														<label for='inputEmail3' class='col-md-4 control-label'>$txtnew_pass <span style='color: red; padding-left: 2px;'>*</span></label>
														<div class='col-md-6'>
															<input type='password' required name='pass1' class='form-control' >
														</div>
													</div>

													<div class='row margin-top'>	
														<label for='inputEmail3' class='col-md-4 control-label'>$txtrepeat_pass <span style='color: red; padding-left: 2px;'>*</span></label>
														<div class='col-md-6'>
															<input type='password' required name='pass2' class='form-control' >
														</div>
													</div>


										            <div class='row margin-top'>
										                <div class='col-md-2 col-md-offset-8'>
										                    <button type='submit' name='newPassword' class='btn btn-success'>$txtupdate</button>    
										                </div>
										            </div>
										        </div>
										    </form>
										</div>
									</form>
								</div> <!-- end of form	input-->
				      		</div> <!-- end of password tab -->
				      </div>

				      <div class='modal-footer'>
				        <button type='button' class='btn btn-primary' data-dismiss='modal'>$txtclose</button>
				        
				      </div>
				    </div>
				  </div>
				</div></div>";

if(isset($_POST['newPassword'])){
	$currentPass = md5($_POST['currentPass']);
	if($pass == $currentPass){

		if($_POST['pass1'] == $_POST['pass2']){

	        $newPass= md5($_POST['pass1']);
	        $reset_pass = "UPDATE users SET password = '".$newPass."' WHERE username = '".$username."'";
	        $reset_pass_res = mysqli_query($mysqli, $reset_pass) or die(mysqli_error($mysqli));    
	        echo "<div class='alert alert-success alert-dismissible' role='alert'>
	        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	        <p>$txtpassword_changed</p>
	        </div>";   
	        
	        setcookie('Key_my_site', $newPass);

	    }else{
	        echo "<div class='alert alert-danger alert-dismissible' role='alert'>
	        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	        <p>$txterror_incorect_pass</p>
	        </div>";
	    }
	}else{
			 echo "<div class='alert alert-danger alert-dismissible' role='alert'>
	        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	        <p>$txterror_incorect_current_pass</p>
	        </div>";
	}
}

	 		echo"<br>
	 		<div class='panel panel-success'>
		 		<div class='panel-heading'>
			 		<h3 class=' panel-title text-center'><span class='glyphicon glyphicon-user' aria-hidden='true'></span> $txthello, $username</h3>
				</div>	
				<div class='panel-body'>
					<button type='button' class='btn btn-primary btn-lg' style='display: block; width: 100%;' data-toggle='modal' data-target='#myModal'>
						$txtmy_menu
					</button><br>

				";
			
		
 			 
 			} 
 			//admin menu button
 			if($info['role']=="Admin"){
 				echo "<a class='btn btn-lg btn-primary' style='display: block; width: 100%;' type='button' href='adminMenu.php?lang=".$_GET['lang']."'>$txtadmin_menu</a><br>";
 			}
 			//echo "<a href=logout.php>Logout</a>";
 		echo"<div class='pull-right' ><a href='logout.php?lang=".$_GET['lang']."' role='button' class='btn btn-primary'>$txtlog_out</a></div>";
 		echo "</div></div>";
 		}//end of while check 

 	}//end of IF ID_my_site 

else 
 //if the cookie does not exist, they are taken to the login screen 
	{			 
	 
	include 'login.php';
	 } 

 ?> 
