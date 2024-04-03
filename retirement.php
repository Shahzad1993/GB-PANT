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
        <title>Retirement | UKPN</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

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
                                    <h4 class="page-title">Retirement</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Retirement</a></li>
                                            <li class="breadcrumb-item active">Retirement</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
										<form id="form_id">	
											<div class="row">
												<!--div class="col-md-4 mb-3">
													<label class="form-label">Employee Code</label>
													<input type="text" name="employee_code" class="form-control" onkeyup="action19(this.value)" placeholder="Employee Code" required>
												</div-->
												
												<div class="col-md-12" id="message"></div>
												<div class="col-md-12">
													<label style="font-size: 18px;">Current Post</label>
												</div>
												<div class="col-md-3 mb-3">
													<label class="form-label">Retirement Date</label>
													<input type="date" name="retirement_date" class="form-control" min="<?= date("Y-m-d"); ?>" required>
												</div>
												<?php
												if($_SESSION['astro_role']=='Head Quarter'){
													$output ='<div class="col-md-3 mb-3" id="employee_data">
														<input type="hidden" name="work_location" id="work_location" value="Head Quarter">
														<label class="form-label">Employee</label>
														<select name="employee" id="employee_name" class="form-control" required>';
															$output .= '<option value="">~~~Choose~~~</option>';
															$query="select * from employee where work_location='Head Quarter' and is_retired='0'";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
																$query1="select * from post where id='".$record['post']."'";
																$row1=$db->select($query1);
																$record1=$row1->fetch_array();
																
																$output .= '<option value="'.$record['employee_code'].'">'.$record['employee_code'].' - '.$record['employee_name'].' &nbsp;&nbsp;&nbsp;&nbsp;( '.$record1['post_name'].' )</option>';
															}
														$output .='</select></div>';
													
													echo $output;
												}else if($_SESSION['astro_role']=='Division'){
													$query11="select * from division where phone='".$_SESSION['astro_email']."'";
													$row11=$db->select($query11);
													$record11=$row11->fetch_array();
													
													$output ='<div class="col-md-3 mb-3" id="employee_data">
														<input type="hidden" name="work_location" id="work_location" value="Division">
														<input type="hidden" name="office_name" id="office_name" value="'.$record11['id'].'">
														<label class="form-label">Employee</label>
															<select name="employee" id="employee_name" class="form-control" required>';
															$output .= '<option value="">~~~Choose~~~</option>';
															$query="select * from employee where work_location='Division' and office_name='".$record11['id']."' and is_retired='0'";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
																$query1="select * from post where id='".$record['post']."'";
																$row1=$db->select($query1);
																$record1=$row1->fetch_array();
																
																$output .= '<option value="'.$record['employee_code'].'">'.$record['employee_code'].' - '.$record['employee_name'].' &nbsp;&nbsp;&nbsp;&nbsp;( '.$record1['post_name'].' )</option>';
															}
															$output .='</select></div>';
														echo $output;
												}elseif($_SESSION['astro_role']=='Deport'){
													$query11="select * from deport where phone='".$_SESSION['astro_email']."'";
													$row11=$db->select($query11);
													$record11=$row11->fetch_array();
													
													$output ='<div class="col-md-3 mb-3" id="employee_data">
														<input type="hidden" name="work_location" id="work_location" value="Deport">
														<input type="hidden" name="office_name" id="office_name" value="'.$record11['id'].'">
														<label class="form-label">Employee</label>
															<select name="employee" id="employee_name" class="form-control" required>';
															$output .= '<option value="">~~~Choose~~~</option>';
															$query="select * from employee where work_location='Deport' and office_name='".$record11['id']."' and is_retired='0'";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
																$query1="select * from post where id='".$record['post']."'";
																$row1=$db->select($query1);
																$record1=$row1->fetch_array();
																
																$output .= '<option value="'.$record['employee_code'].'">'.$record['employee_code'].' - '.$record['employee_name'].' &nbsp;&nbsp;&nbsp;&nbsp;( '.$record1['post_name'].' )</option>';
															}
															$output .='</select></div>';
														echo $output;
												}
												?>
												
												<div class="col-md-12">
													<input type="hidden" name="add_retirement" value="add_retirement">
													<button id="button_id" class="btn btn-primary" type="submit">Submit</button>
												</div>
												
											</div>
										</form>
									</div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                        </div>
                        <!-- end row -->
					</div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <?php include "inc/footer.php"; ?>
                <!-- end Footer -->

            </div>
		</div>
        <!-- END wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
		<script src="assets/js/vendor.min.js"></script>
		<script src="assets/libs/parsleyjs/parsley.min.js"></script>
		<script src="assets/js/pages/form-validation.init.js"></script>
		<script src="assets/js/app.min.js"></script>

<script>
	$(document).ready(function(){
		$('#form_id').on('submit', function(e){
			e.preventDefault();
			
			$.ajax({
				url:'query',
				type:'POST',
				data:$('#form_id').serialize(),
				beforeSend:function(){
					$('#button_id').html('Please Wait...');
				},
				success:function(data){
					if(data=='Success'){
						$('#message').html('<div class="alert alert-success alert-dismissable"><span><i class="fa fa-check"></i> Employee Retired Successfully!</span></div>');
						$('#form_id')[0].reset();
						$('#button_id').html('Submit');
					}else{
						$('#message').html('<div class="alert alert-danger alert-dismissable"><span><i class="fa fa-times"></i> '+data+'</span>');
						$('#button_id').html('Submit');
					}
					setTimeout(function() {
						$('.alert').hide('slow');
						location.reload();
					}, 2000);
				}
			});
			
		});
	});
</script>
      
    </body>
</html>