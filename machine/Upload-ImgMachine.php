<?php
	require_once 'conn.php';
	if(ISSET($_POST['edit'])){
		$mac_id = $_POST['mac_id'];
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
					mysqli_query($conn, "UPDATE `machine` set `mac_pic` = '$path' WHERE `mac_id` = '$mac_id'") or die(mysqli_error());
					echo "<script>alert('User account updated!')</script>";
					header("location: manage_machine.php");
			}		
		}else{
			echo "<script>alert('Image only')</script>";
		}
	}
?>
