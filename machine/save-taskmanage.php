<html>
<head>
<title>ระบบซ่อม</title>
</head>
<body>
<?php
	ini_set('display_errors', 1);
	error_reporting(~0);

	$serverName = "localhost";
	$userName = "root";
	$userPassword = "rootroot";
	$dbName = "mtservice";

	$conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);

	for ($i = 1; $i<= (int)$_POST["hdnCount"]; $i++){
		if(isset($_POST["task_mac_id$i"]))
		{
			if(		$_POST["m_mac_id$i"] != "" &&
					$_POST["tc_id$i"] != "" &&
					$_POST["task_mac_status$i"] != "")
			{
				$sql = "INSERT INTO tasker_mac (m_mac_id, tc_id, task_mac_status) 
					VALUES (
                        '".$_POST["m_mac_id$i"]."',
                        '".$_POST["tc_id$i"]."',
                        '".$_POST["task_mac_status$i"]."'
                        )";
				$query = mysqli_query($conn,$sql);
			}
		}
	}
    echo "<script>alert('แบ่งงานสำเร็จ !!');</script>";
	echo "<script>window.close();</script>";
	mysqli_close($conn);
?>
</body>
</html>