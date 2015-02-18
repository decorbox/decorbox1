
<?php
//session_start();

include 'connect.php';



?>
<!DOCTYPE HTML>
<html>
	<head>
	<?php include 'library.php';?>
	</head>
	<body><!-- kiekvienam puslapyje priskirti nuorodas kad rodytu nuorodoj id puslapio 
	ir cia su echo atsvaizduos tam paciam puslapyje su if-->

<?php
if (isset($_GET['cat_id'])) {

	$safe_cat_id = mysqli_real_escape_string($mysqli, $_GET['cat_id']); //gaunu paspaustos categorijos id 

	//$safe_cats_id = $_SESSION['cat_id'];
	$get_cat_title_sql = "SELECT cat_title FROM store_categories WHERE id='".$safe_cat_id."'";
	$get_cat_title_res = mysqli_query($mysqli, $get_cat_title_sql) or die(mysqli_error($mysqli)); 

	//get category name
	while ($title = mysqli_fetch_array($get_cat_title_res)) {
		$cat_title = $title['cat_title'];	
	}

	//pagination

	//gets current page number
	$items_per_page = 1;
	if(isset($_GET['page'])) {
		$current_page = $_GET['page'];
	} else {
		$current_page = 1;
	}
	//calculates the offset for sql LIMIT
	$offset = $items_per_page * ($current_page - 1);

	//gets items based on page
	$get_items_sql = "SELECT id, item_title, item_price, item_image FROM store_items WHERE cat_id = '".$safe_cat_id."' order by item_title";
	$query_limit_view = sprintf("%s LIMIT %d, %d", $get_items_sql, $offset, $items_per_page);
	$get_items_res = mysqli_query($mysqli, $query_limit_view) or die(mysqli_error($mysqli));

	//counts how manny items and pages are in the db
	$get_total_num_sql="SELECT COUNT(*) AS total FROM store_items WHERE cat_id = '".$safe_cat_id."'";
	$query = mysqli_query($mysqli, $get_total_num_sql) or die(mysql_error($mysqli));
	$result = mysqli_fetch_array($query);
	$total = $result['total'];
	$total_pages = (int)($total / $items_per_page); 

	//form the page link
	$url = $_SERVER['PHP_SELF'] . "?cat_id=" . $safe_cat_id;

	//displays pagination only if there is more than 1 page
	$pagination = '';
	$amount_of_numbered_pages = 8;
	if ($total_pages > 1) {
		//pagination header
		$pagination .= '<div class="row"><div class="col-md-12"><ul class="pagination">';
		//displays first and previous arrows if the current page is not the first
		if ($current_page > 1) {
			$pagination .= '<li><a href="' . $url . '&page=' . 1 . '">' . '<<' . '</a></li>';
			$pagination .= '<li><a href="' . $url . '&page=' . ($current_page - 1) . '">' . '<' . '</a></li>';
			$page_counter_start = $current_page - 1;
		} else {
			$pagination .= '<li class="disabled"><a href="#">' . '<<' . '</a></li>';
			$pagination .= '<li class="disabled"><a href="#">' . '<' . '</a></li>';
			$page_counter_start = $current_page;
		}
		//displays 8 numbered pages, 1 previous, 1 current and 6 next
		for ($page_counter = $page_counter_start, $i = 0; $page_counter <= $total_pages && $i < $amount_of_numbered_pages; $page_counter++, $i++) {
			if ($page_counter != $current_page) {
				$pagination .= '<li><a href="' . $url . '&page=' . $page_counter . '">' . $page_counter . '</a></li>';
			//marks the current page as active
			} else {
				$pagination .= '<li class="active"><a href="' . $url . '&page=' . $page_counter . '">' . $page_counter . '</a></li>';
			}
		}
		//displays next and last arrows if the current page is not the last
		if ($current_page != $total_pages) {
			$pagination .= '<li><a href="' . $url . '&page=' . ($current_page + 1) . '">' . '>' . '</a></li>';
			$pagination .= '<li><a href="' . $url . '&page=' . $total_pages . '">' . '>>' . '</a></li>';
		} else {
			$pagination .= '<li class="disabled"><a href="#">' . '>' . '</a></li>';
			$pagination .= '<li class="disabled"><a href="#">' . '>>' . '</a></li>';
		}
		//pagination footer
		$pagination .= '</ul></div></div>';
	}
	//end of pagination

	$display_block = "<h1>$cat_title</h1>";
	//display items grid
	while ($items = mysqli_fetch_array($get_items_res)) {
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
			        		
		for($i=1; $i<20; $i++) {
		 	$display_block .= "<option value=\"".$i."\">".$i."</option><br>";
		} 
				        	
		$display_block .= "
		</select></p>
		<input type='hidden' name='sel_item_id' value='" . $item_id ."' />
		<button class='btn btn-success' type='submit' name='submit' value='submit'>Įdėti į krepšelį</button>
		</form>
		</div>
		</div>";



	}//end mysql fetch array	
	//pagination buttons			

	//end pagination buttons
	mysqli_free_result($get_items_res);
	
	//print body elements
	echo $display_block;
	echo $pagination;
} else {
	include_once('mainContent.php');
}

?>	
	</body>
</html>