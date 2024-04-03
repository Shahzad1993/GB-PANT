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
	<title>Leave Request | UKPN</title>
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
                                    <h4 class="page-title">Leave Request</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Leave</a></li>
                                            <li class="breadcrumb-item active">Leave Request</li>
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
                                        
                                        <div class="row pt-2">
											<div class="col-lg-4">
												<input type="date" value="<?= date("Y-m-d"); ?>" onchange="action14(this.value)" class="form-control">
											</div>
										</div>
                                        
										<div class="row pt-2">
											
											<div class="col-lg-12">
												<form id="attendance_request_approval_form">
													<div class="table-responsive">
														<table class="table table-sm mb-0">
															<thead>
																<tr class="table-active">
																	<th><input type="checkbox" id="checkAll"></th>
																	<th>From Date</th>
																	<th>To Date</th>
																	<th>Leave Type</th>
																	<th>Requested On</th>
																	<th>Note</th>
																	<th>Status</th>
																	<th>Action Taken By</th>
																	<!--th>Action</th-->
																</tr>
															</thead>
															<tbody id="attendance_request_data">
																<?php
																$output = '';
			
																$query="select * from leave_request where requested_on='".date("Y-m-d")."'";
																$row=$db->select($query);
																if ($row->num_rows > 0) {
																	while($record=$row->fetch_array()){
																		
																		if($_SESSION['astro_role']=='Division'){
																			$query11="select * from division where phone='".$_SESSION['astro_email']."'";
																			$row11=$db->select($query11);
																			$record11=$row11->fetch_array();
																			
																			$sql1 = "SELECT * FROM `employee` where phone='".$record['employee']."' and work_location='Division' and office_name='".$record11['id']."' and (attendance_type!='Manual' or attendance_type!=NULL)";
																		}else if($_SESSION['astro_role']=='Deport'){
																			$query11="select * from deport where phone='".$_SESSION['astro_email']."'";
																			$row11=$db->select($query11);
																			$record11=$row11->fetch_array();
																			
																			$sql1 = "SELECT * FROM `employee` where phone='".$record['employee']."' and work_location='Deport' and office_name='".$record11['id']."' and (attendance_type!='Manual' or attendance_type!=NULL)";
																		}else if($_SESSION['astro_role']=='Head Quarter'){
																			$sql1 = "SELECT * FROM `employee` where phone='".$record['employee']."' and work_location='Head Quarter' and (attendance_type!='Manual' or attendance_type!=NULL)";
																		}else{
																			$sql1 = "SELECT * FROM `employee` WHERE phone='".$record['employee']."'";
																		}
																		$exe1 = $db->select($sql1);
																		if ($exe1->num_rows > 0) {
																			$record1 = $exe1->fetch_array();
																		
																			$sql2 = "SELECT * FROM `login` WHERE mobile='".$record['action_taken_by']."'";
																			$exe2 = $db->select($sql2);
																			if ($exe2->num_rows > 0) {
																				$record2 = $exe2->fetch_array();
																				
																				$action_taken_by = $record2['name'];
																				
																				if($record['action_taken_on']!=NULL){
																					$action_taken_on = date("d M, y",strtotime($record['action_taken_on']));
																				}
																			}else{
																				$action_taken_by = '';
																				$action_taken_on = '';
																			}
																			if($record['leave_type']=='LW'){
																				$leave_type = 'Leave Without Pay';
																			}else{
																				$leave_type = $record['leave_type'];
																			}
																			
																			$output .= '<tr>
																				<td>';
																					if($record['is_approved']=='1'){
																						
																					}else{
																						$output .='<input type="checkbox" class="checkAllData" name="request_id[]" value="'.$record['id'].'">';
																					}
																				$output .='</td>
																				<td>'.date("d M, y",strtotime($record['from_date'])).'</td>
																				<td>'.date("d M, y",strtotime($record['to_date'])).'</td>
																				<td>'.$leave_type.'</td>
																				<td>'.date("d M, Y h:i A",strtotime($record['requested_on'])).'
																					<br />by '.$record1['employee_name'].'
																				</td>
																				<td>'.$record['notes'].'</td>
																				<td>';
																					if($record['is_approved']=='1'){
																						$output .= '<span class="text-success">Approved</span>';
																					}else{
																						$output .= '<span class="text-danger">Pending</span>';
																					}
																				$output .= '</td>
																				<td>'.$action_taken_by.'
																					<br />'.$action_taken_on.'</td>';
																				/*$output .= '<td>
																					<div class="dropdown float-end">
																						<a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false" title="Absent" style="line-height: 1;">
																							<i class="mdi mdi-dots-horizontal"></i>
																						</a>
																						<div class="dropdown-menu dropdown-menu-end">
																							<a href="javascript:void(0);" onclick="action9('.$record['id'].')" class="dropdown-item">View Request</a>
																						</div>
																					</div>
																				</td>';*/
																			$output .= '</tr>';
																		}
																		
																	}
																	$output .='<tr>
																			<td colspan="8">
																				<input type="hidden" name="leave_request_approval" value="leave_request_approval">
																				<button type="submit" id="attendance_request_approval_button" class="btn btn-primary btn-sm">Approve</button></td>
																		</tr>';
																}
																echo $output;
																?>
															</tbody>
														</table>
													</div>
												</form>
											</div>
										   
										</div>
										
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
function action14(query14){
	if(query14 != ''){
	    var action14 = 'fetch_leave_request';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action14:action14, query14:query14},
			success:function(data){
				//alert(data);
			    $('#attendance_request_data').html(data);
			}
		})
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
					$('#message').html('<span class="text-success">Request Arroved Successfully!</span>');
					$('#attendance_request_approval_form')[0].reset();
					//setInterval(function() {}
					setTimeout(function() {
					    //alert(data);
						location.reload();
					}, 1000);
				}else{
					$('#message').html('<span class="text-danger">'+data+'</span>');
				}
				$('#attendance_request_approval_button').html('Approve');
			}
		});
	});
});
</script>

    </body>
</html>