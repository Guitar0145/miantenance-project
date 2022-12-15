<?php
	require_once 'connect_sqli.php';
	if(ISSET($_POST['editIssue'])){
		$m_id = $_POST['m_id'];
		$m_issue = $_POST['m_issue'];
		
			mysqli_query($con, "UPDATE `maintenance` set `m_issue` = '$m_issue' WHERE `m_id` = '$m_id'") or die(mysqli_error());
			echo "<script>alert('แก้ไขอาการ สำเร็จ !')</script>";
			header("location: index.php");
			}		
		else {
			echo "<script>alert('แก้ไข อาการไม่สำเร็จ !')</script>";
            header("location: index.php");
		}
?>