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
        <title>Employee History | GB Pant</title>
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
<style>
th,td{
	padding: 8px .85rem !important;
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

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Employee History</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">History</a></li>
                                            <li class="breadcrumb-item active">Employee History</li>
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
										<form id="form_id">	
											<div class="row">
												<!--div class="col-md-4 mb-3">
													<label class="form-label">Employee Code</label>
													<input type="text" name="employee_code" class="form-control" onkeyup="action19(this.value)" placeholder="Employee Code" required>
												</div-->
												
												<div class="col-md-12" id="message"></div>
												<?php
												if($_SESSION['astro_role']=='Admin'){
												?>
													<div class="col-md-3 mb-3">
														<label class="form-label">Work Location</label>
														<select name="work_location" id="work_location" onchange="action31(this.value)" class="form-control">
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
													<div class="col-md-3 mb-3" id="dep_div_data"></div>
													<div class="col-md-3 mb-3" id="employee_data"></div>
												<?php
												}elseif($_SESSION['astro_role']=='Head Quarter'){
													$output ='<div class="col-md-3 mb-3" id="employee_data">
														<input type="hidden" name="work_location" id="work_location" value="Head Quarter">
														<label class="form-label">Employee</label>
														<select name="employee" id="employee_name" onchange="action23(this.value)" class="form-control" required>';
															$output .= '<option value="">~~~Choose~~~</option>';
															$query="select * from employee where work_location='Head Quarter'";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
																$query1="select * from post where id='".$record['post']."'";
																$row1=$db->select($query1);
																$record1=$row1->fetch_array();
																$output .= '<option value="'.$record['employee_code'].'">'.$record['employee_code'].' - '.$record['employee_name'].' &nbsp;&nbsp;&nbsp;&nbsp;( '.$record1['post_name'].' )</option>';
															}
														$output .='</select></div>';
													
													echo $output;
												}else if($_SESSION['astro_role']=='Division'){
													$query11="select * from division where phone='".$_SESSION['astro_email']."'";
													$row11=$db->select($query11);
													$record11=$row11->fetch_array();
													
													$output ='<div class="col-md-3 mb-3" id="employee_data">
														<input type="hidden" name="work_location" id="work_location" value="Division">
														<input type="hidden" name="office_name" id="office_name" value="'.$record11['id'].'">
														<label class="form-label">Employee</label>
															<select name="employee" id="employee_name" onchange="action23(this.value)" class="form-control" required>';
															$output .= '<option value="">~~~Choose~~~</option>';
															$query="select * from employee where work_location='Division' and office_name='".$record11['id']."'";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
																$query1="select * from post where id='".$record['post']."'";
																$row1=$db->select($query1);
																$record1=$row1->fetch_array();
																
																$output .= '<option value="'.$record['employee_code'].'">'.$record['employee_code'].' - '.$record['employee_name'].' &nbsp;&nbsp;&nbsp;&nbsp;( '.$record1['post_name'].' )</option>';
															}
															$output .='</select></div>';
														echo $output;
												}elseif($_SESSION['astro_role']=='Deport'){
													$query11="select * from deport where phone='".$_SESSION['astro_email']."'";
													$row11=$db->select($query11);
													$record11=$row11->fetch_array();
													
													$output ='<div class="col-md-3 mb-3" id="employee_data">
														<input type="hidden" name="work_location" id="work_location" value="Deport">
														<input type="hidden" name="office_name" id="office_name" value="'.$record11['id'].'">
														<label class="form-label">Employee</label>
															<select name="employee" id="employee_name" onchange="action23(this.value)" class="form-control" required>';
															$output .= '<option value="">~~~Choose~~~</option>';
															$query="select * from employee where work_location='Deport' and office_name='".$record11['id']."'";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
																$query1="select * from post where id='".$record['post']."'";
																$row1=$db->select($query1);
																$record1=$row1->fetch_array();
																
																$output .= '<option value="'.$record['employee_code'].'">'.$record['employee_code'].' - '.$record['employee_name'].' &nbsp;&nbsp;&nbsp;&nbsp;( '.$record1['post_name'].' )</option>';
															}
															$output .='</select></div>';
														echo $output;
												}
												?>
												
												<div class="col-md-12">
													<div class="row" id="employee_history_data">
														
														<!--div class="accordion accordion-flush" id="accordionFlushExample">
															<div class="accordion-item">
																<h2 class="accordion-header" id="flush-headingOne">
																	<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
																		Employee Details
																	</button>
																</h2>
																<div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
																	<div class="accordion-body">
																		<div class="table-responsive">
																			<table class="table table-bordered">
																				<tbody>
																					<?php
																					$i=1;
																					$query="select * from employee where employee_code='TEST001'";
																					$row=$db->select($query);
																					$record=$row->fetch_array();
																					
																					if($record['work_location']=='Head Quarter'){
																						$office_name = '';
																					}else if($record['work_location']=='Division'){
																						$query3="select * from division where id='".$record['office_name']."'";
																						$row3=$db->select($query3);
																						$record3=$row3->fetch_array();
																						
																						$office_name = $record3['division'];
																					}elseif($record['work_location']=='Deport'){
																						$query3="select * from deport where id='".$record['office_name']."'";
																						$row3=$db->select($query3);
																						$record3=$row3->fetch_array();
																						
																						$office_name = $record3['deport'];
																					}
																					
																					$query2="select * from post where id='".$record['post']."'";
																					$row2=$db->select($query2);
																					$record2=$row2->fetch_array();
																					
																					$query4="select * from department where id='".$record['department']."'";
																					$row4=$db->select($query4);
																					$record4=$row4->fetch_array();
																					
																					$query6="select * from post where id='".$record['reporting_manager']."'";
																					$row6=$db->select($query6);
																					$record6=$row6->fetch_array();
																					
																					$query5="select * from employee where employee_code='".$record['reporting_manager_name']."'";
																					$row5=$db->select($query5);
																					$record5=$row5->fetch_array();
																						
																					$query7="select * from post where id='".$record['appointment_officer']."'";
																					$row7=$db->select($query7);
																					$record7=$row7->fetch_array();
																					
																					$query8="select * from employee where employee_code='".$record['appointment_officer_name']."'";
																					$row8=$db->select($query8);
																					$record8=$row8->fetch_array();
																						
																					$query9="select * from cast where id='".$record['cast']."'";
																					$row9=$db->select($query9);
																					$record9=$row9->fetch_array();
																						
																					
																					?>
																						<tr>
																							<th>Employee Code</th>
																							<td><?= $record['employee_code']; ?></td>
																							<th>Employee Name</th>
																							<td><?= $record['employee_name']; ?></td>
																						</tr>
																						<tr>
																							<th>Work Location</th>
																							<td><?= $record['work_location']; ?></td>
																							<th>Office Name</th>
																							<td><?= $office_name; ?></td>
																						</tr>
																						<tr>
																							<th>Designation</th>
																							<td><?= $record2['post_name']; ?></td>
																							<th>Department</th>
																							<td><?= $record4['department']; ?></td>
																						</tr>
																						<tr>
																							<th>Reporting Manager</th>
																							<td><?= $record6['post_name']; ?></td>
																							<th>Reporting Manager Name</th>
																							<td><?= $record5['employee_name']; ?></td>
																						</tr>
																						<tr>
																							<th>Appointment Officer</th>
																							<td><?= $record7['post_name']; ?></td>
																							<th>Appointment Officer Name</th>
																							<td><?= $record8['employee_name']; ?></td>
																						</tr>
																						
																						<tr>
																							<th>Father Name</th>
																							<td><?= $record['father_name']; ?></td>
																							<th>Mother Name</th>
																							<td><?= $record['mother_name']; ?></td>
																						</tr>
																						<tr>
																							<th>Email</th>
																							<td><?= $record['email']; ?></td>
																							<th>Gender</th>
																							<td><?= $record['gender']; ?></td>
																						</tr>
																						<tr>
																							<th>DOB</th>
																							<td><?= date("d M, Y",strtotime($record['dob'])); ?></td>
																							<th>Height</th>
																							<td><?= $record['height']; ?></td>
																						</tr>
																						<tr>
																							<th>Identity Mark</th>
																							<td colspan="3"><?= $record['identity_mark']; ?></td>
																						</tr>
																						<tr>
																							<th>Address</th>
																							<td colspan="3"><?= $record['address']; ?></td>
																						</tr>
																						<tr>
																							<th>City</th>
																							<td><?= $record['city']; ?></td>
																							<th>District</th>
																							<td><?= $record['district']; ?></td>
																						</tr>
																						<tr>
																							<th>State</th>
																							<td><?= $record['state']; ?></td>
																							<th>PIN</th>
																							<td><?= $record['pin']; ?></td>
																						</tr>
																						<tr>
																							<th>Cast</th>
																							<td><?= $record9['cast']; ?></td>
																							<th>DOJ</th>
																							<td><?= date("d M, Y",strtotime($record['doj'])); ?></td>
																						</tr>
																						<tr>
																							<th>Nominee</th>
																							<td><?= $record['nominee']; ?></td>
																							<th>Nominee Relation</th>
																							<td><?= $record['nominee_relation']; ?></td>
																						</tr>
																						
																				</tbody>
																			</table>
																		</div>
																	</div>
																</div>
															</div>
															<div class="accordion-item">
																<h2 class="accordion-header" id="flush-headingTwo">
																	<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
																		Leave History
																	</button>
																</h2>
																<div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
																	<div class="accordion-body">
																		<div class="table-responsive">
																			<table class="table table-bordered table-striped">
																				<thead>
																					<tr>
																						<th>From Date</th>
																						<th>To Date</th>
																						<th>Request Type</th>
																						<th>Requested ON</th>
																						<th>Note</th>
																						<th>Status</th>
																						<th>Action Taken By</th>
																					</tr>
																				</thead>
																				<tbody>
																					<?php
																					$i=1;
																					$query="select * from leave_request where employee='R870162' order by id desc";
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
																									echo 'On '.date("d M, y",strtotime($record['action_taken_on']));
																								}
																								?>
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
															<div class="accordion-item">
																<h2 class="accordion-header" id="flush-headingThree">
																	<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
																		Transfer History
																	</button>
																</h2>
																<div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
																	<div class="accordion-body">
																		<div class="table-responsive">
																			<table class="table table-bordered table-striped">
																				<thead>
																					<tr>
																						<th>#</th>
																						<th>Order Date</th>
																						<th>Designation</th>
																						<th>From Work Location</th>
																						<th>Relieving Date</th>
																						<th>To Work Location</th>
																						<th>Transfered By</th>
																					</tr>
																				</thead>
																				<tbody>
																					<?php
																					$i=1;
																					$query="select * from transfer_request where employee='R870162' and is_transfer='1'";
																					$row=$db->select($query);
																					while($record=$row->fetch_array()){
																						$query1="select * from employee where employee_code='".$record['employee']."'";
																						$row1=$db->select($query1);
																						$record1=$row1->fetch_array();
																						
																						$query2="select * from post where id='".$record['post']."'";
																						$row2=$db->select($query2);
																						$record2=$row2->fetch_array();
																						
																						if($record['work_location']=='Head Quarter'){
																							$work_location = $record['work_location'];
																						}else if($record['work_location']=='Division'){
																							$query3="select * from division where id='".$record['office_name']."'";
																							$row3=$db->select($query3);
																							$record3=$row3->fetch_array();
																							
																							$work_location = $record['work_location'].' ('.$record3['division'].')';
																						}elseif($record['work_location']=='Deport'){
																							$query3="select * from deport where id='".$record['office_name']."'";
																							$row3=$db->select($query3);
																							$record3=$row3->fetch_array();
																							
																							$work_location = $record['work_location'].' ('.$record3['deport'].')';
																						}
																						
																						if($record['to_work_location']=='Head Quarter'){
																							$to_work_location = $record['to_work_location'];
																						}else if($record['to_work_location']=='Division'){
																							$query3="select * from division where id='".$record['to_office_name']."'";
																							$row3=$db->select($query3);
																							$record3=$row3->fetch_array();
																							
																							$to_work_location = $record['to_work_location'].' ('.$record3['division'].')';
																						}elseif($record['to_work_location']=='Deport'){
																							$query3="select * from deport where id='".$record['to_office_name']."'";
																							$row3=$db->select($query3);
																							$record3=$row3->fetch_array();
																							
																							$to_work_location = $record['to_work_location'].' ('.$record3['deport'].')';
																						}
																						
																						$query4="select * from login where mobile='".$record['transfer_by']."'";
																						$row4=$db->select($query4);
																						$record4=$row4->fetch_array();
																					?>
																						<tr>
																							<td><?= $i; ?></td>
																							<td><?= date("d M, Y",strtotime($record['add_date'])); ?></td>
																							<td><?= $record2['post_name']; ?></td>
																							<td><?= $work_location; ?></td>
																							<td><?= date("d M, Y",strtotime($record['relieving_date'])); ?></td>
																							<td><?= $to_work_location; ?></td>
																							<td><?= $record4['name']; ?></td>
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

															<div class="accordion-item">
																<h2 class="accordion-header" id="flush-headingFour">
																	<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
																		Promotion History
																	</button>
																</h2>
																<div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour"
																	data-bs-parent="#accordionFlushExample">
																	<div class="accordion-body">
																		<div class="table-responsive">
																			<table class="table table-bordered table-striped">
																				<thead>
																					<tr>
																						<th>#</th>
																						<th>Order Date</th>
																						<th>Current Post</th>
																						<th>Current Work Location</th>
																						<th>Relieving Date</th>
																						<th>New Post</th>
																						<th>New Work Location</th>
																						<th>Transfered By</th>
																					</tr>
																				</thead>
																				<tbody>
																					<?php
																					$i=1;
																					$query="select * from promotion_request where employee='R150016' and is_transfer='1'";
																					$row=$db->select($query);
																					while($record=$row->fetch_array()){
																						$query1="select * from employee where employee_code='".$record['employee']."'";
																						$row1=$db->select($query1);
																						$record1=$row1->fetch_array();
																						
																						$query2="select * from post where id='".$record['post']."'";
																						$row2=$db->select($query2);
																						$record2=$row2->fetch_array();
																						
																						$query5="select * from post where id='".$record['to_post']."'";
																						$row5=$db->select($query5);
																						$record5=$row5->fetch_array();
																						
																						if($record['work_location']=='Head Quarter'){
																							$work_location = $record['work_location'];
																						}else if($record['work_location']=='Division'){
																							$query3="select * from division where id='".$record['office_name']."'";
																							$row3=$db->select($query3);
																							$record3=$row3->fetch_array();
																							
																							$work_location = $record['work_location'].' ('.$record3['division'].')';
																						}elseif($record['work_location']=='Deport'){
																							$query3="select * from deport where id='".$record['office_name']."'";
																							$row3=$db->select($query3);
																							$record3=$row3->fetch_array();
																							
																							$work_location = $record['work_location'].' ('.$record3['deport'].')';
																						}
																						
																						if($record['to_work_location']=='Head Quarter'){
																							$to_work_location = $record['to_work_location'];
																						}else if($record['to_work_location']=='Division'){
																							$query3="select * from division where id='".$record['to_office_name']."'";
																							$row3=$db->select($query3);
																							$record3=$row3->fetch_array();
																							
																							$to_work_location = $record['to_work_location'].' ('.$record3['division'].')';
																						}elseif($record['to_work_location']=='Deport'){
																							$query3="select * from deport where id='".$record['to_office_name']."'";
																							$row3=$db->select($query3);
																							$record3=$row3->fetch_array();
																							
																							$to_work_location = $record['to_work_location'].' ('.$record3['deport'].')';
																						}
																						
																						$query4="select * from login where mobile='".$record['transfer_by']."'";
																						$row4=$db->select($query4);
																						$record4=$row4->fetch_array();
																					?>
																						<tr>
																							<td><?= $i; ?></td>
																							<td><?= date("d M, Y",strtotime($record['add_date'])); ?></td>
																							<td><?= $record2['post_name']; ?></td>
																							<td><?= $work_location; ?></td>
																							<td><?= date("d M, Y",strtotime($record['relieving_date'])); ?></td>
																							<td><?= $record5['post_name']; ?></td>
																							<td><?= $to_work_location; ?></td>
																							<td><?= $record4['name']; ?></td>
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
														</div-->
													</div>
												</div>
												
											</div>
										</form>
									</div> <!-- end card-body-->
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
		</div>
        <!-- END wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
		<script src="assets/js/vendor.min.js"></script>
		<script src="assets/libs/parsleyjs/parsley.min.js"></script>
		<script src="assets/js/pages/form-validation.init.js"></script>
		<script src="assets/js/app.min.js"></script>

<script>
function action31(query31){
	if(query31 != ''){
		var action31 = 'fetch_division1';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action31:action31, query31:query31},
			success:function(data){
				//alert(data);
				$('#dep_div_data').html(data);
				$('#employee_data').html('');
				$('#employee_history_data').html('');
			}
		})
	}else{
		$('#dep_div_data').html('');
		$('#employee_data').html('');
		$('#employee_history_data').html('');
	}
}
</script>

<script>
function action22(query22){
	if(query22 != ''){
		var action22 = 'fetch_employee1';
		var work_location = $('#work_location').val();
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action22:action22, query22:query22, work_location:work_location},
			success:function(data){
				//alert(data);
				$('#employee_data').html(data);
			}
		})
	}else{
		$('#employee_data').html('');
	}
}
</script>


<script>
function action311(query311){
	if(query311 != ''){
		
		var action311 = 'fetch_division1';
		
		if($('#work_location').val() == 'Division' || $('#work_location').val() == 'Deport'){
			var office_name = $('#office_name').val();
			
			$.ajax({
				url:"query.php",
				method:"POST",
				data:{action311:action311, query311:query311, office_name:office_name},
				success:function(data){
					//alert(data);
					if(query311=='Head Quarter'){
						$('#to_employee_data').hide();
					}else{
						$('#to_employee_data').html('');
					}
					$('#to_dep_div_data').html(data);
					
					$('#to_appointment_officer_name').html('');
				}
			})
		}else{
			var office_name = '';
			$.ajax({
				url:"query.php",
				method:"POST",
				data:{action311:action311, query311:query311, office_name:office_name},
				success:function(data){
					//alert(data);
					if(query311=='Head Quarter'){
						$('#to_employee_data').hide();
					}else{
						$('#to_employee_data').html('');
					}
					$('#to_dep_div_data').html(data);
					
					$('#to_appointment_officer_name').html('');
				}
			})
		}
		
		
	}else{
		$('#to_dep_div_data').html('');
		$('#to_employee_data').html('');
		$('#to_appointment_officer_name').html('');
	}
}
</script>

<script>
function action221(query221){
	if(query221 != ''){
		var action221 = 'fetch_employee';
		var to_work_location = $('#to_work_location').val();
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action221:action221, query221:query221, to_work_location:to_work_location},
			success:function(data){
				//alert(data);
				$('#to_employee_data').html(data);
				$('#to_appointment_officer_name').html('');
			}
		})
	}else{
		$('#to_employee_data').html('');
		$('#to_appointment_officer_name').html('');
	}
}
</script>




<script>
function action23(query23){
	if(query23 != ''){
		var action23 = 'fetch_employee_history';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action23:action23, query23:query23},
			success:function(data){
				//alert(data);
				$('#employee_history_data').html(data);
			}
		})
	}else{
		$('#employee_history_data').html('');
	}
}
</script>

<script>
function action511(query511){
	if(query511 != ''){
		var action511 = 'fetch_promotion_to';
		var work_location = $('#work_location').val();
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action511:action511, query511:query511, work_location:work_location},
			success:function(data){
				//alert(data);
				$('#to_dep_div_data_promotion').html(data);
			}
		})
	}else{
		$('#to_dep_div_data_promotion').html('');
	}
}
</script>




<script>
function action4(query4){
	if(query4 != ''){
		var action4 = 'fetch_reporting_manager_name';
		if($('#work_location').val() == ''){
			alert("Choose Work Location!");
		}else{
			if($('#work_location').val() == 'Division' || $('#work_location').val() == 'Deport'){
				if($('#office_name').val() == ''){
					alert("Choose Division/Deport!");
				}else{
					var work_location = $('#work_location').val();
					var office_name = $('#office_name').val();
					
					$.ajax({
						url:"query.php",
						method:"POST",
						data:{action4:action4, query4:query4, work_location:work_location, office_name:office_name},
						success:function(data){
							//alert(data);
							$('#reporting_manager_name').html(data);
						}
					})
				}
			}else{
				var work_location = $('#work_location').val();
				
				$.ajax({
					url:"query.php",
					method:"POST",
					data:{action4:action4, query4:query4, work_location:work_location},
					success:function(data){
						//alert(data);
						$('#reporting_manager_name').html(data);
					}
				})
			}
		}
	}
}
</script>

<script>
function action411(query411){
	if(query411 != ''){
		var action411 = 'fetch_appointment_officer_name';
		if($('#to_work_location').val() == ''){
			alert("Choose Work Location!");
			$("#appointment_officer").val("");
			$("#department_button").attr("disabled", true);
		}else{
			$("#department_button").attr("disabled", false);
			if($('#to_work_location').val() == 'Division' || $('#to_work_location').val() == 'Deport'){
				if($('#to_office_name').val() == ''){
					alert("Choose Division/Deport!");
				}else{
					var employee = $('#employee_name').val();
					var to_work_location = $('#to_work_location').val();
					var to_office_name = $('#to_office_name').val();
					
					$.ajax({
						url:"query.php",
						method:"POST",
						data:{action411:action411, query411:query411, to_work_location:to_work_location, to_office_name:to_office_name, employee:employee},
						success:function(data){
							//alert(data);
							$('#to_appointment_officer_name').html(data);
						}
					})
				}
			}else{
				var to_work_location = $('#to_work_location').val();
				var employee = $('#employee_name').val();
				$.ajax({
					url:"query.php",
					method:"POST",
					data:{action411:action411, query411:query411, to_work_location:to_work_location, to_office_name:to_office_name, employee:employee},
					success:function(data){
						//alert(data);
						$('#to_appointment_officer_name').html(data);
					}
				})
			}
		}
	}
}
</script>

<script>
	$(document).ready(function(){
		$('#form_id').on('submit', function(e){
			e.preventDefault();
			
			$.ajax({
				url:'query',
				type:'POST',
				data:$('#form_id').serialize(),
				beforeSend:function(){
					$('#button_id').html('Please Wait...');
				},
				success:function(data){
					if(data=='Success'){
						$('#message').html('<div class="alert alert-success alert-dismissable"><span><i class="fa fa-check"></i> Promotion Created Successfully!</span></div>');
						$('#form_id')[0].reset();
						$('#button_id').html('Submit');
					}else if(data=='Success1'){
						$('#message').html('<div class="alert alert-success alert-dismissable"><span><i class="fa fa-check"></i> Promotion Updates Successfully!</span></div>');
						$('#button_id').html('Update');
					}else{
						$('#message').html('<div class="alert alert-danger alert-dismissable"><span><i class="fa fa-times"></i> '+data+'</span>');
						$('#button_id').html('Submit');
					}
					setTimeout(function() {
						$('.alert').hide('slow');
					}, 2000);
				}
			});
			
		});
	});
</script>
      
    </body>
</html>