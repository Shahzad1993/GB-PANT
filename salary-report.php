<?php
include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}

$current_month = date("m");
$current_year = date("Y");

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Salary Report | GB Pant</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
	<meta content="Coderthemes" name="author" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!-- App favicon -->
	<link rel="shortcut icon" href="assets/images/favicon.ico">

	<!-- Responsive Table css -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-stylesheet" />
	<link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />

	<!-- icons -->
	<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<style>
th{
	font-size: 14px;
}
td{
	font-size: 13px;
}
</style>
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
                                    <h4 class="page-title">Salary Report</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                                            <li class="breadcrumb-item active">Salary Report</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form id="salary_search_form">
											<div class="row pt-2">
												<div class="col-lg-3">
													<label>Month</label>
													<select class="form-control" name="month" required>
														<option value="">Month</option>
														<?php
														$query51 = "SELECT * FROM `month`";
														$row51 = $db->select($query51);
														while($record51 = $row51->fetch_array()){
															if($record51['month_no']==$current_month){
														?>
															<option value="<?= $record51['month_no']; ?>" selected><?= $record51['month_name']; ?></option>
														<?php
															}else{
														?>
															<option value="<?= $record51['month_no']; ?>"><?= $record51['month_name']; ?></option>
														<?php	
															}
														}
														?>
													</select>
												</div>
												<div class="col-lg-3">
													<label>Year</label>
													<select class="form-control" name="year" required>
														<option value="">Year</option>
														<?php
														for($i=date("Y"); $i > 2000; $i--){
															if($i==$current_year){
														?>
															<option value="<?= $i; ?>" selected><?= $i; ?></option>
														<?php
															}else{
														?>
															<option value="<?= $i; ?>"><?= $i; ?></option>
														<?php
															}
														}
														?>
													</select>
												</div>
												<div class="col-lg-6">
													<br />
													<input type="hidden" name="salary_search" value="salary_search">
													<button type="submit" id="salary_search_button" class="btn btn-primary">Search</button>
												</div>
											</div>
                                        </form>
										
										<div class="row pt-2">
											<div class="col-lg-12" id="message"></div>
											<div class="col-lg-12">
												<form id="attendance_request_approval_form">
													<div class="table-responsive">
														<table class="table table-sm mb-0">
															<thead>
																<tr class="table-active">
																	<th>#</th>
																	<th>Employee Code</th>
																	<th>Name</th>
																	<th>Basic Amount</th>
																	<th>Grade Pay</th>
																	<th>Total Allowence</th>
																	<th>Total Deduction</th>
																	<th>LIC Premium</th>
																	<th>Salary Amount</th>
																	<th>Payble Amount</th>
																	<th>Action</th>
																</tr>
															</thead>
															<tbody id="salary_search_data"></tbody>
														</table>
													</div>
												</form>
											</div>
										   
										</div>
										
                                    </div>
                                </div>
                            </div>
                        </div>
                        
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

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- Responsive Table js -->
        <script src="assets/libs/admin-resources/rwd-table/rwd-table.min.js"></script>

        <!-- Init js -->
        <script src="assets/js/pages/responsive-table.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>

<script>
function action13(query13){
	if(query13 != ''){
	    var action13 = 'fetch_attendance_request';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action13:action13, query13:query13},
			success:function(data){
				//alert(data);
			    $('#attendance_request_data').html(data);
			}
		})
	}
}
</script>     

<script>
function action9(query9){
	if(query9 != ''){
	    var action9 = 'regulize_popup';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action9:action9, query9:query9},
			success:function(data){
			    //location.reload();
			    //alert(data);
			    $('#view_request_details').html(data);
			    $('#view_request_popup').modal('show');
			}
		})
	}
}
</script>     

<div class="modal fade show" id="view_request_popup" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="regulize_form">
            <div class="modal-content" id="view_request_details">
                
            </div>
        </form>
    </div>
</div>

<script>
$("#checkAll").click(function(){
    $('.checkAllData').not(this).prop('checked', this.checked);
});
</script>

<script>
$(document).ready(function(){
	$('#salary_search_form').on('submit', function(e){
		e.preventDefault();
		$.ajax({
			url:'query',
			type:'POST',
			data:$('#salary_search_form').serialize(),
			beforeSend:function(){
				$('#salary_search_button').html('Please Wait...');
			},
			success:function(data){
				//alert(data);
				if(data=='Error'){
					$('#salary_search_data').html('<span class="text-danger">Invalid Date!</span>');
				}else{
					$('#salary_search_data').html(data);
				}
				$('#salary_search_button').html('Search');
			}
		});
	});
});
</script>

    </body>
</html>