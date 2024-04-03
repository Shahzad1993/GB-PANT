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
        <title>Post | GB Pant</title>
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
      
            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">New Post</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Post</a></li>
                                            <li class="breadcrumb-item active">New Post</li>
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
                                        <form id="department_form" class="needs-validation" novalidate>
											<?php
											if(isset($_POST['id'])){
												$query_1="select * from post where id='".base64_decode($_POST['id'])."'";
												$row_1=$db->select($query_1);
												$record_1=$row_1->fetch_array();
											?>
												<div class="row">
													<div class="col-md-3 mb-3">
														<label class="form-label">Post Name Hindi</label>
														<input type="text" name="post_name" value="<?= $record_1['post_name']; ?>" class="form-control block_special" placeholder="Post Name" required>
													</div>
													<div class="col-md-3 mb-3">
														<label class="form-label">Post Name English</label>
														<input type="text" name="post_name_en" value="<?= $record_1['post_name_en']; ?>" class="form-control block_special" placeholder="Post Name" required>
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">No of Post Allowed</label>
														<select name="no_of_post" class="form-control" required>
															<option value="">~~~Choose~~~</option>
															<?php
															for($i=1; $i < 100; $i++){
																if($i==$record_1['no_of_post']){
																?>
																	<option value="<?= $i; ?>" selected><?= $i; ?></option>
																<?php
																}else{
																?>
																	<option value="<?= $i; ?>"><?= $i; ?></option>
																<?php
																}
															}
															?>
														</select>
													</div>
													
													<div class="col-md-3 mb-3">
														<label class="form-label">Reporting Authority</label>
														<select name="reporting_authority" id="reporting_authority" class="form-control">
															<option value="">~~~Choose~~~</option>
															<?php
															$query="select * from post";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
																if($record['id']==$record_1['reporting_authority']){
																?>
																	<option value="<?= $record['id']; ?>" selected><?= $record['post_name']; ?></option>
																<?php
																}else{
																?>
																	<option value="<?= $record['id']; ?>"><?= $record['post_name']; ?></option>
																<?php
																}
															}
															?>
														</select>
													</div>
													
													
												</div>
												<input type="hidden" name="id" value="<?= $record_1['id']; ?>">
												<input type="hidden" name="update_post" value="update_post">
												<button id="department_button" class="btn btn-primary" type="submit">Update</button>
												
											<?php
											}else{
											?>
												<div class="row">
													<div class="col-md-3 mb-3">
														<label class="form-label">Post Name Hindi</label>
														<input type="text" name="post_name" id="post_name" class="form-control block_special" placeholder="Post Name Hindi">
													</div>
													<div class="col-md-3 mb-3">
														<label class="form-label">Post Name English</label>
														<input type="text" name="post_name_en" id="post_name_en" class="form-control block_special" placeholder="Post Name English" required>
													</div>
													<div class="col-md-3 mb-3">
														<label class="form-label">No of Post Allowed</label>
														<select name="no_of_post" id="no_of_post" class="form-control">
															<option value="">~~~Choose~~~</option>
															<?php
															for($i=1; $i < 100; $i++){
															?>
																<option value="<?= $i; ?>"><?= $i; ?></option>
															<?php
															}
															?>
														</select>
													</div>
													<div class="col-md-3 mb-3">
														<label class="form-label">Reporting Authority</label>
														<select name="reporting_authority" id="reporting_authority" class="form-control">
															<option value="">~~~Choose~~~</option>
															<option value="None">None</option>
															<?php
															$query="select * from post";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
															?>
																<option value="<?= $record['id']; ?>"><?= $record['post_name']; ?></option>
															<?php
															}
															?>
														</select>
													</div>
													
												</div>
												
												<input type="hidden" name="add_post" value="add_post">
												<button id="department_button" class="btn btn-primary" type="submit">Save Post</button>
												
											<?php
											}
											?>
											
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
function action_001(work_location){
	var action_001 = 'fetch_authority_post';
	$.ajax({
		url:"query.php",
		method:"POST",
		data:{action_001:action_001, work_location:work_location},
		success:function(data){
			//alert(data);
			$('#reporting_authority').html(data);
			$('#reviewing_authority').html(data);
			$('#accepting_authority').html(data);
		}
	})
}
</script>

<script>
$(document).ready(function(){
	$('#department_form').on('submit', function(e){
		e.preventDefault();
		if($('#work_location').val() == ''){
			$('.form-control').css('border', '1px solid #d3d6da');
			$('#work_location').css('border', '2px solid red');
			$('#work_location').focus();
		}else if($('#post_name').val() == ''){
			$('.form-control').css('border', '1px solid #d3d6da');
			$('#post_name').css('border', '2px solid red');
			$('#post_name').focus();
		}else if($('#post_name_en').val() == ''){
			$('.form-control').css('border', '1px solid #d3d6da');
			$('#post_name_en').css('border', '2px solid red');
			$('#post_name_en').focus();
		}else if($('#no_of_post').val() == ''){
			$('.form-control').css('border', '1px solid #d3d6da');
			$('#no_of_post').css('border', '2px solid red');
			$('#no_of_post').focus();
		}else if($('#reporting_authority').val() == ''){
			$('.form-control').css('border', '1px solid #d3d6da');
			$('#reporting_authority').css('border', '2px solid red');
			$('#reporting_authority').focus();
		}else{
			$.ajax({
				url:'query.php',
				type:'POST',
				data:$('#department_form').serialize(),
				beforeSend:function(){
					$('#department_button').html('Please Wait...');
				},
				success:function(data){
					//alert(data);
					if(data=='Success'){
						$('#message').html('<p class="text-success">Post Added Successfully!</p>');
						$('#department_form')[0].reset();
						/*setInterval(function() {
							location.reload();
						}, 2000);*/
					}else if(data=='Success1'){
						$('#message').html('<p class="text-success">Post Update Successfully!</p>');
						/*setInterval(function() {
							location.reload();
						}, 2000);*/
					}else{
						$('#message').html('<p class="text-danger">'+data+'</p>');
					}
					$('#department_button').html('Save');
				}
			});
		}
	});
});
</script>

<script type="text/javascript">
    $(function () {
        $(".block_special").keypress(function (e) {
            var keyCode = e.keyCode || e.which;
			var regex = /^[0-9 A-Za-z_,]+$/;
			var isValid = regex.test(String.fromCharCode(keyCode));
            return isValid;
        });
    });
</script>
      
    </body>
</html>