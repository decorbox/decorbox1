<?php
include 'connect.php';
session_start();


if (isset($_POST['sel_item_id'])) {
    //create safe values for use
    $safe_sel_item_id = mysqli_real_escape_string($mysqli, $_POST['sel_item_id']);
    $safe_sel_item_qty = mysqli_real_escape_string($mysqli, $_POST['sel_item_qty']);
        
    $_SESSION['sel_item_id'] = $_POST['sel_item_id'];// turi perduoti id i showcart.php
    
    //validate item and get title and price
    $get_iteminfo_sql = "SELECT item_title FROM store_items WHERE id = '".$safe_sel_item_id."'";
    $get_iteminfo_res = mysqli_query($mysqli, $get_iteminfo_sql) or die(mysqli_error($mysqli));

    if (mysqli_num_rows($get_iteminfo_res) < 1) { 
        //free result
        mysqli_free_result($get_iteminfo_res);
        //close connection to MySQL
         mysqli_close($mysqli);
         //invalid id, send away
        header('Location: ' . $_SERVER['HTTP_REFERER']);// grizti atgal i praeita puslapi
        exit;
    } else {
            //get info
                while ($item_info = mysqli_fetch_array($get_iteminfo_res)) {
                    $item_title = stripslashes($item_info['item_title']);
                }
                //free result
                mysqli_free_result($get_iteminfo_res);   

                $get_session_sql = "SELECT * FROM store_shoppertrack WHERE session_id = '".$_COOKIE['PHPSESSID']."'";
                $get_session_query = mysqli_query($mysqli, $get_session_sql) or die(mysqli_error($mysqli));
                $session = mysqli_fetch_assoc($get_session_query);//tikrinu dabartine session IMA tik viena reiksme

            
                //add new session id IDENTIFICATION if not exist in sql
                if($session['session_id']!=$_COOKIE['PHPSESSID'] ){// jei nera session id, ideda visa info i sql
                    $insert_to_shoppertrack_sql = "INSERT INTO store_shoppertrack (session_id) VALUES (
                     '".$_COOKIE['PHPSESSID']."')";
                    $add_to_shoppertrack_res = mysqli_query($mysqli, $insert_to_shoppertrack_sql) or die(mysqli_error($mysqli));


                     //get order_id
                    $get_order_id_sql = "SELECT id FROM store_shoppertrack WHERE session_id = '".$_COOKIE['PHPSESSID']."'";
                    $run_order_id_res = mysqli_query($mysqli, $get_order_id_sql) or die(mysqli_error($mysqli));
                    while($info = mysqli_fetch_array( $run_order_id_res))    
                    { 
                        $order_id = $info['id'];
                    } 
                        //add info to cart table
                        $addtocart_sql = "INSERT INTO store_shoppertrack_items
                            (order_id, sel_item_id, sel_item_qty, date_added) VALUES ('".$order_id."',
                            '".$safe_sel_item_id."',
                            '".$safe_sel_item_qty."',
                            now())";
                        $addtocart_res = mysqli_query($mysqli, $addtocart_sql) or die(mysqli_error($mysqli));

                }//end of if



            //}//jeigu yra toks session id 
                else if($session['session_id']==$_COOKIE['PHPSESSID'] ){//jeigu yra toksai session id
                    //get order_id
                    $get_order_id_sql = "SELECT id FROM store_shoppertrack WHERE session_id = '".$_COOKIE['PHPSESSID']."'";
                    $run_order_id_res = mysqli_query($mysqli, $get_order_id_sql) or die(mysqli_error($mysqli));
                    while($info = mysqli_fetch_array( $run_order_id_res))    
                    { 
                        $order_id = $info['id'];
                    } 
                    
                    //add or update info to cart table
                    $get_product_sql = "SELECT * FROM store_shoppertrack_items WHERE order_id = '" . $order_id . "' ";
                    $product_query = mysqli_query($mysqli, $get_product_sql);
                    //$product = mysqli_fetch_assoc($product_query);

                    $check = false;//check if updated info
                    while($product = mysqli_fetch_array( $product_query))      
                    { 
                        if ($product['sel_item_id']== $safe_sel_item_id) {
                           // update cart product
                            $update_cart_sql = "UPDATE store_shoppertrack_items
                            SET sel_item_qty = sel_item_qty + '" . (float)$safe_sel_item_qty . "', date_added = now()
                            WHERE sel_item_id = '" . (int)$safe_sel_item_id . "' AND order_id = '".$order_id."'";
                            $update_to_cart_res = mysqli_query($mysqli, $update_cart_sql) or die(mysqli_error($mysqli));
                           // echo "update";
                            $check = true;
                        }  

                    }//end of while
                    //if not updated, add new record
                    if($check == false)  {
                        //add info to cart table    
                        $add_item_sql = "INSERT INTO store_shoppertrack_items
                            (order_id, sel_item_id, sel_item_qty, date_added) VALUES ('".$order_id."',
                            '".$safe_sel_item_id."',
                            '".$safe_sel_item_qty."', now())";
                        $add_item_res = mysqli_query($mysqli, $add_item_sql) or die(mysqli_error($mysqli));
                        //echo " idejo nauja";
                    }
                     
                }//end else if session  
          
            //close connection to MySQL
          // mysqli_close($mysqli);
            //redirect to showcart page
            
  
           
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            //exit;
            }//end of main else
        
}//end main if

     else {
        //send them somewhere else
        header('Location: ' . $_SERVER['HTTP_REFERER']);//gryzta i praeita puslapi
        exit;
    }
?>