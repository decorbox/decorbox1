<?php
include 'connect.php';

if($_POST['id'])
{
$id=$_POST['id'];
$sql=mysqli_query($mysqli, "select * from store_subcategories where cat_id='".$id."'");
	echo "<option value=''>-</option>";
	while($row=mysqli_fetch_array($sql))
	{
	$data_id=$row['subcat_id'];
	$data_title=$row['subcat_title'];
	echo "<option value='".$data_id."'>$data_title</option>";
	}
}//http://crewow.com/PHP_Dynamic_Select_option_Via_Ajax.php
?>