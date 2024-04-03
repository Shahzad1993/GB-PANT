<?php
include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Order | UKPN</title>
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

    <body class="loading">
		<!-- Begin page -->
        <div id="wrapper">
			<!-- Topbar Start -->
            <?php include "inc/header.php"; ?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            <?php include "inc/sidebar.php"; ?>
            <!-- Left Sidebar End -->
      
            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">New Order</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Order</a></li>
                                            <li class="breadcrumb-item active">New Order</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <div class="row pt-2">
											<div class="col-lg-4">
												<label>Employee Code</label>
												<input type="text" class="form-control" onchange="action17(this.value)" placeholder="Employee Code" required="">
											</div>
										</div>
                                        <form id="add_order_form">
											<div class="row pt-2" id="order_list_data"></div>
										</form>
                                    </div>
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                        </div>
                        <!-- end row -->
					</div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <?php include "inc/footer.php"; ?>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
		<script src="assets/js/vendor.min.js"></script>
		<script src="assets/libs/parsleyjs/parsley.min.js"></script>
		<script src="assets/js/pages/form-validation.init.js"></script>
		<script src="assets/js/app.min.js"></script>
		
<script>
function action17(query17){
	if(query17 != ''){
		var action17 = 'fetch_order_list_data';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action17:action17, query17:query17},
			success:function(data){
				//alert(data);
				$('#order_list_data').html(data);
			}
		})
	}
}
</script>

<script>
$(document).ready(function(){
	$('#add_order_form').on('submit', function(e){
		e.preventDefault();
		$.ajax({
			url:'query.php',
			type:'POST',
			//data:$('#department_form').serialize(),
			data:new FormData(this),  
			contentType:false,  
			processData:false,
			beforeSend:function(){
				$('#add_order_button').html('Please Wait...');
			},
			success:function(data){
				//alert(data);
				if(data=='Error'){
					$('#message').html('<p class="text-danger">Something went wrong!</p>');
					
					/*setInterval(function() {
						location.reload();
						//window.location.replace("dashboard");
					}, 1000);*/
				}else{
					$('#order_list_data_all').html(data);
					$('#message').html('<p class="text-success">Employee Added Successfully!</p>');
					$('#add_order_form')[0].reset();
				}
				$('#add_order_button').html('Save');
				
			}
		});
	});
});
</script>



    </body>
</html>