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


        public function usernameavailable($username){
            $checkuser = mysqli_query($this->dbcon, "SELECT username FROM user WHERE username = '$username'");
            return $checkuser;
        }

        public function registration ($fname, $u_depart, $username, $password, $level){
            $reg = mysqli_query($this->dbcon, "INSERT INTO user(u_name, u_depart, username, password, level) VALUES('$fname', '$u_depart', '$username', '$password', '$level')");
            return $reg; 
        }

        public function addmaint ($m_user, $m_depart_id, $m_c_id, $m_st_id, $m_urgency, $m_issue, $check_status, $photo){
            $add_maint = mysqli_query($this->dbcon, "INSERT INTO maintenance (m_user, m_depart_id, m_c_id, m_st_id, m_urgency, m_issue, check_status, photo) VALUES('$m_user', '$m_depart_id', '$m_c_id', '$m_st_id', '$m_urgency', '$m_issue', '$check_status', '$photo')");
            return $add_maint; 
        }

        public function adddepart ($dep_sub, $dep_name){
            $add_dp = mysqli_query($this->dbcon, "INSERT INTO depart (depart_sub_name, depart_name) VALUES('$dep_sub', '$dep_name')");
            return $add_dp; 
        }

        public function addCate ($c_name){
            $add_ct = mysqli_query($this->dbcon, "INSERT INTO categories (c_name) VALUES('$c_name')");
            return $add_ct; 
        }

        public function addSubtask ($st_name){
            $add_st = mysqli_query($this->dbcon, "INSERT INTO subtasks (st_name) VALUES('$st_name')");
            return $add_st; 
        }

        public function addTech ($tc_name, $tc_nickname, $tc_depart, $tc_status){
            $add_tech = mysqli_query($this->dbcon, "INSERT INTO technician (tc_name, tc_nickname, tc_depart, tc_status) VALUES('$tc_name', '$tc_nickname', '$tc_depart', '$tc_status')");
            return $add_tech; 
        }

        public function fetchonerecord ($m_id) {
            $result = mysqli_query($this->dbcon, "SELECT * 
            FROM maintenance
            INNER JOIN depart ON maintenance.m_depart_id = depart.depart_id 
            INNER JOIN categories ON maintenance.m_c_id = categories.c_id
            RIGHT JOIN subtasks ON maintenance.m_st_id = subtasks.st_id 
            WHERE m_id = '$m_id'");
            return $result;

        }

        public function updatestatus ($m_issue, $check_status, $m_admin, $m_status, $m_c_id, $times_limit, $m_rate, $ap_datetime, $m_id) { 
            $result = mysqli_query($this->dbcon, "UPDATE maintenance SET 
                m_issue = '$m_issue',
                check_status = '$check_status',
                m_admin = '$m_admin',
                m_status = '$m_status',
                m_c_id = '$m_c_id',
                times_limit = '$times_limit',
                m_rate = '$m_rate',
                ap_datetime = '$ap_datetime'
                WHERE m_id = '$m_id'
            "); 
            return $result;
        }

         // รายละเอียดคิวงาน
        public function fetchTaskmaint($m_id) {
            $result = mysqli_query($this->dbcon, "SELECT * 
            FROM maintenance
            INNER JOIN depart ON maintenance.m_depart_id = depart.depart_id 
            INNER JOIN categories ON maintenance.m_c_id = categories.c_id
            RIGHT JOIN subtasks ON maintenance.m_st_id = subtasks.st_id
            WHERE m_id = '$m_id'");
            return $result;
    
        }

        public function fetchTaskmaint2($m_id) {
            $result = mysqli_query($this->dbcon, "SELECT * 
            FROM maintenance
            INNER JOIN depart ON maintenance.m_depart_id = depart.depart_id 
            INNER JOIN categories ON maintenance.m_c_id = categories.c_id
            RIGHT JOIN subtasks ON maintenance.m_st_id = subtasks.st_id
            WHERE m_id = '$m_id'");
            return $result;
    
        }

        public function Endjob($m_id) {
            $result = mysqli_query($this->dbcon, "SELECT * 
            FROM maintenance
            INNER JOIN depart ON maintenance.m_depart_id = depart.depart_id 
            INNER JOIN categories ON maintenance.m_c_id = categories.c_id
            RIGHT JOIN subtasks ON maintenance.m_st_id = subtasks.st_id
            WHERE m_id = '$m_id'");
            return $result;
    
        }
        
        public function fetchOnetask($m_id) {
            $result = mysqli_query($this->dbcon, "SELECT * 
            FROM tasker
            INNER JOIN technician ON tasker.tc_id = technician.tc_id
            WHERE m_id = '$m_id'");
            return $result;
    
        } 

        //อัพเดท / ปิดงาน
        public function updateEnd ($m_status, $suc_issue, $suc_date, $suc_time, $m_id) { 
            $result = mysqli_query($this->dbcon, "UPDATE maintenance SET 
                m_status = '$m_status',
                suc_issue = '$suc_issue',
                suc_date = '$suc_date',
                suc_time = '$suc_time'
                WHERE m_id = '$m_id'
            "); 
            return $result;
        }

        public function fetchstatusend ($m_id) {
            $result = mysqli_query($this->dbcon, "SELECT * 
            FROM maintenance
            INNER JOIN depart ON maintenance.m_depart_id = depart.depart_id 
            INNER JOIN categories ON maintenance.m_c_id = categories.c_id
            RIGHT JOIN subtasks ON maintenance.m_st_id = subtasks.st_id 
            WHERE m_id = '$m_id'");
            return $result;

        }

        public function updateUsercheck ($user_check, $date_check, $user_comment, $name_check, $m_status, $m_id) { 
            $result = mysqli_query($this->dbcon, "UPDATE maintenance SET 
                user_check = '$user_check',
                date_check = '$date_check',
                user_comment = '$user_comment',
                name_check = '$name_check',
                m_status = '$m_status'
                WHERE m_id = '$m_id'
            "); 
            return $result;
        }

        public function insertData($m_user, $m_depart_id, $m_c_id, $m_st_id, $m_urgency, $m_issue, $check_status, $file)
		{	
			$allow = array('jpg', 'jpeg', 'png');
		   	$exntension = explode('.', $file['name']);
		   	$fileActExt = strtolower(end($exntension));
		   	$fileNew = rand() . "." . $fileActExt;  // rand function create the rand number 
		   	$filePath = 'uploads/'.$fileNew; 
			
			if (in_array($fileActExt, $allow)) {
    		          if ($file['size'] > 0 && $file['error']) {
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

        public function AddOrders ($m_id, $pr_code, $pr_product, $pr_detail, $pr_status, $pr_start, $pr_userstart){
            $add_od = mysqli_query($this->dbcon, "INSERT INTO purchase (m_id, pr_code, pr_product, pr_detail, pr_status, pr_start, pr_userstart) 
            VALUES('$m_id', '$pr_code', '$pr_product', '$pr_detail', '$pr_status', '$pr_start', '$pr_userstart')");
            return $add_od; 
        }

        public function updateStatusPur($pr_status, $pr_id, $pr_end, $pr_userend) { 
            $result = mysqli_query($this->dbcon, "UPDATE purchase SET 
                pr_status = '$pr_status',
                pr_end = '$pr_end',
                pr_userend = '$pr_userend'

                WHERE pr_id = '$pr_id'
            "); 
            return $result;
        }

        public function AddWorking ($m_id, $date_start, $user_start, $status_work){
            $add_work = mysqli_query($this->dbcon, "INSERT INTO working (m_id, date_start, user_start, status_work) 
            VALUES('$m_id', '$date_start', '$user_start', '$status_work')");
            return $add_work; 
        }

        public function updateWorkEnd($work_id, $status_work, $date_end, $user_end) { 
            $result = mysqli_query($this->dbcon, "UPDATE working SET 
                status_work = '$status_work',
                date_end = '$date_end',
                user_end = '$user_end'

                WHERE work_id = '$work_id'
            "); 
            return $result;
        }


        public function updateEnd2 ($m_status, $suc_issue, $suc_date, $suc_time, $task_status, $m_id) { 
            $result = mysqli_query($this->dbcon, "UPDATE maintenance SET 
                m_status = '$m_status',
                suc_issue = '$suc_issue',
                suc_date = '$suc_date',
                suc_time = '$suc_time'
                WHERE m_id = '$m_id'
            "); 
            $result = mysqli_query($this->dbcon, "UPDATE tasker SET 
            task_status = '$task_status'
            WHERE m_id = '$m_id'
        "); 
            return $result;
        }
        
    }

    

?>
