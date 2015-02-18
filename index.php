<!DOCTYPE HTML>
<html>
	<head>
		<title>Bootstrap test</title>
	
		<?php 
			
			include 'library.php';
			include 'connect.php';
			session_start();
			
		?>
	</head>
	<body>
<div class="container">
	<div class="row">
		<div class="col-md-12 border-color">
			<h1>Header</h1>

		</div>
	</div>

	<div class="row">
		<div class="col-md-12 border-color">
			<p>up meniu</p>
		</div>
	</div>
<!--
	<div class="row">
		<div class="col-md-3 border-color">
			<?php /*include 'displayCategories.php';?>
		</div>
		<div class="col-md-6 border-color">
			<?php include 'showCategoriesItems.php';

			?>
		</div>
		<div class="col-md-3 border-color">
			<?php include 'showPriceWidget.php';*/
			?>
		</div>

	</div> 
</div>	-->
	
	<?php  
		
			//include 'mainContent.php';// kad roduty main is pradziu
		
		
			
		
			include 'displayCategories.php'; 
		
	?>
		
	</body>

</html>