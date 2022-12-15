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
                        <h5>ค้นหาการรับงานช่าง</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <?php 
                                    include('connect_sqli.php'); 
                                    $query = "SELECT * FROM technician " or die("Error:" . mysqli_error());
                                    $technic = mysqli_query($con, $query);
                                ?>
                                <form action="" method="GET">
                                    <div class="input-group mb-3">
                                        <select class="form-select" name="search" aria-label="Default select example">
                                            <option selected><?php if(isset($_GET['search'])){echo $_GET['search']; } ?></option>
                                            <?php foreach($technic as $technic){?>
                                            <option value="<?php echo $technic['tc_name'] ?>"><?php echo $technic['tc_name'] ?></option>
                                            <?php } ?>
                                        </select>
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
                                    <th class="col-auto">รหัสแจ้งซ่อม</th>
                                    <th class="col-auto">ช่าง</th>
                                    <th class="col-auto">สถานะ</th>
                                    <th class="col-auto">ประเมิน</th>
                                    <th class="col-auto">วันที่</th>
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
                                            $where .= " AND CONCAT(tasker.tc_id,tc_name,tc_nickname) LIKE '%$filtervalue%'";
                                        } else {
                                            unset ($filtervalue);
                                        }

                                        $query = "SELECT * 
                                            FROM technician
                                            INNER JOIN tasker ON technician.tc_id = tasker.tc_id
                                            WHERE technician.tc_id = tasker.tc_id {$where}
                                            LIMIT 50
                                                 ";
                                        $row = mysqli_query($con, $query);

                                        if(mysqli_num_rows($row) > 0)
                                        {
                                            foreach ($row as $item)
                                            {
                                                ?>
                                                 <tr>
                                                    <td class="text-center"><?= $item['task_id']; ?></td>
                                                    <td class="text-center"><?= $item['m_id']; ?></td>
                                                    <td><?= $item['tc_name']; ?></td>
                                                    <td><?= $item['task_status']; ?></td>
                                                    <td><?= $item['task_score']; ?></td>
                                                    <td><?= $item['date_task']; ?></td>
                                                    <td><button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#more<?php echo $item['m_id']?>">เพิ่มเติม</button></td>
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