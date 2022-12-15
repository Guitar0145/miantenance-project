<?php
	class Maintenance
	{
		private $servername = "localhost";
		private $username   = "root";
		private $password   = "rootroot";
		private $dbname     = "mtservice";
		public  $con;


		// Database Connection 
		public function __construct()
		{
		    try {
			$this->con = new mysqli($this->servername, $this->username, $this->password, $this->dbname);	
		    } catch (Exception $e) {
			echo $e->getMessage();
		    }
		}

		// Insert customer data into customer table
		public function insertData($m_user, $m_depart_id, $m_c_id, $m_st_id, $m_urgency, $m_issue, $check_status, $file)
		{	
			$allow = array('jpg', 'jpeg', 'png');
		   	$exntension = explode('.', $file['name']);
		   	$fileActExt = strtolower(end($exntension));
		   	$fileNew = rand() . "." . $fileActExt;  // rand function create the rand number 
		   	$filePath = 'uploads/'.$fileNew; 
			
			if (in_array($fileActExt, $allow)) {
    		          if ($file['size'] > 0 && $file['error'] == 0) {
		            if (move_uploaded_file($file['tmp_name'], $filePath)) {
		   		$query = "INSERT INTO maintenance (m_user, m_depart_id, m_c_id, m_st_id, m_urgency, m_issue, check_status, m_img)
					VALUES('$m_user','$m_depart_id','$m_c_id','$m_st_id','$m_urgency','$m_issue','$check_status','$fileNew')";
				$sql = $this->con->query($query);
				if ($sql==true) {
				   return true;
				}else{
				  return false;
			    }   		    
		        }
		      }
		   }
		}

	}
?>