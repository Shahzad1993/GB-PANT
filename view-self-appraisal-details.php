<?php
include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}

$query="select * from self_appraisal where id='".$_REQUEST['id']."'";
$row=$db->select($query);
$record=$row->fetch_array();

$query1="select employee_name,employee_code,post,father_name,work_location,phone from employee where employee_code='".$record['employee']."'";
$row1=$db->select($query1);
$record1=$row1->fetch_array();

$query3="select post_name_en,post_name,level from post where id='".$record1['post']."'";
$row3=$db->select($query3);
$record3=$row3->fetch_array();

if(file_exists($record['award'])){
	$award = '<img src="'.$record['award'].'" style="width:50%">';
}else{
	$award = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>View Self Appraisal Details | UKPN</title>
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
      
            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">View Self Appraisal Details</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Self Appraisal</a></li>
                                            <li class="breadcrumb-item active">View Self Appraisal Details</li>
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
											<div class="col-md-12 mb-3">
												<div class="responsive-table-plugin">
													<div class="table-responsive">
														<table class="table table-bordered">
															<thead>
																<tr class="bg-primary text-white">
																	<th colspan="5"><?= $record1['employee_name']; ?> का <?= $record['year']; ?> का स्वमूल्यांकन विवरण :</th>
																	<th>
																	<?php
																	if($_SESSION['astro_role']!='Admin'){
																		$query2="select * from employee_appraisal where self_appraisal_id='".$_REQUEST['id']."'";
																		$row2=$db->select($query2);
																		if($row2->num_rows > 0){
																			$record2=$row2->fetch_array();
																		?>
																			<a href="view-appraisal-details?id=<?= $record2['id']; ?>" class="btn btn-warning btn-sm">View Appraisal</a>
																		<?php
																		}else{
																			if($record1['employee_code']==$_SESSION['astro_email']){
																			?>
																				<a href="view-self-appraisal-list" class="btn btn-warning btn-sm">Back</a>
																			<?php	
																			}else{
																			?>
																				<a href="appraisal?id=<?= $_REQUEST['id']; ?>" class="btn btn-warning btn-sm">Create Appraisal</a>
																			<?php
																			}
																		}
																	}else{
																	?>
																		<a href="view-self-appraisal-list" class="btn btn-warning btn-sm">Back</a>
																	<?php	
																	}
																	?>
																	</th>
																</tr>
															</thead>
															<thead>
																<tr>
																	<th>कर्मचारी कोड</th>
																	<td><?= $record1['employee_code']; ?></td>
																	<th>कर्मचारी नाम</th>
																	<td><?= $record1['employee_name']; ?></td>
																	<th>पिता का  नाम</th>
																	<td><?= $record1['father_name']; ?></td>
																</tr>
																<tr>
																	<th>कार्य स्थल </th>
																	<td><?= $record1['work_location']; ?></td>
																	<th>पदनाम </th>
																	<td><?= $record3['post_name']; ?></td>
																	<th>मोबाइल </th>
																	<td><?= $record1['phone']; ?></td>
																</tr>
																<tr>
																	<th>वर्ष</th>
																	<td><?= $record['year']; ?></td>
																	<th>दिनांक</th>
																	<td><?= date("d M, Y", strtotime($record['from_date'])); ?></td>
																	<th>से दिनांक</th>
																	<td><?= date("d M, Y", strtotime($record['to_date'])); ?></td>
																</tr>
															</thead>
														</table>
													</div>
													

												</div>
											</div>
											<?php
											if($record3['post_name_en']=='DRIVER' || $record3['post_name_en']=='CONDUCTOR' || $record3['level']=='10'){
											?>
												<div class="col-md-12 mb-3">
													<div class="responsive-table-plugin">
														<div class="table-responsive">
															<table class="table table-bordered">
																<thead>
																	<tr class="bg-primary text-white">
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
																	$query4="select * from annual_work_plan where self_appraisal_id='".$_REQUEST['id']."'";
																	$row4=$db->select($query4);
																	while($record4=$row4->fetch_array()){
																		if($record4['task_to_be_performed']!='Behaviour'){
																			$query41="select * from deport_level_annual_work where id='".$record4['task_to_be_performed']."'";
																			$row41=$db->select($query41);
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
																	?>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											<?php	
											}else{
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
												</div>
												
												<div class="col-md-12 mb-3">
													<div class="responsive-table-plugin">
														<div class="table-responsive">
															<table class="table table-bordered">
																<thead>
																	<tr class="bg-primary text-white">
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
												</div>
												
												<?php
												if($record['description']!='' && $record['description']!=NULL){
												?>
													<div class="col-md-12 mb-3">
														<div class="responsive-table-plugin">
															<div class="table-responsive">
																<table class="table table-bordered">
																	<thead>
																		<tr class="bg-primary text-white">
																			<th>अवधि के दौरान प्राप्त उपलब्धियां / कार्यों का संक्षिप्त विवरण:</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																			<td><?= $record['description']; ?></td>
																		</tr>
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
																		<th>स्वः मूल्यांकन प्रति:</th>
																	</tr>
																	<tr>
																		<th><img src="<?= $record['self_appraisal_copy']; ?>" style="width:50%"></th>
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
        
    </body>
</html>