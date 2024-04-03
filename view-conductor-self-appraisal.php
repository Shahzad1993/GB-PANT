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
        <title>View Conductor Self Appraisal | UKPN</title>
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
                                    <h4 class="page-title">View Driver/Conductor Self Appraisal</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Self Appraisal</a></li>
                                            <li class="breadcrumb-item active">View Self Appraisal</li>
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
													<thead>
														<tr class="text-nowrap bg-primary text-white">
															<th>#</th>
															<th>Employee Code</th>
															<th>Employee Name</th>
															<th>Post</th>
															<th>Work Location</th>
															<th>Office Name</th>
															<th>Year</th>
															<th>From Date</th>
															<th>To Date</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$i=1;
														if($_SESSION['astro_role']=='Admin'){
															$query3="select id,present_post from acr";
														}else{
															$query3="select id,present_post from acr where reporting_authority_name='".$_SESSION['astro_email']."'";
														}
														$row3=$db->select($query3);
														if($row3->num_rows > 0){
															while($record3=$row3->fetch_array()){
																$query_1="SELECT id,post_name FROM `post` WHERE id = '".$record3['present_post']."' and post_name_en='CONDUCTOR'";
																$row_1=$db->select($query_1);
																if($row_1->num_rows > 0){
																	$record_1=$row_1->fetch_array();
																
																	$query="select id,employee,year,from_date,to_date from self_appraisal where acr_id='".$record3['id']."'";
																	$row=$db->select($query);
																	if($row->num_rows > 0){
																		while($record=$row->fetch_array()){
																			$query1="select * from employee where employee_code='".$record['employee']."'";
																			$row1=$db->select($query1);
																			$record1=$row1->fetch_array();
																			
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
																				<td><?= $record1['employee_code']; ?></td>
																				<td><?= $record1['employee_name']; ?></td>
																				<td><?= $record_1['post_name']; ?></td>
																				<td><?= $record1['work_location']; ?></td>
																				<td><?= $office_name; ?></td>
																				<td><?= $record['year']; ?></td>
																				<td><?= date("d M, Y", strtotime($record['from_date'])); ?></td>
																				<td><?= date("d M, Y", strtotime($record['to_date'])); ?></td>
																				<td>
																					<a href="view-self-appraisal-details.php?id=<?= $record['id']; ?>" class="btn btn-info btn-sm text-nowrap">View Self Appraisal Details</a>
																				</td>
																			</tr>
																		<?php
																		$i++;
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