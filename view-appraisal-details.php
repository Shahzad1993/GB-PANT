<?php
include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}

$query="select * from employee_appraisal where id='".$_REQUEST['id']."'";
$row=$db->select($query);
$record=$row->fetch_array();

$query_1="select * from self_appraisal where id='".$record['self_appraisal_id']."'";
$row_1=$db->select($query_1);
$record_1=$row_1->fetch_array();

$query1="select employee_name,employee_code,post,father_name,work_location,phone from employee where employee_code='".$record['employee']."'";
$row1=$db->select($query1);
$record1=$row1->fetch_array();

$query11="select * from grading where shreni='".$record['shreni']."'";
$row11=$db->select($query11);
$record11=$row11->fetch_array();
$shreni = $record11['shreni'].' - '.$record11['shreni_name'];

$query6="select post_name_en,post_name,level from post where id='".$record1['post']."'";
$row6=$db->select($query6);
$record6=$row6->fetch_array();
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>View Appraisal Details | UKPN</title>
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
                                    <h4 class="page-title">View Appraisal Details</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Appraisal</a></li>
                                            <li class="breadcrumb-item active">View Appraisal Details</li>
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
																	<th colspan="5"><?= $record1['employee_name']; ?>'s Appraisal Details of <?= $record['year']; ?> :</th>
																	<th>
																	<?php
																	if($_SESSION['astro_role']!='Admin'){
																		$query2="select * from review_appraisal where employee_appraisal_id='".$_REQUEST['id']."'";
																		$row2=$db->select($query2);
																		if($row2->num_rows > 0){
																			$record2=$row2->fetch_array();
																		?>
																			<a href="view-acr-review-details?id=<?= $record2['id']; ?>" class="btn btn-warning btn-sm">View Review</a>
																		<?php
																		}
																	}else{
																	?>
																		<a href="view-appraisal-list" class="btn btn-warning btn-sm">Back</a>
																	<?php	
																	}
																	?>
																	</th>
																</tr>
															</thead>
															<thead>
																<tr>
																	<th>कर्मचारी कोड</th>
																	<td><?= $record1['employee_code']; ?></td>
																	<th>कर्मचारी नाम</th>
																	<td><?= $record1['employee_name']; ?></td>
																	<th>पिता का  नाम</th>
																	<td><?= $record1['father_name']; ?></td>
																</tr>
																<tr>
																	<th>कार्य स्थल </th>
																	<td><?= $record1['work_location']; ?></td>
																	<th>पदनाम </th>
																	<td><?= $record6['post_name']; ?></td>
																	<th>मोबाइल </th>
																	<td><?= $record1['phone']; ?></td>
																</tr>
																<tr>
																	<th>वर्ष</th>
																	<td><?= $record['year']; ?></td>
																	<th>दिनांक</th>
																	<td><?= date("d M, Y", strtotime($record_1['from_date'])); ?></td>
																	<th>से दिनांक</th>
																	<td><?= date("d M, Y", strtotime($record_1['to_date'])); ?></td>
																</tr>
																<tr>
																	<th>समग्र ग्रेड </th>
																	<td><?= $record['overall_grade']; ?></td>
																	<th>श्रेणी</th>
																	<td><?= $shreni; ?></td>
																	<th>सत्यनिष्ठा </th>
																	<td><?= $record['integrity']; ?></td>
																</tr>
															</thead>
														</table>
													</div>
												</div>
											</div>
											
											<?php
											if($record6['post_name_en']=='DRIVER' || $record6['post_name_en']=='CONDUCTOR' || $record6['level']=='10'){
											?>
												<div class="col-md-12">
													<label class="form-label">वार्षिक कार्य योजना और उपलब्धि :</label>
												</div>
												<div class="col-md-12">
													<div class="table-responsive">
														<table class="table table-bordered table-hover">
															<tr>
																<th style="width:4%">#</th>
																<th style="width:36%">विषय </th>
																<th style="width:20%">वर्तमान वर्ष </th>
																<th style="width:20%">ग्रेड (1 to 10)</th>
																<th style="width:20%">श्रेणी </th>
															</tr>
															<?php
															$a=1;
															$query41="select * from annual_work_plan where self_appraisal_id='".$record_1['id']."'";
															$row41=$db->select($query41);
															while($record41=$row41->fetch_array()){
																if($record41['task_to_be_performed']=='Behaviour'){
																	$work = 'सामान्य व्यवहार';
																}else{
																	$query4="select * from deport_level_annual_work where id='".$record41['task_to_be_performed']."'";
																	$row4=$db->select($query4);
																	$record4=$row4->fetch_array();
																	$work = $record4['work'];
																}
																
																$actual_achievement = $record41['actual_achievement'];
																$grade = $record41['grade'];
																
																$query42="select * from grading where min_grade <= $grade and max_grade >= $grade";
																$row42=$db->select($query42);
																$record42=$row42->fetch_array();
															?>
																<tr>
																	<td><?= $a; ?></td>
																	<td>
																		<?= $work; ?>
																	</td>
																	<td><?= $record41['actual_achievement']; ?></td>
																	<td><?= $record41['grade']; ?></td>
																	<td><?= $record42['shreni'].' - '.$record42['shreni_name']; ?></td>
																</tr>
															<?php
															$a++;
															}
															$total = $row41->num_rows;;
															?>
															
													   </table>
													</div>
												</div>
											<?php
											}else{
											?>
												<div class="col-md-12 mb-3">
													<div class="responsive-table-plugin">
														<div class="table-responsive">
															<table class="table table-bordered">
																<thead>
																	<tr class="bg-primary text-white">
																		<th colspan="4">Assessment of Personal Attribute :</th>
																	</tr>
																	<tr>
																		<th>#</th>
																		<th>Personal Attribute</th>
																		<th>Grade (1 to 10)</th>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	$i=1;
																	$query_0="select * from assestment_of_personal_attributes_data where employee_appraisal_id='".$_REQUEST['id']."'";
																	$row_0=$db->select($query_0);
																	while($record_0=$row_0->fetch_array()){
																		$query_1="select * from assestment_of_personal_attributes where id='".$record_0['assestment_of_personal_attributes_id']."'";
																		$row_1=$db->select($query_1);
																		$record_1=$row_1->fetch_array();
																	?>
																	<tr>
																		<th><?= $i; ?></th>
																		<td><?= $record_1['personal_attribute']; ?></td>
																		<td><?= $record_0['grade']; ?></td>
																	</tr>
																	<?php
																	$i++;
																	}
																	?>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											<?php
											}
											
											if($record['pen_picture']!='' && $record['pen_picture']!=NULL){
											?>
												<div class="col-md-12 mb-3">
													<div class="responsive-table-plugin">
														<div class="table-responsive">
															<table class="table table-bordered">
																<thead>
																	<tr class="bg-primary text-white">
																		<th colspan="4">प्रतिवेदक प्राधिकारी कि टिप्पणी :</th>
																	</tr>
																</thead>
																<tbody><tr><td><?= $record['pen_picture']; ?></tr></td></tbody>
															</table>
														</div>
													</div>
												</div>
											<?php
											}
											
											$sql_acr_1 = "SELECT * FROM `acr` WHERE reviewing_authority_name = '".$_SESSION['astro_email']."' and present_post='".$record1['post']."'";
											$exe_acr_1 = $db->select($sql_acr_1);
											if ($exe_acr_1->num_rows > 0) {
											?>
												<div class="col-md-12">
													<h4 id="message"></h4>
													<form id="department_form" class="needs-validation">
														<div class="row mb-3">
															<div class="col-md-12">
																<label class="form-label">क्या आप प्रतिवेदक प्राधिकारी द्वारा किये गए मूल्यांकन से सहमत हैं ?</label>
																<!--select name="agree_with_assestment" class="form-control" onchange="action1(this.value)"-->
																<select name="agree_with_assestment" id="agree_with_assestment" class="form-control" onchange="action_acr_review(this.value,<?= $record['id']; ?>)">
																	<option value="">---</option>
																	<option value="Yes">हाँ</option>
																	<option value="No">नहीं</option>
																</select>
															</div>
															<div class="col-md-12">
																<div class="row" id="review_section_id"></div>
															</div>
														</div>
														
														<input type="hidden" name="employee" value="<?= $record1['employee_code']; ?>">
														<input type="hidden" name="employee_appraisal_id" value="<?= $record['id']; ?>">
														<input type="hidden" name="add_acr_review" value="add_acr_review">
														<button id="department_button" class="btn btn-primary" type="submit">जमा करें </button>
													</form>
												</div>
											<?php
											}
											?>
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
<script>
function action_acr_review(query_acr_review,id){
	var action_acr_review = 'review_section_show_hide';
	$.ajax({
		url:"query.php",
		method:"POST",
		data:{action_acr_review:action_acr_review,query_acr_review:query_acr_review,id:id},
		success:function(data){
			$('#review_section_id').html(data);
		}
	})
}
</script>

<script>
function action_count_grade(overall_grade1){
	if(overall_grade1 > 8){
		var shreni = 'A';
		var shreni1 = 'उत्कृष्ट';
	}else if(overall_grade1 <= 8 && overall_grade1 >= 7){
		var shreni = 'B';
		var shreni1 = 'अतिउत्तम';
	}else if(overall_grade1 <= 6 && overall_grade1 >= 5){
		var shreni = 'C';
		var shreni1 = 'उत्तम';
	}else if(overall_grade1 <= 4 && overall_grade1 >= 3){
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

<script>
$(document).ready(function(){
	$('#department_form').on('submit', function(e){
		e.preventDefault();
		if($('#agree_with_assestment').val()==''){
			$('#agree_with_assestment').css('border', '2px solid red');
			$('#agree_with_assestment').focus();
		}else{
			$('.form-control').css('border', '1px solid #d3d6da');
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
						$('#message').html('<p class="text-danger">ACR Review Already Submitted!</p>');
					}else{
						$('#message').html('<p class="text-success">ACR Review Added Successfully!</p>');
						$('#department_form')[0].reset();
						setTimeout(function() {
							window.location.replace("view-acr-review-details?id="+data);
						}, 1000);
					}
					$('#department_button').html('Save');
				}
			});
		}
	});
});
</script>

<script>
function countChar(val) {
  var len = val.value.length;
  if (len >= 50) {
    //val.value = val.value.substring(0, 100);
	$('#department_button').attr('disabled', false);
  } else {
    $('#charNum').text(50 - len);
	$('#department_button').attr('disabled', true);
  }
};
</script>
      
    </body>
</html>