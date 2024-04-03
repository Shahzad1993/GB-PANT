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
        <title>View Self Appraisal | UKPN</title>
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
                                    <h4 class="page-title">View Self Appraisal</h4>
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
														<tr>
															<th>#</th>
															<th>Year</th>
															<th>From Date</th>
															<th>To Date</th>
															<th>Self Appraisal Copy</th>
															<th>Award</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$i=1;
														$query="select * from self_appraisal where employee='".$_SESSION['astro_email']."'";
														$row=$db->select($query);
														while($record=$row->fetch_array()){
														?>
															<tr>
																<td><?= $i; ?></td>
																<td><?= $record['year']; ?></td>
																<td><?= date("d M, Y", strtotime($record['from_date'])); ?></td>
																<td><?= date("d M, Y", strtotime($record['to_date'])); ?></td>
																<td>
																	<a href="<?= $record['self_appraisal_copy']; ?>" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-eye"></i></a>
																</td>
																<td>
																	<a href="<?= $record['award']; ?>" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-eye"></i></a>
																</td>
																<td>
																	<a href="view-self-appraisal-details.php?id=<?= $record['id']; ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
																</td>
															</tr>
														<?php
														$i++;
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