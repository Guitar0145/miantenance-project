<?php
	require_once 'connect_sqli.php';
	if(ISSET($_POST['editTech'])){
		$tc_id = $_POST['tc_id'];
		$tc_name = $_POST['tc_name'];
		$tc_nickname = $_POST['tc_nickname'];
        $tc_depart = $_POST['tc_depart'];
		
			mysqli_query($con, "UPDATE `technician` set `tc_name` = '$tc_name', `tc_nickname` = '$tc_nickname', `tc_depart` = '$tc_depart' WHERE `tc_id` = '$tc_id'") or die(mysqli_error());
			echo "<script>alert('แก้ไขสำเร็จ !')</script>";
			header("location: manage_departlist.php");
			}		
		else {
			echo "<script>alert('แก้ไขไม่สำเร็จ !!')</script>";
		}
?>