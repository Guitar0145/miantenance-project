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
    <?php include 'navbar.php' ?>
    <div class="container-fluid">
        <div class="p-3 mt-3">
            <div class="card p-3">
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->              
                <div class="row">
                    <div class="col-12">
                        <div class="card-header bg-secondary text-white">
                            รายการแจ้งซ่อมทั้งหมด
                        </div>
                        <div class="card-body shadow p-4 mb-4 bg-white">
                               
                                
                        </div>
                    </div>
                </div>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                <div class="row">
                    <div class="col-6">
                        <div class="card-header bg-secondary text-white">
                            รายการแจ้งซ่อมทั้งหมด
                        </div>
                        <div class="card-body shadow p-4 mb-4 bg-white">
                        1 of 2          
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card-header bg-secondary text-white">
                            รายการแจ้งซ่อมทั้งหมด
                        </div>
                        <div class="card-body shadow p-4 mb-4 bg-white">
                            1 of 2          
                        </div>
                    </div>
                </div>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                <div class="row">
                    <div class="col-6">
                        <div class="card-header bg-secondary text-white">
                            รายการแจ้งซ่อมทั้งหมด
                        </div>
                        <div class="card-body shadow p-4 mb-4 bg-white">
                            <label for="customRange2" class="form-label">ระดับความยากง่ายของงาน</label>
                            <input type="range" class="form-range" min="1" max="5" id="myRange">
                            <p>ความยาก : <span id="demo"></span></p>
                            <input type="hidden" name="checkstatus" id="checkstatus" value="รอตรวจสอบ">         
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card-header bg-secondary text-white">
                            รายการแจ้งซ่อมทั้งหมด
                        </div>
                        <div class="card-body shadow p-4 mb-4 bg-white">
                            1 of 2          
                        </div>
                    </div>
                </div>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
            </div>
        </div>
    </div>
   
    <?php include 'footer.php';?>
</body>
<script>
var slider = document.getElementById("myRange");
var output = document.getElementById("demo");
output.innerHTML = slider.value;

slider.oninput = function() {
  output.innerHTML = this.value;
}
</script>
</html>