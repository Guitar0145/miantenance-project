<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script>
    setInterval(() => {
      $.get("notification.php", function (data, status) {
        var json_data = JSON.parse(data);

        var notificationEl = $('#notificationPush');
        var CountQty = $('#CountQty');
        CountQty.html(json_data.length);
        console.log(CountQty)

        // Clear หน้าจอ
        notificationEl.empty();
        json_data.forEach(push_data => {
          //console.log(push_data);
          notificationEl.append('<li><a class="dropdown-item" href="admin-approved-repair.php?id='+push_data.m_id+'">No.'+push_data.m_id+' / '+ push_data.depart_sub_name+' / '+ push_data.m_issue+' </a></li>');
          //notificationEl.append('<p>'+push_data.product_name+'</p>');
        });
        /** 
        ทดสอบข้อมูล JSON
        
        console.log(json_data[0].product_name)
        console.log(json_data[0].qty)
        /**/
      });
    }, 2000);
</script>
<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="javascript:void(0)"><img src="img/logo.gif" alt="" style="width:35px;" class="rounded-pill"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">หน้าหลัก</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="monitor.php">Monitor</a>
        </li>
        
        <?php if( empty( $_SESSION['u_id'] ) ) { ?>
        <li class="nav-item">
          <a class="nav-link" href="login.php">เข้าสู่ระบบ</a>
        </li>
        <?php } ?>
        
        <?php if($_SESSION['level'] == 'Admin' ) {?>
        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">แจ้งซ่อม</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="mantenance-all.php">รายการแจ้งซ่อม</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="manage_departlist.php">รายการแผนก/ช่าง</a></li>
                <li><a class="dropdown-item" href="manage_typetaker.php">รายการประเภทงาน</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">แจ้งซ่อมเครื่องจักร</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="machine/index-machine.php">รายการแจ้งซ่อม</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="machine/manage_dep_machine.php">จัดการแผนกเครื่องจักร</a></li>
                <li><a class="dropdown-item" href="machine/manage_machine.php">จัดการรายการเครื่องจักร</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">รายงาน</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="report-technician.php">รายงานช่าง</a></li>
                <li><a class="dropdown-item" href="report-maintenance.php">รายงานแจ้งซ่อมทั่วไป</a></li>
                <li><a class="dropdown-item" href="machine/">รายงานแจ้งซ่อมเครื่องจักร</a></li>
            </ul>
        </li>

        <li class="nav-item dropdown">
                <a class="nav-link position-relative" type="button" id="notification" data-bs-toggle="dropdown" ria-haspopup="true" aria-expanded="false">แจ้งซ่อม
                <i class="fa fa-bell"></i>&nbsp;<span class="position-absolute top-5 start-110 translate-middle badge rounded-pill bg-danger" id="CountQty"></span> </a>
                    
                <ul class="dropdown-menu" aria-labelledby="notification">
                    <li><a class="dropdown-item" href="#">รายการแจ้งซ่อม</a></li>
                    <div id="notificationPush">

                    </div>
                </ul>
       </li>
       <!--<li class="nav-item dropdown">
                <a class="nav-link position-relative" type="button" id="notification" data-bs-toggle="dropdown" ria-haspopup="true" aria-expanded="false">เครื่องจักร
                <i class="fa fa-bell"></i>&nbsp;<span class="position-absolute top-5 start-110 translate-middle badge rounded-pill bg-danger" id="CountQty">0</span> </a>
                    
                <ul class="dropdown-menu" aria-labelledby="notification">
                    <li><a class="dropdown-item" href="#">รายการแจ้งซ่อม</a></li>
                    <div id="notificationPush">

                    </div>
                </ul>
       </li>-->
       <?php } ?>
      </ul>
      
      <?php if( $_SESSION['u_id'] ) { ?>
      <ul class="nav navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><?php echo $_SESSION['username']; ?></a>
            <div class="dropdown-menu dropdown-menu-end">
                <a href="#" class="dropdown-item">ผู้ใช้ : <?php echo $_SESSION['u_name']; ?></a>
                
<!------------------------------------------------------------------เริ่มต้นการแก้ไข--------------------------------------------------------------------------------------------->   
              <?php
                require 'connect_sqli.php';
                $query = mysqli_query($con, "SELECT * FROM `user` WHERE u_id = " . $_SESSION['u_id'] . " ") or die(mysqli_error());
                while($fetch = mysqli_fetch_array($query)){
              ?>
              <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#detailUser<?php echo $_SESSION['u_id'] ?>">ดูรายละเอียด</a>
              <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editUser<?php echo $_SESSION['u_id'] ?>" >แก้ไขข้อมูล</a>
              <?php if($_SESSION['u_name'] == 'Admin' ) { ?>
              <div class="dropdown-divider"></div>
                  <a href="backup-database/backup-database.php" class="dropdown-item">BackUp-Database</a>
                  <a href="switch-page.php" class="dropdown-item">Switch Functions</a>
              <?php } ?>
              <div class="dropdown-divider"></div>
                  <a href="logout.php" class="dropdown-item">ออกจากระบบ</a>
              </div>
              
        </li>
      </ul>
              <div class="modal fade" id="editUser<?php echo $_SESSION['u_id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form method="POST" enctype="multipart/form-data" action="update-profile.php">
                      <div class="modal-header">
                        <h3 class="modal-title">แก้ไขข้อมูล</h3>
                      </div>
                      <div class="modal-body">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                          <div class="form-group">
                            <label>ชื่อ-สกุล</label>
                            <input type="hidden" value="<?php echo $fetch['u_id']?>" name="u_id"/>
                            <input type="text" class="form-control" value="<?php echo $fetch['u_name']?>" name="u_name" required="required"/>
                          </div>
                          <div class="form-group">
                            <label>แผนก</label>
                            <input type="text" class="form-control" value="<?php echo $fetch['u_depart']?>" name="u_depart" required="required"/>
                          </div>
                          <div class="form-group">
                            <label>username</label>
                            <input type="text" class="form-control" value="<?php echo $fetch['username']?>" name="username" required="required"/>
                          </div>
                          <div class="form-group">
                            <label>password</label>
                            <input type="password" class="form-control" value="<?php echo $fetch['password']?>" name="password" required="required"/>
                          </div>
                        </div>
                      </div>
                      <br style="clear:both;"/>
                      <div class="modal-footer">
                        
                        <button class="btn btn-warning" name="edit"><span class="glyphicon glyphicon-save"></span>ตกลง</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              
              <div class="modal fade" id="detailUser<?php echo $_SESSION['u_id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">รายละเอียด</h4>
                      </div>
                      <div class="modal-body">
                          <table class="table table-sm table-bordered border-dark">
                            <tr>
                              <th class="table-active">ชื่อ</th>
                              <td><?php echo $fetch['u_name'] ?></td>
                            </tr>
                            <tr>
                              <th class="table-active">แผนก</th>
                              <td><?php echo $fetch['u_depart']?></td>
                            </tr>
                            <tr>
                              <th class="table-active">Username</th>
                              <td><?php echo $fetch['username']?></td>
                            </tr>
                            <tr>
                              <th class="table-active">Password</th>
                              <td><a id="spoiler" style="display:none"><?php echo $fetch['password']?></a>
                                <a title="ดู" type="button" class="btn btn-sm btn-outline-dark" onclick="if(document.getElementById('spoiler') .style.display=='none') {document.getElementById('spoiler') .style.display=''}else{document.getElementById('spoiler') .style.display='none'}"><i class="far fa-eye"></i>
                                </a>
                              </td>
                            </tr>
                            <tr>
                              <th class="table-active">อัพเดทล่าสุด</th>
                              <td><?php echo $fetch['u_datetime']?></td>
                            </tr>
                          </table>
                      </div>
                      <br style="clear:both;"/>
                  </div>
                </div>
              </div>
				<?php
					}
				?>
 <!------------------------------------------------------------------สิ้นสุดการแก้ไข--------------------------------------------------------------------------------------------->             
      <?php } ?>
      
    </div>
  </div>
</nav>