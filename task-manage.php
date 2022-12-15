<?php
    include_once ('functions-maint.php');
    include('connect_sqli.php'); 

    $query = "SELECT * FROM technician ORDER BY tc_id " or die("Error:" . mysqli_error());
    $tech = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>อัพเดทสถานะ</title>
  <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
  <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/bootstrap-grid.css" rel="stylesheet" type="text/css">
  <link href="css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
</head>
<body>
<div class="container-fluid"> <!--start container-->
<?php
    $m_id = $_GET['id'];
    $upstatus = new DB_con();
    $sql = $upstatus ->fetchonerecord($m_id);
    while($row = mysqli_fetch_array($sql)) {
?>
<div class="card p-1 my-1">
    <div class="card-body">
        <h5 class="modal-title text-center" id="exampleModalLabel">แบ่งงานช่าง<br>รหัสการแจ้งซ่อมทั่วไป ที่ #<?php echo $row['m_id'] ?></br></h5>
            <form action="save-taskmanage.php" id="frmMain" name="frmMain" method="post"><br>
                    <div class="table-responsive-md">
                        <table class="table table-hover table-bordered" id="myTable">
                            <!-- head table -->
                            <thead>
                                <tr>
                                    
                                    <td > <div align="center">รหัสงาน </div></td>
                                    <td > <div align="center">ช่าง </div></td>
                                    <td > <div align="center">สถานะงาน </div></td>
                                    <td > <div align="center">
                                        
                                     </div></td>
                                </tr>
                            </thead>
                            <!-- body dynamic rows -->
                            <tbody></tbody>
                        </table>
                        <hr>
                            <div class="text-center">
                                <input type="button" class="btn btn-sm btn-primary" id="createRows" value="เพิ่ม">
                                <input type="button" class="btn btn-sm btn-danger" id="deleteRows" value="ลบ">
                                <input type="button" class="btn btn-sm btn-secondary" id="clearRows" value="ล้าง">
                            </div>
                            <hr>
                            <input type="hidden" id="hdnCount" name="hdnCount">
                            </div>
                            <?php } ?>
                        <div class="modal-footer">    
                            <button type="submit" name="submitupdate" id="submsubmitupdateit" class="btn btn-sm btn-primary">ยืนยัน</button>&nbsp;
                            <button type="button" name="submitupdate" id="submsubmitupdateit" class="btn btn-sm btn-secondary" onclick="window.close();">ยกเลิก</button>
                        </div>
                </form>
        </div>
    </div>
</div>
<!--End Modal แจ้งซ่อม--><!--จบอัพเดทสถานะ-->  
</body>
<script type="text/javascript">
    $(document).ready(function(){

        var rows = 1;
        $("#createRows").click(function(){
                            var tr = "<tr>";
                            tr = tr + "<input type='hidden' class='form-control form-control-sm' name='task_id"+rows+"'  id='task_id"+rows+"' size='5'>";
                            tr = tr + "<td><input type='text' class='form-control form-control-sm' name='m_id"+rows+"' value='<?php echo $m_id ; ?>' id='m_id"+rows+"' size='10'></td>";
                            tr = tr + "<td><select class='form-select form-select-sm' required name='tc_id"+rows+"' id='tc_id"+rows+"'><?php foreach($tech as $tech){?><option value='<?php echo $tech["tc_id"];?>'><?php echo $tech["tc_name"];?>/<?php echo $tech["tc_nickname"];?>/<?php echo $tech["tc_depart"];?></option><?php } ?></select></td>";
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
</html>