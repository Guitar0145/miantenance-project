<div class="btn-group">
    <button type="button" class="p-1 badge btn bg-primary dropdown-toggle position-relative" data-bs-toggle="dropdown" aria-expanded="false">จัดการ</button>
    <?php if($_SESSION['level'] == 'Admin' ) {?>
        <?php if ($countWorking > 0 ){?>
            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
        <?php } ?>
    <?php } ?>
    
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#" onclick="window.open(this.href='task-detail.php?id=<?php echo $listelect['m_id'] ?>','popUpWindow','height=600,width=700,left=200,top=200,,scrollbars=yes,menubar=no'); return false;">ดูเพิ่มเติม</a></li>
        <li><a class="dropdown-item" href="#" name="editIssue2" id="editIssue2" data-bs-toggle="modal" data-bs-target="#editIssue2<?php echo $listelect['m_id']?>">แก้ไขอาการ</a></li>
        <?php if($_SESSION['level'] == 'Admin' ) {?>
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