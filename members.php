<?php 

//Connects to your Database 
include 'connect.php';
 

//update user info
if(isset($_POST['submitUpdate'])){
	$update_user_sql = "UPDATE users
    SET name = '" . $_POST['name'] . "', address = '".$_POST['address']."', city = '".$_POST['city']."', zip = '".$_POST['zip']."',
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
				$city= $user_info['city'];
				$zip= $user_info['zip'];
				$phone= $user_info['phone'];
				$email= $user_info['email'];
				}
 			echo "Sveiki, "; 
 			echo $username;

 			//ziuri kiek order id usernamas turi
 		
			/*<!-- Button  modal -->*/
			


	 		echo"<br>	
				<button type='button' class='btn btn-primary btn-lg' data-toggle='modal' data-target='#myModal'>
				  Mano meniu
				</button>

				<!-- Modal -->
				<div class='modal fade' id='myModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
				  <div class='modal-dialog modal-lg'>
				    <div class='modal-content'>
				     	<div class='modal-header'>
				        	<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				        	<h4 class='modal-title' id='myModalLabel'>Mano meniu</h4>
				     	</div>

				     	<div class='modal-body'>     <!--TABS--> 	
							<ul class='nav nav-tabs' id='tabContent'>
				        		<li class='active'><a href='#profile' data-toggle='tab'>Mano profilis</a></li>
				        		<li><a href='#užsakymai' data-toggle='tab'>Užsakymai</a></li>
				        		
							</ul>
				      		<div class='tab-content'>
				        		<div class='tab-pane active' id='profile'> 
				        <!--PROFILIS-->
				        			<div class=' border-color'> <!--forma-->

										<form class='form-horizontal' method='post'> 
											<div class='form-group'>
												<div class='row margin-top'>
												
													<label for='inputName3' class='col-md-4 control-label'>Vardas ir pavardė</label>
													<div class='col-md-8'>
														<input type='text' name='name' value='$vardas' class='form-control' id='inputName3' >							
														
													</div>
												</div>

												<div class='row margin-top'>	
													<label for='inputCity3' class='col-md-4 control-label'>Miestas</label>
													<div class='col-md-8'>
														<input type='text' name='city' value='$city' class='form-control' id='inputCity3' >
														
													</div>
												</div>	

												<div class='row margin-top'>	
													<label for='inputAddress3' class='col-md-4 control-label'>Adresas</label>
													<div class='col-md-8'>
														<input type='text' name='address' value='$adresas' class='form-control' id='inputAddress3' >
														
													</div>
												</div>	

												<div class='row margin-top'>	
													<label for='inputEmail3' class='col-md-4 control-label'>El.Pašto adresas</label>
													<div class='col-md-8'>
														<input type='email' name='email' value='$email' class='form-control' id='inputEmail3' >
														
													</div>
												</div>	

												<div class='row margin-top'>	
													<label for='inputPhone3' class='col-md-4 control-label'>Telefono numeris</label>
													<div class='col-md-8'>
														<input type='text' name='tel' value='$phone' class='form-control' id='inputPhone3' >
														
													</div>
												</div>	
												
												<div class='row margin-top'>	
													<label for='inputZip3' class='col-md-4 control-label'>Pašto kodas</label>
													<div class='col-md-8'>
														<input type='text' name='zip' value='$zip' class='form-control' id='inputZip3' >
														
													</div>
												</div>	
												
												<div class='row margin-top'>
													<div class='col-md-1 col-md-offset-8'>
														<button type='submit' value'Submit' name='submitUpdate' class='btn btn-default'>Atnaujinti</button>
													</div>
												</div>
											</div>
										</form>
									</div> <!-- end of form	input-->
		
				      			</div> <!-- end of profile tab -->
				     <!--UZSAKYMAI-->   
				        		<div class='tab-pane' id='užsakymai'>
				       			<table class='table table-bordered table-hover table-condensed'>
									<tr>
										<th class='text-center'>Pavadinimas</th>
										<th class='text-center'>Kiekis</th>
										<th class='text-center'>Kaina</th>
										<th class='text-center'>Užsakymo data</th>
										<th class='text-center'>Statusas</th>
									</tr>";
									//atvaizduoja uzsakymus
									$get_order_id_by_username = "SELECT order_id, status, order_date FROM store_orders WHERE authorization = '".$username."' ORDER BY order_date";
 									$get_id_by_username_res= mysqli_query($mysqli, $get_order_id_by_username);

 									while($order_id_by_username = mysqli_fetch_array($get_id_by_username_res)){
 										$status = $order_id_by_username['status'];
 										$order_date = $order_id_by_username['order_date'];
	 			

	 								$get_cart_sql = "SELECT so.item_id, so.item_price, so.item_qty, si.item_title FROM
									store_orders_items_item AS so LEFT JOIN store_items AS si ON si.id = so.item_id WHERE order_id ='".$order_id_by_username['order_id']."'"; 
									$get_cart_res = mysqli_query($mysqli, $get_cart_sql) or die(mysqli_error($mysqli));	//status dar reikia
										while($show_items=mysqli_fetch_array($get_cart_res)){
										$item_title=$show_items['item_title'];
										$item_qty=$show_items['item_qty'];
										$item_price=$show_items['item_price'];
										
								echo"	<tr class='text-center'>
										<td>$item_title</td>
										<td>$item_qty</td>
										<td>$item_price</td>
										<td>$order_date</td>
										<td>$status</td>
									</tr>";
									 	}//end of while show items 
									}//end of while order id 
								echo"</table>	
				       			</div> 

				        		
							</div>
				      </div>

				      <div class='modal-footer'>
				        <button type='button' class='btn btn-primary' data-dismiss='modal'>Close</button>
				        
				      </div>
				    </div>
				  </div>
				</div>";
			
		
 			echo "<a href=logout.php>Logout</a><br>"; 
 			} 
 			//admin menu button
 			if($info['role']=="Admin"){
 				echo "<a class='btn btn-lg btn-danger' type='button' href='#'>Admin menu</a>";
 			}
 		}//end of while check 

 	}//end of IF ID_my_site 

else 
 //if the cookie does not exist, they are taken to the login screen 
	{			 
	// header("Location: login.php"); 
	//include 'login.php';
	 } 

 ?> 
