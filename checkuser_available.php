<?php
    include_once('functions-maint.php');

    $usernamecheck = new DB_con();

    // รับค่า value จาก post
    $username = $_POST['username'];

    $sql = $usernamecheck->usernameavailable($username);

    $num = mysqli_num_rows($sql);

    if ($num>0){
        echo "<span style='color:red;'>ชื่อผู้ใช้นี้ มีคนใช้แล้ว !!</span>";
        echo "<script>$('#submit').prop('disabled',true);</script>";
    } else{
        echo "<span style='color:green;'>คุณสามารถใช้ ชื่อผู้ใช้นี้ได้ !!</span>";
        echo "<script>$('#submit').prop('disabled',false);</script>";
    }

?>