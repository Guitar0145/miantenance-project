<?php
	require_once '../connect_sqli.php';
	if(ISSET($_POST['editMac'])){
		$mac_id = $_POST['mac_id'];
		$mac_name = $_POST['mac_name'];
		$mac_serial = $_POST['mac_serial'];
		$depsub_mac_id = $_POST['depsub_mac_id'];
		$mac_status = $_POST['mac_status'];
		
			mysqli_query($con, "UPDATE `machine` set 
            `mac_id` = '$mac_id', 
            `mac_name` = '$mac_name', 
            `mac_serial` = '$mac_serial', 
            `depsub_mac_id` = '$depsub_mac_id', 
            `mac_status` = '$mac_status'
            
            WHERE `mac_id` = '$mac_id'") or die(mysqli_error());
			echo "<script>alert('แก้ไขเครื่องจักร สำเร็จ !')</script>";
			header("location: manage_machine.php");
			}		
		else {
			echo "<script>alert('แก้ไขเครื่องจักร ไม่สำเร็จ !')</script>";
            header("location: manage_machine.php");
		}
?>