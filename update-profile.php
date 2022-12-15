<?php
	require_once 'connect_sqli.php';
	if(ISSET($_POST['edit'])){
		$u_id = $_POST['u_id'];
		$u_name = $_POST['u_name'];
		$u_depart = $_POST['u_depart'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		
			mysqli_query($con, "UPDATE `user` set `u_name` = '$u_name', `u_depart` = '$u_depart', `username` = '$username', `password` = '$password' WHERE `u_id` = '$u_id'") or die(mysqli_error());
			echo "<script>alert('User account updated!')</script>";
			header("location: index.php");
			}		
		else {
			echo "<script>alert('Image only')</script>";
		}
?>