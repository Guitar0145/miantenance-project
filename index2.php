<?php
    include_once ('functions-maint.php');

    $maintdata = new DB_con();
        
        if (isset($_POST['submitmaint'])){
            $m_user = $_POST['m_user'];
            $m_depart_id = $_POST['m_depart_id'];
            $m_c_id = $_POST['m_c_id'];
            $m_st_id = $_POST['m_st_id'];
            $m_issue = $_POST['m_issue'];
            $check_status = $_POST['check_status'];

            $sql = $maintdata->addmaint($m_user, $m_depart_id, $m_c_id, $m_st_id, $m_issue, $check_status);

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
        include('connect_sqli.php'); 
        $query = "SELECT * FROM categories ORDER BY c_id " or die("Error:" . mysqli_error());
        $cate = mysqli_query($con, $query);

        $query3 = "SELECT * FROM subtasks ORDER BY st_id " or die("Error:" . mysqli_error());
        $subt= mysqli_query($con, $query3);

        $query2 = "SELECT * FROM depart ORDER BY depart_id " or die("Error:" . mysqli_error());
        $depart = mysqli_query($con, $query2);      
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
    <title>Document</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/fa_icon.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){

        var rows = 1;
        $("#createRows").click(function(){
                            var tr = "<tr>";
                            tr = tr + "<td><input type='text' class='form-control form-control-sm' name='task_id"+rows+"'  id='task_id"+rows+"' size='5'></td>";
                            tr = tr + "<td><input type='text' class='form-control form-control-sm' name='m_id"+rows+"' value='<?php echo "1"; ?>' id='m_id"+rows+"' size='10'></td>";
                            tr = tr + "<td><select class='form-select form-select-sm' name='tc_id"+rows+"' id='tc_id"+rows+"'><option selected>เลือกช่าง</option><option value='1'>ช่างหนึ่ง / ช่างไฟ</option><option value='2'>ช่างสอง / ช่างไฟ</option><option value='3'>ช่างสาม / ช่างไฟ</option><option value='4'>ช่างสี่ / ช่างไฟ</option><option value='5'>ช่างห้า / ช่างไฟ</option></select></td>";
                            tr = tr + "<td><input type='text' class='form-control form-control-sm' name='task_status"+rows+"' value='<?php echo "กำลังทำงาน"; ?>' id='task_status"+rows+"' size='8'></td>";
                            tr = tr + "</tr>";
                            $('#myTable > tbody:last').append(tr);
                        
                            $('#hdnCount').val(rows);
                            rows = rows + 1;
            });

            $("#deleteRows").click(function(){
                    if ($("#myTable tr").length != 1) {
                        $("#myTable tr:last").remove();
                    }
            });

            $("#clearRows").click(function(){
                    rows = 1;
                    $('#hdnCount').val(rows);
                    $('#myTable > tbody:last').empty(); // remove all
            });

        });
    </script>
    <style>
        .gold {
            color:#FFD700;
        }
    </style>
    </head>
<body>
    <?php include 'navbar.php' ?>
    <div class="">
        <div class="p-1 mt-2">
            <div class="card p-1">
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="button" class="btn btn-warning shadow my-1 mx-1" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><i class="fas fa-cogs"></i>&nbsp;แจ้งซ่อมทั่วไป</button>
                <a class="btn btn-info shadow my-1 mx-1" href="index-machine.php"><i class="fas fa-cogs"></i>&nbsp;แจ้งซ่อมเครื่องจักร</a>
            </div><br>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->              
                <div class="row">
                    <div class="col-12">
                        <div class="card-header bg-secondary text-white">
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
                                        <th class="col-auto text-center">อาการ</th>
                                        <th>วันที่แจ้งงาน</th>
                                        <th class="col-auto text-center">การตรวจสอบ</th>
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
                                        ?>
                                        <tr>
                                            <td class="text-center" width="5%"><?php echo $listall['m_id'] ?></td>
                                            <td class="text-center"><?php echo $listall['m_user'] ?></td>
                                            <td><?php echo $listall['depart_sub_name'] ?></td>
                                            <td><?php echo $listall['c_name'] ?></td>
                                            <td><?php echo $listall['st_name'] ?></td>
                                            <td><?php echo $listall['m_issue'] ?></td>
                                            <td class="text-center"><?php echo $listall['m_datetime'] ?></td>
                                            <td class="text-center"><p class="text-danger"><?php echo $listall['check_status'] ?></p></td>
                                            <td class="text-center">
                                            <form>
                                                <button type="submit" name="submitstatus" id="submitstatus" class="btn btn-sm btn-primary" onclick="window.open(this.href='approved_status.php?id=<?php echo $listall['m_id'] ?>','popUpWindow','height=400,width=600,left=200,top=200,,scrollbars=yes,menubar=no'); return false;" >รับงาน</button>&nbsp;
                                            </form>
                                            </td>
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
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6">
                        <div class="card-header bg-secondary text-white">
                            คิวแจ้งซ่อมระบบไฟฟ้า
                        </div>
                        <div class="card-body shadow mb-2 bg-white">
                            <div class="table-responsive-md">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="col-auto">#</th>
                                            <th class="col-auto">ผู้แจ้ง</th>
                                            <th class="col-auto">แผนก</th>
                                            <th class="col-auto">ปัญหา</th>
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
                                        WHERE c_name = 'ระบบไฟฟ้า' AND (m_status ='กำลังดำเนินการ' OR m_status = 'รอสินค้า-อะไหล่')
                                        ");
                                        $listelectric->execute();
                                        $electric = $listelectric->fetchAll();
                                        foreach ($electric as $listelect){
                                    ?>
                                        <tr>
                                            <th class="text-center"><?php echo $listelect['m_id'] ?></th>
                                            <td class="text-center"><?php echo $listelect['m_user'] ?></td>
                                            <td><?php echo $listelect['depart_sub_name'] ?></td>
                                            <td><?php echo $listelect['m_issue'] ?></td>
                                            <td class="text-center"><?php echo $listelect['m_status'] ?></td>
                                            <td><?php
                                                    $star = $listelect['m_rate'];
                                                    $star5 = '<i class="fas fa-star gold"><i class="fas fa-star gold"><i class="fas fa-star gold"><i class="fas fa-star gold"><i class="fas fa-star gold">';
                                                    $star4 = '<i class="fas fa-star gold"><i class="fas fa-star gold"><i class="fas fa-star gold"><i class="fas fa-star gold">';
                                                    $star3 = '<i class="fas fa-star gold"><i class="fas fa-star gold"><i class="fas fa-star gold">';
                                                    $star2 = '<i class="fas fa-star gold"><i class="fas fa-star gold">';
                                                    $star1 = '<i class="fas fa-star gold">';

                                                    if ($star >= 5) {
                                                        echo $star5;    
                                                    } else if ($star >= 4) {
                                                        echo $star4;        
                                                    } else if ($star >= 3) {
                                                        echo $star3;     
                                                    } else if ($star >= 2) {
                                                        echo $star2;       
                                                    } else {
                                                        echo $star1;    
                                                    }
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-primary mx-1 my-1"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-sm btn-warning"><i class="fas fa-user-alt" data-bs-toggle="modal" data-bs-target="#taskmanage"></i></button>
                                            </td>
                                        </tr>
                                                    

                                        <?php } ?>
                                    </tbody>
                                </table>  
                            </div>       
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xxl-6">
                        <div class="card-header bg-secondary text-white">
                            คิวแจ้งซ่อมระบบปะปา
                        </div>
                        <div class="card-body shadow mb-2 bg-white">
                            <div class="table-responsive-md">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="col-auto">#</th>
                                            <th class="col-auto">ผู้แจ้ง</th>
                                            <th class="col-auto">แผนก</th>
                                            <th class="col-auto">ปัญหา</th>
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
                                        WHERE c_name = 'ระบบปะปา' AND (m_status ='กำลังดำเนินการ' OR m_status = 'รอสินค้า-อะไหล่')
                                        ");
                                        $listelectric->execute();
                                        $electric = $listelectric->fetchAll();
                                        foreach ($electric as $listelect){
                                    ?>
                                        <tr>
                                            <th class="text-center"><?php echo $listelect['m_id'] ?></th>
                                            <td class="text-center"><?php echo $listelect['m_user'] ?></td>
                                            <td><?php echo $listelect['depart_sub_name'] ?></td>
                                            <td><?php echo $listelect['m_issue'] ?></td>
                                            <td class="text-center"><?php echo $listelect['m_status'] ?></td>
                                            <td><?php
                                                    $star = $listelect['m_rate'];
                                                    $star5 = '<i class="fas fa-star gold"><i class="fas fa-star gold"><i class="fas fa-star gold"><i class="fas fa-star gold"><i class="fas fa-star gold">';
                                                    $star4 = '<i class="fas fa-star gold"><i class="fas fa-star gold"><i class="fas fa-star gold"><i class="fas fa-star gold">';
                                                    $star3 = '<i class="fas fa-star gold"><i class="fas fa-star gold"><i class="fas fa-star gold">';
                                                    $star2 = '<i class="fas fa-star gold"><i class="fas fa-star gold">';
                                                    $star1 = '<i class="fas fa-star gold">';

                                                    if ($star >= 5) {
                                                        echo $star5;    
                                                    } else if ($star >= 4) {
                                                        echo $star4;        
                                                    } else if ($star >= 3) {
                                                        echo $star3;     
                                                    } else if ($star >= 2) {
                                                        echo $star2;       
                                                    } else {
                                                        echo $star1;    
                                                    }
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-primary mx-1 my-1"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-sm btn-warning"><i class="fas fa-user-alt"></i></button>
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
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xxl-6">
                        <div class="card-header bg-secondary text-white">
                            รายการแจ้งซ่อมทั่วไป
                        </div>
                        <div class="card-body shadow mb-2 bg-white">
                            <div class="table-responsive-md">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="col-auto">#</th>
                                            <th class="col-auto">ผู้แจ้ง</th>
                                            <th class="col-auto">แผนก</th>
                                            <th class="col-auto">ปัญหา</th>
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
                                        WHERE c_name = 'ทั่วไป' AND (m_status ='กำลังดำเนินการ' OR m_status = 'รอสินค้า-อะไหล่')
                                        ");
                                        $listelectric->execute();
                                        $electric = $listelectric->fetchAll();
                                        foreach ($electric as $listelect){
                                    ?>
                                        <tr>
                                            <th class="text-center"><?php echo $listelect['m_id'] ?></th>
                                            <td class="text-center"><?php echo $listelect['m_user'] ?></td>
                                            <td><?php echo $listelect['depart_sub_name'] ?></td>
                                            <td><?php echo $listelect['m_issue'] ?></td>
                                            <td class="text-center"><?php echo $listelect['m_status'] ?></td>
                                            <td><?php
                                                    $star = $listelect['m_rate'];
                                                    $star5 = '<i class="fas fa-star gold"><i class="fas fa-star gold"><i class="fas fa-star gold"><i class="fas fa-star gold"><i class="fas fa-star gold">';
                                                    $star4 = '<i class="fas fa-star gold"><i class="fas fa-star gold"><i class="fas fa-star gold"><i class="fas fa-star gold">';
                                                    $star3 = '<i class="fas fa-star gold"><i class="fas fa-star gold"><i class="fas fa-star gold">';
                                                    $star2 = '<i class="fas fa-star gold"><i class="fas fa-star gold">';
                                                    $star1 = '<i class="fas fa-star gold">';

                                                    if ($star >= 5) {
                                                        echo $star5;    
                                                    } else if ($star >= 4) {
                                                        echo $star4;        
                                                    } else if ($star >= 3) {
                                                        echo $star3;     
                                                    } else if ($star >= 2) {
                                                        echo $star2;       
                                                    } else {
                                                        echo $star1;    
                                                    }
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-primary mx-1 my-1"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-sm btn-warning"><i class="fas fa-user-alt"></i></button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>  
                            </div>          
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xxl-6">
                        <div class="card-header bg-secondary text-white">
                            รายการแจ้งซ่อมทั่วไป
                        </div>
                        <div class="card-body shadow mb-2 bg-white">
                            1 of 2          
                        </div>
                    </div>
                </div>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                <!--Start Modal แจ้งซ่อม-->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">แจ้งซ่อม</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
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
                                <span class="input-group-text">อาการ</span>
                                <textarea class="form-control" placeholder="อาการ..." name="m_issue" id="m_issue" required></textarea>
                            </div>
                            <div class="mb-3">
                                <input class="form-control" type="file" id="m_img" name="m_img">
                                <label for="formFile" class="form-label" style="color:red;">&nbsp;ใส่รูปภาพได้(ถ้ามี)</label>
                            </div>
                            <input class="form-control" type="hidden" id="check_status" value="รอตรวจสอบ" name="check_status">
                        </div>
                        <div class="modal-footer">    
                            <button type="submit" name="submitmaint" id="submitmaint" class="btn btn-primary">ส่งข้อมูล</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        </div>
                        </form>
                        </div>
                    </div>
                </div>
                <!--End Modal แจ้งซ่อม-->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

            </div>
        </div>
    </div>
   
    <?php include 'footer.php';?>
</body>
</html>