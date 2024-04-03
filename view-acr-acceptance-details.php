<?php
include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}

$query="select * from acceptance_appraisal where id='".$_REQUEST['id']."'";
$row=$db->select($query);
$record=$row->fetch_array();

$query1="select employee_name,employee_code from employee where employee_code='".$record['employee']."'";
$row1=$db->select($query1);
$record1=$row1->fetch_array();

if($record['shreni'] == 'A'){
	$shreni = 'A - उत्कृष्ट';
}else if($record['shreni'] == 'B'){
	$shreni = 'B - अतिउत्तम';
}else if($record['shreni'] == 'C'){
	$shreni = 'C - उत्तम';
}else if($record['shreni'] == 'B'){
	$shreni = 'D - अच्छा';
}else if($record['shreni'] == 'C'){
	$shreni = 'E - ख़राब';
}else{
	$shreni = 'N/A';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>View ACR Acceptance Details | UKPN</title>
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
                                    <h4 class="page-title">View ACR Acceptance Details</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">ACR Acceptance</a></li>
                                            <li class="breadcrumb-item active">View ACR Acceptance Details</li>
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
																	<th colspan="6"><?= $record1['employee_name']; ?> की एसीआर स्वीकृति विवरण :</th>
																	<!--th>
																	<?php
																	if($_SESSION['astro_role']=='Admin'){
																	?>
																		<a href="appraisal.php?id=<?= $_REQUEST['id']; ?>" class="btn btn-warning btn-sm">Appraisal</a>
																	<?php
																	}
																	?>
																	</th-->
																</tr>
															</thead>
															<thead>
																<tr>
																	<th>कर्मचारी कोड </th>
																	<td><?= $record1['employee_code']; ?></td>
																</tr>
																<tr>
																	<th>कर्मचारी का नाम </th>
																	<td><?= $record1['employee_name']; ?></td>
																</tr>
																<tr>
																	<th>क्या आप प्रतिवेदक / समीक्षक प्राधिकारी के मंतव्य से सहमत है?</th>
																	<td><?= $record['agree_with_remark']; ?></td>
																</tr>
																<tr>
																	<th>मत भिन्नता में सकारण विवरण अंकित किया जाये ।</th>
																	<td><?= $record['diffrent_openion']; ?></td>
																</tr>
																<tr>
																	<th>स्वीकर्ता प्राधिकारी द्वारा अतिरिक्त टिप्पणी (ऐच्छिक)</th>
																	<td><?= $record['additional_comment']; ?></td>
																</tr>
																<tr>
																	<th>समग्र ग्रेड (अंक 1 से 10 तक)</th>
																	<td><?= $record['overall_grade']; ?></td>
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