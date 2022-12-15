<?php
	require_once 'conn.php';
	if(ISSET($_POST['edit'])){
		$m_id = $_POST['m_id'];
		$image_name = $_FILES['photo']['name'];
		$image_temp = $_FILES['photo']['tmp_name'];
        
		$m_user = $_POST['m_user'];
		$m_issue = $_POST['m_issue'];
		$exp = explode(".", $image_name);
		$end = end($exp);
		$name = time().".".$end;
		if(!is_dir("./upload"))
			mkdir("upload");
		$path = "upload/".$name;
		$allowed_ext = array("gif", "jpg", "jpeg", "png");
		if(in_array($end, $allowed_ext)){
				if(move_uploaded_file($image_temp, $path)){
					mysqli_query($conn, "UPDATE `maintenance` set `m_user` = '$m_user', `m_issue` = '$m_issue', `photo` = '$path' WHERE `m_id` = '$m_id'") or die(mysqli_error());
					echo "<script>alert('User account updated!')</script>";
					header("location: index.php");
			}		
		}else{
			echo "<script>alert('Image only')</script>";
		}
	}
?>
