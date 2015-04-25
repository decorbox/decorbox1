
<?php include 'library.php' ?>
<script>tinymce.init({selector:'textarea'});</script>
<?php 
    echo "
    <form method='POST'>
        <textarea name='text1'>Easy! You should check out MoxieManager!</textarea>
        <textarea name='text2'>Easy! You should check out MoxieManager!</textarea>
    <button name='submit' type='submit'> submit </button>
    </form>";
if(isset($_POST['submit'])){
    echo $_POST['text1'];
    echo "<br>".$_POST['text2'];
}