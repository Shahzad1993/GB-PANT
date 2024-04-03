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
	<title>Todays's Attendance | GB Pant</title>
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
                                    <h4 class="page-title">Todays's Attendance</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Attendance</a></li>
                                            <li class="breadcrumb-item active">Todays's Attendance</li>
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
                                        
										<div class="row pt-2">
											
											<div class="col-lg-12">
												<div class="table-responsive">
													<table class="table table-sm mb-0">
														<thead>
															<tr>
																<th colspan="9" style="font-size:20px;"><?= date("l - d M, Y"); ?></th>
															</tr>
															<tr>
																<th colspan="8" style="font-size:20px;">
																	<div class="col-lg-12">
												
																		<div class="row">
																			<?php
																			if($_SESSION['astro_role']=='Admin'){
																				
																			?>
																				<div class="col-md-3 mb-2">
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
																				<div class="col-md-9" id="work_location_name">
																					<br />
																					<input type="hidden" id="search_monthly_attendance_status" value="search_monthly_attendance_status">
																					<a onclick="action_montly_print()" id="search_button" class="btn btn-success">Search</a>
																				</div>
																			<?php
																			}
																			?>
																			
																		</div>
																	
																	</div>
																</th>
															</tr>
															<tr class="bg-primary text-white">
																<th>#</th>
																<th>Employee Code</th>
																<th>Employee Name</th>
																<th>Work Location</th>
																<th>Check-In</th>
																<th>Check-Out</th>
																<th>Location</th>
																<th>Effective Hour</th>
																<th>Arrival</th>
															</tr>
														</thead>
														<tbody id="search_data">
															<?php
															if($_SESSION['astro_role']!='Admin'){
																$output = '';
																$day_name = date('D', strtotime($today));
																
																if($_SESSION['astro_role']=='Division'){
																	$query1="select * from division where phone='".$_SESSION['astro_email']."'";
																	$row1=$db->select($query1);
																	$record1=$row1->fetch_array();
																	
																	$query5="select * from employee where (attendance_type!='Manual' or attendance_type!=NULL) and work_location='Division' and office_name='".$record1['id']."'";
																}else if($_SESSION['astro_role']=='Depot'){
																	$query2="select * from deport where phone='".$_SESSION['astro_email']."'";
																	$row2=$db->select($query2);
																	$record2=$row2->fetch_array();
																	
																	$query5="select * from employee where (attendance_type!='Manual' or attendance_type!=NULL) and work_location='Deport' and office_name='".$record1['id']."'";
																}else if($_SESSION['astro_role']=='Head Quarter'){
																	$query2="select * from head_quarter where phone='".$_SESSION['astro_email']."'";
																	$row2=$db->select($query2);
																	$record2=$row2->fetch_array();
																	
																	$query5="select * from employee where (attendance_type!='Manual' or attendance_type!=NULL) and work_location='Head Quarter'";
																}else{
																	$query5="select * from employee where (attendance_type!='Manual' or attendance_type!=NULL) order by employee_name asc";
																}
																$i=1;
																$row5 = $db->select($query5);
																if ($row5->num_rows > 0) {
																	while($record5 = $row5->fetch_array()){
																		
																		if(strtoupper($day_name)==$record5['weekly_rest']){
																			$output .= '<tr class="bg-warning text-white">
																					<td>'.$i.'</td>
																					<td>'.$record5['employee_code'].'</td>
																					<td>'.$record5['employee_name'].'</td>
																					<td>'.$record5['work_location'].'</td>
																					<td colspan="5">Weekly Off</td>
																				</tr>';
																		}else{
																			$query4 = "SELECT * FROM `attendance` WHERE employee='".$record5['phone']."' and attendance_date='$today'";
																			$row4 = $db->select($query4);
																			if ($row4->num_rows > 0) {
																				$record4 = $row4->fetch_array();
																				
																				$check_in = $record4['check_in'];
																				if($record4['check_out']==NULL){
																					$hour = '0h 0m';
																				}else{
																					$check_out = $record4['check_out'];
																					
																					$diff = abs(strtotime($check_in) - strtotime($check_out));
																					$tmins = $diff/60;
																					$hours = floor($tmins/60);
																					$mins = $tmins%60;
																					
																					$hour = $hours.'h '.$mins.'m';
																				}
																				
																				if(strtotime($check_in) <= strtotime('09:30 AM')){
																					$arrival = 'On Time';
																				}else{
																					$arrival1 = abs(strtotime('09:30 AM') - strtotime($check_in));
																					
																					$tmins1 = $arrival1/60;
																					$hours1 = floor($tmins1/60);
																					$mins1 = $tmins%60;
																					
																					$arrival = $hours1.'h '.$mins1.'m late';
																				}
																				
																			$output .= '<tr>
																					<td>'.$i.'</td>
																					<td>'.$record5['employee_code'].'</td>
																					<td>'.$record5['employee_name'].'</td>
																					<td>'.$record5['work_location'].'</td>
																					<td><i class="fa fa-arrow-right text-success" style="transform: rotate(135deg);"></i> &nbsp;'.$record4['check_in'].'</td>';
																					if($record4['check_out']==NULL){
																						$output .= '<td>--:--</td>';
																					}else{
																						$output .= '<td><i class="fa fa-arrow-right text-danger" style="transform: rotate(315deg);"></i> &nbsp;'.$record4['check_out'].'</td>';
																					}
																					$output .= '<td><a href="javascript:void(0)" onclick="action_map('.$record4['id'].')"><i class="fa fa-map-marker-alt"></i></a></td>
																					<td>'.$hour.'</td>
																					<td>'.$arrival.'</td>
																					
																				</tr>';
																			}else{
																				$output .= '<tr>
																					<td>'.$i.'</td>
																					<td>'.$record5['employee_code'].'</td>
																					<td>'.$record5['employee_name'].'</td>
																					<td>'.$record5['work_location'].'</td>
																					<td>--:--</td>
																					<td>--:--</td>
																					<td>-----</td>
																					<td>-----</td>
																					<td>-----</td>
																				</tr>';
																			}
																		}																		
																		$i++;
																	}
																}else{
																	$output .="Employee Doesn't Exist!";
																}
																
																echo $output;
															}
															?>
														</tbody>
													</table>
												</div> 
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
function action12(query12){
	if(query12 != ''){
	    var action12 = 'fetch_attendance';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action12:action12, query12:query12},
			success:function(data){
				//alert(data);
			    $('#attendance_list_data').html(data);
			}
		})
	}
}
</script> 
 
<script>
function action_map(query_map){
	if(query_map != ''){
	    var action_map = 'fetch_attendance_map';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action_map:action_map, query_map:query_map},
			success:function(data){
				//alert(data);
				$('#map_data').html(data);
				$("#centermodal").modal('show');
			}
		})
	}
}
</script>

<div class="modal fade" id="centermodal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myCenterModalLabel">Attendance Location</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row" id="map_data"></div>
			</div>
		</div>
	</div>
</div>

<script>
function action_work_location(query_work_location){
	var action_work_location = 'fetch_work_location_name1';
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
	var search_today_attendance_status = $('#search_today_attendance_status').val();
	
	if($('#work_location').val() == ''){
		$('.form-control').css('border', '1px solid #ced4da');
		$('#work_location').css('border', '1px solid red');
	}else{
		
		if($('#work_location').val() == 'Division' || $('#work_location').val() == 'Depot'){
			if($('#office_name').val() == ''){
				$('.form-control').css('border', '1px solid #ced4da');
				$('#office_name').css('border', '1px solid red');
			}else{
				var work_location = $('#work_location').val();
				var office_name = $('#office_name').val();
				$.ajax({
					url:"query.php",
					method:"POST",
					data:{action_montly_print:action_montly_print, work_location:work_location, office_name:office_name, search_today_attendance_status:search_today_attendance_status},
					beforeSend:function(){
						$('#search_button').html('Please Wait...');
					},
					success:function(data){
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
			
			var work_location = $('#work_location').val();
			$.ajax({
				url:"query.php",
				method:"POST",
				data:{action_montly_print:action_montly_print, work_location:work_location, search_today_attendance_status:search_today_attendance_status},
				beforeSend:function(){
					$('#search_button').html('Please Wait...');
				},
				success:function(data){
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

    </body>
</html>