<?php
$display_block.= "<h1 class='text-center'>Kategorijos prekės</h1>";
	 						$display_block.="<div class='row'> <div class='col-md-2 col-md-offset-10'>				
	 							<button type='button' name='buttonAddItem' class='btn btn-primary' data-toggle='modal' data-target='#addItem'><span class='glyphicon glyphicon-plus' aria-hidden='true'></span> Įdėti prekę</button>
	 						</div></div>";

			 
?>
<script type="text/javascript">
	$(document).ready(function(){
//Below line will get value of Category and store in id
$("#addCategory").change(function()
{
var id=$(this).val();
var dataString = 'id='+ id;
$.ajax
({
type: "POST",
url: "ajaxSubCat.php",
data: dataString,
cache: false,
success: function(html)
{
//This will get values from Ajax_SubCategory.php and show in Subcategory Select option
$("#addSubCategory").html(html);
} 
});
});							
	});
</script>   

<?php 
$display_block.="<!-- add item Modal -->
<div class='modal fade' id='addItem' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center'>Įdėti naują prekę</h4>
			</div>

			<form class='form-horizontal'  method='post' enctype='multipart/form-data'>
				<div class='modal-body'>
					<div class='form-group'>
						<div class='row margin-top'>	
							<label for='inputImage'  class='col-md-4 control-label'>Pasirinkite paveikslėlį<span style='color: red; padding-left: 2px;'>*</span></label>
							<div class='col-md-8'>
								
								<input name='addIMG' required type='file' /> 
								<p>Paveikslėlio dydis turi būti mažesnis nei 2MB</p> 
							</div>
						</div>	

						<div class='row margin-top'>
							<label for='inputName3' class='col-md-4 control-label'>Pavadinimas LT<span style='color: red; padding-left: 2px;'>*</span></label>
							<div class='col-md-8'>
								<input type='text' required name='addTitle' class='form-control' >							
							</div>
						</div>

						<div class='row margin-top'>
							<label for='inputName5' class='col-md-4 control-label'>Pavadinimas EN<span style='color: red; padding-left: 2px;'>*</span></label>
							<div class='col-md-8'>
								<input type='text' required name='addTitleEn' class='form-control' >							
							</div>
						</div>

						<div class='row margin-top'>	
							<label for='inputPrice' class='col-md-4 control-label'>Kaina<span style='color: red; padding-left: 2px;'>*</span></label>
							<div class='col-md-8'>
								<input type='number' min='0' required step='any' name='addPrice' class='form-control'  >
							</div>
						</div>	

						<div class='row margin-top'>	
							<label for='inputqty' class='col-md-4 control-label'>Kiekis<span style='color: red; padding-left: 2px;'>*</span></label>
							<div class='col-md-8'>
								<input type='number' min='0' required step='any' name='addqty' class='form-control'  >
							</div>
						</div>

						<div class='row margin-top'>	
							<label for='inputCategory' required class='col-md-4 control-label'>Pasirinkite kategoriją<span style='color: red; padding-left: 2px;'>*</span></label>
							<div class='col-md-8'>
	<!--  KATEGORIJOS	-->		<select class='selectOption' id='addCategory' style='width:100%'  name='addItemCategory'>";
													
								//get all categories for select option
								$select_addcat_sql = "SELECT * FROM store_categories WHERE sorting_id !='99999999' AND sorting_id !='88888888' ";
								$select_addcat_res = mysqli_query($mysqli, $select_addcat_sql) or die(mysqli_error($mysqli));
										
								//selected category
									while($cat = mysqli_fetch_array($select_addcat_res)){
										$cat_id = $cat['id'];
										$cat_title = $cat['cat_title'];
										$display_block .="<option  value='".$cat_id."'>$cat_title</option>";
										} 
																	
				$display_block .="
								</select>
							</div>
						</div>	

						<div class='row margin-top'>	
							<label for='inputSubCategory' id='sub_title' class='col-md-4 control-label '>Pasirinkite sub kategoriją </label>
									
							<div class='col-md-8'>
				<!--subcategories-->				
								<select name='addSubCategories' style='width:100%' id='addSubCategory'>	
											  
								</select>	
							</div>
						</div>	

						<div class='row margin-top'>	
							<label for='inputDescription' class='col-md-4 control-label'>Apibūdinimas LT</label>
							<div class='col-md-8'>
								
								<textarea  class='form-control' name='addDescription' rows='3'></textarea>
							</div>
						</div>	
						<div class='row margin-top'>	
							<label for='inputDescription' class='col-md-4 control-label'>Apibūdinimas EN</label>
							<div class='col-md-8'>
								
								<textarea  class='form-control' name='addDescriptionEN' rows='3'></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class='modal-footer'>
				 	<button type='button' class='btn btn-default' data-dismiss='modal'>Uždaryti</button>
				 	<button type='submit' name='submitAddItem' value='Submit' class='btn btn-primary'>Pridėti</button>
				</div>
		 	</form>
		</div>
	</div>
</div>";	


	//submit edit form	Upload image only	
if(isset($_POST["submitAddItem"])) {
	// Check if image file is a actual image or fake image
	if ($_FILES["addIMG"]["size"] != 0){ 	
		$target_dir = "images/";
		$target_file = $target_dir . basename($_FILES["addIMG"]["name"]);
		$uploadOk1 = 1;//check if no error found
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	    $check = getimagesize($_FILES["addIMG"]["tmp_name"]);
	    if($check !== false) {
	        $uploadOk1 = 1;
	    } else {
	        echo"<div class='alert alert-danger alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				Pasirinktas failas nėra paveikslėlis.
			</div>";
	        $uploadOk1 = 0;
	    }
	    // Check if file already exists
		if (file_exists($target_file)) {

		    echo"<div class='alert alert-danger alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				Toks paveikslėlio pavadinimas jau egzistuoja.
			</div>";
		    $uploadOk1 = 0;
		}
		// Check file size
		if ($_FILES["addIMG"]["size"] > 5000000) {//5MB
		    echo"<div class='alert alert-danger alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				Paveikslėlis per didelis.
			</div>";
		    $uploadOk1 = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		   
			echo"<div class='alert alert-danger alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				Tik .JPG, .JPEG, .PNG ir .GIF formatai galimi.
			</div>";
		    $uploadOk1 = 0;
		}
			

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk1 == 1) 
		    {
		    	move_uploaded_file($_FILES["addIMG"]["tmp_name"], $target_file);
		        //update item content
				//check for input errors
				if(isset($_POST['addSubCategories'])){
					$update_store_item = "INSERT INTO store_items (cat_id, item_title, item_price, item_desc, item_image, subcat_id, item_title_EN, item_desc_EN, qty,item_price_old)VALUES(
					'".$_POST['addItemCategory']."',
					'".$_POST['addTitle']."',
					'".$_POST['addPrice']."',
					'".$_POST['addDescription']."',
					'images/".basename( $_FILES["addIMG"]["name"])."',
					'".$_POST['addSubCategories']."',
					'".$_POST['addTitleEn']."',
					'".$_POST['addDescriptionEN']."',
					'".$_POST['addqty']."',
					NULL)";
	
					$update_store_item_res = mysqli_query($mysqli, $update_store_item);
				}else{
					$update_store_item = "INSERT INTO store_items (cat_id, item_title, item_price, item_desc, item_image, item_title_EN, item_desc_EN, qty,item_price_old)VALUES(
					'".$_POST['addItemCategory']."',
					'".$_POST['addTitle']."',
					'".$_POST['addPrice']."',
					'".$_POST['addDescription']."',
					'images/".basename( $_FILES["addIMG"]["name"])."',
					'".$_POST['addTitleEn']."',
					'".$_POST['addDescriptionEN']."',
					'".$_POST['addqty']."',
					NULL)";
					$update_store_item_res = mysqli_query($mysqli, $update_store_item);
				}
						
						//echo("<meta http-equiv='refresh' content='0'>");//reflesh page
			}
	}else{
			echo"<div class='alert alert-danger alert-dismissible' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					Paveikslėlio dydis per didelis.
				</div>";
		 }		        
					
}//end of add new item

	 		$display_block.="<div class='row'>
	 						   <table class='table tableStuff text-center table-responsive table-striped table-bordered' cellspacing='0' width='100%'>
							        <thead>
							            <tr>
							                <th>Nuotrauka</th>
							                <th>Pavadinimas</th>
							                <th>Kaina</th>
							                <th>Sena kaina</th>
							                <th>Kiekis</th>
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
							                <th>Sena kaina</th>
							                <th>Kiekis</th>
							                <th>Kategorija</th>
							                <th>Sub kategorija</th>
							                <th>Veiksmai</th>
							            </tr>
							        </tfoot>
							 
							        <tbody>";
							               //ITEMS TABLE
	 						$get_items_sql = "SELECT * FROM store_items WHERE nav_id IS NULL ORDER BY id DESC";
	 						$get_items_res = mysqli_query($mysqli, $get_items_sql) or die(mysqli_error($mysqli));
	 						
	 						while($item = mysqli_fetch_array($get_items_res)){ 
	 							$item_id = $item['id'];
	 							$item_cat_id = $item['cat_id'];
	 							$item_title = $item['item_title'];
	 							$item_title_EN = $item['item_title_EN'];
	 							$item_price = $item['item_price'];
	 							$item_price_old = $item['item_price_old'];
	 							$item_desc = $item['item_desc'];
	 							$item_desc_EN = $item['item_desc_EN'];
	 							$item_image = $item['item_image'];
	 							$item_subcat_id = $item['subcat_id'];
	 							$store_item_qty = $item['qty'];

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
							                <td><a href='showitem.php?lang=".$_GET['lang']."&item_id=$item_id' target='_blank'>$item_title</a></td>
							                <td>$item_price &euro;</td>
							                <td>$item_price_old &euro;</td>
							                <td>$store_item_qty</td>
							                <td>$cat_title</td>
							                <td>$get_subTitle</td>
							                <td> <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#".$item_id."'>
												  Redaguoti
												</button>
												<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#deleteItem".$item_id."'>
												  Naikinti
												</button>
											</td>
							            </tr>";

$display_block.="<!-- Delete Item Modal -->
<div class='modal fade' id='deleteItem".$item_id."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>Ar tikrai norite ištrinti ".$item_title."?</h4>
			</div>
			<form class='form-horizontal' method='post' >
				
				<div class='margin-bottom15 text-center'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Uždaryti</button>
					<input type='hidden' name='delete_image' value='".$item_image."'>
					<button type='submit' value='".$item_id."' name='deleteItem' class='btn btn-primary'>Ištrinti</button>
				</div>
			</form>
		</div>
	</div>				
</div>";

							           
			 
?>
<script type="text/javascript">
	$(document).ready(function(){
//Below line will get value of Category and store in id
$("#search_category_id<?php echo $item_id ?>").change(function()
{
var id=$(this).val();
var dataString = 'id='+ id;
$.ajax
({
type: "POST",
url: "ajaxSubCat.php",
data: dataString,
cache: false,
success: function(html)
{
//This will get values from Ajax_SubCategory.php and show in Subcategory Select option
$("#subCategory<?php echo $item_id ?>").html(html);
} 
});
});							
	});
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
										<p>Paveikslėlis turi būti mažesnis nei 2MB</p> 
									</div>
								</div>	

								<div class='row margin-top'>
									<label for='inputName3' class='col-md-4 control-label'>Pavadinimas LT<span style='color: red; padding-left: 2px;'>*</span></label>
									<div class='col-md-8'>
										<input type='text' name='title' required value='$item_title' class='form-control'  >							
									</div>
								</div>

								<div class='row margin-top'>
									<label for='inputName3' class='col-md-4 control-label'>Pavadinimas EN<span style='color: red; padding-left: 2px;'>*</span></label>
									<div class='col-md-8'>
										<input type='text' name='titleEN' required value='$item_title_EN' class='form-control' >							
									</div>
								</div>

								<div class='row margin-top'>	
									<label for='inputPrice' class='col-md-4 control-label'>Kaina<span style='color: red; padding-left: 2px;'>*</span></label>
									<div class='col-md-8'>
										<input type='number' min='0' step='any' required name='price' value='$item_price' class='form-control' id='inputPrice' >
									</div>
								</div>	

								

								<div class='row margin-top'>	
									<label for='inputPrice' class='col-md-4 control-label'>Sena kaina</label>
									<div class='col-md-8'>
										<input type='number' step='any' name='priceOld' value='$item_price_old' class='form-control'  >
									</div>
								</div>	

								<div class='row margin-top'>	
									<label for='inputqty' class='col-md-4 control-label'>Kiekis<span style='color: red; padding-left: 2px;'>*</span></label>
									<div class='col-md-8'>
										<input type='number' min='0' required step='any' name='qty' value='$store_item_qty' class='form-control'  >
									</div>
								</div>
								
								<div class='row margin-top'>	
									<label for='inputCategory' class='col-md-4 control-label'>Kategorija<span style='color: red; padding-left: 2px;'>*</span></label>
									<div class='col-md-8'>
			<!--  KATEGORIJOS	-->		<select class='selectOption' required id='search_category_id".$item_id."' style='width:100%'  name='showCategory'>";
													

										//get all categories for select option
										
										$select_cat_sql = "SELECT * FROM store_categories WHERE sorting_id !='88888888' AND sorting_id !='99999999' ";
										$select_cat_res = mysqli_query($mysqli, $select_cat_sql) or die(mysqli_error($mysqli));
										
										//selected category
										$display_block .="<option value='".$item_cat_id."'>$cat_title</option>";
										//other categories
											while($cat = mysqli_fetch_array($select_cat_res)){

												if($item_cat_id != $cat['id']){
													$cat_id = $cat['id'];
													$cat_title = $cat['cat_title'];
													$display_block .="<option  value='".$cat_id."'>$cat_title</option>";
													}
												
												} 									
						$display_block .="
										</select>
									</div>
								</div>	

								<div class='row margin-top'>	
									<label for='inputSubCategory' id='show_heading' class='col-md-4 control-label'>Sub kategorija</label>
									
									<div class='col-md-8'>
						<!--subcategories-->				

									
										<select name='show_sub_categories'  style='width:100%' id='subCategory".$item_id."'>	
											  
										</select>	
									</div>
								</div>	

								<div class='row margin-top'>	
									<label for='inputDescription' class='col-md-4 control-label'>Apibūdinimas LT</label>
									<div class='col-md-8'>
										<textarea class='form-control' value='$item_desc' name='description' rows='3'>$item_desc</textarea>
									</div>
								</div>

								<div class='row margin-top'>	
									<label for='inputDescriptionEN' class='col-md-4 control-label'>Apibūdinimas EN</label>
									<div class='col-md-8'>
										<textarea class='form-control' value='$item_desc_EN' name='descriptionEN' rows='3'>$item_desc_EN</textarea>
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
//delete item							
if(isset($_POST['deleteItem'])){

	$delete_item = "DELETE FROM store_items where id='".$_POST['deleteItem']."'";
	$delete_item_sql = mysqli_query($mysqli, $delete_item);
	unlink($_POST['delete_image']);//delete old image
	echo("<meta http-equiv='refresh' content='0'>");//reflesh page
}

	//submit edit form	Upload image only	
if(isset($_POST["submitEditItem"])) {
	// Check if image file is a actual image or fake image
	$uploadOk = 1;//check if no error found
	if ($_FILES["itemIMG"]["size"] != 0){ 	
			$target_dir = "images/";
		$target_file = $target_dir . basename($_FILES["itemIMG"]["name"]);
		
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
			</div>";
		    }
		}
	}//end of upload image
	//update item content
	//check for input errors

	

	if(isset($_POST['priceOld']) && $_POST['priceOld']=='' && $uploadOk== 1){
		if(isset($_POST['show_sub_categories'])){
			$update_store_item = "UPDATE store_items SET cat_id = '".$_POST['showCategory']."', item_title = '".$_POST['title']."', item_title_EN = '".$_POST['titleEN']."',
			item_price = '".$_POST['price']."', item_desc = '".$_POST['description']."', item_desc_EN = '".$_POST['descriptionEN']."', subcat_id = '".$_POST['show_sub_categories']."',qty = '".$_POST['qty']."' ,item_price_old=NULL WHERE id='".$_POST['getItem_id']."'";
			$update_store_item_res = mysqli_query($mysqli, $update_store_item);
		}else{
			$update_store_item = "UPDATE store_items SET cat_id = '".$_POST['showCategory']."', item_title = '".$_POST['title']."', item_title_EN = '".$_POST['titleEN']."',
			item_price = '".$_POST['price']."', item_desc = '".$_POST['description']."', item_desc_EN = '".$_POST['descriptionEN']."', qty = '".$_POST['qty']."', item_price_old=NULL WHERE id='".$_POST['getItem_id']."'";
			$update_store_item_res = mysqli_query($mysqli, $update_store_item);
		}
		echo("<meta http-equiv='refresh' content='0'>");//reflesh page
	}else
		{
		if($uploadOk== 1){
			if(isset($_POST['show_sub_categories'])){
				$update_store_item = "UPDATE store_items SET cat_id = '".$_POST['showCategory']."', item_title = '".$_POST['title']."', item_title_EN = '".$_POST['titleEN']."',
				item_price = '".$_POST['price']."', item_desc = '".$_POST['description']."', item_desc_EN = '".$_POST['descriptionEN']."', subcat_id = '".$_POST['show_sub_categories']."', qty = '".$_POST['qty']."', item_price_old='".$_POST['priceOld']."' WHERE id='".$_POST['getItem_id']."'";
				$update_store_item_res = mysqli_query($mysqli, $update_store_item);
			}else{
				$update_store_item = "UPDATE store_items SET cat_id = '".$_POST['showCategory']."', item_title = '".$_POST['title']."', item_title_EN = '".$_POST['titleEN']."',
				item_price = '".$_POST['price']."', item_desc = '".$_POST['description']."', item_desc_EN = '".$_POST['descriptionEN']."', qty = '".$_POST['qty']."', item_price_old='".$_POST['priceOld']."' WHERE id='".$_POST['getItem_id']."'";
				$update_store_item_res = mysqli_query($mysqli, $update_store_item);
			}
			echo("<meta http-equiv='refresh' content='0'>");//reflesh page
		}
	}
}//end of submitEdit item