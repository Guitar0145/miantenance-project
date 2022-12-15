<?php  session_start(); ?>
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
<ul class="nav navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Profile</a>
            <div class="dropdown-menu dropdown-menu-end">
                <a href="#" class="dropdown-item">ผู้ใช้ : <?php echo $_SESSION['u_name']; ?></a>
                <a href="#" class="dropdown-item">ดูรายละเอียด</a>
<!------------------------------------------------------------------เริ่มต้นการแก้ไข--------------------------------------------------------------------------------------------->   
              <?php
                require 'conn.php';
                $query = mysqli_query($conn, "SELECT * FROM `user` WHERE u_id = " . $_SESSION['u_id'] . " ") or die(mysqli_error());
                while($fetch = mysqli_fetch_array($query)){
              ?>
              <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editUser<?php echo $_SESSION['u_id'] ?>" >แก้ไขข้อมูล</a>

              	
				
 <!------------------------------------------------------------------สิ้นสุดการแก้ไข--------------------------------------------------------------------------------------------->             
                

                  <div class="dropdown-divider"></div>
                  <a href="logout.php" class="dropdown-item">ออกจากระบบ</a>
                      <a href="logout.php" class="dropdown-item">ออกจากระบบ</a>
                  </div>
        </li>
      </ul>
      <div class="modal fade" id="editUser<?php echo $_SESSION['u_id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form method="POST" enctype="multipart/form-data" action="edit.php">
                      <div class="modal-header">
                        <h3 class="modal-title">Edit User</h3>
                      </div>
                      <div class="modal-body">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                          <div class="form-group">
                            <label>u_name</label>
                            <input type="hidden" value="<?php echo $fetch['u_id']?>" name="u_id"/>
                            <input type="text" class="form-control" value="<?php echo $fetch['u_name']?>" name="u_name" required="required"/>
                          </div>
                          <div class="form-group">
                            <label>u_depart</label>
                            <input type="text" class="form-control" value="<?php echo $fetch['u_depart']?>" name="u_depart" required="required"/>
                          </div>
                          <div class="form-group">
                            <label>username</label>
                            <input type="text" class="form-control" value="<?php echo $fetch['username']?>" name="username" required="required"/>
                          </div>
                          <div class="form-group">
                            <label>password</label>
                            <input type="text" class="form-control" value="<?php echo $fetch['password']?>" name="password" required="required"/>
                          </div>
                        </div>
                      </div>
                      <br style="clear:both;"/>
                      <div class="modal-footer">
                        
                        <button class="btn btn-warning" name="edit"><span class="glyphicon glyphicon-save"></span> Update</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>	
              <?php
					}
				?>		
      
</body>
</html>