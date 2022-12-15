<?php


    session_start();

    $error = "";
    isset( $_POST['username'] ) ? $username = $_POST['username'] : $username = "";
    isset( $_POST['password'] ) ? $password = $_POST['password'] : $password = "";
    if( !empty( $username ) && !empty( $password ) ) {
        $c = mysqli_connect( "localhost", "root", "rootroot", "mtservice" );
        mysqli_query( $c, "SET NAMES UTF8" );
        $sql = " 
                SELECT * FROM user 
                WHERE 
                ( username = '{$username}' ) AND  
                ( password = '{$password}' ) 
            ";
        $q = mysqli_query( $c, $sql );
        $f = mysqli_fetch_assoc( $q );
        if( isset( $f['u_id'] ) ) {
            $_SESSION['u_id'] = $f['u_id'];
            $_SESSION['username'] = $f['username'];
            $_SESSION['u_name'] = $f['u_name'];
            $_SESSION['level'] = $f['level'];
        } else {
            echo "<script>alert('Login ไม่สำเร็จ !');</script>";
            echo "<script>window.location.href='index.php'</script>";
        }
        mysqli_close( $c );
    }

    include_once ('functions-maint.php');

    $maintdata = new DB_con();
    if (isset($_POST['submit'])){
    $m_user = $_POST['m_user'];
    $m_depart_id = $_POST['m_depart_id'];
    $m_c_id = $_POST['m_c_id'];
    $m_st_id = $_POST['m_st_id'];
    $m_urgency = $_POST['m_urgency'];
    $m_issue = $_POST['m_issue'];
    $check_status = $_POST['check_status'];
    $photo = $_POST['photo'];


    $sql = $maintdata->addmaint($m_user, $m_depart_id, $m_c_id, $m_st_id, $m_urgency, $m_issue, $check_status, $photo);

            if ($sql){
                echo "<script>alert('แจ้งซ่อมสำเร็จ !');</script>";
                echo "<script>window.location.href='index.php'</script>";
            } else{
                echo "<script>alert('แจ้งซ่อมไม่สำเร็จ ลองใหม่อีกครั้ง !!');</script>";
                echo "<script>window.location.href='index.php'</script>";
            }
    }
?>
<?php
        date_default_timezone_set("Asia/Bangkok");
        include('connect_sqli.php'); 
        $query = "SELECT * FROM categories ORDER BY c_id " or die("Error:" . mysqli_error());
        $cate = mysqli_query($con, $query);

        $query3 = "SELECT * FROM subtasks ORDER BY st_id " or die("Error:" . mysqli_error());
        $subt= mysqli_query($con, $query3);

        $query2 = "SELECT * FROM depart ORDER BY depart_id " or die("Error:" . mysqli_error());
        $depart = mysqli_query($con, $query2);   
        
        $sql = "SELECT * FROM `switch` WHERE switch_name = 'ระดับความยากดาว' ";
        $sql_query = mysqli_query($con,$sql);
        $switchRate = mysqli_fetch_all($sql_query,MYSQLI_ASSOC);
    
        $sql = "SELECT * FROM `switch` WHERE switch_name = 'Time Limit (ย้อนหลัง)' ";
        $sql_query = mysqli_query($con,$sql);
        $switchTime = mysqli_fetch_all($sql_query,MYSQLI_ASSOC);
?>
<?php
    $con = mysqli_connect("localhost","root","rootroot","mtservice");
    $sqlSwitch = "SELECT * FROM `switch` WHERE switch_id = '1' ";
    $Sql_querySwitch = mysqli_query($con,$sqlSwitch);
    $rowSwitch = mysqli_fetch_all($Sql_querySwitch,MYSQLI_ASSOC);
?>
<?php 
    $con=mysqli_connect("localhost","root","rootroot","mtservice");
    if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $sql="SELECT *
    FROM tasker
    WHERE task_status = 'ทำงานเสร็จสิ้น'";
    if ($result=mysqli_query($con,$sql))
    {
    $countSuccess=mysqli_num_rows($result);
    mysqli_free_result($result);
    }
?>
<?php 
//เขียนแบบ PDO 
$servername = "localhost";
$username = "root";
$password = "rootroot";

try {
  $connect = new PDO("mysql:host=$servername;dbname=mtservice", $username, $password);
  // set the PDO error mode to exception
  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 // echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
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
    <link rel="stylesheet" href="dist/css/lightbox.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
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
    <?php include 'navbar.php' ?>
    <div class="container-fluid">
        <div class="p-1 mt-2">
            <div class="card p-1">
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="button" class="btn btn-warning shadow my-1 mx-1" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><i class="fas fa-cogs"></i>&nbsp;แจ้งซ่อมทั่วไป</button>
                <a class="btn btn-info shadow my-1 mx-1" href="machine/repair-machine.php"><i class="fas fa-cogs"></i>&nbsp;แจ้งซ่อมเครื่องจักร</a>
                <?php if($_SESSION['level'] == 'Admin' ) {?>
                <button type="button" class="btn btn-info shadow my-1 mx-1" data-bs-toggle="modal" data-bs-target="#Status_Tech" data-bs-whatever="@mdo"><i class="fas fa-cogs"></i>&nbsp;สถานะช่าง</button>
                <?php } ?>
            </div><br>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->              
                <div class="row">
                    <div class="col-12">

                        <div class="card-header bg-secondary text-white" style="font-weight: bold;">
                            รายการแจ้งทั่วไปที่รอตรวจสอบ
                        </div>
                        <div class="card-body shadow mb-2 bg-white">
                            <div class="table-responsive-md">
                                <table class="table table-sm table-bordered">
                                    <thead class="text-center">
                                        <th class="col-auto">#</th>
                                        <th class="col-auto">ผู้แจ้ง</th>
                                        <th class="col-auto">แผนก</th>
                                        <th class="col-auto text-center">ประเภทงาน</th>
                                        <th class="col-auto text-center">ประเภทย่อย</th>
                                        <th class="col-3 text-center">อาการ</th>
                                        <th class="col-auto text-center">รูปภาพ</th>
                                        <th class="col-auto text-center">ความเร่งด่วน</th>
                                        <th>วันที่แจ้งงาน</th>
                                        <th class="col-auto text-center">รอตรวจสอบ</th>
                                        <th class="col-auto text-center">จัดการ</th>
                                    </thead> 
                                    <tbody style="font-size: 14px;">
                                        <?php
                                            $listcheck = $connect->query("SELECT *
                                            FROM maintenance
                                            INNER JOIN depart ON maintenance.m_depart_id = depart.depart_id 
                                            INNER JOIN categories ON maintenance.m_c_id = categories.c_id
                                            RIGHT JOIN subtasks ON maintenance.m_st_id = subtasks.st_id
                                            WHERE check_status = 'รอตรวจสอบ'
                                            ");
                                            $listcheck->execute();

                                            $maint = $listcheck->fetchAll();
                                            foreach ($maint as $listall){

                                            $datetime_start = $listall['m_datetime'];
                                            $datetime_end = date("Y-m-d H:i:s");
                                            $seconds = strtotime($datetime_end) - strtotime($datetime_start);
                                            $sum += $seconds;

                                            $days    = floor($seconds / 86400);
                                            $hours   = floor(($seconds - ($days * 86400)) / 3600);
                                            $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
                                            $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));
                                        ?>
                                        <tr>
                                            <td class="text-center" width="5%"><?php echo $listall['m_id'] ?></td>
                                            <td class="text-center"><?php echo $listall['m_user'] ?></td>
                                            <td ><?php echo $listall['depart_sub_name'] ?></td>
                                            <td><?php echo $listall['c_name'] ?></td>
                                            <td><?php echo $listall['st_name'] ?></td>
                                            <td><?php echo $listall['m_issue'] ?></td>
                                            <td class="text-center">
                                                <a class="example-image-link" href="<?php echo $listall['photo'] ?>" data-lightbox="example-set" data-title="<?php echo $listall['m_issue'] ?>">
                                                <img class="example-image" src="<?php echo $listall['photo'] ?>"  width="70" height="70">
                                                </a>
                                            </td>
                                            <td>
                                            <?php
                                                $urgency = $listall['m_urgency'];
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
                                            <td class="text-center"><?php echo $listall['m_datetime'] ?></td>
                                            <td class="text-center">
                                                <?php echo $days." วัน ".$hours." ชั่วโมง "; ?>
                                            </td>
                                            <td  class="col-1 text-center">
                                            <form>
                                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                    <button type="button" name="editIssue" id="editIssue" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editIssue<?php echo $listall['m_id']?>"><i class="fas fa-edit"></i></button>
                                                    <?php if($_SESSION['level'] == 'Admin' ) {?>
                                                        <button type="submit" name="submitstatus" id="submitstatus" class="btn btn-outline-primary" onclick="window.open(this.href='approved_status.php?id=<?php echo $listall['m_id'] ?>','popUpWindow','height=400,width=600,left=200,top=200,,scrollbars=yes,menubar=no'); return false;" >รับงาน</button>
                                                    <?php } ?>
                                                    <button type="button" name="submitstatus" id="submitstatus" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#edit<?php echo $listall['m_id']?>">รูป&nbsp;<i class="fas fa-file-image"></i></button>
                                                </div>
                                            </form>
                                            </td>
<!-----------------------------------------------------------------------------------------------Start Modal Issue Update--------------------------------------------------------------------------->
                                    <div class="modal fade" id="editIssue<?php echo $listall['m_id']?>" aria-hidden="true">                      
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="POST" enctype="multipart/form-data" action="edit-issue.php">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">แก้ไขอาการแจ้งซ่อม # <?php echo $listall['m_id']; ?></h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="col"></div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <input type="hidden" value="<?php echo $listall['m_id']?>" name="m_id"/>
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text">อาการ</span>
                                                                <textarea class="form-control" rows="4" name="m_issue" aria-label="With textarea" required="required"><?php echo $listall['m_issue']?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br style="clear:both;"/>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-warning" name="editIssue"><span class="glyphicon glyphicon-save"></span>ยืนยัน</button>
                                                        </form>
                                                        <button class="btn btn-danger" data-bs-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>ปิด</button>
                                                    </div> 
                                            </div>
                                        </div>
                                    </div>
<!-----------------------------------------------------------------------------------------------End Modal Issue Update--------------------------------------------------------------------------->

<!--------------------------------------------------------------------------------------Open Modal Update IMG ----------------------------------------------------------------------------------->
                                    <div class="modal fade" id="edit<?php echo $listall['m_id']?>" aria-hidden="true">                      
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="POST" enctype="multipart/form-data" action="upload-img.php">
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
                                                                <img src="<?php echo $listall['photo']?>" height="200" width="auto" />
                                                                </div>
                                                                <input type="hidden" name="previous" value="<?php echo $listall['photo']?>"/>
                                                                <hr>
                                                                <h5>รูปภาพใหม่</h5>
                                                                <input type="file" class="form-control" name="photo" value="<?php echo $listall['photo']?>" required="required"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="hidden" value="<?php echo $listall['m_id']?>" name="m_id"/>
                                                                <input type="hidden" class="form-control" value="<?php echo $listall['m_user']?>" name="m_user" required="required"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="hidden" class="form-control" value="<?php echo $listall['m_issue']?>" name="m_issue" required="required"/>
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
                                    </tr>     
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>    
                        </div>
                    </div>
                </div>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                <div class="row">
                    <?php foreach ($switchRate as $switchRate ) { $status_switchRate = $switchRate['status']; } ?>
                    <?php foreach ($switchTime as $switchTime ) { $status_switchTime = $switchTime['status']; } ?>
<!----------------------------------------------------------------------- รายการคิวแจ้งซ่อมโปรเจค ------------------------------------------------------------------------------------->
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xxl-12">
                        <div class="card-header bg-secondary text-white">
                            รายการตรวจสอบแล้ว รอดำเนินการ
                        </div>
                        <div class="card-body shadow mb-2 bg-white">
                        <div class="table-responsive-md">
                                <table class="table table-hover table-bordered" style="font-size:14px;">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="col-auto">#</th>
                                            <th colspan="2" class="col-auto">ผู้แจ้ง/แผนก</th>
                                            <th class="col-auto">ประเภทงาน</th>
                                            <th class="col-auto">ประเภทงานย่อย</th>
                                            <th class="col-4">ปัญหา</th>
                                            <th class="col-auto">รูปภาพ</th>
                                            <th class="col-auto">ความเร่งด่วน</th>
                                            <th class="col-auto">ตรวจสอบ</th>
                                            <th class="col-auto">ความยาก</th>
                                            <th class="col-1">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $listelectric = $connect->query("SELECT *
                                        FROM maintenance
                                        INNER JOIN depart ON maintenance.m_depart_id = depart.depart_id 
                                        INNER JOIN categories ON maintenance.m_c_id = categories.c_id
                                        RIGHT JOIN subtasks ON maintenance.m_st_id = subtasks.st_id
                                        WHERE (c_name = 'รอดำเนินการ' AND check_status = 'ตรวจสอบแล้ว' AND user_check = 'NO') AND (m_status ='กำลังดำเนินการ' OR m_status = 'รอสินค้า-อะไหล่')
                                        ");
                                        $listelectric->execute();
                                        $electric = $listelectric->fetchAll();
                                        foreach ($electric as $listelect){
                                        $m_id_count = $listelect['m_id'];
                                        ?>
                                    
                                        <?php
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
                                            $sql3 = "SELECT * FROM purchase WHERE m_id = $m_id_count ";
                                                if ($result3=mysqli_query($con,$sql3))
                                                {
                                                    $countOrders=mysqli_num_rows($result3);
                                                    mysqli_free_result($result3);
                                                }

                                                $sql4 = "SELECT * FROM purchase WHERE m_id = $m_id_count AND pr_status = 'กำลังรอสินค้า' ";
                                                if ($result4=mysqli_query($con,$sql4))
                                                {
                                                    $TaskerStatus=mysqli_num_rows($result4);
                                                    mysqli_free_result($result4);
                                                }
                                                $sql5 = "SELECT * FROM working WHERE m_id = $m_id_count AND status_work = 'กำลังทำงาน' ";
                                                if ($result5=mysqli_query($con,$sql5))
                                                {
                                                $countWorking=mysqli_num_rows($result5);
                                                mysqli_free_result($result5);
                                                }
                                        ?>

                                        
                                        <tr>
                                            <th class="text-center" ><?php echo $m_id_count ?></th>
                                            <td colspan="2"><?php echo $listelect['m_user'] ?>/<?php echo $listelect['depart_sub_name'] ?></td>
                                            <td><?php echo $listelect['c_name'] ?></td>
                                            <td><?php echo $listelect['st_name'] ?></td>
                                            <td><?php echo $listelect['m_issue'] ?></td>
                                            <td class="text-center"><a class="example-image-link" href="<?php echo $listall['photo'] ?>" data-lightbox="example-set" data-title="<?php echo $listall['m_issue'] ?>">คลิกเพื่อดูรูป</a></td>
                                            <td>
                                                <?php
                                                    $urgency = $listelect['m_urgency'];
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
                                            <td class="text-center"><?php echo $listelect ['ap_datetime']; ?></td>
                                            <td class="text-center"><a style="font-weight:bold; color:#000;" class="btn btn-sm btn-outline-warning px-3"><?php echo $listelect['m_rate'] ?>&nbsp;<i class="fas fa-star gold"></i></td>
                                            
                                            <td class="text-center">
                                                <!--------------- Button Group Pannel---------------->
                                                <div class="btn-group">
                                                    <button type="button" class="p-1 badge btn bg-primary dropdown-toggle position-relative" data-bs-toggle="dropdown" aria-expanded="false">จัดการ</button>
                                                    <?php if($_SESSION['level'] == 'Admin' ) {?>
                                                        <?php if ($countWorking > 0 ){?>
                                                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#" onclick="window.open(this.href='task-detail.php?id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=600,width=700,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">ดูเพิ่มเติม</a></li>
                                                        <?php if($_SESSION['level'] == 'Admin' ) {?>
                                                            <li><a class="dropdown-item" href="#" name="editIssue2" id="editIssue2" data-bs-toggle="modal" data-bs-target="#editIssue4<?php echo $listelect['m_id']?>">แก้ไข</a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                                <!--------------- Button Group Pannel---------------->
                                            </td>
                                        </tr>
<!-----------------------------------------------------------------------------------------------Start Modal Issue Update--------------------------------------------------------------------------->
                                        <div class="modal fade" id="editIssue4<?php echo $listelect['m_id']?>" aria-hidden="true">                      
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST" enctype="multipart/form-data" action="edit-issue4.php">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">แก้ไขอาการแจ้งซ่อม # <?php echo $listelect['m_id']; ?></h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="col"></div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <input type="hidden" value="<?php echo $listelect['m_id']?>" name="m_id"/>
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-text">อาการ</span>
                                                                    <textarea class="form-control" rows="4" name="m_issue"  required="required"><?php echo $listelect['m_issue']?></textarea>
                                                                </div>

                                                                <div class="input-group mt-2">
                                                                    <span class="input-group-text">ประเภทงาน</span>
                                                                    <?php $strDefault = $listelect['m_c_id']; ?>
                                                                        <select class="form-select" name="m_c_id">
                                                                            <option value=""><-- เลือกประเภทงานซ่อม --></option>
                                                                            <?php
                                                                                $strSQL = "SELECT * FROM categories ORDER BY c_id ASC";
                                                                                $objQuery = mysqli_query($con,$strSQL);
                                                                                while($objResuut = mysqli_fetch_array($objQuery))
                                                                                {
                                                                                    if($strDefault == $objResuut["c_id"])
                                                                                    {
                                                                                        $categories = "selected";
                                                                                    } else
                                                                                    {
                                                                                        $categories = "";
                                                                                    }
                                                                            ?>
                                                                            <option value="<?php echo $objResuut["c_id"];?>" <?php echo $categories;?>><?php echo $objResuut["c_name"];?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                </div>

                                                                <?php if ($status_switchRate == 1) { ?> 
                                                                <div class="input-group mt-2">
                                                                    <span class="input-group-text">ความยาก</span>
                                                                    <input type="number" class="form-control" name="m_rate" min="0" max="10" value="<?php echo $listelect['m_rate']; ?>">
                                                                    <span class="input-group-text">ดาว</span>
                                                                </div>
                                                                <?php }  ?>

                                                                <?php if ($switchTime['status'] == 1) { ?>
                                                                <div class="input-group mt-2">
                                                                    <span class="input-group-text">Time Limit</span>
                                                                    <input type="number" class="form-control" name="times_limit" min="0" value="<?php echo $listelect['times_limit']; ?>">
                                                                    <span class="input-group-text">ชม.</span>
                                                                </div>
                                                                <?php } ?>

                                                            </div>
                                                        </div>
                                                        <br style="clear:both;"/>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-warning" name="editIssue4"><span class="glyphicon glyphicon-save"></span>ยืนยัน</button>
                                                            </form>
                                                            <button class="btn btn-danger" data-bs-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>ปิด</button>
                                                        </div> 
                                                </div>
                                            </div>
                                        </div>
<!-----------------------------------------------------------------------------------------------End Modal Issue Update--------------------------------------------------------------------------->
                                        <?php } ?>
                                    </tbody>
                                </table>  
                            </div>               
                        </div>
                    </div>  
<!----------------------------------------------------------------------------------------------- สิ้นสุดตรวจสอบแล้ว รอ-ช่าง---------------------------------------------------------------------------> 
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xxl-6">
                        <div class="card-header bg-secondary text-white" style="font-weight: bold;">
                            รายการแจ้งซ่อมทั่วไป
                        </div>
                        <div class="card-body shadow mb-2 bg-white">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered" style="font-size:14px;">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="col-auto">#</th>
                                            <th colspan="2" class="col-auto">ผู้แจ้ง/แผนก</th>
                                            <th class="col-4">ปัญหา</th>
                                            <th class="col-auto text-center">ความเร่งด่วน</th>
                                            <th class="col-auto">สถานะงาน</th>
                                            <th class="col-auto">ความยาก</th>
                                            <th class="col-auto">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $listelectric = $connect->query("SELECT *
                                        FROM maintenance
                                        INNER JOIN depart ON maintenance.m_depart_id = depart.depart_id 
                                        INNER JOIN categories ON maintenance.m_c_id = categories.c_id
                                        RIGHT JOIN subtasks ON maintenance.m_st_id = subtasks.st_id
                                        WHERE (c_name = 'ทั่วไป' AND check_status = 'ตรวจสอบแล้ว' AND user_check = 'NO') AND (m_status ='กำลังดำเนินการ' OR m_status = 'รอสินค้า-อะไหล่')
                                        ");
                                        $listelectric->execute();
                                        $electric = $listelectric->fetchAll();
                                        foreach ($electric as $listelect){
                                            $m_id_count = $listelect['m_id'];
                                            ?>
                                        
                                            <?php
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

                                                $sql3 = "SELECT * FROM purchase WHERE m_id = $m_id_count ";
                                                if ($result3=mysqli_query($con,$sql3))
                                                {
                                                    $countOrders=mysqli_num_rows($result3);
                                                    mysqli_free_result($result3);
                                                }

                                                $sql4 = "SELECT * FROM purchase WHERE m_id = $m_id_count AND pr_status = 'กำลังรอสินค้า' ";
                                                if ($result4=mysqli_query($con,$sql4))
                                                {
                                                    $TaskerStatus=mysqli_num_rows($result4);
                                                    mysqli_free_result($result4);
                                                }

                                                $sql5 = "SELECT * FROM working WHERE m_id = $m_id_count AND status_work = 'กำลังทำงาน' ";
                                                if ($result5=mysqli_query($con,$sql5))
                                                {
                                                $countWorking=mysqli_num_rows($result5);
                                                mysqli_free_result($result5);
                                                }
                                            ?>
                                        <tr>
                                            <th class="text-center" style="<?php if($countPer == '0') {?>color:red;<?php } ?>"><?php echo $listelect['m_id'] ?></th>
                                            <td colspan="2"><?php echo $listelect['m_user'] ?>/<?php echo $listelect['depart_sub_name'] ?></td>
                                            <td><?php echo $listelect['m_issue'] ?></td>
                                            <td>
                                            <?php
                                                $urgency = $listelect['m_urgency'];
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
                                            <td>
                                            <?php 
                                                If ($TaskerStatus > 0 ){
                                                    echo '<span style="color:#F99607">กำลังรออะไหล่&nbsp;<i class="far fa-clock"></i></span>' ;
                                                } else {
                                                    echo '<span style="color:green;">กำลังดำเนินการ&nbsp;<i class=""></i></span>' ;
                                                }
                                            
                                            ?>
                                            </td>
                                            <td class="text-center"><a style="font-weight:bold; color:#000;" class="btn btn-sm btn-outline-warning px-3"><?php echo $listelect['m_rate'] ?>&nbsp;<i class="fas fa-star gold"></i>
                                            </td>

                                            <td class="text-center">
                                                <!--------------- Button Group Pannel---------------->
                                                <div class="btn-group">
                                                    <button type="button" class="p-1 badge btn bg-primary dropdown-toggle position-relative" data-bs-toggle="dropdown" aria-expanded="false">จัดการ</button>
                                                    <?php if($_SESSION['level'] == 'Admin' ) {?>
                                                        <?php if ($countWorking > 0 ){?>
                                                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#" onclick="window.open(this.href='task-detail.php?id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=600,width=700,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">ดูเพิ่มเติม</a></li>
                                                        <?php if($_SESSION['level'] == 'Admin' ) {?>
                                                        <li><a class="dropdown-item" href="#" name="editIssue2" id="editIssue2" data-bs-toggle="modal" data-bs-target="#editIssue2<?php echo $listelect['m_id']?>">แก้ไขอาการ</a></li>
                                                        
                                                            <li><a class="dropdown-item" href="#" onclick="window.open(this.href='task-manage.php?id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=400,width=700,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">จ่ายงานช่าง (<?php echo $countPer; ?>)</a></li>
                                                            <?php if($countPer ==! 0 ) {?>
                                                                <li><hr class="dropdown-divider"></li>
                                                        
                                                            <?php } ?>
                                                            <li><a class="dropdown-item" href="#" onclick="window.open(this.href='pr_orders.php?m_id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=600,width=1200,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">สั่งซื้อสินค้า (<?php echo $countOrders; ?>)</a></li>
                                                            <li><a class="dropdown-item position-relative" href="#" onclick="window.open(this.href='working_time.php?m_id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=600,width=1200,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">เวลาการทำงานช่าง
                                                                    <?php if ($countWorking > 0 ){ ?>   
                                                                    <span class="position-absolute top-0 start-90 translate-middle p-1 bg-danger mt-2 border border-light rounded-circle"></span>
                                                                <?php } ?>  
                                                            </a>
                                                            </li>
                                                        <?php } ?>

                                                        <?php if($_SESSION['level'] == 'User' ) {?>
                                                            <?php if($listelect['user_check'] == 'NO') {?>
                                                                <li><a class="dropdown-item" href="#" onclick="window.open(this.href='user_check.php?id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=400,width=600,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">ยืนยันตรวจสอบ</a></li>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                                <!--------------- Button Group Pannel---------------->
                                            </td>
                                            
                                        </tr>
<!-----------------------------------------------------------------------------------------------Start Modal Issue Update--------------------------------------------------------------------------->
                                    <div class="modal fade" id="editIssue2<?php echo $listelect['m_id']?>" aria-hidden="true">                      
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="POST" enctype="multipart/form-data" action="edit-issue2.php">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">แก้ไขอาการแจ้งซ่อม # <?php echo $listelect['m_id']; ?></h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="col"></div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <input type="hidden" value="<?php echo $listelect['m_id']?>" name="m_id"/>
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-text">อาการ</span>
                                                                <textarea class="form-control" rows="4" name="m_issue" aria-label="With textarea" required="required"><?php echo $listelect['m_issue']?></textarea>
                                                            </div>

                                                            <?php if ($_SESSION['level'] == 'Admin') { ?>
                                                                
                                                            <div class="input-group mt-2">
                                                            <span class="input-group-text">ประเภทงาน</span>
                                                            <?php $strDefault = $listelect['m_c_id']; ?>
                                                                <select class="form-select" name="m_c_id">
                                                                    <option value=""><-- เลือกประเภทงานซ่อม --></option>
                                                                    <?php
                                                                        $strSQL = "SELECT * FROM categories ORDER BY c_id ASC";
                                                                        $objQuery = mysqli_query($con,$strSQL);
                                                                        while($objResuut = mysqli_fetch_array($objQuery))
                                                                        {
                                                                            if($strDefault == $objResuut["c_id"])
                                                                            {
                                                                                $categories = "selected";
                                                                            } else
                                                                            {
                                                                                $categories = "";
                                                                            }
                                                                    ?>
                                                                    <option value="<?php echo $objResuut["c_id"];?>" <?php echo $categories;?>><?php echo $objResuut["c_name"];?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>

                                                            <?php if ($status_switchRate == 1) { ?> 
                                                            <div class="input-group mt-2">
                                                                <span class="input-group-text">ความยาก</span>
                                                                <input type="number" class="form-control" name="m_rate" min="0" max="10" value="<?php echo $listelect['m_rate']; ?>">
                                                                <span class="input-group-text">ดาว</span>
                                                            </div>
                                                            <?php }  ?>

                                                            <?php if ($switchTime['status'] == 1) { ?>
                                                            <div class="input-group mt-2">
                                                                <span class="input-group-text">Time Limit</span>
                                                                <input type="number" class="form-control" name="times_limit" min="0" value="<?php echo $listelect['times_limit']; ?>">
                                                                <span class="input-group-text">ชม.</span>
                                                            </div>
                                                            <?php } ?>
                                                            
                                                        <?php } ?>
                                                        </div>
                                                    </div>
                                                    <br style="clear:both;"/>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-warning" name="editIssue2"><span class="glyphicon glyphicon-save"></span>ยืนยัน</button>
                                                        </form>
                                                        <button class="btn btn-danger" data-bs-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>ปิด</button>
                                                    </div> 
                                            </div>
                                        </div>
                                    </div>
<!-----------------------------------------------------------------------------------------------End Modal Issue Update--------------------------------------------------------------------------->
                                        <?php } ?>
                                    </tbody>
                                </table>  
                            </div>          
                        </div>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xxl-12">
                        <div class="card-header bg-secondary text-white">
                            คิวรายการซ่อม ช่างนอก
                        </div>
                        <div class="card-body shadow mb-2 bg-white">
                        <div class="table-responsive-md">
                                <table class="table table-hover table-bordered" style="font-size:14px;">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="col-auto">#</th>
                                            <th colspan="2" class="col-auto">ผู้แจ้ง/แผนก</th>
                                            <th class="col-4">ปัญหา</th>
                                            <th class="col-auto">ความเร่งด่วน</th>
                                            <th class="col-auto">สถานะงาน</th>
                                            <th class="col-auto">ความยาก</th>
                                            <th class="col-1">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $listelectric = $connect->query("SELECT *
                                        FROM maintenance
                                        INNER JOIN depart ON maintenance.m_depart_id = depart.depart_id 
                                        INNER JOIN categories ON maintenance.m_c_id = categories.c_id
                                        RIGHT JOIN subtasks ON maintenance.m_st_id = subtasks.st_id
                                        WHERE (c_name = 'ช่างนอก' AND check_status = 'ตรวจสอบแล้ว' AND user_check = 'NO') AND (m_status ='กำลังดำเนินการ' OR m_status = 'รอสินค้า-อะไหล่')
                                        ");
                                        $listelectric->execute();
                                        $electric = $listelectric->fetchAll();
                                        foreach ($electric as $listelect){
                                        $m_id_count = $listelect['m_id'];
                                        ?>
                                    
                                        <?php
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
                                            $sql3 = "SELECT * FROM purchase WHERE m_id = $m_id_count ";
                                                if ($result3=mysqli_query($con,$sql3))
                                                {
                                                    $countOrders=mysqli_num_rows($result3);
                                                    mysqli_free_result($result3);
                                                }

                                                $sql4 = "SELECT * FROM purchase WHERE m_id = $m_id_count AND pr_status = 'กำลังรอสินค้า' ";
                                                if ($result4=mysqli_query($con,$sql4))
                                                {
                                                    $TaskerStatus=mysqli_num_rows($result4);
                                                    mysqli_free_result($result4);
                                                }
                                                $sql5 = "SELECT * FROM working WHERE m_id = $m_id_count AND status_work = 'กำลังทำงาน' ";
                                                if ($result5=mysqli_query($con,$sql5))
                                                {
                                                $countWorking=mysqli_num_rows($result5);
                                                mysqli_free_result($result5);
                                                }
                                        ?>

                                        
                                        <tr>
                                            <th class="text-center"><?php echo $m_id_count ?></th>
                                            <td colspan="2"><?php echo $listelect['m_user'] ?>/<?php echo $listelect['depart_sub_name'] ?></td>
                                            <td><?php echo $listelect['m_issue'] ?></td>
                                            <td>
                                                <?php
                                                    $urgency = $listelect['m_urgency'];
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
                                            <td>
                                            <?php 
                                                If ($TaskerStatus > 0 ){
                                                    echo '<span style="color:#F99607">กำลังรออะไหล่&nbsp;<i class="far fa-clock"></i></span>' ;
                                                } else {
                                                    echo '<span style="color:green;">กำลังดำเนินการ&nbsp;<i class=""></i></span>' ;
                                                }
                                            
                                            ?>
                                            </td>
                                            <td class="text-center"><a style="font-weight:bold; color:#000;" class="btn btn-sm btn-outline-warning px-3"><?php echo $listelect['m_rate'] ?>&nbsp;<i class="fas fa-star gold"></i></td>
                                            
                                            <td class="text-center">
                                                <!--------------- Button Group Pannel---------------->
                                                <div class="btn-group">
                                                    <button type="button" class="p-1 badge btn bg-primary dropdown-toggle position-relative" data-bs-toggle="dropdown" aria-expanded="false">จัดการ</button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#" onclick="window.open(this.href='task-detail.php?id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=600,width=700,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">ดูเพิ่มเติม</a></li>
                                                        <?php if($_SESSION['level'] == 'Admin' ) {?>
                                                        <li><a class="dropdown-item" href="#" name="editIssue2" id="editIssue2" data-bs-toggle="modal" data-bs-target="#editIssue4<?php echo $listelect['m_id']?>">แก้ไขอาการ</a></li>
                                                        <?php } ?>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <?php if($_SESSION['level'] == 'Admin' ) {?>
                                                            <?php if($listelect['user_check'] == 'NO') {?>
                                                                <li><a class="dropdown-item" href="#" onclick="window.open(this.href='user_check.php?id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=400,width=600,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">ยืนยันตรวจสอบ</a></li>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                                <!--------------- Button Group Pannel---------------->
                                            </td>
                                        </tr>
<!-----------------------------------------------------------------------------------------------Start Modal Issue Update--------------------------------------------------------------------------->
                                        <div class="modal fade" id="editIssue4<?php echo $listelect['m_id']?>" aria-hidden="true">                      
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST" enctype="multipart/form-data" action="edit-issue4.php">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">แก้ไขอาการแจ้งซ่อม # <?php echo $listelect['m_id']; ?></h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="col"></div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <input type="hidden" value="<?php echo $listelect['m_id']?>" name="m_id"/>
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-text">อาการ</span>
                                                                    <textarea class="form-control" rows="4" name="m_issue"  required="required"><?php echo $listelect['m_issue']?></textarea>
                                                                </div>

                                                                <div class="input-group mt-2">
                                                                    <span class="input-group-text">ประเภทงาน</span>
                                                                    <?php $strDefault = $listelect['m_c_id']; ?>
                                                                        <select class="form-select" name="m_c_id">
                                                                            <option value=""><-- เลือกประเภทงานซ่อม --></option>
                                                                            <?php
                                                                                $strSQL = "SELECT * FROM categories ORDER BY c_id ASC";
                                                                                $objQuery = mysqli_query($con,$strSQL);
                                                                                while($objResuut = mysqli_fetch_array($objQuery))
                                                                                {
                                                                                    if($strDefault == $objResuut["c_id"])
                                                                                    {
                                                                                        $categories = "selected";
                                                                                    } else
                                                                                    {
                                                                                        $categories = "";
                                                                                    }
                                                                            ?>
                                                                            <option value="<?php echo $objResuut["c_id"];?>" <?php echo $categories;?>><?php echo $objResuut["c_name"];?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                </div>

                                                                <?php if ($status_switchRate == 1) { ?> 
                                                                <div class="input-group mt-2">
                                                                    <span class="input-group-text">ความยาก</span>
                                                                    <input type="number" class="form-control" name="m_rate" min="0" max="10" value="<?php echo $listelect['m_rate']; ?>">
                                                                    <span class="input-group-text">ดาว</span>
                                                                </div>
                                                                <?php }  ?>

                                                                <?php if ($switchTime['status'] == 1) { ?>
                                                                <div class="input-group mt-2">
                                                                    <span class="input-group-text">Time Limit</span>
                                                                    <input type="number" class="form-control" name="times_limit" min="0" value="<?php echo $listelect['times_limit']; ?>">
                                                                    <span class="input-group-text">ชม.</span>
                                                                </div>
                                                                <?php } ?>

                                                            </div>
                                                        </div>
                                                        <br style="clear:both;"/>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-warning" name="editIssue4"><span class="glyphicon glyphicon-save"></span>ยืนยัน</button>
                                                            </form>
                                                            <button class="btn btn-danger" data-bs-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>ปิด</button>
                                                        </div> 
                                                </div>
                                            </div>
                                        </div>
<!-----------------------------------------------------------------------------------------------End Modal Issue Update--------------------------------------------------------------------------->
                                        <?php } ?>
                                    </tbody>
                                </table>  
                            </div>               
                        </div>
                    </div>   
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->                        
                    </div>
                    
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xxl-6">
                    <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xxl-12">
                        <div class="card-header bg-secondary text-white" style="font-weight: bold;">
                            คิวแจ้งซ่อมอะไหล่-แม่พิมพ์
                        </div>
                        <div class="card-body shadow mb-2 bg-white">
                            <div class="table-responsive-md">
                                <table class="table table-hover table-bordered" style="font-size:14px;">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="col-auto">#</th>
                                            <th colspan="2" class="col-auto">ผู้แจ้ง/แผนก</th>
                                            <th class="col-4">ปัญหา</th>
                                            <th class="col-auto text-center">ความเร่งด่วน</th>
                                            <th class="col-auto">สถานะงาน</th>
                                            <th class="col-auto">ความยาก</th>
                                            <th class="col-auto">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $listelectric = $connect->query("SELECT *
                                        FROM maintenance
                                        INNER JOIN depart ON maintenance.m_depart_id = depart.depart_id 
                                        INNER JOIN categories ON maintenance.m_c_id = categories.c_id
                                        RIGHT JOIN subtasks ON maintenance.m_st_id = subtasks.st_id
                                        WHERE (c_name = 'อะไหล่-แม่พิมพ์' AND check_status = 'ตรวจสอบแล้ว' AND user_check = 'NO') AND (m_status ='กำลังดำเนินการ' OR m_status = 'รอสินค้า-อะไหล่')
                                        ");
                                        $listelectric->execute();
                                        $electric = $listelectric->fetchAll();
                                        foreach ($electric as $listelect){
                                            $m_id_count = $listelect['m_id'];
                                            $sql6 = "SELECT * FROM tasker WHERE m_id = $m_id_count GROUP BY date_task " or die("Error:" . mysqli_error());
                                            $row = mysqli_query($con, $sql6);
                                            
                                            ?>
                                        
                                            <?php
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

                                                $sql3 = "SELECT * FROM purchase WHERE m_id = $m_id_count ";
                                                if ($result3=mysqli_query($con,$sql3))
                                                {
                                                    $countOrders=mysqli_num_rows($result3);
                                                    mysqli_free_result($result3);
                                                }

                                                $sql4 = "SELECT * FROM purchase WHERE m_id = $m_id_count AND pr_status = 'กำลังรอสินค้า' ";
                                                if ($result4=mysqli_query($con,$sql4))
                                                {
                                                    $TaskerStatus=mysqli_num_rows($result4);
                                                    mysqli_free_result($result4);
                                                }
                                                $sql5 = "SELECT * FROM working WHERE m_id = $m_id_count AND status_work = 'กำลังทำงาน' ";
                                                if ($result5=mysqli_query($con,$sql5))
                                                {
                                                $countWorking=mysqli_num_rows($result5);
                                                mysqli_free_result($result5);
                                                }
                                                   

                                                
                                            ?>

                                        <tr>
                                            <th class="text-center" style="<?php if($countPer == '0') {?>color:red;<?php } ?>"><?php echo $listelect['m_id'] ?></th>
                                            <td colspan="2"><?php echo $listelect['m_user'] ?>/<?php echo $listelect['depart_sub_name'] ?></td>
                                            <td><?php echo $listelect['m_issue'] ?></td>
                                            <td>
                                            <?php
                                                $urgency = $listelect['m_urgency'];
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
                                            <td>
                                            <?php 
                                                If ($TaskerStatus > 0 ){
                                                    echo '<span style="color:#F99607">กำลังรออะไหล่&nbsp;<i class="far fa-clock"></i></span>' ;
                                                } else {
                                                    echo '<span style="color:green;">กำลังดำเนินการ&nbsp;<i class=""></i></span>' ;
                                                }
                                            ?>
                                            <?php foreach ( $row as $row) { ?>
                                                <?php
                                                        $datetime_start2 = $row['date_task'];
                                                        $datetime_end2 = date("Y-m-d H:i:s");
                                                        $seconds2 = strtotime($datetime_end2) - strtotime($datetime_start2);
                                                        $sum2 += $seconds2;
    
                                                        $days2    = floor($seconds2 / 86400);
                                                        $hours2   = floor(($seconds2 - ($days2 * 86400)) / 3600);
                                                        $minutes2 = floor(($seconds2 - ($days2 * 86400) - ($hours2 * 3600))/60);
                                                        $seconds2 = floor(($seconds2 - ($days2 * 86400) - ($hours2 * 3600) - ($minutes2*60)));
                                                    
                                                ?>
                                                    <?php if ($days2 >=  7){ ?>
                                                        <a style="color:red;"><i class="fas fa-exclamation"></i></a>
                                                    <?php } ?>
                                                <?php } ?>
                                            </td>
                                            <td class="text-center"><a style="font-weight:bold; color:#000;" class="btn btn-sm btn-outline-warning px-3"><?php echo $listelect['m_rate'] ?>&nbsp;<i class="fas fa-star gold"></i></td>

                                            <td class="text-center">
                                                <!--------------- Button Group Pannel---------------->
                                                <div class="btn-group">
                                                    <button type="button" class="p-1 badge btn bg-primary dropdown-toggle position-relative" data-bs-toggle="dropdown" aria-expanded="false">จัดการ</button>
                                                    <?php if($_SESSION['level'] == 'Admin' ) {?>
                                                        <?php if ($countWorking > 0 ){?>
                                                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#" onclick="window.open(this.href='task-detail.php?id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=600,width=700,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">ดูเพิ่มเติม</a></li>
                                                        <?php if($_SESSION['level'] == 'Admin' ) {?>
                                                        <li><a class="dropdown-item" href="#" name="editIssue2" id="editIssue2" data-bs-toggle="modal" data-bs-target="#editIssue3<?php echo $listelect['m_id']?>">แก้ไขอาการ</a></li>
                                                            <li><a class="dropdown-item" href="#" onclick="window.open(this.href='task-manage.php?id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=400,width=700,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">จ่ายงานช่าง (<?php echo $countPer; ?>)</a></li>
                                                            <?php if($countPer ==! 0 ) {?>
                                                                <li><hr class="dropdown-divider"></li>
                                                        
                                                            <?php } ?>
                                                            <li><a class="dropdown-item" href="#" onclick="window.open(this.href='pr_orders.php?m_id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=600,width=1200,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">สั่งซื้อสินค้า (<?php echo $countOrders; ?>)</a></li>
                                                            <li><a class="dropdown-item position-relative" href="#" onclick="window.open(this.href='working_time.php?m_id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=600,width=1200,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">เวลาการทำงานช่าง
                                                                    <?php if ($countWorking > 0 ){ ?>   
                                                                    <span class="position-absolute top-0 start-90 translate-middle p-1 bg-danger mt-2 border border-light rounded-circle"></span>
                                                                <?php } ?>  
                                                            </a>
                                                            </li>
                                                        <?php } ?>

                                                        <?php if($_SESSION['level'] == 'User' ) {?>
                                                            <?php if($listelect['user_check'] == 'NO') {?>
                                                                <li><a class="dropdown-item" href="#" onclick="window.open(this.href='user_check.php?id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=400,width=600,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">ยืนยันตรวจสอบ</a></li>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                                <!--------------- Button Group Pannel---------------->
                                            </td>
                                        </tr>
                                        <!-----------------------------------------------------------------------------------------------Start Modal Issue Update--------------------------------------------------------------------------->
                                        <div class="modal fade" id="editIssue3<?php echo $listelect['m_id']?>" aria-hidden="true">                      
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST" enctype="multipart/form-data" action="edit-issue3.php">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">แก้ไขอาการแจ้งซ่อม # <?php echo $listelect['m_id']; ?></h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="col"></div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <input type="hidden" value="<?php echo $listelect['m_id']?>" name="m_id"/>
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-text">อาการ</span>
                                                                    <textarea class="form-control" rows="4" name="m_issue" aria-label="With textarea" required="required"><?php echo $listelect['m_issue']?></textarea>
                                                                </div>

                                                                <div class="input-group mt-2">
                                                                    <span class="input-group-text">ประเภทงาน</span>
                                                                    <?php $strDefault = $listelect['m_c_id']; ?>
                                                                        <select class="form-select" name="m_c_id">
                                                                            <option value=""><-- เลือกประเภทงานซ่อม --></option>
                                                                            <?php
                                                                                $strSQL = "SELECT * FROM categories ORDER BY c_id ASC";
                                                                                $objQuery = mysqli_query($con,$strSQL);
                                                                                while($objResuut = mysqli_fetch_array($objQuery))
                                                                                {
                                                                                    if($strDefault == $objResuut["c_id"])
                                                                                    {
                                                                                        $categories = "selected";
                                                                                    } else
                                                                                    {
                                                                                        $categories = "";
                                                                                    }
                                                                            ?>
                                                                            <option value="<?php echo $objResuut["c_id"];?>" <?php echo $categories;?>><?php echo $objResuut["c_name"];?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                </div>

                                                                <?php if ($status_switchRate == 1) { ?> 
                                                                <div class="input-group mt-2">
                                                                    <span class="input-group-text">ความยาก</span>
                                                                    <input type="number" class="form-control" name="m_rate" min="0" max="10" value="<?php echo $listelect['m_rate']; ?>">
                                                                    <span class="input-group-text">ดาว</span>
                                                                </div>
                                                                <?php }  ?>

                                                                <?php if ($switchTime['status'] == 1) { ?>
                                                                <div class="input-group mt-2">
                                                                    <span class="input-group-text">Time Limit</span>
                                                                    <input type="number" class="form-control" name="times_limit" min="0" value="<?php echo $listelect['times_limit']; ?>">
                                                                    <span class="input-group-text">ชม.</span>
                                                                </div>
                                                                <?php } ?>

                                                            </div>
                                                        </div>
                                                        <br style="clear:both;"/>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-warning" name="editIssue3"><span class="glyphicon glyphicon-save"></span>ยืนยัน</button>
                                                            </form>
                                                            <button class="btn btn-danger" data-bs-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>ปิด</button>
                                                        </div> 
                                                </div>
                                            </div>
                                        </div>
<!-----------------------------------------------------------------------------------------------End Modal Issue Update--------------------------------------------------------------------------->
                                        <?php } ?>
                                    </tbody>
                                </table>  
                            </div>          
                        </div>
                    </div>
                </div>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                    
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xxl-12">
                        <div class="card-header bg-secondary text-white">
                            คิวแจ้งซ่อมเครื่องจักร
                        </div>
                        <div class="card-body shadow mb-2 bg-white">
                        <div class="table-responsive-md">
                                <table class="table table-hover table-bordered" style="font-size:14px;">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="col-auto">#</th>
                                            <th colspan="2" class="col-auto">ผู้แจ้ง/แผนก</th>
                                            <th class="col-4">ปัญหา</th>
                                            <th class="col-auto">ความเร่งด่วน</th>
                                            <th class="col-auto">สถานะงาน</th>
                                            <th class="col-auto">ความยาก</th>
                                            <th class="col-1">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $listelectric = $connect->query("SELECT *
                                        FROM maintenance
                                        INNER JOIN depart ON maintenance.m_depart_id = depart.depart_id 
                                        INNER JOIN categories ON maintenance.m_c_id = categories.c_id
                                        RIGHT JOIN subtasks ON maintenance.m_st_id = subtasks.st_id
                                        WHERE (c_name = 'เครื่องจักร' AND check_status = 'ตรวจสอบแล้ว' AND user_check = 'NO') AND (m_status ='กำลังดำเนินการ' OR m_status = 'รอสินค้า-อะไหล่')
                                        ");
                                        $listelectric->execute();
                                        $electric = $listelectric->fetchAll();
                                        foreach ($electric as $listelect){
                                        $m_id_count = $listelect['m_id'];
                                        ?>
                                    
                                        <?php
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
                                            $sql3 = "SELECT * FROM purchase WHERE m_id = $m_id_count ";
                                                if ($result3=mysqli_query($con,$sql3))
                                                {
                                                    $countOrders=mysqli_num_rows($result3);
                                                    mysqli_free_result($result3);
                                                }

                                                $sql4 = "SELECT * FROM purchase WHERE m_id = $m_id_count AND pr_status = 'กำลังรอสินค้า' ";
                                                if ($result4=mysqli_query($con,$sql4))
                                                {
                                                    $TaskerStatus=mysqli_num_rows($result4);
                                                    mysqli_free_result($result4);
                                                }
                                                $sql5 = "SELECT * FROM working WHERE m_id = $m_id_count AND status_work = 'กำลังทำงาน' ";
                                                if ($result5=mysqli_query($con,$sql5))
                                                {
                                                $countWorking=mysqli_num_rows($result5);
                                                mysqli_free_result($result5);
                                                }
                                        ?>

                                        
                                        <tr>
                                            <th class="text-center" style="<?php if($countPer == '0') {?>color:red;<?php } ?>"><?php echo $m_id_count ?></th>
                                            <td colspan="2"><?php echo $listelect['m_user'] ?>/<?php echo $listelect['depart_sub_name'] ?></td>
                                            <td><?php echo $listelect['m_issue'] ?></td>
                                            <td>
                                                <?php
                                                    $urgency = $listelect['m_urgency'];
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
                                            <td>
                                            <?php 
                                                If ($TaskerStatus > 0 ){
                                                    echo '<span style="color:#F99607">กำลังรออะไหล่&nbsp;<i class="far fa-clock"></i></span>' ;
                                                } else {
                                                    echo '<span style="color:green;">กำลังดำเนินการ&nbsp;<i class=""></i></span>' ;
                                                }
                                            
                                            ?>
                                            </td>
                                            <td class="text-center"><a style="font-weight:bold; color:#000;" class="btn btn-sm btn-outline-warning px-3"><?php echo $listelect['m_rate'] ?>&nbsp;<i class="fas fa-star gold"></i></td>
                                            
                                            <td class="text-center">
                                                <!--------------- Button Group Pannel---------------->
                                                <div class="btn-group">
                                                    <button type="button" class="p-1 badge btn bg-primary dropdown-toggle position-relative" data-bs-toggle="dropdown" aria-expanded="false">จัดการ</button>
                                                    <?php if($_SESSION['level'] == 'Admin' ) {?>
                                                        <?php if ($countWorking > 0 ){?>
                                                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#" onclick="window.open(this.href='task-detail.php?id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=600,width=700,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">ดูเพิ่มเติม</a></li>
                                                        <?php if($_SESSION['level'] == 'Admin' ) {?>
                                                        <li><a class="dropdown-item" href="#" name="editIssue2" id="editIssue2" data-bs-toggle="modal" data-bs-target="#editIssue4<?php echo $listelect['m_id']?>">แก้ไขอาการ</a></li>
                                                            <li><a class="dropdown-item" href="#" onclick="window.open(this.href='task-manage.php?id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=400,width=700,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">จ่ายงานช่าง (<?php echo $countPer; ?>)</a></li>
                                                            <?php if($countPer ==! 0 ) {?>
                                                                <li><hr class="dropdown-divider"></li>
                                                        
                                                            <?php } ?>
                                                            <li><a class="dropdown-item" href="#" onclick="window.open(this.href='pr_orders.php?m_id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=600,width=1200,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">สั่งซื้อสินค้า (<?php echo $countOrders; ?>)</a></li>
                                                            <li><a class="dropdown-item position-relative" href="#" onclick="window.open(this.href='working_time.php?m_id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=600,width=1200,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">เวลาการทำงานช่าง
                                                                    <?php if ($countWorking > 0 ){ ?>   
                                                                    <span class="position-absolute top-0 start-90 translate-middle p-1 bg-danger mt-2 border border-light rounded-circle"></span>
                                                                <?php } ?>  
                                                            </a>
                                                            </li>
                                                        <?php } ?>

                                                        <?php if($_SESSION['level'] == 'User' ) {?>
                                                            <?php if($listelect['user_check'] == 'NO') {?>
                                                                <li><a class="dropdown-item" href="#" onclick="window.open(this.href='user_check.php?id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=400,width=600,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">ยืนยันตรวจสอบ</a></li>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                                <!--------------- Button Group Pannel---------------->
                                            </td>
                                        </tr>
<!-----------------------------------------------------------------------------------------------Start Modal Issue Update--------------------------------------------------------------------------->
                                        <div class="modal fade" id="editIssue4<?php echo $listelect['m_id']?>" aria-hidden="true">                      
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST" enctype="multipart/form-data" action="edit-issue4.php">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">แก้ไขอาการแจ้งซ่อม4 # <?php echo $listelect['m_id']; ?></h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="col"></div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <input type="hidden" value="<?php echo $listelect['m_id']?>" name="m_id"/>
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-text">อาการ</span>
                                                                    <textarea class="form-control" rows="4" name="m_issue"  required="required"><?php echo $listelect['m_issue']?></textarea>
                                                                </div>

                                                                <div class="input-group mt-2">
                                                                    <span class="input-group-text">ประเภทงาน</span>
                                                                    <?php $strDefault = $listelect['m_c_id']; ?>
                                                                        <select class="form-select" name="m_c_id">
                                                                            <option value=""><-- เลือกประเภทงานซ่อม --></option>
                                                                            <?php
                                                                                $strSQL = "SELECT * FROM categories ORDER BY c_id ASC";
                                                                                $objQuery = mysqli_query($con,$strSQL);
                                                                                while($objResuut = mysqli_fetch_array($objQuery))
                                                                                {
                                                                                    if($strDefault == $objResuut["c_id"])
                                                                                    {
                                                                                        $categories = "selected";
                                                                                    } else
                                                                                    {
                                                                                        $categories = "";
                                                                                    }
                                                                            ?>
                                                                            <option value="<?php echo $objResuut["c_id"];?>" <?php echo $categories;?>><?php echo $objResuut["c_name"];?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                </div>

                                                                <?php if ($status_switchRate == 1) { ?> 
                                                                <div class="input-group mt-2">
                                                                    <span class="input-group-text">ความยาก</span>
                                                                    <input type="number" class="form-control" name="m_rate" min="0" max="10" value="<?php echo $listelect['m_rate']; ?>">
                                                                    <span class="input-group-text">ดาว</span>
                                                                </div>
                                                                <?php }  ?>

                                                                <?php if ($switchTime['status'] == 1) { ?>
                                                                <div class="input-group mt-2">
                                                                    <span class="input-group-text">Time Limit</span>
                                                                    <input type="number" class="form-control" name="times_limit" min="0" value="<?php echo $listelect['times_limit']; ?>">
                                                                    <span class="input-group-text">ชม.</span>
                                                                </div>
                                                                <?php } ?>

                                                            </div>
                                                        </div>
                                                        <br style="clear:both;"/>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-warning" name="editIssue4"><span class="glyphicon glyphicon-save"></span>ยืนยัน</button>
                                                            </form>
                                                            <button class="btn btn-danger" data-bs-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>ปิด</button>
                                                        </div> 
                                                </div>
                                            </div>
                                        </div>
<!-----------------------------------------------------------------------------------------------End Modal Issue Update--------------------------------------------------------------------------->
                                        <?php } ?>
                                    </tbody>
                                </table>  
                            </div>               
                        </div>
                    </div>   
<!----------------------------------------------------------------------- รายการคิวแจ้งซ่อมโปรเจค ------------------------------------------------------------------------------------->
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xxl-12">
                        <div class="card-header bg-secondary text-white">
                            คิวรายการ Project
                        </div>
                        <div class="card-body shadow mb-2 bg-white">
                        <div class="table-responsive-md">
                                <table class="table table-hover table-bordered" style="font-size:14px;">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="col-auto">#</th>
                                            <th colspan="2" class="col-auto">ผู้แจ้ง/แผนก</th>
                                            <th class="col-4">ปัญหา</th>
                                            <th class="col-auto">ความเร่งด่วน</th>
                                            <th class="col-auto">สถานะงาน</th>
                                            <th class="col-auto">ความยาก</th>
                                            <th class="col-1">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $listelectric = $connect->query("SELECT *
                                        FROM maintenance
                                        INNER JOIN depart ON maintenance.m_depart_id = depart.depart_id 
                                        INNER JOIN categories ON maintenance.m_c_id = categories.c_id
                                        RIGHT JOIN subtasks ON maintenance.m_st_id = subtasks.st_id
                                        WHERE (c_name = 'Project' AND check_status = 'ตรวจสอบแล้ว' AND user_check = 'NO') AND (m_status ='กำลังดำเนินการ' OR m_status = 'รอสินค้า-อะไหล่')
                                        ");
                                        $listelectric->execute();
                                        $electric = $listelectric->fetchAll();
                                        foreach ($electric as $listelect){
                                        $m_id_count = $listelect['m_id'];
                                        ?>
                                    
                                        <?php
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
                                            $sql3 = "SELECT * FROM purchase WHERE m_id = $m_id_count ";
                                                if ($result3=mysqli_query($con,$sql3))
                                                {
                                                    $countOrders=mysqli_num_rows($result3);
                                                    mysqli_free_result($result3);
                                                }

                                                $sql4 = "SELECT * FROM purchase WHERE m_id = $m_id_count AND pr_status = 'กำลังรอสินค้า' ";
                                                if ($result4=mysqli_query($con,$sql4))
                                                {
                                                    $TaskerStatus=mysqli_num_rows($result4);
                                                    mysqli_free_result($result4);
                                                }
                                                $sql5 = "SELECT * FROM working WHERE m_id = $m_id_count AND status_work = 'กำลังทำงาน' ";
                                                if ($result5=mysqli_query($con,$sql5))
                                                {
                                                $countWorking=mysqli_num_rows($result5);
                                                mysqli_free_result($result5);
                                                }
                                        ?>

                                        
                                        <tr>
                                            <th class="text-center" style="<?php if($countPer == '0') {?>color:red;<?php } ?>"><?php echo $m_id_count ?></th>
                                            <td colspan="2"><?php echo $listelect['m_user'] ?>/<?php echo $listelect['depart_sub_name'] ?></td>
                                            <td><?php echo $listelect['m_issue'] ?></td>
                                            <td>
                                                <?php
                                                    $urgency = $listelect['m_urgency'];
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
                                            <td>
                                            <?php 
                                                If ($TaskerStatus > 0 ){
                                                    echo '<span style="color:#F99607">กำลังรออะไหล่&nbsp;<i class="far fa-clock"></i></span>' ;
                                                } else {
                                                    echo '<span style="color:green;">กำลังดำเนินการ&nbsp;<i class=""></i></span>' ;
                                                }
                                            
                                            ?>
                                            </td>
                                            <td class="text-center"><a style="font-weight:bold; color:#000;" class="btn btn-sm btn-outline-warning px-3"><?php echo $listelect['m_rate'] ?>&nbsp;<i class="fas fa-star gold"></i></td>
                                            
                                            <td class="text-center">
                                                <!--------------- Button Group Pannel---------------->
                                                <div class="btn-group">
                                                    <button type="button" class="p-1 badge btn bg-primary dropdown-toggle position-relative" data-bs-toggle="dropdown" aria-expanded="false">จัดการ</button>
                                                    <?php if($_SESSION['level'] == 'Admin' ) {?>
                                                        <?php if ($countWorking > 0 ){?>
                                                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#" onclick="window.open(this.href='task-detail.php?id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=600,width=700,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">ดูเพิ่มเติม</a></li>
                                                        <?php if($_SESSION['level'] == 'Admin' ) {?>
                                                        <li><a class="dropdown-item" href="#" name="editIssue2" id="editIssue2" data-bs-toggle="modal" data-bs-target="#editIssue4<?php echo $listelect['m_id']?>">แก้ไขอาการ</a></li>
                                                            <li><a class="dropdown-item" href="#" onclick="window.open(this.href='task-manage.php?id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=400,width=700,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">จ่ายงานช่าง (<?php echo $countPer; ?>)</a></li>
                                                            <?php if($countPer ==! 0 ) {?>
                                                                <li><hr class="dropdown-divider"></li>
                                                        
                                                            <?php } ?>
                                                            <li><a class="dropdown-item" href="#" onclick="window.open(this.href='pr_orders.php?m_id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=600,width=1200,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">สั่งซื้อสินค้า (<?php echo $countOrders; ?>)</a></li>
                                                            <li><a class="dropdown-item position-relative" href="#" onclick="window.open(this.href='working_time.php?m_id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=600,width=1200,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">เวลาการทำงานช่าง
                                                                    <?php if ($countWorking > 0 ){ ?>   
                                                                    <span class="position-absolute top-0 start-90 translate-middle p-1 bg-danger mt-2 border border-light rounded-circle"></span>
                                                                <?php } ?>  
                                                            </a>
                                                            </li>
                                                        <?php } ?>

                                                        <?php if($_SESSION['level'] == 'User' ) {?>
                                                            <?php if($listelect['user_check'] == 'NO') {?>
                                                                <li><a class="dropdown-item" href="#" onclick="window.open(this.href='user_check.php?id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=400,width=600,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">ยืนยันตรวจสอบ</a></li>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                                <!--------------- Button Group Pannel---------------->
                                            </td>
                                        </tr>
<!-----------------------------------------------------------------------------------------------Start Modal Issue Update--------------------------------------------------------------------------->
                                        <div class="modal fade" id="editIssue4<?php echo $listelect['m_id']?>" aria-hidden="true">                      
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST" enctype="multipart/form-data" action="edit-issue4.php">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">แก้ไขอาการแจ้งซ่อม # <?php echo $listelect['m_id']; ?></h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="col"></div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <input type="hidden" value="<?php echo $listelect['m_id']?>" name="m_id"/>
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-text">อาการ</span>
                                                                    <textarea class="form-control" rows="4" name="m_issue"  required="required"><?php echo $listelect['m_issue']?></textarea>
                                                                </div>

                                                                <div class="input-group mt-2">
                                                                    <span class="input-group-text">ประเภทงาน</span>
                                                                    <?php $strDefault = $listelect['m_c_id']; ?>
                                                                        <select class="form-select" name="m_c_id">
                                                                            <option value=""><-- เลือกประเภทงานซ่อม --></option>
                                                                            <?php
                                                                                $strSQL = "SELECT * FROM categories ORDER BY c_id ASC";
                                                                                $objQuery = mysqli_query($con,$strSQL);
                                                                                while($objResuut = mysqli_fetch_array($objQuery))
                                                                                {
                                                                                    if($strDefault == $objResuut["c_id"])
                                                                                    {
                                                                                        $categories = "selected";
                                                                                    } else
                                                                                    {
                                                                                        $categories = "";
                                                                                    }
                                                                            ?>
                                                                            <option value="<?php echo $objResuut["c_id"];?>" <?php echo $categories;?>><?php echo $objResuut["c_name"];?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                </div>

                                                                <?php if ($status_switchRate == 1) { ?> 
                                                                <div class="input-group mt-2">
                                                                    <span class="input-group-text">ความยาก</span>
                                                                    <input type="number" class="form-control" name="m_rate" min="0" max="10" value="<?php echo $listelect['m_rate']; ?>">
                                                                    <span class="input-group-text">ดาว</span>
                                                                </div>
                                                                <?php }  ?>

                                                                <?php if ($switchTime['status'] == 1) { ?>
                                                                <div class="input-group mt-2">
                                                                    <span class="input-group-text">Time Limit</span>
                                                                    <input type="number" class="form-control" name="times_limit" min="0" value="<?php echo $listelect['times_limit']; ?>">
                                                                    <span class="input-group-text">ชม.</span>
                                                                </div>
                                                                <?php } ?>

                                                            </div>
                                                        </div>
                                                        <br style="clear:both;"/>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-warning" name="editIssue4"><span class="glyphicon glyphicon-save"></span>ยืนยัน</button>
                                                            </form>
                                                            <button class="btn btn-danger" data-bs-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>ปิด</button>
                                                        </div> 
                                                </div>
                                            </div>
                                        </div>
<!-----------------------------------------------------------------------------------------------End Modal Issue Update--------------------------------------------------------------------------->
                                        <?php } ?>
                                    </tbody>
                                </table>  
                            </div>               
                        </div>
                    </div>   
<!--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                    </div> <!-- Div row -->

                    <?php foreach ($rowSwitch as $rowSwitch) { $status = $rowSwitch['status'];?><?php } ?>
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xxl-12">
                        <div class="card-header bg-success text-white">
                            ยืนยันการตรวจสอบงานแล้ว
                        </div>
                        <div class="card-body shadow mb-2 bg-white">
                        <div class="table-responsive-md">
                                <table class="table table-hover table-bordered" style="font-size:14px;">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="col-auto">#</th>
                                            <th colspan="2" class="col-auto">ผู้แจ้ง/แผนก</th>
                                            <th class="col-auto">ปัญหา</th>
                                            <th class="col-1">ความเร่งด่วน</th>
                                            <th class="col-1">ความยาก</th>
                                            <th class="col-auto">การตรวจสอบปิดงาน</th>
                                            <th class="col-auto">ผู้ตรวจสอบ</th>
                                            <th class="col-1">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $listelectric = $connect->query("SELECT *
                                        FROM maintenance
                                        INNER JOIN depart ON maintenance.m_depart_id = depart.depart_id 
                                        INNER JOIN categories ON maintenance.m_c_id = categories.c_id
                                        RIGHT JOIN subtasks ON maintenance.m_st_id = subtasks.st_id
                                        WHERE (check_status = 'ตรวจสอบแล้ว' AND user_check = 'YES') AND (m_status ='กำลังดำเนินการ' OR m_status = 'รอสินค้า-อะไหล่')
                                        ");
                                        $listelectric->execute();
                                        $electric = $listelectric->fetchAll();
                                        foreach ($electric as $listelect){
                                        $m_id_count = $listelect['m_id'];
                                        ?>
                                    
                                        <?php
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
                                            $sql5 = "SELECT * FROM working WHERE m_id = $m_id_count AND status_work = 'กำลังทำงาน' ";
                                                if ($result5=mysqli_query($con,$sql5))
                                                {
                                                $countWorking=mysqli_num_rows($result5);
                                                mysqli_free_result($result5);
                                                }
                                        ?>

                                        
                                        <tr>
                                            <th class="text-center" style="<?php if($countPer == '0') {?>color:red;<?php } ?>"><?php echo $m_id_count ?></th>
                                            <td colspan="2"><?php echo $listelect['m_user'] ?>/<?php echo $listelect['depart_sub_name'] ?></td>
                                            <td><?php echo $listelect['m_issue'] ?></td>
                                            <td>
                                            <?php
                                                $urgency = $listelect['m_urgency'];
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
                                            
                                            <td class="text-center"><a style="font-weight:bold; color:#000;" class="btn btn-sm btn-outline-warning px-3"><?php echo $listelect['m_rate'] ?>&nbsp;<i class="fas fa-star gold"></i></td>
                                            <td><?php echo $listelect['user_comment'] ?></td>
                                            <td><?php echo $listelect['name_check'] ?></td>
                                            <td class="text-center">
                                                <!-- Example single danger button -->
                                                <div class="btn-group">
                                                <button type="button" class="p-2 badge btn bg-primary dropdown-toggle position-relative" data-bs-toggle="dropdown" aria-expanded="false">จัดการ</button>
                                                    <?php if($_SESSION['level'] == 'Admin' ) {?>
                                                        <?php if ($countWorking > 0 ){?>
                                                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#" onclick="window.open(this.href='task-detail.php?id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=600,width=700,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">ดูเพิ่มเติม</a></li>
                                                       
                                                        <?php if($_SESSION['level'] == 'Admin' ) {?>
                                                            <li><hr class="dropdown-divider"></li>
                                                                <?php if($listelect['user_check'] == 'YES') {?>
                                                                    <?php if($status == '1') {?>
                                                                        <li><a class="dropdown-item" href="#" onclick="window.open(this.href='task-manage.php?id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=400,width=700,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">จ่ายงานช่าง (<?php echo $countPer; ?>)</a></li>
                                                                    <?php } ?>
                                                                    <?php if ($countWorking > 0 ){ ?>  
                                                                        <li><a class="dropdown-item position-relative" href="#" onclick="window.open(this.href='working_time.php?m_id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=600,width=1200,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">เวลาการทำงานช่าง
                                                                    <?php } ?>  
                                                                    <?php if ($countWorking > 0 ){ ?>   
                                                                            <span class="position-absolute top-0 start-90 translate-middle p-1 bg-danger mt-2 border border-light rounded-circle"></span>
                                                                        <?php } ?>  
                                                                    </a>
                                                                    </li>
                                                                    <?php if ($countWorking == 0 ){ ?>
                                                                        <li><a class="dropdown-item" href="#" onclick="window.open(this.href='approved_status_end.php?id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=400,width=600,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">ปิดงานเคสงาน</a></li>
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
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                </div>

                <!--Start Modal แจ้งซ่อม-->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">แจ้งซ่อม</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form method="POST" action="index.php" enctype="multipart/form-data">
                            <div class="mb-3">
                            <div class="input-group mb-3">
                            <span class="input-group-text">ชื่อ</span>
                                <input type="text" class="form-control" placeholder="ผู้แจ้งซ่อม(ชื่อเล่น)" name="m_user" id="m_user" required >
                            </div>
                            <div class="input-group mb-3">
                            <span class="input-group-text">แผนก</span>
                                <select class="form-select" required name="m_depart_id" id="m_depart_id">
                                <option selected>เลือกแผนก...</option>
                                <?php foreach($depart as $depart){?>
                                    <option value="<?php echo $depart["depart_id"];?>"><?php echo $depart["depart_sub_name"];?></option>
                                <?php } ?>
                                </select>
                            </div>
                            </div>
                            
                            <div class="input-group mb-3">
                            <span class="input-group-text">ประเภทงาน</span>
                                <select class="form-select" required name="m_c_id" id="m_c_id">
                                        <option selected>เลือกประเภทงานซ่อม...</option>
                                        <?php foreach($cate as $cate){?>
                                            <option value="<?php echo $cate["c_id"];?>"><?php echo $cate["c_name"];?></option>
                                        <?php } ?>
                                </select>
                            </div>
                            <div class="input-group mb-3">
                            <span class="input-group-text">ประเภทงานย่อย</span>
                                <select class="form-select" required name="m_st_id" id="m_st_id">
                                        <option selected>เลือกประเภทงานย่อย...</option>
                                        <?php foreach($subt as $subt){?>
                                            <option value="<?php echo $subt["st_id"];?>"><?php echo $subt["st_name"];?></option>
                                        <?php } ?>
                                </select>
                            </div>
                            <div class="input-group mb-3">
                            <span class="input-group-text">ความเร่งด่วน</span>
                                <select class="form-select" required name="m_urgency" id="m_urgency">
                                        <option selected>เลือกความเร่งด่วน...</option>
                                            <option value="Hight">Hight</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Low">Low</option>
                                </select>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text">อาการ</span>
                                <textarea class="form-control" placeholder="อาการ..." name="m_issue" id="m_issue" required></textarea>
                            </div>
                            <input class="form-control" type="hidden" id="check_status" value="รอตรวจสอบ" name="check_status">
                            <input class="form-control" type="hidden" id="photo" value="upload/no_picture.png" name="photo">
                        </div>
                        <div class="modal-footer">    
                            <button type="submit" name="submit" id="submit" class="btn btn-primary">ส่งข้อมูล</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        </div>
                        </form>
                        </div>
                    </div>
                </div>
                <!--End Modal แจ้งซ่อม-->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
    <!--Start Modal login-->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
      <form action="index.php" method="POST">
        
          <section style="background-color: #fff;">
            <div class="card shadow-2-strong" style="border-radius: 1rem;">
              <div class="card-body p-5 text-center">
                 <h3 class="mb-3">Login</h3>
                  <div class="form-outline mb-4">
                    <input type="text" id="username" name="username" placeholder="Username" class="form-control form-control-lg" />
                  </div>
                  <div class="form-outline mb-4">
                    <input type="password" id="password" name="password" placeholder="Password" class="form-control form-control-lg" />

                  </div>
                      <button class="btn btn-primary form-control" type="submit" name="login">Login</button>
              </div>
            </div>
          </section>
        </form>
      </div>
    </div>
  </div>
</div>
<!--End Modal login-->
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
            </div>
        </div>
    </div>
    <script src="dist/js/lightbox-plus-jquery.min.js"></script>
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