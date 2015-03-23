<?php
include 'connect.php';
include 'library.php';

// select sorting items
   

            $display_block = 
            "<div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 margin-top20'>
                <div class='text-center panel panel-success'>
                    <a href='showitem.php?item_id'>
                        <div class='panel-heading'>
                            <h3 class='panel-title'>item_title</h3>
                        </div>
                    </a>
                    
                    <div class='panel-body'>
                    <div class='row'>
                        <div id='posts' class='col-lg-6 col-md-6 col-sm-6 col-xs-6 '>    
                            <img class='margin-top20 imgLeft imgSize img-responsive '>
                        </div>
                        <div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>
                            <div class='row '>
                                <div class=' col-lg-12 col-md-12 col-sm-6 col-xs-6 '>
                                    <form method='post' style='weigth:500px' action='addtocart.php'>
                                        <label class=' margin-top20' for='sel_item_qty'>Kiekis:</label>
                                        <input type='number' min='1' value='1' class='fullWidthSelect' >
                    
                                        <div class='row'>
                                            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                                                <label class='labelSize margin-left20'>&euro;44</label>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                                        
                                        <button class='btn btn-success margin-top20 margin-bottom15 fullWidthButton'  type='submit' name='submit' value='submit'>Įdėti į krepšelį</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>";
    
            //}//end mysql fetch array

        
        //}//end of else
        echo $display_block;
?>