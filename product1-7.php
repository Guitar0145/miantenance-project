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
    <style>
        .card-item {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .card-item:hover {
        transform: scale(1.1); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        border: 1px solid green;
        transition:0.5s;
        }
    </style>
    
    </head>
<body>
    <?php include 'navbar-machine.php' ?>
    <div class="container-fluid">
        <div class="mt-2">
            <div class="card p-2">
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->              
                <div class="row">
                    <div class="col-12">
                                <form method="post" class="row g-1">
                                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2 col-xxl-2">
                                        <input type="text" name="serial" class="form-control shadow" id="serial" placeholder="serial" >
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2 col-xxl-2">
                                        <input type="text" name="name" class="form-control shadow" id="name" placeholder="name" >
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2 col-xxl-2">
                                        <input class="form-control shadow" type="file" id="formFile">
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-1 col-xxl-1">
                                        <select class="form-select shadow" aria-label="Default select example">
                                            <option selected>เลือกแผนก</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-1 col-xxl-1">
                                        <select class="form-select shadow" aria-label="Default select example">
                                            <option selected>สถานะการทำงาน</option>
                                            <option value="ใช้งานได้">ใช้งานได้</option>
                                            <option value="ปรับปรุง">ปรับปรุง</option>
                                            <option value="เสีย">เสีย</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-1 col-xxl-1">
                                        <select class="form-select shadow" aria-label="Default select example">
                                            <option selected>สถานเะครื่องจักร</option>
                                            <option value="Enable">Enable</option>
                                            <option value="Disable">Disable</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2 col-xxl-2">
                                        <button type="submit" name="submitlicense" class="btn btn-primary mb-3 shadow">เพิ่มเครื่องจักร <i class="far fa-check-circle"></i></button>
                                    </div>
                                </form>

                        <div class="card-header text-white" style="background-color: #BFBA0F;">
                            รายการเครื่องจักรแผนกทอ
                        </div>
                        <div class="card-body shadow p-4 mb-4 bg-white">
                            <div class="p-1 my-1 text-end" style="border: 1px solid #ccc; border-radius:10px; width:200px; position:absolute; right:0px; padding:15px; margin:40px;">
                                <span class="badge rounded-pill" style="background-color: #20c997;">ใช้งานได้</span>
                                <span class="badge rounded-pill" style="background-color: #fd7e14;">ปรับปรุง</span>
                                <span class="badge rounded-pill" style="background-color: #dc3545;">เสีย</span>
                            </div><br>
                            <br>
                        <div class="row g-4">
                            <div class="col-6 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                                <div class="card card-item" style="background-color:#20c997;">
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><img class="card-img-top" src="img/chainmachine.jpg" alt="Card image"></a>
                                <div class="card-body">
                                    <h6 class="card-title" style="color:white;">name machine</h6>
                                </div>
                                </div>
                            </div>
                            
                            <div class="col-6 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                                <div class="card card-item" style="background-color:#20c997;">
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><img class="card-img-top" src="img/chainmachine.jpg" alt="Card image"></a>
                                <div class="card-body">
                                    <h6 class="card-title" style="color:white;">name machine</h6>
                                </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                                <div class="card card-item" style="background-color:#20c997;">
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><img class="card-img-top" src="img/chainmachine.jpg" alt="Card image"></a>
                                <div class="card-body">
                                    <h6 class="card-title" style="color:white;">name machine</h6>
                                </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                                <div class="card card-item" style="background-color:#20c997;">
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><img class="card-img-top" src="img/chainmachine.jpg" alt="Card image"></a>
                                <div class="card-body">
                                    <h6 class="card-title" style="color:white;">name machine</h6>
                                </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                                <div class="card card-item" style="background-color:#20c997;">
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><img class="card-img-top" src="img/chainmachine.jpg" alt="Card image"></a>
                                <div class="card-body">
                                    <h6 class="card-title" style="color:white;">name machine</h6>
                                </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                                <div class="card card-item" style="background-color:#fd7e14;">
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><img class="card-img-top" src="img/chainmachine.jpg" alt="Card image"></a>
                                <div class="card-body">
                                    <h6 class="card-title" style="color:white;">name machine</h6>
                                </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                                <div class="card card-item" style="background-color:#20c997;">
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><img class="card-img-top" src="img/chainmachine.jpg" alt="Card image"></a>
                                <div class="card-body">
                                    <h6 class="card-title" style="color:white;">name machine</h6>
                                </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                                <div class="card card-item" style="background-color:#dc3545;">
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><img class="card-img-top" src="img/chainmachine.jpg" alt="Card image"></a>
                                <div class="card-body">
                                    <h6 class="card-title" style="color:white;">name machine</h6>
                                </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                                <div class="card card-item" style="background-color:#20c997;">
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><img class="card-img-top" src="img/chainmachine.jpg" alt="Card image"></a>
                                <div class="card-body">
                                    <h6 class="card-title" style="color:white;">name machine</h6>
                                </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                                <div class="card card-item" style="background-color:#20c997;">
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><img class="card-img-top" src="img/chainmachine.jpg" alt="Card image"></a>
                                <div class="card-body">
                                    <h6 class="card-title" style="color:white;">name machine</h6>
                                </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                                <div class="card card-item" style="background-color:#20c997;">
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><img class="card-img-top" src="img/chainmachine.jpg" alt="Card image"></a>
                                <div class="card-body">
                                    <h6 class="card-title" style="color:white;">name machine</h6>
                                </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                                <div class="card card-item" style="background-color:#20c997;">
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><img class="card-img-top" src="img/chainmachine.jpg" alt="Card image"></a>
                                <div class="card-body">
                                    <h6 class="card-title" style="color:white;">name machine</h6>
                                </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                                <div class="card card-item" style="background-color:#20c997;">
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><img class="card-img-top" src="img/chainmachine.jpg" alt="Card image"></a>
                                <div class="card-body">
                                    <h6 class="card-title" style="color:white;">name machine</h6>
                                </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                                <div class="card card-item" style="background-color:#fd7e14;">
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><img class="card-img-top" src="img/chainmachine.jpg" alt="Card image"></a>
                                <div class="card-body">
                                    <h6 class="card-title" style="color:white;">name machine</h6>
                                </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                                <div class="card card-item" style="background-color:#20c997;">
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><img class="card-img-top" src="img/chainmachine.jpg" alt="Card image"></a>
                                <div class="card-body">
                                    <h6 class="card-title" style="color:white;">name machine</h6>
                                </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                                <div class="card card-item" style="background-color:#dc3545;">
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><img class="card-img-top" src="img/chainmachine.jpg" alt="Card image"></a>
                                <div class="card-body">
                                    <h6 class="card-title" style="color:white;">name machine</h6>
                                </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                                <div class="card card-item" style="background-color:#20c997;">
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><img class="card-img-top" src="img/chainmachine.jpg" alt="Card image"></a>
                                <div class="card-body">
                                    <h6 class="card-title" style="color:white;">name machine</h6>
                                </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                                <div class="card card-item" style="background-color:#20c997;">
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><img class="card-img-top" src="img/chainmachine.jpg" alt="Card image"></a>
                                <div class="card-body">
                                    <h6 class="card-title" style="color:white;">name machine</h6>
                                </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                                <div class="card card-item" style="background-color:#20c997;">
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><img class="card-img-top" src="img/chainmachine.jpg" alt="Card image"></a>
                                <div class="card-body">
                                    <h6 class="card-title" style="color:white;">name machine</h6>
                                </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 col-xl-2 col-xxl-1">
                                <div class="card card-item" style="background-color:#20c997;">
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><img class="card-img-top" src="img/chainmachine.jpg" alt="Card image"></a>
                                <div class="card-body">
                                    <h6 class="card-title" style="color:white;">name machine</h6>
                                </div>
                                </div>
                            </div>
                
                    </div>
                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                <!--Start Modal แจ้งซ่อม-->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">แจ้งซ่อมเครื่องจักร</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                            <div class="input-group mb-2">
                                <span class="input-group-text" id="basic-addon1">ผู้แจ้งซ่อม</span>
                                <input type="text" class="form-control" placeholder="ชื่อผู้แจ้ง(ชื่อเล่่น)"  aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-2">
                                <label class="input-group-text" for="inputGroupSelect01">แผนก</label>
                                <select class="form-select" id="inputGroupSelect01">
                                    <option selected>เลือก...</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text" id="basic-addon1">เครื่องจักร</span>
                                <input type="text" class="form-control" placeholder="เครื่องทอ no.1.1" aria-describedby="basic-addon1">
                            </div>
                            <div class="mb-2">
                                <input type="text" class="form-control" value="เสีย" name="status">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text">อาการ..</span>
                                <textarea class="form-control" aria-label="With textarea"></textarea>
                             </div>
                             <div class="mb-2">
                                <input class="form-control" type="file" id="m_img" name="m_img">
                                <label for="formFile" class="form-label" style="color:red;">&nbsp;ใส่รูปภาพได้(ถ้ามี)</label>
                            </div>
                        </div>
                        <div class="modal-footer">    
                            <button type="submit" name="submitrepair" id="submitrepair" class="btn btn-primary">ยืนยัน</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        </div>
                        
                        </form>
                        </div>
                    </div>
                </div>
                <!--End Modal แจ้งซ่อม-->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
               
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
            </div>
        </div>
    </div>
   
    <?php include 'footer.php';?>
</body>
</html>