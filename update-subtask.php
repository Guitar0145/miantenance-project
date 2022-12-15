<?php
	require_once 'connect_sqli.php';
	if(ISSET($_POST['editST'])){
		$st_id = $_POST['st_id'];
		$st_name = $_POST['st_name'];
		
			mysqli_query($con, "UPDATE `subtasks` set `st_name` = '$st_name' WHERE `st_id` = '$st_id'") or die(mysqli_error());
			echo "<script>alert('แก้ไขสำเร็จ !')</script>";
			header("location: manage_typetaker.php");
			}		
		else {
			echo "<script>alert('แก้ไขไม่สำเร็จ !!')</script>";
            header("location: manage_typetaker.php");
		}
?>