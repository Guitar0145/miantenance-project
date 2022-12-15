<?php
	require_once 'connect_sqli.php';
	if(ISSET($_POST['editDepart'])){
		$depart_id = $_POST['depart_id'];
		$depart_sub_name = $_POST['depart_sub_name'];
		$depart_name = $_POST['depart_name'];
		
			mysqli_query($con, "UPDATE `depart` set `depart_sub_name` = '$depart_sub_name', `depart_name` = '$depart_name' WHERE `depart_id` = '$depart_id'") or die(mysqli_error());
			echo "<script>alert('แก้ไขสำเร็จ !')</script>";
			header("location: manage_departlist.php");
			}		
		else {
			echo "<script>alert('แก้ไขไม่สำเร็จ !!')</script>";
		}
?>