<?php //kodas kopijuotas nuo kito puslapio
$display_block.= "<h1 class='text-center'>Informacijos aprašymai</h1>";

	 		$display_block.="<div class='row'>
	 						   <table class='table tableStuff text-center table-responsive table-striped table-bordered' cellspacing='0' width='100%'>
							        <thead>
							            <tr>
							                <th>Pavadinimas</th>
							                <th>Veiksmai</th>
							            </tr>
							        </thead>
							 
							        <tfoot>
							            <tr>
							                <th>Pavadinimas</th>
							                <th>Veiksmai</th>
							            </tr>
							        </tfoot>
							 
							        <tbody>";
							               //ITEMS TABLE
	 						$get_items_sql = "SELECT * FROM text_content ORDER BY id DESC";
	 						$get_items_res = mysqli_query($mysqli, $get_items_sql) or die(mysqli_error($mysqli));
	 						
	 						$nav_title = "";
	 						while($item = mysqli_fetch_array($get_items_res)){ 
	 							$item_id = $item['id'];
	 							$item_title = $item['title'];
	 							$item_desc = $item['text_LT'];
	 							$item_desc_EN = $item['text_EN'];
	 							
	 							
						$display_block.="<tr>
							                
							                <td>$item_title</td>
							                
							                <td> <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#".$item_id."'>
												  Redaguoti
												</button>
												
											</td>
							            </tr>";
					           

							            //modals area
$display_block.="<!-- edit item Modal -->
<div class='modal fade' id='".$item_id."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>Redaguoti aprašymą</h4>
				</div>								      	 
					<form class='form-horizontal'  method='post'>
						<div class='modal-body'>
							<div class='form-group'>
									

								<div class='row text-center margin-top'>
									<h3 for='inputName3' class='col-md-12 control-label'>Skiltis: $item_title</h3>
								</div>


								<div class='row margin-top'>	
									<label for='inputDescription' class='col-md-3 control-label'>Apibūdinimas LT</label>
									<div class='col-md-9'>
										<textarea class='form-control' value='$item_desc' name='description' rows='6'>$item_desc</textarea>
									</div>
								</div>

								<div class='row margin-top'>	
									<label for='inputDescriptionEN' class='col-md-3 control-label'>Apibūdinimas EN</label>
									<div class='col-md-9'>
										<textarea class='form-control' value='$item_desc_EN' name='descriptionEN' rows='6'>$item_desc_EN</textarea>
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
	$update_store_item = "UPDATE text_content SET text_LT = '".$_POST['description']."', text_EN = '".$_POST['descriptionEN']."' WHERE id='".$_POST['getItem_id']."'";
	$update_store_item_res = mysqli_query($mysqli, $update_store_item);
		
	echo("<meta http-equiv='refresh' content='0'>");//reflesh page
	
}//end edit
	
