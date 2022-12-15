<?php
	$conn = mysqli_connect("localhost", "root", "rootroot", "mtservice");
 
	if(!$conn){
		die("Error: Failed to connect to database!");
	}
?>