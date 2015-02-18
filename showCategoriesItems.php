
<?php
//session_start();

include 'connect.php';

$safe_cat_id = mysqli_real_escape_string($mysqli, $_GET['cat_id']); //gaunu paspaustos categorijos id 

//$safe_cats_id = $_SESSION['cat_id'];
$get_cat_title_sql = "SELECT cat_title FROM store_categories WHERE id='".$safe_cat_id."'";
$get_cat_title_res = mysqli_query($mysqli, $get_cat_title_sql) or die(mysqli_error($mysqli)); 


//get category name
while ($title = mysqli_fetch_array($get_cat_title_res)){
	$cat_title = $title['cat_title'];	
	}


//pagination	
//get total number of record
$get_total_num_sql="SELECT id FROM store_items WHERE cat_id = '".$safe_cat_id."'";
$get_total_num = mysqli_query($mysqli, $get_total_num_sql) or die(mysql_error($mysqli));
$row = mysqli_fetch_array($get_total_num);
$rec_count = $row[0];
$rec_limit = 5;//itemu kiekis, nerodo pirmo itemo kazkodel
if(isset($_GET['page'])){
	$page = $_GET['page'] + 1;
	$offset = $rec_limit * $page;
}else{
	$page = 0;
	$offset = 0;
}
$left_rec = $rec_count - ($page * $rec_limit);

//get items
$get_items_sql = "SELECT id, item_title, item_price, item_image FROM store_items WHERE cat_id = '".$safe_cat_id."' order by item_title";
$query_limit_view = sprintf("%s LIMIT %d, %d", $get_items_sql, $row, $rec_limit);
$get_items_res = mysqli_query($mysqli, $query_limit_view) or die(mysqli_error($mysqli));
//$get_items_res = mysqli_query($mysqli, $get_items_sql) or die(mysqli_error($mysqli));
//end of pagination


$pagination = "<ul class='pagination'>
  <li><a href='#''>1</a></li>
  <li><a href='#'>2</a></li>
  <li><a href='#''>3</a></li>
  <li><a href='#'>4</a></li>
  <li><a href='#'>5</a></li>
</ul>";
//end of pagination

$display_block = "<h1>$cat_title</h1>";
//display items grid
while ($items = mysqli_fetch_array($get_items_res)) 
	{
	$item_id = $items['id'];
	$item_title = stripslashes($items['item_title']);
	$item_price = $items['item_price'];
	$item_image = $items['item_image'];

	$display_block .= 
	"<div class='col-md-5 margin-top border-color'>
		<div class='border-color'> 
			<a href=\"showitem.php?item_id=".$item_id."\">" .$item_title."</a>
		</div>

		<div class='border-color col-md-12'>
		<img src=".$item_image." width='100px'></img>
	&euro;".$item_price." <br>

	<form method='post' action='addtocart.php'>
	<p><label for=\"sel_item_qty\">Kiekis:</label>
	<select id=\"sel_item_qty\" name=\"sel_item_qty\">";
		        		
	for($i=1; $i<20; $i++){
	 	$display_block .= "<option value=\"".$i."\">".$i."</option><br>";
	 	} 
			        	
$display_block .= <<<END_OF_TEXT
</select></p>
<input type='hidden' name='sel_item_id' value="$item_id" />
<button class='btn btn-success' type='submit' name='submit' value='submit'>Įdėti į krepšelį</button>
</form>
</div>
</div>

END_OF_TEXT;

}//end mysql fetch array	
//pagination buttons			

//end pagination buttons
mysqli_free_result($get_items_res);

?>
<!DOCTYPE HTML>
<html>
	<head>
	<?php include 'library.php';?>
	</head>
	<body><!-- kiekvienam puslapyje priskirti nuorodas kad rodytu nuorodoj id puslapio 
	ir cia su echo atsvaizduos tam paciam puslapyje su if-->
	
		<?php echo $display_block?>
		<?php echo $pagination; ?>

	</body>
</html>