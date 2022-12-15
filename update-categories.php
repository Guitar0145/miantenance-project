<?php
	require_once 'connect_sqli.php';
	if(ISSET($_POST['editCate'])){
		$c_id = $_POST['c_id'];
		$c_name = $_POST['c_name'];
		
			mysqli_query($con, "UPDATE `categories` set `c_name` = '$c_name' WHERE `c_id` = '$c_id'") or die(mysqli_error());
			echo "<script>alert('แก้ไขสำเร็จ !')</script>";
			header("location: manage_typetaker.php");
			}		
		else {
			echo "<script>alert('แก้ไขไม่สำเร็จ !!')</script>";
            header("location: manage_typetaker.php");
		}
?>