
<?php
//anglu isversta
include 'connect.php';
//include 'library.php';
?>
<script type="text/javascript">
	$(document).ready(function(){
  $('.slider3').bxSlider({
    speed: 1000,
	auto: true
    
  });
});
//https://github.com/stevenwanderski/bxslider-4
</script>
<?php
if(isset($_GET['lang']) && $_GET['lang']=='LT'){
		include 'content_LT.php';
	}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
		include 'content_EN.php';
	}else{
		include 'content_LT.php';
	}
$display_block2="";
$display_block2.="
<div class='row margin-top20'>
	<div class='hidden-xs text-center panel panel-success' >
		<div class='panel-heading'>
			<a href='?lang=".$_GET['lang']."&special=yes'>
				<h3 class='panel-title'> $txtspecial_offers</h3>
			</a>
		</div>
		
		<div class='panel-body slider3'>";
		$get_special_item = "SELECT * FROM store_items WHERE item_price_old != 'NULL' order by id DESC";
		$get_special_item_res = mysqli_query($mysqli, $get_special_item);
		while ($item = mysqli_fetch_array($get_special_item_res)) {
			$item_id = $item['id'];
			if(isset($_GET['lang']) && $_GET['lang']=='LT'){
				$item_title = stripslashes($item['item_title']);
			}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
				$item_title = stripslashes($item['item_title_EN']);
			}else{
				$item_title = stripslashes($item['item_title']);
			}
			
			$item_price = $item['item_price'];
			$item_price_old = $item['item_price_old'];
			$discount = $item_price_old - $item_price;
			$item_image = $item['item_image'];
		$display_block2.="
			<div class='col-lg-12-edit col-md-12-edit col-sm-12-edit col-xs-12-edit  '>
			  	<div class='text-center panel panel-success'>
		      		<a href='showitem.php?lang=".$_GET['lang']."&item_id=".$item_id."'>
				        <div class='panel-heading'>
				       		<h3 class='panel-title'>$item_title</h3>
				      	</div>
				    </a>
			   		
			   		<div class='panel-body panel-body-edi slide'>
				   		<div class='row'>
					   		<div id='posts' class='col-md-12-edit col-sm-6-edit col-xs-6-edit ' > 
					   			
				        		<img margin='auto' class='margin-top20 text-center img-responsiv specialImgSize' src='$item_image'/>
				        		
				        	</div>
				        	<form method='post' style='weigth:500px' action='addtocart.php'>
					        	<div class=' col-md-12-edit col-sm-12-edit col-xs-12-edit '>
					        		<div class='row '>
					        			<div class=' col-lg-12-edit col-md-12-edit col-sm-12-edit col-xs-12-edit margin-left15 '>
						        			
												<label class=' margin-top20 margin-left20' for='sel_item_qty'>$txtqty:</label><br>
												<input type='number' min='1' value='1' class='inputWidth margin-left-20' name='sel_item_qty' id='sel_item_qty'>
							
						     					<div class='row'>
						     						<div class='col-lg-12-edit col-md-12-edit col-sm-12-edit col-xs-12-edit'>
						        						<p class='labelSize margin-left20' style='text-decoration: line-through;'>$txtold_price:".$item_price_old."&euro;</p>
						        					</div>
						        					<div class='col-lg-12-edit col-md-12-edit col-sm-12-edit col-xs-12-edit'>
						        						<p class='margin-left20' >$txtitemDiscount:".$discount."&euro;</p>
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



$display_block2.="
		</div>
	</div>
</div>	
		";
echo $display_block2;




			
		
