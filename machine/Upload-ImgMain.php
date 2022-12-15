<?php
	require_once 'conn.php';
	if(ISSET($_POST['edit'])){
		$m_mac_id = $_POST['m_mac_id'];
		$image_name = $_FILES['photo']['name'];
		$image_temp = $_FILES['photo']['tmp_name'];
        
		$exp = explode(".", $image_name);
		$end = end($exp);
		$name = time().".".$end;
		if(!is_dir("./upload"))
			mkdir("upload");
		$path = "upload/".$name;
		$allowed_ext = array("gif", "jpg", "jpeg", "png");
		if(in_array($end, $allowed_ext)){
				if(move_uploaded_file($image_temp, $path)){
					mysqli_query($conn, "UPDATE `main_machine` set `m_mac_pic` = '$path' WHERE `m_mac_id` = '$m_mac_id'") or die(mysqli_error());
					echo "<script>alert('User account updated!')</script>";
					header("location: index-machine.php");
			}		
		}else{
			echo "<script>alert('Image only')</script>";
		}
	}
?>
