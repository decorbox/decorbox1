
<?php 

//Connects to your Database 
include 'connect.php';
include 'library.php'; 

?>


<script type="text/javascript">//load table stuff
$(document).ready(function() {
    $('.tableStuffOrderDesc').dataTable({
    	"order": [[ 0, "desc" ]]//order desc
    });
    $('.tableStuff').dataTable();//order asc
} );

$(document).ready(function() {
  	$(".selectOption").select2({ minimumResultsForSearch: Infinity });//run sorting, INFINITY PASLEPE SEARCH BAR
});

</script>


<?php
$display_block ="";

//checks cookies to make sure they are logged in 
if(isset($_COOKIE['ID_my_site'])) 
	{ 	
 	$username = $_COOKIE['ID_my_site']; 
 	$pass = $_COOKIE['Key_my_site']; 
 	$check = mysqli_query($mysqli, "SELECT * FROM users WHERE username = '$username'")or die(mysqli_error()); 
 	while($info = @mysqli_fetch_array( $check )) // @ - disable DUMB warning when image is uploaded	 
 		{ 
 //if the cookie has the wrong password, they are taken to the login page 
 		if ($pass != $info['password']) 
 			{ 			//header("Location: login.php"); //login 
 				echo "<div class='row'><div class='col-md-4 col-md-offset-4' ><h1 class='text-center'>Prašome prisijungti</h1>";
 				include 'login.php';
 				echo "</div></div>";
 			} 

 //otherwise they are shown the admin area	 
 		else 
 			{	if($info['role']!="Admin"){echo "<h1>Jūs nesate administratorius</h1>";}
	 			if($info['role']=="Admin"){
	 				//admin menu
	 				$display_block .= "
	 				
	 					<div class='row'>
	 						<div class='col-md-12'>
	 							<h1 class='text-center'>Valdymo skydas</h1>
	 						</div>
	 					</div>
	 					<div class='row'>
	 						<div class='col-md-2 border-color'>
	 							<div class='list-group'>";
	 							if(isset($_GET['menu']) && $_GET['menu']=='vartotojai'){
	 				$display_block.="<a href='".$_SERVER['PHP_SELF']. "?menu=vartotojai' class='list-group-item active'>
							            <span class='glyphicon glyphicon-user'></span> Vartotojai
							        </a>";
	 							}else{
	 				$display_block.="<a href='".$_SERVER['PHP_SELF']. "?menu=vartotojai' class='list-group-item '>
							            <span class='glyphicon glyphicon-user'></span> Vartotojai
							        </a>";
							    }
							    if(isset($_GET['menu']) && $_GET['menu']=='prekes'){
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?menu=prekes' class='list-group-item active'>
							            <span class='glyphicon glyphicon-file'></span> Prekės
							        </a>";
							    }else{
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?menu=prekes' class='list-group-item'>
							            <span class='glyphicon glyphicon-file'></span> Prekės
							        </a>";
							    }
							    if(isset($_GET['menu']) && $_GET['menu']=='kategorijos'){
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?menu=kategorijos' class='list-group-item active'>
							            <span class='glyphicon glyphicon-th-list'></span> Kategorijos
							        </a>";
							    }else{
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?menu=kategorijos' class='list-group-item'>
							            <span class='glyphicon glyphicon-th-list'></span> Kategorijos
							        </a>";
							    }
							    if(isset($_GET['menu']) && $_GET['menu']=='uzsakymai'){
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?menu=uzsakymai' class='list-group-item active'>
							            <span class='glyphicon glyphicon-shopping-cart'></span> Užsakymai
							        </a>";	    	
							    }else{
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?menu=uzsakymai' class='list-group-item'>
							            <span class='glyphicon glyphicon-shopping-cart'></span> Užsakymai
							        </a>";
							    }
							     if(isset($_GET['menu']) && $_GET['menu']=='galerija'){
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?menu=galerija' class='list-group-item active'>
							            <span class='glyphicon glyphicon-shopping-cart'></span> Nuotraukų galerija
							        </a>";	    	
							    }else{
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?menu=galerija' class='list-group-item'>
							            <span class='glyphicon glyphicon-shopping-cart'></span> Nuotraukų galerija
							        </a>";
							    }

	 			$display_block.="</div>
	 						</div>
	 				
	 						<div class='col-md-10 border-color'>";
	//----------VARTOTOJAI PUSLAPIS	 						
		 				if(isset($_GET['menu']) && $_GET['menu']=='vartotojai'){
		 					include 'adminMenuUsers.php'; 
		 				}		
	//---------PREKES puslapis		
		 				if(isset($_GET['menu']) && $_GET['menu']=='prekes'){
		 					include 'adminMenuItems.php';
						}
	//------------KATEGORIJOS PUSLAPIS
					    if(isset($_GET['menu']) && $_GET['menu']=='kategorijos'){
					    	include 'adminMenuCategories.php';
					    }
    //-------------UZSAKYMAI PUSLAPIS

					    if(isset($_GET['menu']) && $_GET['menu']=='uzsakymai'){
					    	include 'adminMenuOrders.php';
					    }
	//-------------GALERIJA PUSLAPIS				    
					    if(isset($_GET['menu']) && $_GET['menu']=='galerija'){
					    	include 'adminMenuPhotoGallery.php';
/*					    	$display_block.= "<h1 class='text-center'>Nuotraukų galerija</h1>";

							$display_block.="
							<div class='row'>
								<div class='col-md-10'>
									<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addPhoto'><span class='glyphicon glyphicon-plus' aria-hidden='true'></span>Įdėti nuotrauką</button>
								</div>
							</div>

							<div class='row'>
								<div class='col-md-10'>
									";
									$show_image="SELECT * FROM store_items";
									$show_image_res = mysqli_query($mysqli, $show_image);
									while($img = mysqli_fetch_array($show_image_res)){
										$image = $img['item_image'];
								$display_block.="<img width='200px' height='200px' src='$image'></img>";

									}

							$display_block.="		
								</div>
							</div>
							";
*/
						}
					


	 	$display_block.="   </div>
	 					</div>";//end of main page row
	 				
	 						
	 			}//end of admin page
 			}//end of while check 
 		}
 		echo $display_block;
	}//end of IF ID_my_site 

	else{ 
	 //if the cookie does not exist, they are taken to the login screen 
		echo "<div class='row'><div class='col-md-4 col-md-offset-4' ><h1 class='text-center'>Prašome prisijungti</h1>";
	 				include 'login.php';
	 	echo "</div></div>";		
		 } 

 ?> 
