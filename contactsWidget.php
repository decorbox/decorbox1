
<?php
//neisversta
//include 'connect.php';
//include 'library.php';

if(isset($_GET['lang']) && $_GET['lang']=='LT'){
        include 'content_LT.php';
    }else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
        include 'content_EN.php';
    }else{
        include 'content_LT.php';
    }

$display_block="";
$display_block.="
<div class='row'>
	<div class=' text-center panel panel-success' >
		<div class='panel-heading'>
			<h3 class='panel-title'><span class='glyphicon glyphicon-earphone' aria-hidden='true'></span> $txtcontacts</h3>
		</div>
		
		<div class='panel-body'>
			<label> +370 627 00354</label>
			<label> decorbox.lt@gmail.com</label></label>
		</div>
	</div>
</div>	
		";
echo $display_block;




			
		
