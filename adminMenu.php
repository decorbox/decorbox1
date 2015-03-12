
<?php 

//Connects to your Database 
include 'connect.php';
include 'library.php'; 
?>
<script type="text/javascript">//load table stuff
$(document).ready(function() {
    $('.tableStuffOrderDesc').dataTable({
    	"order": [[ 0, "desc" ]]//order desc
    });
    $('.tableStuff').dataTable();//order asc
} );

$(document).ready(function() {
  	$(".selectOption").select2({ minimumResultsForSearch: Infinity });//run sorting, INFINITY PASLEPE SEARCH BAR
});
</script>


<?php
$display_block ="";

//checks cookies to make sure they are logged in 
if(isset($_COOKIE['ID_my_site'])) 
	{ 	
 	$username = $_COOKIE['ID_my_site']; 
 	$pass = $_COOKIE['Key_my_site']; 
 	$check = mysqli_query($mysqli, "SELECT * FROM users WHERE username = '$username'")or die(mysqli_error()); 
 	while($info = @mysqli_fetch_array( $check )) // @ - disable DUMB warning when image is uploaded	 
 		{ 
 //if the cookie has the wrong password, they are taken to the login page 
 		if ($pass != $info['password']) 
 			{ 			//header("Location: login.php"); //login 
 				echo "<div class='row'><div class='col-md-4 col-md-offset-4' ><h1 class='text-center'>Prašome prisijungti</h1>";
 				include 'login.php';
 				echo "</div></div>";
 			} 

 //otherwise they are shown the admin area	 
 		else 
 			{	if($info['role']!="Admin"){echo "<h1>Jūs nesate administratorius</h1>";}
	 			if($info['role']=="Admin"){
	 				//admin menu
	 				$display_block .= "
	 				
	 					<div class='row'>
	 						<div class='col-md-12'>
	 							<h1 class='text-center'>Valdymo skydas</h1>
	 						</div>
	 					</div>
	 					<div class='row'>
	 						<div class='col-md-2 border-color'>
	 							<div class='list-group'>
	 								<a href='".$_SERVER['PHP_SELF']. "?menu=vartotojai' class='list-group-item '>
							            <span class='glyphicon glyphicon-user'></span> Vartotojai
							        </a>
							        <a href='".$_SERVER['PHP_SELF']. "?menu=prekes' class='list-group-item'>
							            <span class='glyphicon glyphicon-file'></span> Prekės
							        </a>
							        <a href='".$_SERVER['PHP_SELF']. "?menu=kategorijos' class='list-group-item'>
							            <span class='glyphicon glyphicon-th-list'></span> Kategorijos
							        </a>
							        <a href='".$_SERVER['PHP_SELF']. "?menu=uzsakymai' class='list-group-item'>
							            <span class='glyphicon glyphicon-shopping-cart'></span> Užsakymai
							        </a>
	 							</div>
	 						</div>
	 				
	 						<div class='col-md-10 border-color'>";
	//----------VARTOTOJAI PUSLAPIS	 						
		 				if(isset($_GET['menu']) && $_GET['menu']=='vartotojai'){
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
		 				}//END OF USER PAGE		
	//---------PREKES puslapis		
		 				if(isset($_GET['menu']) && $_GET['menu']=='prekes'){
	 						$display_block.= "<h1 class='text-center'>Prekės</h1>";
	 						$display_block.="<div class='row'> <div class='col-md-2 col-md-offset-10'>				
	 							<button type='button' name='buttonAddItem' class='btn btn-primary' data-toggle='modal' data-target='#addItem'><span class='glyphicon glyphicon-plus' aria-hidden='true'></span> Įdėti prekę</button>
	 						</div></div>";

$display_block.="<!-- add item Modal -->
<div class='modal fade' id='addItem' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>Įdėti prekę</h4>
			</div>

			<div class='modal-body'>
			body
			</div>

			<div class='modal-footer'>
				<button type='button' class='btn btn-default' data-dismiss='modal'>Uždaryti</button>
			 	<button type='submit' name='submitEdit' value='Submit' class='btn btn-primary'>Išsaugoti</button>
		  	</div>
		</div>
	</div>
</div>";	
	 		$display_block.="<div class='row'>
	 						   <table class='table tableStuff text-center table-responsive table-striped table-bordered' cellspacing='0' width='100%'>
							        <thead>
							            <tr>
							                <th>Nuotrauka</th>
							                <th>Pavadinimas</th>
							                <th>Kaina</th>
							                <th>Kategorija</th>
							                <th>Sub kategorija</th>
							                <th>Veiksmai</th>
							            </tr>
							        </thead>
							 
							        <tfoot>
							            <tr>
							                <th>Nuotrauka</th>
							                <th>Pavadinimas</th>
							                <th>Kaina</th>
							                <th>Kategorija</th>
							                <th>Sub kategorija</th>
							                <th>Veiksmai</th>
							            </tr>
							        </tfoot>
							 
							        <tbody>";
							               //ITEMS TABLE
	 						$get_items_sql = "SELECT * FROM store_items";
	 						$get_items_res = mysqli_query($mysqli, $get_items_sql) or die(mysqli_error($mysqli));

	 						while($item = mysqli_fetch_array($get_items_res)){
	 							$item_id = $item['id'];
	 							$item_cat_id = $item['cat_id'];
	 							$item_title = $item['item_title'];
	 							$item_price = $item['item_price'];
	 							$item_desc = $item['item_desc'];
	 							$item_image = $item['item_image'];
	 							$item_subcat_id = $item['subcat_id'];

	 							//get catgerogy title
	 							$get_cat_title_sql = "SELECT cat_title FROM store_categories WHERE id ='".$item_cat_id."'";
	 							$get_cat_title_res = mysqli_query($mysqli, $get_cat_title_sql) or die(mysqli_error($mysqli));
	 							$cat_title_res = mysqli_fetch_assoc($get_cat_title_res);
	 							$cat_title = $cat_title_res['cat_title'];
	 							
	 							//get subcategory title
	 							$get_subcat_title_sql = "SELECT subcat_title FROM store_subcategories WHERE cat_id='".$item_cat_id."' AND subcat_id='".$item_subcat_id."'";
	 							$get_subcat_title_res = mysqli_query($mysqli, $get_subcat_title_sql) or die(mysqli_error($mysqli));
	 							$get_subTitle_res = mysqli_fetch_assoc($get_subcat_title_res);
	 							$get_subTitle = $get_subTitle_res['subcat_title'];

	 							
						$display_block.="<tr>
							                <td><img class='adminImgSize' src='$item_image'></td>
							                <td><a href='showitem.php?item_id=$item_id' target='_blank'>$item_title</a></td>
							                <td>&euro;$item_price</td>
							                <td>$cat_title</td>
							                <td>$get_subTitle</td>
							                <td> <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#".$item_id."'>
												  Redaguoti
												</button>
												<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#deleteItem'>
												  Naikinti
												</button>
											</td>
							            </tr>";
							           

?>
<script type="text/javascript">
$(document).ready(function() {

	$('#show_heading').hide();
	$('#search_category_id').change(function(){
		$('#show_sub_categories').fadeOut();
		//$('#loader').show();
		$.post("ajaxSubcategories.php", {
			parent_id: $('#search_category_id').val(),
			
		}, function(response){
			
			setTimeout("finishAjax('show_sub_categories', '"+escape(response)+"')", 400);
		});
		return false;
	});
});

function finishAjax(id, response){
  $('#show_heading').show();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
} 

function alert_id()
{
	if($('#sub_category_id').val() == '')
	alert('Please select a sub category.');
	else
	alert($('#sub_category_id').val());
	return false;
}
</script>
<?php		
							            //modals area
$display_block.="<!-- edit item Modal -->
<div class='modal fade' id='".$item_id."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>Redaguoti prekę</h4>
				</div>								      	 
					<form class='form-horizontal'  method='post' enctype='multipart/form-data'>
						<div class='modal-body'>
							<div class='form-group'>
								<div class='row margin-top'>	
									<label for='inputImage'  class='col-md-4 control-label'><img class='inputImage' src='$item_image'></label>
									<div class='col-md-8'>
										<input type='hidden' name='oldImage' value='".$item_image."'>
										<input name='itemIMG' type='file' /> 
										<p>Paveikslėlis 
									</div>
								</div>	

								<div class='row margin-top'>
									<label for='inputName3' class='col-md-4 control-label'>Pavadinimas</label>
									<div class='col-md-8'>
										<input type='text' name='pavadinimas' value='$item_title' class='form-control' id='inputName3' >							
									</div>
								</div>

								<div class='row margin-top'>	
									<label for='inputPrice' class='col-md-4 control-label'>Kaina</label>
									<div class='col-md-8'>
										<input type='text' name='price' value='$item_price' class='form-control' id='inputPrice' >
									</div>
								</div>	

								<div class='row margin-top'>	
									<label for='inputCategory' class='col-md-4 control-label'>Kategorija</label>
									<div class='col-md-8'>
									<select class='selectOption' id='search_category_id' style='width:100%'  name='category'>";
										//prie kategorijos ir subkateg SELECT pridet $item_id, ir java scripte			
										
							
										//get all categories for select option
										
										$select_cat_sql = "SELECT * FROM store_categories";
										$select_cat_res = mysqli_query($mysqli, $select_cat_sql) or die(mysqli_error($mysqli));
										//get subcat for select option
										//$select_subcat_sql = "SELECT * FROM store_subcategories";
										//$select_subcat_res = mysqli_query($mysqli, $select_subcat_sql) or die(mysqli_error($mysqli));
										
										//$display_block .="<option value='".$item_cat_id."'>$cat_title</option>";
										//categories
											while($cat = mysqli_fetch_array($select_cat_res)){

												//if($item_cat_id != $cat['id']){
													$cat_id = $cat['id'];
													$cat_title = $cat['cat_title'];
													$display_block .="<option  value='".$cat_id."'>$cat_title</option>";
													//}
												} 									
						$display_block .="
										</select>
									</div>
								</div>	

								<div class='row margin-top'>	
									<label for='inputSubCategory' id='show_heading' class='col-md-4 control-label'>Sub kategorija</label>
									
									<div class='col-md-8'>
						<!--subcategories-->				

										<div id='show_sub_categories'></div>

									</div>
								</div>	

								<div class='row margin-top'>	
									<label for='inputDescription' class='col-md-4 control-label'>Apibūdinimas</label>
									<div class='col-md-8'>
										<input type='text' name='description' value='$item_desc' class='form-control' id='inputDescription' >
									</div>
								</div>	
							</div>
						</div>
						<div class='modal-footer'>
						 	<button type='button' class='btn btn-default' data-dismiss='modal'>Uždaryti</button>
						 	<input type='hidden' value='".$item_id."' name='getItem_id'>
						 	<button type='submit' name='submitEditItem' value='Submit' class='btn btn-primary'>Išsaugoti</button>
					  	</div>
				 	</form>";									    
			$display_block.="
				</div>
		 	</div>
		</div>";
			  					}//end of main fetch array $get_items_res

					$display_block.="</tbody>
							</div></table>";//end of items table

	//submit edit form	Upload image only	
if(isset($_POST["submitEditItem"])) {
	// Check if image file is a actual image or fake image
	if ($_FILES["itemIMG"]["size"] != 0){ 	
			$target_dir = "images/";
		$target_file = $target_dir . basename($_FILES["itemIMG"]["name"]);
		$uploadOk = 1;//check if no error found
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	    $check = getimagesize($_FILES["itemIMG"]["tmp_name"]);
	    if($check !== false) {
	        $uploadOk = 1;
	    } else {
	        echo"<div class='alert alert-danger alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				Pasirinktas failas nėra paveikslėlis.
			</div>";
	        $uploadOk = 0;
	    }
	    // Check if file already exists
		if (file_exists($target_file)) {

		    echo"<div class='alert alert-danger alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				Toks paveikslėlio pavadinimas jau egzistuoja.
			</div>";
		    $uploadOk = 0;
		}
		// Check file size
		if ($_FILES["itemIMG"]["size"] > 5000000) {//5MB
		    echo"<div class='alert alert-danger alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				Paveikslėlis per didelis.
			</div>";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		   
			echo"<div class='alert alert-danger alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				Tik .JPG, .JPEG, .PNG ir .GIF formatai galimi.
			</div>";
		    $uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    echo"<div class='alert alert-danger alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				Paveikslėlis nebuvo atnaujintas.
			</div>";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["itemIMG"]["tmp_name"], $target_file)) {
		        unlink($_POST['oldImage']);//delete old image
		        //insert new image link to database
		        $insert_foto_sql = "UPDATE store_items SET item_image ='images/".basename( $_FILES["itemIMG"]["name"])."' WHERE id='".$_POST['getItem_id']."'";
		        $insert_foto_res = mysqli_query($mysqli, $insert_foto_sql) or die(mysqli_error($mysqli));
		        echo("<meta http-equiv='refresh' content='0'>");//reflesh page
		       
		    } else {
		        echo"<div class='alert alert-danger alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				Nutiko klaida atnaujinant paveikslėlį.
			</div>";;
		    }
		}
	}//end of upload image
	//update item content

}//end of submitEdit item
							    }//END OF ITEMS PAGE
	//------------KATEGORIJOS PUSLAPIS
					    if(isset($_GET['menu']) && $_GET['menu']=='kategorijos'){
					    	$display_block.= "<h1 class='text-center'>Kategorijos</h1>";
					    	$display_block .="<div class='row'> <div class='col-md-4 col-md-offset-8'>
					    	<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addCategory'><span class='glyphicon glyphicon-plus' aria-hidden='true'></span>Įdėti kategoriją</button>
					    	<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addSubCategory'><span class='glyphicon glyphicon-plus' aria-hidden='true'></span>Įdėti sub kategoriją</button>
					    	</div></div><br>";

$display_block.="<!-- Add category Modal -->
<div class='modal fade' id='addCategory' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>Įdėti kategoriją</h4>
			</div>
			<form class='form-horizontal' method='post'>
				<div class='modal-body'>
					<div class='form-group'>
						<div class='row margin-top'>
							<div class='col-md-12'>
								<input type='text' placeholder='Įveskite naują kategoriją' class='form-control input-lg text-center' name='inputNewCategory'>
							</div>
						</div>
					</div>				
				</div>

			<div class='modal-footer'>
				<button type='button' class='btn btn-default' data-dismiss='modal'>Uždaryti</button>
			 	<button type='submit' name='submitNewCategory' value='Submit' class='btn btn-primary'>Išsaugoti</button>
		  	</div>
		  	</form>
		</div>
	</div>
</div>";
//is submitted 'insert new category'
if(isset($_POST['submitNewCategory'])){
	if($_POST['inputNewCategory']==''){
		echo"<div class='alert alert-danger alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<strong>Dėmesio!</strong> Palikote tuščią kategorijos lauką, kategorija nebuvo sukurta.
			</div>";
	}else{
		$insert_new_cat = "INSERT INTO store_categories VALUES (NULL, '".$_POST['inputNewCategory']."')";
		$insert_res = mysqli_query($mysqli, $insert_new_cat) or die(mysqli_error($mysqli));

		echo"<div class='alert alert-success alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				Nauja kategorija pridėta.
			</div>";
	}
}


$display_block.="<!-- Add SubCategory Modal -->
<div class='modal fade' id='addSubCategory' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>Įdėti sub kategoriją</h4>
			</div>
			<form class='form-horizontal' method='post'>
				<div class='modal-body'>
					<div class='form-group'>
						<div class='row margin-top'>
							<div class='col-md-3'
								<label>Pasirinkite kategoriją:</label>
							</div>
							<div class='col-md-9'>
								<select  class='selectOption ' style='width:100%'  name='selectSubCategory'>";
								$get_cat = "SELECT * FROM store_categories";
								$get_cat_rs= mysqli_query($mysqli, $get_cat);

								while($cat = mysqli_fetch_array($get_cat_rs)){
									$cat_id=$cat['id'];
									$cat_title=$cat['cat_title'];
									$display_block.="<option value='".$cat_id."'>$cat_title</option>";
								}


			$display_block.="	</select>
							</div>
						</div>

						<div class='row margin-top'>
							<div class='col-md-12'>
								<input type='text' placeholder='Įveskite naują sub kategoriją' class='form-control input-lg text-center' name='inputNewSubCategory'>
							</div>
						</div>
					</div>
				</div>

				<div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Uždaryti</button>
				 	<button type='submit' name='submitNewSubcat' value='Submit' class='btn btn-primary'>Išsaugoti</button>
			  	</div>
		  	</form>
		</div>
	</div>
</div>";

if(isset($_POST['submitNewSubcat'])){
	if($_POST['inputNewSubCategory']==''){
		echo"<div class='alert alert-danger alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<strong>Dėmesio!</strong> Palikote tuščią sub kategorijos lauką, sub kategorija nebuvo sukurta.
			</div>";
	}else{
		$insert_subcat = "INSERT INTO store_subcategories VALUES ('".$_POST['selectSubCategory']."', NULL, '".$_POST['inputNewSubCategory']."')";
		$insert_subcat_res= mysqli_query($mysqli, $insert_subcat);
		echo"<div class='alert alert-success alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				Nauja sub kategorija pridėta.
			</div>";
	}
}
			$display_block.="<div class='row'>
	 						    <table class='table text-center table-responsive table-striped table-bordered' cellspacing='0' width='100%'>
							        <thead>
							            <tr>
							                <th class='text-center'>Kategorija</th>
							                <th class='text-center'>Sub kategorija</th>
							                <th class='text-center'>Veiksmai</th>
							            </tr>
							        </thead>
							 
							        <tfoot>
							            <tr>
							                <th class='text-center'>Kategorija</th>
							                <th class='text-center'>Sub kategorija</th>
							                <th class='text-center'>Veiksmai</th>
							            </tr>
							        </tfoot>
							 
							        <tbody>";
							    $get_cats_sql = "SELECT id, cat_title FROM store_categories ORDER BY cat_title";
								$get_cats_res = mysqli_query($mysqli, $get_cats_sql) or die(mysqli_error($mysqli));
								
								while ($cats = mysqli_fetch_array($get_cats_res)) //display categories
									{
									$cat_id = $cats['id'];
									$cat_title = $cats['cat_title'];

									$subcat_sql="SELECT * FROM store_subcategories where cat_id='".$cat_id."'";
       								$subcat_res= mysqli_query($mysqli, $subcat_sql) or die(mysqli_error($mysqli));

       								$display_block.="
				       						<tr>
				       							<td>$cat_title</td>
				       							<td>";

				       							if(mysqli_num_rows($subcat_res)==0){
				       								$display_block.="Nėra sub kategorijų";
				       							}else {
				       				$display_block.="<select class='selectOption' style='width:100%'>";
				       							//show subcats

							       				while($subcat = mysqli_fetch_array($subcat_res)){
								       				$subc_id = $subcat['subcat_id'];
								       				$subc_title = $subcat['subcat_title'];
								       				$display_block.="<option>$subc_title</option>";
							       				} 
				       			$display_block.="</select>";
				       							}//else
				       			$display_block.="</td>
				       							<td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#edit".$cat_id."'>
												  Redaguoti
												</button>
												<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#delete".$cat_id."'>
												  Naikinti
												</button>
												</td>
											<tr>
				       						";

	$display_block.="<!-- edit categories Modal -->
<div class='modal fade' id='edit".$cat_id."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>Redaguoti kategorijas</h4>
			</div>

			<div class='modal-body'>
				<form class='form-horizontal' method='post'>
					<div class='form-group'>
						<div class='row margin-top'>
							<label for='inputCat' class='col-md-12 text-center control-label'>Kategorija</label>
								<div class='col-md-12'>
									<input type='hidden' name='editCategoryId' value='$cat_id'>
									<input type='text'  name='editCategory' value='$cat_title' class='form-control input-lg' >							
								</div>
						</div>
						<br>
						<div class='row margin-top'>
							<label for='inputCat' class='col-md-12 text-center control-label'>Sub kategorijos</label>
						</div>
						";
				
       			$subcat_res= mysqli_query($mysqli, $subcat_sql) or die(mysqli_error($mysqli));
       			if(mysqli_num_rows($subcat_res)==0){
       				$display_block.="<label>Nėra sub kategorijų</label>";
       			}else{
					while($sub = mysqli_fetch_array($subcat_res)){
						$subct_id = $sub['subcat_id'];
						$subct_title = $sub['subcat_title'];
						$display_block.="
						<div class='row margin-top'>
							<div class='col-md-12'>
								<input type='hidden' name='editSubcategoryId".$subct_id."' value='$subct_id'>
								<input type='text' name='editSubcategory".$subct_id."' class='form-control' value='$subct_title'> 
							</div>
						</div>	
						";		
						}
					}//else	
	$display_block.="
					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Uždaryti</button>
					 	<button type='submit' name='submitEditCategory' value='Submit' class='btn btn-primary'>Atnaujinti</button>
			  		</div>
				</form>
			</div>

			
		</div>
	</div>
</div>";

$display_block.="<!-- Delete categories Modal -->
<div class='modal fade' id='delete".$cat_id."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>Ištrinti kategorijas</h4>
			</div>
			<form class='form-horizontal' method='post'>
				<div class='modal-body'>
					<div class='form-group'>
						<div class='row'>
							<div class='col-md-12'>
								<div class='alert alert-info alert-dismissible' role='alert'>
									<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
									<strong>Dėmesio!</strong> Jeigi ištrinsite kategoriją, bus ištrintos ir jos sub kategorijos.
								</div>
							</div>
						</div>
						<div class='row margin-top'>
							<div class='col-md-3 radio'>
								<label>
								<input type='radio' id='delCat' name='optionsRadios' value='1' checked> Ištrinti kategoriją
								</label>
							</div>
							<div class='col-md-9'>
							<!--	<select  class='selectOption ' style='width:100%'  name='selectCategory1'>-->";
								$select_cat = "SELECT * FROM store_categories WHERE id='".$cat_id."'";
								$select_cat_res = mysqli_query($mysqli, $select_cat);
								while($cat = mysqli_fetch_array($select_cat_res)){
									$c_id = $cat['id'];
									$c_title = $cat['cat_title'];
									$display_block.="
									<input type='hidden' name='selectCategory1' value='".$c_id."'>
									<input type='text' class='form-control' disabled value='".$c_title."'>";
								}
				$display_block.="<!--</select>-->
							</div>
						</div>

						<div class='row margin-top'>";
						$select_cat_res = mysqli_query($mysqli, $select_cat);
						$select_subcat = "SELECT * FROM store_subcategories WHERE cat_id='".$cat_id."'";
						$select_subcat_res = mysqli_query($mysqli, $select_subcat);

						if(mysqli_num_rows($select_subcat_res)==0){
							$display_block.="<label>Nėra sub kategorijų</label>";
						}else{
				$display_block.="
							<div class='col-md-3 radio'>
								<label>
								<input type='radio' id='delSubCat' name='optionsRadios' value='2'> Ištrinti sub kategoriją
								</label>
							</div>
							<div class='col-md-9 '>
								<select  class='selectOption ' style='width:100%'  name='selectSubCategory1'>";
								
									while($subc = mysqli_fetch_array($select_subcat_res)){
										$s_id= $subc['subcat_id'];
										$s_title = $subc['subcat_title'];
										$display_block.="<option value='".$s_id."'>$s_title</option>";
									}

					$display_block.="</select>
							</div>";
						}//end of else
		$display_block.="</div>

					</div>			
				</div>

				<div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Uždaryti</button>
				 	<button type='submit' name='submitDelete' value='Submit' class='btn btn-primary'>Ištrinti</button>
			  	</div>
		  	</form>
		</div>
	</div>
</div>"; 

	       						
				       				

								}//end of fetch categories
//if submit delete								
if(isset($_POST['submitDelete'])){
	if($_POST['optionsRadios']==1){//delete category
		$delete_cat="DELETE  FROM store_categories WHERE id='".$_POST['selectCategory1']."'";
		$delete_cat_res = mysqli_query($mysqli, $delete_cat) or die(mysqli_error($mysqli));
		
		$delete_sub="DELETE  FROM store_subcategories WHERE cat_id='".$_POST['selectCategory1']."'";
		$delete_sub_res=mysqli_query($mysqli, $delete_sub) or die(mysqli_error($mysqli));

		echo"<div class='alert alert-danger alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				Kategorija ir jos sub kategorijos buvo ištrintos.
			</div>";
	}else if($_POST['optionsRadios']==2){//delete sub category
		$delete_sub1="DELETE  FROM store_subcategories WHERE subcat_id='".$_POST['selectSubCategory1']."'";
		$delete_sub_res1=mysqli_query($mysqli, $delete_sub1) or die(mysqli_error($mysqli));
		echo"<div class='alert alert-danger alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				Sub kategorija buvo ištrinta.
			</div>";
	}
}			
								$display_block.="
				       				</tbody>
				       			</table>
				       		</div>
				       				";
					//if is submited edit category
						if(isset($_POST['submitEditCategory'])){

							$subcats_sql="SELECT * FROM store_subcategories where cat_id='".$_POST['editCategoryId']."'";
							$subcts_res= mysqli_query($mysqli, $subcats_sql) or die(mysqli_error($mysqli));
							
							while($sub = mysqli_fetch_array($subcts_res)){
								$sub_id = $sub['subcat_id'];
								$sub_title = $sub['subcat_title'];
							
							//check input	
								//if subcat input is empty write only subcategory title
								if($_POST['editSubcategory'.$sub_id.'']==''){
									//write only category title
									$update_cats = "UPDATE store_categories SET cat_title ='".$_POST['editCategory']."' WHERE id='".$_POST['editCategoryId']."'";
									$update_cats_res = mysqli_query($mysqli, $update_cats) or die(mysqli_error($mysqli));
									echo("<meta http-equiv='refresh' content='0'>");//reflesh page
									//alert
									echo"<div class='alert alert-danger alert-dismissible' role='alert'>
										  	<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
										  	<strong>Dėmesio!</strong> Buvo palikti tušti laukai sub kategorijose, tie laukai nebuvo atnaujinti.
										</div>";
										//if category title is empty
								}else if($_POST['editCategory']==''){
									//no data because ALERTS IS DOUBLEING
								}	//if everything ir good, update all
								else if(mysqli_num_rows($subcts_res)>=1){
							
									echo $_POST['editSubcategory'.$sub_id.''];
									echo "-->";
									echo $_POST['editSubcategoryId'.$sub_id.''];
									echo "<br>";
									$update_cats = "UPDATE store_categories SET cat_title ='".$_POST['editCategory']."' WHERE id='".$_POST['editCategoryId']."'";
									$update_cats_res = mysqli_query($mysqli, $update_cats) or die(mysqli_error($mysqli));

									$update_subcats = "UPDATE store_subcategories SET subcat_title ='".$_POST['editSubcategory'.$sub_id.'']."' WHERE cat_id='".$_POST['editCategoryId']."' AND subcat_id='".$_POST['editSubcategoryId'.$sub_id.'']."'"; 
									$update_subcats_res = mysqli_query($mysqli, $update_subcats) or die(mysqli_error($mysqli));
									echo("<meta http-equiv='refresh' content='0'>");//reflesh page
								}//end of else
								
							}//end of while
						//when is no subcategories
								//is category title is empty	
								if($_POST['editCategory']==''){
									echo"<div class='alert alert-danger alert-dismissible' role='alert'>
										  	<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
										  	<strong>Dėmesio!</strong> Kategorijos pavadinime buvo palikta tuščia eilute, pavadinimas nepakeistas.
										</div>";
								}//update category title	
								else if(mysqli_num_rows($subcts_res)==0){
									$update_cats = "UPDATE store_categories SET cat_title ='".$_POST['editCategory']."' WHERE id='".$_POST['editCategoryId']."'";
									$update_cats_res = mysqli_query($mysqli, $update_cats) or die(mysqli_error($mysqli));	
									echo("<meta http-equiv='refresh' content='0'>");//reflesh page
								}
						}//end if isset submitEditCategory


					    }//END OF CATEGORIES PAGE
    //-------------UZSAKYMAI PUSLAPIS

					    if(isset($_GET['menu']) && $_GET['menu']=='uzsakymai'){
					    	$display_modal_table ="";
					    	$display_block.= "<h1 class='text-center'> Užsakymai</h1>";
				$display_block.="<div class='row'>
	 						    <table class='table tableStuffOrderDesc text-center table-responsive table-striped table-bordered' cellspacing='0' width='100%'>
							        <thead>
							            <tr>
							                <th class='text-center'>ID</th>
							                <th class='text-center'>Vardas</th>
							                <th class='text-center'>Suma</th>
							                <th class='text-center'>Miestas</th>
							                <th class='text-center'>Adresas</th>
							                <th class='text-center'>El. Paštas</th>
							                <th class='text-center'>Telefono Nr.</th>
							                <th class='text-center'>Pašto kodas</th>
							                <th class='text-center'>Vartotojas</th>
							                <th class='text-center'>Statusas</th>
							                <th class='text-center'>Užsakymo Data</th>
							                <th class='text-center'>Veiksmai</th>
							            </tr>
							        </thead>
							 
							        <tfoot>
							            <tr>
							                <th class='text-center'>ID</th>
							                <th class='text-center'>Vardas</th>
							                
							                <th class='text-center'>Suma</th>
							                <th class='text-center'>Miestas</th>
							                <th class='text-center'>Adresas</th>
							                <th class='text-center'>El. Paštas</th>
							                <th class='text-center'>Telefono Nr.</th>
							                <th class='text-center'>Pašto kodas</th>
							                <th class='text-center'>Vartotojas</th>
							                <th class='text-center'>Statusas</th>
							                <th class='text-center'>Užsakymo Data</th>
							                <th class='text-center'>Veiksmai</th>
							            </tr>
							        </tfoot>
							 
							        <tbody>";

									$select_orders="SELECT * FROM store_orders";
									$select_orders_res = mysqli_query($mysqli, $select_orders);

									while($order = mysqli_fetch_array($select_orders_res)){
										$order_id = $order['order_id'];
										$order_date = $order['order_date'];
										$order_name = $order['order_name'];
										$order_address = $order['order_address'];
										$order_city = $order['order_city'];
										$order_zip = $order['order_zip'];
										$order_tel = $order['order_tel'];
										$order_email = $order['order_email'];
										//$order_item_total = $order['item_total'];
										$order_shipping_total = $order['shipping_total'];
										$order_authorization = $order['authorization'];
										$order_status = $order['status'];

							$display_block.="
										<tr>
											<td>$order_id</td>
											<td>$order_name</td>
											
											<td> &euro;$order_shipping_total</td>
											<td>$order_city</td>
											<td>$order_address</td>
											<td>$order_email</td>
											<td>$order_tel</td>
											<td>$order_zip</td>
											<td class='row_width'>$order_authorization</td>
											<td><div class='row'>$order_status</div>";
											//status icon
												if($order_status=="Atlikta"){
													$display_block.="<span style='color:green' class='glyphicon glyphicon-ok'></span>";
												}else{
													$display_block.="<span style='color:red' class='glyphicon glyphicon-remove'></span>";
												}
												$display_block.="
												 <button style='float:right' type='button' class='btn btn-default' data-toggle='modal' data-target='#status".$order_id."'>
												
									        	<span class='glyphicon glyphicon-cog'></span>
									        	</button>";
									        	
							$display_block.="</td>
											<td>$order_date</td>
											<td>
												<div class='row'>
													<div class='col-md-6'>
														<button type='button' class='btn btnLeft btn-danger' data-toggle='modal' data-target='#del".$order_id."'>
														  <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
														</button>
														</div>

														<div class='col-md-6'>
														<button type='button' class='btn btnLeft1 btn-success' data-toggle='modal' data-target='#items".$order_id."'>
														  <span class='glyphicon glyphicon-search' aria-hidden='true'></span>
														</button>
													</div>
												</div>
											</td>
										</tr>";

$display_block.="<!-- Edit Status Modal -->
<div class='modal fade' id='status".$order_id."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>Keisti statusą</h4>
			</div>
			<form class='form-horizontal' method='post' >
				<div class='modal-body'>
				<p><b>Vardas:</b> $order_name <br> <b>Vartotojo vardas:</b> $order_authorization <br> <b>El. Paštas:</b> $order_email <br> <b>Statusas:</b>
					<select  class='selectOption' style='width:50%' name='selectStatus'>";

					//get 'role' enum values
				$result = mysqli_query($mysqli, "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
				    WHERE TABLE_NAME = 'store_orders' AND COLUMN_NAME = 'status'") or die (mysqli_error($mysqli));
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
					<button type='submit' value='".$order_id."' name='submitStatus' class='btn btn-primary'>Išsaugoti</button>
				</div>
			</form>
		</div>
	</div>				
</div>";

$display_block.="<!-- Delete Order Modal -->
<div class='modal fade' id='del".$order_id."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>Ar tikrai norite ištrinti užsakymą, kurio ID yra ".$order_id."?</h4>
			</div>
			<form class='form-horizontal' method='post' >
				<div class='margin-bottom15 text-center'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Uždaryti</button>
					<button type='submit' value='".$order_id."' name='deleteOrder' class='btn btn-primary'>Ištrinti</button>
				</div>
			</form>
		</div>
	</div>				
</div>";


$display_modal_table.="<!-- Show Order Items Modal -->
<div class='modal fade' id='items".$order_id."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>Pirkėjo krepšelis</h4>
			</div>
			
			<div class='modal-body'>
				<table class='table tableStuff text-center table-responsive table-striped table-bordered' cellspacing='0' width='100%'>
					<thead>
			            <tr><th class='text-center'>Prekės ID</th>
			            	<th class='text-center'>Nuotrauka</th>
			            	<th class='text-center'>Pavadinimas</th>
						    <th class='text-center'>Kiekis</th>
					        <th class='text-center'>Visa Kaina</th>						              
			            </tr>
					</thead>
	 
					 <tbody>";			
			$show_orders_items = "SELECT * FROM store_orders_items_item WHERE order_id='".$order_id."'";
			$show_orders_items_res = mysqli_query($mysqli, $show_orders_items);
				
				while($items = mysqli_fetch_array($show_orders_items_res)){
					$item_id = $items['item_id'];
					$item_qty = $items['item_qty'];
					$item_full_price = $items['item_price'];

					$full_price_sql = "SELECT sel_item_price FROM store_orders_items WHERE order_id = '".$order_id."'";
					$full_price_res = mysqli_query($mysqli, $full_price_sql);
					$full_price1 = mysqli_fetch_assoc($full_price_res);
					$full_price = $full_price1['sel_item_price'];

					$show_item_sql = "SELECT item_title, item_image FROM store_items WHERE id = '".$item_id."'";
					$show_item_res = mysqli_query($mysqli, $show_item_sql);
					$show_item = mysqli_fetch_assoc($show_item_res);

	$display_modal_table.="
					<tr><td>$item_id</td>
						<td><img class='adminImgSize' src='".$show_item['item_image']."'></td>
						<td>".$show_item['item_title']."</td>
						<td>$item_qty</td>
						<td>&euro;$item_full_price</td>
					</tr>	
					";
				}
				
	$display_modal_table.="
					</tbody> 
					<tr style='color:red;'>
						<td class='text-right' colspan='4'><label>Galutinė kaina:</label></td>
						<td>&euro;<strong>$full_price</strong></td>

					</tr>
				</table>	
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-default' data-dismiss='modal'>Uždaryti</button>
			</div>		
		</div>
	</div>		
</div>";

									}//end of while order

//if submit status form									
if(isset($_POST['submitStatus'])){
	$update_status_sql = "UPDATE store_orders SET status = '".$_POST['selectStatus']."' WHERE order_id = '".$_POST['submitStatus']."'";
	$update_status_rs = mysqli_query($mysqli, $update_status_sql);
		echo("<meta http-equiv='refresh' content='0'>");//reflesh page
}
//if submit delete order
if(isset($_POST['deleteOrder'])){
	$del_order = "DELETE FROM store_orders WHERE order_id = '".$_POST['deleteOrder']."'";
	$del_order_res = mysqli_query($mysqli, $del_order);

	$del_order_items = "DELETE FROM store_orders_items WHERE order_id = '".$_POST['deleteOrder']."'";
	$del_order_items_res = mysqli_query($mysqli, $del_order_items);

	$del_order_items_item = "DELETE FROM store_orders_items_item WHERE order_id = '".$_POST['deleteOrder']."'";
	$del_order_items_item_res = mysqli_query($mysqli, $del_order_items_item);
	echo("<meta http-equiv='refresh' content='0'>");//reflesh page
}
						$display_block.="
									</tbody>
								</table>
							</div>		
						";			      
$display_block .= $display_modal_table; //add to display block modal table, because of error 2x table inside
					    }//end of uzsakymai page
					    else{
/*
?>
<script type="text/javascript">
$(document).ready(function() {

	$('#loader').hide();
	$('#show_heading').hide();
	
	$('#search_category_id').change(function(){
		$('#show_sub_categories').fadeOut();
		$('#loader').show();
		$.post("ajaxSubcategories.php", {
			parent_id: $('#search_category_id').val(),
		}, function(response){
			
			setTimeout("finishAjax('show_sub_categories', '"+escape(response)+"')", 400);
		});
		return false;
	});
});

function finishAjax(id, response){
  $('#loader').hide();
  $('#show_heading').show();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
} 

function alert_id()
{
	if($('#sub_category_id').val() == '')
	alert('Please select a sub category.');
	else
	alert($('#sub_category_id').val());
	return false;
}
</script>
<?php

				$display_block.=" <select id='search_category_id'>";
					    				$select_cat_sql = "SELECT * FROM store_categories";
										$select_cat_res = mysqli_query($mysqli, $select_cat_sql) or die(mysqli_error($mysqli));
										//get subcat for select option
										//$select_subcat_sql = "SELECT * FROM store_subcategories";
										//$select_subcat_res = mysqli_query($mysqli, $select_subcat_sql) or die(mysqli_error($mysqli));
										
										//$display_block .="<option value='".$item_cat_id."'>$cat_title</option>";
										//categories
											while($cat = mysqli_fetch_array($select_cat_res)){
												
												//if($item_cat_id != $cat['id']){
													$cat_id = $cat['id'];
													$cat_title = $cat['cat_title'];
													$display_block .="<option  value='".$cat_id."'>$cat_title</option>";
													}
												//}										
						$display_block .="
										</select>
									</div>
								</div>	
									<h4 id='show_heading'>Select Sub Category</h4>
									<div id='show_sub_categories' align='center'>
									</div>
											
										";*/
							}
					//	$display_block.="</select>";
					   // }



	 	$display_block.="   </div>
	 					</div>";//end of main page row
	 						
	 			}//end of admin page
 			}//end of while check 
 		}
 		echo $display_block;
	}//end of IF ID_my_site 

	else{ 
	 //if the cookie does not exist, they are taken to the login screen 
		echo "<div class='row'><div class='col-md-4 col-md-offset-4' ><h1 class='text-center'>Prašome prisijungti</h1>";
	 				include 'login.php';
	 	echo "</div></div>";		
		 } 

 ?> 
