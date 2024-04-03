<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Log In | GOVIND BALLABH PANT UNIVERSITY OF AGRICULTURE & TECHNOLOGY</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" name="description" />
        <meta content="" name="author" />
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
											<h4>GOVIND BALLABH PANT UNIVERSITY OF AGRICULTURE & TECHNOLOGY</h4>
                                        </a>
									</div>
                                    <p class="text-muted mb-4 mt-3">Enter your Mobile No. / User Name and password to access admin panel.</p>
                                    <p id="message"></p>
                                </div>

                                <form id="login_form">

                                    <div class="mb-2">
                                        <label for="emailaddress" class="form-label">Mobile No. / User Name</label>
                                        <input class="form-control block_special" type="text" name="phone" id="emailaddress" required="" placeholder="Mobile No. / User Name">
                                    </div>

                                    <div class="mb-2">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
                                            <div class="input-group-text" data-password="false">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="g-recaptcha" data-sitekey="6Lc-uaspAAAAAHhgR5ULbxcRxvIPn4HO5DC9FouB"></div><br>
									<div class="d-grid mb-0 text-center">
										<input type="hidden" name="login" value="login">
                                        <button class="btn btn-primary" type="submit" id="login_button"> Log In </button>
                                    </div>

                                </form>

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p> <a href="auth-recoverpw.html" class="text-muted ms-1">Forgot your password?</a></p>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <footer class="footer footer-alt">
            <script>document.write(new Date().getFullYear())</script> &copy; GOVIND BALLABH PANT UNIVERSITY OF AGRICULTURE & TECHNOLOGY by <a href="#" class="text-dark">PATh2VILLAGE</a> 
        </footer>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
						$('#login_button').html('Sign In');
					}
					
					
				}
			});
		});
	});
</script>     

<script type="text/javascript">
    $(function () {
        $(".block_special").keypress(function (e) {
            var keyCode = e.keyCode || e.which;
			var regex = /^[0-9A-Za-z.@]+$/;
			var isValid = regex.test(String.fromCharCode(keyCode));
            return isValid;
        });
    });
</script>
   
    </body>
</html>