<?php
//include 'library.php';


$display_block.= "<h1 class='text-center'>Idėjų galerija</h1>";

$display_block.="
<div class='row'>
	<div class='col-md-4 col-md-offset-8'>
		<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addPhoto'><span class='glyphicon glyphicon-plus' aria-hidden='true'></span>Įdėti naują</button>
		<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#sortingIdeas'><span class='glyphicon glyphicon-th-list' aria-hidden='true'></span> Rūšiuoti idėjas</button>
	</div>
</div>";


?>
<script>
$( document ).ready(function() {
    $("#sortable").sortable();
});


</script>
<!--
<script type="text/javascript">
     	 bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
     	bkLib.onDomLoaded(function() {

        //new nicEditor({buttonList : ['fontSize','bold','italic','underline','strikeThrough','left','center','right','justify','ul','ol','forecolor','html',]}).panelInstance('editor');
  		});
     </script>-->
<?php
//http://api.jqueryui.com/sortable/#entry-examples
//modalinis kopijuotas is kito puslapio
$display_block.="<!-- Sorting categories Modal -->
<div class='modal fade' id='sortingIdeas' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>Rūšiuoti idėjų galeriją</h4>
			</div>
			<form class='form-horizontal' method='post'>
				<div class='modal-body'>
					<div class='form-group'>
						<div class='row'>
							<div class='col-md-12'>
								<ol id='sortable' class='text-center list-group' style='margin:auto;'>";

								$show_cats="SELECT * FROM ideas_gallery ORDER BY sorting_id";
								$show_cats_res=mysqli_query($mysqli, $show_cats);
								$count_rows = 0;
								while($info = mysqli_fetch_array($show_cats_res)){
									$categ_title = $info['title'];
									$categ_id = $info['id'];
					$display_block.="<li><input type='hidden' name='categ_id".$categ_id."' value='$categ_id'>
										<div class='list-group-item list-group-item-info' >$categ_title</div>
									</li>";
								}
									
					$display_block.="				
								</ol>
							</div>
						</div>
					</div>				
				</div>

				<div class='modal-footer margin-top20'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Uždaryti</button>
					<button type='submit' name='submitSortingCategory' value='Submit' class='btn btn-primary'>Išsaugoti</button>
				</div>
		  	</form>
		</div>
	</div>
</div>";
if(isset($_POST['submitSortingCategory'])){
		$count=0;//count sorting value
	foreach ($_POST as $postName => $sorting_value)//gauna value is $_POST ir eiles tvarka iraso sorting
		{
			if("categ_id"+$sorting_value != $postName){
				$count +=1;
		     $update_sorting = "UPDATE ideas_gallery SET sorting_id = '".$count."' WHERE id='".$sorting_value."'";
		     $update_sorting_res = mysqli_query($mysqli, $update_sorting);
			}
		}
		echo"<div class='alert alert-success alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				Idėjų galerija surūšiuota.
			</div>";
}

$display_block.="<div class='row'>
	 						   <table class='table tableStuff text-center table-responsive table-striped table-bordered' cellspacing='0' width='100%'>
							        <thead>
							            <tr>
							                <th>Nuotrauka</th>
							                <th>Pavadinimas</th>
							                <th>Kategorija</th>
							                <th>Sub kategorija</th>
							                <th>Veiksmai</th>
							            </tr>
							        </thead>
							 
							        <tfoot>
							            <tr>
							                <th>Nuotrauka</th>
							                <th>Pavadinimas</th>
							                <th>Kategorija</th>
							                <th>Sub kategorija</th>
							                <th>Veiksmai</th>
							            </tr>
							        </tfoot>
							 
							        <tbody>";
							               //ITEMS TABLE
	 						$show_image="SELECT * FROM ideas_gallery ORDER BY sorting_id";
							$show_image_res = mysqli_query($mysqli, $show_image);
							while($img = mysqli_fetch_array($show_image_res)){
								$image_id = $img['id'];
								$image = $img['ideas_image'];
								$description = $img['description'];
								$descriptionEN = $img['description_EN'];
								$title = $img['title'];
								$titleEN = $img['title_EN'];
								$cat_id = $img['cat_id'];
								$subcat_id = $img['subcat_id'];

						//$display_block.="<img width='200px' height='200px' src='$image'></img>";
								$get_categories="SELECT cat_title FROM store_categories WHERE id = '".$cat_id."'";
								$get_categories_res = mysqli_query($mysqli, $get_categories);
								$cat_title_assoc = mysqli_fetch_assoc($get_categories_res);
								$cat_title = $cat_title_assoc['cat_title'];

								$get_subcategories="SELECT subcat_title FROM store_subcategories WHERE subcat_id = '".$subcat_id."'";
								$get_subcategories_res = mysqli_query($mysqli, $get_subcategories);
								$subcat_title_assoc = mysqli_fetch_assoc($get_subcategories_res);
								$subcat_title = $subcat_title_assoc['subcat_title'];

						$display_block.="<tr>
							                <td><img width='100px' height='100px' src='$image'></td>
							                <td>$title</td>
			
							                <td>$cat_title</td>
							                <td>$subcat_title</td>
							                <td> <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#editPhoto".$image_id."'>
												  Redaguoti
												</button>
												<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#deletePhoto".$image_id."'>
												  Naikinti
												</button>
											</td>
							            </tr>";


$display_block.="<!-- Delete Photo Modal -->
<div class='modal fade' id='deletePhoto".$image_id."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>Ar tikrai norite ištrinti $title ?</h4>
			</div>
			<form class='form-horizontal' method='post' >
				<div class='margin-bottom15 text-center'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Uždaryti</button>
					<input type='hidden' name='delete_image' value='".$image."'>
					<button type='submit' value='".$image_id."' name='imageID' class='btn btn-primary'>Ištrinti</button>
				</div>
			</form>
		</div>
	</div>				
</div>";


?>
<script type="text/javascript">
	$(document).ready(function(){
//Below line will get value of Category and store in id
$("#search_category_id<?php echo $image_id ?>").change(function()
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
$("#subCategory<?php echo $image_id ?>").html(html);
} 
});
});							
	});
</script>  


<?php 
							            //modals area
$display_block.="<!-- edit image Modal -->
<div class='modal fade' id='editPhoto".$image_id."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>Redaguoti paveikslėlį</h4>
				</div>								      	 
					<form class='form-horizontal'  method='post' enctype='multipart/form-data'>
						<div class='modal-body'>
							<div class='form-group'>
								<div class='row margin-top'>	
									<label class='col-md-4 control-label'><img class='inputImage' src='$image'></label>
									<div class='col-md-8'>
										<input type='hidden' name='oldImage' value='".$image."'>
										<input name='itemIMG' type='file' /> 
										<p>Paveikslėlis turi būti mažesnis nei 2MB</p> 
									</div>
									
								</div>	
								

								<div class='row margin-top'>
									<label class='col-md-4 control-label'>Pavadinimas LT<span style='color: red; padding-left: 2px;'>*</span></label>
									<div class='col-md-8'>
										<input type='text' required name='addTitle' value='".$title."' class='form-control' >							
									</div>
								</div>

								<div class='row margin-top'>
									<label for='inputName5' class='col-md-4 control-label'>Pavadinimas EN<span style='color: red; padding-left: 2px;'>*</span></label>
									<div class='col-md-8'>
										<input type='text' required name='addTitleEn' value='".$titleEN."' class='form-control' >							
									</div>
								</div>

								

								<div class='row margin-top'>	
									<label  class='col-md-4 control-label'>Kategorija<span style='color: red; padding-left: 2px;'>*</span></label>
									<div class='col-md-8'>
			<!--  KATEGORIJOS	-->		<select class='selectOption' required id='search_category_id".$image_id."' style='width:100%'  name='showCategory'>";
													

										//get all categories for select option
										
										$select_cat_sql = "SELECT * FROM store_categories";
										$select_cat_res = mysqli_query($mysqli, $select_cat_sql) or die(mysqli_error($mysqli));
										
										//selected category
										$display_block .="<option value='".$cat_id."'>$cat_title</option>";
										//other categories
											while($cat = mysqli_fetch_array($select_cat_res)){

												if($cat_id != $cat['id']){
													$cats_id = $cat['id'];
													$cats_title = $cat['cat_title'];
													$display_block .="<option  value='".$cats_id."'>$cats_title</option>";
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

									
										<select name='show_sub_categories'  style='width:100%' id='subCategory".$image_id."'>	
											  
										</select>	
									</div>
								</div>	

								<div class='row margin-top'>
									<label class='col-md-4 control-label'>Aprašymas LT</label>
									<div class='col-md-8'>
										<textarea  class='form-control' name='descriptionPhoto'  rows='3'>$description</textarea>
															
									</div>
								</div>

								<div class='row margin-top'>
									<label class='col-md-4 control-label'>Aprašymas EN</label>
									<div class='col-md-8'>
										<textarea  class='form-control' name='descriptionENPhoto'  rows='3'>$descriptionEN</textarea>							
									</div>
								</div>

							</div>
						</div>
						<div class='modal-footer'>
						 	<button type='button' class='btn btn-default' data-dismiss='modal'>Uždaryti</button>
						 	<input type='hidden' value='".$image_id."' name='getImage_id'>
						 	<button type='submit' name='submitEditPhoto' value='Submit'  class='btn btn-primary'>Išsaugoti</button>
					  	</div>
				 	</form>";									    
			$display_block.="
				</div>
		 	</div>
		</div>
	</div>
</div>";

							        }//end of while
							    $display_block.="
							    </tbody>
							   </table>
							    ";
if(isset($_POST['submitEditPhoto'])){

	// Check if image file is a actual image or fake image
	$uploadOk = 1;//check if no error found
	if ($_FILES["itemIMG"]["size"] != 0){ 	
			$target_dir = "images/ideas_gallery/";
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
		        $insert_foto_sql = "UPDATE ideas_gallery SET ideas_image ='images/ideas_gallery/".basename( $_FILES["itemIMG"]["name"])."' WHERE id='".$_POST['getImage_id']."'";
		        $insert_foto_res = mysqli_query($mysqli, $insert_foto_sql) or die(mysqli_error($mysqli));
		        //echo("<meta http-equiv='refresh' content='0'>");//reflesh page
		       
		    } else {
		        echo"<div class='alert alert-danger alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				Nutiko klaida atnaujinant paveikslėlį.
			</div>";
		    }
		}
	}//end of upload image




	if(isset($_POST['show_sub_categories']) && $uploadOk == 1){	
		$update_gallery= "UPDATE ideas_gallery SET cat_id = '".$_POST['showCategory']."', subcat_id = '".$_POST['show_sub_categories']."', description = '".$_POST['descriptionPhoto']."'
		, description_EN = '".$_POST['descriptionENPhoto']."', title = '".$_POST['addTitle']."', title_EN = '".$_POST['addTitleEn']."' WHERE id='".$_POST['getImage_id']."'";
		$update_gallery_res = mysqli_query($mysqli, $update_gallery);
	}else if($uploadOk == 1){
		$update_gallery= "UPDATE ideas_gallery SET cat_id = '".$_POST['showCategory']."', subcat_id = NULL, description = '".$_POST['descriptionPhoto']."'
		, description_EN = '".$_POST['descriptionENPhoto']."', title = '".$_POST['addTitle']."', title_EN = '".$_POST['addTitleEn']."' WHERE id='".$_POST['getImage_id']."'";
		$update_gallery_res = mysqli_query($mysqli, $update_gallery);
	}
	//echo("<meta http-equiv='refresh' content='0'>");//reflesh page
	print_r($_POST);
	echo $_POST['descriptionPhoto'];
}


			 
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

$display_block.="<!-- add Photo Modal -->
<div class='modal fade' id='addPhoto' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center'>Įdėti naują</h4>
			</div>

			<form class='form-horizontal'  method='post' enctype='multipart/form-data'>
				<div class='modal-body'>
					<div class='form-group'>
						<div class='row margin-top'>	
							<label   class='col-md-4 control-label'>Pasirinkite paveikslėlį<span style='color: red; padding-left: 2px;'>*</span></label>
							<div class='col-md-8'>
								<input name='addIMG' required type='file' /> 
								<p>Paveikslėlio dydis turi būti mažesnis nei 2MB</p> 
							</div>
						</div>	


						<div class='row margin-top'>
							<label class='col-md-4 control-label'>Pavadinimas LT<span style='color: red; padding-left: 2px;'>*</span></label>
							<div class='col-md-8'>
								<input type='text' required name='addNewTitle' class='form-control' >							
							</div>
						</div>

						<div class='row margin-top'>
							<label for='inputName5' class='col-md-4 control-label'>Pavadinimas EN<span style='color: red; padding-left: 2px;'>*</span></label>
							<div class='col-md-8'>
								<input type='text' required name='addNewTitleEn' class='form-control' >							
							</div>
						</div>

						<div class='row margin-top'>
							<label class='col-md-4 control-label'>Aprašymas LT</label>
							<div class='col-md-8'>
								<textarea  class='form-control' name='descriptionNewPhoto'  rows='3'></textarea>							
							</div>
						</div>

						<div class='row margin-top'>
							<label class='col-md-4 control-label'>Aprašymas EN</label>
							<div class='col-md-8'>
								<textarea  class='form-control' name='descriptionNewENPhoto'  rows='3'></textarea>							
							</div>
						</div>

						<div class='row margin-top'>	
							<label for='inputCategory' required class='col-md-4 control-label'>Pasirinkite kategoriją<span style='color: red; padding-left: 2px;'>*</span></label>
							<div class='col-md-8'>
	<!--  KATEGORIJOS	-->		<select class='selectOption' id='addCategory' style='width:100%'  name='addItemCategory'>";
													
								//get all categories for select option
								$select_addcat_sql = "SELECT * FROM store_categories";
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
					</div>
				</div>
				<div class='modal-footer'>
				 	<button type='button' class='btn btn-default' data-dismiss='modal'>Uždaryti</button>
				 	<button type='submit' name='submitAddPhoto' value='Submit' class='btn btn-primary'>Pridėti</button>
				</div>
		 	</form>
		</div>
	</div>
</div>";

	//submit edit form	Upload image only	
if(isset($_POST["submitAddPhoto"])) {
	// Check if image file is a actual image or fake image
	if ($_FILES["addIMG"]["size"] != 0){ 	
		$target_dir = "images/ideas_gallery/";
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
		    	
		        //update item content
				//check for input errors
				if(isset($_POST['addSubCategories'])){
					move_uploaded_file($_FILES["addIMG"]["tmp_name"], $target_file);
					$update_store_item = "INSERT INTO ideas_gallery (cat_id, subcat_id, ideas_image, description, description_EN, title, title_EN )VALUES(
					'".$_POST['addItemCategory']."',
					'".$_POST['addSubCategories']."',
					'images/ideas_gallery/".basename( $_FILES["addIMG"]["name"])."',
					'".$_POST['descriptionNewPhoto']."',
					'".$_POST['descriptionNewENPhoto']."',
					'".$_POST['addNewTitle']."',
					'".$_POST['addNewTitleEn']."'
					)";
		
					$update_store_item_res = mysqli_query($mysqli, $update_store_item) or die(mysqli_error($mysqli));
					
				}else{
					move_uploaded_file($_FILES["addIMG"]["tmp_name"], $target_file);
					$update_store_item = "INSERT INTO ideas_gallery (cat_id, ideas_image, description, description_EN, title, title_EN )VALUES(
					'".$_POST['addItemCategory']."',
					'images/ideas_gallery/".basename( $_FILES["addIMG"]["name"])."',
					'".$_POST['descriptionNewPhoto']."',
					'".$_POST['descriptionNewENPhoto']."',
					'".$_POST['addNewTitle']."',
					'".$_POST['addNewTitleEn']."'
					)";
	
					$update_store_item_res = mysqli_query($mysqli, $update_store_item);
				}
						
						echo("<meta http-equiv='refresh' content='0'>");//reflesh page
			}
	}else{
			echo"<div class='alert alert-danger alert-dismissible' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					Paveikslėlio dydis per didelis.
				</div>";
		 }		        
					
}//end of add new item

/*if submit delete photo*/
if(isset($_POST['imageID'])){
	$delete_item = "DELETE FROM ideas_gallery where id='".$_POST['imageID']."'";
	$delete_item_sql = mysqli_query($mysqli, $delete_item) or die(mysqli_error($mysqli));
		unlink($_POST['delete_image']);//delete old image
		echo("<meta http-equiv='refresh' content='0'>");//reflesh page
}


$display_block.="		
	
</div>
";



					    	