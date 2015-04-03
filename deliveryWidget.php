
<?php

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
	<div class='panel panel-success' >
		<div class='panel-heading text-center'>
			<h3 class='panel-title'><span class='glyphicon glyphicon-globe' aria-hidden='true'></span> $txtimportant</h3>
		</div>
		
		<div class='panel-body'>
			
			<ul id='listWidgetmargin'>
		    	<label style='width:100%' data-toggle='modal' data-target='#aboutUs'>
		    		<li>
		    			$txtabout_us
		    		</li>
		    	</label>

		    	<label style='width:100%'>
		    		<li data-toggle='modal' data-target='#payment' >
		    			$txtpayment_methods	
		    		</li>
		    	</label>

		    	<label style='width:100%'>
		    		<li data-toggle='modal' data-target='#delivery' >
		    			$txtitems_delivery	
		    		</li>
		    	</label>
		    	
		    	<label style='width:100%'>
		    		<li data-toggle='modal' data-target='#returning'>
		    			$txtitems_returns	
		    		</li>
		    	</label>

		    	
		    	
		    </ul>

		   
			
		</div>
	</div>
</div>	
		";



$display_block.="<!-- About us Modal -->
<div class='modal fade' id='aboutUs' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>$txtabout_us</h4>
			</div>
			
			<div class='modal-body'>
				<div class='form-group'>
					<div class='row margin-top'>
						<div class='row'>
							<div class='col-md-10 col-md-offset-1 '>
							<p> $txtmodal_about_us</p>
							</div>
						</div>	

					</div>
				</div>
			</div>	
			<div class='modal-footer'>
				<button type='button' class='btn btn-primary' data-dismiss='modal'>$txtclose</button>
			</div>
		  	
		</div>
	</div>
</div>";	

$display_block.="<!-- Payment methods Modal -->
<div class='modal fade' id='payment' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>$txtpayment_methods</h4>
			</div>
			
			<div class='modal-body'>
				<div class='form-group'>
					<div class='row margin-top'>
						<div class='row'>
							<div class='col-md-10 col-md-offset-1 '>
							<p> $txtpayment_methods_info</p>
							</div>
						</div>	

					</div>
				</div>
			</div>	
			<div class='modal-footer'>
				<button type='button' class='btn btn-primary' data-dismiss='modal'>$txtclose</button>
			</div>
		  	
		</div>
	</div>
</div>";	



$display_block.="<!-- Delivery Modal -->
<div class='modal fade' id='delivery' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>$txtitems_delivery</h4>
			</div>
			
			<div class='modal-body'>
				<div class='form-group'>
					<div class='row margin-top'>
						<div class='col-md-10 col-md-offset-1 '>
							<p>$txtmodal_delivery</p>
						</div>	
					</div>
				</div>
			</div>	
			<div class='modal-footer'>
				<button type='button' class='btn btn-primary' data-dismiss='modal'>$txtclose</button>
			</div>
		  	
		</div>
	</div>
</div>";





$display_block.="<!-- Returning Modal -->
<div class='modal fade' id='returning' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title text-center' id='myModalLabel'>$txtitems_returns</h4>
			</div>
			
			<div class='modal-body'>
				<div class='form-group'>
					<div class='row margin-top'>
						<div class='col-md-10 col-md-offset-1 '>
							<p>$txtmodal_returning</p>
						</div>	
					</div>
				</div>
			</div>	
			<div class='modal-footer'>
				<button type='button' class='btn btn-primary' data-dismiss='modal'>$txtclose</button>
			</div>
		  	
		</div>
	</div>
</div>";	


echo $display_block;




			
		
