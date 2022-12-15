<?php
	require_once 'connect_sqli.php';
	if(ISSET($_POST['edittime'])){
		$task_id = $_POST['task_id'];
		$date_task = $_POST['date_task'];
		
			mysqli_query($con, "UPDATE `tasker` set `date_task` = '$date_task' WHERE `task_id` = '$task_id'") or die(mysqli_error());
			echo "<script>alert('แก้ไขเวลา สำเร็จ !')</script>";
			header("location: switch-page.php");
			}		
		else {
			echo "<script>alert('แก้ไขเวลาไม่สำเร็จ !')</script>";
            header("location: switch-page.php");
		}
?>