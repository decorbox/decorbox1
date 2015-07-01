<style type="text/css">.panel2{border:none;}</style>
<?php
//anglu isversta
include 'connect.php';
//include 'library.php';
if(isset($_GET['lang']) && $_GET['lang']=='LT'){
		include 'content_LT.php';
	}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
		include 'content_EN.php';
	}else{
		include 'content_LT.php';
	}

//$display_block1="";
$display_block1
.="
<div class=''> 
	<div class='visible-sm visible-xs text-center panel panel2 panel-success' >
		<div class='panel-heading'>
			<h3 class='panel-title'><span class='glyphicon glyphicon-shopping-cart' aria-hidden='true'></span> $txtbasket</h3>
		</div>
		
		<div class='panel-body'>";//price widget border

if(isset($_COOKIE['PHPSESSID'])){
//get order_id
	$get_order_id_sql = "SELECT id FROM store_shoppertrack WHERE session_id = '".$_COOKIE['PHPSESSID']."'";
	$run_order_id_res = mysqli_query($mysqli, $get_order_id_sql) or die(mysqli_error($mysqli));
	while($info = mysqli_fetch_array( $run_order_id_res))    
	{ 
	    $order_id = $info['id'];
	}  
}
//get widget info
if (isset($order_id)) {

	$get_cart_sql = "SELECT st.order_id, si.item_price, st.sel_item_qty FROM
	store_shoppertrack_items AS st LEFT JOIN store_items AS si ON si.id = st.sel_item_id WHERE order_id ='".$order_id."'"; 
	$get_cart_res = mysqli_query($mysqli, $get_cart_sql) or die(mysqli_error($mysqli));
					
	if (mysqli_num_rows($get_cart_res) < 1) {
		//print message
		$display_block1 .= "
		<!--<div class='text-center '>-->
		 	<label>
				$txtno_basket_items
			</label>
		<!--</div>-->
		";
	}
	else {
		$full_price=0; 
		$full_qty=0;
		while ($cart_info = mysqli_fetch_array($get_cart_res)) {
			$id = $cart_info['order_id'];
			$item_price = $cart_info['item_price'];
			$item_qty = $cart_info['sel_item_qty'];
			$full_qty =  $full_qty + $item_qty; //galutinis kiekis
			$total_price = sprintf("%.02f", $item_price * $item_qty); 
			$full_price = sprintf("%.02f", $full_price+$total_price); //galutine kaina
		}
		$display_block1 .= "<div><p class='labelSize'>$txtqty: $full_qty </p></div>";
		$display_block1 .= "<div><p class='labelSize'>$txtprice: $full_price &euro;</p></div>";
		$display_block1 .= "<a href='showcart.php?lang=".$_GET['lang']."' role='button' style='width:100%' class='btn btn-primary'>$txtshow_basket</a>";	
	}
	$display_block1.="
		</div>
	</div>
</div>
	
";


	mysqli_free_result($get_cart_res);
}else{
	$display_block1 .= "
		<div class=' text-center'>
		 	<label>
				$txtno_basket_items
			</label>
		</div>
	</div>
	</div>
</div>
	";
}
//echo $display_block1;


?>

			
		
