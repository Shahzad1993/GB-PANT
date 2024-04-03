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
        <title>Employee | GB Pant</title>
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
            <?php include "inc/sidebar.php"; ?>
            <div class="content-page">
                <div class="content">
					<div class="container-fluid">
						<?php
						if(isset($_POST['id'])){
							$query="select * from employee where employee_code='".base64_decode($_POST['id'])."'";
							$row=$db->select($query);
							$record_emp=$row->fetch_array();
						?>
							<div class="row">
								<div class="col-12">
									<div class="page-title-box">
										<h4 class="page-title">Edit Employee</h4>
										<div class="page-title-right">
											<ol class="breadcrumb m-0">
												<li class="breadcrumb-item"><a href="javascript: void(0);">Employee</a></li>
												<li class="breadcrumb-item active">Edit Employee</li>
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
											<h4 id="message"></h4>
											<form id="department_form" class="needs-validation">
												<div class="row">
													<div class="col-md-3 mb-3">
														<label class="form-label">Employee Code</label>
														<input type="text" value="<?= $record_emp['employee_code']; ?>" class="form-control block_special" placeholder="Employee Code" readonly>
													</div>
													<div class="col-md-3 mb-3">
														<label class="form-label">Employee Name</label>
														<input type="text" name="employee_name" id="employee_name" value="<?= $record_emp['employee_name']; ?>" class="form-control block_special" placeholder="Employee Name">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">University</label>
														<select name="work_location" id="work_location" onchange="action3(this.value), action3_2(this.value)" class="form-control">
															<option value="">~~~Choose~~~</option>
															<?php
															$query_w="select * from work_location";
															$row_w=$db->select($query_w);
															while($record_w=$row_w->fetch_array()){
																if($record_emp['work_location']==$record_w['work_location']){
															?>
																<option value="<?= $record_w['work_location']; ?>" selected><?= $record_w['work_location_name']; ?></option>
															<?php
																}else{
															?>
																<option value="<?= $record_w['work_location']; ?>"><?= $record_w['work_location_name']; ?></option>
															<?php
																}
															}
															?>
														</select>
													</div>
													
													<div class="col-md-3 mb-3" id="dep_div_data">
														<?php
														$output = '';
														if($record_emp['work_location']=='Division'){
															$output .='<label class="form-label">Division Name</label>
															<select name="office_name" id="office_name" class="form-control">';
															$output .= '<option value="">~~~Choose~~~</option>';
															$query="select * from division";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
																if($record_emp['office_name']==$record['id']){
																	$output .= '<option value="'.$record['id'].'" selected>'.$record['division'].'</option>';
																}else{
																	$output .= '<option value="'.$record['id'].'">'.$record['division'].'</option>';
																}
															}
															$output .='</select>';
														}else if($record_emp['work_location']=='Depot'){
															$output .='<label class="form-label">Depot</label>
															<select name="office_name" id="office_name" class="form-control">';
															$output .= '<option value="">~~~Choose~~~</option>';
															$query="select * from deport";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
																if($record_emp['office_name']==$record['id']){
																	$output .= '<option value="'.$record['id'].'" selected>'.$record['deport'].'</option>';
																}else{
																	$output .= '<option value="'.$record['id'].'">'.$record['deport'].'</option>';
																}
															}
															$output .='</select>';
														}
														echo $output;
														?>
													</div>
													<div class="col-md-3 mb-3">
														<label class="form-label">Department</label>
														<select name="department" id="department" class="form-control">
															<option value="">~~~Choose~~~</option>
															<?php
															$query="select * from department";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
																if($record_emp['department']==$record['department']){
															?>
																<option value="<?= $record['department']; ?>" selected><?= $record['department']; ?></option>
															<?php
																}else{
															?>
																<option value="<?= $record['department']; ?>"><?= $record['department']; ?></option>
															<?php
																}
															}
															?>
														</select>
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Employee Category</label>
														<select name="employee_category" id="employee_category" class="form-control">
															<option value="">~~~Choose~~~</option>
															<?php
															$query="select * from emp_category";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
																if($record_emp['employee_category']==$record['id']){
															?>
																<option value="<?= $record['id']; ?>" selected><?= $record['category']; ?></option>
															<?php
																}else{
															?>
																<option value="<?= $record['id']; ?>"><?= $record['category']; ?></option>
															<?php	
																}
															}
															?>
														</select>
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Designation</label>
														<select name="post" id="post" class="form-control">
															<option value="">~~~Choose~~~</option>
															<?php
															$query="select * from post order by post_name_en asc";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
																if($record_emp['post']==$record['id']){
															?>
																<option value="<?= $record['id']; ?>" selected><?= $record['post_name_en']; ?></option>
															<?php	
																}else{
															?>
																<option value="<?= $record['id']; ?>"><?= $record['post_name_en']; ?></option>
															<?php
																}
															}
															?>
														</select>
													</div>
													<div class="col-md-3 mb-3">
														<label class="form-label">Weekly Rest</label>
														<select name="weekly_rest" id="weekly_rest" class="form-control">
															<option value="">~~~Choose~~~</option>
															<?php
															$query="select * from weekly_rest";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
																if($record_emp['weekly_rest']==$record['weekly_rest']){
															?>
																<option value="<?= $record['weekly_rest']; ?>" selected><?= $record['weekly_rest']; ?></option>
															<?php	
																}else{
															?>
																<option value="<?= $record['weekly_rest']; ?>"><?= $record['weekly_rest']; ?></option>
															<?php
																}
															}
															?>
														</select>
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Father's Name</label>
														<input type="text" name="father_name" id="father_name" value="<?= $record_emp['father_name']; ?>" class="form-control block_special" placeholder="Father's Name">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Mother's Name</label>
														<input type="text" name="mother_name" id="mother_name"  value="<?= $record_emp['mother_name']; ?>" class="form-control block_special" placeholder="Mother's Name">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Phone</label>
														<input type="text" name="phone" id="phone" value="<?= $record_emp['phone']; ?>" class="form-control allow_number" placeholder="Phone">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Gender</label>
														<select name="gender" id="gender" class="form-control">
															<option value="">~~~Choose~~~</option>
															<?php
															if($record_emp['gender']=='Male'){
															?>
																<option value="Male" selected>Male</option>
																<option value="Female">Female</option>
															<?php
															}else if($record_emp['gender']=='Female'){
															?>
																<option value="Male">Male</option>
																<option value="Female" selected>Female</option>
															<?php
															}else{
																?>
																<option value="Male">Male</option>
																<option value="Female">Female</option>
															<?php
															}
															?>
															
														</select>
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Date of Birth</label>
														<input type="date" name="dob" id="dob" value="<?= $record_emp['dob']; ?>" class="form-control">
													</div>
													
													<div class="col-md-6 mb-3">
														<label class="form-label">Address</label>
														<input type="text" name="address" id="address" value="<?= $record_emp['address']; ?>" class="form-control block_special" placeholder="Address">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">City</label>
														<input type="text" name="city" id="city" value="<?= $record_emp['city']; ?>" class="form-control block_special" placeholder="City">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">District</label>
														<input type="text" name="district" id="district" value="<?= $record_emp['district']; ?>" class="form-control block_special" placeholder="District">
													</div>

													<div class="col-md-3 mb-3">
														<label class="form-label">State</label>
														<input type="text" name="state" id="state" value="<?= $record_emp['state']; ?>" class="form-control block_special" placeholder="State">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Caste Category</label>
														<select name="cast" id="cast" class="form-control">
															<option value="">~~~Choose~~~</option>
															<?php
															$query="select * from cast";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
																if($record_emp['cast']==$record['id']){
																?>
																	<option value="<?= $record['id']; ?>" selected><?= $record['cast']; ?></option>
																<?php
																}else{
																?>
																	<option value="<?= $record['id']; ?>"><?= $record['cast']; ?></option>
																<?php
																}
															}
															?>
														</select>
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Grade Pay</label>
														<input type="text" name="grade_pay" id="grade_pay" value="<?= $record_emp['grade_pay']; ?>" class="form-control allow_float" placeholder="Grade Pay">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Basic Salary</label>
														<input type="text" name="basic_salary" id="basic_salary" value="<?= $record_emp['basic_salary']; ?>" class="form-control allow_float" placeholder="Basic Salary">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Date of Joining</label>
														<input type="date" name="doj" id="doj" value="<?= $record_emp['doj']; ?>" class="form-control">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Nominee</label>
														<input type="text" name="nominee" id="nominee" value="<?= $record_emp['nominee']; ?>" class="form-control block_special" placeholder="Nominee">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Nominee Relationship</label>
														<input type="text" name="nominee_relation" id="nominee_relation" value="<?= $record_emp['nominee_relation']; ?>" class="form-control block_special" placeholder="Nominee Relationship">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">No of Dependent</label>
														<input type="text" name="no_of_dependent" id="no_of_dependent" value="<?= $record_emp['no_of_dependent']; ?>" onkeyup="action_no_of_family(this.value)" class="form-control allow_number" placeholder="No of Dependent" maxlength="1">
														<span id="dependent_error" class="text-danger"></span>
													</div>
													
													<div class="col-md-12" id="no_of_family_data">
														<?php
														$output = '';
														$i=1;
														$output .= '<div class="row">';
														$query="select * from family_member where employee_code='".$record_emp['employee_code']."'";
														$row=$db->select($query);
														while($record=$row->fetch_array()){
															if(file_exists($record['member_aadhaar_copy'])){
																$member_aadhaar_copy_img='<a href="'.$record['member_aadhaar_copy'].'" target="_blank">View Document</a>';
															}else{
																$member_aadhaar_copy_img='';
															}
														//for($i=1; $i <= $record_emp['no_of_dependent']; $i++){
															$output .= '<div class="col-md-12"><h5>Member '.$i.'</h5></div>
																<div class="col-md-3 mb-3">
																	<label class="form-label">Name</label>
																	<input type="text" name="member_name[]" value="'.$record['member_name'].'" class="form-control block_special" placeholder="Name ">
																</div>
																<div class="col-md-2 mb-3">
																	<label class="form-label">Relation</label>
																	<input type="text" name="relation[]" value="'.$record['relation'].'" class="form-control block_special" placeholder="Relation ">
																</div>
																<div class="col-md-2 mb-3">
																	<label class="form-label">Age</label>
																	<input type="text" name="member_age[]" value="'.$record['member_age'].'" class="form-control allow_number" maxlength="2" placeholder="Age">
																</div>
																<div class="col-md-2 mb-3">
																	<label class="form-label">Aadhaar Number</label>
																	<input type="text" name="member_aadhaar_no[]" value="'.$record['member_aadhaar_no'].'" class="form-control allow_number" maxlength="12" placeholder="Aadhaar Number">
																</div>
																<div class="col-md-2 mb-3">
																	<label class="form-label">Aadhaar Card Doc</label>
																	<input type="file" name="member_aadhaar_copy[]" maxlength="12" placeholder="Aadhaar Number">
																</div>
																<div class="col-md-1 mb-3">
																	<br />
																	'.$member_aadhaar_copy_img.'
																</div>';
															$i++;
														}
														
														$output .= '</div>';
														echo $output;
														?>
													</div>
													<hr>
													<div class="col-md-12 mb-3">
														<div class="table-responsive">
															<table class="table table-bordered table-hover" id="lic_list_data">
																<tr>
																	<th width="2%"><input id="checkAll" class="formcontrol" type="checkbox"></th>
																	<th>LIC Number</th>
																	<th>LIC Premium Amount</th>
																</tr>
																<?php
																$i=1;
																$query="select * from lic_data where employee_code='".$record_emp['employee_code']."'";
																$row=$db->select($query);
																while($record=$row->fetch_array()){
																	if($i==1){
																?>
																	<tr>
																		<td></td>
																		<td><input type="text" name="lic_number[]" value="<?= $record['lic_number']; ?>" class="form-control allow_number" placeholder="LIC Number"></td>
																		<td><input type="text" name="lic_premium[]" value="<?= $record['lic_premium']; ?>" class="form-control allow_float" placeholder="LIC Premium"></td>
																	</tr>
																<?php
																	}else{
																?>
																	<tr>
																		<td><input class="itemRow" type="checkbox" value="delivery_id1"></td>
																		<td><input type="text" name="lic_number[]" value="<?= $record['lic_number']; ?>" class="form-control allow_number" placeholder="LIC Number"></td>
																		<td><input type="text" name="lic_premium[]" value="<?= $record['lic_premium']; ?>" class="form-control allow_float" placeholder="LIC Premium"></td>
																	</tr>
																<?php
																	}
																	$i++;
																}
																?>
																
														   </table>
														</div>
														<div class="row">
															<div class="col-md-12">
																<button class="btn btn-primary btn-sm" id="addRows" type="button">+ Add More LIC Details</button>
																<button class="btn btn-danger btn-sm delete" id="removeRows" type="button">- Delete</button>
															</div>
														</div>
													</div>
													
													<hr>
													<div class="col-md-12"><h5>Allowance</h5></div>
													<div class="col-md-2 mb-3">
														<label class="form-label">IR</label>
														<input type="text" name="ir" value="<?= $record_emp['ir']; ?>" class="form-control allow_float" placeholder="IR">
													</div>
													
													<div class="col-md-2 mb-3">
														<label class="form-label">Cycle / P.H Allowance</label>
														<input type="text" name="cycle_ph_allowence" value="<?= $record_emp['cycle_ph_allowence']; ?>" class="form-control allow_float" placeholder="Cycle / P.H Allowance">
													</div>
													
													<div class="col-md-2 mb-3">
														<label class="form-label">Cash Handling Allowance</label>
														<input type="text" name="cash_handling_allowence" value="<?= $record_emp['cash_handling_allowence']; ?>" class="form-control allow_float" placeholder="Cash Handling Allowance">
													</div>
													
													<div class="col-md-2 mb-3">
														<label class="form-label">Pollution Allowance</label>
														<input type="text" name="pollution_allowence" value="<?= $record_emp['pollution_allowence']; ?>" class="form-control allow_float" placeholder="Pollution Allowance">
													</div>
													
													<div class="col-md-2 mb-3">
														<label class="form-label">Washing Allowance</label>
														<input type="text" name="washing_allowence" value="<?= $record_emp['washing_allowence']; ?>" class="form-control allow_float" placeholder="Washing Allowance">
													</div>
													
													<hr>
													<div class="col-md-12"><h5>Deduction</h5></div>
													
													<div class="col-md-2 mb-3">
														<label class="form-label">Society</label>
														<input type="text" name="society" value="<?= $record_emp['society']; ?>" class="form-control allow_float" placeholder="Society">
													</div>
													
													<div class="col-md-2 mb-3">
														<label class="form-label">Staff Car</label>
														<input type="text" name="staff_car" value="<?= $record_emp['staff_car']; ?>" class="form-control allow_float" placeholder="Staff Car">
													</div>
													
													<div class="col-md-2 mb-3">
														<label class="form-label">House Maintenance</label>
														<input type="text" name="house_maintenance" value="<?= $record_emp['house_maintenance']; ?>" class="form-control allow_float" placeholder="House Maintenance">
													</div>
													
													<div class="col-md-2 mb-3">
														<label class="form-label">Electricity Bill</label>
														<input type="text" name="electricity" value="<?= $record_emp['electricity']; ?>" class="form-control allow_float" placeholder="Electricity Bill">
													</div>
													<hr>
													<div class="col-md-3 mb-3">
														<label class="form-label">EPF No</label>
														<input type="text" name="epf_no" value="<?= $record_emp['epf_no']; ?>" class="form-control allow_number" placeholder="EPF No">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">ESI No</label>
														<input type="text" name="esi_no" value="<?= $record_emp['esi_no']; ?>" class="form-control allow_number" placeholder="ESI No">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">PAN No</label>
														<input type="text" name="pan_no" value="<?= $record_emp['pan_no']; ?>" class="form-control block_special" placeholder="PAN No">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Aadhaar No</label>
														<input type="text" name="aadhaar_no" value="<?= $record_emp['aadhaar_no']; ?>" class="form-control allow_number" placeholder="Aadhaar No">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Bank Name</label>
														<input type="text" name="bank_name" value="<?= $record_emp['bank_name']; ?>" class="form-control block_special" placeholder="Bank Name">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">IFSC Code</label>
														<input type="text" name="ifsc_code" value="<?= $record_emp['ifsc_code']; ?>" class="form-control block_special" placeholder="IFSC Code">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Account No</label>
														<input type="text" name="account_no" value="<?= $record_emp['account_no']; ?>" class="form-control allow_number" placeholder="Account No">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Employee Picture</label>
														<input type="file" name="employee_pic" value="<?= $record_emp['employee_pic']; ?>" class="form-control">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Employee Aadhaar Card</label>
														<input type="file" name="aadhaar_card_copy" class="form-control">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Employee PAN Card</label>
														<input type="file" name="pan_card_copy" class="form-control">
													</div>
													
													
													<hr>
													<div class="col-md-12"><h5>Attendance</h5></div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Attendance Type</label>
														<select name="attendance_type" id="attendance_type" class="form-control">
															<option value="">~~~Choose~~~</option>
															<?php
															if($record_emp['attendance_type']=='Geofence'){
															?>
																<option value="Geofence" selected>Geofence</option>
																<option value="Remote">Remote</option>
																<option value="Manual">Manual</option>
															<?php
															}else if($record_emp['attendance_type']=='Remote'){
															?>
																<option value="Geofence">Geofence</option>
																<option value="Remote" selected>Remote</option>
																<option value="Manual">Manual</option>
															<?php	
															}else if($record_emp['attendance_type']=='Manual'){
															?>
																<option value="Geofence">Geofence</option>
																<option value="Remote">Remote</option>
																<option value="Manual" selected>Manual</option>
															<?php	
															}else{
															?>
																<option value="Geofence">Geofence</option>
																<option value="Remote">Remote</option>
																<option value="Manual">Manual</option>
															<?php	
															}
															?>
														</select>
													</div>
													
												</div>
												<input type="hidden" name="employee_code" id="employee_code" value="<?= $record_emp['employee_code']; ?>">
												<input type="hidden" name="update_employee" value="update_employee">
												<button id="department_button" class="btn btn-primary" type="submit">Save</button>
											</form>

										</div> <!-- end card-body-->
									</div> <!-- end card-->
								</div> <!-- end col-->

							</div>
						<?php
						}else{
						?>
							<div class="row">
								<div class="col-12">
									<div class="page-title-box">
										<h4 class="page-title">New Employee</h4>
										<div class="page-title-right">
											<ol class="breadcrumb m-0">
												<li class="breadcrumb-item"><a href="javascript: void(0);">Employee</a></li>
												<li class="breadcrumb-item active">New Employee</li>
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
											<h4 id="message"></h4>
											<form id="department_form" class="needs-validation">
												<div class="row">
													<div class="col-md-3 mb-3">
														<label class="form-label">Employee Code</label>
														<input type="text" name="employee_code" id="employee_code" class="form-control block_special" placeholder="Employee Code">
													</div>
													<div class="col-md-3 mb-3">
														<label class="form-label">Employee Name</label>
														<input type="text" name="employee_name" id="employee_name" class="form-control block_special" placeholder="Employee Name">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">University</label>
														<select name="work_location" id="work_location" onchange="action3(this.value), action3_2(this.value)" class="form-control">
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
													<div class="col-md-3 mb-3">
														<label class="form-label">Department</label>
														<select name="department" class="form-control">
															<option value="">~~~Choose~~~</option>
															<?php
															$query="select * from department";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
															?>
																<option value="<?= $record['department']; ?>"><?= $record['department']; ?></option>
															<?php
															}
															?>
														</select>
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Employee Category</label>
														<select name="employee_category" id="employee_category" class="form-control">
															<option value="">~~~Choose~~~</option>
															<?php
															$query="select * from emp_category";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
															?>
																<option value="<?= $record['id']; ?>"><?= $record['category']; ?></option>
															<?php
															}
															?>
														</select>
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Designation</label>
														<select name="post" id="post" class="form-control">
															<option value="">~~~Choose~~~</option>
														</select>
													</div>
													<div class="col-md-3 mb-3">
														<label class="form-label">Weekly Rest</label>
														<select name="weekly_rest" id="weekly_rest" class="form-control">
															<option value="">~~~Choose~~~</option>
															<?php
															$query="select * from weekly_rest";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
															?>
																<option value="<?= $record['weekly_rest']; ?>"><?= $record['weekly_rest']; ?></option>
															<?php
															}
															?>
														</select>
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Father's Name</label>
														<input type="text" name="father_name" id="father_name" class="form-control block_special" placeholder="Father's Name">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Mother's Name</label>
														<input type="text" name="mother_name" id="mother_name" class="form-control block_special" placeholder="Mother's Name">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Phone</label>
														<input type="text" name="phone" id="phone" class="form-control allow_number" placeholder="Phone">
													</div>
													
													<!--div class="col-md-3 mb-3">
														<label class="form-label">Email</label>
														<input type="text" name="email" id="email" class="form-control" placeholder="Email">
													</div-->
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Gender</label>
														<select name="gender" id="gender" class="form-control">
															<option value="">~~~Choose~~~</option>
															<option value="Male">Male</option>
															<option value="Female">Female</option>
														</select>
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Date of Birth</label>
														<input type="date" name="dob" id="dob" class="form-control">
													</div>
													
													<!--div class="col-md-3 mb-3">
														<label class="form-label">Exact Height (in cm)</label>
														<input type="text" name="height" id="height" class="form-control" placeholder="Height (in cm)">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Personal Marks for Identification</label>
														<input type="text" name="identity_mark" id="identity_mark" class="form-control" placeholder="Identification Marks">
													</div-->
													
													<div class="col-md-6 mb-3">
														<label class="form-label">Address</label>
														<input type="text" name="address" class="form-control block_special" placeholder="Address">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">City</label>
														<input type="text" name="city" class="form-control block_special" placeholder="City">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">District</label>
														<input type="text" name="district" class="form-control block_special" placeholder="District">
													</div>

													<div class="col-md-3 mb-3">
														<label class="form-label">State</label>
														<input type="text" name="state" class="form-control block_special" placeholder="State">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Caste Category</label>
														<select name="cast" class="form-control">
															<option value="">~~~Choose~~~</option>
															<?php
															$query="select * from cast";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
															?>
																<option value="<?= $record['id']; ?>"><?= $record['cast']; ?></option>
															<?php
															}
															?>
														</select>
													</div>
													
													
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Grade Pay</label>
														<input type="text" name="grade_pay" class="form-control allow_float" placeholder="Grade Pay">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Basic Salary</label>
														<input type="text" name="basic_salary" class="form-control allow_float" placeholder="Basic Salary">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Date of Joining</label>
														<input type="date" name="doj" id="doj" class="form-control">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Nominee</label>
														<input type="text" name="nominee" class="form-control block_special" placeholder="Nominee">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Nominee Relationship</label>
														<input type="text" name="nominee_relation" class="form-control block_special" placeholder="Nominee Relationship">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">No of Dependent</label>
														<input type="text" name="no_of_dependent" onkeyup="action_no_of_family(this.value)" class="form-control allow_number" placeholder="No of Dependent" maxlength="1">
														<span id="dependent_error" class="text-danger"></span>
													</div>
													
													<div class="col-md-12" id="no_of_family_data"></div>
													<!--hr>
													
													<div class="col-md-12"><h4>Allowence</h4></div>
													<div class="col-md-3 mb-3">
														<label class="form-label">DA Salary</label>
														<input type="text" name="da_salary" class="form-control" placeholder="DA Salary">
													</div-->
													
													
													<hr>
													<div class="col-md-12 mb-3">
														<div class="table-responsive">
															<table class="table table-bordered table-hover" id="lic_list_data">
																<tr>
																	<th width="2%"><input id="checkAll" class="formcontrol" type="checkbox"></th>
																	<th>LIC Number</th>
																	<th>LIC Premium Amount</th>
																</tr>
																<tr id="lic_list_1">
																	<td></td>
																	<td><input type="text" name="lic_number[]" class="form-control allow_number" placeholder="LIC Number"></td>
																	<td><input type="text" name="lic_premium[]" class="form-control allow_float" placeholder="LIC Premium"></td>
																</tr>
														   </table>
														</div>
														<div class="row">
															<div class="col-md-12">
																<button class="btn btn-primary btn-sm" id="addRows" type="button">+ Add More LIC Details</button>
																<button class="btn btn-danger btn-sm delete" id="removeRows" type="button">- Delete</button>
															</div>
														</div>
													</div>
													
													<hr>
													<div class="col-md-12"><h5>Allowance</h5></div>
													<div class="col-md-2 mb-3">
														<label class="form-label">IR</label>
														<input type="text" name="ir" class="form-control allow_float" placeholder="IR">
													</div>
													
													<div class="col-md-2 mb-3">
														<label class="form-label">Cycle / P.H Allowance</label>
														<input type="text" name="cycle_ph_allowence" class="form-control allow_float" placeholder="Cycle / P.H Allowance">
													</div>
													
													<div class="col-md-2 mb-3">
														<label class="form-label">Cash Handling Allowance</label>
														<input type="text" name="cash_handling_allowence" class="form-control allow_float" placeholder="Cash Handling Allowance">
													</div>
													
													<div class="col-md-2 mb-3">
														<label class="form-label">Pollution Allowance</label>
														<input type="text" name="pollution_allowence" class="form-control allow_float" placeholder="Pollution Allowance">
													</div>
													
													<div class="col-md-2 mb-3">
														<label class="form-label">Washing Allowance</label>
														<input type="text" name="washing_allowence" class="form-control allow_float" placeholder="Washing Allowance">
													</div>
													
													<hr>
													<div class="col-md-12"><h5>Deduction</h5></div>
													
													<div class="col-md-2 mb-3">
														<label class="form-label">Society</label>
														<input type="text" name="society" class="form-control allow_float" placeholder="Society">
													</div>
													
													<div class="col-md-2 mb-3">
														<label class="form-label">Staff Car</label>
														<input type="text" name="staff_car" class="form-control allow_float" placeholder="Staff Car">
													</div>
													
													<div class="col-md-2 mb-3">
														<label class="form-label">House Maintenance</label>
														<input type="text" name="house_maintenance" class="form-control allow_float" placeholder="House Maintenance">
													</div>
													
													<div class="col-md-2 mb-3">
														<label class="form-label">Electricity Bill</label>
														<input type="text" name="electricity" class="form-control allow_float" placeholder="Electricity Bill">
													</div>
													
													<hr>
													
													<!--div class="col-md-3 mb-3">
														<label class="form-label">Employee EL</label>
														<input type="text" name="employee_el" class="form-control" placeholder="Employee EL">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Employee CL</label>
														<input type="text" name="employee_cl" class="form-control" placeholder="Employee CL">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Employee ML</label>
														<input type="text" name="employee_ml" class="form-control" placeholder="Employee ML">
													</div-->
													<div class="col-md-3 mb-3">
														<label class="form-label">EPF No</label>
														<input type="text" name="epf_no" class="form-control allow_number" placeholder="EPF No">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">ESI No</label>
														<input type="text" name="esi_no" class="form-control allow_number" placeholder="ESI No">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">PAN No</label>
														<input type="text" name="pan_no" class="form-control block_special" placeholder="PAN No">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Aadhaar No</label>
														<input type="text" name="aadhaar_no" class="form-control allow_number" placeholder="Aadhaar No">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Bank Name</label>
														<input type="text" name="bank_name" class="form-control block_special" placeholder="Bank Name">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">IFSC Code</label>
														<input type="text" name="ifsc_code" class="form-control block_special" placeholder="IFSC Code">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Account No</label>
														<input type="text" name="account_no" class="form-control allow_number" placeholder="Account No">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Employee Picture</label>
														<input type="file" name="employee_pic" class="form-control">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Employee Aadhaar Card</label>
														<input type="file" name="aadhaar_card_copy" class="form-control">
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Employee PAN Card</label>
														<input type="file" name="pan_card_copy" class="form-control">
													</div>
													
													
													<hr>
													<div class="col-md-12"><h5>Attendance</h5></div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Attendance Type</label>
														<select name="attendance_type" id="attendance_type" class="form-control">
															<option value="">~~~Choose~~~</option>
															<option value="Geofence">Geofence</option>
															<option value="Remote">Remote</option>
															<option value="Manual">Manual</option>
															
														</select>
													</div>
													
												</div>
												
												<input type="hidden" name="add_employee" value="add_employee">
												<button id="department_button" class="btn btn-primary" type="submit">Save</button>
											</form>

										</div> <!-- end card-body-->
									</div> <!-- end card-->
								</div> <!-- end col-->

							</div>
						<?php
						}
						?>
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
function action1(query1){
	if(query1 != ''){
		var action1 = 'fetch_reporting_manager';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action1:action1, query1:query1},
			success:function(data){
				//alert(data);
				$('#reporting_manager').html(data);
			}
		})
	}
}
</script>

<script>
function action2(query2){
	if(query2 != ''){
		var action2 = 'fetch_deport';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action2:action2, query2:query2},
			success:function(data){
				//alert(data);
				$('#deport_data').html(data);
			}
		})
	}
}
</script>

<script>
function action3(query3){
	if(query3 != ''){
		var action3 = 'fetch_division';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action3:action3, query3:query3},
			success:function(data){
				//alert(data);
				$('#dep_div_data').html(data);
			}
		})
	}
}
</script>

<script>
function action4(query4){
	if(query4 != ''){
		var action4 = 'fetch_reporting_manager_name';
		if($('#work_location').val() == ''){
			alert("Choose Work Location!");
			$("#reporting_manager").val("");
			$("#department_button").attr("disabled", true);
		}else{
			$("#department_button").attr("disabled", false);
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
function action41(query41){
	if(query41 != ''){
		var action41 = 'fetch_appointment_officer_name';
		if($('#work_location').val() == ''){
			alert("Choose Work Location!");
			$("#appointment_officer").val("");
			$("#department_button").attr("disabled", true);
		}else{
			$("#department_button").attr("disabled", false);
			if($('#work_location').val() == 'Division' || $('#work_location').val() == 'Deport'){
				if($('#office_name').val() == ''){
					alert("Choose Division/Deport!");
				}else{
					var work_location = $('#work_location').val();
					var office_name = $('#office_name').val();
					
					$.ajax({
						url:"query.php",
						method:"POST",
						data:{action41:action41, query41:query41, work_location:work_location, office_name:office_name},
						success:function(data){
							//alert(data);
							$('#appointment_officer_name').html(data);
						}
					})
				}
			}else{
				var work_location = $('#work_location').val();
				
				$.ajax({
					url:"query.php",
					method:"POST",
					data:{action41:action41, query41:query41, work_location:work_location, office_name:office_name},
					success:function(data){
						//alert(data);
						$('#appointment_officer_name').html(data);
					}
				})
			}
		}
		
		
		
	}
}
</script>





<script>
$(document).ready(function(){
	$('#department_form').on('submit', function(e){
		e.preventDefault();
		if($('#employee_code').val() == ''){
			//$('.form-control').css('border', '1px solid #ced4da');
			$('#employee_code').css('border', '1px solid #ff0000');
			$('#employee_code').focus();
		}else if($('#employee_name').val() == ''){
			$('.form-control').css('border', '1px solid #ced4da');
			$('#employee_name').css('border', '1px solid red');
			$('#employee_name').focus();
		}else if($('#work_location').val() == ''){
			$('.form-control').css('border', '1px solid #ced4da');
			$('#work_location').css('border', '1px solid red');
			$('#work_location').focus();
		}else if($('#department').val() == ''){
			$('.form-control').css('border', '1px solid #ced4da');
			$('#department').css('border', '1px solid red');
			$('#department').focus();
		}else if($('#employee_category').val() == ''){
			$('.form-control').css('border', '1px solid #ced4da');
			$('#employee_category').css('border', '1px solid red');
			$('#employee_category').focus();
		}else if($('#post').val() == ''){
			$('.form-control').css('border', '1px solid #ced4da');
			$('#post').css('border', '1px solid red');
			$('#post').focus();
		}else if($('#weekly_rest').val() == ''){
			$('.form-control').css('border', '1px solid #ced4da');
			$('#weekly_rest').css('border', '1px solid red');
			$('#weekly_rest').focus();
		}else if($('#phone').val() == ''){
			$('.form-control').css('border', '1px solid #ced4da');
			$('#phone').css('border', '1px solid red');
			$('#phone').focus();
		}else if($('#gender').val() == ''){
			$('.form-control').css('border', '1px solid #ced4da');
			$('#gender').css('border', '1px solid red');
			$('#gender').focus();
		}else if($('#dob').val() == ''){
			$('.form-control').css('border', '1px solid #ced4da');
			$('#dob').css('border', '1px solid red');
			$('#dob').focus();
		}else if($('#doj').val() == ''){
			$('.form-control').css('border', '1px solid #ced4da');
			$('#doj').css('border', '1px solid red');
			$('#doj').focus();
		}else{
			$('.form-control').css('border', '1px solid #ced4da');
			$.ajax({
				url:'query.php',
				type:'POST',
				//data:$('#department_form').serialize(),
				data:new FormData(this),  
				contentType:false,  
				processData:false,
				beforeSend:function(){
					$('#department_button').html('Please Wait...');
				},
				success:function(data){
					//alert(data);
					if(data=='Success'){
						$('#message').html('<p class="text-success">Employee Added Successfully!</p>');
						$('#department_form')[0].reset();
					}else if(data=='Success1'){
						$('#message').html('<p class="text-success">Employee Updated Successfully!</p>');
					}else{
						$('#message').html('<p class="text-danger">'+data+'</p>');
					}
					$('#department_button').html('Save');
					$('html, body').animate({ scrollTop: 0 }, 0);
				}
			});
		}
		
		
	});
});
</script>

<script type="text/javascript">
    $(function () {
        $(".allow_float").keypress(function (e) {
            var keyCode = e.keyCode || e.which;
			var regex = /^[.0-9]+$/;
			//var regex = /^[0-9]+$/;
			var isValid = regex.test(String.fromCharCode(keyCode));
            return isValid;
        });
    });
</script>

<script type="text/javascript">
    $(function () {
        $(".allow_number").keypress(function (e) {
            var keyCode = e.keyCode || e.which;
			var regex = /^[0-9]+$/;
			//var regex = /^[0-9]+$/;
			var isValid = regex.test(String.fromCharCode(keyCode));
            return isValid;
        });
    });
</script>

<script type="text/javascript">
    $(function () {
        $(".block_special").keypress(function (e) {
            var keyCode = e.keyCode || e.which;
			var regex = /^[0-9 A-Za-z_,]+$/;
			//var regex = /^[0-9]+$/;
			var isValid = regex.test(String.fromCharCode(keyCode));
            return isValid;
        });
    });
</script>

<script>
function action_no_of_family(query_no_of_family){
	var action_no_of_family = 'fetch_no_of_family';
	
	if(query_no_of_family > 6){
		$('#dependent_error').html('Dependent can not more than 6!');
	}else{
		$('#dependent_error').html('');
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action_no_of_family:action_no_of_family, query_no_of_family:query_no_of_family},
			success:function(data){
				//alert(data);
				$('#no_of_family_data').html(data);
			}
		})
	}
	
}
</script>

<script>
 $(document).ready(function(){
	$(document).on('click', '#checkAll', function() {          	
		$(".itemRow").prop("checked", this.checked);
	});	
	$(document).on('click', '.itemRow', function() {  	
		if ($('.itemRow:checked').length == $('.itemRow').length) {
			$('#checkAll').prop('checked', true);
		} else {
			$('#checkAll').prop('checked', false);
		}
	});  
	var count = $(".itemRow").length;
	$(document).on('click', '#addRows', function() { 
		count++;
		
		var htmlRows = '';
		htmlRows += '<tr id="lic_list_'+count+'">';
			htmlRows += '<td><input class="itemRow" type="checkbox" value="delivery_id'+count+'"></td>';
			htmlRows += '<td><input type="text" name="lic_number[]" class="form-control allow_number" placeholder="LIC Number"></td>';          
			htmlRows += '<td><input type="text" name="lic_premium[]" class="form-control allow_float" placeholder="LIC Premium"></td>';          
		htmlRows += '</tr>';
		$('#lic_list_data').append(htmlRows);
	}); 
	$(document).on('click', '#removeRows', function(){
		$(".itemRow:checked").each(function() {
			$(this).closest('tr').remove();
		});
		$('#checkAll').prop('checked', false);
		calculateTotal();
	});		
		
	$(document).on('click', '.deleteInvoice', function(){
		var id = $(this).attr("id");
		if(confirm("Are you sure you want to remove this?")){
			$.ajax({
				url:"action.php",
				method:"POST",
				dataType: "json",
				data:{id:id, action:'delete_invoice'},				
				success:function(response) {
					if(response.status == 1) {
						$('#'+id).closest("tr").remove();
					}
				}
			});
		} else {
			return false;
		}
	});
 });	
</script>

<script>
function action3_2(query3_2){
	if(query3_2 != ''){
		var action3_2 = 'fetch_post';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action3_2:action3_2, query3_2:query3_2},
			success:function(data){
				//alert(data);
				$('#post').html(data);
			}
		})
	}else{
		$('#post').html('<option value="">~~~Choose~~~</option>');
	}
}
</script>
      
    </body>
</html>