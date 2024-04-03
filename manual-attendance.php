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
	<title>Manual Attendance | UKPN</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
	<meta content="Coderthemes" name="author" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!-- App favicon -->
	<link rel="shortcut icon" href="assets/images/favicon.ico">

	<!-- Responsive Table css -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-stylesheet" />
	<link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />

	<!-- icons -->
	<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<style>
th{
	font-size: 14px;
}
td{
	font-size: 13px;
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
                                    <h4 class="page-title">Manual Attendance</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Attendance</a></li>
                                            <li class="breadcrumb-item active">Manual Attendance</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form id="attendance_request_approval_form">
											<div class="row pt-2">
												<div class="col-lg-4">
													<label>Date</label>
													<input type="date" name="attendance_date" value="<?= date("Y-m-d"); ?>" onchange="action16(this.value)" class="form-control" max="<?= date("Y-m-d"); ?>">
												</div>
											</div>
                                        
											<div class="row pt-2">
												
												<div class="col-lg-12" id="message"></div>
												<div class="col-lg-12">
													
														<div class="table-responsive">
															<table class="table table-sm mb-0">
																<thead>
																	<tr class="bg-primary text-white">
																		<th><input type="checkbox" id="checkAll"></th>
																		<th>Employee Code</th>
																		<th>Employee Name</th>
																		<th>Work Location</th>
																		<th>Division / Deport</th>
																		<th>Employee Category</th>
																	</tr>
																</thead>
																<tbody id="attendance_request_data">
																	<?php
																	$attendance_date = date("Y-m-d");
																	
																	$output = '';
																	$i=0;
																	
																	if($_SESSION['astro_role']=='Division'){
																		$query1="select * from division where phone='".$_SESSION['astro_email']."'";
																		$row1=$db->select($query1);
																		$record1=$row1->fetch_array();
																		
																		$query="select * from employee where attendance_type='Manual' and work_location='Division' and office_name='".$record1['id']."'";
																		
																		$division_deport = $record1['division'];
																	}else if($_SESSION['astro_role']=='Depot'){
																		$query2="select * from deport where phone='".$_SESSION['astro_email']."'";
																		$row2=$db->select($query2);
																		$record2=$row2->fetch_array();
																		
																		$query="select * from employee where attendance_type='Manual' and work_location='Deport' and office_name='".$record1['id']."'";
																		$division_deport = $record2['deport'];
																	}else if($_SESSION['astro_role']=='Head Quarter'){
																		$query="select * from employee where attendance_type='Manual' and work_location='Head Quarter'";
																		$division_deport = '';
																	}else{
																		$query="select * from employee where attendance_type='Manual'";
																		$division_deport = '';
																	}
																	$row=$db->select($query);
																	if ($row->num_rows > 0) {
																		while($record=$row->fetch_array())
																		{
																			if($record['work_location']=='Division'){
																				$query1="select * from division where id='".$record['office_name']."'";
																				$row1=$db->select($query1);
																				$record1=$row1->fetch_array();
																				
																				$division_deport = $record1['division'];
																			}else if($record['work_location']=='Depot'){
																				$query1="select * from deport where id='".$record['office_name']."'";
																				$row1=$db->select($query1);
																				$record1=$row1->fetch_array();
																				
																				$division_deport = $record1['deport'];
																			}else{
																				$division_deport = '';
																			}
																			
																			$query3="select * from emp_category where id='".$record['employee_category']."'";
																			$row3=$db->select($query3);
																			$record3=$row3->fetch_array();
																			
																			$query4="select * from manual_attendance where employee='".$record['phone']."' and attendance_date='".$attendance_date."'";
																			$row4=$db->select($query4);
																			if ($row4->num_rows > 0){
																				$output .='<tr>
																					<td></td>
																					<td>'.$record['employee_code'].'</td>
																					<td>'.$record['employee_name'].'</td>
																					<td>'.$record['work_location'].'</td>
																					<td>'.$division_deport.'</td>
																					<td>'.$record3['category'].'</td>
																				</tr>';
																			}else{
																				$output .='<tr>
																					<td><input type="checkbox" class="checkAllData" name="employee[]" value="'.$record['phone'].'"></td>
																					<td>'.$record['employee_code'].'</td>
																					<td>'.$record['employee_name'].'</td>
																					<td>'.$record['work_location'].'</td>
																					<td>'.$division_deport.'</td>
																					<td>'.$record3['category'].'</td>
																				</tr>';
																				
																				$i++;
																			}
																		}
																		
																		if($i > 0){
																			$output .='<tr>
																				<td colspan="8">
																					<input type="hidden" name="add_manual_attendance" value="add_manual_attendance">
																					<button type="submit" id="attendance_request_approval_button" class="btn btn-primary btn-sm">Make Attendance</button>
																				</td>
																			</tr>';
																		}
																	}
																	echo $output;
																	?>
																</tbody>
															</table>
														</div>
													
												</div>
											   
											</div>
										</form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
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
function action16(query16){
	if(query16 != ''){
		var ToDate = '<?= date("Y-m-d"); ?>';
		if(query16 > ToDate){
			alert("Date is Greater than Today");
			$('#attendance_request_data').html(data);
		}else{
			var action16 = 'fetch_manual_attendance';
			$.ajax({
				url:"query.php",
				method:"POST",
				data:{action16:action16, query16:query16},
				success:function(data){
					//alert(data);
					$('#attendance_request_data').html(data);
				}
			})
		}
	    
	}
}
</script>     

<script>
function action9(query9){
	if(query9 != ''){
	    var action9 = 'regulize_popup';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action9:action9, query9:query9},
			success:function(data){
			    //location.reload();
			    //alert(data);
			    $('#view_request_details').html(data);
			    $('#view_request_popup').modal('show');
			}
		})
	}
}
</script>     

<div class="modal fade show" id="view_request_popup" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="regulize_form">
            <div class="modal-content" id="view_request_details">
                
            </div>
        </form>
    </div>
</div>

<script>
$("#checkAll").click(function(){
    $('.checkAllData').not(this).prop('checked', this.checked);
});
</script>

<script>
$(document).ready(function(){
	$('#attendance_request_approval_form').on('submit', function(e){
		e.preventDefault();
		$.ajax({
			url:'query',
			type:'POST',
			data:$('#attendance_request_approval_form').serialize(),
			beforeSend:function(){
				$('#attendance_request_approval_button').html('Please Wait...');
			},
			success:function(data){
				//alert(data);
				if(data=='Success'){
					$('#message').html('<span class="text-success">Attendance Made Successfully!</span>');
					$('#attendance_request_approval_form')[0].reset();
					//setInterval(function() {}
					setTimeout(function() {
					    //alert(data);
						location.reload();
					}, 1000);
				}else{
					$('#message').html('<span class="text-danger">'+data+'</span>');
				}
				$('#attendance_request_approval_button').html('Make Attendance');
			}
		});
	});
});
</script>

    </body>
</html>