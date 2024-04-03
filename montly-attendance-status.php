<?php
include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}
$today=date('Y-m-d');
//$today='2022-10-16';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Montly Attendance Status | GB Pant</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
	<meta content="Coderthemes" name="author" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!-- App favicon -->
	<link rel="shortcut icon" href="assets/images/favicon.ico">

	<!-- Responsive Table css -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-stylesheet" />
	<link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />

	<!-- icons -->
	<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<style>
th{
	font-size: 14px;
	white-space: nowrap;
}
td{
	font-size: 13px;
	white-space: nowrap;
}
.font-weight-bold{
	font-weight: 700;
	text-align: center;
	border-right: 1px solid #edeff1;
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
                                    <h4 class="page-title">Montly Attendance Status</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Attendance</a></li>
                                            <li class="breadcrumb-item active">Montly Attendance Status</li>
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
                                        <form action="export-attendance.php" method="POST">
											<div class="row pt-2">
											
												<div class="col-lg-12">
												
													<div class="row">
														<div class="col-md-2 mb-2">
															<label>From Date</label>
															<input type="date" name="from_date" id="from_date" onchange="action_from_date(this.value)" class="form-control" max="<?= date("Y-m-d"); ?>">
														</div>
														<div class="col-md-2 mb-2" id="to_date_data">
															<label>To Date</label>
															<input type="date" name="to_date" id="to_date" class="form-control" max="<?= date("Y-m-d"); ?>">
														</div>
														<?php
														if($_SESSION['astro_role']=='Division'){
															$query1="select * from division where phone='".$_SESSION['astro_email']."'";
															$row1=$db->select($query1);
															$record1=$row1->fetch_array();
														?>
															<input type="hidden" name="work_location" id="work_location" value="Division">
															<input type="hidden" name="office_name" id="office_name" value="<?= $record1['id']; ?>">
														<?php
														}else if($_SESSION['astro_role']=='Deport'){
															$query1="select * from deport where phone='".$_SESSION['astro_email']."'";
															$row1=$db->select($query1);
															$record1=$row1->fetch_array();
														?>
															<input type="hidden" name="work_location" id="work_location" value="Division">
															<input type="hidden" name="office_name" id="office_name" value="<?= $record1['id']; ?>">
														<?php
														}else if($_SESSION['astro_role']=='Head Quarter'){
															$query1="select * from head_quarter where phone='".$_SESSION['astro_email']."'";
															$row1=$db->select($query1);
															$record1=$row1->fetch_array();
														?>
															<input type="hidden" name="work_location" id="work_location" value="Head Quarter">
															<input type="hidden" name="office_name" id="office_name" value="<?= $record1['id']; ?>">
														<?php
														}else{
														?>
															<div class="col-md-2 mb-2">
																<label>Work Location</label>
																<select name="work_location" id="work_location" onchange="action_work_location(this.value)" class="form-control">
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
														<?php
														}
														?>
														
														<!--div class="col-md-2 mb-2">
															<label>Work Location</label>
															<select name="work_location" id="work_location" onchange="action_work_location(this.value)" class="form-control">
																<option value="">~~~Choose~~~</option>
																<?php
																$query="select * from work_location";
																$row=$db->select($query);
																while($record=$row->fetch_array()){
																?>
																	<option value="<?= $record['work_location']; ?>"><?= $record['work_location']; ?></option>
																<?php
																}
																?>
															</select>
														</div-->
														<div class="col-md-6" id="work_location_name">
															<br />
															<input type="hidden" id="search_monthly_attendance_status" value="search_monthly_attendance_status">
															<a onclick="action_montly_print()" id="search_button" class="btn btn-success">Search</a>
														</div>
													</div>
												
												</div>
												<div class="col-lg-12" id="search_data">
													<div class="table-responsive">
														<table class="table table-sm mb-0">
															<thead>
																<tr class="bg-primary text-white">
																	<th>#</th>
																	<th>Employee Code</th>
																	<th>Employee Name</th>
																	<!--th>Designtaion</th-->
																</tr>
															</thead>
															<tbody></tbody>
														</table>
													</div> 
												</div>
											</form>
										   
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
function action_from_date(query_from_date){
	if(query_from_date != ''){
	    var action_from_date = 'fetch_to_date';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action_from_date:action_from_date, query_from_date:query_from_date},
			success:function(data){
				//alert(data);
			    $('#to_date_data').html(data);
			}
		})
	}
}
</script>

<script>
function action_work_location(query_work_location){
	var action_work_location = 'fetch_work_location_name';
	$.ajax({
		url:"query.php",
		method:"POST",
		data:{action_work_location:action_work_location, query_work_location:query_work_location},
		success:function(data){
			//alert(data);
			$('#work_location_name').html(data);
		}
	})
}
</script>

<script>	
function action_montly_print(){
	
	var action_montly_print = 'export_attendance';
	var search_monthly_attendance_status = $('#search_monthly_attendance_status').val();
	
	if($('#from_date').val() == ''){
		$('.form-control').css('border', '1px solid #ced4da');
		$('#from_date').css('border', '1px solid red');
	}else if($('#to_date').val() == ''){
		$('.form-control').css('border', '1px solid #ced4da');
		$('#to_date').css('border', '1px solid red');
	}else if($('#work_location').val() == ''){
		$('.form-control').css('border', '1px solid #ced4da');
		$('#work_location').css('border', '1px solid red');
	}else{
		
		if($('#work_location').val() == 'Division' || $('#work_location').val() == 'Depot'){
			if($('#office_name').val() == ''){
				$('.form-control').css('border', '1px solid #ced4da');
				$('#office_name').css('border', '1px solid red');
			}else{
				var from_date = $('#from_date').val();
				var to_date = $('#to_date').val();
				var work_location = $('#work_location').val();
				var office_name = $('#office_name').val();
				$.ajax({
					url:"query.php",
					method:"POST",
					data:{action_montly_print:action_montly_print, from_date:from_date, to_date:to_date, work_location:work_location, office_name:office_name, search_monthly_attendance_status:search_monthly_attendance_status},
					beforeSend:function(){
						$('#search_button').html('Please Wait...');
					},
					success:function(data){
						//alert(data);
						//$('#search_data').html(data);
						if(data=='Error'){
							$('#office_name').css('border', '1px solid red');
						}else{
							$('#search_data').html(data);
						}
						$('#search_button').html('Search');
					}
				})
			}
		}else{
			var from_date = $('#from_date').val();
			var to_date = $('#to_date').val();
			var work_location = $('#work_location').val();
			$.ajax({
				url:"query.php",
				method:"POST",
				data:{action_montly_print:action_montly_print, from_date:from_date, to_date:to_date, work_location:work_location, search_monthly_attendance_status:search_monthly_attendance_status},
				beforeSend:function(){
					$('#search_button').html('Please Wait...');
				},
				success:function(data){
					//alert(data);
					//$('#work_location_name').html(data);
					if(data=='Error'){
						$('#office_name').css('border', '1px solid red');
					}else{
						$('#search_data').html(data);
					}
					$('#search_button').html('Search');
				}
			})
		}
		
	}
	
	
}
</script>



<script>
$(document).ready(function(){
	$('#search_form1').on('submit', function(e){
		e.preventDefault();
		
		if($('#from_date').val() == ''){
			$('.form-control').css('border', '1px solid #ced4da');
			$('#from_date').css('border', '1px solid red');
		}else if($('#to_date').val() == ''){
			$('.form-control').css('border', '1px solid #ced4da');
			$('#to_date').css('border', '1px solid red');
		}else if($('#work_location').val() == ''){
			$('.form-control').css('border', '1px solid #ced4da');
			$('#work_location').css('border', '1px solid red');
		}else{
			$('.form-control').css('border', '1px solid #ced4da');
			$.ajax({
				url:'query.php',
				type:'POST',
				data:$('#search_form').serialize(),
				/*data:new FormData(this),  
				contentType:false,  
				processData:false,*/
				beforeSend:function(){
					$('#search_button').html('Please Wait...');
				},
				success:function(data){
					//alert(data);
					if(data=='Error'){
						$('#office_name').css('border', '1px solid red');
					}else{
						$('#search_data').html(data);
					}
					
					$('#search_button').html('Search');
				}
			});
		}
		
		
	});
});
</script>
 
    </body>
</html>