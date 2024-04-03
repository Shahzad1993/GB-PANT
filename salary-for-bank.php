<?php
include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ../");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Salary for Bank | GB Pant</title>
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
                                    <h4 class="page-title">Salary for Bank</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                                            <li class="breadcrumb-item active">Salary for Bank</li>
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
											<div class="col-lg-12">
												<form id="attendance_request_approval_form">
													<div class="table-responsive">
														<table class="table table-sm mb-0">
															<thead>
																<tr class="text-nowrap bg-primary text-white">
																	<th>#</th>
																	<th>Name</th>
																	<th>Designation</th>
																	<th>Bank Name</th>
																	<th>Account No.</th>
																	<th>IFSC Code</th>
																	<th>Payble Amount</th>
																</tr>
															</thead>
															<tbody id="salary_search_data">
																<?php
																$total_gross_salary		= 0;
																$month		= date("m");
																$year		= date("Y");
																
																$salary_month = $year.'-'.$month;
																
																$no_of_days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
																
																$start_date = $year.'-'.$month.'-01';
																$end_date	= $year.'-'.$month.'-'.$no_of_days;
																
																$sundays=0;
																$total_days=cal_days_in_month(CAL_GREGORIAN, $month, $year);
																for($i=1;$i<=$total_days;$i++)
																if(date('N',strtotime($year.'-'.$month.'-'.$i))==7){
																	$sundays++;
																}
																
																$output='';
																
																$current_month = date("Y-m");
																
																if($current_month >= $salary_month){
																	$i= 1;
																	$query4 = "SELECT * FROM `employee` order by employee_name asc";
																	$row4 = $db->select($query4);
																	while($record4 = $row4->fetch_array()){
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
																		
																		$query6 = "SELECT * FROM `post` where id='".$record4['post']."'";
																		$row6 = $db->select($query6);
																		$record6 = $row6->fetch_array();
																		
																		$query = "SELECT * FROM `allowence`";
																		$row = $db->select($query);
																		$record = $row->fetch_array();
																		
																		if($record['da_type']=='INR'){
																			$da = $record['da'];
																		}else{
																			if($basic_salary==0 || $record['da']){
																				$da = 0;
																			}else{
																				$da = ($basic_salary * $record['da'] )/100;
																			}
																		}
																		
																		if($record['personal_pay_type']=='INR'){
																			$personal_pay = $record['personal_pay'];
																		}else{
																			if($basic_salary==0 || $record['personal_pay']){
																				$personal_pay = 0;
																			}else{
																				$personal_pay = ($basic_salary * $record['personal_pay'] )/100;
																			}
																		}
																		
																		if($record['medical_allowence_type']=='INR'){
																			$medical_allowence = $record['medical_allowence'];
																		}else{
																			if($basic_salary==0 || $record['medical_allowence']){
																				$medical_allowence = 0;
																			}else{
																				$medical_allowence = ($basic_salary * $record['medical_allowence'] )/100;
																			}
																			
																		}
																		
																		if($record['hra_type']=='INR'){
																			$hra	 = $record['hra'];
																		}else{
																			if($basic_salary==0 || $record['hra']){
																				$hra = 0;
																			}else{
																				$hra	 = ($basic_salary * $record['hra'] )/100;
																			}
																		}
																		
																		if($record['hill_allowence_type']=='INR'){
																			$hill_allowence	 = $record['hill_allowence'];
																		}else{
																			if($basic_salary==0 || $record['hill_allowence']){
																				$hill_allowence = 0;
																			}else{
																				$hill_allowence	 = ($basic_salary * $record['hill_allowence'] )/100;
																			}
																		}
																		
																		if($record['border_allowence_type']=='INR'){
																			$border_allowence	 = $record['border_allowence'];
																		}else{
																			if($basic_salary==0 || $record['border_allowence']){
																				$border_allowence = 0;
																			}else{
																				$border_allowence	 = ($basic_salary * $record['border_allowence'] )/100;
																			}
																		}
																		
																		if($record['cca_type']=='INR'){
																			$cca	 = $record['cca'];
																		}else{
																			if($basic_salary==0 || $record['cca']){
																				$cca = 0;
																			}else{
																				$cca	 = ($basic_salary * $record['cca'] )/100;
																			}
																		}
																		
																		
																		$query1 = "SELECT * FROM `deduction`";
																		$row1 = $db->select($query1);
																		$record1 = $row1->fetch_array();
																		
																		if($record1['epf_type']=='INR'){
																			$epf = $record1['epf'];
																		}else{
																			if($basic_salary==0 || $record1['epf']){
																				$epf = 0;
																			}else{
																				$epf = ($basic_salary * $record1['epf'] )/100;
																			}
																		}
																		
																		if($record1['gpf_type']=='INR'){
																			$gpf = $record1['gpf'];
																		}else{
																			if($basic_salary==0 || $record1['gpf']){
																				$gpf = 0;
																			}else{
																				$gpf = ($basic_salary * $record1['gpf'] )/100;
																			}
																		}
																		
																		if($record1['gis_1_type']=='INR'){
																			$gis_1 = $record1['gis_1'];
																		}else{
																			if($basic_salary==0 || $record1['gis_1']){
																				$gis_1 = 0;
																			}else{
																				$gis_1 = ($basic_salary * $record1['gis_1'] )/100;
																			}
																		}
																		
																		if($record1['gis_2_type']=='INR'){
																			$gis_2 = $record1['gis_2'];
																		}else{
																			if($basic_salary==0 || $record1['gis_2']){
																				$gis_2 = 0;
																			}else{
																				$gis_2 = ($basic_salary * $record1['gis_2'] )/100;
																			}
																		}
																		
																		if($record1['ewf_type']=='INR'){
																			$ewf = $record1['ewf'];
																		}else{
																			if($basic_salary==0 || $record1['ewf']){
																				$ewf = 0;
																			}else{
																				$ewf = ($basic_salary * $record1['ewf'] )/100;
																			}
																		}
																		
																		if($record1['income_tax_type']=='INR'){
																			$income_tax = $record1['income_tax'];
																		}else{
																			if($basic_salary==0 || $record1['income_tax']){
																				$income_tax = 0;
																			}else{
																				$income_tax = ($basic_salary * $record1['income_tax'] )/100;
																			}
																		}
																		
																		$total_allowence = 0;
																		$total_deduction = 0;
																		
																		$total_allowence = $basic_salary + $da + $personal_pay + $medical_allowence + $hra + $hill_allowence + $border_allowence + $cca;
																		
																		$total_deduction = $epf + $gpf + $gis_1 + $gis_2 + $ewf + $income_tax;
																		
																		$total_salary = ($total_allowence - $total_deduction) + $grade_pay;
																		
																		$salary_per_day = $total_salary / $no_of_days;
																		
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
																						$date2=date_create($record5['to_date']);
																						$diff=date_diff($date1,$date2);
																						$no_of_days = $diff->format("%a");
																						
																						$no_of_days = $no_of_days + 1;
																					}else if($record5['to_date'] >= $end_date){
																						$date1=date_create($record5['from_date']);
																						$date2=date_create($end_date);
																						$diff=date_diff($date1,$date2);
																						$no_of_days = $diff->format("%a");
																						
																						$no_of_days = $no_of_days + 1;
																					}else if($record5['from_date'] >= $start_date && $record5['to_date'] <= $end_date){
																						$date1=date_create($record5['from_date']);
																						$date2=date_create($record5['to_date']);
																						$diff=date_diff($date1,$date2);
																						$no_of_days = $diff->format("%a");
																						
																						$no_of_days = $no_of_days + 1;
																					}else{
																						$no_of_days = 0;
																					}
																				}
																				
																				
																				$leave_count = $leave_count + $no_of_days;
																			}
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
																		
																		$output .= '<tr>
																			<td>'.$i.'</td>
																			<td>'.$record4['employee_name'].'</td>
																			<td>'.$record6['post_name_en'].'</td>
																			<td>'.$record4['bank_name'].'</td>
																			<td>'.$record4['account_no'].'</td>
																			<td>'.$record4['ifsc_code'].'</td>
																			<td><i class="fa fa-inr"></i> '.number_format($gross_salary,2).'</td>
																		</tr>';
																		$i++;
																		
																		$total_gross_salary = $total_gross_salary + $gross_salary;
																	}
																}else{
																	echo 'Not Found!';
																}
																	
																echo $output;
																?>
																<tr>
																	<th colspan="5"></th>
																	<th>Total</th>
																	<th><i class="fa fa-inr"></i> <?= number_format($total_gross_salary,2); ?></th>
																</tr>
																<tr>
																	<td colspan="6" class="text-center"><button type="button" class="btn btn-primary btn-sm" onclick="window.print()"><i class="fa fa-printer"></i> Print Now</button></td>
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

    </body>
</html>