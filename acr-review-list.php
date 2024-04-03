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
        <title>View ACR Review List | UKPN</title>
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
	white-space : nowrap;
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
                                    <h4 class="page-title">Acceptance on Basis of ACR Review</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">ACR Acceptance</a></li>
                                            <li class="breadcrumb-item active">ACR Review List</li>
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
                                        <div class="responsive-table-plugin">
                                            <div class="table-responsive">
												<table class="table table-striped">
													<thead class="bg-primary text-white">
														<tr>
															<th>#</th>
															<th>Action</th>
															<th>Employee Code</th>
															<th>Employee</th>
															<th>Work Location</th>
															<th>Office Name</th>
															<th>POST</th>
															<th>Mobile</th>
															<th>Overall Grade</th>
															<th>agree with assestment</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$i=1;
														
														if($_SESSION['astro_role']=='Admin'){
															$query3="select * from acr";
														}else{
															$query3="select * from acr where accepting_authority_name='".$_SESSION['astro_email']."'";
														}
														$row3=$db->select($query3);
														if($row3->num_rows > 0){
															while($record3=$row3->fetch_array()){
																$query0="select * from self_appraisal where acr_id='".$record3['id']."'";
																$row0=$db->select($query0);
																if($row0->num_rows > 0){
																	while($record0=$row0->fetch_array()){
																		$query1_1="select * from employee_appraisal where self_appraisal_id='".$record0['id']."' and employee='".$record0['employee']."'";$row1_1=$db->select($query1_1);
																		if($row1_1->num_rows > 0){
																			$record1_1=$row1_1->fetch_array();
																			
																			$query="select * from review_appraisal where employee_appraisal_id='".$record1_1['id']."' and employee='".$record0['employee']."'";
																			$row=$db->select($query);
																			if($row->num_rows > 0){
																				$record=$row->fetch_array();
																				
																				$query1="select phone,id,post,employee_code,employee_name,dob,work_location,office_name from employee where employee_code='".$record0['employee']."' and work_location='".$record3['work_location']."' and office_name='".$record3['office_name']."'";
																				$row1=$db->select($query1);
																				if($row1->num_rows > 0){
																					$record1=$row1->fetch_array();
																					
																					$query11="select * from post where id='".$record1['post']."'";
																					$row11=$db->select($query11);
																					$record11=$row11->fetch_array();
																					
																					if($record1['work_location']=='Depot'){
        																			    $query31="select deport from deport where id='".$record1['office_name']."'";
        																				$row31=$db->select($query31);
        																				$record31=$row31->fetch_array();
        																				
        																				$office_name = $record31['deport'];
        																			}else if($record1['work_location']=='Division'){
        																			    $query31="select division from division where id='".$record1['office_name']."'";
        																				$row31=$db->select($query31);
        																				$record31=$row31->fetch_array();
        																				
        																				$office_name = $record31['division'];
        																			}else{
        																			    $office_name = '';
        																			}
																				?>
																					<tr>
																						<td><?= $i; ?></td>
																						<td style="white-space:nowrap;">
																							
																							<?php
																							$query2="select * from acceptance_appraisal where review_appraisal_id='".$record['id']."' and  employee='".$record['employee']."'";
																							$row2=$db->select($query2);
																							if($row2->num_rows > 0){
																								$record2=$row2->fetch_array();
																							?>
																								<a href="view-acr-details?id=<?= $record0['id']; ?>" class="btn btn-warning btn-sm">Acceptance Completed</a>
																							<?php
																							}else{
																							?>
																								<!--a href="acr-acceptance?id=<?= $record3['id']; ?>&review-appraisal-id=<?= $record['id']; ?>" class="btn btn-success btn-sm">Create Acceptance</a-->
																								<a href="view-acr-review-details?id=<?= $record['id']; ?>" class="btn btn-primary btn-sm">View Review</a>
																							<?php
																							}
																							?>
																							
																						</td>
																						<td><?= $record1['employee_code']; ?></td>
																						<td><?= $record1['employee_name']; ?></td>
																						<td><?= $record1['work_location']; ?></td>
																						<td><?= $office_name; ?></td>
																						<td><?= $record11['post_name']; ?></td>
																						<td><?= $record1['phone']; ?></td>
																						<td><?= $record['overall_grade']; ?></td>
																						<td><?= $record['agree_with_assestment']; ?></td>
																					</tr>
																				<?php
																				$i++;
																				}
																				
																			}
																		}
																	}
																}
															}
														}
														?>
													
													</tbody>
												</table>
											</div>
                                        </div> <!-- end .responsive-table-plugin-->
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