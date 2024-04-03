<?php
include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}

$query="select * from acr where id='".$_REQUEST['id']."'";
$row=$db->select($query);
$record=$row->fetch_array();

$query10="select * from self_appraisal where acr_id='".$record['id']."'";
$row10=$db->select($query10);
$record10=$row10->fetch_array();


$query1="select employee_name,employee_code,phone from employee where employee_code='".$record10['employee']."'";
$row1=$db->select($query1);
$record1=$row1->fetch_array();

$query2="select post_name from post where id='".$record['present_post']."'";
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
																	<th>मोबाइल </th>
																	<td><?= $record1['phone']; ?></td>
																</tr>
																<tr>
																	<th colspan="3">कर्मचारी का नाम </th>
																	<td><?= $record1['employee_name']; ?></td>
																	<th>पदनाम </th>
																	<td><?= $record2['post_name']; ?></td>
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
																	<th>पदनाम</th>
																	<th>नाम </th>
																	<th>समयावधि</th>
																</tr>
																
															</thead>
															<thead>
																<tr>
																	<th>1</th>
																	<th>प्रतिवेदक प्राधिकारी</th>
																	<td><?= $record3['employee_name']; ?></td>
																	<td><?= $record4['post_name']; ?></td>
																	<td><?= $record['reporting_authority_period']; ?></td>
																</tr>
																<tr>
																	<th>2</th>
																	<th>समीक्षक प्राधिकारी</th>
																	<td><?= $record5['employee_name']; ?></td>
																	<td><?= $record6['post_name']; ?></td>
																	<td><?= $record['reviewing_authority_period']; ?></td>
																</tr>
																<tr>
																	<th>3</th>
																	<th>स्वीकर्ता प्राधिकारी</th>
																	<td><?= $record7['employee_name']; ?></td>
																	<td><?= $record8['post_name']; ?></td>
																	<td><?= $record['accepting_authority_period']; ?></td>
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