<?php
session_start();
include('connect_sqli.php');
$query = "SELECT * FROM technician " or die("Error:" . mysqli_error());
$technic = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานช่าง</title>
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
        <div class="mt-2">
            <div class="card p-1">
                <div class="card-header text-white" style="font-weight: bold; background-color:#058961;">
                    เลือก วันที่ที่ต้องการค้นหารายงาน
                </div>
                <div class="card-body shadow mb-2 bg-white">
                    <form action="report-maintenance.php" method="GET" class="row my-2 g-1">
                        <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2">
                            <select name="m_status" class="form-select">
                                <option selected>
                                    <?php
                                            if (isset($_GET['m_status'])) {
                                                echo $_GET['m_status'];
                                            } else {
                                                echo 'เลือกสถานะ';
                                            }
                                            ?>
                                </option>
                                <option value="เสร็จสิ้น">เสร็จสิ้น</option>
                                <option value="กำลังดำเนินการ">กำลังดำเนินการ</option>
                            </select>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2">
                            <input type="date" class="form-control" name="from_date" placeholder="dd-mm-yyyy" id="from"
                                value="<?php if (isset($_GET['from_date'])) {
                                    echo $_GET['from_date'];
                                } ?>">
                        </div>
                        <div class="col-auto p-2">
                            <span>ถึง</span>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2">
                            <input type="date" class="form-control" name="to_date" id="to"
                                value="<?php if (isset($_GET['to_date'])) {
                                    echo $_GET['to_date'];
                                } ?>">
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2">
                            <button name="submit" type="submit" class="btn btn-primary">ค้นหา</button>
                        </div>


                    </form>
                    <div class="table-responsive-md">
                        <table id="myTable" class="table table-sm table-hover table-bordered" style="font-size:14px;">
                        <thead class="sticky-top" style="background-color: #0067B8;color:#fff;">
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>ผู้แจ้ง</th>
                                    <th>แผนก</th>
                                    <th class="col-3">อาการ</th>
                                    <th>ระดับ</th>
                                    <th>การแก้ไข</th>
                                    <th>ผู้ตรวจสอบ</th>
                                    <th>เวลาที่ตรวจสอบ</th>
                                    <th>สถานะ</th>
                                    <th>แจ้ง->รับ</th>
                                    <th>รับ->ปิดเคส</th>
                                    <th>แจ้ง->ปิดเคส</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_GET['submit'])) {
                                    $m_status = $_GET['m_status'];
                                    $from_date = $_GET['from_date'];
                                    $to_date = $_GET['to_date'];

                                    if ($m_status != "" || $fdate != "" || $tdate != "") {
                                        $query = "SELECT * 
                                                FROM maintenance
                                                INNER JOIN depart ON maintenance.m_depart_id = depart.depart_id 
                                                WHERE m_status = '$m_status' AND m_datetime 
                                                BETWEEN '" . $from_date . "' AND '" . $to_date . "' 
                                                ";

                                        $data = mysqli_query($con, $query) or die('error');
                                        if (mysqli_num_rows($data) > 0) {
                                            while ($row = mysqli_fetch_assoc($data)) {
                                                $m_id = $row['m_id'];
                                                $m_user = $row['m_user'];
                                                $depart_sub_name = $row['depart_sub_name'];
                                                $m_issue = $row['m_issue'];
                                                $m_rate = $row['m_rate'];
                                                $suc_issue = $row['suc_issue'];
                                                $name_check = $row['name_check'];
                                                $date_check = $row['date_check'];
                                                $m_status = $row['m_status'];
                                                $date_repair = $row['m_datetime'];
                                                $date_ap = $row['ap_datetime'];
                                                $date_ap2 = $row['ap_datetime'];
                                                $date_repair2 = $row['m_datetime'];
                                                $suc_date2 = $row['m_datetime'];
                                ?>
                                <tr>
                                    <td class="text-center">
                                        <?php echo $m_id; ?>
                                    </td>
                                    <td>
                                        <?php echo $m_user; ?>
                                    </td>
                                    <td>
                                        <?php echo $depart_sub_name; ?>
                                    </td>
                                    <td>
                                        <?php echo $m_issue; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $m_rate; ?>
                                    </td>
                                    <td>
                                        <?php echo $suc_issue; ?>
                                    </td>
                                    <td>
                                        <?php echo $name_check; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $date_check; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $m_status; ?>
                                    </td>

                                    <!----------------------------แจ้ง ถึง รับ------------------------------>
                                    <td class="text-end">
                                        <?php
                                                $startAp = $row['m_datetime'];
                                                $stopAp = $row['ap_datetime'];
                                                $diff = strtotime($stopAp) - strtotime($startAp);

                                                $fullHours = floor($diff / (60 * 60));
                                                $fullMinutes = floor(($diff - ($fullHours * 60 * 60)) / 60);
                                                $fullSeconds = floor($diff - ($fullHours * 60 * 60) - ($fullMinutes * 60));
                                                        ?>
                                        <?php echo $fullHours; ?> ชม.
                                        <?php echo $fullMinutes; ?> นาที
                                    </td>
                                    <!--------------------------------------------------------------------->

                                    <!----------------------------รับ ถึง ปิดเคส------------------------------>
                                    <td class="text-end">
                                        <?php
                                                $suc_date = $row['suc_date'];
                                                $suc_time = $row['suc_time'];
                                                $MergeDateTime = date('Y-m-d H:i:s', strtotime("$suc_date $suc_time"));
                                                $startAp2 = $row['ap_datetime'];
                                                $stopSuc = $MergeDateTime;
                                                $diff2 = strtotime($stopSuc) - strtotime($startAp2);

                                                $fullHours2 = floor($diff2 / (60 * 60));
                                                $fullMinutes2 = floor(($diff2 - ($fullHours2 * 60 * 60)) / 60);
                                                $fullSeconds2 = floor($diff2 - ($fullHours2 * 60 * 60) - ($fullMinutes2 * 60));
                                                        ?>
                                        <?php echo $fullHours2; ?> ชม.
                                        <?php echo $fullMinutes2; ?> นาที
                                    </td>
                                    <!--------------------------------------------------------------------->

                                    <!----------------------------แจ้ง ถึง ปิดเคส------------------------------>
                                    <td class="text-end">
                                        <?php
                                                $suc_date3 = $row['suc_date'];
                                                $suc_time3 = $row['suc_time'];
                                                $MergeDateTime3 = date('Y-m-d H:i:s', strtotime("$suc_date3 $suc_time3"));
                                                $startAp3 = $row['m_datetime'];
                                                $stopSuc3 = $MergeDateTime3;
                                                $diff3 = strtotime($stopSuc3) - strtotime($startAp3);

                                                $fullHours3 = floor($diff3 / (60 * 60));
                                                $fullMinutes3 = floor(($diff3 - ($fullHours3 * 60 * 60)) / 60);
                                                $fullSeconds3 = floor($diff3 - ($fullHours3 * 60 * 60) - ($fullMinutes3 * 60));
                                                        ?>
                                        <?php echo $fullHours3; ?> ชม.
                                        <?php echo $fullMinutes3; ?> นาที
                                    </td>
                                    <!--------------------------------------------------------------------->
                                </tr>
                                <?php
                                            }
                                        } else {
                                                    ?>
                                <tr>
                                    <td colspan="12" class="text-center" style="color:red;">ไม่เจอข้อมูลที่ท่านต้องการ !
                                    </td>
                                </tr>
                                <?php
                                        }
                                    }

                                }
                                                ?>

                            </tbody>
                        </table>
                        <form action="report-maintenance-excel.php" method="get">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3"><button type="submit"
                                    class="btn btn-success shadow mb-4">
                                    <input type="hidden"
                                        value="<?php if (isset($_GET['m_status'])) {
                                        echo $_GET['m_status'];
                                    } ?>"
                                        name="m_status">
                                    <input type="hidden"
                                        value="<?php if (isset($_GET['from_date'])) {
                                        echo $_GET['from_date'];
                                    } ?>"
                                        name="from_date">
                                    <input type="hidden"
                                        value="<?php if (isset($_GET['to_date'])) {
                                        echo $_GET['to_date'];
                                    } ?>"
                                        name="to_date">
                                    <i class="fas fa-file-excel"></i>&nbsp;Export</button>
                            </div>
                        </form>
                    </div>
                </div>
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