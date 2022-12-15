<?php
	require_once '../connect_sqli.php';
	if(ISSET($_POST['editdepsub'])){
		$depsub_mac_id = $_POST['depsub_mac_id'];
		$depsub_mac_name = $_POST['depsub_mac_name'];
		$dep_mac_id = $_POST['dep_mac_id'];
		
			mysqli_query($con, "UPDATE `depsub_machine` set `depsub_mac_name` = '$depsub_mac_name', `dep_mac_id` = '$dep_mac_id' WHERE `depsub_mac_id` = '$depsub_mac_id'") or die(mysqli_error());
			echo "<script>alert('แก้ไขแผนกเครื่องจักร สำเร็จ !')</script>";
			header("location: manage_dep_machine.php");
			}		
		else {
			echo "<script>alert('แก้ไขแผนกเครื่องจักร ไม่สำเร็จ !')</script>";
            header("location: manage_dep_machine.php");
		}
?>