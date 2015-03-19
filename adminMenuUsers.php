<?php
$display_block.= "<h1 class='text-center'>Vartotojai</h1>";

		 	$display_block.="   <table class='table tableStuff text-center table-responsive table-striped table-bordered' cellspacing='0' width='100%'>
							        <thead>
							            <tr>
							                <th class='text-center'>Vartotojas</th>
							                <th class='text-center'>Vardas ir pavardė</th>
							                <th class='text-center'>El. Paštas</th>
							                <th class='text-center'>Miestas</th>
							                <th class='text-center'>Pašto kodas</th>
							                <th class='text-center'>Telefono Nr.</th>
							                <th class='text-center'>Užsiregistravimo data</th>
							                <th class='text-center'>Statusas</th>
							            </tr>
							        </thead>
							 
							        <tfoot>
							            <tr>
							                <th class='text-center'>Vartotojas</th>
							                <th class='text-center'>Vardas ir pavardė</th>
							                <th class='text-center'>El. Paštas</th>
							                <th class='text-center'>Miestas</th>
							                <th class='text-center'>Pašto kodas</th>
							                <th class='text-center'>Telefono Nr.</th>
							                <th class='text-center'>Užsiregistravimo data</th>
							                <th class='text-center'>Statusas</th>
							            </tr>
							        </tfoot>

							        <tbody>";
							    $get_users_sql = "SELECT * FROM users";
							    $get_users_res = mysqli_query($mysqli, $get_users_sql) or die(mysqli_error($mysqli));

							    while($user = mysqli_fetch_array($get_users_res)){
							    	$user_username = $user['username'];
							    	$user_name = $user['name'];
							    	$user_email = $user['email'];
							    	$user_city = $user['city'];
							    	$user_zip = $user['zip'];
							    	$user_phone = $user['phone'];
							    	$user_role = $user['role'];
							    	$user_date = $user['date'];
							    
							$display_block.="
										<tr>
							                <td>$user_username</td>
							                <td>$user_name</td>
							                <td>$user_email</td>
							                <td>$user_city</td>
							                <td>$user_zip</td>
							                <td>$user_phone</td>
							                <td>$user_date</td>
							         		<td>$user_role <button style='float:right' type='button' class='btn btn-default' data-toggle='modal' data-target='#".$user['ID']."'>
									        	<span class='glyphicon glyphicon-cog'></span>
									        	</button>
									        </td>
							            </tr>";
$display_block.="<!-- edit role Modal -->
<div class='modal fade' id='".$user['ID']."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>Pakeisti vartotojo statusą</h4>
			</div>	

			<form class='form-horizontal' id='myForm' method='post' >
			<div class='modal-body'>
			<p><b>Vardas ir pavardė:</b> $user_name <br> <b>Vartotojo vardas:</b> $user_username <br> <b>El. Paštas:</b> $user_email <br> <b>Statusas:</b>
				<select  class='selectOption' id='inputRole' style='width:50%' name='selectRole'>";

				//get 'role' enum values
				$result = mysqli_query($mysqli, "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
				    WHERE TABLE_NAME = 'users' AND COLUMN_NAME = 'role'")or die (mysqli_error());
				$row = mysqli_fetch_array($result);
				$row_num = mysqli_num_rows($result);
				
				$enumList = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));
				for($i = 0; $i<=1; $i++){
					$display_block.="<option value='".$enumList[$i]."'>".$enumList[$i]."</option>";
				}			
$display_block.="</select>
			</p>
			</div>

			<div class='modal-footer'>
				<button type='button' class='btn btn-default' data-dismiss='modal'>Uždaryti</button>
				<button type='submit' value='".$user_username."' name='submitRole' class='btn btn-primary'>Išsaugoti</button>
			</div>
			</form>";
			
			
$display_block.="
		</div>
	</div>
</div>";
							        }//end of while user
					if(isset($_POST['selectRole'])){//if 'role' form is submitted
						$insert_role_sql = "UPDATE users SET role = '".$_POST['selectRole']."' WHERE username = '".$_POST['submitRole']."'";
						$insert_role_res = mysqli_query($mysqli, $insert_role_sql) or die(mysqli_error($mysqli));
						echo("<meta http-equiv='refresh' content='0'>");//reflesh page
						}		      

				$display_block.="   </tbody>
							    </table>";  