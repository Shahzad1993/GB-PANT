<?php
include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}
$query_1="select * from employee where employee_code='".$_REQUEST['id']."'";
$row_1=$db->select($query_1);
$record_1=$row_1->fetch_array();

$query_2="select post_name_en,level from post where id='".$record_1['post']."'";
$row_2=$db->select($query_2);
$record_2=$row_2->fetch_array();

//$query_3="select id from acr where present_post='".$record_1['post']."' and reporting_authority_work_location='".$record_1['work_location']."' and reporting_office_name='".$record_1['office_name']."'";
$query_3="select id from acr where present_post='".$record_1['post']."' and work_location='".$record_1['work_location']."' and office_name='".$record_1['office_name']."'";
$row_3=$db->select($query_3);
$record_3=$row_3->fetch_array();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Driver/Conductor Self Appraisal | UKPN</title>
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

<style>
.form-label{
	font-size: 16px;
	font-weight: bold;
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

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title"><?= $record_2['post_name_en']; ?> Self Appraisal of <?= $record_1['employee_name']; ?></h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Driver/Conductor Self Appraisal</a></li>
                                            <li class="breadcrumb-item active">New Driver/Conductor  Self Appraisal</li>
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
										<h4 id="message"></h4>
                                        <form id="department_form" class="needs-validation">
											<div class="row mb-3">
												
												<div class="col-md-3 mb-3">
													<label class="form-label">वर्ष</label>
													<select name="year" class="form-control" onchange="action_acr_date_range(this.value)" required>
														<option value="">~~~चुनें ~~~</option>
														<?php
														$query="select year from acr where present_post='".$record_1['post']."' and work_location='".$record_1['work_location']."' and office_name='".$record_1['office_name']."'";
														$row=$db->select($query);
														while($record=$row->fetch_array()){
															$query1="select * from self_appraisal where employee='".$record_1['employee_code']."' and year='".$record['year']."'";
															$row1=$db->select($query1);
															if($row1->num_rows > 0){
																
															}else{
														?>
															<option value="<?= $record['year']; ?>"><?= $record['year']; ?></option>
														<?php
															}
														}
														?>
													</select>
												</div>
												<div class="col-md-6 mb-3">
													<div class="row" id="acr_date_range_data">
														<div class="col-md-6">
															<label class="form-label">दिनांक</label>
															<input type="date" name="from_date"class="form-control" required>
														</div>
														<div class="col-md-6">
															<label class="form-label">से दिनांक</label>
															<input type="date" name="to_date" class="form-control" required>
														</div>
													</div>
												</div>
												
												<div class="col-md-3 mb-3">
													<label class="form-label">मार्ग</label>
													<select type="text" name="marg" class="form-control" required>
														<option value="">---</option>
														<option value="1">मैदानी मार्ग </option>
														<option value="2">पर्वतीय मार्ग </option>
														<option value="3">मिश्रित मार्ग </option>
													</select>
												</div>
												<div class="col-md-12">
													<hr>
													<label class="form-label">वार्षिक कार्य योजना और उपलब्धि :</label>
												</div>
												
												<?php
												if($record_2['level']=='8' || $record_2['level']=='9'){
												?>
													<div class="col-md-12">
														<div class="table-responsive">
															<table class="table table-bordered table-hover">
																<tr>
																	<th style="width:10%">#</th>
																	<th style="width:45%">विषय </th>
																	<th style="width:45%">वर्तमान वर्ष </th>
																</tr>
																<?php
																$i=1;
																$query4="select * from deport_level_annual_work where level='".$record_2['level']."'";
																$row4=$db->select($query4);
																while($record4=$row4->fetch_array()){
																?>
																	<tr>
																		<td><?= $i; ?></td>
																		<td>
																			<?= $record4['work']; ?>
																			<input type="hidden" name="task_to_be_performed[]" value="<?= $record4['id']; ?>" class="form-control">
																		</td>
																		<td><input type="text" name="actual_achievement[]" class="form-control block_alpha" required></td>
																	</tr>
																<?php
																$i++;
																}
																?>
																
														   </table>
														</div>
													</div>
												<?php
												}
												?>
												<div class="col-md-6">
													<label>Award / Honours</label><br />
													<input name="award" type="file">
												</div>
												<div class="col-md-6"></div>
												
											</div>
                                            
											<input type="hidden" name="acr_id" value="<?= $record_3['id']; ?>">
                                            <input type="hidden" name="created_by" value="<?= $_SESSION['astro_email']; ?>">
                                            <input type="hidden" name="employee" value="<?= $record_1['employee_code']; ?>">
                                            <input type="hidden" name="add_self_appraisal1" value="add_self_appraisal1">
                                            <button id="department_button" class="btn btn-primary" type="submit">जमा करना</button>
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

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
		<script src="assets/js/vendor.min.js"></script>
		<script src="assets/libs/parsleyjs/parsley.min.js"></script>
		<script src="assets/js/pages/form-validation.init.js"></script>
		<script src="assets/js/app.min.js"></script>

<script>
function action_acr_date_range(query_acr_date_range){
	var action_acr_date_range = 'fetch_acr_date_range';
	$.ajax({
		url:"query.php",
		method:"POST",
		data:{action_acr_date_range:action_acr_date_range, query_acr_date_range:query_acr_date_range},
		success:function(data){
			//alert(data);
			$('#acr_date_range_data').html(data);
		}
	})
}
</script>

<script>
function action1(query1){
	if(query1 == 'Yes'){
		$('#as_due_id').html('<label>Date</label><input type="date" name="filed_property_retun_date" class="form-control">');
	}else{
		$('#as_due_id').html('');
	}
}

function action2(query2){
	if(query2 == 'Yes'){
		$('#check_up_id').html('<label>Date</label><input type="date" name="medical_check_up_date" class="form-control">');
	}else{
		$('#check_up_id').html('');
	}
}

function action3(query3){
	if(query3 == 'No'){
		$('#previous_year_id').html('<label>Reason</label><input type="text" name="previous_years_acr_reason" class="form-control">');
	}else{
		$('#previous_year_id').html('');
	}
}
</script>

<script>
$(document).ready(function(){
	$('#department_form').on('submit', function(e){
		e.preventDefault();
		$.ajax({
			url:'query.php',
			type:'POST',
			//data:$('#department_form').serialize(),
			data:new FormData(this),  
			contentType:false,  
			processData:false,
			beforeSend:function(){
				$('#department_button').html('Please Wait...');
			},
			success:function(data){
				//alert(data);
				if(data=='Error1'){
					$('#message').html('<p class="text-danger">Something Went Wrong!</p>');
				}else if(data=='Error'){
					$('#message').html('<p class="text-danger">Self Appraisal Already Submitted!</p>');
				}else{
					$('#department_form')[0].reset();
					$('#message').html('<p class="text-success">Self Appraisal Added Successfully!</p>');
					$('html, body').animate({ scrollTop: 0 }, 0);
					setInterval(function() {
						window.location.replace("appraisal?id="+data);
					}, 2000);
				}
				$('#department_button').html('Save');
			}
		});
	});
});
</script>

<script type="text/javascript">
    $(function () {
        $(".block_alpha").keypress(function (e) {
            var keyCode = e.keyCode || e.which;
			//var regex = /^[.0-9]+$/;
			var regex = /^[.0-9]+$/;
			var isValid = regex.test(String.fromCharCode(keyCode));
            return isValid;
        });
    });
</script>
      
    </body>
</html>