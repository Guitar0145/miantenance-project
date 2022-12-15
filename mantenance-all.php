<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบแจ้งซ่อมบำรุง</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/fa_icon.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    </head>
    
<body>
<?php include 'navbar.php' ?>
    <div class="container-fluid">
        <div class="p-3 mt-3">
            <div class="card p-3">
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->              
                <div class="row">
                    <div class="col-12">
                        <div class="card-header bg-success text-white">
                            รายการแจ้งซ่อมทั้งหมด
                        </div>
                        <div class="card-body shadow p-4 mb-4 bg-white">
                        <div class="table-responsive-lg">
                        <table id="myTable" class="cell-border table-sm p-1" style="font-size:13px;">
                            <thead class="sticky-top" style="background-color: #0067B8;color:#fff;">
                                <tr class="text-center">
                                    <th class="col-auto">#</th>
                                    <th class="col-auto">ผู้แจ้ง</th>
                                    <th class="col-auto">แผนก</th>
                                    <th class="col-auto">ประเภทงาน</th>
                                    <th class="col-4">อาการ</th>
                                    <th class="col-auto">ผู้รับงาน</th>
                                    <th class="col-auto">สถานะงาน</th>
                                    <th class="col-auto">วันที่รับงาน</th>
                                    <th class="col-auto">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $con = mysqli_connect("localhost","root","rootroot","mtservice");
                                        $query = "SELECT * FROM maintenance
                                            INNER JOIN depart ON maintenance.m_depart_id = depart.depart_id 
                                            INNER JOIN categories ON maintenance.m_c_id = categories.c_id
                                            RIGHT JOIN subtasks ON maintenance.m_st_id = subtasks.st_id
                                            WHERE maintenance.m_id > 0
                                            ORDER BY m_datetime DESC ";
                                        $row = mysqli_query($con, $query);
                                        if(mysqli_num_rows($row) > 0)
                                        { foreach ($row as $item) { ?>

                                                <?php
                                                $m_id_count = $item['m_id'];
                                                $sql="SELECT * FROM tasker WHERE m_id =  $m_id_count and task_status = 'ทำงานเสร็จสิ้น'";
                                                if ($result=mysqli_query($con,$sql))
                                                {
                                                    $countEnd=mysqli_num_rows($result);
                                                    mysqli_free_result($result);
                                                }
    
                                                $sql2 = "SELECT * FROM tasker WHERE m_id = $m_id_count ";
                                                if ($result2=mysqli_query($con,$sql2))
                                                {
                                                    $countPer=mysqli_num_rows($result2);
                                                    mysqli_free_result($result2);
                                                }
                                                $sql2 = "SELECT * FROM tasker WHERE m_id = $m_id_count ";
                                                if ($result2=mysqli_query($con,$sql2))
                                                {
                                                    $countPer=mysqli_num_rows($result2);
                                                    mysqli_free_result($result2);
                                                }
                                            ?>

                                                 <tr <?php if($item['check_status'] == 'ยกเลิก') { ?> style="color:red;"<?php } ?>>
                                                    <td class="text-center"><?= $item['m_id']; ?></td>
                                                    <td><?= $item['m_user']; ?></td>
                                                    <td><?= $item['depart_sub_name']; ?></td>
                                                    <td><?= $item['st_name']; ?>/<?= $item['c_name']; ?></td>
                                                    <td><?= $item['m_issue']; ?></td>
                                                    <td><?= $item['m_admin']; ?></td>
                                                    <td><?php if($item['check_status'] == 'ยกเลิก') { 
                                                            echo 'ยกเลิก';
                                                        }else{
                                                            echo $item['m_status'];
                                                        }
                                                        ?></td>
                                                    <td class="text-center"><?= $item['ap_datetime']; ?></td>
                                                    <td class="text-center">
                                                    <div class="btn-group">
                                                    <button type="button" class="p-2 badge btn bg-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">จัดการ</button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#" onclick="window.open(this.href='task-detailAll.php?id=<?php echo $item['m_id'] ?>','popUpWindow','height=600,width=1000,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">ดูเพิ่มเติม</a></li>

                                                        <?php if($item['m_status'] != 'เสร็จสิ้น') { ?>
                                                            <?php if($_SESSION['level'] == 'Admin' ) {?>
                                                                <?php if($item['check_status'] == 'ตรวจสอบแล้ว') { ?>
                                                                <li><a class="dropdown-item" href="#" onclick="window.open(this.href='task-manage.php?id=<?php echo $item['m_id'] ?>','popUpWindow','height=400,width=700,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">จ่ายงานช่าง (<?php echo $countPer; ?>)</a></li>
                                                                <?php } ?>
                                                                <?php if($countPer ==! 0 ) {?>
                                                                    <li><hr class="dropdown-divider"></li>
                                                                    
                                                                    <?php if($item['user_check'] == 'YES') {?>
                                                                    <li><a class="dropdown-item" href="#" onclick="window.open(this.href='update-tasker.php?m_id=<?php echo $item['m_id'] ?>','popUpWindow','height=400,width=500,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">ปิดงานช่าง</a></li>
                                                                    <?php } ?>
                                                                    
                                                                    <?php if($countPer == $countEnd) {?>
                                                                    <li><a class="dropdown-item" href="#" onclick="window.open(this.href='approved_status_end.php?id=<?php echo $item['m_id'] ?>','popUpWindow','height=400,width=600,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">ปิดงานเคสงาน</a></li>
                                                                    <?php } ?>
                                                                
                                                                    <?php } ?>
                                                            <?php } ?>

                                                            <?php if($_SESSION['level'] == 'User' ) {?>
                                                                <?php if($item['user_check'] == 'NO') {?>
                                                                    <li><a class="dropdown-item" href="#" onclick="window.open(this.href='user_check.php?id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=400,width=600,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">ยืนยันตรวจสอบ</a></li>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        </ul>
                                                    </div>
                                                
                                                    </td>
                                                </tr>
                                                <!--Start Modal See More-->
                                                <div class="modal fade" id="more<?php echo $item['m_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">รายละเอียด การแจ้งซ่อมที่ #<?php echo $item['m_id'] ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        ...
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <!--End Modal See More -->
                                                <?php
                                            }} else { ?>
                                                <tr>
                                                    <td class="text-center" colspan="12">
                                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                            <strong>ไม่เจอข้อมูลที่ท่านต้องการ<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
    $('#myTable').DataTable();
        } );
    </script>
    <?php include 'footer.php';?>
</body>
</html>