
<?php 
ob_start();
session_start();
include 'library.php';
include 'connect.php';
print_r($_SESSION);
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
			<h1>Logo</h1>
			<!--<img width="200" height="200px;" src="images/skaidre.jpg">
			<img width="200" height="200px;" src="images/skaidre2.jpg">
			<img width="200" height="200px;" src="images/drugelis.jpg">
			<img width="200" height="200px;" src="images/skaidre2.jpg">
			<img width="200" height="200px;" src="images/skaidre2.jpg"> -->
			<?php echo "3 prekes per eilute .KONTAKTAI ir  Turite klausimų? +370 627 00354. ruzava su ryskia ruda spava (teksto spalva, linijos 3F1515
F888BB),pagrindiniam lange specialus pasiulymas butu  prekes su nuolaida. ant pagrinidio dar galerijos pora fotkiu, kai jas paspaudi rodo kategorijos arba subcat galerija. priminimas: kai galutinai bus paruosta duomenu baze resetinti ID laukus nes gali dubliuotis jei visus duomenis is ten istrynsiu. per kiek dienu pristatymas? ideti nuotrauku galerija paspaudus ant kategorijos butu mygtukas, headeryje skaidres, po krepseliu idet widgetu,  kai vartotojas padaro uzsakyma turi nusiusti i el pasta informacija, kai adminas patvirtina uzsakyma i el pasta turi nusiusti vartotojui kad uzsakymas patvirtintas, ";?>

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