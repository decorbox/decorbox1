<?php
include 'library.php';
$display_block.= "<h1 class='text-center'>Kategorijos</h1>";
					    	$display_block .="<div class='row'> <div class='col-md-6 col-md-offset-6'>
					    	<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addCategory'><span class='glyphicon glyphicon-plus' aria-hidden='true'></span>Įdėti kategoriją</button>
					    	<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addSubCategory'><span class='glyphicon glyphicon-plus' aria-hidden='true'></span>Įdėti sub kategoriją</button>
					    	<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#sortingCategory'><span class='glyphicon glyphicon-th-list' aria-hidden='true'></span> Rūšiuoti kategorijas</button>
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
								<input type='text' placeholder='Įveskite naują kategoriją Lietuvių kalba' required class='form-control input-lg text-center' name='inputNewCategory'>
							</div>
						</div>
						<div class='row margin-top'>
							<div class='col-md-12'>
								<input type='text' placeholder='Įveskite naują kategoriją Anglų kalba' required class='form-control input-lg text-center' name='inputNewCategoryEN'>
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
	
	$insert_new_cat = "INSERT INTO store_categories VALUES (NULL, '".$_POST['inputNewCategory']."', 0, '".$_POST['inputNewCategoryEN']."')"; //0-sorting_id kad rodyti pacia pirma kategorija kai ja ka tik idedi
	$insert_res = mysqli_query($mysqli, $insert_new_cat) or die(mysqli_error($mysqli));

	echo"<div class='alert alert-success alert-dismissible' role='alert'>
			<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
			Nauja kategorija pridėta.
		</div>";
	
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
								<input type='text' placeholder='Įveskite naują sub kategoriją Lietuvių kalba' required class='form-control input-lg text-center' name='inputNewSubCategory'>
							</div>
							<div class='col-md-12'>
								<input type='text' placeholder='Įveskite naują sub kategoriją Anglų kalba' required class='form-control input-lg text-center' name='inputNewSubCategoryEN'>
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
	
	$insert_subcat = "INSERT INTO store_subcategories VALUES ('".$_POST['selectSubCategory']."', NULL, '".$_POST['inputNewSubCategory']."', '".$_POST['inputNewSubCategoryEN']."')";
	$insert_subcat_res= mysqli_query($mysqli, $insert_subcat);
	echo"<div class='alert alert-success alert-dismissible' role='alert'>
			<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
			Nauja sub kategorija pridėta.
		</div>";
	
}

?>
<script>
$( document ).ready(function() {
    $("#sortable").sortable();
});

</script>
<?php
//http://api.jqueryui.com/sortable/#entry-examples
$display_block.="<!-- Sorting categories Modal -->
<div class='modal fade' id='sortingCategory' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>Rūšiuoti kategorijas</h4>
			</div>
			<form class='form-horizontal' method='post'>
				<div class='modal-body'>
					<div class='form-group'>
						<div class='row'>
							<div class='col-md-12'>
								<ol id='sortable' class='text-center list-group' style='margin:auto;'>";

								$show_cats="SELECT * FROM store_categories ORDER BY sorting_id";
								$show_cats_res=mysqli_query($mysqli, $show_cats);
								$count_rows = 0;
								while($info = mysqli_fetch_array($show_cats_res)){
									$categ_title = $info['cat_title'];
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
		     $update_sorting = "UPDATE store_categories SET sorting_id = '".$count."' WHERE id='".$sorting_value."'";
		     $update_sorting_res = mysqli_query($mysqli, $update_sorting);
			}
		}
		echo"<div class='alert alert-success alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				Kategorijos surūšiuotos.
			</div>";
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
							    $get_cats_sql = "SELECT id, cat_title, cat_title_EN FROM store_categories ORDER BY sorting_id";
								$get_cats_res = mysqli_query($mysqli, $get_cats_sql) or die(mysqli_error($mysqli));
								
								while ($cats = mysqli_fetch_array($get_cats_res)) //display categories
									{
									$cat_id = $cats['id'];
									$cat_title = $cats['cat_title'];
									$cat_title_EN = $cats['cat_title_EN'];

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
							<label for='inputCat' class='col-md-12 text-center control-label'>Kategorija<span style='color: red; padding-left: 2px;'>*</span></label>	
							<div class='row margin-top'>
								<div class='col-md-12'>
									<div class='col-md-1'>
										<label>LT</label>
									</div>
									<div class='col-md-11'>
										<input type='hidden' name='editCategoryId' value='$cat_id'>
										<input type='text'  name='editCategory' required value='$cat_title' class='form-control input-lg' >	
									</div>
								</div> 
							</div>	
							<div class='row margin-top'>
								<div class='col-md-12'>
									<div class='col-md-1'>
										<label>EN</label>
									</div>
									<div class='col-md-11'>
										<input type='text'  name='editCategoryEN' required value='$cat_title_EN' class='form-control input-lg' > 
									</div>
								</div> 
							</div>
						</div>
						<br>
						<div class='row margin-top'>
							<label for='inputCat' class='col-md-12 text-center control-label'>Sub kategorijos<span style='color: red; padding-left: 2px;'>*</span></label>
						</div>
						";
				
       			$subcat_res= mysqli_query($mysqli, $subcat_sql) or die(mysqli_error($mysqli));
       			if(mysqli_num_rows($subcat_res)==0){
       				$display_block.="<label>Nėra sub kategorijų</label>";
       			}else{
					while($sub = mysqli_fetch_array($subcat_res)){
						$subct_id = $sub['subcat_id'];
						$subct_title = $sub['subcat_title'];
						$subct_title_EN = $sub['subcat_title_EN'];
						$display_block.="
						<div class='row margin-top'>
							<div class='col-md-12'>
								<div class='col-md-1'>
									<label>LT</label>
								</div>
								<div class='col-md-11'>
									<input type='hidden' name='editSubcategoryId".$subct_id."' value='$subct_id'>
									<input type='text' required name='editSubcategory".$subct_id."' class='form-control' value='$subct_title'>
								</div>
							</div> 
						</div>	
						<div class='row margin-top'>
							<div class='col-md-12'>
								<div class='col-md-1'>
									<label>EN</label>
								</div>
								<div class='col-md-11'>
									<input type='text' required name='editSubcategoryEN".$subct_id."' class='form-control' value='$subct_title_EN'> 
								</div>
							</div> 
						</div>	<br>
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
		$sub_title_EN = $sub['subcat_title_EN'];

	
	//check input	
		//if subcat input is empty write only subcategory title
		if($_POST['editSubcategory'.$sub_id.'']==''){
			//write only category title
			$update_cats = "UPDATE store_categories SET cat_title ='".$_POST['editCategory']."', cat_title_EN='".$_POST['editCategoryEN']."' WHERE id='".$_POST['editCategoryId']."'";
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
			$update_cats = "UPDATE store_categories SET cat_title ='".$_POST['editCategory']."', cat_title_EN='".$_POST['editCategoryEN']."' WHERE id='".$_POST['editCategoryId']."'";
			$update_cats_res = mysqli_query($mysqli, $update_cats) or die(mysqli_error($mysqli));

			$update_subcats = "UPDATE store_subcategories SET subcat_title ='".$_POST['editSubcategory'.$sub_id.'']."', subcat_title_EN='".$_POST['editSubcategoryEN'.$sub_id.'']."' WHERE cat_id='".$_POST['editCategoryId']."' AND subcat_id='".$_POST['editSubcategoryId'.$sub_id.'']."'"; 
			$update_subcats_res = mysqli_query($mysqli, $update_subcats) or die(mysqli_error($mysqli));
			echo("<meta http-equiv='refresh' content='0'>");//reflesh page
		}//end of else
	}//end of while
		
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