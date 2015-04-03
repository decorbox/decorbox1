<?php

$mysqli = mysqli_connect("localhost", "decorbox_decorbox", "DurkinasMetrus", "decorbox_decorbox") or die ("Unable to connect");


mysqli_query($mysqli, "SET character_set_results = 'utf8',
 character_set_client = 'utf8', character_set_connection = 'utf8', 
 character_set_database = 'utf8',
 character_set_server = 'utf8'" );

?>

