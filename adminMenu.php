
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
	 							<a href='index.php?lang=".$_GET['lang']."'> <h2 class='pull-left'><--Grįžti į Decorbox</h2></a>
	 							<h1 class='text-center'>Valdymo skydas</h1>
	 						</div>
	 					</div>
	 					<div class='row'>
	 						<div class='col-md-2 '>
	 							<div class='list-group'>";
	 							if(isset($_GET['menu']) && $_GET['menu']=='vartotojai'){
	 				$display_block.="<a href='".$_SERVER['PHP_SELF']. "?lang=".$_GET['lang']."&menu=vartotojai' class='list-group-item active'>
							            <span class='glyphicon glyphicon-user'></span> Vartotojai
							        </a>";
	 							}else{
	 				$display_block.="<a href='".$_SERVER['PHP_SELF']. "?lang=".$_GET['lang']."&menu=vartotojai' class='list-group-item '>
							            <span class='glyphicon glyphicon-user'></span> Vartotojai
							        </a>";
							    }
							    if(isset($_GET['menu']) && $_GET['menu']=='prekes'){
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?lang=".$_GET['lang']."&menu=prekes' class='list-group-item active'>
							            <span class='glyphicon glyphicon-file'></span> Kategorijų prekės
							        </a>";
							    }else{
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?lang=".$_GET['lang']."&menu=prekes' class='list-group-item'>
							            <span class='glyphicon glyphicon-file'></span> Kategorijų prekės
							        </a>";
							    }
							    if(isset($_GET['menu']) && $_GET['menu']=='meniuprekes'){
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?lang=".$_GET['lang']."&menu=meniuprekes' class='list-group-item active'>
							            <span class='glyphicon glyphicon-file'></span> Meniu prekės
							        </a>";
							    }else{
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?lang=".$_GET['lang']."&menu=meniuprekes' class='list-group-item'>
							            <span class='glyphicon glyphicon-file'></span> Meniu prekės
							        </a>";
							    }
							    if(isset($_GET['menu']) && $_GET['menu']=='kursai'){
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?lang=".$_GET['lang']."&menu=kursai' class='list-group-item active'>
							            <span class='glyphicon glyphicon-file'></span> Kursų aprašymai
							        </a>";
							    }else{
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?lang=".$_GET['lang']."&menu=kursai' class='list-group-item'>
							            <span class='glyphicon glyphicon-file'></span> Kursų aprašymai
							        </a>";
							    }
							    if(isset($_GET['menu']) && $_GET['menu']=='kategorijos'){
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?lang=".$_GET['lang']."&menu=kategorijos' class='list-group-item active'>
							            <span class='glyphicon glyphicon-th-list'></span> Kategorijos
							        </a>";
							    }else{
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?lang=".$_GET['lang']."&menu=kategorijos' class='list-group-item'>
							            <span class='glyphicon glyphicon-th-list'></span> Kategorijos
							        </a>";
							    }
							    if(isset($_GET['menu']) && $_GET['menu']=='uzsakymai'){
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?lang=".$_GET['lang']."&menu=uzsakymai' class='list-group-item active'>
							            <span class='glyphicon glyphicon-shopping-cart'></span> Užsakymai
							        </a>";	    	
							    }else{
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?lang=".$_GET['lang']."&menu=uzsakymai' class='list-group-item'>
							            <span class='glyphicon glyphicon-shopping-cart'></span> Užsakymai
							        </a>";
							    }
							     if(isset($_GET['menu']) && $_GET['menu']=='kategorijuGalerija'){
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?lang=".$_GET['lang']."&menu=kategorijuGalerija' class='list-group-item active'>
							            <span class='glyphicon glyphicon-picture'></span> Kategorijų galerija
							        </a>";	    	
							    }else{
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?lang=".$_GET['lang']."&menu=kategorijuGalerija' class='list-group-item'>
							            <span class='glyphicon glyphicon-picture'></span> Kategorijų galerija
							        </a>";
							    }
							    if(isset($_GET['menu']) && $_GET['menu']=='idejuGalerija'){
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?lang=".$_GET['lang']."&menu=idejuGalerija' class='list-group-item active'>
							            <span class='glyphicon glyphicon-picture'></span> Idėjų galerija
							        </a>";	    	
							    }else{
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?lang=".$_GET['lang']."&menu=idejuGalerija' class='list-group-item'>
							            <span class='glyphicon glyphicon-picture'></span> Idėjų galerija
							        </a>";
							    }
							    if(isset($_GET['menu']) && $_GET['menu']=='skaidres'){
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?lang=".$_GET['lang']."&menu=skaidres' class='list-group-item active'>
							            <span class='glyphicon glyphicon-picture'></span> Skaidrės
							        </a>";	    	
							    }else{
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?lang=".$_GET['lang']."&menu=skaidres' class='list-group-item'>
							            <span class='glyphicon glyphicon-picture'></span> Skaidrės
							        </a>";
							    }
							     if(isset($_GET['menu']) && $_GET['menu']=='aprasymai'){
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?lang=".$_GET['lang']."&menu=aprasymai' class='list-group-item active'>
							            <span class='glyphicon glyphicon-pencil'></span> Aprašymai
							        </a>";	    	
							    }else{
					$display_block.="<a href='".$_SERVER['PHP_SELF']. "?lang=".$_GET['lang']."&menu=aprasymai' class='list-group-item'>
							            <span class='glyphicon glyphicon-pencil'></span> Aprašymai
							        </a>";
							    }

	 			$display_block.="</div>
	 						</div>
	 				
	 						<div class='col-md-10 border-color'>";
	//----------VARTOTOJAI PUSLAPIS	 						
		 				if(isset($_GET['menu']) && $_GET['menu']=='vartotojai'){
		 					include 'adminMenuUsers.php'; 
		 				}		
	//---------Kategorijos PREKES puslapis		
		 				if(isset($_GET['menu']) && $_GET['menu']=='prekes'){
		 					include 'adminMenuItems.php';
						}
	//---------Kategorijos PREKES puslapis		
		 				if(isset($_GET['menu']) && $_GET['menu']=='meniuprekes'){
		 					include 'adminMenuNavItems.php';
						}
	//------------KATEGORIJOS PUSLAPIS
					    if(isset($_GET['menu']) && $_GET['menu']=='kategorijos'){
					    	include 'adminMenuCategories.php';
					    }
    //-------------UZSAKYMAI PUSLAPIS

					    if(isset($_GET['menu']) && $_GET['menu']=='uzsakymai'){
					    	include 'adminMenuOrders.php';
					    }
	//-------------KATEGORIJU GALERIJA PUSLAPIS				    
					    if(isset($_GET['menu']) && $_GET['menu']=='kategorijuGalerija'){
					    	include 'adminMenuPhotoGallery.php';
					    }
	//-------------KATEGORIJU GALERIJA PUSLAPIS				    
					    if(isset($_GET['menu']) && $_GET['menu']=='idejuGalerija'){
					    	include 'adminMenuIdeasGallery.php';
						}
	//-------------SKAIDRES PUSLAPIS				    
					    if(isset($_GET['menu']) && $_GET['menu']=='skaidres'){
					    	include 'adminMenuSlides.php';
						}
	//-------------KURSU APRASYMAI PUSLAPIS				    
					    if(isset($_GET['menu']) && $_GET['menu']=='kursai'){
					    	include 'adminMenuNavSubmenuText.php';
					    }
	//-------------Informacijos APRASYMU PUSLAPIS				    
					    if(isset($_GET['menu']) && $_GET['menu']=='aprasymai'){
					    	include 'adminMenuTextContent.php';
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
