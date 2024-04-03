<?php
if(empty($_POST)){
    header("Location: view-employee");
}

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
        <title>View Employee Details | GB Pant</title>
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
th{
	font-size: 15px;
	font-weight: 600 !important;
}
td{
	font-size: 14px;
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
            
            <div class="content-page">
                <div class="content">
					<div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">View Employee Details</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="view-employee" class="text-white btn btn-danger btn-sm"><i class="fa fa-angle-double-left"></i> Back</a></li>
                                            <!--li class="breadcrumb-item active">View Employee Details</li-->
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
												<table class="table table-sm mb-0">
													<tbody>
														<?php
														$query="select * from employee where employee_code='".base64_decode($_POST['id'])."'";
														$row=$db->select($query);
														$record=$row->fetch_array();

														$query1="select * from post where id='".$record['post']."'";
														$row1=$db->select($query1);
														$record1=$row1->fetch_array();

														$query2="select * from department where id='".$record['department']."'";
														$row2=$db->select($query2);
														$record2=$row2->fetch_array();

														$query3="select * from emp_category where id='".$record['employee_category']."'";
														$row3=$db->select($query3);
														$record3=$row3->fetch_array();

														if($record['work_location']=='Head Quarter'){
															$query6="select * from head_quarter";
															$row6=$db->select($query6);
															$record6=$row6->fetch_array();
															
															$office_name = $record6['hq'];
														}else if($record['work_location']=='Division'){
															$query6="select * from division where id='".$record['office_name']."'";
															$row6=$db->select($query6);
															$record6=$row6->fetch_array();
															
															$office_name = $record6['division'];
														}else if($record['work_location']=='Depot'){
															$query7="select * from deport where id='".$record['office_name']."'";
															$row7=$db->select($query7);
															$record7=$row7->fetch_array();
															
															$office_name = $record7['deport'];
														}
														$query8="select * from cast where id='".$record['cast']."'";
														$row8=$db->select($query8);
														if($row8->num_rows > 0){
															$record8=$row8->fetch_array();
															$cast = $record8['cast'];
														}else{
															$cast = '';
														}
														?>
														<tr>
															<th>Employee Code</th>
															<td><?= $record['employee_code']; ?></td>
															<th>Employee Name</th>
															<td><?= $record['employee_name']; ?></td>
														</tr>
														<tr>
															<th><?= $record['work_location']; ?></th>
															<td><?= $office_name; ?></td>
															<th>Post Name</th>
															<td><?= $record1['post_name_en']; ?></td>
														</tr>
														<tr>
															<th>Department</th>
															<td><?= $record['department']; ?></td>
															<th>Employee Category</th>
															<td><?= $record3['category']; ?></td>
														</tr>
														<!--tr>
															<th>Reporting Manager</th>
															<td><?= $record5['post_name']; ?></td>
															<th>Reporting Manager Name</th>
															<td><?= $record4['employee_name']; ?></td>
														</tr-->
														<tr>
															<th>Father Name</th>
															<td><?= $record['father_name']; ?></td>
															<th>Mother Name</th>
															<td><?= $record['mother_name']; ?></td>
														</tr>
														<tr>
															<th>Phone</th>
															<td><?= $record['phone']; ?></td>
															<th>Email</th>
															<td></td>
														</tr>
														<tr>
															<th>Gender</th>
															<td><?= $record['gender']; ?></td>
															<th>DOB</th>
															<td><?= date("d M, Y",strtotime($record['dob'])); ?></td>
														</tr>
														<tr>
															<th>Address</th>
															<td><?= $record['address']; ?></td>
															<th>State</th>
															<td><?= $record['state']; ?></td>
														</tr>
														<tr>
															<th>District</th>
															<td><?= $record['district']; ?></td>
															<th>City</th>
															<td><?= $record['city']; ?></td>
														</tr>
														<tr>
															<th>Cast</th>
															<td><?= $cast; ?></td>
															<th>Date of Joining</th>
															<td><?= date("d M, Y",strtotime($record['doj'])); ?></td>
														</tr>
														<tr>
															<th>Nominee</th>
															<td><?= $record['nominee']; ?></td>
															<th>Nominee Relation</th>
															<td><?= $record['nominee_relation']; ?></td>
														</tr>
														<tr>
															<th>No of Dependent</th>
															<td><?= $record['no_of_dependent']; ?></td>
															<th colspan="2"></td>
														</tr>
														<tr>
															<th>Grade Pay</th>
															<td>&#8377; <?= $record['grade_pay']; ?></td>
															<th>Basic Salary</th>
															<td>&#8377; <?= $record['basic_salary']; ?></td>
														</tr>
														<tr>
															<th>EPF No</th>
															<td><?= $record['epf_no']; ?></td>
															<th>ESI No</th>
															<td><?= $record['esi_no']; ?></td>
														</tr>
														<tr>
															<th>PAN No</th>
															<td><?= $record['pan_no']; ?></td>
															<th>Aadhaar No</th>
															<td><?= $record['aadhaar_no']; ?></td>
														</tr>
														<tr>
															<th>Bank Name</th>
															<td><?= $record['bank_name']; ?></td>
															<th>IFSC Code</th>
															<td><?= $record['ifsc_code']; ?></td>
														</tr>
														<tr>
															<th>Account No</th>
															<td><?= $record['account_no']; ?></td>
															<th colspan="2"></td>
														</tr>
														
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