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
	<title>LIC Report | GB Pant</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
	<meta content="Coderthemes" name="author" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!-- App favicon -->
	<link rel="shortcut icon" href="assets/images/favicon.ico">

	<!-- Responsive Table css -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-stylesheet" />
	<link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />

	<!-- icons -->
	<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<style>
th{
	font-size: 14px;
}
td{
	font-size: 13px;
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
                                    <h4 class="page-title">LIC Report</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                                            <li class="breadcrumb-item active">LIC Report</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        
										<div class="row pt-2">
											<div class="col-lg-12" id="message"></div>
											<div class="col-lg-12">
												<div class="table-responsive">
													<table class="table table-sm mb-0">
														<thead class="table-active">
															<tr>
																<th>#</th>
																<th>Employee Code</th>
																<th>Employee Name</th>
																<th>LIC Number</th>
																<th>LIC Premium</th>
															</tr>
														</thead>
														<tbody>
															<?php
															$i=1;
															$total_lic_premium = 0;
															$query="select * from employee where id!='1'";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
																$a=1;
																$query1="select * from lic_data where employee_code='".$record['employee_code']."'";
																$row1=$db->select($query1);
																while($record1=$row1->fetch_array()){
																	if($record1['lic_premium']==''){
																		$lic_premium = 0;
																	}else{
																		if(is_string($record1['lic_premium'])==1){
																			$lic_premium = 0;
																		}else{
																			$lic_premium = $record1['lic_premium'];
																		}
																	}
																	if($a==1){
																	?>
																		<tr>
																			<td><?= $i; ?></td>
																			<td><?= $record['employee_code']; ?></td>
																			<td><?= $record['employee_name']; ?></td>
																			<td><?= $record1['lic_number']; ?></td>
																			<td>&#8377; <?= $lic_premium; ?></td>
																		</tr>
																	<?php	
																	$i++;
																	}else{
																	?>
																		<tr>
																			<td></td>
																			<td></td>
																			<td></td>
																			<td><?= $record1['lic_number']; ?></td>
																			<td>&#8377; <?= $lic_premium; ?></td>
																		</tr>
																	<?php
																	}
																	
																	
																	
																	$total_lic_premium = $total_lic_premium + $lic_premium;
																	
																	$a++;
																}
															
															}
															?>
															<tr>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td>&#8377; <?= $lic_premium; ?></td>
															</tr>
															<tr>
																<td colspan="6" class="text-center"><button type="button" class="btn btn-primary btn-sm" onclick="window.print()"><i class="fa fa-printer"></i> Print Now</button></td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										   
										</div>
										
                                    </div>
                                </div>
                            </div>
                        </div>
                        
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