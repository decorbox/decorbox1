<?php 
ob_start();
if(isset($_GET['lang']) && $_GET['lang']=='LT'){
        include 'content_LT.php';
    }else if(isset($_GET['lang']) && $_GET['lang']=='EN'){
        include 'content_EN.php';
    }else{
        include 'content_LT.php';
    }
?>

<div class="row margin-top">

  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="<?php echo "index.php?lang=".$_GET['lang'].""; ?>"><?php echo $txtnav_home; ?></a>
      </div>
      <div>
        <ul class="nav navbar-nav">
          

          <li class="dropdown "> <!-- onclick="location.href='index.php?lang=<?php echo $_GET['lang'] ?>&nav=Kurybines-dirbtuves';" -->
          <a href="#"  class="dropdown-toggle"  data-toggle="dropdown">
          <?php echo $txtnav_creative; ?> <b class="caret"></b></a>
          <ul class="dropdown-menu ">
            <li><a href="index.php?lang=<?php echo $_GET['lang'] ?>&submenu=Rankdarbiu-burelis"><?php echo $txtnav_submenu_handicraft; ?> </a></li>
            <li><a href="index.php?lang=<?php echo $_GET['lang'] ?>&submenu=Kurybines-popietes"><?php echo $txtnav_submenu_creative; ?></a></li>
            
          </ul>
        </li>
          
          <li><a href="index.php?lang=<?php echo $_GET['lang'] ?>&nav=Ranku-darbo-gaminiai"><?php echo $txtnav_handmade; ?></a></li>
          <li><a href="index.php?lang=<?php echo $_GET['lang'] ?>&nav=Kontaktai"><?php echo $txtnav_about; ?></a></li>
          <li class="navbar-text"><?php echo $txtnav_questions; ?> +370 62700354</li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
          
          
          <li>
              <form method="POST" action="<?php echo "search.php?lang=".$_GET['lang']."";  ?>" class="navbar-form ">
                 <div class="input-group">
                     <input name="search" type="Search" required placeholder="<?php echo $txtnav_search; ?>" class="form-control" />
                     <div class="input-group-btn">
                         <button type="submit" class="btn btn-success">
                            <span class="glyphicon glyphicon-search"></span>
                         </button>
                     </div>
                 </div>
              </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</div>


<?php 
if (isset($_POST['search'])){
    header("Location: search.php?lang=".$_GET['lang']."&search=".$_POST['search']."");
}

?>