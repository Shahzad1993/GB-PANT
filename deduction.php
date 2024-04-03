<?php
include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}

$sql = "SELECT * FROM `deduction`";
$exe = $db->select($sql);
$record = $exe->fetch_array();
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Deduction | UKPN</title>
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
                                    <h4 class="page-title">Deduction</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Deduction</a></li>
                                            <li class="breadcrumb-item active">Deduction</li>
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
											<div class="row">
												
												<div class="col-md-3 mb-3">
													<label class="form-label">EPF (INR / %)</label>
													<select name="epf_type" class="form-control" required>
														<option value="">~~~Choose~~~</option>
														<?php
														if($record['epf_type']=='INR'){
														?>
															<option value="INR" selected>INR</option>
															<option value="%">%</option>
														<?php
														}else if($record['epf_type']=='%'){
														?>
															<option value="INR">INR</option>
															<option value="%" selected>%</option>
														<?php	
														}else{
														?>
															<option value="INR">INR</option>
															<option value="%">%</option>
														<?php	
														}
														?>
													</select>
												</div>
												<div class="col-md-3 mb-3">
													<label class="form-label">EPF</label>
													<input type="text" name="epf" value="<?= $record['epf']; ?>" class="form-control block_alpha" placeholder="EPF" required>
												</div>
												<div class="col-md-3 mb-3">
													<label class="form-label">GPF (INR / %)</label>
													<select name="gpf_type" class="form-control" required>
														<option value="">~~~Choose~~~</option>
														<?php
														if($record['gpf_type']=='INR'){
														?>
															<option value="INR" selected>INR</option>
															<option value="%">%</option>
														<?php
														}else if($record['gpf_type']=='%'){
														?>
															<option value="INR">INR</option>
															<option value="%" selected>%</option>
														<?php	
														}else{
														?>
															<option value="INR">INR</option>
															<option value="%">%</option>
														<?php	
														}
														?>
													</select>
												</div>
												
												<div class="col-md-3 mb-3">
													<label class="form-label">GPF</label>
													<input type="text" name="gpf" value="<?= $record['gpf']; ?>" class="form-control block_alpha" placeholder="GPF" required>
												</div>
												<div class="col-md-3 mb-3">
													<label class="form-label">GIS I (INR / %)</label>
													<select name="gis_1_type" class="form-control" required>
														<option value="">~~~Choose~~~</option>
														<?php
														if($record['gis_1_type']=='INR'){
														?>
															<option value="INR" selected>INR</option>
															<option value="%">%</option>
														<?php
														}else if($record['gis_1_type']=='%'){
														?>
															<option value="INR">INR</option>
															<option value="%" selected>%</option>
														<?php	
														}else{
														?>
															<option value="INR">INR</option>
															<option value="%">%</option>
														<?php	
														}
														?>
													</select>
												</div>
												
												<div class="col-md-3 mb-3">
													<label class="form-label">GIS I</label>
													<input type="text" name="gis_1" value="<?= $record['gis_1']; ?>" class="form-control block_alpha" placeholder="GIS I" required>
												</div>
												<div class="col-md-3 mb-3">
													<label class="form-label">GIS II (INR / %)</label>
													<select name="gis_2_type" class="form-control" required>
														<option value="">~~~Choose~~~</option>
														<?php
														if($record['gis_2_type']=='INR'){
														?>
															<option value="INR" selected>INR</option>
															<option value="%">%</option>
														<?php
														}else if($record['gis_2_type']=='%'){
														?>
															<option value="INR">INR</option>
															<option value="%" selected>%</option>
														<?php	
														}else{
														?>
															<option value="INR">INR</option>
															<option value="%">%</option>
														<?php	
														}
														?>
													</select>
												</div>
												
												<div class="col-md-3 mb-3">
													<label class="form-label">GIS II</label>
													<input type="text" name="gis_2" value="<?= $record['gis_2']; ?>" class="form-control block_alpha" placeholder="GIS II" required>
												</div>
												<div class="col-md-3 mb-3">
													<label class="form-label">EWF (INR / %)</label>
													<select name="ewf_type" class="form-control" required>
														<option value="">~~~Choose~~~</option>
														<?php
														if($record['ewf_type']=='INR'){
														?>
															<option value="INR" selected>INR</option>
															<option value="%">%</option>
														<?php
														}else if($record['ewf_type']=='%'){
														?>
															<option value="INR">INR</option>
															<option value="%" selected>%</option>
														<?php	
														}else{
														?>
															<option value="INR">INR</option>
															<option value="%">%</option>
														<?php	
														}
														?>
													</select>
												</div>
												
												<div class="col-md-3 mb-3">
													<label class="form-label">EWF</label>
													<input type="text" name="ewf" value="<?= $record['ewf']; ?>" class="form-control block_alpha" placeholder="EWF" required>
												</div>
												
												<div class="col-md-3 mb-3">
													<label class="form-label">Income Tax (INR / %)</label>
													<select name="income_tax_type" class="form-control" required>
														<option value="">~~~Choose~~~</option>
														<?php
														if($record['income_tax_type']=='INR'){
														?>
															<option value="INR" selected>INR</option>
															<option value="%">%</option>
														<?php
														}else if($record['income_tax_type']=='%'){
														?>
															<option value="INR">INR</option>
															<option value="%" selected>%</option>
														<?php	
														}else{
														?>
															<option value="INR">INR</option>
															<option value="%">%</option>
														<?php	
														}
														?>
													</select>
												</div>
												
												<div class="col-md-3 mb-3">
													<label class="form-label">Income Tax</label>
													<input type="text" name="income_tax" value="<?= $record['income_tax']; ?>" class="form-control block_alpha" placeholder="Income Tax" required>
												</div>
												<div class="col-md-3 mb-3">
													<label class="form-label">Other Recovery (INR / %)</label>
													<select name="other_recovery_type" class="form-control" required>
														<option value="">~~~Choose~~~</option>
														<?php
														if($record['other_recovery_type']=='INR'){
														?>
															<option value="INR" selected>INR</option>
															<option value="%">%</option>
														<?php
														}else if($record['other_recovery_type']=='%'){
														?>
															<option value="INR">INR</option>
															<option value="%" selected>%</option>
														<?php	
														}else{
														?>
															<option value="INR">INR</option>
															<option value="%">%</option>
														<?php	
														}
														?>
													</select>
												</div>
												
												<div class="col-md-3 mb-3">
													<label class="form-label">Other Recovery</label>
													<input type="text" name="other_recovery" value="<?= $record['other_recovery']; ?>" class="form-control block_alpha" placeholder="Other Recovery" required>
												</div>
												<div class="col-md-3 mb-3">
													<label class="form-label">Recovery Day (INR / %)</label>
													<select name="recovery_day_type" class="form-control" required>
														<option value="">~~~Choose~~~</option>
														<?php
														if($record['recovery_day_type']=='INR'){
														?>
															<option value="INR" selected>INR</option>
															<option value="%">%</option>
														<?php
														}else if($record['recovery_day_type']=='%'){
														?>
															<option value="INR">INR</option>
															<option value="%" selected>%</option>
														<?php	
														}else{
														?>
															<option value="INR">INR</option>
															<option value="%">%</option>
														<?php	
														}
														?>
													</select>
												</div>
												
												<div class="col-md-3 mb-3">
													<label class="form-label">Recovery Day</label>
													<input type="text" name="recovery_day" value="<?= $record['recovery_day']; ?>" class="form-control block_alpha" placeholder="Recovery Day" required>
												</div>
												<div class="col-md-3 mb-3">
													<label class="form-label">Corporation Recovery (INR / %)</label>
													<select name="corporation_recovery_type" class="form-control" required>
														<option value="">~~~Choose~~~</option>
														<?php
														if($record['corporation_recovery_type']=='INR'){
														?>
															<option value="INR" selected>INR</option>
															<option value="%">%</option>
														<?php
														}else if($record['corporation_recovery_type']=='%'){
														?>
															<option value="INR">INR</option>
															<option value="%" selected>%</option>
														<?php	
														}else{
														?>
															<option value="INR">INR</option>
															<option value="%">%</option>
														<?php	
														}
														?>
													</select>
												</div>
												
												<div class="col-md-3 mb-3">
													<label class="form-label">Corporation Recovery</label>
													<input type="text" name="corporation_recovery" value="<?= $record['corporation_recovery']; ?>" class="form-control block_alpha" placeholder="Corporation Recovery" required>
												</div>
											</div>
                                            
                                            <input type="hidden" name="add_deduction" value="add_deduction">
                                            <button id="department_button" class="btn btn-primary" type="submit">Save</button>
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
$(document).ready(function(){
	$('#department_form').on('submit', function(e){
		e.preventDefault();
		$.ajax({
			url:'query.php',
			type:'POST',
			data:$('#department_form').serialize(),
			/*data:new FormData(this),  
			contentType:false,  
			processData:false,*/
			beforeSend:function(){
				$('#department_button').html('Please Wait...');
			},
			success:function(data){
				//alert(data);
				if(data=='Success'){
					$('#message').html('<p class="text-success">Deduction Updated Successfully!</p>');
					//$('#department_form')[0].reset();
					setInterval(function() {
						location.reload();
						//window.location.replace("dashboard");
					}, 1000);
				}else{
					$('#message').html('<p class="text-danger">'+data+'</p>');
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
			var regex = /^[.0-9]+$/;
			//var regex = /^[0-9]+$/;
			var isValid = regex.test(String.fromCharCode(keyCode));
            return isValid;
        });
    });
</script>
      
    </body>
</html>