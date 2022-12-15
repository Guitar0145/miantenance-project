<?php
    $con=mysqli_connect("localhost","root","rootroot","mtservice");
    if (isset($_GET['switch_id'])){
        $switch_id=$_GET['switch_id'];

        $sql="UPDATE `switch` SET 
            `status`=1 WHERE switch_id='$switch_id'";

        mysqli_query($con,$sql);
    }
    header('location: switch-page.php');
?>