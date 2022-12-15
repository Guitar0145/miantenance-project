<?php
    session_start();
    $error = "";
    isset( $_POST['username'] ) ? $username = $_POST['username'] : $username = "";
    isset( $_POST['password'] ) ? $password = $_POST['password'] : $password = "";
    if( !empty( $username ) && !empty( $password ) ) {
        $c = mysqli_connect( "localhost", "root", "rootroot", "mtservice" );
        mysqli_query( $c, "SET NAMES UTF8" );
        $sql = " 
                SELECT * FROM user 
                WHERE 
                ( username = '{$username}' ) AND  
                ( password = '{$password}' ) 
            ";
        $q = mysqli_query( $c, $sql );
        $f = mysqli_fetch_assoc( $q );
        if( isset( $f['u_id'] ) ) {
            $_SESSION['u_id'] = $f['u_id'];
            $_SESSION['username'] = $f['username'];
            $_SESSION['level'] = $f['level'];
            $_SESSION['u_name'] = $f['u_name'];
            echo "<script>alert('เข้าสู่ระบบ สำเร็จ !!');</script>";
            echo "<script>window.location.href='index.php'</script>";
        } else {
            echo "<script>alert('เข้าสู่ระบบ ไม่สำเร็จ !');</script>";
            echo "<script>window.location.href='login.php'</script>";
        }
        mysqli_close( $c );
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-5 pt-3" width="50">
						
					</div>
					<div class="card shadow-lg">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4">Login</h1>
							<form action="login.php" method="POST">
								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">Username</label>
									<input id="username" type="text" class="form-control" name="username" value="" required autofocus>
									<div class="invalid-feedback">
										Username
									</div>
								</div>

								<div class="mb-3">
									<div class="mb-2 w-100">
										<label class="text-muted" for="password">Password</label>
										
									</div>
									<input id="password" type="password" class="form-control" name="password" required>
								    <div class="invalid-feedback">
								    	Password is required
							    	</div>
								</div>

								<div class="text-center">
									<button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
                                    <a type="submit"  class="btn btn-secondary" href="index.php">ยกเลิก</a>
								</div>
							</form>
						</div>
						<div class="card-footer py-3 border-0">
							<div class="text-center">
								ไม่มีบัญชีเข้าสู่ระบบ ? <a href="" class="text-dark">ติดต่อ IT & Stock</a>
							</div>
						</div>
					</div>
					<div class="text-center mt-5 text-muted">
						Copyright &copy; 2022 &mdash; Shining Gold
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>