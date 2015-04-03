
<?php
session_start();

// Include the main TCPDF library (search for installation path).
require_once('pdf/tcpdf_import.php');
require_once('pdf/mailer/class.phpmailer.php');
include 'connect.php';

//create new PDF document
if(isset($_GET['lang']) && $_GET['lang']=='LT'){
        include 'content_LT.php';
    }else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
        include 'content_EN.php';
    }else{
        include 'content_LT.php';
    }

$order_id = $_COOKIE['order_id'];
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Decorbox');
$pdf->SetTitle('Decorbox');
$pdf->SetSubject('Payment');
$pdf->SetKeywords('Payment, PDF');



/*
//foto yra pdf\examples\images
// set default header data
$pdf->SetHeaderData('logo.png', PDF_HEADER_LOGO_WIDTH, 'Decorbox', 'stringas');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
*/
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$pdf->setPrintHeader(false);//nerodo header ir footer
$pdf->setPrintFooter(false);

// set some language-dependent strings (optional)
//if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
//    require_once(dirname(__FILE__).'/lang/eng.php');
 //   $pdf->setLanguageArray($l);
//}


$select_user_info="SELECT * FROM store_orders WHERE id='".$order_id."'";
$select_user_info_res= mysqli_query($mysqli, $select_user_info);

while($user = mysqli_fetch_assoc($select_user_info_res)){//buvo array
	$user_name=$user['order_name'];
	$user_address = $user['order_address'];
	$user_country = $user['country'];
	$user_city = $user['order_city'];
	$user_zip = $user['order_zip'];
	$user_tel = $user['order_tel'];
	$user_email = $user['order_email'];
	$shipping_total = $user['shipping_total'];
	$order_date = $user['order_date'];
}
// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', 'B', 12, '', false);

// add a page
$pdf->AddPage();

$pdf->Write(0, $txtvat_invoice, '', 0, 'C', true, 0, false, false, 0);
$pdf->SetFont('dejavusans', '', 10, '', false);
$pdf->Write(0, $txtorder_id.': '.$order_id, '', 0, 'C', true, 0, false, false, 0);
$pdf->Write(0, $order_date, '', 0, 'C', true, 0, false, false, 0);


// 2 columns-----------------------------------------------------------------------------
$pdf->SetTopMargin(40);



$left_column = "
<strong align=\"center\">$txtseller</strong> 

	<p>
<strong>$txtcompany:</strong> MB „Viskas jūsų šventei“<br>
<strong>$txtbank_acc:</strong> LT077300010142612531<br>
<strong>$txtcompany_code:</strong> 303944367<br>
<strong>$txtemail:</strong> decorbox.lt@gmail.com <br>
<strong>$txtphone:</strong> +370 627 00354 

	</p>

";


$right_column = "
<strong align=\"center\">$txtbuyer</strong> 
	<p>
<strong>$txtinput_name:</strong> $user_name<br>
<strong>$txtaddress:</strong> $user_address<br>
<strong>$txtcity:</strong> $user_city<br>
<strong>$txtzip:</strong> $user_zip<br>	
<strong>$txtcountry:</strong> $user_country<br>
<strong>$txtphone:</strong>	$user_tel<br>
<strong>$txtemail:</strong> $user_email


	</p>
";

// set color for background
$pdf->SetFillColor(255, 255, 255);

// set color for text
$pdf->SetTextColor(0, 0, 0);
// write the first column
$pdf->writeHTMLCell(90, '', '', '', $left_column, 0, 0, 1, true, 'J', true);
// write the second column
// set color for background
$pdf->SetRightMargin(14);
$pdf->SetFillColor(255, 255, 255);

// set color for text
$pdf->SetTextColor(0, 0, 0);
//90 - plotis celliu							//1-border
$pdf->writeHTMLCell(100, '', '', '', $right_column, 0, 1, 1, true, 'J', true);
$pdf->SetTopMargin(100);


//$pdf->Ln(4);
//---------------


$get_cart_email_sql = "SELECT st.order_id, si.item_title, si.item_title_EN , si.item_price, si.id, st.item_qty FROM
	store_orders_items_item AS st LEFT JOIN store_items AS si ON si.id = st.item_id WHERE order_id ='".$order_id."'";
$get_cart_email_res = mysqli_query($mysqli, $get_cart_email_sql) or die(mysqli_error($mysqli));
$display_block = "";
$display_block .= "
<p><strong align=\"center\">$txtitem_info</strong></p>
		<table align=\"center\" cellspacing=\"0\"  cellpadding=\"7\" border=\"1\">
			<tr>
				<th border=\"2\"><strong>$txttitle</strong></th>
				<th border=\"2\"><strong>$txtprice</strong></th>
				<th border=\"2\"><strong>$txtqty</strong></th>
				<th border=\"2\"><strong>$txtsum</strong></th>
			</tr>";


		// info is shoppertrack
		$full2_qty=0;
		$full2_price=0;
		while ($cart2_info = mysqli_fetch_array($get_cart_email_res)) {
		$item2_id = $cart2_info['id'];//nenaudojamas

		if(isset($_GET['lang']) && $_GET['lang']=='LT'){
	        	$item2_title = stripslashes($cart2_info['item_title']);
		    }else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
		        $item2_title = stripslashes($cart2_info['item_title_EN']);
		    }else{
		        $item2_title = stripslashes($cart2_info['item_title']);
	    }
		
		$item2_price = $cart2_info['item_price'];
		$item2_qty = $cart2_info['item_qty'];
		$full2_qty =  $full2_qty + $item2_qty;
		$total2_price = sprintf("%.02f", $item2_price * $item2_qty);
		$full2_price = sprintf("%.02f", $full2_price+$total2_price); //galutine kaina

//TABLE DATA
	$display_block .= "
	<tr>
		<td><p>$item2_title</p></td>
		<td><p>$item2_price €</p></td>
		<td><p>$item2_qty</p></td>
		<td><p>$total2_price €</p></td>
	</tr>";

	
	}//end of while
	$shipping = 0;

//jei yra siuntimas i uzsienio salis pridet kaina uzsienyje
	if(isset($_COOKIE['europeShip'])){
		$shipping += $_SESSION['shippingEuropean'];
	}else{//jei i lietuva pridet lietuvos kaina
		if($full2_price<$_SESSION['totalShippingPrice']){
			$shipping += $_SESSION['shipping'];
		}
	}
	
$display_block.="
	<tr>
		<td align=\"right\" colspan=\"3\"><div><label><strong>$txtdelivery :</strong></label></div></td>
		<td ><p><strong><span>" . $shipping .  "</span> €</strong></p></td>
	</tr>
	<tr>
		<td align=\"right\" colspan=\"3\"><div><label><strong>$txtfull_price :</strong></label></div></td>
		<td border=\"2\"><p><strong><span>" . ($full2_price + $shipping) .  "</span> €</strong></p></td>
	</tr>
</table>
";


$pdf->writeHTML($display_block, true, false, false, false, '');

// -----------------------------------------------------------------------------
 ob_end_clean();//corrent output error
//Close and output PDF document
$pdf->Output('test.pdf', 'I');
//header("Location: checkout_success.php?lang=".$_GET['lang']."");
/*
 $pdf->Output('Payment.pdf', 'S');
 SENDmail($pdf);

 function SENDmail($pdf){
 	$mailer = new PHPMailer();

 	$mailer->AddReplyTo('zvejysnr1@gmail.com', 'Reply To');
 	//$mailer->SetFrom ('decorbox.lt@gmail.com', 'Sent From');
 	$mailer->Subject = 'Decorbox.lt prekių užsakymas';
 	$mailer->MsgHTML = "<h5>Sveikiname</h5> užsisakę prekes iš Decorbox.lt, per tris dienas prašome apmokėti sąskaitą";
 	if ($pdf){
 		echo "email sent";
 		$mailer->AddStringAttachment($pdf, 'Payment.pdf');
 		$mailer->Send();
 	}
 }*/