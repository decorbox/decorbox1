
<?php
//session_start();

include 'connect.php';
include 'library.php';
?>
<!DOCTYPE HTML>
<html>

<body>

<?php
if(isset($_GET['cat_id'])){
	$safe_cat_id = mysqli_real_escape_string($mysqli, $_GET['cat_id']); //gaunu paspaustos categorijos id 
	//$safe_cats_id = $_SESSION['cat_id'];
	$get_cat_title_sql = "SELECT cat_title FROM store_categories WHERE id='".$safe_cat_id."'";
	$get_cat_title_res = mysqli_query($mysqli, $get_cat_title_sql) or die(mysqli_error($mysqli)); 
}
//options for pagination
$items_per_page = 6;
$amount_of_numbered_pages = 5;
$display_block = "";
//end options
	//SHOW SUBCATEGORY ITEMS
if (isset($_GET['cat_id']) AND isset($_GET['subcat_id'])) {

	if(isset($_GET['subpage'])) {
		$current_page1 = $_GET['subpage'];
	} else {
		$current_page1 = 1;
	}
	
	$offset = $items_per_page * ($current_page1 - 1);
	//pagination for sorting(subcategories) items
	$get_items_sql1 = "SELECT id, item_title, item_price, item_image FROM store_items WHERE cat_id = '".$safe_cat_id."' AND subcat_id='".$_GET['subcat_id']."' order by item_title";
	$query_limit_view1 = sprintf("%s LIMIT %d, %d", $get_items_sql1, $offset, $items_per_page);
	$get_items_res1 = mysqli_query($mysqli, $query_limit_view1) or die(mysqli_error($mysqli));
		
	$get_total_num_sql1="SELECT COUNT(*) AS total1 FROM store_items WHERE cat_id = '".$safe_cat_id."' AND subcat_id='".$_GET['subcat_id']."'";
	$query1 = mysqli_query($mysqli, $get_total_num_sql1) or die(mysql_error($mysqli));
	$result1 = mysqli_fetch_array($query1);
	$total1 = $result1['total1'];
	$total_pages1 = ceil($total1 / $items_per_page);
	$total_items1 = $result1['total1'];

	//link of displaying subcategories
	$url1 = $_SERVER['PHP_SELF'] . "?cat_id=" . $safe_cat_id. "&subcat_id=" . $_GET['subcat_id'];

	//displays pagination only if there is more than 1 page

	$subPagination = '';	
	if ($total_pages1 > 1) {
		//pagination header
		$subPagination .= '<div class="row text-center"><div class="col-md-12"><ul class="pagination">';
		//displays first and previous arrows if the current page is not the first
		if ($current_page1 > 1) {
			$subPagination .= '<li><a href="' . $url1 . '&subpage=' . 1 . '">' . '<<' . '</a></li>';
			$subPagination .= '<li><a href="' . $url1 . '&subpage=' . ($current_page1 - 1) . '">' . '<' . '</a></li>';
			$page_counter_start1 = $current_page1 - 1;
			}
			else{
				$subPagination .= '<li class="disabled"><a href="#">' . '<<' . '</a></li>';
				$subPagination .= '<li class="disabled"><a href="#">' . '<' . '</a></li>';
				$page_counter_start1 = $current_page1;
			}
			//displays 8 numbered pages, 1 previous, 1 current and 6 next
			for ($page_counter = $page_counter_start1, $i = 0; $page_counter <= $total_pages1 && $i < $amount_of_numbered_pages; $page_counter++, $i++) {
				if ($page_counter != $current_page1) {
					$subPagination .= '<li><a href="' . $url1 . '&subpage=' . $page_counter . '">' . $page_counter . '</a></li>';
				//marks the current page as active
				} else {
					$subPagination .= '<li class="active"><a href="' . $url1 . '&subpage=' . $page_counter . '">' . $page_counter . '</a></li>';
				}
			}
			//displays next and last arrows if the current page is not the last
			if ($current_page1 != $total_pages1) {
				$subPagination .= '<li><a href="' . $url1 . '&subpage=' . ($current_page1 + 1) . '">' . '>' . '</a></li>';
				$subPagination .= '<li><a href="' . $url1 . '&subpage=' . $total_pages1 . '">' . '>>' . '</a></li>';
			} else {
				$subPagination .= '<li class="disabled"><a href="#">' . '>' . '</a></li>';
				$subPagination .= '<li class="disabled"><a href="#">' . '>>' . '</a></li>';
			}
			//pagination footer
			$subPagination .= '</ul></div></div>';
		}
	//}//end if isset
	//end of pagination

	// select sorting items
	$get_sorting_items_sql = "SELECT * from store_items WHERE cat_id ='".$safe_cat_id."' AND subcat_id='".$_GET['subcat_id']."'";
	$query_sorting_limit_view = sprintf("%s LIMIT %d, %d", $get_sorting_items_sql, $offset, $items_per_page);
	$get_sorting_items_res = mysqli_query($mysqli, $query_sorting_limit_view) or die(mysqli_error($mysqli));

	$subcat_title_sql="SELECT subcat_title FROM store_subcategories WHERE subcat_id='".$_GET['subcat_id']."'";
	$subcat_title_res= mysqli_query($mysqli, $subcat_title_sql) or die(mysql_error($mysqli));
	$subcat_title = mysqli_fetch_assoc($subcat_title_res);
	
	$display_block .= "<h1 class='text-center'>".$subcat_title['subcat_title']."</h1>";

	//display items
	if($total_items1<1){//if no items in category
		$display_block.="<div class='text-center'><label>Šioje kategorijoje prekių nėra!</label></div>";
	}else{
		while ($items = mysqli_fetch_array($get_sorting_items_res)) {
			$item_id = $items['id'];
			$item_title = stripslashes($items['item_title']);
			$item_price = $items['item_price'];
			$item_image = $items['item_image'];

			$display_block .= 
			"<div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 margin-top20'>
			  	<div class='text-center panel panel-success'>
		      		<a href='showitem.php?item_id=".$item_id."'>
				        <div class='panel-heading'>
				       		<h3 class='panel-title'>$item_title</h3>
				      	</div>
				    </a>
			   		
			   		<div class='panel-body'>
				   		<div class='row'>
					   		<div id='posts' class='col-lg-6 col-md-6 col-sm-6 col-xs-6 '>    
				        		<img class='margin-top20 imgLeft imgSize img-responsive ' src='$item_image'>
				        	</div>
				        	<form method='post' style='weigth:500px' action='addtocart.php'>
					        	<div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>
					        		<div class='row '>
					        			<div class=' col-lg-12 col-md-12 col-sm-6 col-xs-6 '>
						        			
												<label class=' margin-top20' for='sel_item_qty'>Kiekis:</label>
												<input type='number' min='1' value='1' class='fullWidthSelect' name='sel_item_qty' id='sel_item_qty'>
							
						     					<div class='row'>
						        					<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
						        						<label class='labelSize margin-left20'>&euro;".$item_price."</label>
						        					</div>
						        				</div>
					  					</div>
					        		</div>
					        	</div>
					        	<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
									<input type='hidden' name='sel_item_id' value='" . $item_id ."' />
									<button class='btn btn-success margin-top20 margin-bottom15 fullWidthButton'  type='submit' name='submit' value='submit'>Įdėti į krepšelį</button>
									       
								</div>
							</form>

			        	</div>
		      		</div>
		  		</div>
		  	</div>";
	
			}//end mysql fetch array

		$display_block .="$subPagination";
		}//end of else
		echo $display_block;
	
	//SHOW CATEGORY ITEMS
	} else if(isset($_GET['cat_id']) && !isset($_GET['subcat_id'])){
		//get category name
		while ($title = mysqli_fetch_array($get_cat_title_res)) {
			$cat_title = $title['cat_title'];	
		}

	//pagination
	//gets current page number
	
	if(isset($_GET['page'])) {
		$current_page = $_GET['page'];
	} else {
		$current_page = 1;
	}
	//calculates the offset for sql LIMIT
	$offset = $items_per_page * ($current_page - 1);
	
//pagination for categories items
	$get_items_sql = "SELECT id, item_title, item_price, item_image FROM store_items WHERE cat_id = '".$safe_cat_id."' order by item_title";
	$query_limit_view = sprintf("%s LIMIT %d, %d", $get_items_sql, $offset, $items_per_page);
	$get_items_res = mysqli_query($mysqli, $query_limit_view) or die(mysqli_error($mysqli));
	//}
	//counts how manny items and pages are in the db
	$get_total_num_sql="SELECT COUNT(*) AS total FROM store_items WHERE cat_id = '".$safe_cat_id."'";
	$query = mysqli_query($mysqli, $get_total_num_sql) or die(mysql_error($mysqli));
	$result = mysqli_fetch_array($query);
	$total = $result['total'];
	$total_pages = ceil($total / $items_per_page); 
	$total_items = $result['total'];
	
	
	//form the page link
	//link of displayint categories
	$url = $_SERVER['PHP_SELF'] . "?cat_id=" . $safe_cat_id;

	//displays pagination only if there is more than 1 page

	$pagination = '';
	//$amount_of_numbered_pages = 8;
	if ($total_pages > 1) {
		//pagination header
		$pagination .= '<div class="row text-center"><div class="col-md-12"><ul class="pagination">';
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


	$display_block .= "<h1 class='text-center'>$cat_title</h1>";

	if($total_items<1){//if no items in category
		$display_block.="<div class='text-center'><label>Šioje kategorijoje prekių nėra!</label></div>";
	}else{
	//display items grid
	while ($items = mysqli_fetch_array($get_items_res)) {
		$item_id = $items['id'];
		$item_title = stripslashes($items['item_title']);
		$item_price = $items['item_price'];
		$item_image = $items['item_image'];

		$display_block.="
			<div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 margin-top20'>
			  	<div class='text-center panel panel-success'>
		      		<a href='showitem.php?item_id=".$item_id."'>
				        <div class='panel-heading'>
				       		<h3 class='panel-title'>$item_title</h3>
				      	</div>
				    </a>
			   		
			   		<div class='panel-body'>
				   		<div class='row'>
					   		<div id='posts' class='col-lg-6 col-md-6 col-sm-6 col-xs-6 '>    
				        		<img class='margin-top20 imgLeft imgSize img-responsive ' src='$item_image'>
				        	</div>
				        	<form method='post' style='weigth:500px' action='addtocart.php'>
					        	<div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>
					        		<div class='row '>
					        			<div class=' col-lg-12 col-md-12 col-sm-6 col-xs-6 '>
						        			
												<label class=' margin-top20' for='sel_item_qty'>Kiekis:</label>
												<input type='number' min='1' value='1' class='fullWidthSelect' name='sel_item_qty' id='sel_item_qty'>
							
						     					<div class='row'>
						        					<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
						        						<label class='labelSize margin-left20'>&euro;".$item_price."</label>
						        					</div>
						        				</div>
					  					</div>
					        		</div>
					        	</div>
					        	<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
									<input type='hidden' name='sel_item_id' value='" . $item_id ."' />
									<button class='btn btn-success margin-top20 margin-bottom15 fullWidthButton'  type='submit' name='submit' value='submit'>Įdėti į krepšelį</button>
									       
								</div>
							</form>

			        	</div>
		      		</div>
		  		</div>
		  	</div>";	
		}//end mysql fetch array	

	$display_block .= "$pagination";
	}
	mysqli_free_result($get_items_res);

	//print body elements
	echo $display_block;
	//echo $pagination;
	
} else {
	//show main page
	include_once 'mainContent.php';
}

?>	

	</body>
</html>