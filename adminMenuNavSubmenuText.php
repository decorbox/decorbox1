<?php //kodas kopijuotas nuo kito puslapio
$display_block.= "<h1 class='text-center'>Kursų aprašymai</h1>";
	 						$display_block.="<div class='row'> <div class='col-md-2 col-md-offset-10'>				
	 							<button type='button' name='buttonAddItem' class='btn btn-primary' onclick='addRichTextEditor(this);' data-toggle='modal' data-target='#addItem'><span class='glyphicon glyphicon-plus' aria-hidden='true'></span> Įdėti kursą</button>
	 						</div></div>";

	
$display_block.="<!-- add item Modal -->
<div class='modal fade' id='addItem' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center'>Įdėti naują aprašymą</h4>
			</div>

			<form class='form-horizontal'  method='post'>
				<div class='modal-body'>
					<div class='form-group'>	

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
							<label for='inputCategory' required class='col-md-4 control-label'>Pasirinkite kursą<span style='color: red; padding-left: 2px;'>*</span></label>
							<div class='col-md-8'>
	<!--  KATEGORIJOS	-->		<select class='selectOption' id='addCategory' style='width:100%'  name='addItemCategory'>";
													
							
								$display_block .="<option  value='1'>Rankdarbių būrelis mergaitėms ir merginoms</option>";
								$display_block .="<option  value='2'>Kūrybinės popietės moterims</option>";
										
																	
				$display_block .="
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
	
	$update_store_item = "INSERT INTO navbar_submenu_text(txt_title, txt_info, txt_title_EN, txt_info_EN, submenu_id)VALUES(
		'".$_POST['addTitle']."',
		'".$_POST['addDescription']."',
		'".$_POST['addTitleEn']."',
		'".$_POST['addDescriptionEN']."',
		'".$_POST['addItemCategory']."')";
	
		$update_store_item_res = mysqli_query($mysqli, $update_store_item);
		//echo("<meta http-equiv='refresh' content='0'>");//reflesh page
								
}//end of add new item

	 		$display_block.="<div class='row'>
	 						   <table class='table tableStuff text-center table-responsive table-striped table-bordered' cellspacing='0' width='100%'>
							        <thead>
							            <tr>
							             
							                <th>Pavadinimas</th>
							                <th>Kursas</th>
							                <th>Veiksmai</th>
							            </tr>
							        </thead>
							 
							        <tfoot>
							            <tr>
							             
							                <th>Pavadinimas</th>
							                <th>Kursas</th>
							                <th>Veiksmai</th>
							            </tr>
							        </tfoot>
							 
							        <tbody>";
							               //ITEMS TABLE
	 						$get_items_sql = "SELECT * FROM navbar_submenu_text ORDER BY id DESC";
	 						$get_items_res = mysqli_query($mysqli, $get_items_sql) or die(mysqli_error($mysqli));
	 						
	 						$nav_title = "";
	 						while($item = mysqli_fetch_array($get_items_res)){ 
	 							$item_id = $item['id'];
	 							$item_nav_id = $item['submenu_id'];
	 							$item_title = $item['txt_title'];
	 							$item_title_EN = $item['txt_title_EN'];
	 							$item_desc = $item['txt_info'];
	 							$item_desc_EN = $item['txt_info_EN'];
	 							
	 							
	 							if($item_nav_id == 2){
	 								$nav_title = "Kūrybinės popietės moterims";
	 							}else if($item_nav_id == 1){
	 								$nav_title = "Rankdarbių būrelis mergaitėms ir merginoms";
	 							}
	 							

	 							
						$display_block.="<tr>
							                
							                <td>$item_title</td>
							                <td>$nav_title</td>
							                <td> <button type='button' class='btn btn-primary' onclick='addRichTextEditor(this);' data-toggle='modal' data-target='#".$item_id."'>
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
					
					<button type='submit' value='".$item_id."' name='deleteItem' class='btn btn-primary'>Ištrinti</button>
				</div>
			</form>
		</div>
	</div>				
</div>";

							           

							            //modals area
$display_block.="<!-- edit item Modal -->
<div class='modal fade' id='".$item_id."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>Redaguoti kursą</h4>
				</div>								      	 
					<form class='form-horizontal'  method='post'>
						<div class='modal-body'>
							<div class='form-group'>
									

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
									<label for='inputCategory' class='col-md-4 control-label'>Meniu kategorija<span style='color: red; padding-left: 2px;'>*</span></label>
									<div class='col-md-8'>
			<!-- meniu KATEGORIJOS	-->		<select class='selectOption' required id='search_category_id".$item_id."' style='width:100%'  name='showCategory'>";
													

										//get all categories for select option
										
										$select_cat_sql = "SELECT * FROM navbar_submenu_text ";
										$select_cat_res = mysqli_query($mysqli, $select_cat_sql) or die(mysqli_error($mysqli));
								
										//selected category
										
										//other categories
											
										$display_block .="<option  value='2'>Kūrybinės popietės moterims</option>";
										$display_block .="<option  value='1'>Rankdarbių būrelis mergaitėms ir merginoms</option>";
													
												
																				
						$display_block .="
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
	$delete_item = "DELETE FROM navbar_submenu_text where id='".$_POST['deleteItem']."'";
	$delete_item_sql = mysqli_query($mysqli, $delete_item);
	
	echo("<meta http-equiv='refresh' content='0'>");//reflesh page
}

	//submit edit form	Upload image only	
if(isset($_POST["submitEditItem"])) {
	$update_store_item = "UPDATE navbar_submenu_text SET submenu_id = '".$_POST['showCategory']."', txt_title = '".$_POST['title']."', txt_title_EN = '".$_POST['titleEN']."',
	txt_info = '".$_POST['description']."', txt_info_EN = '".$_POST['descriptionEN']."' WHERE id='".$_POST['getItem_id']."'";
	$update_store_item_res = mysqli_query($mysqli, $update_store_item);
		
	echo("<meta http-equiv='refresh' content='0'>");//reflesh page
	
}//end edit
	
