<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search List</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/fa_icon.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="dist/css/lightbox.min.css">
</head>
<body>
<?php include 'navbar.php' ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>ค้นหารายการแจ้งซ่อมที่ต้องการ</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">

                                <form action="" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control"  name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" placeholder="ค้นหารายการ ด้วย ชื่อ / แผนก / ประเภทงาน หรือ สถานะงาน" >
                                        <button type="submit" class="btn btn-primary">ค้นหา</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="table-responsive-md">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th class="col-auto">#</th>
                                    <th class="col-auto">ผู้แจ้ง</th>
                                    <th class="col-auto">แผนก</th>
                                    <th class="col-auto">ประเภทงาน</th>
                                    <th class="col-auto">หมวดงาน</th>
                                    <th class="col-4">อาการ</th>
                                    <th class="col-auto">ผู้รับงาน</th>
                                    <th class="col-auto">สถานะงาน</th>
                                    <th class="col-auto">ความยาก</th>
                                    <th class="col-auto">วันที่รับงาน</th>
                                    <th class="col-auto">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $con = mysqli_connect("localhost","root","rootroot","mtservice");

                                    if(isset($_GET['search']))
                                    {
                                        
                                        $filtervalue = $_GET['search'];
                                        $nolimit = 50;
                                        $where ="";
                                        if ($filtervalue){
                                            $where .= " AND CONCAT(m_user,m_admin,m_status,c_name,depart_sub_name,st_name) LIKE '%$filtervalue%'";
                                        } else {
                                            unset ($filtervalue);
                                        }

                                        $query = "SELECT * 
                                            FROM 
                                                maintenance
                                            INNER JOIN 
                                                depart ON maintenance.m_depart_id = depart.depart_id 
                                            INNER JOIN 
                                                categories ON maintenance.m_c_id = categories.c_id
                                            RIGHT JOIN 
                                                subtasks ON maintenance.m_st_id = subtasks.st_id
                                            WHERE
                                                maintenance.m_id > 0
                                                {$where}
                                            ORDER BY m_id DESC
                                            LIMIT 50
                                                 ";
                                        $row = mysqli_query($con, $query);

                                        if(mysqli_num_rows($row) > 0)
                                        {
                                            foreach ($row as $item)
                                            {
                                                ?>
                                                 <tr <?php if($item['check_status'] == 'ยกเลิก') { ?> class="alert alert-danger"<?php } ?>>
                                                    <td class="text-center"><?= $item['m_id']; ?></td>
                                                    <td class="text-center"><?= $item['m_user']; ?></td>
                                                    <td><?= $item['depart_sub_name']; ?></td>
                                                    <td><?= $item['c_name']; ?></td>
                                                    <td><?= $item['st_name']; ?></td>
                                                    <td><?= $item['m_issue']; ?></td>
                                                    <td><?= $item['m_admin']; ?></td>
                                                    <td>
                                                        <?php if($item['check_status'] == 'ยกเลิก') { 
                                                            echo 'ยกเลิก';
                                                        }else{
                                                            echo $item['m_status'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center"><?= $item['m_rate']; ?></td>
                                                    <td class="text-center"><?= $item['ap_datetime']; ?></td>
                                                    <td class="text-center"><button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#more<?php echo $item['m_id']?>">เพิ่มเติม</button></td>
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
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                                <tr>
                                                    <td class="text-center" colspan="12">
                                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                            <strong>ไม่เจอข้อมูลที่ท่านต้องการ<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php
                                        }

                                        
                                    }
                                ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php include 'footer.php';?>
</body>
</html>