<?php
//include 'library.php';


$display_block.= "<h1 class='text-center'>Skaidrės</h1>";

$display_block.="
<div class='row'>
	<div class='col-md-2 col-md-offset-10'>
		<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addPhoto'><span class='glyphicon glyphicon-plus' aria-hidden='true'></span>Įdėti naują</button>
	</div>
</div>";


$display_block.="<div class='row'>
	 						   <table class='table tableStuff text-center table-responsive table-striped table-bordered' cellspacing='0' width='100%'>
							        <thead>
							            <tr>
							                <th>Nuotrauka</th>
							                <th>Pavadinimas</th>
							                <th>Veiksmai</th>
							            </tr>
							        </thead>
							 
							        <tfoot>
							            <tr>
							                <th>Nuotrauka</th>
							                <th>Pavadinimas</th>
							                <th>Veiksmai</th>
							            </tr>
							        </tfoot>
							 
							        <tbody>";
							               //ITEMS TABLE
	 						$show_image="SELECT * FROM slides_gallery ORDER BY id DESC";
							$show_image_res = mysqli_query($mysqli, $show_image);
							while($img = mysqli_fetch_array($show_image_res)){
								$image_id = $img['id'];
								$image = $img['slide_image'];
								$title = $img['image_title'];
								
						$display_block.="<tr>
							                <td><img width='100px' height='100px' src='$image'></td>
							                <td>$title</td>
							                <td> 
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

							        }//end of while
							    $display_block.="
							    </tbody>
							   </table>
							    ";




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
							<label class='col-md-4 control-label'>Pavadinimas <span style='color: red; padding-left: 2px;'>*</span></label>
							<div class='col-md-8'>
								<input type='text' required name='addNewTitle' class='form-control' >							
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
		$target_dir = "images/slides/";
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
				move_uploaded_file($_FILES["addIMG"]["tmp_name"], $target_file);
				$update_store_item1 = "INSERT INTO slides_gallery (slide_image, image_title)VALUES(
				'images/slides/".basename( $_FILES["addIMG"]["name"])."',
				'".$_POST['addNewTitle']."'
				)";
				
				$update_store_item_res = mysqli_query($mysqli, $update_store_item1) or die(mysqli_error($mysqli));
				
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
	$delete_item = "DELETE FROM slides_gallery where id='".$_POST['imageID']."'";
	$delete_item_sql = mysqli_query($mysqli, $delete_item) or die(mysqli_error($mysqli));
		unlink($_POST['delete_image']);//delete old image
		echo("<meta http-equiv='refresh' content='0'>");//reflesh page
}


$display_block.="		
	
</div>
";



					    	