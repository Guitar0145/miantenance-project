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
</head>
<body>
<?php
$objConnect = new mysqli("localhost","root","rootroot") or die("Error Connect to Database");
$objDB = $objConnect->select_db("mtservice");
if(isset($_GET["m_id"]))
   {
	   $strm_id = $_GET["m_id"];
   }
//*** Update Condition ***//
if($_GET["Action"] == "Save")
{
	for($i=1;$i<=$_POST["hdnLine"];$i++)
	{
		$strSQL = "UPDATE tasker SET ";
		$strSQL .="task_id = '".$_POST["task_id$i"]."' ";
		$strSQL .=",m_id = '".$_POST["m_id$i"]."' ";
		$strSQL .=",task_status = '".$_POST["task_status$i"]."' ";
		$strSQL .="WHERE task_id = '".$_POST["hdnTask_id$i"]."' ";
		$objQuery = $objConnect->query($strSQL);
	}
  echo "<script>alert('ปิดงานช่างสำเร็จ !!');</script>";
	
	//header("location:$_SERVER[PHP_SELF]");
	//exit();
}

$strSQL = " SELECT * 
            FROM tasker
            INNER JOIN technician ON tasker.tc_id = technician.tc_id
            WHERE tasker.task_status = 'กำลังทำงาน' AND m_id = '".$strm_id."'
            ";
$objQuery = $objConnect->query($strSQL) or die ("Error Query [".$strSQL."]");
?>
<div class="container-fluid">
  <div class="card p-2 my-2">
    <div class="table-responsive-md my-2">
      <form name="frmMain" method="post" action="update-tasker.php?Action=Save">
      <div class="text-center"><div><h5>ปิดงานช่าง รหัสงานซ่อมที่ # <?php echo $strm_id;?></h5></div>
      <table class="table table-sm table-bordered border-dark">
        <thead class="table-active">
        <tr>
          <th><div align="center">ช่าง</div></th>
        </tr>
        </thead>
      <?php
      $i =0;
      while($objResult = $objQuery->fetch_array())
      {
        $i = $i + 1;

      ?>
        <tr>
         
        <input type="hidden" name="hdnTask_id<?php echo $i;?>" size="10" value="<?php echo $objResult["task_id"];?>">
        <input type="hidden" class="form-control form-control-sm" name="task_id<?php echo $i;?>" size="2" value="<?php echo $objResult["task_id"];?>">
        </div>
          <input type="hidden" class="form-control form-control-sm" name="m_id<?php echo $i;?>" size="2" value="<?php echo $objResult["m_id"];?>">
          <td><input type="text" class="form-control form-control-sm" name="tc_id<?php echo $i;?>" size="20" value="<?php echo $objResult["tc_id"];?>.<?php echo $objResult["tc_name"];?> / <?php echo $objResult["tc_nickname"];?>">
              <input type="hidden" class="form-control form-control-sm" size="3" min="1" required max="10" name="task_status<?php echo $i;?>" value="ทำงานเสร็จสิ้น">
        </td>

        </tr>
      <?php
      }
      ?>
      </table>
      <div class="text-center">
        <input type="submit" name="submit" class="btn btn-sm btn-primary" value="ปิดงานช่าง" onclick="return confirm('คลิกเพื่อยินยัน ปิดงานช่าง !!')">
        <input type="hidden" name="hdnLine" value="<?php echo $i;?>">
      </form>
      </div>
    </div>
  </div>
</div>
<?php
$objConnect->close();
?>
</body>
</html>