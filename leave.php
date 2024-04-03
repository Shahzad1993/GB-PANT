<?php
include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}

$today = date("Y-m-d");
$start_date1 = date("Y")."-01-01";
$end_date1 = date("Y")."-06-30";


$start_date2 = date("Y")."-07-01";
$end_date2 = date("Y")."-12-31";

if($today >= $start_date1 && $today <= $end_date1){
	$total_el= '16';
}else if($today >= $start_date2 && $today <= $end_date2){
	$total_el= '15';
}

$sql = "SELECT sum(no_of_days) as cl_count FROM `leave_request` WHERE employee = '".$_SESSION['astro_email']."' and leave_type='CL' and is_approved='1'";
$exe = $db->select($sql);
$record = $exe->fetch_array();
if ($record['cl_count'] == NULL) {
	$cl_count = 0;
}else{
	$cl_count = $record['cl_count'];
}
$total_cl_count = 14 - $cl_count;


$sql1 = "SELECT sum(no_of_days) as el_count FROM `leave_request` WHERE employee = '".$_SESSION['astro_email']."' and leave_type='EL' and is_approved='1'";
$exe1 = $db->select($sql1);
$record1 = $exe1->fetch_array();
if ($record1['el_count'] == NULL) {
	$el_count = 0;
}else{
	$el_count = $record1['el_count'];
}
$total_el_count = $total_el - $el_count;


$sql2 = "SELECT sum(no_of_days) as ml_count FROM `leave_request` WHERE employee = '".$_SESSION['astro_email']."' and leave_type='ML' and is_approved='1'";
$exe2 = $db->select($sql2);
$record2 = $exe2->fetch_array();
if ($record2['ml_count'] == NULL) {
	$ml_count = 0;
}else{
	$ml_count = $record2['ml_count'];
}
$total_ml_count = 12 - $ml_count;

?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Leave | UKPN</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

		<!-- App css -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
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
                                    <h4 class="page-title">Leave</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Leave</a></li>
                                            <li class="breadcrumb-item active">Leave</li>
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
										<a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#centermodal">Apply Leave</a>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                        </div>
						
						
                        <div class="row">
												
							<div class="col-xl-4 col-sm-6">
								<div class="card">
									<div class="card-body">
										<div class="d-flex align-items-start">
											<div class="flex-1">
												<h4 class="my-1 text-center"><a href="javascript:void(0);" class="text-dark">EARNED LEAVE</a></h4>
											</div>
										</div>
										<hr>
										<div class="text-muted">
											<div class="row">
												<div class="col-6">
													<div>
														<p class="text-truncate mb-0">AVAILABLE</p>
														<h5 class="mb-sm-0"><?= $total_el_count; ?></h5>
													</div>
												</div>
												<div class="col-6">
													<div>
														<p class="text-truncate mb-0">CONSUMED</p>
														<h5 class="mb-sm-0"><?= $el_count; ?></h5>
													</div>
												</div>
												
												<div class="col-12"><hr></div>
												<div class="col-12">
													<div>
														<p class="text-truncate mb-0">1 JULY - 31 DECEMBER QUOTA</p>
														<h5 class="mb-sm-0"><?= $total_el; ?></h5>
													</div>
												</div>
												
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-xl-4 col-sm-6">
								<div class="card">
									<div class="card-body">
										<div class="d-flex align-items-start">
											<div class="flex-1">
												<h4 class="my-1 text-center"><a href="javascript:void(0);" class="text-dark">CASUAL LEAVE</a></h4>
											</div>
										</div>
										<hr>
										<div class="text-muted">
											<div class="row">
												<div class="col-6">
													<div>
														<p class="text-truncate mb-0">AVAILABLE</p>
														<h5 class="mb-sm-0"><?= $total_cl_count; ?></h5>
													</div>
												</div>
												<div class="col-6">
													<div>
														<p class="text-truncate mb-0">CONSUMED</p>
														<h5 class="mb-sm-0"><?= $cl_count; ?></h5>
													</div>
												</div>
												
												<div class="col-12"><hr></div>
												<div class="col-12">
													<div>
														<p class="text-truncate mb-0">ANNUAL QUOTA</p>
														<h5 class="mb-sm-0">14</h5>
													</div>
												</div>
												
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-xl-4 col-sm-6">
								<div class="card">
									<div class="card-body">
										<div class="d-flex align-items-start">
											<div class="flex-1">
												<h4 class="my-1 text-center"><a href="javascript:void(0);" class="text-dark">MEDICAL LEAVE</a></h4>
											</div>
										</div>
										<hr>
										<div class="text-muted">
											<div class="row">
												<div class="col-6">
													<div>
														<p class="text-truncate mb-0">AVAILABLE</p>
														<h5 class="mb-sm-0"><i class="fa fa-infinity"></i></h5>
													</div>
												</div>
												<div class="col-6">
													<div>
														<p class="text-truncate mb-0">CONSUMED</p>
														<h5 class="mb-sm-0"><?= $ml_count; ?></h5>
													</div>
												</div>
												
												<div class="col-12"><hr></div>
												<div class="col-12">
													<div>
														<p class="text-truncate mb-0">ANNUAL QUOTA</p>
														<h5 class="mb-sm-0"><i class="fa fa-infinity"></i></h5>
													</div>
												</div>
												
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-xl-4 col-sm-6">
								<div class="card">
									<div class="card-body">
										<div class="d-flex align-items-start">
											<div class="flex-1">
												<h4 class="my-1 text-center"><a href="javascript:void(0);" class="text-dark">LEAVE WITHOUT PAY</a></h4>
											</div>
										</div>
										<hr>
										<div class="text-muted">
											<div class="row">
												<div class="col-6">
													<div>
														<p class="text-truncate mb-0">AVAILABLE</p>
														<h5 class="mb-sm-0"><i class="fa fa-infinity"></i></h5>
													</div>
												</div>
												<div class="col-6">
													<div>
														<p class="text-truncate mb-0">CONSUMED</p>
														<h5 class="mb-sm-0"><?= $ml_count; ?></h5>
													</div>
												</div>
												
												<div class="col-12"><hr></div>
												<div class="col-12">
													<div>
														<p class="text-truncate mb-0">ANNUAL QUOTA</p>
														<h5 class="mb-sm-0"><i class="fa fa-infinity"></i></h5>
													</div>
												</div>
												
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-xl-4 col-sm-6">
								<div class="card">
									<div class="card-body">
										<div class="d-flex align-items-start">
											<div class="flex-1">
												<h4 class="my-1 text-center"><a href="javascript:void(0);" class="text-dark">LIFTIME EL COUNT</a></h4>
											</div>
										</div>
										<hr>
										<div class="text-muted">
											<div class="row">
												<div class="col-6">
													<div>
														<p class="text-truncate mb-0">AVAILABLE</p>
														<h5 class="mb-sm-0">0</h5>
													</div>
												</div>
												<div class="col-6">
													<div>
														<p class="text-truncate mb-0">CONSUMED</p>
														<h5 class="mb-sm-0">0</h5>
													</div>
												</div>
												
												<div class="col-12"><hr></div>
												<div class="col-12">
													<div>
														<p class="text-truncate mb-0">Total QUOTA</p>
														<h5 class="mb-sm-0">0</h5>
													</div>
												</div>
												
											</div>
										</div>
									</div>
								</div>
							</div>
							
							
							
							
						</div>
						
						<div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
									
										<div class="table-responsive">
											<table class="table table-sm">
												<thead>
													<tr class="table-active">
														<th>From Date</th>
														<th>To Date</th>
														<th>Request Type</th>
														<th>Requested ON</th>
														<th>Note</th>
														<th>Status</th>
														<th>Action Taken By</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$i=1;
													$query="select * from leave_request where employee='".$_SESSION['astro_email']."' order by id desc";
													$row=$db->select($query);
													while($record=$row->fetch_array()){
													?>
														<tr>
															<td><?= date("d M, y",strtotime($record['from_date'])); ?></td>
															<td><?= date("d M, y",strtotime($record['to_date'])); ?></td>
															<td><?= $record['leave_type']; ?></td>
															<td>
																<?= date("d M, Y h:i A",strtotime($record['requested_on'])); ?>
																<br /><?= $_SESSION['astro_name']; ?>
															</td>
															<td><?= $record['notes']; ?></td>
															<td>
																<?php
																if($record['is_approved']=='1'){
																	echo '<span class="text-success">Approved</span>';
																}else{
																	echo '<span class="text-danger">Pending</span>';
																}
																?>
															</td>
															<td>
																<?= $record['action_taken_by']; ?>
																<br />
																<?php
																if($record['action_taken_on']!=NULL){
																	echo date("d M, y",strtotime($record['action_taken_on']));
																}
																?>
															</td>
															<td>
																<div class="dropdown float-end">
																	<a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false" title="Absent" style="line-height: 1;">
																		<i class="mdi mdi-dots-horizontal"></i>
																	</a>
																	<div class="dropdown-menu dropdown-menu-end">
																		<a href="javascript:void(0);" onclick="action9(<?= $record['id']; ?>)" class="dropdown-item">View Request</a>
																	</div>
																</div>
															</td>
														</tr>
													<?php
													$i++;
													}
													?>
												
												</tbody>
											</table>
										</div>
										
                                    </div>
                                </div>
                            </div>

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
$(document).ready(function(){
	$('#leave_form').on('submit', function(e){
		e.preventDefault();
		$.ajax({
			url:'query.php',
			type:'POST',
			//data:$('#leave_form').serialize(),
			data:new FormData(this),  
			contentType:false,  
			processData:false,
			beforeSend:function(){
				$('#leave_button').html('Please Wait...');
			},
			success:function(data){
				if(data=='Success'){
					$('#message').html('<p class="text-success">Leave Request Submitted Successfully!</p>');
					$('#leave_form')[0].reset();
					setInterval(function() {
						location.reload();
						//window.location.replace("dashboard");
					}, 1000);
				}else{
					$('#message').html('<p class="text-danger">'+data+'</p>');
				}
				$('#leave_button').html('Request');
			}
		});
	});
});
</script>

<script>
function action11(query11){
	if(query11 != ''){
		var from_date	= $('#from_date').val();
		
		var action11 = 'fetch_leave_type';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action11:action11, query11:query11, from_date:from_date},
			success:function(data){
				//alert(data);
				$('#leave_type').html(data);
			}
		})
	}
}
</script>

<script>
function action10(query10){
	if(query10 != ''){
		var action10 = 'fetch_end_date';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action10:action10, query10:query10},
			success:function(data){
				//alert(data);
				$('#end_date_id').html(data);
			}
		})
	}
}
</script>


<div class="modal fade" id="centermodal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myCenterModalLabel">Leave Request</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
			
				<form id="leave_form">
					<div class="row">
						<div class="col-md-12 mb-2" id="message"></div>
						<div class="col-md-12 mb-2">
							<label>From Date</label>
							<input type="text" name="from_date" id="from_date" class="form-control" onfocus="(this.type='date')" onchange="action10(this.value)" min="<?= $today; ?>" required>
						</div>
						<div class="col-md-12 mb-2" id="end_date_id">
							<label>To Date</label>
							<input type="text" name="to_date" class="form-control" onfocus="(this.type='date')" onchange="action11(this.value)" required>
						</div>
						<div class="col-md-12 mb-2">
							<label>Leave Types</label>
							<select name="leave_type" class="form-control" id="leave_type" required>
								<option value="">Select</option>
								<?php
								
								
								if($total_cl_count > 0){
								?>
									<option value="CL">CL ( <?= $total_cl_count; ?> Available )</option>
								<?php
								}else{
								?>
									<option value="CL" class="text-danger" disabled>CL ( Not Available )</option>
								<?php	
								}
								
								
								if($total_el_count > 0){
								?>
									<option value="CL">EL ( <?= $total_el_count; ?> Available )</option>
								<?php
								}else{
								?>
									<option value="CL" class="text-danger" disabled>EL ( Not Available )</option>
								<?php	
								}
								?>
								<option value="ML">ML ( &#x221E; Available )</option>
								<option value="LW">Leave Without Pay ( &#x221E; Available )</option>
							</select>
						</div>
						<div class="col-md-12 mb-2">
							<label>Notes</label>
							<textarea name="notes" class="form-control" rows="5" required></textarea>
						</div>
						<div class="col-md-12 mb-3">
							<label>Upload Document</label><br />
							<input type="file" name="documents">
						</div>
						
						<div class="col-md-12 mb-2">
							<input type="hidden" name="add_leave" value="add_leave">
							<button type="submit" id="leave_button" class="btn btn-success">Request</button>
						</div>
						
					</div>
				</form>
				
			</div>
		</div>
	</div>
</div>



    </body>
</html>