
<?php 
ob_start();
session_start();
//include 'library.php'; 
include 'connect.php';

if (!isset($_GET['lang'])) {
   header('Location: ?lang=LT');
}
//select language
if(isset($_GET['lang']) && $_GET['lang']=='LT'){
	include 'content_LT.php';
}else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
	include 'content_EN.php';
}else{
	include 'content_LT.php';
}



?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Decorbox</title>
		<link rel="shortcut icon" type="image/x-icon" href="images/decorbox/favicon.ico" />
	</head>
	<body>
<div class="container">
	
	<?php include 'header.php'; 
		 include 'navbar.php';
		include 'displayCategories.php';
	?>
</div>

<div class="container">
	<div class="row">
		<?php include 'footer.php'; ?>
	</div>
</div>	
	</body>

</html>