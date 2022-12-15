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

        public function addMacDepart ($dep_mac_name){
            $add_MD = mysqli_query($this->dbcon, "INSERT INTO dep_machine (dep_mac_name) VALUES('$dep_mac_name')");
            return $add_MD; 
        }

        public function addMacDepartSub ($depsub_mac_name, $dep_mac_id){
            $add_MDS = mysqli_query($this->dbcon, "INSERT INTO depsub_machine (depsub_mac_name, dep_mac_id) VALUES('$depsub_mac_name', '$dep_mac_id')");
            return $add_MDS; 
        }

        public function addMachine ($mac_name, $mac_serial, $mac_pic, $depsub_mac_id, $mac_status){
            $add_Mac = mysqli_query($this->dbcon, 
            "   INSERT INTO machine (mac_name, mac_serial, mac_pic, depsub_mac_id, mac_status) 
                VALUES('$mac_name', 
                        '$mac_serial',
                        '$mac_pic',
                        '$depsub_mac_id',
                        '$mac_status'
                        )");
            return $add_Mac; 
        }

        public function addRepairMac ($m_mac_name, $depart_id, $mac_id, $m_mac_issue, $m_mac_urgency, $m_mac_pic, $check_status, $m_mac_datetime){
            $add_RS = mysqli_query($this->dbcon, "INSERT INTO main_machine (m_mac_name, depart_id, mac_id, m_mac_issue, m_mac_urgency, m_mac_pic, check_status, m_mac_datetime) 
            VALUES('$m_mac_name', '$depart_id', '$mac_id', '$m_mac_issue', '$m_mac_urgency', '$m_mac_pic', '$check_status', '$m_mac_datetime')");
            return $add_RS; 
        }

        public function updateMianMac ($check_status, $m_mac_approve, $mainmac_status, $m_mac_rate, $m_approve_date, $m_check_status, $m_mac_id) { 
            $result = mysqli_query($this->dbcon, "UPDATE main_machine SET 
                check_status = '$check_status',
                m_mac_approve = '$m_mac_approve',
                mainmac_status = '$mainmac_status',
                m_mac_rate = '$m_mac_rate',
                m_check_status = '$m_check_status',
                m_approve_date = '$m_approve_date'
                WHERE m_mac_id = '$m_mac_id'
            "); 
            return $result;
        }

        public function updateEditIssue ($m_mac_issue, $m_mac_id) { 
            $result = mysqli_query($this->dbcon, "UPDATE main_machine SET 
                m_mac_issue = '$m_mac_issue'
                WHERE m_mac_id = '$m_mac_id'
            "); 
            return $result;
        }

        public function fetchonerecord ($m_mac_id) {
            $result = mysqli_query($this->dbcon, "SELECT * 
            FROM main_machine
            WHERE m_mac_id = '$m_mac_id'");
            return $result;

        }

        public function fetchTaskmaint($m_mac_id) {
            $result = mysqli_query($this->dbcon, "SELECT * 
            FROM main_machine
            INNER JOIN depart ON main_machine.depart_id = depart.depart_id 
            WHERE m_mac_id = '$m_mac_id'");
            return $result;
    
        }

        public function fetchOnetask($m_mac_id) {
            $result = mysqli_query($this->dbcon, "SELECT * 
            FROM tasker_mac
            INNER JOIN technician ON tasker_mac.tc_id = technician.tc_id
            WHERE m_mac_id = '$m_mac_id'");
            return $result;
    
        }

        public function AddOrders ($m_mac_id, $mc_pr_code, $mc_pr_product, $mc_pr_detail, $mc_pr_status, $mc_pr_start, $mc_pr_userstart){
            $add_od = mysqli_query($this->dbcon, "INSERT INTO purchase_mc (m_mac_id, mc_pr_code, mc_pr_product, mc_pr_detail, mc_pr_status, mc_pr_start, mc_pr_userstart) 
            VALUES('$m_mac_id', '$mc_pr_code', '$mc_pr_product', '$mc_pr_detail', '$mc_pr_status', '$mc_pr_start', '$mc_pr_userstart')");
            return $add_od; 
        }

        public function updateStatusPur($mc_pr_status, $mc_pr_id, $mc_pr_end, $mc_pr_userend) { 
            $result = mysqli_query($this->dbcon, "UPDATE purchase_mc SET 
                mc_pr_status = '$mc_pr_status',
                mc_pr_end = '$mc_pr_end',
                mc_pr_userend = '$mc_pr_userend'
                WHERE mc_pr_id = '$mc_pr_id'
            "); 
            return $result;
        }

        public function AddWorking ($m_mac_id, $mc_date_start, $mc_user_start, $mc_status_work){
            $add_work = mysqli_query($this->dbcon, "INSERT INTO working_mc (m_mac_id, mc_date_start, mc_user_start, mc_status_work) 
            VALUES('$m_mac_id', '$mc_date_start', '$mc_user_start', '$mc_status_work')");
            return $add_work; 
        }

        public function updateWorkEnd($mc_work_id, $mc_status_work, $mc_date_end, $mc_user_end) { 
            $result = mysqli_query($this->dbcon, "UPDATE working_mc SET 
                mc_status_work = '$mc_status_work',
                mc_date_end = '$mc_date_end',
                mc_user_end = '$mc_user_end'

                WHERE mc_work_id = '$mc_work_id'
            "); 
            return $result;
        }

        public function updateUsercheck ($m_check_status, $m_mac_datecheck, $m_mac_comment, $m_mac_check, $m_mac_id) { 
            $result = mysqli_query($this->dbcon, "UPDATE main_machine SET 
                m_check_status = '$m_check_status',
                m_mac_datecheck = '$m_mac_datecheck',
                m_mac_comment = '$m_mac_comment',
                m_mac_check = '$m_mac_check'
                WHERE m_mac_id = '$m_mac_id'
            "); 
            return $result;
        }

        public function fetchstatusend ($m_mac_id) {
            $result = mysqli_query($this->dbcon, "SELECT * 
            FROM main_machine
            INNER JOIN depart ON main_machine.depart_id = depart.depart_id 
            WHERE m_mac_id = '$m_mac_id'");
            return $result;

        }

        public function updateEnd2 ($mainmac_status, $m_suc_issue, $m_suc_date, $switch_machine, $task_mac_status, $m_mac_id) { 
            $result = mysqli_query($this->dbcon, "UPDATE main_machine SET 
                mainmac_status = '$mainmac_status',
                m_suc_issue = '$m_suc_issue',
                m_suc_date = '$m_suc_date',
                switch_machine = '$switch_machine'
                WHERE m_mac_id = '$m_mac_id'
            "); 
            $result = mysqli_query($this->dbcon, "UPDATE tasker_mac SET 
            task_mac_status = '$task_mac_status'
            WHERE m_mac_id = '$m_mac_id'
        "); 
            return $result;
        }

        


   }
?>