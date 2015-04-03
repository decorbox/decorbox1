
<?php 
ob_start();
session_start();
include 'library.php'; 
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
		
	</head>
	<body>
<div class="container">
	
	<?php include 'header.php'; 
		 include 'navbar.php';
		include 'displayCategories.php';
	?>
</div>

	
	</body>

</html>