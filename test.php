<?php 
include 'library.php';

if(isset($_POST['submit'])){
	echo $_POST['info'];
	print_r($_POST);
}
//<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
/*
<script type="text/javascript">
     	 //bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
     	bkLib.onDomLoaded(function() {
        new nicEditor({buttonList : ['fontSize','bold','italic','underline','strikeThrough','left','center','right','justify','ul','ol','forecolor','html',]}).panelInstance('editor');
  		});
     </script>*/
?>


<form method="POST">

	  <script>
function myFunction() {
    document.getElementById("demo").innerHTML = "<h1>tekstas</h1>";
}
</script>
<button onclick="myFunction()">Click me</button>



<textarea>A function is triggered when the button is clicked. The function outputs some text in a p element with id="demo".<p id="demo"></p></textarea>


	<button type='submit' name="submit">sunbmit</button>
</form>
    </body>
</html>