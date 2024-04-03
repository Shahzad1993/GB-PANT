<?php
include 'config/main.php';
$db = new Main;

if(empty($_SESSION['mobile_otp'])){
	header("Location: ./");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Verify OTP | HRM</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

		<!-- App css -->
		<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-stylesheet" />
		<link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />

		<!-- icons -->
		<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    </head>

    <body class="loading" style="background:url('assets/images/bg1.jpg');background-repeat: no-repeat;background-size: 100% 100%;">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-4">
                        <div class="card">

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <div class="auth-logo">
                                        <a href="./" class="logo logo-dark text-center">
											<img src="assets/images/logo-light.png" alt="logo" style="width:100px"><br /><br />
											<h3>UTTRAKHAND PARIVAHAN NIGAM</h3>
                                        </a>
									</div>
                                    <p class="text-muted mb-4 mt-3">Enter OTP to access Your Account.</p>
                                    <p id="message"></p>
                                </div>

                                <form id="login_form">

                                    <div class="mb-2">
                                        <label for="emailaddress" class="form-label">Enter OTP</label>
                                        <input class="form-control" type="text" name="otp" id="emailaddress" required="" placeholder="Enter OTP" maxlength="4" minlength="4">
                                    </div><br />

                                    <div class="d-grid mb-0 text-center">
										<input type="hidden" name="verify_otp_admin" value="verify_otp_admin">
                                        <button class="btn btn-primary" type="submit" id="login_button"> VERIFY OTP </button>
                                    </div>

                                </form>

                            </div> <!-- end card-body -->
                        </div>
                        
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <footer class="footer footer-alt">
            <script>document.write(new Date().getFullYear())</script> &copy; UKPN by <a href="#" class="text-dark">The Design House</a> 
        </footer>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
<script>
	$(document).ready(function(){
		$('#login_form').on('submit', function(e){
			e.preventDefault();
			$.ajax({
				url:'query',
				type:'POST',
				data:$('#login_form').serialize(),
				beforeSend:function(){
					$('#login_button').html('Please Wait...');
				},
				success:function(data){
					//alert(data);
					if(data=='Success'){
						$('#message').html('<p class="text-success">Login Successfull!</p>');
						$('#login_form')[0].reset();
						$('#login_button').html('<i class="las la-check-double"></i>');
						setTimeout(function() {
							window.location.replace("dashboard");
						}, 1000); 
					}else{
						$('#message').html('<p class="text-danger">'+data+'</p>');
						$('#login_button').html('VERIFY OTP');
					}
					
					
				}
			});
		});
	});
</script>        
    </body>
</html>