<?php
include 'connect.php';

if($_REQUEST)
{
	$id 	= $_REQUEST['parent_id'];
	$select_subcat_sql = "SELECT * FROM store_subcategories WHERE cat_id ='".$id."'";
	$select_subcat_res = mysqli_query($mysqli, $select_subcat_sql) or die(mysqli_error($mysqli));

echo"	
	<select name='sub_category' class='selectOption' id='sub_category_id'>
	";
	
	while($categ = mysqli_fetch_array($select_subcat_res)){
	$subcat_id = $categ['subcat_id'];
	$subcat_title = $categ['subcat_title'];
	echo"<option value='".$subcat_id."'>$subcat_title</option>";
	}
	
echo"</select>";

}

?>
