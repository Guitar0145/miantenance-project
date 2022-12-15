<?php 
    include('connect_sqli.php'); 

    $sql = "SELECT * FROM `switch` WHERE switch_name = 'ระดับความยากดาว' ";
    $sql_query = mysqli_query($con,$sql);
    $switchRate = mysqli_fetch_all($sql_query,MYSQLI_ASSOC);

    $sql = "SELECT * FROM `switch` WHERE switch_name = 'Time Limit (ย้อนหลัง)' ";
    $sql_query = mysqli_query($con,$sql);
    $switchTime = mysqli_fetch_all($sql_query,MYSQLI_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ทดสอบ สวิตซ์</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/fa_icon.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container pt-3">

        <?php foreach ($switchRate as $switchRate ) { if ($switchRate['status'] == 1) { ?> 
            <div class="alert alert-primary" role="alert">
            A simple primary alert—check it out!
            </div>
        <?php } } ?>

        <?php foreach ($switchTime as $switchTime ) { if ($switchTime['status'] == 1) { ?>
            <div class="alert alert-secondary" role="alert">
            A simple secondary alert—check it out!
            </div>
        <?php } } ?>
           
    </div>
</body>
</html>