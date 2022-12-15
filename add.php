<!DOCTYPE html>
<html>
<head>
<title>ระบบซ่อม</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/fa_icon.js" crossorigin="anonymous"></script>

<meta charset=utf-8 />
</head>
<body>
 <center><br>
<!-- Button trigger modal -->
<button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">แบ่งงาน</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">แบ่งงาน รหัสงานที่ #1 / ไฟดับ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form action="save.php" id="frmMain" name="frmMain" method="post"><br>
                <div class="card-body">
                    <table class="table table-hover table-bordered" width="600" border="1" id="myTable">
                    <!-- head table -->
                    <thead>
                    <tr>
                        <td > <div align="center">รหัสแบ่งงาน </div></td>
                        <td > <div align="center">รหัสงาน </div></td>
                        <td > <div align="center">ช่าง </div></td>
                        <td > <div align="center">สถานะงาน </div></td>
                    </tr>
                    </thead>
                    <!-- body dynamic rows -->
                    <tbody></tbody>
                    </table>
                    <hr>
                    <input type="button" class="btn btn-sm btn-primary" id="createRows" value="เพิ่ม">
                    <input type="button" class="btn btn-sm btn-danger" id="deleteRows" value="ลบ">
                    <input type="button" class="btn btn-sm btn-secondary" id="clearRows" value="ล้าง">
                    <center>
                    <hr>
                    <input type="hidden" id="hdnCount" name="hdnCount">
                    
                    </form>
        </div>
      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-sm btn-primary" value="แบ่งงาน">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>