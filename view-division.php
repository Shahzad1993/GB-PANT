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
        <title>View Collage | GB pant</title>
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
                                    <h4 class="page-title">View Collage</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Collage</a></li>
                                            <li class="breadcrumb-item active">View Collage</li>
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
															<th>Collage</th>
															<th>Phone</th>
															<th>Email</th>
															<th>Location</th>
															<!--th>Password</th-->
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$i=1;
														$query="select * from division";
														$row=$db->select($query);
														while($record=$row->fetch_array()){
															$query1="select * from login where mobile='".$record['phone']."'";
															$row1=$db->select($query1);
															if($row1->num_rows > 0){
																$record1=$row1->fetch_array();
																$core_pass = $record1['core_pass'];
															}else{
																$core_pass = '';
															}
														?>
															<tr>
																<td><?= $i; ?></td>
																<td><?= $record['division']; ?></td>
																<td><?= $record['phone']; ?></td>
																<td><?= $record['email']; ?></td>
																<td><?= $record['location']; ?></td>
																<!--td><?= $core_pass; ?></td-->
																<td>
																	<form method="POST" action="division1" target="_blank">
																		<input type="hidden" name="id" value="<?= base64_encode($record['id']); ?>">
																		<button type="submit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></button>
																	</form>
																	<a href="#" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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