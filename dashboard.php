<?php
include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}

$sql = "SELECT count(id) as employee_count FROM `employee` where id!='1'";
$exe = $db->select($sql);
$record = $exe->fetch_array();

$sql1 = "SELECT count(id) as division_count FROM `division`";
$exe1 = $db->select($sql1);
$record1 = $exe1->fetch_array();

$sql2 = "SELECT count(id) as deport_count FROM `deport`";
$exe2 = $db->select($sql2);
$record2 = $exe2->fetch_array();

$sql3 = "SELECT count(id) as department_count FROM `department`";
$exe3 = $db->select($sql3);
$record3 = $exe3->fetch_array();
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Dashboard | GB Pant</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- plugin css -->
        <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />

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
           
            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Welcome !</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">GB PANT</a></li>
                                            <li class="breadcrumb-item active">Dashboards</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-xl-4 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="knob-chart" dir="ltr">
                                                <input data-plugin="knob" data-width="70" data-height="70" data-fgColor="#1abc9c"
                                                    data-bgColor="#d1f2eb" value="<?= $record['employee_count']; ?>"
                                                    data-skin="tron" data-angleOffset="0" data-readOnly=true
                                                    data-thickness=".15"/>
                                            </div>
                                            <div class="text-end">
                                                <h3 class="mb-1 mt-0"> <span data-plugin="counterup"><?= $record['employee_count']; ?></span> </h3>
                                                <p class="text-muted mb-0">No of Employee</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col-xl-4 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="knob-chart" dir="ltr">
                                                <input data-plugin="knob" data-width="70" data-height="70" data-fgColor="#3bafda"
                                                    data-bgColor="#d8eff8" value="<?= $record1['division_count']; ?>"
                                                    data-skin="tron" data-angleOffset="0" data-readOnly=true
                                                    data-thickness=".15"/>
                                            </div>
                                            <div class="text-end">
                                                <h3 class="mb-1 mt-0"> <span data-plugin="counterup"><?= $record1['division_count']; ?></span> </h3>
                                                <p class="text-muted mb-0">No of College</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col-xl-4 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="knob-chart" dir="ltr">
                                                <input data-plugin="knob" data-width="70" data-height="70" data-fgColor="#6c757d"
                                                    data-bgColor="#e2e3e5" value="<?= $record3['department_count']; ?>"
                                                    data-skin="tron" data-angleOffset="0" data-readOnly=true
                                                    data-thickness=".15"/>
                                            </div>
                                            <div class="text-end">
                                                <h3 class="mb-1 mt-0"> <span data-plugin="counterup"><?= $record3['department_count']; ?></span> </h3>
                                                <p class="text-muted mb-1">No of Department</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
							
							
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

        <!-- KNOB JS -->
        <script src="assets/libs/jquery-knob/jquery.knob.min.js"></script>
        <!-- Apex js-->
        <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- Plugins js-->
        <script src="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>

        <!-- Dashboard init-->
        <script src="assets/js/pages/dashboard-sales.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        
    </body>
</html>