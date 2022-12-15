<?php
$con=mysqli_connect("localhost","root","rootroot","mtservice");
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$sql2="SELECT tc_id
FROM tasker
GROUP BY tc_id 
";
if ($result=mysqli_query($con,$sql2))
  {
  $count=mysqli_num_rows($result);
  mysqli_free_result($result);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
  <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/bootstrap-grid.css" rel="stylesheet" type="text/css">
  <link href="css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
  <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
  <table class="table table-sm table-bordered border-dark">
    <thead class="table-active">
      <tr>
        <th>รหัสช่าง</th>
        <th>จำนวนงานที่ทำอยู่</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?php echo $count; ?></td>
        <td><?php echo $count; ?></td>
      </tr>
    </tbody>
  </table>
</div>
</body>
</html>