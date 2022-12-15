<?php
    include_once ('functions-maint.php');
include 'functions.php';

$mtObj = new Maintenance();

// Insert Record in customer table
if(isset($_POST['submit'])) {

    $m_user = $_POST['m_user'];
    $m_depart_id = $_POST['m_depart_id'];
    $m_c_id = $_POST['m_c_id'];
    $m_st_id = $_POST['m_st_id'];
    $m_urgency = $_POST['m_urgency'];
    $m_issue = $_POST['m_issue'];
    $check_status = $_POST['check_status'];
    $file = $_FILES['m_img'];
    $insertData = $mtObj->insertData($m_user, $m_depart_id, $m_c_id, $m_st_id, $m_urgency, $m_issue, $check_status, $file);

    if ($insertData){
        header("Location:index.php");
    }else{
        return false;
    }

}
?>