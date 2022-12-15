<?php

include("connect.inc");  
$sql = " SELECT * FROM maintenance 
INNER JOIN depart ON maintenance.m_depart_id = depart.depart_id 
INNER JOIN categories ON maintenance.m_c_id = categories.c_id
WHERE check_status = 'รอตรวจสอบ' ";
$query = mysqli_query($conn,$sql) or die (mysqli_error($conn));
$JSON = array();
while ($row = mysqli_fetch_assoc($query)) {
    array_push($JSON,$row);
}
echo json_encode($JSON);
