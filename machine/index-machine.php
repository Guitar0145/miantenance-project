<?php 
    session_start();
    include ('../connect_sqli.php');

    $query = "  SELECT * FROM main_machine 
                INNER JOIN machine ON main_machine.mac_id = machine.mac_id
                WHERE check_status = 'รอตรวจสอบ' 
            " 
    or die ("Error:" . mysqli_error());
    $main_machine = mysqli_query($con, $query);

    $query2 = "  SELECT * FROM main_machine 
                INNER JOIN machine ON main_machine.mac_id = machine.mac_id
                WHERE (check_status = 'ตรวจสอบแล้ว' AND m_check_status = 'NO')
            " 
    or die ("Error:" . mysqli_error());
    $list_mainmac = mysqli_query($con, $query2);

    $query = "  SELECT * FROM main_machine 
    INNER JOIN machine ON main_machine.mac_id = machine.mac_id
    INNER JOIN depart ON main_machine.depart_id = depart.depart_id
    WHERE check_status = 'ตรวจสอบแล้ว' AND m_check_status = 'YES' AND mainmac_status = 'กำลังดำเนินการ'
    " 
    or die ("Error:" . mysqli_error());
    $listcheck = mysqli_query($con, $query);

    include_once ('functions-machine.php');
    $updatedata = new DB_con();

    if (isset($_POST['submit'])){

        $m_mac_id = $_POST['m_mac_id'];
        $check_status = $_POST['check_status'];
        $m_mac_approve = $_POST['m_mac_approve'];
        $mainmac_status = $_POST['mainmac_status'];
        $m_mac_rate = $_POST['m_mac_rate'];
        $m_approve_date = $_POST['m_approve_date'];
        $m_check_status = $_POST['m_check_status'];


        $sql =  $updatedata->updateMianMac($check_status, $m_mac_approve, $mainmac_status, $m_mac_rate, $m_approve_date, $m_check_status, $m_mac_id);
        if ($sql) {
          echo "<script>alert('อัพเดทข้อมูล สำเร็จ !!');</script>";
          echo "<script>window.location.href='index-machine.php'</script>";
        } else {
          echo "<script>alert('อัพเดทข้อมูล ไม่สำเร็จ !!');</script>";
          echo "<script>window.location.href='index-machine.php'</script>";
        }
        
    }

    $dataIssue = new DB_con();
    if (isset($_POST['submitIssue'])){

        $m_mac_id = $_POST['m_mac_id'];
        $m_mac_issue = $_POST['m_mac_issue'];

        $sql =  $dataIssue->updateEditIssue($m_mac_issue, $m_mac_id);
        if ($sql) {
          echo "<script>alert('อัพเดทข้อมูล สำเร็จ !!');</script>";
          echo "<script>window.location.href='index-machine.php'</script>";
        } else {
          echo "<script>alert('อัพเดทข้อมูล ไม่สำเร็จ !!');</script>";
          echo "<script>window.location.href='index-machine.php'</script>";
        }
        
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แจ้งซ่อมเครื่องจักร</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="../css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/fa_icon.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="../dist/css/lightbox.min.css">
    <style>
        .gold {
            color:#FFD700;
        }
    .line_notech {
        border-bottom:2px dashed black;
    }
    </style>
    </head>
<body>
    <?php include 'navbar-machine.php' ?>
    <div class="container-fluid">
        <div class="">
            <div class="card p-1 my-2">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-info shadow my-1 mx-1" href="repair-machine.php"><i class="fas fa-cogs"></i>&nbsp;แจ้งซ่อมเครื่องจักร</a>
                <?php if($_SESSION['level'] == 'Admin' ) {?>
                <button type="button" class="btn btn-warning shadow my-1 mx-1" data-bs-toggle="modal" data-bs-target="#Status_Tech" data-bs-whatever="@mdo"><i class="fas fa-cogs"></i>&nbsp;สถานะช่าง</button>
                <?php } ?>
            </div><br>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->              
                <div class="row">
                    <div class="col-12">
                        <div class="card-header bg-secondary text-white">
                            รายการแจ้งซ่อมเครื่องจักร ที่รอตรวจสอบ
                        </div>
                        <div class="card-body shadow p-4 mb-4 bg-white">
                            <div class="table-responsive-md">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="col-auto">#</th>
                                            <th>ผู้แจ้ง</th>
                                            <th>แผนก</th>
                                            <th class="col-1">หมายเลขเครื่อง</th>
                                            <th>เครื่องจักร</th>
                                            <th>อาการ</th>
                                            <th>ความเร่งด่วน</th>
                                            <th class="col-1">รูปภาพ</th>
                                            <th>วันที่แจ้ง</th>
                                            <th>เวลา</th>
                                            <th class="col-1">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($main_machine AS $row) { ?>
                                        <tr>
                                            <th class="text-center"><?php echo $row ['m_mac_id']; ?></th>
                                            <td><?php echo $row ['m_mac_name']; ?></td>
                                            <td><?php echo $row ['depart_id']; ?></td>
                                            <td><?php echo $row ['mac_serial']; ?></td>
                                            <td><?php echo $row ['mac_name']; ?></td>
                                            <td><?php echo $row ['m_mac_issue']; ?></td>
                                            <td><?php echo $row ['m_mac_urgency']; ?></td>
                                            <td class="text-center">
                                                <a href="<?php echo $row ['m_mac_pic']; ?>" data-lightbox="example-set" data-title="<?php echo $row ['m_mac_issue']; ?>">
                                                <img src="<?php echo $row ['m_mac_pic']; ?>" width="50" height="70">
                                            </td>
                                            <td class="text-center"><?php echo $row ['m_mac_datetime']; ?></td>
                                            <td class="text-center">
                                                <?php 
                                                    date_default_timezone_set("Asia/Bangkok");
                                                    $datetime_start = $row['m_mac_datetime'];
                                                    $datetime_end = date("Y-m-d H:i:s");
                                                    $seconds = strtotime($datetime_end) - strtotime($datetime_start);
                                                    $sum += $seconds;
        
                                                    $days    = floor($seconds / 86400);
                                                    $hours   = floor(($seconds - ($days * 86400)) / 3600);
                                                    $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
                                                    $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));
                                                    
                                                    echo $days." วัน ".$hours." ชั่วโมง ";
                                                ?>

                                            </td>
                                            <td class="text-center">
                                            <?php if($_SESSION['level'] == 'Admin' ) {?>
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#ApproveMac<?php echo $row ['m_mac_id']; ?>">รับงาน</button>
                                            <?php } ?>
                                                <button class="btn btn-sm btn-primary" name="editImg" id="editImg" data-bs-toggle="modal" data-bs-target="#editImg<?php echo $row['m_mac_id']; ?>">รูป</button>
                                            </td>
                                        </tr>
                                        <!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                        <!--------------------------------------------------------------------------------------Open Modal Update IMG ----------------------------------------------------------------------------------->
                                <div class="modal fade" id="editImg<?php echo $row['m_mac_id']; ?>" aria-hidden="true">                      
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="POST" enctype="multipart/form-data" action="Upload-ImgMain.php">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title">อัพโหลดรูปภาพ</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="col"></div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <h5>รูปภาพเดิม</h5>
                                                                <hr>
                                                                <div class="text-center">
                                                                <img src="<?php echo $row['m_mac_pic']?>" height="200" width="auto" />
                                                                </div>
                                                                <input type="hidden" name="previous" value="<?php echo $row['m_mac_pic']?>"/>
                                                                <hr>
                                                                <h5>รูปภาพใหม่</h5>
                                                                <input type="file" class="form-control" name="photo" value="<?php echo $row['m_mac_pic']?>" required="required"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="hidden" value="<?php echo $row['m_mac_id']?>" name="m_mac_id"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br style="clear:both;"/>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-warning" name="edit"><span class="glyphicon glyphicon-save"></span>Upload</button>
                                                        <button class="btn btn-danger" data-bs-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
<!--------------------------------------------------------------------------------------Close Modal Update IMG ----------------------------------------------------------------------------------->
                                        <!--Start Modal แจ้งซ่อม-->
                                        <div class="modal fade" id="ApproveMac<?php echo $row ['m_mac_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">แจ้งซ่อม</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post">
                                                        <div class="input-group mb-2">
                                                            <span class="input-group-text">เครื่องจักร</span>
                                                            <input type="text" class="form-control" name="mac_name" value="<?php echo $row ['mac_name'] ;?>" readonly>
                                                        </div>
                                                        <div class="input-group mb-2">
                                                            <span class="input-group-text">อาการ</span>
                                                            <textarea class="form-control" name="m_mac_issue" required readonly><?php echo $row ['m_mac_issue']; ?></textarea>
                                                        </div>
                                                        <div class="input-group mb-2">
                                                            <span class="input-group-text">ความเร่งด่วน</span>
                                                            <input type="text" class="form-control" name="m_mac_urgency" value="<?php echo $row['m_mac_urgency']; ?>" readonly>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="customRange2" class="form-label">ระดับความยากง่ายของงาน</label>
                                                            <input type="range" class="form-range" min="0" max="10" name="m_mac_rate" id="myRange">
                                                            <h5>ความยาก : <span id="demo"></span></h5>
                                                        </div>
                                                        <div class="input-group mb-2">

                                                            <input type="hidden" class="form-control" name="check_status" value="ตรวจสอบแล้ว" readonly>
                                                        </div>
                                                        <div class="input-group mb-2">

                                                            <input type="hidden" class="form-control" name="m_mac_approve"  value="<?php echo $_SESSION['u_name']; ?>" readonly>
                                                        </div>
                                                        <div class="input-group mb-2">

                                                            <input type="hidden" class="form-control" name="mainmac_status" value="กำลังดำเนินการ" readonly>
                                                        </div>
                                                        <div class="input-group mb-2">
                                                            <input type="hidden" class="form-control" name="m_check_status" value="NO" readonly>
                                                        </div>
                                                        <div class="input-group mb-2">

                                                            <input type="hidden" class="form-control" name="m_approve_date" value="<?php echo date ('Y-m-d H:i:s'); ?>">
                                                            <input type="hidden" class="form-control" name="m_mac_id" value="<?php echo $row['m_mac_id']; ?>">
                                                        </div>


                                                <div class="modal-footer">    
                                                    <button type="submit" name="submit" id="submit" class="btn btn-primary">รับงาน</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                                </div>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End Modal แจ้งซ่อม-->
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                <div class="row">
                    <div class="col-12">
                        <div class="card-header bg-primary text-white">
                            คิวรายการแจ้งซ่อมเครื่องจักร
                        </div>
                        <div class="card-body shadow p-4 mb-4 bg-white">
                            <div class="table-responsive-md">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="col-auto">#</th>
                                            <th>ผู้แจ้ง</th>
                                            <th>แผนก</th>
                                            <th class="col-1">หมายเลขเครื่อง</th>
                                            <th>เครื่องจักร</th>
                                            <th>อาการ</th>
                                            <th>ความเร่งด่วน</th>
                                            <th>สถานะ</th>
                                            <th>วันที่แจ้ง</th>
                                            <th class="col-1">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($list_mainmac AS $row) { 
                                            
                                            $count_id  = $row['m_mac_id'];
                                            ?>
                                        
                                            <?php
                                                $sql="SELECT * FROM tasker_mac WHERE m_mac_id =  $count_id and task_mac_status = 'ทำงานเสร็จสิ้น'";
                                                if ($result=mysqli_query($con,$sql))
                                                {
                                                    $countEnd=mysqli_num_rows($result);
                                                    mysqli_free_result($result);
                                                }
    
                                                $sql2 = "SELECT * FROM tasker_mac WHERE m_mac_id = $count_id ";
                                                if ($result2=mysqli_query($con,$sql2))
                                                {
                                                    $countPer=mysqli_num_rows($result2);
                                                    mysqli_free_result($result2);
                                                }

                                                $sql3 = "SELECT * FROM purchase_mc WHERE m_mac_id = $count_id ";
                                                if ($result3=mysqli_query($con,$sql3))
                                                {
                                                    $countOrders=mysqli_num_rows($result3);
                                                    mysqli_free_result($result3);
                                                }

                                                $sql4 = "SELECT * FROM purchase_mc WHERE m_mac_id = $count_id AND mc_pr_status = 'กำลังรอสินค้า' ";
                                                if ($result4=mysqli_query($con,$sql4))
                                                {
                                                    $TaskerStatus=mysqli_num_rows($result4);
                                                    mysqli_free_result($result4);
                                                }

                                                $sql5 = "SELECT * FROM working_mc WHERE m_mac_id = $count_id AND mc_status_work = 'กำลังทำงาน' ";
                                                if ($result5=mysqli_query($con,$sql5))
                                                {
                                                $countWorking=mysqli_num_rows($result5);
                                                mysqli_free_result($result5);
                                                }
                                            ?>
                                        <tr>
                                            <th class="text-center"><?php echo $row ['m_mac_id']; ?></th>
                                            <td><?php echo $row ['m_mac_name']; ?></td>
                                            <td><?php echo $row ['depart_id']; ?></td>
                                            <td><?php echo $row ['mac_serial']; ?></td>
                                            <td><?php echo $row ['mac_name']; ?></td>
                                            <td class="col-3"><?php echo $row ['m_mac_issue']; ?></td>
                                            <td><?php echo $row ['m_mac_urgency']; ?></td>
                                            <td>
                                            <?php 
                                                If ($TaskerStatus > 0 ){
                                                    echo '<span style="color:#F99607">กำลังรออะไหล่&nbsp;<i class="far fa-clock"></i></span>' ;
                                                } else {
                                                    echo '<span style="color:green;">กำลังดำเนินการ&nbsp;<i class=""></i></span>' ;
                                                }
                                            
                                            ?>
                                            </td>
                                            <td class="text-center"><?php echo $row ['m_mac_datetime']; ?></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="p-1 badge btn bg-primary dropdown-toggle position-relative" data-bs-toggle="dropdown" aria-expanded="false">จัดการ</button>
                                                    <?php if($_SESSION['level'] == 'Admin' ) {?>
                                                        <?php if ($countWorking > 0 ){?>
                                                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#" onclick="window.open(this.href='task-detail.php?id=<?php echo $row['m_mac_id'] ?>','popUpWindow','height=600,width=700,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">ดูเพิ่มเติม</a></li>
                                                            <li><a class="dropdown-item" href="#" name="editIssue" id="editIssue" data-bs-toggle="modal" data-bs-target="#editIssue<?php echo $row ['m_mac_id']; ?>">แก้ไขอาการ</a></li>
                                                            <?php if($_SESSION['level'] == 'Admin' ) {?>
                                                                <li><a class="dropdown-item" href="#" onclick="window.open(this.href='task-manage.php?id=<?php echo $row['m_mac_id'] ?>','popUpWindow','height=400,width=700,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">จ่ายงานช่าง (<?php echo $countPer; ?>)</a></li>
                                                                <?php if($countPer ==! 0 ) {?>
                                                                    <li><hr class="dropdown-divider"></li>
                                                            
                                                                <?php } ?>
                                                                <li><a class="dropdown-item" href="#" onclick="window.open(this.href='pr_orders.php?id=<?php echo $row['m_mac_id'] ?>','popUpWindow','height=600,width=1200,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">สั่งซื้อสินค้า (<?php echo $countOrders; ?>)</a></li>
                                                                <li><a class="dropdown-item position-relative" href="#" onclick="window.open(this.href='working_time.php?id=<?php echo $row['m_mac_id'] ?>','popUpWindow','height=600,width=1200,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">เวลาการทำงานช่าง
                                                                        <?php if ($countWorking > 0 ){ ?>   
                                                                        <span class="position-absolute top-0 start-90 translate-middle p-1 bg-danger mt-2 border border-light rounded-circle"></span>
                                                                    <?php } ?>  
                                                                </a>
                                                                </li>
                                                            <?php } ?>

                                                            <?php if($_SESSION['level'] == 'User' ) {?>
                                                                <?php if($row['m_check_status'] == 'NO') {?>
                                                                    <li><a class="dropdown-item" href="#" onclick="window.open(this.href='user_check.php?id=<?php echo $row['m_mac_id'] ?>','popUpWindow','height=400,width=600,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">ยืนยันตรวจสอบ</a></li>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </ul>
                                                </div>
                                            </td>
                                        </tr>
<!--------------------------------------------------------------------------- Start Modal Edit Maintenance Machine----------------------------------------------------------------->
                                        <div class="modal fade" id="editIssue<?php echo $row ['m_mac_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">แก้ไขอาการ # <?php echo $row['m_mac_id']; ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST">
                                                        <div class="input-group">
                                                            <span class="input-group-text">อาการ</span>
                                                            <textarea class="form-control" name="m_mac_issue" required><?php echo $row['m_mac_issue']; ?></textarea>
                                                            <input type="hidden" name="m_mac_id" value="<?php echo $row['m_mac_id']; ?>">
                                                        </div>
                                                    
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="submitIssue" class="btn btn-primary">Save changes</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
<!---------------------------------------------------------------------------End Modal Edit Maintenance Machine------------------------------------------------------------------->
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                <div class="row">
                    <div class="col-12">
                        <div class="card-header bg-success text-white">
                            ยืนยันการตรวจสอบงานแล้ว
                        </div>
                        <div class="card-body shadow p-4 mb-4 bg-white">
                            <div class="table-responsive-md">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>ผู้แจ้ง/แผนก</th>
                                            <th>เครื่องจักร</th>
                                            <th class="col-3">ปัญหา</th>
                                            <th>ความเร่งด่วน</th>
                                            <th>ความยาก</th>
                                            <th class="col-3">การตรวจสอบปิดงาน</th>
                                            <th>ผู้ตรวจสอบ</th>
                                            <th>จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($listcheck as $row) { 
                                            $count_id  = $row['m_mac_id'];
                                            ?>
                                        
                                            <?php
                                                $sql="SELECT * FROM tasker_mac WHERE m_mac_id =  $count_id and task_mac_status = 'ทำงานเสร็จสิ้น'";
                                                if ($result=mysqli_query($con,$sql))
                                                {
                                                    $countEnd=mysqli_num_rows($result);
                                                    mysqli_free_result($result);
                                                }
    
                                                $sql2 = "SELECT * FROM tasker_mac WHERE m_mac_id = $count_id ";
                                                if ($result2=mysqli_query($con,$sql2))
                                                {
                                                    $countPer=mysqli_num_rows($result2);
                                                    mysqli_free_result($result2);
                                                }

                                                $sql3 = "SELECT * FROM purchase_mc WHERE m_mac_id = $count_id ";
                                                if ($result3=mysqli_query($con,$sql3))
                                                {
                                                    $countOrders=mysqli_num_rows($result3);
                                                    mysqli_free_result($result3);
                                                }

                                                $sql4 = "SELECT * FROM purchase_mc WHERE m_mac_id = $count_id AND mc_pr_status = 'กำลังรอสินค้า' ";
                                                if ($result4=mysqli_query($con,$sql4))
                                                {
                                                    $TaskerStatus=mysqli_num_rows($result4);
                                                    mysqli_free_result($result4);
                                                }

                                                $sql5 = "SELECT * FROM working_mc WHERE m_mac_id = $count_id AND mc_status_work = 'กำลังทำงาน' ";
                                                if ($result5=mysqli_query($con,$sql5))
                                                {
                                                $countWorking=mysqli_num_rows($result5);
                                                mysqli_free_result($result5);
                                                }
                                            ?>
                                        <tr>
                                            <td><?php echo $row['m_mac_id']; ?></td>
                                            <td><?php echo $row['m_mac_name']; ?> / <?php echo $row['depart_sub_name']; ?></td>
                                            <td><?php echo $row['mac_name']; ?></td>
                                            <td><?php echo $row['m_mac_issue']; ?></td>
                                            <td>
                                                <?php
                                                    $urgency = $row['m_mac_urgency'];
                                                    $urgency_hight= '<div style="color:red; font-weight: bold;">Hight</div>';
                                                    $urgency_normal = '<div class="" style="color:blue; font-weight: bold;">Normal</div>';
                                                    $urgency_low = '<div class="" style="color:gray; font-weight: bold;">Low</div>';

                                                    if ($urgency == 'Hight') {
                                                        echo $urgency_hight;        
                                                    } else if ($urgency == 'Normal') {
                                                        echo $urgency_normal;       
                                                    } else {
                                                        echo $urgency_low;    
                                                    }
                                                ?>
                                            </td>
                                            <td class="text-center"><a style="font-weight:bold; color:#000;" class="btn btn-sm btn-outline-warning px-3"><?php echo $row['m_mac_rate'] ?>&nbsp;<i class="fas fa-star gold"></i></td>
                                            <td><?php echo $row['m_mac_comment']; ?></td>
                                            <td><?php echo $row['m_mac_check']; ?></td>
                                            <td>
                                            <div class="btn-group">
                                                <button type="button" class="p-2 badge btn bg-primary dropdown-toggle position-relative" data-bs-toggle="dropdown" aria-expanded="false">จัดการ</button>
                                                    <?php if($_SESSION['level'] == 'Admin' ) {?>
                                                        <?php if ($countWorking > 0 ){?>
                                                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#" onclick="window.open(this.href='task-detail.php?id=<?php echo $row['m_mac_id'] ?>','popUpWindow','height=600,width=700,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">ดูเพิ่มเติม</a></li>
                                                       
                                                        <?php if($_SESSION['level'] == 'Admin' ) {?>
                                                            <li><hr class="dropdown-divider"></li>
                                                                <?php if($row['m_check_status'] == 'YES') {?>
                                                                    <?php if($status == '1') {?>
                                                                        <li><a class="dropdown-item" href="#" onclick="window.open(this.href='task-manage.php?id=<?php echo $row['m_mac_id'] ?>','popUpWindow','height=400,width=700,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">จ่ายงานช่าง (<?php echo $countPer; ?>)</a></li>
                                                                    <?php } ?>
                                                                    <?php if ($countWorking > 0 ){ ?>  
                                                                        <li><a class="dropdown-item position-relative" href="#" onclick="window.open(this.href='working_time.php?id=<?php echo $row['m_mac_id'] ?>','popUpWindow','height=600,width=1200,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">เวลาการทำงานช่าง
                                                                    <?php } ?>  
                                                                        <?php if ($countWorking > 0 ){ ?>   
                                                                            <span class="position-absolute top-0 start-90 translate-middle p-1 bg-danger mt-2 border border-light rounded-circle"></span>
                                                                        <?php } ?>  
                                                                    </a>
                                                                    </li>
                                                                    <?php if ($countWorking == 0 ){ ?>
                                                                        <li><a class="dropdown-item" href="#" onclick="window.open(this.href='approved_status_end.php?id=<?php echo $row['m_mac_id'] ?>','popUpWindow','height=400,width=600,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">ปิดงานเคสงาน</a></li>
                                                                    <?php } ?> 
                                                                <?php } ?>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
 <!--Start Modal Status TECH-->
 <div class="modal fade" id="Status_Tech" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">สถานะงานช่าง</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <?php
       $query = "SELECT * ,COUNT(tasker.task_id) AS takerCount
       FROM tasker
       LEFT JOIN technician ON tasker.tc_id = technician.tc_id
       WHERE tasker.task_status = 'กำลังทำงาน'
       GROUP BY tasker.tc_id
       ORDER BY tasker.tc_id ASC
        " or die("Error:" . mysqli_error());
        $taker = mysqli_query($con, $query); 
      ?>
      <table class="table table-sm table-bordered border-dark">
        <thead class="table-active">
            <tr class="text-center">
            <th scope="col-1">รหัสช่าง</th>
            <th scope="col-3">ชื่อ</th>
            <th scope="col-3">ชื่อเล่น</th>
            <th scope="col-3">ช่าง</th>
            <th scope="col-2">จำนวนงาน</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($taker as $taker){?>
                <tr>
                <td class="text-center"><?php echo $taker['tc_id']; ?></td>
                <th><?php echo $taker['tc_name']; ?></th>
                <th><?php echo $taker['tc_nickname']; ?></th>
                <th><?php echo $taker['tc_depart']; ?></th>
                <td class="text-center"><?php echo $taker['takerCount']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
        </table>

        
        <hr>
        <?php 
            $queryWork2 = "SELECT * 
            FROM technician
            WHERE NOT technician.tc_id IN (SELECT tc_id FROM tasker WHERE task_status = 'กำลังทำงาน')
            " or die("Error:" . mysqli_error());
            $listwork = mysqli_query($con, $queryWork2);
        ?>
        <table class="table table-sm table-bordered border-dark">
            <tr></tr>
        <thead class="table-active">
            <tr class="text-center">
                <th scope="col-1">รหัสช่าง</th>
                <th scope="col-3">ชื่อ</th>
                <th scope="col-3">ชื่อเล่น</th>
                <th scope="col-3">ช่าง</th>
                <th scope="col-2">สถานะ</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listwork as $listwork){?>
                <tr>
                <td class="text-center"><?php echo $listwork['tc_id']; ?></td>
                <th><?php echo $listwork['tc_name']; ?></th>
                <th><?php echo $listwork['tc_nickname']; ?></th>
                <th><?php echo $listwork['tc_depart']; ?></th>
                <td class="text-center">ว่าง</td>            
                </td>
                </tr>
            <?php } ?>
        </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--End Modal -->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

            </div>
        </div>
    </div>
   
    <?php include '../footer.php';?>
    <script src="../dist/js/lightbox-plus-jquery.min.js"></script>
</body>
</html>
<script>
var slider = document.getElementById("myRange");
var output = document.getElementById("demo");
output.innerHTML = slider.value;

slider.oninput = function() {
  output.innerHTML = this.value;
}
</script>