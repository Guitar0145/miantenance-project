

<?php
    define ('DB_SERVER','localhost');
    define ('DB_USER' , 'root');
    define ('DB_PASS' , 'rootroot');
    define ('DB_NAME' , 'mtservice');

    class DB_con {
        function __construct(){
            $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            $this ->dbcon = $conn;

           if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL:". mysqli_connect_error();
           } 
        }

		public function fetchImg ($m_id) {
            $result = mysqli_query($this->dbcon, "SELECT * 
            FROM maintenance
            WHERE m_id = '$m_id'");
            return $result;

        }

		public function addmaint ($m_user, $m_depart_id, $m_c_id, $m_st_id, $m_urgency, $m_issue, $check_status, $m_img){
            $add_maint = mysqli_query($this->dbcon, "INSERT INTO maintenance (m_user, m_depart_id, m_c_id, m_st_id, m_urgency, m_issue, check_status, m_img) VALUES('$m_user', '$m_depart_id', '$m_c_id', '$m_st_id', '$m_urgency', '$m_issue', '$check_status', '$m_img')");
            return $add_maint; 
        }

        public function UploadImg($file, $m_id)
		{	
			$allow = array('jpg', 'jpeg', 'png');
		   	$exntension = explode('.', $file['name']);
		   	$fileActExt = strtolower(end($exntension));
		   	$fileNew = rand() . "." . $fileActExt;  // rand function create the rand number 
		   	$filePath = 'uploads/'.$fileNew; 
			
			if (in_array($fileActExt, $allow)) {
    		          if ($file['size'] > 0 && $file['error']) {
		            if (move_uploaded_file($file['tmp_name'], $filePath)) {
		   		$query = "UPDATE maintenance SET m_img = '$fileNew' WHERE m_id = '$m_id' ";

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
