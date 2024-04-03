<?php
include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}
$query3="select * from self_appraisal where id='".$_REQUEST['id']."'";
$row3=$db->select($query3);
if($row3->num_rows > 0){
	$record3=$row3->fetch_array();
}else{
	//header("Location: view-self-appraisal-list");
}

/*$query4="select * from self_appraisal where employee='".$_REQUEST['id']."' order by year desc";
$row4=$db->select($query4);
$record4=$row4->fetch_array();*/

$query5="select * from employee where employee_code='".$record3['employee']."'";
$row5=$db->select($query5);
$record5=$row5->fetch_array();

$query6="select post_name,post_name_en,level from post where id='".$record5['post']."'";
$row6=$db->select($query6);
$record6=$row6->fetch_array();
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Appraisal | UKPN</title>
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
                                    <h4 class="page-title">Appraisal</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Appraisal</a></li>
                                            <li class="breadcrumb-item active">Appraisal</li>
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
                                        <form id="acr_form" class="needs-validation">
											<div class="row">
												<div class="col-md-12">
													<div class="responsive-table-plugin">
														<div class="table-responsive">
															<table class="table table-bordered">
																<thead>
																	<tr class="bg-primary text-white">
																		<th colspan="6"><?= $record5['employee_name']; ?> का <?= $record3['year']; ?> का मूल्यांकन :</th>
																	</tr>
																</thead>
																<thead>
																	<tr>
																		<th>कर्मचारी कोड</th>
																		<td><?= $record5['employee_code']; ?></td>
																		<th>कर्मचारी नाम</th>
																		<td><?= $record5['employee_name']; ?></td>
																		<th>पिता का  नाम</th>
																		<td><?= $record5['father_name']; ?></td>
																	</tr>
																	<tr>
																		<th>कार्य स्थल </th>
																		<td><?= $record5['work_location']; ?></td>
																		<th>पदनाम </th>
																		<td><?= $record6['post_name']; ?></td>
																		<th>मोबाइल </th>
																		<td><?= $record5['phone']; ?></td>
																	</tr>
																	<tr>
																		<th>वर्ष</th>
																		<td><?= $record3['year']; ?></td>
																		<th>दिनांक</th>
																		<td><?= date("d M, Y", strtotime($record3['from_date'])); ?></td>
																		<th>से दिनांक</th>
																		<td><?= date("d M, Y", strtotime($record3['to_date'])); ?></td>
																	</tr>
																</thead>
															</table>
														</div>
														

													</div>
												</div>
												<?php
												if($record6['post_name_en']=='DRIVER' || $record6['post_name_en']=='CONDUCTOR' || $record6['level']=='10'){
													$save_type = 'add_employee_appraisal1';
												?>
													<div class="col-md-12">
														<div class="table-responsive">
															<table class="table table-bordered table-hover">
																<tr class="bg-primary text-white">
																	<th colspan="4">स्वः मूल्यांकन के आधार पर मूल्यांकन  :</th>
																</tr>
																<tr>
																	<th style="width:4%">#</th>
																	<th style="width:32%">विषय </th>
																	<th style="width:32%">वर्तमान वर्ष </th>
																	<th style="width:32%">ग्रेड (1 to 10)</th>
																</tr>
																<?php
																$a=1;
																$query41="select * from annual_work_plan where self_appraisal_id='".$record3['id']."'";
																$row41=$db->select($query41);
																while($record41=$row41->fetch_array()){
																	$query4="select * from deport_level_annual_work where id='".$record41['task_to_be_performed']."'";
																	$row4=$db->select($query4);
																	$record4=$row4->fetch_array();
																	$actual_achievement = $record41['actual_achievement'];
																	
																	$grade_data = '';
																	if($record41['task_to_be_performed']=='98' || $record41['task_to_be_performed']=='103'){
																		$query42="select * from kilometers where marg='".$record3['marg']."' and min_km <= $actual_achievement and max_km >= $actual_achievement";
																		$row42=$db->select($query42);
																		$record42=$row42->fetch_array();
																		
																		$min_grade = $record42['min_grade'];
																		
																		$grade_data .='<option value="'.$min_grade.'" selected>'.$min_grade.'</option>';
																	}else if($record41['task_to_be_performed']=='99'){
																		$query42="select * from diesel_average where marg='".$record3['marg']."' and min_average <= $actual_achievement and max_average >= $actual_achievement";
																		$row42=$db->select($query42);
																		$record42=$row42->fetch_array();
																		
																		$min_grade = $record42['min_grade'];
																		$grade_data .='<option value="'.$min_grade.'" selected>'.$min_grade.'</option>';
																	}else if($record41['task_to_be_performed']=='114' || $record41['task_to_be_performed']=='105'){
																		$query42="select * from attendance_days where min_days <= $actual_achievement and max_days >= $actual_achievement";
																		$row42=$db->select($query42);
																		$record42=$row42->fetch_array();
																		
																		$min_grade = $record42['min_grade'];
																		$grade_data .='<option value="'.$min_grade.'" selected>'.$min_grade.'</option>';
																	}else if($record41['task_to_be_performed']=='104'){
																		$query42="select * from load_factor where min_load <= $actual_achievement and max_load >= $actual_achievement";
																		$row42=$db->select($query42);
																		$record42=$row42->fetch_array();
																		
																		$grade = $record42['grade'];
																		$grade_data .='<option value="'.$grade.'" selected>'.$grade.'</option>';
																	}else if($record41['task_to_be_performed']=='100'){
																		if($actual_achievement==0){
																			$accident = '10';
																		}else if($actual_achievement==1){
																			$accident = '5';
																		}else{
																			$accident = '0';
																		}
																		$grade_data .='<option value="'.$accident.'" selected>'.$accident.'</option>';
																	}else{
																		for($i = 1; $i <= 10; $i++){
																			$grade_data .='<option value="'.$i.'">'.$i.'</option>';
																		}
																	}
																?>
																	<tr>
																		<td><?= $a; ?></td>
																		<td>
																			<?= $record4['work']; ?>
																			<input type="hidden" name="annual_work_plan_id[]" value="<?= $record41['id']; ?>" class="form-control">
																		</td>
																		<td><?= $record41['actual_achievement']; ?></td>
																		<td>
																			<select name="grade[]" class="form-control allot_qty_class" onchange="action_count_grade(this.value)" required>
																				<option value="">---</option>
																				<?= $grade_data; ?>
																			</select>
																		</td>
																	</tr>
																<?php
																$a++;
																}
																$total = ($row41->num_rows) + 1;
																?>
																<tr>
																	<td><?= $a; ?></td>
																	<td>
																		सामान्य व्यवहार 
																		<input type="hidden" name="annual_work_plan_id[]" value="Behaviour" class="form-control">
																	</td>
																	<td></td>
																	<td>
																		<select name="grade[]" class="form-control allot_qty_class" onchange="action_count_grade(this.value)" required>
																			<option value="">---</option>
																			<?php
																			for($i = 1; $i <= 10; $i++){
																				echo '<option value="'.$i.'">'.$i.'</option>';
																			}
																			?>
																		</select>
																	</td>
																</tr>
														   </table>
														</div>
													</div>
												<?php
												}else{
													$save_type = 'add_employee_appraisal';
												?>
													<div class="col-md-12">
														<div class="responsive-table-plugin">
															<div class="table-responsive">
																<table class="table table-bordered">
																	<thead>
																		<tr class="bg-primary text-white">
																			<th colspan="2">वयक्तिगत गुणों का मूल्यांकन  :</th>
																			<th style="text-align:right"><a href="view-self-appraisal-details.php?id=<?= $_REQUEST['id']; ?>" class="btn btn-warning btn-sm">Back</a></th>
																		</tr>
																		<tr>
																			<th style="width:5%">#</th>
																			<th style="width:45%">स्वः मूल्यांकन के आधार पर मूल्यांकन :</th>
																			<th style="width:50%">ग्रेड  (1 - 10) :</th>
																		</tr>
																	</thead>
																	<thead>
																		<?php
																		$j=1;
																		$query="select * from assestment_of_personal_attributes";
																		$row=$db->select($query);
																		if($row->num_rows > 0){
																			while($record=$row->fetch_array()){
																			?>
																				<tr>
																					<th><?= $j; ?></th>
																					<th>
																						<?= $record['personal_attribute']; ?>
																						<input type="hidden" name="personal_attribute[]" value="<?= $record['id']; ?>">
																					</th>
																					<td>
																						<select name="grade[]" class="form-control allot_qty_class" onchange="action_count_grade(this.value)" required>
																							<?php
																							for($i = 1; $i <= 10; $i++){
																							?>
																								<option value="<?= $i; ?>"><?= $i; ?></option>
																							<?php
																							}
																							?>
																						</select>
																					</td>
																				</tr>
																			<?php
																			$j++;
																			}
																		}
																		?>
																	</thead>
																</table>
															</div>
															
														</div>
													</div>
													
													
												<?php
													$total = $row->num_rows;
												}
												?>
												<div class="col-md-12">
														<div class="responsive-table-plugin">
															<div class="table-responsive">
																<table class="table table-bordered">
																	<thead>
																		<tr class="bg-primary text-white">
																			<th>प्रतिवेदक प्राधिकारी कि टिप्पणी (अधिकतम 100 अक्षर) :<br />
																				<small>ग्रेडिंग कि प्रणाली अपनाते हुए कार्मिक / अधिकारी के व्यक्तिगत गुण एवं कार्यक्षमता तथा आउटपुट का संज्ञान लिया जाये </small>
																			</th>
																		</tr>
																	</thead>
																	<thead>
																		<tr>
																			<td>
																				<textarea name="pen_picture" class="form-control" rows="7" onkeyup="countChar(this)"></textarea>
																				<span id="charNum">100</span>
																			</td>
																		</tr>
																	</thead>
																</table>
															</div>
														</div>
													</div>
												<div class="col-md-12">
													<div class="responsive-table-plugin">
														<div class="table-responsive">
															<table class="table table-bordered">
																<thead>
																	<tr>
																		<th style="width:38%">सत्यनिष्ठा </th>
																		<th style="width:17%">समग्र ग्रेड (अंक 1 से 10 तक)</th>
																		<th style="width:15%">श्रेणी </th>
																	</tr>
																</thead>
																<thead>
																	<tr>
																		<td>
																			<select name="integrity" class="form-control" required>
																				<option value="">---</option>
																				<option value="प्रमाणित">प्रमाणित</option>
																				<option value="संदिग्ध">संदिग्ध</option>
																			</select>
																		</td>
																		<td>
																			<input type="number" name="overall_grade" id="overall_grade" value="1" class="form-control" readonly>
																		</td>
																		<td>
																			<input type="hidden" name="shreni" id="shreni" value="E" class="form-control" readonly>
																			<input type="text" id="shreni1" value="E" class="form-control" readonly>
																		</td>
																		
																	</tr>
																</thead>
															</table>
														</div>
													</div>
												</div>
												
											</div>
											
                                            <input type="hidden" name="self_appraisal_id" value="<?= $record3['id']; ?>">
                                            <input type="hidden" name="employee" value="<?= $record3['employee']; ?>">
                                            <input type="hidden" name="year" value="<?= $record3['year']; ?>">
                                            <input type="hidden" name="<?= $save_type; ?>" value="<?= $save_type; ?>">
                                            <button id="acr_button" class="btn btn-primary" type="submit">जमा करना</button>
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
function action_count_grade(query_count_grade){
	var total = '<?php echo $total; ?>';
	
	var allot_qty = 0;
	$(".allot_qty_class").each(function(){
		if($(this).val() !==""){
			allot_qty +=parseInt($(this).val());
		}
	});
	
	var overall_grade = allot_qty / total;
	var overall_grade1 = parseInt(overall_grade);
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
	$('#overall_grade').val(overall_grade1);
}
</script>

<script>
$(document).ready(function(){
	$('#acr_form').on('submit', function(e){
		e.preventDefault();
		$.ajax({
			url:'query.php',
			type:'POST',
			data:$('#acr_form').serialize(),
			/*data:new FormData(this),  
			contentType:false,  
			processData:false,*/
			beforeSend:function(){
				$('#acr_button').html('Please Wait...');
			},
			success:function(data){
				if(data=='Error1'){
					$('#message').html('<p class="text-danger">Something Went Wrong!</p>');
				}else if(data=='Error'){
					$('#message').html('<p class="text-danger">Employee Appraisal Already Exist!</p>');
				}else{
					$('#acr_form')[0].reset();
					$('#message').html('<p class="text-success">Employee Appraisal Added Successfully!</p>');
					$('html, body').animate({ scrollTop: 0 }, 0);
					setInterval(function() {
						window.location.replace("view-appraisal-details?id="+data);
					}, 2000);
				}
				$('#acr_button').html('Save');
			}
		});
	});
});
</script>

<script>
function countChar(val) {
  var len = val.value.length;
  if (len >= 100) {
    val.value = val.value.substring(0, 100);
  } else {
    $('#charNum').text(100 - len);
  }
};
</script>

      
    </body>
</html>