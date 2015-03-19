<?php 
ob_start();
session_start();
include 'library.php';
include 'connect.php';
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Decorbox</title>
	</head>
	<body>
<div class="container">
	<div class="row">
		<div class="col-md-12 border-color">
			<h1>Header</h1>
			<?php echo "ideti nuotrauku galerija paspaudus ant kategorijos butu mygtukas, headeryje skaidres, po krepseliu idet widgetu, showcart.php prie sumos pridet siuntimo kaina ir parodyti ir padaryti kad butu galima keisti kiekius, checkout php rudyti jau galutine kaina su siuntimu, kai vartotojas padaro uzsakyma turi nusiusti i el pasta informacija, kai adminas patvirtina uzsakyma i el pasta turi nusiusti vartotojui kad uzsakymas patvirtintas, padaryt kad kategorijas butu galima isdeliot taip kaip nori";?>

		</div>
	</div>

	<div class="row margin-top">
		<div class="col-md-12 ">
			
		</div>
	</div>
	
	<?php  
		include 'displayCategories.php';
	?>
		
	</body>

</html>