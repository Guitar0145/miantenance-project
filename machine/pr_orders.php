<?php session_start(); 
include('../connect_sqli.php'); 
include_once ('functions-machine.php');

$orderData = new DB_con();
if (isset($_POST['submitOrders'])){
$m_mac_id = $_POST['m_mac_id'];
$mc_pr_code = $_POST['mc_pr_code'];
$mc_pr_product = $_POST['mc_pr_product'];
$mc_pr_detail = $_POST['mc_pr_detail'];
$mc_pr_status = $_POST['mc_pr_status'];
$mc_pr_start = $_POST['mc_pr_start'];
$mc_pr_userstart = $_POST['mc_pr_userstart'];


$sql = $orderData->AddOrders($m_mac_id, $mc_pr_code, $mc_pr_product, $mc_pr_detail, $mc_pr_status, $mc_pr_start, $mc_pr_userstart);

        if ($sql){
            echo "<script>alert('เพิ่มรายการสั่งซื้อสินค้า สำเร็จ!');</script>";
            echo "<script>window.location.href='pr_orders.php</script>";
        } else{
            echo "<script>alert('เพิ่มรายการสั่งซื้อสินค้า ไม่สำเร็จ !!');</script>";
            echo "<script>window.location.href='pr_orders.php'</script>";
        }
}

$updatedata = new DB_con();

    if (isset($_POST['Receive'])){

        $mc_pr_id = $_POST['mc_pr_id'];
        $mc_pr_status = $_POST['mc_pr_status'];
        $mc_pr_end = $_POST['mc_pr_end'];
        $mc_pr_userend = $_POST['mc_pr_userend'];


        $sql =  $updatedata->updateStatusPur($mc_pr_status, $mc_pr_id, $mc_pr_end, $mc_pr_userend);
        if ($sql) {
          echo "<script>alert('รับสินค้า สำเร็จ !!');</script>";
          echo "<script>window.location.href='pr_orders.php</script>";
        } else {
          echo "<script>alert('รับสินค้า ไม่สำเร็จ !!');</script>";
          echo "<script>window.location.href='pr_orders.php</script>";
        }
    }

$Get_id = $_GET['id'];
$query = "SELECT * FROM purchase_mc WHERE m_mac_id = '$Get_id' " or die("Error:" . mysqli_error());
$purchase = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="../css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/fa_icon.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    </head>
<body>
    <div class="container-fluid">
        <div class="p-3 mt-3">
            <div class="card p-3">
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->              
                <div class="row">
                    <div class="col-12">
                        <div class="card-header bg-primary text-white">
                            เพิ่มรายการสั่งซื้อ รายการแจ้งซ่อม : <?php echo $_GET['id']; ?> 
                        </div>
                        <div class="card-body shadow p-4 mb-4 bg-white">
                        <div class="col-10">
                            <form method="POST">
                            <div class="input-group mb-3">
                                <input type="hidden" class="form-control" placeholder="รหัสแจ้งซ่อม" value="<?php echo $_GET['id']; ?>" name="m_mac_id" required>
                                <div class="col-2">
                                    <input type="text" class="form-control" placeholder="PR Code" name="mc_pr_code" required>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" placeholder="สินค้า" name="mc_pr_product" required>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" placeholder="รายละเอียด" name="mc_pr_detail" required>
                                </div>
                                <input type="hidden" class="form-control" placeholder="สถานะ" value="กำลังรอสินค้า" name="mc_pr_status">
                                <?php date_default_timezone_set("Asia/Bangkok"); ?>
                                <input type="hidden" class="form-control" placeholder="วันที่สั่ง" value="<?php echo date("Y-m-d"); ?> <?php echo date("H:i:s"); ?>" name="mc_pr_start">
                                <input type="hidden" class="form-control" placeholder="ผู้สั่งซื้อ" value="<?php echo $_SESSION['u_name']; ?>" name="mc_pr_userstart">
                                <button type="submit" class="btn btn-primary" name="submitOrders">เพิ่ม</button>
                            </div>
                            </form>
                        </div>  
                        </div>
                    </div>
                </div>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                <div class="row">
                    <div class="col-12">
                        <div class="card-header bg-success text-white">
                        รายการสั่งซื้อสินค้า รายการแจ้งซ่อม : <?php echo $_GET['id']; ?>

                        <?php 
                        $id_count = $_GET['id'];
                        $sql3 = "SELECT * FROM purchase_mc WHERE m_mac_id = $id_count AND mc_pr_status = 'กำลังรอสินค้า' ";
                        if ($result3=mysqli_query($con,$sql3))
                        {
                            $countOrders=mysqli_num_rows($result3);
                            mysqli_free_result($result3);
                        }
                        ?>
                        </div>
                        <div class="card-body shadow p-4 mb-4 bg-white">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th>รหัส PR</th>
                                    <th>PR Code</th>
                                    <th>สินค้า</th>
                                    <th>รายละเอียด</th>
                                    <th>สถานะ</th>
                                    <th>วันที่สั่ง</th>
                                    <th>วันที่รับ</th>
                                    <th>ผู้สั่ง</th>
                                    <th>รับ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($purchase as $row) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $row['mc_pr_id']; ?></td>
                                    <td><?php echo $row['mc_pr_code']; ?></td>
                                    <td><?php echo $row['mc_pr_product']; ?></td>
                                    <td><?php echo $row['mc_pr_detail']; ?></td>
                                    <td class="text-center">
                                    <?php 
                                            if($row['pr_status'] == 'กำลังรอสินค้า') {
                                                echo '<span style="color:#F99607;">กำลังรอสินค้า</span>';
                                            } else {
                                                echo '<span style="color:green;">รับสินค้าแล้ว</span>';
                                            }
                                    ?>
                                    </td>
                                    <td class="text-center"><?php echo $row['mc_pr_start']; ?></td>
                                    <td><?php echo $row['mc_pr_end']; ?></td>
                                    <td><?php echo $row['mc_pr_userstart']; ?>
                                        
                                
                                    </td>
                                    <td class="col-1 text-center">
                                        <form method="POST">
                                            <input type="hidden" name="mc_pr_id" value="<?php echo $row['mc_pr_id']; ?>">
                                            <input type="hidden" name="mc_pr_status" value="รับสินค้าแล้ว">
                                            <input type="hidden" name="mc_pr_end" value="<?php echo date("Y-m-d"); ?> <?php echo date("H:i:s"); ?>">
                                            <input type="hidden" name="mc_pr_userend" value="<?php echo $_SESSION['u_name']; ?>">

                                        <button type="submit" name="Receive" onClick="return confirm('ยืนยันรับสินค้า ?');" class="btn btn-sm btn-primary" <?php if ($row['mc_pr_status'] == 'รับสินค้าแล้ว') { ?>disabled<?php } ?>><i class="fas fa-check-circle">&nbsp;ยืนยัน</i></button>
                                        </form>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
var slider = document.getElementById("myRange");
var output = document.getElementById("demo");
output.innerHTML = slider.value;

slider.oninput = function() {
  output.innerHTML = this.value;
}
</script>
</html>