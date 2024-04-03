<?php
include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}
if($_SESSION['astro_role']!='Admin'){
	header("Location: dashboard");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>View Employee | GB Pant</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Responsive Table css -->
        <link href="assets/libs/admin-resources/rwd-table/rwd-table.min.css" rel="stylesheet" type="text/css" />

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
                                    <h4 class="page-title">View Employee</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Employee</a></li>
                                            <li class="breadcrumb-item active">View Employee</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
									
										<div class="row pt-2">
											<div class="col-lg-12">
												<form id="department_form">
													<div class="row">
														<div class="col-md-4 mb-2">
															<label>Work Location</label>
															<select name="work_location" id="work_location" onchange="action_work_location_view_post(this.value)" class="form-control">
																<option value="">~~~Choose~~~</option>
																<?php
																$query="select * from work_location";
																$row=$db->select($query);
																while($record=$row->fetch_array()){
																?>
																	<option value="<?= $record['work_location']; ?>"><?= $record['work_location_name']; ?></option>
																<?php
																}
																?>
															</select>
														</div>
														<div class="col-md-8" id="work_location_name">
															<br />
															<input type="hidden" name="search_employee" value="search_employee">
															<button type="submit" id="search_button" class="btn btn-success">Search</button>
														</div>
													</div>
												</form>
											</div>
											<div class="col-lg-12">
												<div class="responsive-table-plugin" id="employee_data">
													<div class="table-responsive">
														<table class="table table-bordered">
															<thead>
																<tr class="text-nowrap bg-primary text-white">
																	<th>#</th>
																	<th>Profile Pic</th>
																	<th>Employee Code</th>
																	<th>Employee Name</th>
																	<th>Work Location</th>
																	<th>Post Name</th>
																	<th>Mobile</th>
																	<!--th>Password</th-->
																	<th>Action</th>
																</tr>
															</thead>
															<tbody id="request_data"></tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									
                                    </div>
                                </div> <!-- end card -->
                            </div> <!-- end col -->
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

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- Responsive Table js -->
        <script src="assets/libs/admin-resources/rwd-table/rwd-table.min.js"></script>

        <!-- Init js -->
        <script src="assets/js/pages/responsive-table.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
<script>
function action_work_location_view_post(query_work_location){
	var action_work_location_view_post = 'fetch_work_location_name';
	$.ajax({
		url:"query.php",
		method:"POST",
		data:{action_work_location_view_post:action_work_location_view_post, query_work_location:query_work_location},
		success:function(data){
			//alert(data);
			$('#work_location_name').html(data);
		}
	})
}
</script>

<script>
$(document).ready(function(){
	$('#department_form').on('submit', function(e){
		e.preventDefault();
		$.ajax({
			url:'query.php',
			type:'POST',
			data:$('#department_form').serialize(),
			/*data:new FormData(this),  
			contentType:false,  
			processData:false,*/
			beforeSend:function(){
				$('#search_button').html('Please Wait...');
			},
			success:function(data){
				//alert(data);
				$('#employee_data').html(data);
				$('#search_button').html('Search');
			}
		});
	});
});
</script>  

<script>
function action_search(employee_no){
	var action_search = 'fetch_search_data';
	var work_location = $('#work_location').val();
	
	if ($('#office_name').length){
		var office_name = $('#office_name').val();
	}else{
		var office_name = '';
	}
	$.ajax({
		url:"query.php",
		method:"POST",
		data:{action_search:action_search, employee_no:employee_no, work_location:work_location, office_name:office_name},
		beforeSend: function() {
			$('#loader').removeClass('hidden');
		},
		success:function(data){
			//alert(data);
			$('#employee_data_search').html(data);
			$('#loader').addClass('hidden');
		}
	})
	
}
</script>
    
    </body>
</html>