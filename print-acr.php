<?php
include 'config/main.php';
$db = new Main;

date_default_timezone_set("Asia/Kolkata");

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}

$query11="select * from self_appraisal where id='".$_REQUEST['id']."'";
$row11=$db->select($query11);
$record11=$row11->fetch_array();

if(file_exists($record11['award'])){
	$award = '<img src="'.$record11['award'].'" style="width:50%">';
}else{
	$award = '';
}

$query="select * from acr where id='".$record11['acr_id']."'";
$row=$db->select($query);
$record=$row->fetch_array();

$query1="select employee_name,employee_code,phone,father_name,office_name,work_location from employee where employee_code='".$record11['employee']."'";
$row1=$db->select($query1);
$record1=$row1->fetch_array();

$query2="select post_name,post_name_en,level from post where id='".$record['present_post']."'";
$row2=$db->select($query2);
$record2=$row2->fetch_array();

if($record1['work_location']=='Division'){
	$query21="select division from division where id='".$record1['office_name']."'";
	$row21=$db->select($query21);
	$record21=$row21->fetch_array();
	
	$office_name = $record1['work_location'].' - '.$record21['division'];;
	$office_name1 = $record21['division'];;
}else if($record1['work_location']=='Depot'){
	$query21="select deport from deport where id='".$record1['office_name']."'";
	$row21=$db->select($query21);
	$record21=$row21->fetch_array();
	
	$office_name = $record1['work_location'].' - '.$record21['deport'];
	$office_name1 = $record21['deport'];
}else{
	$office_name = $record1['work_location'];
	$office_name1 = $record1['work_location'];
}

$query_1="select employee_name from employee where employee_code='".$record['reporting_authority_name']."'";
$row_1=$db->select($query_1);
if($row_1->num_rows > 0){
	$record_1=$row_1->fetch_array();
	$reporting_authority_name = $record_1['employee_name'];
}else{
	$reporting_authority_name = '';
}
$query_2="select post_name from post where id='".$record['reporting_authority_post']."'";
$row_2=$db->select($query_2);
if($row_2->num_rows > 0){
	$record_2=$row_2->fetch_array();
	$reporting_authority_post = $record_2['post_name'];
}else{
	$reporting_authority_post = '';
}

$query_11="select employee_name from employee where employee_code='".$record['reviewing_authority_name']."'";
$row_11=$db->select($query_11);
if($row_11->num_rows > 0){
	$record_11=$row_11->fetch_array();
	$reviewing_authority_name = $record_11['employee_name'];
}else{
	$reviewing_authority_name = '';
}
$query_21="select post_name from post where id='".$record['reviewing_authority_post']."'";
$row_21=$db->select($query_21);
if($row_21->num_rows > 0){
	$record_21=$row_21->fetch_array();
	$reviewing_authority_post = $record_21['post_name'];
}else{
	$reviewing_authority_post = '';
}

$query_12="select employee_name from employee where employee_code='".$record['accepting_authority_name']."'";
$row_12=$db->select($query_12);
if($row_12->num_rows > 0){
	$record_12=$row_12->fetch_array();
	$accepting_authority_name = $record_12['employee_name'];
}else{
	$accepting_authority_name = '';
}
$query_22="select post_name from post where id='".$record['accepting_authority_post']."'";
$row_22=$db->select($query_22);
if($row_22->num_rows > 0){
	$record_22=$row_22->fetch_array();
	$accepting_authority_post = $record_22['post_name'];
}else{
	$accepting_authority_post = '';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Print ACR | UKPN</title>
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

<style>
th,td{
	/*white-space: nowrap;*/
	padding: 5px 15px !important;
	font-size: 11px;
}
.acr_header{
	background-color: #01933e;
	padding: 5px 20px;
	color: #fff;
	font-size: 14px;
}
.table-responsive{
	margin-bottom: 6px;
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
                                    <h4 class="page-title">Print ACR</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">ACR</a></li>
                                            <li class="breadcrumb-item active">Print ACR</li>
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
										<div class="row">
											<div class="col-xl-12" id="printableArea">
												<div class="card">
													<div class="card-body">
														
														<div class="row">
															<div class="col-md-12 mb-2 text-center">
																<table style="width:100%">
																	<tr>
																		<td style="width:20%"></td>
																		<td style="width:60%">
																			<h3>उत्तराखंड परिवहन निगम</h3>
																			<h5 class="text-uppercase"><?= $office_name1; ?></h5>
																			<h4 class="text-uppercase">वार्षिक गोपनीय प्रविष्टि  (<?= $record['year']; ?>)</h4>
																		</td>
																		<td style="width:20%"><img src="assets/images/logo-light.png" alt="" height="65"></td>
																	</tr>
																</table>
																
																
															</div>
															<div class="col-md-12 mb-1"><strong>क्रमांक  <?= $_REQUEST['id']; ?> / <?= $office_name1; ?> / <?= $record['year']; ?></strong></div>
															<div class="col-md-12 mb-1">
																<div class="table-responsive">
																	<table class="table table-bordered">
																		<thead>
																			<tr>
																				<th colspan="6"><?= $record1['employee_name']; ?> का <?= $record['year']; ?> का एसीआर विवरण :</th>
																			</tr>
																		</thead>
																		<thead>
																			<tr>
																				<th>पदनाम</th>
																				<td><?= $record2['post_name']; ?></td>
																				<th class="nowrap">कर्मचारी कोड </th>
																				<td><?= $record1['employee_code']; ?></td>
																				<th>कर्मचारी का नाम</th>
																				<td><?= $record1['employee_name']; ?></td>
																			</tr>
																			
																			<tr>
																				<th>पिता / पति का नाम </th>
																				<td><?= $record1['father_name']; ?></td>
																				<th>मोबाइल</th>
																				<td><?= $record1['phone']; ?></td>
																				<td colspan="2"></td>
																			</tr>
																			<tr>
																				<th>वर्ष</th>
																				<td><?= $record['year']; ?></td>
																				<th>दिनांक </th>
																				<td><?= date("d M, Y", strtotime($record11['from_date'])); ?></td>
																				<th>से दिनांक </th>
																				<td><?= date("d M, Y", strtotime($record11['to_date'])); ?></td>
																			</tr>
																			
																		</thead>
																	</table>
																</div>
															</div>
															
														</div>
														
														<div class="row">
															<?php
															if($record2['post_name_en']=='DRIVER' || $record2['post_name_en']=='CONDUCTOR' || $record2['level']=='10'){
															?>
															
															<?php	
															}else{
															?>
															<div class="col-md-12 mb-1">स्वः मूल्यांकन</div>
															<div class="col-md-12 mb-1">
																<div class="table-responsive">
																	<table class="table table-bordered">
																		<thead>
																			<tr>
																				<th colspan="3">आलोच्य अवधि में आवंटित उत्तरदायित्वों का सार अंकित किया जाये:</th>
																			</tr>
																			<tr>
																				<th>#</th>
																				<th>समयावधि</th>
																				<th>आवंटित उत्तरदायित्व</th>
																			</tr>
																		</thead>
																		<tbody>
																			<?php
																			$i=1;
																			$query5="select * from summary_responsibilities_alloted where self_appraisal_id='".$_REQUEST['id']."'";
																			$row5=$db->select($query5);
																			while($record5=$row5->fetch_array()){
																			?>
																			<tr>
																				<th><?= $i; ?></th>
																				<td><?= $record5['period']; ?></td>
																				<td><?= $record5['alloted_responsibility']; ?></td>
																			</tr>
																			
																			<?php
																			$i++;
																			}
																			?>
																		</tbody>
																	</table>
																</div>
															</div>
															
															<div class="col-md-12 mb-1">
																<div class="table-responsive">
																	<table class="table table-bordered">
																		<thead>
																			<tr>
																				<th colspan="4">वार्षिक कार्य योजना और उपलब्धि:</th>
																			</tr>
																			<tr>
																				<th>#</th>
																				<th>विषय</th>
																				<th>वर्तमान वर्ष</th>
																			</tr>
																		</thead>
																		<tbody>
																			<?php
																			$i=1;
																			$query6="select * from annual_work_plan where self_appraisal_id='".$_REQUEST['id']."'";
																			$row6=$db->select($query6);
																			while($record6=$row6->fetch_array()){
																			?>
																			<tr>
																				<th><?= $i; ?></th>
																				<td><?= $record6['task_to_be_performed']; ?></td>
																				<td><?= $record6['actual_achievement']; ?></td>
																			</tr>
																			
																			<?php
																			$i++;
																			}
																			?>
																			
																		</tbody>
																	</table>
																</div>
															</div>
															<?php
															}
															?>
														</div>
														
														<div class="row">
															<?php
															$query_04="select * from employee_appraisal where self_appraisal_id='".$record11['id']."'";
															$row_04=$db->select($query_04);
															if($row_04->num_rows > 0){
																$record_04=$row_04->fetch_array();
																$employee_appraisal_id = $record_04['id'];
																
																if($record_04['shreni'] == 'A'){
																	$shreni_1 = 'A - उत्कृष्ट';
																}else if($record_04['shreni'] == 'B'){
																	$shreni_1 = 'B - अतिउत्तम';
																}else if($record_04['shreni'] == 'C'){
																	$shreni_1 = 'C - उत्तम';
																}else if($record_04['shreni'] == 'D'){
																	$shreni_1 = 'D - अच्छा';
																}else if($record_04['shreni'] == 'E'){
																	$shreni_1 = 'E - ख़राब';
																}else{
																	$shreni_1 = 'E - ख़राब';
																}
																
																$query_0121="select employee_name,post from employee where employee_code='".$record_04['created_by']."'";
																$row_0121=$db->select($query_0121);
																$record_0121=$row_0121->fetch_array();
																
																$query_0122="select post_name from post where id='".$record_0121['post']."'";
																$row_0122=$db->select($query_0122);
																$record_0122=$row_0122->fetch_array();
																?>
																<div class="col-md-12 mb-1"><?= $record_0121['employee_name']; ?>  ( <?= $record_0122['post_name']; ?> )  द्वारा  मूल्यांकन</div>
																<?php
																if($record2['post_name_en']=='DRIVER' || $record2['post_name_en']=='CONDUCTOR' || $record2['level']=='10'){
																?>
																	<div class="col-md-12 mb-1">
																		<div class="table-responsive">
																			<table class="table table-bordered">
																				<thead>
																					<tr>
																						<th colspan="5">वार्षिक कार्य योजना और उपलब्धि :</th>
																					</tr>
																				</thead>
																				<tbody>
																					<tr>
																						<th style="width:4%">#</th>
																						<th style="width:36%">विषय </th>
																						<th style="width:20%">वर्तमान वर्ष </th>
																						<th style="width:20%">ग्रेड (1 to 10)</th>
																						<th style="width:20%">श्रेणी </th>
																					</tr>
																					<?php
																					$a=1;
																					$query41="select * from annual_work_plan where self_appraisal_id='".$record11['id']."'";
																					$row41=$db->select($query41);
																					while($record41=$row41->fetch_array()){
																						if($record41['task_to_be_performed']=='Behaviour'){
																							$work = 'सामान्य व्यवहार';
																						}else{
																							$query4="select * from deport_level_annual_work where id='".$record41['task_to_be_performed']."'";
																							$row4=$db->select($query4);
																							$record4=$row4->fetch_array();
																							$work = $record4['work'];
																						}
																						$actual_achievement = $record41['actual_achievement'];
																						$grade = $record41['grade'];
																						
																						$query42="select * from grading where min_grade <= $grade and max_grade >= $grade";
																						$row42=$db->select($query42);
																						$record42=$row42->fetch_array();
																					?>
																						<tr>
																							<td><?= $a; ?></td>
																							<th><?= $work; ?></th>
																							<td><?= $record41['actual_achievement']; ?></td>
																							<td><?= $record41['grade']; ?></td>
																							<td><?= $record42['shreni'].' - '.$record42['shreni_name']; ?></td>
																						</tr>
																					<?php
																					$a++;
																					}
																					$total = $row41->num_rows;;
																					?>
																				</tbody>
																				<tfoot>
																					<tr>
																						<th></th>
																						<th></th>
																						<th>समग्र ग्रेड</th>
																						<th><?= $record_04['overall_grade']; ?></th>
																						<th><?= $shreni_1; ?></th>
																					</tr>
																				</tfoot>
																		   </table>
																		</div>
																	</div>
																<?php
																}else{
																?>
																	<div class="col-md-12 mb-1">
																		<div class="table-responsive">
																			<table class="table table-bordered">
																				<thead>
																					<tr>
																						<th colspan="4">वयक्तिगत गुणों का मूल्यांकन :</th>
																					</tr>
																					<tr>
																						<th>#</th>
																						<th>वयक्तिगत गुण</th>
																						<th>ग्रेड  (1 - 10) </th>
																						<th>श्रेणी</th>
																					</tr>
																				</thead>
																				<tbody>
																					<?php
																					$i=1;
																					$query_05="select * from assestment_of_personal_attributes_data where employee_appraisal_id='".$record_04['id']."'";
																					$row_05=$db->select($query_05);
																					while($record_05=$row_05->fetch_array()){
																						$query_06="select * from assestment_of_personal_attributes where id='".$record_05['assestment_of_personal_attributes_id']."'";
																						$row_06=$db->select($query_06);
																						$record_06=$row_06->fetch_array();
																						
																						$query42="select * from grading where min_grade <= ".$record_05['grade']." and max_grade >= ".$record_05['grade']."";
																						$row42=$db->select($query42);
																						$record42=$row42->fetch_array();
																					?>
																					<tr>
																						<th><?= $i; ?></th>
																						<td><?= $record_06['personal_attribute']; ?></td>
																						<td><?= $record_05['grade']; ?></td>
																						<td><?= $record42['shreni'].' - '.$record42['shreni_name']; ?></td>
																					</tr>
																					<?php
																					$i++;
																					}
																					?>
																					<tr>
																						<th colspan="4">किये गए कार्यों का मूल्यांकन :</th>
																					</tr>
																					<?php
																					$i=1;
																					$query_07="select * from assessment_of_work_output_data where employee_appraisal_id='".$record_04['id']."'";
																					$row_07=$db->select($query_07);
																					while($record_07=$row_07->fetch_array()){
																						$query_08="select * from assessment_of_work_output where id='".$record_07['assessment_of_work_output_id']."'";
																						$row_08=$db->select($query_08);
																						$record_08=$row_08->fetch_array();
																						
																						$query42="select * from grading where min_grade <= ".$record_07['grade']." and max_grade >= ".$record_07['grade']."";
																						$row42=$db->select($query42);
																						$record42=$row42->fetch_array();
																					?>
																					<tr>
																						<th><?= $i; ?></th>
																						<td><?= $record_08['work_output']; ?></td>
																						<td><?= $record_07['grade']; ?></td>
																						<td><?= $record42['shreni'].' - '.$record42['shreni_name']; ?></td>
																					</tr>
																					<?php
																					$i++;
																					}
																					?>
																					<tfoot>
																					<tr>
																						<th></th>
																						<th>समग्र ग्रेड</th>
																						<th><?= $record_04['overall_grade']; ?></th>
																						<th><?= $shreni_1; ?></th>
																					</tr>
																				</tfoot>
																				</tbody>
																			</table>
																		</div>
																	</div>
																<?php	
																}
																
																?>
																<div class="col-md-12 mb-1">
																	<div class="table-responsive">
																		<table class="table table-bordered">
																			<tbody>
																				<tr>
																					<th>सत्यनिष्ठा</th>
																					<td><?= $record_04['integrity']; ?></td>
																				</tr>
																				<tr>
																					<th>प्रतिवेदक प्राधिकारी कि टिप्पणी</th>
																					<td colspan="5"><?= $record_04['pen_picture']; ?></td>
																				</tr>
																			</tbody>
																		</table>
																	</div>
																</div>
																<div class="col-md-12" style="text-align:right;margin-right:200px;">
																	<h5>Digitally Signed by: <?= $record_0121['employee_name']; ?></h5>
																	<h5>( <?= $record_0122['post_name']; ?> )</h5>
																	<h5>Date: <?= date("d F Y h:i:s A",strtotime($record_04['created_date'])); ?></h5>
																</div>
																
																<div class="col-md-12">
																	<div class="row">
																		<?php
																		$query_011="select * from review_appraisal where employee_appraisal_id='".$employee_appraisal_id."'";
																		$row_011=$db->select($query_011);
																		if($row_011->num_rows > 0){
																			$record_011=$row_011->fetch_array();
																			
																			$review_appraisal_id = $record_011['id'];
																			
																			if($record_011['shreni'] == 'A'){
																				$shreni = 'A - उत्कृष्ट';
																			}else if($record_011['shreni'] == 'B'){
																				$shreni = 'B - अतिउत्तम';
																			}else if($record_011['shreni'] == 'C'){
																				$shreni = 'C - उत्तम';
																			}else if($record_011['shreni'] == 'D'){
																				$shreni = 'D - अच्छा';
																			}else if($record_011['shreni'] == 'E'){
																				$shreni = 'E - ख़राब';
																			}else{
																				$shreni = 'E - ख़राब';
																			}
																			
																			$query_0121="select employee_name,post from employee where employee_code='".$record_011['created_by']."'";
																			$row_0121=$db->select($query_0121);
																			$record_0121=$row_0121->fetch_array();
																			
																			$query_0122="select post_name from post where id='".$record_0121['post']."'";
																			$row_0122=$db->select($query_0122);
																			$record_0122=$row_0122->fetch_array();
																		?>
																			<div class="col-md-12 mb-1"><?= $record_0121['employee_name']; ?>  ( <?= $record_0122['post_name']; ?> )  द्वारा  समीक्षा</div>
																			<div class="col-md-12 mb-1">
																				<div class="table-responsive">
																					<table class="table table-bordered">
																						<thead>
																							<tr>
																								<th style="width:45%">क्या आप प्रतिवेदक प्राधिकारी द्वारा किये गए मूल्यांकन से सहमत हैं ?</th>
																								<td style="width:55%"><?= $record_011['agree_with_assestment']; ?></td>
																							</tr>
																							<tr>
																								<th>मत भिन्नता में सकारण विवरण अंकित किया जाये ।</th>
																								<td><?= $record_011['diffrent_openion']; ?></td>
																							</tr>
																							<tr>
																								<th>समग्र ग्रेड (अंक 1 से 10 तक)</th>
																								<td><?= $record_011['overall_grade']; ?></td>
																							</tr>
																							<tr>
																								<th>श्रेणी </th>
																								<td><?= $shreni; ?></td>
																							</tr>
																						</thead>
																					</table>
																				</div>
																			</div>
																			<div class="col-md-12" style="text-align:right;margin-right:200px;">
																				<h5>Digitally Signed by: <?= $record_0121['employee_name']; ?></h5>
																				<h5>( <?= $record_0122['post_name']; ?> )</h5>
																				<h5>Date: <?= date("d F Y h:i:s A",strtotime($record_011['created_date'])); ?></h5>
																			</div>
																		<?php
																			$query_012="select * from acceptance_appraisal where review_appraisal_id='".$review_appraisal_id."'";
																			$row_012=$db->select($query_012);
																			if($row_012->num_rows > 0){
																				$record_012=$row_012->fetch_array();
																				
																				if($record_012['shreni'] == 'A'){
																					$shreni = 'A - उत्कृष्ट';
																				}else if($record_012['shreni'] == 'B'){
																					$shreni = 'B - अतिउत्तम';
																				}else if($record_012['shreni'] == 'C'){
																					$shreni = 'C - उत्तम';
																				}else if($record_012['shreni'] == 'D'){
																					$shreni = 'D - अच्छा';
																				}else if($record_012['shreni'] == 'E'){
																					$shreni = 'E - ख़राब';
																				}else{
																					$shreni = 'E - ख़राब';
																				}
																				$query_0121="select employee_name,post from employee where employee_code='".$record_012['created_by']."'";
																				$row_0121=$db->select($query_0121);
																				$record_0121=$row_0121->fetch_array();
																				
																				$query_0122="select post_name from post where id='".$record_0121['post']."'";
																				$row_0122=$db->select($query_0122);
																				$record_0122=$row_0122->fetch_array();
																				
																			?>
																				<div class="col-md-12 mb-1" style="font-size:14px;"><?= $record_0121['employee_name']; ?>  ( <?= $record_0122['post_name']; ?> )  द्वारा  स्वीकृति</div>
																				<div class="col-md-12 mb-1">
																					<div class="table-responsive">
																						<table class="table table-bordered">
																							<thead>
																								<tr>
																									<th style="width:45%">क्या आप प्रतिवेदक / समीक्षक प्राधिकारी के मंतव्य से सहमत है?</th>
																									<td style="width:55%"><?= $record_012['agree_with_remark']; ?></td>
																								</tr>
																								<tr>
																									<th>मत भिन्नता में सकारण विवरण अंकित किया जाये ।</th>
																									<td><?= $record_012['diffrent_openion']; ?></td>
																								</tr>
																								<tr>
																									<th style="font-size:16px;">समग्र ग्रेड (अंक 1 से 10 तक)</th>
																									<th style="font-size:16px;"><?= $record_012['overall_grade']; ?></th>
																								</tr>
																								<tr>
																									<th style="font-size:16px;">श्रेणी </th>
																									<th style="font-size:16px;"><?= $shreni; ?></th>
																								</tr>
																							</thead>
																						</table>
																					</div>
																				</div>
																				
																				<div class="col-md-12" style="text-align:right;margin-right:200px;">
																					<h5>Digitally Signed by: <?= $record_0121['employee_name']; ?></h5>
																					<h5>( <?= $record_0122['post_name']; ?> )</h5>
																					<h5>Date: <?= date("d F Y h:i:s A",strtotime($record_012['created_date'])); ?></h5>
																				</div>
																			<?php
																			}else{
																			?>
																				<div class="col-md-12 mb-1" style="font-size:14px;">_______________________________  ( _______________________________ )  द्वारा  स्वीकृति</div>
																				<div class="col-md-12 mb-1">
																					<div class="table-responsive">
																						<table class="table table-bordered">
																							<thead>
																								<tr>
																									<th style="width:45%">क्या आप प्रतिवेदक / समीक्षक प्राधिकारी के मंतव्य से सहमत है?</th>
																									<td style="width:55%"></td>
																								</tr>
																								<tr>
																									<th>मत भिन्नता में सकारण विवरण अंकित किया जाये ।</th>
																									<td></td>
																								</tr>
																								<tr>
																									<th style="font-size:16px;">समग्र ग्रेड (अंक 1 से 10 तक)</th>
																									<th style="font-size:16px;"></th>
																								</tr>
																								<tr>
																									<th style="font-size:16px;">श्रेणी </th>
																									<th style="font-size:16px;"></th>
																								</tr>
																							</thead>
																						</table>
																					</div>
																				</div>
																				
																				<div class="col-md-12" style="text-align:right;margin-right:200px;">
																					<h5>Digitally Signed by: &nbsp;_______________________________&nbsp;&nbsp;</h5>
																					<h5>( _______________________________ )</h5>
																					<h5>Date: &nbsp;_______________________________&nbsp;&nbsp;</h5>
																				</div>
																			<?php
																			}
																			?>
																				<div class="col-md-12 mb-1">
																					<div class="table-responsive">
																						<table class="table table-bordered">
																							<thead>
																								<tr>
																									<th>पदनाम</th>
																									<td><?= $record2['post_name']; ?></td>
																									<th class="nowrap">कर्मचारी कोड </th>
																									<td><?= $record1['employee_code']; ?></td>
																									<th>कर्मचारी का नाम</th>
																									<td><?= $record1['employee_name']; ?></td>
																								</tr>
																								
																								<tr>
																									<th>पिता / पति का नाम </th>
																									<td><?= $record1['father_name']; ?></td>
																									<th>मोबाइल</th>
																									<td><?= $record1['phone']; ?></td>
																									<td colspan="2"></td>
																								</tr>
																								<tr>
																									<th>वर्ष</th>
																									<td><?= $record['year']; ?></td>
																									<th>दिनांक </th>
																									<td><?= date("d M, Y", strtotime($record11['from_date'])); ?></td>
																									<th>से दिनांक </th>
																									<td><?= date("d M, Y", strtotime($record11['to_date'])); ?></td>
																								</tr>
																								
																							</thead>
																						</table>
																					</div>
																				</div>
																			<?php
																		
																		}else{
																			$review_appraisal_id = '';
																		?>
																			<div class="col-md-12 mb-3 text-center"><h1>Review Not Available</h1></div>
																		<?php
																		}
																		?>
																	</div>
																</div>
															<?php
															}else{
																$employee_appraisal_id='';
															?>
																<div class="col-md-12 mb-3 text-center"><h1>Appaisal Not Available</h1></div>
															<?php
															}
															?>
														</div>
													</div>
												</div> <!-- end card -->
											</div> <!-- end col -->
											<div class="col-xl-12 mb-2 text-center">
												<a href="javascript:;"  onclick="printDiv('printableArea')" class="btn btn-primary btn-sm">Print Now</a>
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
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
    </body>
</html>