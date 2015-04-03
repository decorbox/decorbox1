<?php
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
$display_block.="<a href='index.php?lang=".$_GET['lang']."'><h3><-- $txtback_to_mainpage</h3></a>";

    $get_username = "SELECT username FROM users WHERE temp_pass_reset_token = '".$_GET['token']."'";
    $get_username_res = mysqli_query($mysqli, $get_username) or die(mysqli_error($mysqli));
    $get_username_assoc = mysqli_fetch_assoc($get_username_res);
    $user_num_rows = mysqli_num_rows($get_username_res);
    $username = $get_username_assoc['username'];

if(isset($_POST['submitReset'])){
    if($_POST['pass1'] == $_POST['pass2']){
        $pass= md5($_POST['pass1']);
        $reset_pass = "UPDATE users SET password = '".$pass."', temp_pass_reset_token = NULL 
            WHERE temp_pass_reset_token = '".$_GET['token']."'";
        $reset_pass_res = mysqli_query($mysqli, $reset_pass) or die(mysqli_error($mysqli));    
        echo "<div class='alert alert-success alert-dismissible' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <p>$txtpassword_changed</p>
        </div>";   

            //padaryt kad siusti i el pasta
    }else{
        echo "<div class='alert alert-danger alert-dismissible' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <p>$txterror_incorect_pass</p>
        </div>";
    }
}  

$display_block.= "
<div class='row'>
    <div class='col-md-4 col-md-offset-4' ><h1 class='text-center'>$txtrecover_pass</h1>";

if($user_num_rows !=0){  
 $display_block.="   
    <form method='POST'>
        <div class='form-group'>
            <div class='row margin-top text-center'>
                <h3>$txtusername: $username</h3> 
            </div>  

            <div class='row margin-top'>
                <label>$txtpassword</label>
                    <input type='password' required name='pass1' class='form-control' placeholder='$txtpassword'>
                    
            </div>
            <div class='row margin-top'>
                <label>$txtrepeat_pass</label>
                    <input type='password' required name='pass2' class='form-control' placeholder='$txtrepeat_pass'>
                    
            </div>

            <div class='row margin-top'>
                <div>
                    <button type='submit' value'resetPasword' name='submitReset' class='btn btn-success'>$txtrecover_pass</button>    
                </div>
                </div>
            </div>
        </form>";
}else{
    $display_block.="<label>$txtno_user</label>";
}
    

$display_block.="                        
    </div>
</div>";
echo $display_block;

?>