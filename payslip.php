<?php
if(empty($_POST)){
    header("Location: salary-report");
}

include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}

$month		= base64_decode(mysqli_real_escape_string($db->link, $_POST['month']));
$year		= base64_decode(mysqli_real_escape_string($db->link, $_POST['year']));

$salary_month = $year.'-'.$month;

$total_no_of_days=cal_days_in_month(CAL_GREGORIAN,$month,$year);

$start_date = $year.'-'.$month.'-01';
$end_date	= $year.'-'.$month.'-'.$total_no_of_days;

$sundays=0;
$total_days=cal_days_in_month(CAL_GREGORIAN, $month, $year);
for($i=1;$i<=$total_days;$i++){
	if(date('N',strtotime($year.'-'.$month.'-'.$i))==7){
		$sundays++;
	}
}

$query4 = "SELECT * FROM `employee` where phone='".base64_decode($_POST['employee'])."'";
$row4 = $db->select($query4);
$record4 = $row4->fetch_array();

if($record4['basic_salary']=='' || $record4['basic_salary']==NULL){
	$basic_salary = 0;
}else{
	if(is_string($record4['basic_salary'])==1){
		$basic_salary = 0;
	}else{
		$basic_salary = $record4['basic_salary'];
	}
}

if($record4['grade_pay']==''){
	$grade_pay = 0;
}else{
	if(is_string($record4['grade_pay'])==1){
		$grade_pay = 0;
	}else{
		$grade_pay = $record4['grade_pay'];
	}
}

$query = "SELECT * FROM `allowence`";
$row = $db->select($query);
$record = $row->fetch_array();

if($record['da_type']=='INR'){
	$da = $record['da'];
}else{
	$da = ($basic_salary * $record['da'] )/100;
}

if($record['personal_pay_type']=='INR'){
	$personal_pay = $record['personal_pay'];
}else{
	$personal_pay = ($basic_salary * $record['personal_pay'] )/100;
}

if($record['medical_allowence_type']=='INR'){
	$medical_allowence = $record['medical_allowence'];
}else{
	$medical_allowence = ($basic_salary * $record['medical_allowence'] )/100;
}

if($record['hra_type']=='INR'){
	$hra	 = $record['hra'];
}else{
	$hra	 = ($basic_salary * $record['hra'] )/100;
}

if($record['hill_allowence_type']=='INR'){
	$hill_allowence	 = $record['hill_allowence'];
}else{
	$hill_allowence	 = ($basic_salary * $record['hill_allowence'] )/100;
}

if($record['border_allowence_type']=='INR'){
	$border_allowence	 = $record['border_allowence'];
}else{
	$border_allowence	 = ($basic_salary * $record['border_allowence'] )/100;
}

if($record['cca_type']=='INR'){
	$cca	 = $record['cca'];
}else{
	$cca	 = ($basic_salary * $record['cca'] )/100;
}

$query1 = "SELECT * FROM `deduction`";
$row1 = $db->select($query1);
$record1 = $row1->fetch_array();

if($record1['epf_type']=='INR'){
	$epf = $record1['epf'];
}else{
	$epf = ($basic_salary * $record1['epf'] )/100;
}

if($record1['gpf_type']=='INR'){
	$gpf = $record1['gpf'];
}else{
	$gpf = ($basic_salary * $record1['gpf'] )/100;
}

if($record1['gpf_type']=='INR'){
	$gpf = $record1['gpf'];
}else{
	$gpf = ($basic_salary * $record1['gpf'] )/100;
}

if($record1['gis_1_type']=='INR'){
	$gis_1 = $record1['gis_1'];
}else{
	$gis_1 = ($basic_salary * $record1['gis_1'] )/100;
}

if($record1['gis_2_type']=='INR'){
	$gis_2 = $record1['gis_2'];
}else{
	$gis_2 = ($basic_salary * $record1['gis_2'] )/100;
}

if($record1['ewf_type']=='INR'){
	$ewf = $record1['ewf'];
}else{
	$ewf = ($basic_salary * $record1['ewf'] )/100;
}

if($record1['income_tax_type']=='INR'){
	$income_tax = $record1['income_tax'];
}else{
	$income_tax = ($basic_salary * $record1['income_tax'] )/100;
}

$total_allowence = 0;
$total_deduction = 0;
$total_allowence = $da + $personal_pay + $medical_allowence + $hra + $hill_allowence + $border_allowence + $cca;
$total_deduction = $epf + $gpf + $gis_1 + $gis_2 + $ewf + $income_tax;
$total_salary = $basic_salary + ($total_allowence - $total_deduction) + $grade_pay;
$salary_per_day = $total_salary / $total_no_of_days;

$query1 = "SELECT count(id) as attendance_count FROM `attendance` where employee='".$record4['phone']."' and attendance_date LIKE '$salary_month%' and check_out!='NULL'";
$row1 = $db->select($query1);
$record1 = $row1->fetch_array();

$query2 = "SELECT count(id) as regulization_count FROM `regulization_request` where employee='".$record4['phone']."' and requested_date LIKE '$salary_month%' and is_approved='1'";
$row2 = $db->select($query2);
$record2 = $row2->fetch_array();

$query3 = "SELECT sum(lic_premium) as lic_premium_amount FROM `lic_data` where employee_code='".$record4['phone']."'";
$row3 = $db->select($query3);
$record3 = $row3->fetch_array();

$leave_count =0;
$query5 = "SELECT * FROM `leave_request` where employee='".$record4['phone']."' and ((from_date >= '$start_date' and from_date <= '$end_date') or (to_date >= '$start_date' and to_date <= '$end_date')) and is_approved='1'";
$row5 = $db->select($query5);
if ($row5->num_rows > 0) {
	while($record5 = $row5->fetch_array()){
		
		if($record5['leave_type']=='LW'){
			$no_of_days = 0;
		}else{
			if($record5['from_date'] <= $start_date){
				$date1=date_create($start_date);
				$date2=date_create($end_date);
				$diff=date_diff($date1,$date2);
				$no_of_days = $diff->format("%a");
				
				$no_of_days = $no_of_days + 1;
				
				$start = new DateTime($start_date);
				$end = new DateTime($end_date);
			}else if($record5['to_date'] >= $end_date){
				$date1=date_create($record5['from_date']);
				$date2=date_create($end_date);
				$diff=date_diff($date1,$date2);
				$no_of_days = $diff->format("%a");
				
				$no_of_days = $no_of_days + 1;
				
				$start = new DateTime($record5['from_date']);
				$end = new DateTime($end_date);
			}else if($record5['from_date'] >= $start_date && $record5['to_date'] <= $end_date){
				$date1=date_create($record5['from_date']);
				$date2=date_create($record5['to_date']);
				$diff=date_diff($date1,$date2);
				$no_of_days = $diff->format("%a");
				
				$no_of_days = $no_of_days + 1;
				
				$start = new DateTime($record5['from_date']);
				$end = new DateTime($record5['to_date']);
			}else{
				$no_of_days = 0;
			}
		}
		
		$leave_count = $leave_count + $no_of_days;
	}
	$days = $start->diff($end, true)->days;
	$leave_sundays = intval($days / 7) + ($start->format('N') + $days % 7 >= 7);
	$sundays = $sundays - $leave_sundays;
}else{
	$sundays = $sundays;
}

if($record1['attendance_count'] > 0){
	$attendance_count = $record1['attendance_count'] + $sundays;
	$lic_premium_amount = $record3['lic_premium_amount'];
}else{
	$attendance_count = $record1['attendance_count'];
	$lic_premium_amount = 0;
}


$attendance_count = $attendance_count + $record2['regulization_count'] + $leave_count;


$gross_salary = ($salary_per_day * $attendance_count) - $lic_premium_amount;




?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Payslip | GB Pant</title>
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
                                    <h4 class="page-title"><span class="text-primary"><?= $record4['employee_name']; ?>'s</span> Payslip of <span class="text-primary"><?= $year.' - '.date("F",strtotime($month)); ?></span></h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Payslip</a></li>
                                            <li class="breadcrumb-item active">Payslip</li>
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
											<div class="col-lg-12" id="message"></div>
											<div class="col-lg-6">
												<form id="attendance_request_approval_form">
													<div class="table-responsive">
														<table class="table table-sm mb-0">
															<thead>
																<tr class="table-primary">
																	<th colspan="2">Salary Breakdown</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<th>Employee Code</th>
																	<td><?= $record4['employee_code']; ?></td>
																</tr>
																<tr>
																	<th>Employee Name</th>
																	<td><?= $record4['employee_name']; ?></td>
																</tr>
																<tr class="text-success">
																	<th>Basic Amount</th>
																	<td> + <i class="fa fa-inr"></i> <?= number_format($basic_salary,2); ?></td>
																</tr>
																<tr class="text-success">
																	<th>Grade Pay</th>
																	<td> + <i class="fa fa-inr"></i> <?= number_format($grade_pay,2); ?></td>
																</tr>
																<tr class="text-success">
																	<th>Total Allowence</th>
																	<td> + <i class="fa fa-inr"></i> <?= number_format($total_allowence,2); ?></td>
																</tr>
																<tr class="text-danger">
																	<th>Total Deduction</th>
																	<td> - <i class="fa fa-inr"></i> <?= number_format($total_deduction,2); ?></td>
																</tr>
																<tr class="text-danger">
																	<th>LIC Premium</th>
																	<td> - <i class="fa fa-inr"></i> <?= number_format($lic_premium_amount,2); ?></td>
																</tr>
																<tr class="text-success">
																	<th>Salary Amount</th>
																	<th><i class="fa fa-inr"></i> <?= number_format($total_salary,2); ?></th>
																</tr>
															</tbody>
														</table>
													</div>
												</form>
											</div>
											
											<div class="col-lg-6">
												<form id="attendance_request_approval_form">
													<div class="table-responsive">
														<table class="table table-sm mb-0">
															<thead>
																<tr class="table-success">
																	<th colspan="2">Payslip</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<th>Total No of Days</th>
																	<td><?= $total_no_of_days; ?></td>
																</tr>
																<tr>
																	<th>Present Days</th>
																	<td><?= $record1['attendance_count'] + $record2['regulization_count']; ?></td>
																</tr>
																<tr>
																	<th>Absent Days</th>
																	<td><?= $total_no_of_days - $attendance_count; ?></td>
																</tr>
																<tr>
																	<th>Sunday</th>
																	<td><?= $sundays; ?></td>
																</tr>
																<tr>
																	<th>Holidays</th>
																	<td>0</td>
																</tr>
																<tr>
																	<th>Paid Leave</th>
																	<td><?= $leave_count; ?></td>
																</tr>
																<tr>
																	<th>Total Days Count</th>
																	<td><?= $attendance_count; ?></td>
																</tr>
																
																<tr class="text-success">
																	<th>Payble Amount</th>
																	<th><i class="fa fa-inr"></i> <?= number_format($gross_salary,2); ?></th>
																</tr>
															</tbody>
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