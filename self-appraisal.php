<?php
include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}
$query_1="select * from employee where employee_code='".$_SESSION['astro_email']."'";
$row_1=$db->select($query_1);
$record_1=$row_1->fetch_array();

$query_2="select * from post where id='".$record_1['post']."'";
$row_2=$db->select($query_2);
$record_2=$row_2->fetch_array();

//$query_3="select * from acr where present_post='".$record_1['post']."' and reporting_authority_work_location='".$record_1['work_location']."' and reporting_office_name='".$record_1['office_name']."'";
$query_3="select * from acr where present_post='".$record_1['post']."' and work_location='".$record_1['work_location']."' and office_name='".$record_1['office_name']."'";
$row_3=$db->select($query_3);
if($row_3->num_rows > 0){
    $record_3=$row_3->fetch_array();
    $acr_id = $record_3['id'];
}else{
    $acr_id = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Self Appraisal | UKPN</title>
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
                                    <h4 class="page-title">New Self Appraisal</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Self Appraisal</a></li>
                                            <li class="breadcrumb-item active">New Self Appraisal</li>
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
												
												<div class="col-md-4 mb-3">
													<label class="form-label">वर्ष </label>
													<select name="year" class="form-control" onchange="action_acr_date_range(this.value)" required>
														<option value="">~~~चुनें ~~~</option>
														<?php
														if($record_1['office_name']!='' && $record_1['office_name']!=NULL){
														    $query="select * from acr where present_post='".$record_1['post']."' and work_location='".$record_1['work_location']."' and office_name='".$record_1['office_name']."'";
														}else{
														    $query="select * from acr where present_post='".$record_1['post']."' and work_location='".$record_1['work_location']."'";
														}
														$row=$db->select($query);
														while($record=$row->fetch_array()){
															$query1="select * from self_appraisal where employee='".$_SESSION['astro_email']."' and year='".$record['year']."'";
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
												
												<div class="col-md-8 mb-3">
													<div class="row" id="acr_date_range_data">
														<div class="col-md-6">
															<label class="form-label">दिनांक </label>
															<input type="date" name="from_date"class="form-control" required>
														</div>
														<div class="col-md-6">
															<label class="form-label">से दिनांक </label>
															<input type="date" name="to_date" class="form-control" required>
														</div>
													</div>
												</div>
												
												<?php
												//$record_2['level']=10;
												if($record_2['level']=='2' || $record_2['level']=='3' || $record_2['level']=='4' || $record_2['level']=='5' || $record_2['level']=='6' || $record_2['level']=='7'){
												?>
													<div class="col-md-12">
														<div class="table-responsive">
															<table class="table table-bordered table-hover" id="invoiceItem">
																<thead>
																	<tr>
																		<th colspan="4" width="100%">आलोच्य अवधि में आवंटित उत्तरदायित्वों का सार अंकित  किया जाय। </th>
																	</tr>
																	<tr>
																		<th width="2%">#</th>
																		<th width="2%"><input id="checkAll" class="formcontrol" type="checkbox"></th>
																		<th>समयावधि </th>
																		<th>आवंटित उत्तरदायित्व </th>
																	</tr>
																</thead>
																<tbody>
																	<tr id="delivery_order_1">
																		<td>1</td>
																		<td></td>
																		<td><input type="text" name="period[]" class="form-control"></td>
																		<td><input type="text" name="alloted_responsibility[]" class="form-control"></td>
																	</tr>
																</tbody>
																<tfoot>
																	<tr>
																		<td colspan="3">
																			<button class="btn btn-danger btn-sm delete" id="removeRows" type="button">- Remove</button>
																			<button class="btn btn-success btn-sm" id="addRows" type="button">+ Add More</button>
																		</td>
																	</tr>
																</tfoot>
														   </table>
														</div>
														
													</div>
													<div class="col-md-12">
														<div class="table-responsive">
															<table class="table table-bordered table-hover">
																<tr>
																	<th width="100%" colspan="3">वार्षिक कार्य योजना और उपलब्धि </th>
																</tr>
																<tr>
																	<th width="2%">#</th>
																	<th>विषय </th>
																	<!--th>Last Year</th-->
																	<th>वर्तमान वर्ष </th>
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
																			<input type="hidden" name="task_to_be_performed[]" value="<?= $record4['work']; ?>" class="form-control">
																		</td>
																		<td>
																			<input type="text" name="actual_achievement[]" class="form-control" required>
																		</td>
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
												<div class="col-md-12 mb-3">
													<hr>
													<label class="form-label">अवधि के दौरान प्राप्त उपलब्धियां / कार्यों का संक्षिप्त विवरण :</label><br />
													<small>इस भाग में सम्बंधित अधिकारी द्वारा कृत कार्य के सम्बन्ध में स्वतः मूल्यांकन अधिकतम 300 शब्दों में अंकित किया जायेगा </small>
													<textarea name="description" class="form-control" rows="7"></textarea>
												</div>
												
												<div class="col-md-12 mb-3">
													<label>स्वः मूल्यांकन प्रति </label><br />
													<img src="" id="output_image" style="width: 50%; height: auto;"><br/>
													<input name="self_appraisal_copy" onchange="preview_image(event)" type="file" accept="image/*">
												</div>
												
												<div class="col-md-6">
													<label>पुरस्कार / सम्मान </label><br />
													<input name="award" type="file">
												</div>
												<div class="col-md-6"></div>
												
											</div>
                                            <input type="hidden" name="acr_id" value="<?= $acr_id; ?>">
                                            <input type="hidden" name="employee" value="<?= $_SESSION['astro_email']; ?>">
                                            <input type="hidden" name="add_self_appraisal" value="add_self_appraisal">
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
					$('#message').html('<p class="text-success">Self Appraisal Added Successfully!</p>');
					$('#department_form')[0].reset();
				}else if(data=='Error'){
					$('#message').html('<p class="text-danger">Self Appraisal Already Submitted!</p>');
				}else{
					$('#message').html('<p class="text-danger">'+data+'</p>');
				}
				$('#department_button').html('Save');
			}
		});
	});
});
</script>

<script type='text/javascript'>
function preview_image(event) 
{
 var reader = new FileReader();
 reader.onload = function()
 {
  var output = document.getElementById('output_image');
  output.src = reader.result;
  document.getElementById('profile_image_data').value='1';
  
 }
 reader.readAsDataURL(event.target.files[0]);
}
</script>


<script>
 $(document).ready(function(){
	$(document).on('click', '#checkAll', function() {          	
		$(".itemRow").prop("checked", this.checked);
	});	
	$(document).on('click', '.itemRow', function() {  	
		if ($('.itemRow:checked').length == $('.itemRow').length) {
			$('#checkAll').prop('checked', true);
		} else {
			$('#checkAll').prop('checked', false);
		}
	});  
	var count = $(".itemRow").length;
	$(document).on('click', '#addRows', function() { 
		count++;
		
		var count1 = count + 1;
		var htmlRows = '';
		htmlRows += '<tr id="delivery_order_'+count+'">';
		htmlRows += '<td>'+count1+'</td>';
		htmlRows += '<td><input class="itemRow" type="checkbox"></td>';
		htmlRows += '<td><input type="text" name="period[]" class="form-control"></td>';
		htmlRows += '<td><input type="text" name="alloted_responsibility[]" class="form-control"></td>';
		
		htmlRows += '</tr>';
			$('#invoiceItem').append(htmlRows);
		}); 
		$(document).on('click', '#removeRows', function(){
			$(".itemRow:checked").each(function() {
				$(this).closest('tr').remove();
			});
			$('#checkAll').prop('checked', false);
			calculateTotal();
		});		
		
		$(document).on('blur', "#amountPaid", function(){
			var amountPaid = $(this).val();
			var totalAftertax = $('#totalAftertax').val();	
			if(amountPaid && totalAftertax) {
				totalAftertax = totalAftertax-amountPaid;			
				$('#amountDue').val(totalAftertax);
			} else {
				$('#amountDue').val(totalAftertax);
			}	
		});	
		$(document).on('click', '.deleteInvoice', function(){
			var id = $(this).attr("id");
			if(confirm("Are you sure you want to remove this?")){
				$.ajax({
					url:"action.php",
					method:"POST",
					dataType: "json",
					data:{id:id, action:'delete_invoice'},				
					success:function(response) {
						if(response.status == 1) {
							$('#'+id).closest("tr").remove();
						}
					}
				});
			} else {
				return false;
			}
		});
	 });	
  </script>
      
    </body>
</html>