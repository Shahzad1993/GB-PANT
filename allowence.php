<?php
include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}

$sql = "SELECT * FROM `allowence`";
$exe = $db->select($sql);
$record = $exe->fetch_array();
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Allowance | UKPN</title>
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
                                    <h4 class="page-title">Allowance</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Allowance</a></li>
                                            <li class="breadcrumb-item active">Allowance</li>
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
													<label class="form-label">DA (INR / %)</label>
													<select name="da_type" class="form-control" required>
														<option value="">~~~Choose~~~</option>
														<?php
														if($record['da_type']=='INR'){
														?>
															<option value="INR" selected>INR</option>
															<option value="%">%</option>
														<?php
														}else if($record['da_type']=='%'){
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
													<label class="form-label">DA</label>
													<input type="text" name="da" value="<?= $record['da']; ?>" class="form-control block_alpha" placeholder="DA" required>
												</div>
												<div class="col-md-3 mb-3">
													<label class="form-label">Personal Pay (INR / %)</label>
													<select name="personal_pay_type" class="form-control" required>
														<option value="">~~~Choose~~~</option>
														<?php
														if($record['personal_pay_type']=='INR'){
														?>
															<option value="INR" selected>INR</option>
															<option value="%">%</option>
														<?php
														}else if($record['personal_pay_type']=='%'){
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
													<label class="form-label">Personal Pay</label>
													<input type="text" name="personal_pay" value="<?= $record['personal_pay']; ?>" class="form-control block_alpha" placeholder="Personal Pay" required>
												</div>
												
												<div class="col-md-3 mb-3">
													<label class="form-label">Medical Allowance (INR / %)</label>
													<select name="medical_allowence_type" class="form-control" required>
														<option value="">~~~Choose~~~</option>
														<?php
														if($record['medical_allowence_type']=='INR'){
														?>
															<option value="INR" selected>INR</option>
															<option value="%">%</option>
														<?php
														}else if($record['medical_allowence_type']=='%'){
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
													<label class="form-label">Medical Allowance</label>
													<input type="text" name="medical_allowence" value="<?= $record['medical_allowence']; ?>" class="form-control block_alpha" placeholder="Medical Allowance" required>
												</div>
												
												
												<div class="col-md-3 mb-3">
													<label class="form-label">HRA (INR / %)</label>
													<select name="hra_type" class="form-control" required>
														<option value="">~~~Choose~~~</option>
														<?php
														if($record['hra_type']=='INR'){
														?>
															<option value="INR" selected>INR</option>
															<option value="%">%</option>
														<?php
														}else if($record['hra_type']=='%'){
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
													<label class="form-label">HRA</label>
													<input type="text" name="hra" value="<?= $record['hra']; ?>" class="form-control block_alpha" placeholder="HRA" required>
												</div>
												<div class="col-md-3 mb-3">
													<label class="form-label">Hill Allowance (INR / %)</label>
													<select name="hill_allowence_type" class="form-control" required>
														<option value="">~~~Choose~~~</option>
														<?php
														if($record['hill_allowence_type']=='INR'){
														?>
															<option value="INR" selected>INR</option>
															<option value="%">%</option>
														<?php
														}else if($record['hill_allowence_type']=='%'){
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
													<label class="form-label">Hill Allowance</label>
													<input type="text" name="hill_allowence" value="<?= $record['hill_allowence']; ?>" class="form-control block_alpha" placeholder="Hill Allowance" required>
												</div>
												<div class="col-md-3 mb-3">
													<label class="form-label">Border Allowance (INR / %)</label>
													<select name="border_allowence_type" class="form-control" required>
														<option value="">~~~Choose~~~</option>
														<?php
														if($record['border_allowence_type']=='INR'){
														?>
															<option value="INR" selected>INR</option>
															<option value="%">%</option>
														<?php
														}else if($record['border_allowence_type']=='%'){
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
													<label class="form-label">Border Allowance</label>
													<input type="text" name="border_allowence" value="<?= $record['border_allowence']; ?>" class="form-control block_alpha" placeholder="Border Allowance" required>
												</div>
												<div class="col-md-3 mb-3">
													<label class="form-label">CCA (INR / %)</label>
													<select name="cca_type" class="form-control" required>
														<option value="">~~~Choose~~~</option>
														<?php
														if($record['cca_type']=='INR'){
														?>
															<option value="INR" selected>INR</option>
															<option value="%">%</option>
														<?php
														}else if($record['cca_type']=='%'){
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
													<label class="form-label">CCA</label>
													<input type="text" name="cca" value="<?= $record['cca']; ?>" class="form-control block_alpha" placeholder="CCA" required>
												</div>
												
												
												
											</div>
                                            
                                            <input type="hidden" name="add_allowence" value="add_allowence">
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
					$('#message').html('<p class="text-success">Allowance Updated Successfully!</p>');
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