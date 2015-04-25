
<?php
//session_start();
//isversta i anglu
include 'connect.php';
//include 'library.php';
?>
<!DOCTYPE HTML>
<html>

<body>

<?php
if(isset($_GET['lang']) && $_GET['lang']=='LT'){
		include 'content_LT.php';
	}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
		include 'content_EN.php';
	}else{
		include 'content_LT.php';
	}

if(isset($_GET['cat_id']) ){
	$safe_cat_id = mysqli_real_escape_string($mysqli, $_GET['cat_id']); //gaunu paspaustos categorijos id 
	//$safe_cats_id = $_SESSION['cat_id'];
	if(isset($_GET['lang']) && $_GET['lang']=='LT'){
		$get_cat_title_sql = "SELECT cat_title FROM store_categories WHERE id='".$safe_cat_id."'";
	}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
		$get_cat_title_sql = "SELECT cat_title_EN FROM store_categories WHERE id='".$safe_cat_id."'";
	}else{
		$get_cat_title_sql = "SELECT cat_title FROM store_categories WHERE id='".$safe_cat_id."'";
	}
	
	$get_cat_title_res = mysqli_query($mysqli, $get_cat_title_sql) or die(mysqli_error($mysqli)); 
}
//options for pagination
$items_per_page = 24;
$amount_of_numbered_pages = 5;
$display_block = "";

?>
<script>
document.getElementById('links').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};

</script>

<?php
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
	if(isset($_GET['lang']) && $_GET['lang']=='LT'){
		$get_items_sql1 = "SELECT id, item_title, item_price, item_image FROM store_items WHERE cat_id = '".$safe_cat_id."' AND subcat_id='".$_GET['subcat_id']."' order by id DESC";
	}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
		$get_items_sql1 = "SELECT id, item_title_EN, item_price, item_image FROM store_items WHERE cat_id = '".$safe_cat_id."' AND subcat_id='".$_GET['subcat_id']."' order by id DESC";
	}else{
		$get_items_sql1 = "SELECT id, item_title, item_price, item_image FROM store_items WHERE cat_id = '".$safe_cat_id."' AND subcat_id='".$_GET['subcat_id']."' order by id DESC";
	}
	
	$query_limit_view1 = sprintf("%s LIMIT %d, %d", $get_items_sql1, $offset, $items_per_page);
	$get_items_res1 = mysqli_query($mysqli, $query_limit_view1) or die(mysqli_error($mysqli));
		
	$get_total_num_sql1="SELECT COUNT(*) AS total1 FROM store_items WHERE cat_id = '".$safe_cat_id."' AND subcat_id='".$_GET['subcat_id']."'";
	$query1 = mysqli_query($mysqli, $get_total_num_sql1) or die(mysql_error($mysqli));
	$result1 = mysqli_fetch_array($query1);
	$total1 = $result1['total1'];
	$total_pages1 = ceil($total1 / $items_per_page);
	$total_items1 = $result1['total1'];

	//link of displaying subcategories
	$url1 = "?lang=".$_GET['lang']."&cat_id=" . $safe_cat_id. "&subcat_id=" . $_GET['subcat_id'];

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
	$get_sorting_items_sql = "SELECT * from store_items WHERE cat_id ='".$safe_cat_id."' AND subcat_id='".$_GET['subcat_id']."' order by id DESC";
	$query_sorting_limit_view = sprintf("%s LIMIT %d, %d", $get_sorting_items_sql, $offset, $items_per_page);
	$get_sorting_items_res = mysqli_query($mysqli, $query_sorting_limit_view) or die(mysqli_error($mysqli));

	

	if(isset($_GET['lang']) && $_GET['lang']=='LT'){
		$subcat_title_sql="SELECT subcat_title FROM store_subcategories WHERE subcat_id='".$_GET['subcat_id']."'";
		$subcat_title_res= mysqli_query($mysqli, $subcat_title_sql) or die(mysql_error($mysqli));
		$subcat_title = mysqli_fetch_assoc($subcat_title_res);
		$display_block .= "<h1 class='text-center'>".$subcat_title['subcat_title']."</h1>";
	}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
		$subcat_title_sql="SELECT subcat_title_EN FROM store_subcategories WHERE subcat_id='".$_GET['subcat_id']."'";
		$subcat_title_res= mysqli_query($mysqli, $subcat_title_sql) or die(mysql_error($mysqli));
		$subcat_title = mysqli_fetch_assoc($subcat_title_res);
		$display_block .= "<h1 class='text-center'>".$subcat_title['subcat_title_EN']."</h1>";
	}else{
		$subcat_title_sql="SELECT subcat_title FROM store_subcategories WHERE subcat_id='".$_GET['subcat_id']."'";
		$subcat_title_res= mysqli_query($mysqli, $subcat_title_sql) or die(mysql_error($mysqli));
		$subcat_title = mysqli_fetch_assoc($subcat_title_res);
		$display_block .= "<h1 class='text-center'>".$subcat_title['subcat_title']."</h1>";
	}
	
	
	
	

	//display items
	if($total_items1<1){//if no items in category
		$display_block.="<div class='text-center '><label>$txtno_items_in_category</label></div>";
	}else{
		while ($items = mysqli_fetch_array($get_sorting_items_res)) {
			$item_id = $items['id'];
			if(isset($_GET['lang']) && $_GET['lang']=='LT'){
				$item_title = stripslashes($items['item_title']);
			}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
				$item_title = stripslashes($items['item_title_EN']);
			}else{
				$item_title = stripslashes($items['item_title']);
			}
			
			$item_price = $items['item_price'];
			$item_image = $items['item_image'];

			$display_block .= 

			"
			<div class='col-lg-4-edit col-md-4-edit col-sm-4 col-xs-4 '>
			  	<div class='text-center panel panel-success panel-edit'>
		      		<a href='showitem.php?lang=".$_GET['lang']."&item_id=".$item_id."'>
				        <div class='panel-heading'>
				       		<h3 class='panel-title'>$item_title</h3>
				      	</div>
				    </a>
			   		
			   		<div class='panel-body panel-body-edit2'>
				   		<div class='row'>
					   		<div id='posts' class='col-md-6-edit col-sm-6-edit col-xs-6-edit '> 
					   			
				        		<img class='margin-top20 imgSize img-responsive ' src='$item_image'/>
				        		
				        	</div>
				        	<form method='post' action='addtocart.php'>
					        	<div class=' col-md-6-edit col-sm-6-edit col-xs-6-edit '>
					        		<div class='row '>
					        			<div class=' col-lg-12-edit col-md-12-edit col-sm-6-edit col-xs-6-edit margin-left15 '>
						        			
												<label class=' margin-top20 margin-left20' for='sel_item_qty'>$txtqty:</label><br>
												<input type='number' min='1' value='1' class='fullWidthSelect margin-left-20' name='sel_item_qty' id='sel_item_qty'>
							
						     					<div class='row'>
						        					<div class='col-lg-12-edit col-md-12-edit col-sm-12-edit col-xs-12-edit'>
						        						<p class='labelSize margin-left20'>".$item_price."&euro;</p>
						        					</div>
						        				</div>
					  					</div>
					        		</div>
					        	</div>
					        	<div class='col-lg-12-edit col-md-12-edit col-sm-12-edit col-xs-12-edit'>
									<input type='hidden' name='sel_item_id' value='" . $item_id ."'&euro; />
									<button class='btn btn-success margin-top20 margin-bottom15 fullWidthButton'  type='submit' name='submit' value='submit'>$txtadd_to_basket</button>
									       
								</div>
							</form>

			        	</div>
		      		</div>
		  		</div>
		  	</div>
		";
	
			}//end mysql fetch array

		$display_block .="$subPagination";
		}//end of else
		echo $display_block;
	
	//SHOW CATEGORY ITEMS
	} else if(isset($_GET['cat_id']) && !isset($_GET['subcat_id']) && !isset($_GET['special'])){
		//get category name
		while ($title = mysqli_fetch_array($get_cat_title_res)) {
			if(isset($_GET['lang']) && $_GET['lang']=='LT'){
				$cat_title = $title['cat_title'];
			}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
				$cat_title = $title['cat_title_EN'];
			}else{
				$cat_title = $title['cat_title'];
			}

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
	$get_items_sql = "SELECT * FROM store_items WHERE cat_id = '".$safe_cat_id."' order by id DESC";
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
	$url = "?lang=".$_GET['lang']."&cat_id=" . $safe_cat_id;

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
		$display_block.="<div class='text-center'><label>$txtno_items_in_category</label></div>";
	}else{
	//display items grid
	while ($items = mysqli_fetch_array($get_items_res)) {
		$item_id = $items['id'];
		if(isset($_GET['lang']) && $_GET['lang']=='LT'){
				$item_title = stripslashes($items['item_title']);
			}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
				$item_title = stripslashes($items['item_title_EN']);
			}else{
				$item_title = stripslashes($items['item_title']);
			}
		
		$item_price = $items['item_price'];
		$item_image = $items['item_image'];

		$display_block.="
			<div class='col-lg-4-edit col-md-4-edit col-sm-6-edit col-xs-4-edit '>
			  	<div class='text-center panel panel-success panel-edit'>
		      		<a href='showitem.php?lang=".$_GET['lang']."&item_id=".$item_id."'>
				        <div class='panel-heading'>
				       		<h3 class='panel-title'>$item_title</h3>
				      	</div>
				    </a>
			   		
			   		<div class='panel-body panel-body-edit2'>
				   		<div class='row'>
					   		<div id='posts' class='col-md-6-edit col-sm-6-edit col-xs-6-edit '>    
				        		<img class='margin-top20  imgSize img-responsive ' src='$item_image'>
				        	</div>
				        	<form method='post' style='weigth:500px' action='addtocart.php'>
					        	<div class=' col-md-6-edit col-sm-6-edit col-xs-6-edit '>
					        		<div class='row '>
					        			<div class=' col-lg-12-edit col-md-12-edit col-sm-6-edit col-xs-6-edit margin-left15 '>
						        			
												<label class=' margin-top20 margin-left20' for='sel_item_qty'>$txtqty:</label><br>
												<input type='number' min='1' value='1' class='fullWidthSelect margin-left-20' name='sel_item_qty' id='sel_item_qty'>
							
						     					<div class='row'>
						        					<div class='col-lg-12-edit col-md-12-edit col-sm-12-edit col-xs-12-edit'>
						        						<p class='labelSize margin-left20'>".$item_price."&euro;</p>
						        					</div>
						        				</div>
					  					</div>
					        		</div>
					        	</div>
					        	<div class='col-lg-12-edit col-md-12-edit col-sm-12-edit col-xs-12-edit'>
									<input type='hidden' name='sel_item_id' value='" . $item_id ."' />
									<button class='btn btn-success margin-top20 margin-bottom15 fullWidthButton'  type='submit' name='submit' value='submit'>$txtadd_to_basket</button>
									       
								</div>
							</form>

			        	</div>
		      		</div>
		  		</div>
		  	</div>";	
		}//end mysql fetch array	

	$display_block .= "$pagination";
	}
	//mysqli_free_result($get_items_res);

	//print body elements
	echo $display_block;
	//echo $pagination;


//SHOW SPECIAL OFFERS PAGE	
}else if(isset($_GET['special'])){
	
	if(isset($_GET['spage'])) {
		$current_page2 = $_GET['spage'];
	} else {
		$current_page2 = 1;
	}
	
	$offset = $items_per_page * ($current_page2 - 1);
	//pagination for sorting(subcategories) items
	if(isset($_GET['lang']) && $_GET['lang']=='LT'){
		$get_items_sql2 = "SELECT id, item_title, item_price, item_price_old, item_image FROM store_items WHERE item_price_old !='NULL' order by id DESC";
	}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
		$get_items_sql2 = "SELECT id, item_title_EN, item_price, item_price_old, item_image FROM store_items WHERE item_price_old !='NULL' order by id DESC";
	}else{
		$get_items_sql2 = "SELECT id, item_title, item_price, item_price_old, item_image FROM store_items WHERE item_price_old !='NULL' order by id DESC";
	}
	
	$query_limit_view2 = sprintf("%s LIMIT %d, %d", $get_items_sql2, $offset, $items_per_page);
	$get_items_res2 = mysqli_query($mysqli, $query_limit_view2) or die(mysqli_error($mysqli));
		
	$get_total_num_sql2="SELECT COUNT(*) AS total2 FROM store_items WHERE item_price_old!='NULL'";
	$query2 = mysqli_query($mysqli, $get_total_num_sql2) or die(mysql_error($mysqli));
	$result2 = mysqli_fetch_array($query2);
	$total2 = $result2['total2'];
	$total_pages2 = ceil($total2 / $items_per_page);
	$total_items2 = $result2['total2'];

	//link of displaying subcategories
	$url1 = "?lang=".$_GET['lang']."&special=".$_GET['special']."";

	//displays pagination only if there is more than 1 page

	$sPagination = '';	
	if ($total_pages2 > 1) {
		//pagination header
		$sPagination .= '<div class="row text-center"><div class="col-md-12"><ul class="pagination">';
		//displays first and previous arrows if the current page is not the first
		if ($current_page2 > 1) {
			$sPagination .= '<li><a href="' . $url1 . '&spage=' . 1 . '">' . '<<' . '</a></li>';
			$sPagination .= '<li><a href="' . $url1 . '&spage=' . ($current_page2 - 1) . '">' . '<' . '</a></li>';
			$page_counter_start1 = $current_page2 - 1;
			}
			else{
				$sPagination .= '<li class="disabled"><a href="#">' . '<<' . '</a></li>';
				$sPagination .= '<li class="disabled"><a href="#">' . '<' . '</a></li>';
				$page_counter_start1 = $current_page2;
			}
			//displays 8 numbered pages, 1 previous, 1 current and 6 next
			for ($page_counter = $page_counter_start1, $i = 0; $page_counter <= $total_pages2 && $i < $amount_of_numbered_pages; $page_counter++, $i++) {
				if ($page_counter != $current_page2) {
					$sPagination .= '<li><a href="' . $url1 . '&spage=' . $page_counter . '">' . $page_counter . '</a></li>';
				//marks the current page as active
				} else {
					$sPagination .= '<li class="active"><a href="' . $url1 . '&spage=' . $page_counter . '">' . $page_counter . '</a></li>';
				}
			}
			//displays next and last arrows if the current page is not the last
			if ($current_page2 != $total_pages2) {
				$sPagination .= '<li><a href="' . $url1 . '&spage=' . ($current_page2 + 1) . '">' . '>' . '</a></li>';
				$sPagination .= '<li><a href="' . $url1 . '&spage=' . $total_pages2 . '">' . '>>' . '</a></li>';
			} else {
				$sPagination .= '<li class="disabled"><a href="#">' . '>' . '</a></li>';
				$sPagination .= '<li class="disabled"><a href="#">' . '>>' . '</a></li>';
			}
			//pagination footer
			$sPagination .= '</ul></div></div>';
		}
	//}//end if isset
	//end of pagination

	// select sorting items
	$get_sorting_items_sql = "SELECT * from store_items WHERE item_price_old !='NULL' order by id DESC";
	$query_sorting_limit_view = sprintf("%s LIMIT %d, %d", $get_sorting_items_sql, $offset, $items_per_page);
	$get_sorting_items_res = mysqli_query($mysqli, $query_sorting_limit_view) or die(mysqli_error($mysqli));

	

	if(isset($_GET['lang']) && $_GET['lang']=='LT'){
		$display_block .= "<h1 class='text-center'>$txtspecial_offers</h1>";
	}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
		$display_block .= "<h1 class='text-center'>$txtspecial_offers</h1>";
	}else{
		$display_block .= "<h1 class='text-center'>$txtspecial_offers</h1>";
	}
	
	
	
	

	//display items
	if($total_items2<1){//if no items in category
		$display_block.="<div class='text-center '><label>$txtno_items_in_category</label></div>";
	}else{
		while ($items = mysqli_fetch_array($get_sorting_items_res)) {
			$item_id = $items['id'];
			if(isset($_GET['lang']) && $_GET['lang']=='LT'){
				$item_title = stripslashes($items['item_title']);
			}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
				$item_title = stripslashes($items['item_title_EN']);
			}else{
				$item_title = stripslashes($items['item_title']);
			}
			
			$item_price = $items['item_price'];
			$item_price_old = $items['item_price_old'];
			$discount = $item_price_old - $item_price;
			$item_image = $items['item_image'];

			$display_block .= 

			"
			<div class='col-lg-4-edit col-md-4-edit col-sm-6-edit col-xs-4-edit '>
			  	<div class='text-center panel panel-success panel-edi'>
		      		<a href='showitem.php?lang=".$_GET['lang']."&item_id=".$item_id."'>
				        <div class='panel-heading'>
				       		<h3 class='panel-title'>$item_title</h3>
				      	</div>
				    </a>
			   		
			   		<div class='panel-body panel-body-edit2'>
				   		<div class='row'>
					   		<div id='posts' class='col-md-12-edit col-sm-12-edit col-xs-12-edit '> 
					   			
				        		<img class='margin-top20 special-offers-img img-responsive ' src='$item_image'/>
				        		
				        	</div>
				        	<form method='post' style='weigth:500px' action='addtocart.php'>
					        	<div class=' col-md-12-edit col-sm-12-edit col-xs-12-edit '>
					        		<div class='row '>
					        			<div class=' col-lg-12-edit col-md-12-edit col-sm-6-edit col-xs-6-edit margin-left15 '>
						        			
												<label class=' margin-top20 margin-left20' for='sel_item_qty'>$txtqty:</label><br>
												<input type='number' min='1' value='1' class='inputWidth margin-left-20' name='sel_item_qty' id='sel_item_qty'>
							
						     					<div class='row'>
						     						<div class='col-lg-12-edit col-md-12-edit col-sm-12-edit col-xs-12-edit'>
						        						<p class='labelSize margin-left20' style='text-decoration: line-through;'>$txtold_price:".$item_price_old."&euro;</p>
						        					</div>
						        					<div class='col-lg-12-edit col-md-12-edit col-sm-12-edit col-xs-12-edit'>
						        						<p class=' margin-left20' >$txtitemDiscount: ".$discount."&euro;</p>
						        					</div>
						        					<div class='col-lg-12-edit col-md-12-edit col-sm-12-edit col-xs-12-edit'>
						        						<p class='labelSize margin-left20'>".$item_price."&euro;</p>
						        					</div>
						        				</div>
					  					</div>
					        		</div>
					        	</div>
					        	<div class='col-lg-12-edit col-md-12-edit col-sm-12-edit col-xs-12-edit'>
									<input type='hidden' name='sel_item_id' value='" . $item_id ."' />
									<button class='btn btn-success margin-top20 margin-bottom15 fullWidthButton'  type='submit' name='submit' value='submit'>$txtadd_to_basket</button>
									       
								</div>
							</form>

			        	</div>
		      		</div>
		  		</div>
		  	</div>
		";
	
			}//end mysql fetch array

		$display_block .="$sPagination";
		}//end of else
		echo $display_block;


}else if(isset($_GET['nav']) && $_GET['nav']=='Ranku-darbo-gaminiai'){
	if(isset($_GET['npage'])) {
		$current_page3 = $_GET['npage'];
	} else {
		$current_page3 = 1;
	}
	
	$offset = $items_per_page * ($current_page3 - 1);
	//pagination for sorting(subcategories) items
	if(isset($_GET['lang']) && $_GET['lang']=='LT'){
		$get_items_sql3 = "SELECT id, item_title, item_price, item_image FROM store_items WHERE nav_id='2' order by id DESC";
	}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
		$get_items_sql3 = "SELECT id, item_title_EN, item_price, item_image FROM store_items WHERE  nav_id='2' order by id DESC";
	}else{
		$get_items_sql3 = "SELECT id, item_title, item_price, item_image FROM store_items WHERE nav_id='2' order by id DESC";
	}
	
	$query_limit_view3 = sprintf("%s LIMIT %d, %d", $get_items_sql3, $offset, $items_per_page);
	$get_items_res3 = mysqli_query($mysqli, $query_limit_view3) or die(mysqli_error($mysqli));
		
	$get_total_num_sql3="SELECT COUNT(*) AS total3 FROM store_items WHERE nav_id='2'";
	$query3 = mysqli_query($mysqli, $get_total_num_sql3) or die(mysql_error($mysqli));
	$result3 = mysqli_fetch_array($query3);
	$total3 = $result3['total3'];
	$total_pages3 = ceil($total3 / $items_per_page);
	$total_items3 = $result3['total3'];

	//link of displaying subcategories
	$url1 = "index.php?lang=".$_GET['lang']."&nav=".$_GET['nav']."";

	//displays pagination only if there is more than 1 page

	$nPagination = '';	
	if ($total_pages3 > 1) {
		//pagination header
		$nPagination .= '<div class="row text-center"><div class="col-md-12"><ul class="pagination">';
		//displays first and previous arrows if the current page is not the first
		if ($current_page3 > 1) {
			$nPagination .= '<li><a href="' . $url1 . '&npage=' . 1 . '">' . '<<' . '</a></li>';
			$nPagination .= '<li><a href="' . $url1 . '&npage=' . ($current_page3 - 1) . '">' . '<' . '</a></li>';
			$page_counter_start1 = $current_page3 - 1;
			}
			else{
				$nPagination .= '<li class="disabled"><a href="#">' . '<<' . '</a></li>';
				$nPagination .= '<li class="disabled"><a href="#">' . '<' . '</a></li>';
				$page_counter_start1 = $current_page3;
			}
			//displays 8 numbered pages, 1 previous, 1 current and 6 next
			for ($page_counter = $page_counter_start1, $i = 0; $page_counter <= $total_pages3 && $i < $amount_of_numbered_pages; $page_counter++, $i++) {
				if ($page_counter != $current_page3) {
					$nPagination .= '<li><a href="' . $url1 . '&npage=' . $page_counter . '">' . $page_counter . '</a></li>';
				//marks the current page as active
				} else {
					$nPagination .= '<li class="active"><a href="' . $url1 . '&npage=' . $page_counter . '">' . $page_counter . '</a></li>';
				}
			}
			//displays next and last arrows if the current page is not the last
			if ($current_page3 != $total_pages3) {
				$nPagination .= '<li><a href="' . $url1 . '&npage=' . ($current_page3 + 1) . '">' . '>' . '</a></li>';
				$nPagination .= '<li><a href="' . $url1 . '&npage=' . $total_pages3 . '">' . '>>' . '</a></li>';
			} else {
				$nPagination .= '<li class="disabled"><a href="#">' . '>' . '</a></li>';
				$nPagination .= '<li class="disabled"><a href="#">' . '>>' . '</a></li>';
			}
			//pagination footer
			$nPagination .= '</ul></div></div>';
		}
	//}//end if isset
	//end of pagination

	// select sorting items
	$get_sorting_items_sql = "SELECT * from store_items WHERE nav_id='2' order by id DESC";
	$query_sorting_limit_view = sprintf("%s LIMIT %d, %d", $get_sorting_items_sql, $offset, $items_per_page);
	$get_sorting_items_res = mysqli_query($mysqli, $query_sorting_limit_view) or die(mysqli_error($mysqli));

	

	if(isset($_GET['lang']) && $_GET['lang']=='LT'){
		$display_block .= "<h1 class='text-center'>$txtnav_handmade</h1>";
	}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
		$display_block .= "<h1 class='text-center'>$txtnav_handmade</h1>";
	}else{
		$display_block .= "<h1 class='text-center'>$txtnav_handmade</h1>";
	}
	
	
	
	

	//display items
	if($total_items3<1){//if no items in category
		$display_block.="<div class='text-center '><label>$txtno_items_in_category</label></div>";
	}else{ 
		while ($items = mysqli_fetch_array($get_sorting_items_res)) {
			$item_id = $items['id']; 
			if(isset($_GET['lang']) && $_GET['lang']=='LT'){
				$item_title = stripslashes($items['item_title']);
			}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
				$item_title = stripslashes($items['item_title_EN']);
			}else{
				$item_title = stripslashes($items['item_title']);
			}
			
			$item_price = $items['item_price'];
			$item_image = $items['item_image'];

			$display_block .= 

			"
			<div class='col-lg-4-edit col-md-4-edit col-sm-6-edit col-xs-4-edit '>
			  	<div class='text-center panel panel-success panel-edit'>
		      		<a href='showitem.php?lang=".$_GET['lang']."&item_id=".$item_id."'>
				        <div class='panel-heading'>
				       		<h3 class='panel-title'>$item_title</h3>
				      	</div>
				    </a>
			   		
			   		<div class='panel-body panel-body-edit2'>
				   		<div class='row'>
					   		<div id='posts' class='col-md-6-edit col-sm-6-edit col-xs-6-edit '>    
				        		<img class='margin-top20  imgSize img-responsive ' src='$item_image'>
				        	</div>
				        	<form method='post' style='weigth:500px' action='addtocart.php'>
					        	<div class=' col-md-6-edit col-sm-6-edit col-xs-6-edit '>
					        		<div class='row '>
					        			<div class=' col-lg-12-edit col-md-12-edit col-sm-6-edit col-xs-6-edit margin-left15 '>
						        			
												<label class=' margin-top20 margin-left20' for='sel_item_qty'>$txtqty:</label><br>
												<input type='number' min='1' value='1' class='fullWidthSelect margin-left-20' name='sel_item_qty' id='sel_item_qty'>
							
						     					<div class='row'>
						        					<div class='col-lg-12-edit col-md-12-edit col-sm-12-edit col-xs-12-edit'>
						        						<p class='labelSize margin-left20'>".$item_price."&euro;</p>
						        					</div>
						        				</div>
					  					</div>
					        		</div>
					        	</div>
					        	<div class='col-lg-12-edit col-md-12-edit col-sm-12-edit col-xs-12-edit'>
									<input type='hidden' name='sel_item_id' value='" . $item_id ."' />
									<button class='btn btn-success margin-top20 margin-bottom15 fullWidthButton'  type='submit' name='submit' value='submit'>$txtadd_to_basket</button>
									       
								</div>
							</form>

			        	</div>
		      		</div>
		  		</div>
		  	</div>
		";
	
			}//end mysql fetch array

		$display_block .="$nPagination";
		}//end of else
		echo $display_block;	

}else if(isset($_GET['nav']) && $_GET['nav']=='Kontaktai'){
	$get_text = "SELECT * FROM text_content WHERE id = 5";
	$get_text_res = mysqli_query($mysqli, $get_text);
	$get_text_assoc = mysqli_fetch_assoc($get_text_res);
	
	if(isset($_GET['lang']) && $_GET['lang']=='LT'){
		$txtcontacts_info = $get_text_assoc['text_LT'];
	}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
		$txtcontacts_info = $get_text_assoc['text_EN'];
	}else{
		$txtcontacts_info = $get_text_assoc['text_LT'];
	}
	echo "
<div class='row'>
	<div class=' panel panel-success' >
		<div class='panel-heading text-center'>
			<h3 class='panel-title'>$txtnav_about</h3>
		</div>
			
		<div class='panel-body'>
			<p>$txtcontacts_info</p>
		</div>
	</div>
</div>";
}else if(isset($_GET['submenu']) && $_GET['submenu']=='Rankdarbiu-burelis'){
	
	$get_txt = "SELECT * FROM navbar_submenu_text WHERE submenu_id = '1' ORDER BY id DESC";
	$get_txt_res = mysqli_query($mysqli, $get_txt) or die(mysqli_error($mysqli));
$display_block.="
<div class='row'>";
	while($txt = mysqli_fetch_array($get_txt_res)){
		if(isset($_GET['lang']) && $_GET['lang']=='LT'){
			$txt_title = $txt['txt_title'];
			$txt_info = $txt['txt_info'];
		}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
			$txt_title = $txt['txt_title_EN'];
			$txt_info = $txt['txt_info_EN'];
		}else{
			$txt_title = $txt['txt_title'];
			$txt_info = $txt['txt_info'];
		}
		
	$display_block.="
		<div class='panel panel-success' >
			<div class='panel-heading text-center'>
				<h3 class='panel-title'>$txt_title</h3>
			</div>
			
			<div class='panel-body'>
			<p>$txt_info</p>

			</div>
		</div>";
	}
$display_block.="	
</div>
	
";
echo $display_block;
}else if(isset($_GET['submenu']) && $_GET['submenu']=='Kurybines-popietes'){
	$get_txt = "SELECT * FROM navbar_submenu_text WHERE submenu_id = '2' ORDER BY id DESC";
	$get_txt_res = mysqli_query($mysqli, $get_txt) or die(mysqli_error($mysqli));
$display_block.="
<div class='row'>";
	while($txt = mysqli_fetch_array($get_txt_res)){
		if(isset($_GET['lang']) && $_GET['lang']=='LT'){
			$txt_title = $txt['txt_title'];
			$txt_info = $txt['txt_info'];
		}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
			$txt_title = $txt['txt_title_EN'];
			$txt_info = $txt['txt_info_EN'];
		}else{
			$txt_title = $txt['txt_title'];
			$txt_info = $txt['txt_info'];
		}
		
	$display_block.="
		<div class=' panel panel-success' >
			<div class='panel-heading text-center'>
				<h3 class='panel-title'>$txt_title</h3>
			</div>
			
			<div class='panel-body'>
			<p>$txt_info</p>

			</div>
		</div>";
	}
$display_block.="	
</div>
	
";
echo $display_block;
}
 else {
	//show main page
	include_once 'mainContent.php';
}

?>	

	</body>
</html>