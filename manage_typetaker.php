<?php 
session_start();
include('connect_sqli.php');
include_once ('functions-maint.php');

$Catedata = new DB_con();

if (isset($_POST['submitCate'])){
    $c_name = $_POST['c_name'];

    $sql = $Catedata->addCate($c_name);

    if ($sql){
        echo "<script>alert('เพิ่มข้อมูลสำเร็จ !');</script>";
        echo "<script>window.location.href='manage_typetaker.php'</script>";
    } else{
        echo "<script>alert('เพิ่มข้อมูลไม่สำเร็จ ลองใหม่อีกครั้ง !!');</script>";
        echo "<script>window.location.href='manage_typetaker.php'</script>";
    }
} 

$SubTaskdata = new DB_con();

if (isset($_POST['submitSubtask'])){
    $st_name = $_POST['st_name'];

    $sql = $SubTaskdata->addSubtask($st_name);

    if ($sql){
        echo "<script>alert('เพิ่มข้อมูลสำเร็จ !');</script>";
        echo "<script>window.location.href='manage_typetaker.php'</script>";
    } else{
        echo "<script>alert('เพิ่มข้อมูลไม่สำเร็จ ลองใหม่อีกครั้ง !!');</script>";
        echo "<script>window.location.href='manage_typetaker.php'</script>";
    }
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
    <script src="js/fa_icon.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="dist/css/lightbox.min.css">
</head>
<body>
<?php include 'navbar.php' ?>
    <div class="container-fluid">
        <div class="p-1 mt-2">
            <div class="card p-1">
                <div class="row p-3">
 <!--------------------------------------------- Start Card List Categories------------------------------------------------------------------------------------>
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xxl-6">
                    <div class="card shadow p-4 mb-4 bg-white">
                        <div class="row ps-3">
                        <div class="col-12">
                            
                            <form method="post"  class="row g-1">
                                <div class="col-sm-12 col-md-5 col-lg-5 col-xxl-5">
                                <input type="text" class="form-control" name="c_name"  placeholder="ประเภทงาน...." required>
                                </div>
                                <div class="col-sm-12 col-md-1 col-lg-1 col-xxl-1">
                                <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary" name="submitCate"><i class="fas fa-plus">&nbsp;เพิ่ม</i></button>
                                </div>
                                </div>
                            </form>
                        </div>
                        </div>
                        <div class="card-body">
                        <h5>รายการประเภทงาน</h5>
                        <table class="table table-sm table-hover table-bordered">
                            <tr class="text-center">
                            <th>รหัส</th>  
                            <th>ประเภทงาน</th>  
                            <th>จัดการ</th>  
                            </tr>
                            <?php
                        //Getting default page number
                            if (isset($_GET['pageno'])) {
                                $pageno = $_GET['pageno'];
                                } else {
                                $pageno = 1;
                                }
                        // Formula for pagination  
                                $no_of_records_per_page = 10;
                                $offset = ($pageno-1) * $no_of_records_per_page;
                        // Getting total number of pages
                                $total_pages_sql = "SELECT COUNT(*) FROM categories";
                                $result = mysqli_query($con,$total_pages_sql);
                                $total_rows = mysqli_fetch_array($result)[0];
                                $total_pages = ceil($total_rows / $no_of_records_per_page);
                                $sql = "SELECT * FROM categories LIMIT $offset, $no_of_records_per_page";
                                $res_data = mysqli_query($con,$sql);
                                $cnt=1;
                                while($row = mysqli_fetch_array($res_data)){?>

                            <tr>
                            <td class="text-center"><?php echo $row['c_id'];?></td>
                            <td><?php echo $row['c_name'];?></td>
                            <td class="text-center col-1"><button type="button" name="submitstatus" id="submitstatus" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editCate<?php echo $row['c_id'];?>"><i class="far fa-edit">&nbsp;แก้ไข</i></button></td>
                            </tr>
                            <div class="modal fade" id="editCate<?php echo $row['c_id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <form method="POST" enctype="multipart/form-data" action="update-categories.php">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">แก้ไขรายการประเภทงาน #<?php echo $row['c_id'];?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">แผนก</span>
                                        <input type="hidden" class="form-control" name="c_id" value="<?php echo $row['c_id'];?>">
                                        <input type="text" class="form-control" name="c_name" value="<?php echo $row['c_name'];?>" placeholder="ประเภทงาน...." required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="editCate" class="btn btn-primary">ยืนยัน</button>
                                     </form>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                                    </div>
                                    </div>
                                </div>
                            </div> 

                            <?php $cnt++; } ?>
                        </table>
                            <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item"><a class="page-link" href="?pageno=1">หน้าแรก</a></li>
                                <li class="page-item <?php if($pageno <= 1){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">ก่อนหน้า</a></li>
                                <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">ถัดไป</a></li>
                                <li class="page-item"><a class="page-link"href="?pageno=<?php echo $total_pages; ?>">สุดท้าย</a></li>
                            </ul>
                            </nav>
                        </div>
                        </div>
                    </div>
<!----------------------------------------------------------- End Card List Categories------------------------------------------------------------------------------------>
<!----------------------------------------------------------- Start Card List SubTask------------------------------------------------------------------------------------>
<div class="col-sm-12 col-md-12 col-lg-6 col-xxl-6">
                    <div class="card shadow p-4 mb-4 bg-white">
                        <div class="row ps-3">
                        <div class="col-12">
                            
                            <form method="post"  class="row g-1">
                                <div class="col-sm-12 col-md-5 col-lg-5 col-xxl-5">
                                <input type="text" class="form-control" name="st_name"  placeholder="ประเภทงานย่อย...." required>
                                </div>
                                <div class="col-sm-12 col-md-1 col-lg-1 col-xxl-1">
                                <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary" name="submitSubtask"><i class="fas fa-plus">&nbsp;เพิ่ม</i></button>
                                </div>
                                </div>
                            </form>
                        </div>
                        </div>
                        <div class="card-body">
                        <h5>รายการประเภทงานย่อย</h5>
                        <table class="table table-sm table-hover table-bordered">
                            <tr class="text-center">
                            <th>รหัส</th>  
                            <th>ประเภทงานย่อย</th>  
                            <th>จัดการ</th>  
                            </tr>
                            <?php
                        //Getting default page number
                            if (isset($_GET['pageno'])) {
                                $pageno = $_GET['pageno'];
                                } else {
                                $pageno = 1;
                                }
                        // Formula for pagination  
                                $no_of_records_per_page = 10;
                                $offset = ($pageno-1) * $no_of_records_per_page;
                        // Getting total number of pages
                                $total_pages_sql = "SELECT COUNT(*) FROM subtasks";
                                $result = mysqli_query($con,$total_pages_sql);
                                $total_rows = mysqli_fetch_array($result)[0];
                                $total_pages = ceil($total_rows / $no_of_records_per_page);
                                $sql = "SELECT * FROM subtasks LIMIT $offset, $no_of_records_per_page";
                                $res_data = mysqli_query($con,$sql);
                                $cnt=1;
                                while($row = mysqli_fetch_array($res_data)){?>

                            <tr>
                            <td class="text-center"><?php echo $row['st_id'];?></td>
                            <td><?php echo $row['st_name'];?></td>
                            <td class="text-center col-1"><button type="button" name="submitstatus" id="submitstatus" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editST<?php echo $row['st_id'];?>"><i class="far fa-edit">&nbsp;แก้ไข</i></button></td>
                            </tr>
                            <div class="modal fade" id="editST<?php echo $row['st_id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <form method="POST" enctype="multipart/form-data" action="update-subtask.php">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">แก้ไขรายการประเภทงานย่อย #<?php echo $row['st_id'];?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">แผนก</span>
                                        <input type="hidden" class="form-control" name="st_id" value="<?php echo $row['st_id'];?>">
                                        <input type="text" class="form-control" name="st_name" value="<?php echo $row['st_name'];?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="editST" class="btn btn-primary">ยืนยัน</button>
                                     </form>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                                    </div>
                                    </div>
                                </div>
                            </div> 

                            <?php $cnt++; } ?>
                        </table>
                            <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item"><a class="page-link" href="?pageno=1">หน้าแรก</a></li>
                                <li class="page-item <?php if($pageno <= 1){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">ก่อนหน้า</a></li>
                                <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>"><a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">ถัดไป</a></li>
                                <li class="page-item"><a class="page-link"href="?pageno=<?php echo $total_pages; ?>">สุดท้าย</a></li>
                            </ul>
                            </nav>
                        </div>
                        </div>
                    </div>
<!----------------------------------------------------------- End Card List SubTask------------------------------------------------------------------------------------>
                </div>
            
            </div>
        </div>
    </div>  
<?php include 'footer.php';?>
    
</body>
</html>