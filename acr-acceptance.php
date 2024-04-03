<?php
include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}

$query3="select * from acr where id='".$_REQUEST['id']."' and accepting_authority_name='".$_SESSION['astro_email']."'";
$row3=$db->select($query3);
if($row3->num_rows > 0){
	$record3=$row3->fetch_array();
}else{
	//header("Location: acr-review-list");
}

$query="select * from review_appraisal where id='".$_REQUEST['review-appraisal-id']."'";
$row=$db->select($query);
$record=$row->fetch_array();

$query1="select * from employee where employee_code='".$record['employee']."'";
$row1=$db->select($query1);
$record1=$row1->fetch_array();

$query6="select post_name,post_name_en,level from post where id='".$record1['post']."'";
$row6=$db->select($query6);
$record6=$row6->fetch_array();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>ACR Acceptance | UKPN</title>
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
.display_none{
	display: none;
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
                                    <h4 class="page-title">New ACR Acceptance</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">ACR Acceptance</a></li>
                                            <li class="breadcrumb-item active">New ACR Acceptance</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
							<div class="col-md-12">
								<div class="responsive-table-plugin">
									<div class="table-responsive">
										<table class="table table-bordered">
											<thead>
												<tr class="bg-primary text-white">
													<th colspan="6"><?= $record1['employee_name']; ?> का <?= $record3['year']; ?> का मूल्यांकन :</th>
												</tr>
											</thead>
											<thead>
												<tr>
													<th>वर्ष</th>
													<td><?= $record3['year']; ?></td>
													<th>कर्मचारी कोड</th>
													<td><?= $record1['employee_code']; ?></td>
													<th>कर्मचारी नाम</th>
													<td><?= $record1['employee_name']; ?></td>
												</tr>
												<tr>
													<th>कार्य स्थल </th>
													<td><?= $record1['work_location']; ?></td>
													<th>पदनाम </th>
													<td><?= $record6['post_name']; ?></td>
													<th>मोबाइल </th>
													<td><?= $record1['phone']; ?></td>
												</tr>
											</thead>
										</table>
									</div>
									

								</div>
							</div>
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
										<h4 id="message"></h4>
                                        <form id="department_form" class="needs-validation">
											<div class="row mb-3">
												
												<div class="col-md-12">
													<label class="form-label">क्या आप प्रतिवेदक / समीक्षक प्राधिकारी के मंतव्य से सहमत है?</label>
													<select name="agree_with_remark" class="form-control" onchange="action_acr_accept(this.value,<?= $record['id']; ?>)">
														<option value="">---</option>
														<option value="Yes">हाँ</option>
														<option value="No">नहीं</option>
													</select>
												</div>
												<div class="col-md-12">
													<div class="row" id="accept_section_id"></div>
												</div>
												
											</div>
                                            
                                            <input type="hidden" name="employee" value="<?= $record1['employee_code']; ?>">
                                            <input type="hidden" name="review_appraisal_id" value="<?= $record['id']; ?>">
                                            <input type="hidden" name="add_acr_acceptance" value="add_acr_acceptance">
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
				if(data=='Success'){
					$('#message').html('<p class="text-success">ACR Acceptance Added Successfully!</p>');
					$('#department_form')[0].reset();
					setTimeout(function() {
						window.location.replace("acr-review-list");
					}, 1000);
				}else if(data=='Error'){
					$('#message').html('<p class="text-danger">ACR Acceptance Already Submitted!</p>');
				}else{
					$('#message').html('<p class="text-danger">'+data+'</p>');
				}
				$('#department_button').html('Save');
			}
		});
	});
});
</script>

<script>
function action_acr_accept(query_acr_accept,id){
	var action_acr_accept = 'accept_section_show_hide';
	$.ajax({
		url:"query.php",
		method:"POST",
		data:{action_acr_accept:action_acr_accept,query_acr_accept:query_acr_accept,id:id},
		success:function(data){
			$('#accept_section_id').html(data);
		}
	})
}
</script>

<script>
function action_count_grade(overall_grade1){
	if(overall_grade1 >= 8){
		var shreni = 'A';
		var shreni1 = 'उत्कृष्ट';
	}else if(overall_grade1 < 8 && overall_grade1 >= 6){
		var shreni = 'B';
		var shreni1 = 'अतिउत्तम';
	}else if(overall_grade1 < 6 && overall_grade1 >= 4){
		var shreni = 'C';
		var shreni1 = 'उत्तम';
	}else if(overall_grade1 < 4 && overall_grade1 >= 3){
		var shreni = 'D';
		var shreni1 = 'अच्छा';
	}else if(overall_grade1 < 3){
		var shreni = 'E';
		var shreni1 = 'ख़राब';
	}else{
		var shreni = 'N/A';
		var shreni1 = '';
	}
	$('#shreni').val(shreni);
	$('#shreni1').val(shreni+' - '+shreni1);
}
</script>

    </body>
</html>