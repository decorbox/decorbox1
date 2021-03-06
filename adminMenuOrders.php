<?php
$display_modal_table ="";
					    	$display_block.= "<h1 class='text-center'> Užsakymai</h1>";
				$display_block.=" <div class='row'>
	 						    <table class='table  tableStuffOrderDesc text-center table-responsive table-striped table-bordered' >
							        <thead>
							            <tr>
							                <th class='text-center'>ID</th>
							                <th class='text-center'>Vardas</th>
							                <th class='text-center'>Suma</th>
							                <th class='text-center'>Šalis</th>
							                <th class='text-center'>Miestas</th>
							                <th class='text-center'>Adresas</th>
							                <th class='text-center'>El. Paštas</th>
							                <th class='text-center'>Telefono Nr.</th>
							                <th class='text-center'>Pašto kodas</th>
							                
							                <th class='text-center'>Statusas</th>
							                <th class='text-center'>Užsakymo Data</th>
							                <th class='text-center'>Veiksmai</th>
							            </tr>
							        </thead>
							 
							        <tfoot>
							            <tr>
							                <th class='text-center'>ID</th>
							                <th class='text-center'>Vardas</th>
							                <th class='text-center'>Suma</th>
							                <th class='text-center'>Šalis</th>
							                <th class='text-center'>Miestas</th>
							                <th class='text-center'>Adresas</th>
							                <th class='text-center'>El. Paštas</th>
							                <th class='text-center'>Telefono Nr.</th>
							                <th class='text-center'>Pašto kodas</th>
							                
							                <th class='text-center'>Statusas</th>
							                <th class='text-center'>Užsakymo Data</th>
							                <th class='text-center'>Veiksmai</th>
							            </tr>
							        </tfoot>
							 
							        <tbody>";

									$select_orders="SELECT * FROM store_orders";
									$select_orders_res = mysqli_query($mysqli, $select_orders);

									while($order = mysqli_fetch_array($select_orders_res)){
										$order_id = $order['id'];
										$order_date = $order['order_date'];
										$order_name = $order['order_name'];
										$order_address = $order['order_address'];
										$order_city = $order['order_city'];
										$order_country = $order['country'];
										$order_zip = $order['order_zip'];
										$order_tel = $order['order_tel'];
										$order_email = $order['order_email'];
										//$order_item_total = $order['item_total'];
										$order_shipping_total = $order['shipping_total'];
										$order_authorization = $order['authorization'];
										$order_status = $order['status'];

							$display_block.="
										<tr>
											<td>$order_id</td>
											<td class='row_width'>$order_name</td>
											<td> $order_shipping_total &euro;</td>
											<td class='row_width'>$order_country</td>
											<td class='row_width'>$order_city</td>
											<td class='row_width'>$order_address</td>
											<td class='row_width'>$order_email</td>
											<td class='row_width'>$order_tel</td>
											<td class='row_width'>$order_zip</td>
											
											<td><div class='row'>$order_status</div>";
											//status icon
												if($order_status=="Atlikta"){
													$display_block.="<span style='color:green' class='glyphicon glyphicon-ok'></span>";
												}else{
													$display_block.="<span style='color:red' class='glyphicon glyphicon-remove'></span>";
												}
												$display_block.="
												 <button style='float:right' type='button' class='btn btn-default' data-toggle='modal' data-target='#status".$order_id."'>
												
									        	<span class='glyphicon glyphicon-cog'></span>
									        	</button>";
									        	
							$display_block.="</td>
											<td class='row_width'>$order_date</td>
											<td>
												<div class='row'>
													<div class='col-md-6'>
														<button type='button' class='btn btnLeft btn-danger' data-toggle='modal' data-target='#del".$order_id."'>
														  <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
														</button>
														</div>

														<div class='col-md-6'>
														<button type='button' class='btn btnLeft1 btn-success' data-toggle='modal' data-target='#items".$order_id."'>
														  <span class='glyphicon glyphicon-search' aria-hidden='true'></span>
														</button>
													</div>
												</div>
											</td>
										</tr>";

$display_block.="<!-- Edit Status Modal -->
<div class='modal fade' id='status".$order_id."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>Keisti statusą</h4>
			</div>
			<form class='form-horizontal' method='post' >
				<div class='modal-body'>
				<p><b>Vardas:</b> $order_name <br> <b>Vartotojo vardas:</b> $order_authorization <br> <b>El. Paštas:</b> $order_email <br> <b>Statusas:</b>
					<select  class='selectOption' style='width:50%' name='selectStatus'>";

					//get 'role' enum values
				$result = mysqli_query($mysqli, "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
				    WHERE TABLE_NAME = 'store_orders' AND COLUMN_NAME = 'status'") or die (mysqli_error($mysqli));
				$row = mysqli_fetch_array($result);
				$row_num = mysqli_num_rows($result);
				
				$enumList = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));
				for($i = 0; $i<=1; $i++){
					$display_block.="<option value='".$enumList[$i]."'>".$enumList[$i]."</option>";
				}	
	$display_block.="</select>
				</p>
				</div>

				<div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Uždaryti</button>
					<input type='hidden' value='".$order_email."' name='getEmail'>
					<button type='submit' value='".$order_id."' name='submitStatus' class='btn btn-primary'>Išsaugoti</button>
				</div>
			</form>
		</div>
	</div>				
</div>";

$display_block.="<!-- Delete Order Modal -->
<div class='modal fade' id='del".$order_id."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>Ar tikrai norite ištrinti užsakymą, kurio ID yra ".$order_id."?</h4>
			</div>
			<form class='form-horizontal' method='post' >";

				$show_items = "SELECT item_id, item_qty FROM store_orders_items_item WHERE order_id='".$order_id."'";
				$show_items_res = mysqli_query($mysqli, $show_items);
				
				while($store_items = mysqli_fetch_array($show_items_res)){
					$store_item_id = $store_items['item_id'];
					$store_item_qty = $store_items['item_qty'];
					$display_block .= "<input type='hidden' name='updateItemQty[]' value='".$store_item_qty."'>
									<input type='hidden' name='updateItemID[]' value='".$store_item_id."'>
					";
				}
				$display_block.="
				<div class='checkbox text-center'>
				  <label><input type='checkbox' name='updateQty' value='1'>Nesumokėjo/Grąžino prekes</label>
				</div>
				<div class='margin-bottom15 text-center'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Uždaryti</button>
					<button type='submit' value='".$order_id."' name='deleteOrder' class='btn btn-primary'>Ištrinti</button>
				</div>
			</form>
		</div>
	</div>				
</div>";


$display_modal_table.="<!-- Show Order Items Modal -->
<div class='modal fade' id='items".$order_id."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>Vartotojo: $order_authorization, pirkinių krepšelis</h4>
			</div>
			
			<div class='modal-body'>
				<table class='table tableStuff text-center table-responsive table-striped table-bordered' cellspacing='0' width='100%'>
					<thead>
			            <tr><th class='text-center'>Prekės ID</th>
			            	<th class='text-center'>Nuotrauka</th>
			            	<th class='text-center'>Pavadinimas</th>
						    <th class='text-center'>Kiekis</th>
					        <th class='text-center'>Visa Kaina</th>						              
			            </tr>
					</thead>
	 
					 <tbody>";			
			$show_orders_items = "SELECT * FROM store_orders_items_item WHERE order_id='".$order_id."'";
			$show_orders_items_res = mysqli_query($mysqli, $show_orders_items);
				
				while($items = mysqli_fetch_array($show_orders_items_res)){
					$item_id = $items['item_id'];
					$item_qty = $items['item_qty'];
					$item_full_price = $items['item_price'];

					$full_price_sql = "SELECT sel_item_price FROM store_orders_items WHERE order_id = '".$order_id."'";
					$full_price_res = mysqli_query($mysqli, $full_price_sql);
					$full_price1 = mysqli_fetch_assoc($full_price_res);
					$full_price = $full_price1['sel_item_price'];

					$show_item_sql = "SELECT item_title, item_image FROM store_items WHERE id = '".$item_id."'";
					$show_item_res = mysqli_query($mysqli, $show_item_sql);
					$show_item = mysqli_fetch_assoc($show_item_res);

	$display_modal_table.="
					<tr><td>$item_id</td>
						<td><img class='adminImgSize' src='".$show_item['item_image']."'></td>
						<td>".$show_item['item_title']."</td>
						<td>$item_qty</td>
						<td>$item_full_price &euro;</td>
					</tr>	
					";
				}
				
	$display_modal_table.="
					</tbody> 
					<tr style='color:red;'>
						<td class='text-right' colspan='4'><label>Galutinė kaina:</label></td>
						<td><strong>$full_price</strong>&euro;</td>

					</tr>
				</table>	
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-default' data-dismiss='modal'>Uždaryti</button>
			</div>		
		</div>
	</div>		
</div>";

									}//end of while order

//if submit status form									
if(isset($_POST['submitStatus'])){
	$update_status_sql = "UPDATE store_orders SET status = '".$_POST['selectStatus']."' WHERE id = '".$_POST['submitStatus']."'";
	$update_status_rs = mysqli_query($mysqli, $update_status_sql);
 	if($_POST['selectStatus']=='Atlikta'){
		 	
		$to = $_POST['getEmail'];
		$subject = "Jūsų užsakymas priimtas Decorbox.lt";

		$message = "
		<html>
		<head>
		<title>Jūsų užsakymas priimtas ir išsiųstas</title>
		</head>
		<body>
		<p>Jūsų užsakymas patvirtintas, prekės buvo išsiųstos nurodytu adresu. Dėkojame, kad perkate pas mus.</p><br>
		<p>Decorbox.lt</p>

		</body>
		</html>
		";

		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		$headers .= 'From: <decorbox.lt@gmail.com>' . "\r\n";
		mail($to,$subject,$message,$headers);
		echo("<meta http-equiv='refresh' content='0'>");//reflesh page
 	}
}
//if submit delete order
if(isset($_POST['deleteOrder'])){
	if(isset($_POST['updateQty'])){//update store_items qty,  when no items sent
		$arraySize = sizeof($_POST['updateItemID']);
		$arrayID = $_POST['updateItemID'];
		$arrayQty = $_POST['updateItemQty'];

		for($i=0; $i< $arraySize; $i++){
			
			$update_store_items = "UPDATE store_items SET qty = qty + '".$arrayQty[$i]."' WHERE id = '".$arrayID[$i]."'";
			$update_store_items_res = mysqli_query($mysqli, $update_store_items) or die(mysqli_error($mysqli));
		}

	}
	
	$del_order = "DELETE FROM store_orders WHERE id = '".$_POST['deleteOrder']."'";
	$del_order_res = mysqli_query($mysqli, $del_order);

	$del_order_items = "DELETE FROM store_orders_items WHERE order_id = '".$_POST['deleteOrder']."'";
	$del_order_items_res = mysqli_query($mysqli, $del_order_items);

	$del_order_items_item = "DELETE FROM store_orders_items_item WHERE order_id = '".$_POST['deleteOrder']."'";
	$del_order_items_item_res = mysqli_query($mysqli, $del_order_items_item);
	echo("<meta http-equiv='refresh' content='0'>");//reflesh page
}
						$display_block.="
									</tbody>
								</table>
							</div>	
						";			      
$display_block .= $display_modal_table; //add to display block modal table, because of error 2x table inside