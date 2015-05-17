<?php

ob_start();
include 'connect.php';
include 'library.php';
if(isset($_GET['lang']) && $_GET['lang']=='LT'){
        include 'content_LT.php';
    }else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
        include 'content_EN.php';
    }else{
        include 'content_LT.php';
    }

$display_block="";
if(isset($_GET['search'])){
    $check_search = mysqli_real_escape_string($mysqli, $_GET['search']);
    $search_items =  "SELECT * FROM store_items WHERE (item_title LIKE '%".$check_search."%') OR (item_title_EN LIKE '%".$check_search."%') ";
    $search_items_res = mysqli_query($mysqli, $search_items) or die(mysqli_error($mysqli));

    if(mysqli_num_rows($search_items_res)>=1){

    
        $display_block.="<div class='row text-center'><h1>$txtitems_found</h1></div>";
        while($item = mysqli_fetch_array($search_items_res)){
            $id=$item['id'];
            
            if(isset($_GET['lang']) && $_GET['lang']=='LT'){
                $title = $item['item_title'];
            }else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
                $title = $item['item_title_EN'];
            }else{
                $title = $item['item_title'];
            }

            $price = $item['item_price'];            
            $image = $item['item_image'];

            $display_block .= 

                "
                <div class='col-lg-3-edit col-md-3-edit col-sm-3-edit col-xs-3-edit '>
                    <div class='text-center panel panel-success panel-edit'>
                        <a href='showitem.php?lang=".$_GET['lang']."&item_id=".$id."'>
                            <div class='panel-heading'>
                                <h3 class='panel-title'>$title</h3>
                            </div>
                        </a>
                        
                        <div class='panel-body panel-body-edit2'>
                            <div class='row'>
                                <div id='posts' class='col-md-3-edit col-sm-3-edit col-xs-3-edit '> 
                                    
                                    <img class='margin-top20 imgSize img-responsive ' src='$image'/>
                                    
                                </div>
                                <form method='post' style='weigth:500px' action='addtocart.php'>
                                    <div class=' col-md-6-edit col-sm-6-edit col-xs-6-edit '>
                                        <div class='row '>
                                            <div class=' col-lg-6-edit col-md-12-edit col-sm-6-edit col-xs-6-edit margin-left40 '>
                                                
                                                    <label class=' margin-top20 margin-lef' for='sel_item_qty'>$txtqty:</label><br>
                                                    <input type='number' min='1' value='1' class='fullWidthSelect ' name='sel_item_qty' id='sel_item_qty'>
                                
                                                    <div class='row'>
                                                        <div class='col-lg-12-edit col-md-12-edit col-sm-12-edit col-xs-12-edit'>
                                                            <p class='labelSize '>".$price." &euro;</p>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-lg-12-edit col-md-12-edit col-sm-12-edit col-xs-12-edit'>
                                        <input type='hidden' name='sel_item_id' value='" . $id ."' />
                                        <button class='btn btn-success margin-top20 margin-bottom15 fullWidthButton'  type='submit' name='submit' value='submit'>$txtadd_to_basket</button>
                                               
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            ";    
        }     
    }else{
        $display_block.= "<div class='row text-center'><h1>$txtno_items_found</h1></div>";
    }     
          
}
?>
<!DOCTYPE html>
<html>
<body>
<div class="container">
    <?php 
    include 'header.php';
    include 'navbar.php' ;?>
    <div class="row">
        
        <div class="col-lg-9 col-md-9 ">
            <?php  
                echo $display_block;
            ?>
        </div>

        <div class="col-md-3 right-bar-edit border-color">
            <?php include_once 'login.php';  
                include_once 'showPriceWidget.php';
                include_once 'contactsWidget.php';
                include_once 'deliveryWidget.php';
                include_once 'facebookWidget.php';
            ?>
        </div>

    </div>
</div>

<div class="container">
    <div class="row">
      <?php include 'footer.php'; ?>
    </div>
</div>

</body>
</html>