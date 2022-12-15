<?php
	require_once '../connect_sqli.php';
	if(ISSET($_POST['editdep'])){
		$dep_mac_id = $_POST['dep_mac_id'];
		$dep_mac_name = $_POST['dep_mac_name'];
		
			mysqli_query($con, "UPDATE `dep_machine` set `dep_mac_name` = '$dep_mac_name' WHERE `dep_mac_id` = '$dep_mac_id'") or die(mysqli_error());
			echo "<script>alert('แก้ไขแผนกเครื่องจักร สำเร็จ !')</script>";
			header("location: manage_dep_machine.php");
			}		
		else {
			echo "<script>alert('แก้ไขแผนกเครื่องจักร ไม่สำเร็จ !')</script>";
            header("location: manage_dep_machine.php");
		}
?>