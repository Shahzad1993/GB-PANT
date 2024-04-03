<?php
if(empty($_POST)){
    header("Location: view-self-appraisal-list1");
}

include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}

$id = base64_decode($_POST['id']);

$query11="select * from self_appraisal where id='".$id."'";
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

$query1="select employee_name,employee_code,phone from employee where employee_code='".$record11['employee']."'";
$row1=$db->select($query1);
$record1=$row1->fetch_array();

$query2="select post_name,post_name_en,level from post where id='".$record['present_post']."'";
$row2=$db->select($query2);
$record2=$row2->fetch_array();
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>View ACR Details | UKPN</title>
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
td{
	white-space: nowrap;
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
                                    <h4 class="page-title">View ACR Details</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">ACR</a></li>
                                            <li class="breadcrumb-item active">View ACR Details</li>
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
											<div class="col-xl-12 mb-2">
												<a href="print-acr?id=<?= $id ?>" class="btn btn-primary btn-sm">Print ACR Full Details</a>
											</div>
											<div class="col-xl-12">
												<div class="card">
													<div class="card-body">
														<ul class="nav nav-tabs nav-bordered nav-justified">
															<li class="nav-item">
																<a href="#home-b2" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
																	<span class="d-inline-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
																	<span class="d-none d-sm-inline-block">ए० सी० आर० विवरण</span>
																</a>
															</li>
															<li class="nav-item">
																<a href="#profile-b2" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
																	<span class="d-inline-block d-sm-none"><i class="mdi mdi-account"></i></span>
																	<span class="d-none d-sm-inline-block">स्वः मूल्यांकन</span>
																</a>
															</li>
															<li class="nav-item">
																<a href="#messages-b2" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
																	<span class="d-inline-block d-sm-none"><i class="mdi mdi-email-variant"></i></span>
																	<span class="d-none d-sm-inline-block">मूल्यांकन </span>
																</a>
															</li>
															<li class="nav-item">
																<a href="#settings-b2" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
																	<span class="d-inline-block d-sm-none"><i class="mdi mdi-cog"></i></span>
																	<span class="d-none d-sm-inline-block">समीक्षा</span>
																</a>
															</li>
															<li class="nav-item">
																<a href="#settings-b3" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
																	<span class="d-inline-block d-sm-none"><i class="mdi mdi-cog"></i></span>
																	<span class="d-none d-sm-inline-block">स्वीकृति</span>
																</a>
															</li>
															
														</ul>
														<div class="tab-content">
															<div class="tab-pane active" id="home-b2">
																<div class="row">
																	<div class="col-md-12 mb-3">
																		<div class="responsive-table-plugin">
																			<div class="table-responsive">
																				<table class="table table-bordered">
																					<thead>
																						<tr class="bg-primary text-white">
																							<th colspan="6"><?= $record1['employee_name']; ?> का <?= $record['year']; ?> का एसीआर विवरण :</th>
																						</tr>
																					</thead>
																					<thead>
																						<tr>
																							<th>वर्ष</th>
																							<td><?= $record['year']; ?></td>
																							<th class="nowrap">कर्मचारी कोड </th>
																							<td><?= $record1['employee_code']; ?></td>
																							<th>मोबाइल</th>
																							<td><?= $record1['phone']; ?></td>
																						</tr>
																						<tr>
																							<th>कर्मचारी का नाम</th>
																							<td><?= $record1['employee_name']; ?></td>
																							<th>पदनाम</th>
																							<td><?= $record2['post_name']; ?></td>
																							<td colspan="2"></td>
																						</tr>
																						
																					</thead>
																				</table>
																			</div>
																		</div>
																	</div>
																	
																	<div class="col-md-12 mb-3">
																		<div class="responsive-table-plugin">
																			<div class="table-responsive">
																				<?php
																				$query3="select * from employee where employee_code='".$record['reporting_authority_name']."'";
																				$row3=$db->select($query3);
																				$record3=$row3->fetch_array();
																				
																				$query4="select * from post where id='".$record['reporting_authority_post']."'";
																				$row4=$db->select($query4);
																				$record4=$row4->fetch_array();
																				
																				$query5="select * from employee where employee_code='".$record['reviewing_authority_name']."'";
																				$row5=$db->select($query5);
																				$record5=$row5->fetch_array();
																				
																				$query6="select * from post where id='".$record['reviewing_authority_post']."'";
																				$row6=$db->select($query6);
																				$record6=$row6->fetch_array();
																				
																				$query7="select * from employee where employee_code='".$record['accepting_authority_name']."'";
																				$row7=$db->select($query7);
																				$record7=$row7->fetch_array();
																				
																				$query8="select * from post where id='".$record['accepting_authority_post']."'";
																				$row8=$db->select($query8);
																				$record8=$row8->fetch_array();
																				
																				
																				?>
																				<table class="table table-bordered">
																					<thead>
																						<tr class="bg-primary text-white">
																							<th colspan="6">प्रतिवेदक, समीक्षक एवं स्वीकर्ता प्राधिकारी :</th>
																						</tr>
																						<tr>
																							<th>#</th>
																							<th></th>
																							<th>नाम</th>
																							<th>पदनाम</th>
																						</tr>
																						
																					</thead>
																					<thead>
																						<tr>
																							<th>1</th>
																							<th>प्रतिवेदक प्राधिकारी</th>
																							<td><?= $record3['employee_name']; ?></td>
																							<td><?= $record4['post_name']; ?></td>
																						</tr>
																						<tr>
																							<th>2</th>
																							<th>समीक्षक प्राधिकारी</th>
																							<td><?= $record5['employee_name']; ?></td>
																							<td><?= $record6['post_name']; ?></td>
																						</tr>
																						<tr>
																							<th>3</th>
																							<th>स्वीकर्ता प्राधिकारी</th>
																							<td><?= $record7['employee_name']; ?></td>
																							<td><?= $record8['post_name']; ?></td>
																						</tr>
																						
																					</thead>
																				</table>
																			</div>
																		</div>
																	</div>
																	
																</div>
															</div>
															<div class="tab-pane" id="profile-b2">
																<div class="row">
																	<div class="col-md-12 mb-3">
																			<div class="responsive-table-plugin">
																				<div class="table-responsive">
																					<table class="table table-bordered">
																						<thead>
																							<tr class="bg-primary text-white">
																								<th colspan="6"><?= $record1['employee_name']; ?> का <?= $record11['year']; ?> का स्वमूल्यांकन विवरण</th>
																							</tr>
																						</thead>
																						<thead>
																							<tr>
																								<th>कर्मचारी कोड</th>
																								<td><?= $record1['employee_code']; ?></td>
																								<th>कर्मचारी का नाम</th>
																								<td colspan="3"><?= $record1['employee_name']; ?></td>
																							</tr>
																							<tr>
																								<th>वर्ष </th>
																								<td><?= $record11['year']; ?></td>
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
																	<?php
																	if($record2['post_name_en']=='DRIVER' || $record2['post_name_en']=='CONDUCTOR' || $record2['level']=='10'){
																	?>
																		<div class="col-md-12 mb-3" id="karya_yojna1">
																			<div class="responsive-table-plugin">
																				<div class="table-responsive">
																					<table class="table table-bordered">
																						<thead>
																							<tr class="bg-primary text-white">
																								<th colspan="2">वार्षिक कार्य योजना और उपलब्धि:</th>
																								<th>
																								<?php
																								if($_SESSION['astro_role']=='Admin'){
																								?>
																									<a href="javascript:;" class="btn btn-sm btn-warning" onclick="action_self_appraisal(<?= $id; ?>)"><i class="fa fa-edit"></i> Edit</a></th>
																								<?php
																								}
																								?>
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
																							$query4="select * from annual_work_plan where self_appraisal_id='".$id."'";
																							$row4=$db->select($query4);
																							if ($row4->num_rows > 0) {
																								while($record4=$row4->fetch_array()){
																									$query41="select * from deport_level_annual_work where id='".$record4['task_to_be_performed']."'";
																									$row41=$db->select($query41);
																									if ($row41->num_rows > 0) {
																										$record41=$row41->fetch_array();
																										?>
																										<tr>
																											<th><?= $i; ?></th>
																											<td><?= $record41['work']; ?></td>
																											<td><?= $record4['actual_achievement']; ?></td>
																										</tr>
																										
																										<?php
																										$i++;
																									}
																								}
																							}
																							?>
																						</tbody>
																					</table>
																				</div>
																			</div>
																		</div>
																	<?php	
																	}else{
																		if(file_exists($record11['self_appraisal_copy'])){
																	?>
																		<div class="col-md-12 mb-3">
																			<div class="responsive-table-plugin">
																				<div class="table-responsive">
																					<table class="table table-bordered">
																						<thead>
																							<tr class="bg-primary text-white">
																								<th>स्वः मूल्यांकन प्रति:</th>
																							</tr>
																							<tr>
																								<th><img src="<?= $record11['self_appraisal_copy']; ?>" style="width:100%"></th>
																							</tr>
																						</thead>
																						
																					</table>
																				</div>
																			</div>
																		</div>
																	<?php
																		}
																	?>
																		<div class="col-md-12 mb-3">
																			<div class="responsive-table-plugin">
																				<div class="table-responsive">
																					<table class="table table-bordered">
																						<thead>
																							<tr class="bg-primary text-white">
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
																							$query5="select * from summary_responsibilities_alloted where self_appraisal_id='".$id."'";
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
																		</div>
																		
																		<div class="col-md-12 mb-3" id="karya_yojna1">
																			<div class="responsive-table-plugin">
																				<div class="table-responsive">
																					<table class="table table-bordered">
																						<thead>
																							<tr class="bg-primary text-white">
																								<th colspan="2">वार्षिक कार्य योजना और उपलब्धि:</th>
																								<th>
																								<?php
																								if($_SESSION['astro_role']=='Admin'){
																								?>
																									<a href="javascript:;" class="btn btn-sm btn-warning" onclick="action_self_appraisal1(<?= $id; ?>)"><i class="fa fa-edit"></i> Edit</a>
																								<?php
																								}
																								?>
																								</th>
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
																							$query6="select * from annual_work_plan where self_appraisal_id='".$id."'";
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
																		</div>
																	<?php
																	}
																	?>
																		
																		<div class="col-md-12 mb-3">
																			<div class="responsive-table-plugin">
																				<div class="table-responsive">
																					<table class="table table-bordered">
																						<thead>
																							<tr class="bg-primary text-white">
																								<th>पुरस्कार / सम्मान:</th>
																							</tr>
																							<tr>
																								<th><?= $award; ?></th>
																							</tr>
																						</thead>
																						
																					</table>
																				</div>
																			</div>
																		</div>
																</div>
															</div>
															<div class="tab-pane" id="messages-b2">
																<div class="row">
																	<?php
																	$query_04="select * from employee_appraisal where self_appraisal_id='".$record11['id']."'";
																	$row_04=$db->select($query_04);
																	if($row_04->num_rows > 0){
																		$record_04=$row_04->fetch_array();
																		$employee_appraisal_id = $record_04['id'];
																		$is_updated1 = $record_04['is_updated'];
																		?>
																		<div class="col-md-12 mb-3" id="appraisal_section">
																			<div class="responsive-table-plugin">
																				<div class="table-responsive">
																					<table class="table table-bordered">
																						<thead>
																							<tr class="bg-primary text-white">
																								<th colspan="6"><?= $record1['employee_name']; ?> का <?= $record11['year']; ?> का मूल्यांकन विवरण</th>
																							</tr>
																						</thead>
																						<tbody>
																							<tr>
																								<th>कर्मचारी कोड</th>
																								<td><?= $record1['employee_code']; ?></td>
																								<th>कर्मचारी का नाम</th>
																								<td><?= $record1['employee_name']; ?></td>
																								<th>वर्ष</th>
																								<td><?= $record_04['year']; ?></td>
																							</tr>
																							<tr>
																								<th>समग्र ग्रेड (अंक 1 से 10 तक)</th>
																								<td><?= $record_04['overall_grade']; ?></td>
																								
																								<th>श्रेणी</th>
																								<td><?= $record_04['shreni']; ?></td>
																								<th>सत्यनिष्ठा</th>
																								<td><?= $record_04['integrity']; ?></td>
																							</tr>
																							<tr>
																								<th colspan="2">प्रतिवेदक प्राधिकारी कि टिप्पणी (अधिकतम 100 शब्द) </th>
																								<td colspan="4"><?= $record_04['pen_picture']; ?></td>
																							</tr>
																						</tbody>
																					</table>
																				</div>
																			</div>
																		</div>
																	<?php
																		if($record2['post_name_en']=='DRIVER' || $record2['post_name_en']=='CONDUCTOR' || $record2['level']=='10'){
																		?>
																			<div class="col-md-12" id="karya_yojna2">
																				<div class="table-responsive">
																					<table class="table table-bordered">
																						<thead>
																							<tr class="bg-primary text-white">
																								<th colspan="4">वार्षिक कार्य योजना और उपलब्धि :</th>
																								<th>
																								<?php
																								if($_SESSION['astro_role']=='Admin'){
																									if($record11['is_updated']=='0'){
																									?>
																										<a href="javascript:;" class="btn btn-sm btn-danger" onclick="action_appraisal(<?= $id; ?>)"><i class="fa fa-edit"></i> Need Updation</a>
																									<?php
																									}else{
																									?>
																										<a href="javascript:;" class="btn btn-sm btn-warning" onclick="action_appraisal(<?= $id; ?>)"><i class="fa fa-edit"></i> Edit</a>
																									<?php
																									}
																								}
																								?>
																								</th>
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
																									<td>
																										<?= $work; ?>
																									</td>
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
																				   </table>
																				</div>
																			</div>
																		<?php
																		}else{
																		?>
																			<div class="col-md-12 mb-3" id="karya_yojna3">
																				<div class="responsive-table-plugin">
																					<div class="table-responsive">
																						<table class="table table-bordered">
																							<thead>
																								<tr class="bg-primary text-white">
																									<th colspan="3">वयक्तिगत गुणों का मूल्यांकन :</th>
																									<th>
																									<?php
																									if($_SESSION['astro_role']=='Admin'){
																										if($record11['is_updated']=='0'){
																										?>
																											<a href="javascript:;" class="btn btn-sm btn-danger" onclick="action_appraisal1(<?= $record_04['id']; ?>)"><i class="fa fa-edit"></i> Need Updation</a></th>
																										<?php
																										}else{
																										?>
																											<a href="javascript:;" class="btn btn-sm btn-warning" onclick="action_appraisal1(<?= $record_04['id']; ?>)"><i class="fa fa-edit"></i> Edit</a></th>
																										<?php
																										}
																									}
																									?>
																									</th>
																								</tr>
																								<tr>
																									<th>#</th>
																									<th>वयक्तिगत गुण</th>
																									<th>ग्रेड  (1 - 10) </th>
																									<th>श्रेणी </th>
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
																									$grade = $record_05['grade'];
																									
																									$query42="select * from grading where min_grade <= $grade and max_grade >= $grade";
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
																								
																							</tbody>
																						</table>
																					</div>
																				</div>
																			</div>
																		
																			<div class="col-md-12 mb-3">
																				<div class="responsive-table-plugin">
																					<div class="table-responsive">
																						<table class="table table-bordered">
																							<thead>
																								<tr class="bg-primary text-white">
																									<th colspan="4">किये गए कार्यों का मूल्यांकन :</th>
																								</tr>
																								<tr>
																									<th>#</th>
																									<th></th>
																									<th>ग्रेड  (1 - 10) </th>
																								</tr>
																							</thead>
																							<tbody>
																								<?php
																								$i=1;
																								$query_07="select * from assessment_of_work_output_data where employee_appraisal_id='".$record_04['id']."'";
																								$row_07=$db->select($query_07);
																								while($record_07=$row_07->fetch_array()){
																									$query_08="select * from assessment_of_work_output where id='".$record_07['assessment_of_work_output_id']."'";
																									$row_08=$db->select($query_08);
																									$record_08=$row_08->fetch_array();
																								?>
																								<tr>
																									<th><?= $i; ?></th>
																									<td><?= $record_08['work_output']; ?></td>
																									<td><?= $record_07['grade']; ?></td>
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
																		<?php	
																		}
																	}else{
																		$employee_appraisal_id='';
																		$is_updated1 = 1;
																	?>
																		<div class="col-md-12 mb-3 text-center"><h1>Appaisal Not Available</h1></div>
																	<?php
																	}
																	?>
																</div>
															</div>
															<div class="tab-pane" id="settings-b2">
																<div class="row">
																	<?php
																	$query_011="select * from review_appraisal where employee_appraisal_id='".$employee_appraisal_id."'";
																	$row_011=$db->select($query_011);
																	if($row_011->num_rows > 0){
																		$record_011=$row_011->fetch_array();
																		
																		$review_appraisal_id = $record_011['id'];
																		$is_updated2 = $record_011['is_updated'];
																		
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
																	?>
																	<div class="col-md-12 mb-3" id="review_section">
																		<div class="responsive-table-plugin">
																			<div class="table-responsive">
																				<table class="table table-bordered">
																					<thead>
																						<tr class="bg-primary text-white">
																							<th><?= $record1['employee_name']; ?> की एसीआर समीक्षा विवरण :</th>
																							<th>
																							<?php
																							if($_SESSION['astro_role']=='Admin'){
																								if($is_updated1=='0'){
																								?>
																									<a href="javascript:;" class="btn btn-sm btn-danger" onclick="action_review(<?= $record_011['id']; ?>,<?= $record_011['employee_appraisal_id']; ?>)"><i class="fa fa-edit"></i> Need Updation</a></th>
																								<?php
																								}else{
																								?>
																									<a href="javascript:;" class="btn btn-sm btn-warning" onclick="action_review(<?= $record_011['id']; ?>,<?= $record_011['employee_appraisal_id']; ?>)"><i class="fa fa-edit"></i> Edit</a></th>
																								<?php	
																								}
																							}
																							?>
																							</th>
																						</tr>
																					</thead>
																					<thead>
																						<tr>
																							<th>कर्मचारी कोड</th>
																							<td><?= $record1['employee_code']; ?></td>
																						</tr>
																						<tr>
																							<th>कर्मचारी का नाम</th>
																							<td><?= $record1['employee_name']; ?></td>
																						</tr>
																						<tr>
																							<th>क्या आप प्रतिवेदक प्राधिकारी द्वारा किये गए मूल्यांकन से सहमत हैं ?</th>
																							<td><?= $record_011['agree_with_assestment']; ?></td>
																						</tr>
																						<tr>
																							<th>मत भिन्नता में सकारण विवरण अंकित किया जाये ।</th>
																							<td style="white-space: wrap"><?= $record_011['diffrent_openion']; ?></td>
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
																	</div>
																	<?php
																	}else{
																		$review_appraisal_id = '';
																		$is_updated2 = 1;
																	?>
																		<div class="col-md-12 mb-3 text-center"><h1>Review Not Available</h1></div>
																	<?php
																	}
																	?>
																	
																</div>
															</div>
															<div class="tab-pane" id="settings-b3">
																<div class="row">
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
																	?>
																		<div class="col-md-12 mb-3" id="acceptance_section">
																			<div class="responsive-table-plugin">
																				<div class="table-responsive">
																					<table class="table table-bordered">
																						<thead>
																							<tr class="bg-primary text-white">
																								<th><?= $record1['employee_name']; ?> की एसीआर समीक्षा विवरण:</th>
																								<th>
																								<?php
																								if($_SESSION['astro_role']=='Admin'){
																									if($is_updated2=='0'){
																									?>
																										<a href="javascript:;" class="btn btn-sm btn-danger" onclick="action_accept(<?= $record_012['id']; ?>,<?= $record_012['review_appraisal_id']; ?>)"><i class="fa fa-edit"></i> Need Updation</a></th>
																									<?php
																									}else{
																									?>
																										<a href="javascript:;" class="btn btn-sm btn-warning" onclick="action_accept(<?= $record_012['id']; ?>,<?= $record_012['review_appraisal_id']; ?>)"><i class="fa fa-edit"></i> Edit</a></th>
																									<?php	
																									}
																								}
																								?>
																								</th>
																							</tr>
																						</thead>
																						<thead>
																							<tr>
																								<th>कर्मचारी कोड</th>
																								<td><?= $record1['employee_code']; ?></td>
																							</tr>
																							<tr>
																								<th>कर्मचारी का नाम</th>
																								<td><?= $record1['employee_name']; ?></td>
																							</tr>
																							<tr>
																								<th>क्या आप प्रतिवेदक / समीक्षक प्राधिकारी के मंतव्य से सहमत है?</th>
																								<td><?= $record_012['agree_with_remark']; ?></td>
																							</tr>
																							<tr>
																								<th>मत भिन्नता में सकारण विवरण अंकित किया जाये ।</th>
																								<td style="white-space: wrap"><?= $record_012['diffrent_openion']; ?></td>
																							</tr>
																							<tr>
																								<th>समग्र ग्रेड (अंक 1 से 10 तक)</th>
																								<td><?= $record_012['overall_grade']; ?></td>
																							</tr>
																							<tr>
																								<th>श्रेणी </th>
																								<td><?= $shreni; ?></td>
																							</tr>
																						</thead>
																					</table>
																				</div>
																			</div>
																		</div>
																	<?php
																	}else{
																	?>
																		<div class="col-md-12 mb-3 text-center"><h1>Acceptance Not Available</h1></div>
																	<?php
																	}
																	?>
																</div>
															</div>
															
														</div>
													</div>
												</div> <!-- end card -->
											</div> <!-- end col -->
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
function action_self_appraisal(self_appraisal_id){
	if(self_appraisal_id != ''){
		var action_self_appraisal = 'fetch_self_appraisal_popup_data';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action_self_appraisal:action_self_appraisal, self_appraisal_id:self_appraisal_id},
			success:function(data){
			    $('#self_appraisal_popup_data').html(data);
			    $('#self_appraisal_popup').modal('show');
			}
		})
	}
}
</script>

<script>
function action_self_appraisal1(self_appraisal_id){
	if(self_appraisal_id != ''){
		var action_self_appraisal1 = 'fetch_self_appraisal_popup_data';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action_self_appraisal1:action_self_appraisal1, self_appraisal_id:self_appraisal_id},
			success:function(data){
			    $('#self_appraisal_popup_data').html(data);
			    $('#self_appraisal_popup').modal('show');
			}
		})
	}
}
</script>


		
<div class="modal fade show" id="self_appraisal_popup" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="form_id">
            <div class="modal-content" id="self_appraisal_popup_data">
                
            </div>
        </form>
    </div>
</div>

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
					$('#message').html('<span class="text-success">Self Appraisal Updated Successfully!</span>');
					setTimeout(function() {
					    $('#self_appraisal_popup').modal('hide');
						$('#karya_yojna1').load(' #karya_yojna1');
						$('#appraisal_section').load(' #appraisal_section');
						$('#karya_yojna2').load(' #karya_yojna2');
					}, 1000);
				}else{
					$('#message').html('<span class="text-danger">'+data+'</span>');
				}
				
				$('#button_id').html('Update');
			}
		});
	});
});
</script>


<script>
function action_appraisal1(employee_appraisal_id){
	if(employee_appraisal_id != ''){
		var action_appraisal1 = 'fetch_appraisal_popup_data';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action_appraisal1:action_appraisal1, employee_appraisal_id:employee_appraisal_id},
			success:function(data){
			    $('#appraisal_popup_data').html(data);
			    $('#appraisal_popup').modal('show');
			}
		})
	}
}
</script>  

<script>
function action_appraisal(self_appraisal_id){
	if(self_appraisal_id != ''){
		var action_appraisal = 'fetch_appraisal_popup_data';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action_appraisal:action_appraisal, self_appraisal_id:self_appraisal_id},
			success:function(data){
			    $('#appraisal_popup_data').html(data);
			    $('#appraisal_popup').modal('show');
			}
		})
	}
}
</script>  


		
<div class="modal fade show" id="appraisal_popup" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="form_id1">
            <div class="modal-content" id="appraisal_popup_data">
                
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function(){
	$('#form_id1').on('submit', function(e){
		e.preventDefault();
		$.ajax({
			url:'query',
			type:'POST',
			data:$('#form_id1').serialize(),
			beforeSend:function(){
				$('#button_id1').html('Please Wait...');
			},
			success:function(data){
				if(data=='Success'){
					$('#message1').html('<span class="text-success">Appraisal Updated Successfully!</span>');
					setTimeout(function() {
					    $('#appraisal_popup').modal('hide');
						$('#karya_yojna2').load(' #karya_yojna2');
						$('#karya_yojna3').load(' #karya_yojna3');
						$('#appraisal_section').load(' #appraisal_section');
						$('#review_section').load(' #review_section');
					}, 1000);
				}else{
					$('#message1').html('<span class="text-danger">'+data+'</span>');
				}
				
				$('#button_id1').html('Update');
			}
		});
	});
});
</script>

<script>
function countChar1(val) {
  var len = val.value.length;
  if (len >= 100) {
    val.value = val.value.substring(0, 100);
  } else {
    $('#charNum').text(100 - len);
  }
};
</script>


<script>
function action_review(review_id,employee_appraisal_id){
	if(review_id != ''){
		var action_review = 'fetch_review_popup_data';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action_review:action_review, review_id:review_id,employee_appraisal_id:employee_appraisal_id},
			success:function(data){
			    $('#review_popup_data').html(data);
			    $('#review_popup').modal('show');
			}
		})
	}
}
</script>  

<div class="modal fade show" id="review_popup" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="form_id2">
            <div class="modal-content" id="review_popup_data">
                
            </div>
        </form>
    </div>
</div>


<script>
function action_accept(accept_id,review_id){
	if(accept_id != ''){
		var action_accept = 'fetch_accept_popup_data';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action_accept:action_accept, accept_id:accept_id,review_id:review_id},
			success:function(data){
			    $('#accept_popup_data').html(data);
			    $('#accept_popup').modal('show');
			}
		})
	}
}
</script>  

<div class="modal fade show" id="accept_popup" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="form_id3">
            <div class="modal-content" id="accept_popup_data">
                
            </div>
        </form>
    </div>
</div>


<script>
function action_acr_review(query_acr_review,id){
	var action_acr_review = 'review_section_show_hide';
	$.ajax({
		url:"query.php",
		method:"POST",
		data:{action_acr_review:action_acr_review,query_acr_review:query_acr_review,id:id},
		success:function(data){
			$('#review_section_id').html(data);
		}
	})
}
</script>

<script>
function action_acr_accept(query_acr_accept,id){
	var action_acr_accept = 'accept_section_show_hide';
	$.ajax({
		url:"query.php",
		method:"POST",
		data:{action_acr_accept:action_acr_accept,query_acr_accept:query_acr_accept,id:id},
		success:function(data){
			$('#accept_section_id').html(data);
		}
	})
}
</script>

<script>
function action_count_grade(overall_grade1){
	if(overall_grade1 > 8){
		var shreni = 'A';
		var shreni1 = 'उत्कृष्ट';
	}else if(overall_grade1 <= 8 && overall_grade1 >= 7){
		var shreni = 'B';
		var shreni1 = 'अतिउत्तम';
	}else if(overall_grade1 <= 6 && overall_grade1 >= 5){
		var shreni = 'C';
		var shreni1 = 'उत्तम';
	}else if(overall_grade1 <= 4 && overall_grade1 >= 3){
		var shreni = 'D';
		var shreni1 = 'अच्छा';
	}else if(overall_grade1 < 3){
		var shreni = 'E';
		var shreni1 = 'ख़राब';
	}else{
		var shreni = 'N/A';
		var shreni1 = '';
	}
	$('#shreni').val(shreni);
	$('#shreni1').val(shreni+' - '+shreni1);
}
</script>


<script>
function countChar(val) {
  var len = val.value.length;
  if (len >= 50) {
    //val.value = val.value.substring(0, 100);
	$('#department_button').attr('disabled', false);
  } else {
    $('#charNum').text(50 - len);
	$('#department_button').attr('disabled', true);
  }
};
</script>

<script>
$(document).ready(function(){
	$('#form_id2').on('submit', function(e){
		e.preventDefault();
		$.ajax({
			url:'query',
			type:'POST',
			data:$('#form_id2').serialize(),
			beforeSend:function(){
				$('#department_button').html('Please Wait...');
			},
			success:function(data){
				//alert(data);
				if(data=='Success'){
					$('#message2').html('<span class="text-success">Review Updated Successfully!</span>');
					setTimeout(function() {
					    $('#review_popup').modal('hide');
						$('#review_section').load(' #review_section');
						$('#acceptance_section').load(' #acceptance_section');
					}, 1000);
				}else{
					$('#message2').html('<span class="text-danger">'+data+'</span>');
				}
				
				$('#department_button').html('Update');
			}
		});
	});
});
</script>


<script>
$(document).ready(function(){
	$('#form_id3').on('submit', function(e){
		e.preventDefault();
		$.ajax({
			url:'query',
			type:'POST',
			data:$('#form_id3').serialize(),
			beforeSend:function(){
				$('#department_button').html('Please Wait...');
			},
			success:function(data){
				if(data=='Success'){
					$('#message3').html('<span class="text-success">Acceptance Updated Successfully!</span>');
					setTimeout(function() {
					    $('#accept_popup').modal('hide');
						$('#acceptance_section').load(' #acceptance_section');
					}, 1000);
				}else{
					$('#message3').html('<span class="text-danger">'+data+'</span>');
				}
				
				$('#department_button').html('Update');
			}
		});
	});
});
</script>


    </body>
</html>