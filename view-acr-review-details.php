<?php
include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}

$query="select * from review_appraisal where id='".$_REQUEST['id']."'";
$row=$db->select($query);
$record=$row->fetch_array();

$query_2="select * from employee_appraisal where id='".$record['employee_appraisal_id']."'";
$row_2=$db->select($query_2);
$record_2=$row_2->fetch_array();

$query_1="select * from self_appraisal where id='".$record_2['self_appraisal_id']."'";
$row_1=$db->select($query_1);
$record_1=$row_1->fetch_array();

$query1="select employee_name,employee_code,post,father_name,work_location,phone from employee where employee_code='".$record['employee']."'";
$row1=$db->select($query1);
$record1=$row1->fetch_array();

$query6="select post_name_en,post_name,level from post where id='".$record1['post']."'";
$row6=$db->select($query6);
$record6=$row6->fetch_array();

$query11="select * from grading where shreni='".$record['shreni']."'";
$row11=$db->select($query11);
$record11=$row11->fetch_array();
$shreni = $record11['shreni'].' - '.$record11['shreni_name'];

/*if($record['shreni'] == 'A'){
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
}*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>View ACR Review Details | UKPN</title>
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
                                    <h4 class="page-title">View ACR Review Details</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">ACR Review</a></li>
                                            <li class="breadcrumb-item active">View ACR Review Details</li>
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
																	<th colspan="6"><?= $record1['employee_name']; ?> का  <?= $record_2['year']; ?>  का एसीआर समीक्षा विवरण :</th>
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
																	<td><?= $record_2['year']; ?></td>
																	<th>दिनांक</th>
																	<td><?= date("d M, Y", strtotime($record_1['from_date'])); ?></td>
																	<th>से दिनांक</th>
																	<td><?= date("d M, Y", strtotime($record_1['to_date'])); ?></td>
																</tr>
																<tr>
																	<th>समग्र ग्रेड </th>
																	<td><?= $record['overall_grade']; ?></td>
																	<th>श्रेणी</th>
																	<td colspan="3"><?= $shreni; ?></td>
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
																	$query_0="select * from assestment_of_personal_attributes_data where employee_appraisal_id='".$record_2['id']."'";
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
											
											
											if($record_2['pen_picture']!='' && $record_2['pen_picture']!=NULL){
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
																<tbody><tr><td><?= $record_2['pen_picture']; ?></tr></td></tbody>
															</table>
														</div>
													</div>
												</div>
											<?php
											}
											?>
											
											<div class="col-md-12 mb-3">
												<div class="responsive-table-plugin">
													<div class="table-responsive">
														<table class="table table-bordered">
															
															<thead>
																<tr>
																	<th>क्या आप प्रतिवेदक प्राधिकारी द्वारा किये गए मूल्यांकन से सहमत हैं ?</th>
																	<td><?= $record['agree_with_assestment']; ?></td>
																</tr>
																<tr>
																	<th>मत भिन्नता में सकारण विवरण अंकित किया जाये । </th>
																	<td><?= $record['diffrent_openion']; ?></td>
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
											<?php
											$sql_acr = "SELECT * FROM `acr` WHERE accepting_authority_name = '".$_SESSION['astro_email']."' and present_post='".$record1['post']."'";
											$exe_acr = $db->select($sql_acr);
											if ($exe_acr->num_rows > 0) {
											?>
											<div class="col-md-12 mb-3">
												<h4 id="message"></h4>
												<form id="department_form" class="needs-validation">
													<div class="row mb-3">
														
														<div class="col-md-12">
															<label class="form-label">क्या आप प्रतिवेदक / समीक्षक प्राधिकारी के मंतव्य से सहमत है?</label>
															<select name="agree_with_remark" id="agree_with_remark" class="form-control" onchange="action_acr_accept(this.value,<?= $record['id']; ?>)">
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
$(document).ready(function(){
	$('#department_form').on('submit', function(e){
		e.preventDefault();
		if($('#agree_with_remark').val()==''){
			$('#agree_with_remark').css('border', '2px solid red');
			$('#agree_with_remark').focus();
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
						$('#message').html('<p class="text-danger">ACR Acceptance Already Submitted!</p>');
					}else{
						$('#message').html('<p class="text-success">ACR Acceptance Added Successfully!</p>');
						$('#department_form')[0].reset();
						setTimeout(function() {
							window.location.replace("view-acr-details?id="+data);
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
		var shreni = 'E';
		var shreni1 = 'ख़राब';
	}
	$('#shreni').val(shreni);
	$('#shreni1').val(shreni+' - '+shreni1);
}
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