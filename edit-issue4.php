<?php
	require_once 'connect_sqli.php';
	if(ISSET($_POST['editIssue4'])){
		$m_id = $_POST['m_id'];
		$m_issue = $_POST['m_issue'];
		$m_c_id = $_POST['m_c_id'];
		$m_rate = $_POST['m_rate'];
		$times_limit = $_POST['times_limit'];
		
			mysqli_query($con, "UPDATE `maintenance` set `m_issue` = '$m_issue', `m_c_id` = '$m_c_id', `m_rate` = '$m_rate', `times_limit` = '$times_limit' WHERE `m_id` = '$m_id'") or die(mysqli_error());
			echo "<script>alert('แก้ไขอาการ สำเร็จ !')</script>";
			header("location: index.php");
			}		
		else {
			echo "<script>alert('แก้ไข อาการไม่สำเร็จ !')</script>";
            header("location: index.php");
		}
?>