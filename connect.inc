<?php
	$conn= mysqli_connect("localhost","root","rootroot","mtservice") or die("Error: " . mysqli_error($con));
	mysqli_query($conn, "SET NAMES 'utf8' "); 
	date_default_timezone_set('Asia/Bangkok'); 
?>