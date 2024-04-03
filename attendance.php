<?php
include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}

$query2 = "SELECT * FROM `employee` WHERE employee_code = '".$_SESSION['astro_email']."'";
$row2 = $db->select($query2);
$record2 = $row2->fetch_array();

$query3 = "SELECT * FROM `department` WHERE id = '".$record2['department']."'";
$row3 = $db->select($query3);
$record3 = $row3->fetch_array();

$query11 = "SELECT * FROM `attendance` WHERE employee = '".$_SESSION['astro_email']."' and attendance_date='".date("Y-m-d")."'";
$row11 = $db->select($query11);
if($row11->num_rows > 0){
	$record11 = $row11->fetch_array();
	
	$check_in = $record11['check_in'];
	$check_out = $record11['check_out'];
}else{
	$check_in = '';
	$check_out = '';
}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Attendance | UKPN</title>
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
                                    <h4 class="page-title">Attendance</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Attendance</a></li>
                                            <li class="breadcrumb-item active">Attendance</li>
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
                                        <ul class="nav nav-pills navtab-bg">
                                            <li class="nav-item">
                                                <a href="#general-q-tab" data-bs-toggle="tab" aria-expanded="false" class="nav-link px-3 py-2 active">
                                                    <span class="d-none1 d-sm-inline-block">Attendance Log</span>   
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#privacy-p-tab" data-bs-toggle="tab" aria-expanded="true" class="nav-link px-3 py-2">
                                                    <span class="d-none1 d-sm-inline-block">Attendance Request</span> 
                                                </a>
                                            </li>
                                            
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active show" id="general-q-tab">
                                                <div class="row pt-2">
                                                    <div class="col-lg-12">
                                                        <div class="table-responsive">
															<table class="table table-sm mb-0">
																<thead>
																	<tr class="table-active">
																		<th>Date</th>
																		<th>Check-In</th>
																		<th>Check-Out</th>
																		<th>Location</th>
																		<th>Effective Hour</th>
																		<th>Arrival</th>
																		<th></th>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	$today=date('Y-m-d');
																	$last_date=date('Y-m-d', strtotime('-30 days'));
																	for($i=$today; $i > $last_date; ($i = date('Y-m-d', strtotime('-1 days', strtotime($i))))){
																	    $day_name = date('D', strtotime($i));
																	    if($day_name == 'Sun'){
																	    ?>
																			<tr class="bg-info text-white">
																				<td><?= date("D - d M, y",strtotime($i)); ?></td>
																				<td colspan="4" class="text-center">Weekly Off</td>
																				<td colspan="2"></td>
																			</tr>
																		<?php  
																	    }else{
																	        $query4 = "SELECT * FROM `attendance` WHERE employee = '".$_SESSION['astro_email']."' and attendance_date='$i'";
    																		$row4 = $db->select($query4);
    																		if ($row4->num_rows > 0) {
    																			$record4 = $row4->fetch_array();
    																			
    																			$query5 = "SELECT * FROM `employee` where email='".$record4['employee']."'";
    																			$row5 = $db->select($query5);
    																			$record5 = $row5->fetch_array();
    																			
    																			$check_in = $record4['check_in'];
    																			//$check_out1 = $record4['check_out'];
    
    																			if($record4['check_out']==NULL){
    																				$hour = '0h 0m';
    																			}else{
    																				$check_out = $record4['check_out'];
    																				
    																				$diff = abs(strtotime($check_in) - strtotime($check_out));
    																				$tmins = $diff/60;
    																				$hours = floor($tmins/60);
    																				$mins = $tmins%60;
    																				
    																				$hour = $hours.'h '.$mins.'m';
    																			}
    																			
    																			if(strtotime($check_in) <= strtotime('09:30 AM')){
    																				$arrival = 'On Time';
    																			}else{
    																				$arrival1 = abs(strtotime('09:30 AM') - strtotime($check_in));
    																				
    																				$tmins1 = $arrival1/60;
    																				$hours1 = floor($tmins1/60);
    																				$mins1 = $tmins1%60;
    																				
    																				$arrival = $hours1.'h '.$mins1.'m late';
    																			}
    																		?>
    																			<tr>
    																				<td><?= date("D - d M, Y",strtotime($i)); ?></td>
    																				<td><?= $record4['check_in']; ?></td>
    																				<td><?= $record4['check_out']; ?></td>
    																				<td><a href="#"><i class="fa fa-map-marker-alt"></i></a></td>
    																				<td><?= $hour; ?></td>
    																				<td><?= $arrival; ?></td>
    																				<td>
    																				    <?php
    																				    if($record4['check_out']==NULL){
    																				    ?>
    																				        <div class="dropdown float-end">
                                                                                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false" title="Absent">
                                                                                                    <i class="fa fa-exclamation-triangle text-warning" style="font-size: 13px;"></i>
                                                                                                </a>
                                                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                                                    <a href="javascript:void(0);" onclick="action8('<?= $i; ?>')" class="dropdown-item">Regularize</a>
                                                                                                    <a href="javascript:void(0);" class="dropdown-item"><i class="fa fa-arrow-right text-success" style="transform: rotate(135deg);"></i> <?= $record4['check_in']; ?></a>
                                                                                                </div>
                                                                                            </div>
    																				    <?php   
    																				    }else{
    																				    ?>
    																				        <div class="dropdown float-end">
                                                                                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false" title="Present">
                                                                                                    <i class="fa fa-check-circle text-success" style="font-size: 15px;"></i>
                                                                                                </a>
                                                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                                                    <a href="javascript:void(0);" class="dropdown-item"><i class="fa fa-arrow-right text-success" style="transform: rotate(135deg);"></i> <?= $record4['check_in']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-right text-danger" style="transform: rotate(315deg);"></i> <?= $record4['check_out']; ?></a>
                                                                                                </div>
                                                                                            </div>
    																				    <?php
    																				    }
    																				    ?>
    																				</td>
    																			</tr>
    																		<?php
    																		}else{
    																		?>
    																			<tr>
    																				<td><?= date("D - d M, y",strtotime($i)); ?></td>
    																				<td>--:--</td>
    																				<td>--:--</td>
    																				<td>-----</td>
    																				<td>-----</td>
    																				<td>-----</td>
    																				<td>
    																				    <div class="dropdown float-end">
                                                                                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false" title="Absent">
                                                                                                <i class="fa fa-exclamation-triangle text-warning" style="font-size: 13px;"></i>
                                                                                            </a>
                                                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                                                <a href="javascript:void(0);" onclick="action8('<?= $i; ?>')" class="dropdown-item">Regularize</a>
                                                                                            </div>
                                                                                        </div>
    																				</td>
    																			</tr>
    																		<?php
    																		}
																	    }
																	    
																		
																	}
																	?>
																	
																</tbody>
															</table>
														</div> 
                                                    </div>
                                                   
                                                </div>
                                                <!-- end row -->
    
                                            </div>
                                            
                                            
                                            <div class="tab-pane fade" id="privacy-p-tab">
                                                <div class="row pt-2">
                                                    <div class="col-lg-12">
                                                        <div class="table-responsive">
            												<table class="table table-sm">
            													<thead>
            														<tr class="table-active">
            															<th>Date</th>
            															<th>Request Type</th>
            															<th>Requested ON</th>
            															<th>Note</th>
            															<th>Status</th>
            															<th>Action Taken By</th>
            															<th>Action</th>
            														</tr>
            													</thead>
            													<tbody>
            														<?php
            														$i=1;
            														$query="select * from regulization_request where employee='".$_SESSION['astro_email']."' order by requested_date desc";
            														$row=$db->select($query);
            														while($record=$row->fetch_array()){
            														?>
            															<tr>
            																<td><?= date("D - d M, y",strtotime($record['requested_date'])); ?></td>
            																<td>Attendance Regulization</td>
            																<td>
																				<?= date("d M, y h:i A",strtotime($record['requested_on'])); ?>
																				<br /><?= $_SESSION['astro_name']; ?>
																			</td>
            																<td><?= $record['request']; ?></td>
            																<td>
																				<?php
																				if($record['is_approved']=='1'){
																					echo '<span class="text-success">Approved</span>';
																				}else{
																					echo '<span class="text-danger">Pending</span>';
																				}
																				?>
																			</td>
            																<td>
																				<?= $record['action_taken_by']; ?>
																				<br />
																				<?php
																				if($record['action_taken_on']!=NULL){
																					echo date("d M, y",strtotime($record['action_taken_on']));
																				}
																				?>
																			</td>
            																<td>
            																	<div class="dropdown float-end">
                                                                                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false" title="Absent" style="line-height: 1;">
                                                                                        <i class="mdi mdi-dots-horizontal"></i>
                                                                                    </a>
                                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                                        <a href="javascript:void(0);" onclick="action9(<?= $record['id']; ?>)" class="dropdown-item">View Request</a>
                                                                                    </div>
                                                                                </div>
            																</td>
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
                                                <!-- end row -->
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
function action41(query41,lat,long1){
	if(query41 != ''){
		var action41 = 'employee_checkin';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action41:action41, query41:query41, lat:lat, long1:long1},
			success:function(data){
			    location.reload();
			}
		})
	}
}
</script>     

<script>
function action8(query8){
	if(query8 != ''){
	    //alert(query8);
		var action8 = 'regulize_popup';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action8:action8, query8:query8},
			success:function(data){
			    //location.reload();
			    //alert(data);
			    $('#regulize_popup_data').html(data);
			    $('#regulize_popup_modal').modal('show');
			}
		})
	}
}
</script>   

<div class="modal fade show" id="regulize_popup_modal" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="regulize_form">
            <div class="modal-content" id="regulize_popup_data">
                
            </div>
        </form>
    </div>
</div>


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
$(document).ready(function(){
	$('#regulize_form').on('submit', function(e){
		e.preventDefault();
		$.ajax({
			url:'query',
			type:'POST',
			data:$('#regulize_form').serialize(),
			beforeSend:function(){
				$('#regulize_button').html('Please Wait...');
			},
			success:function(data){
				//alert(data);
				if(data=='Success'){
					$('#message').html('<span class="text-success">Regulization Requested Successfully!</span>');
					$('#regulize_form')[0].reset();
					//setInterval(function() {}
					setTimeout(function() {
					    //alert(data);
						$('#regulize_popup_modal').modal('hide');
					}, 1000);
				}else{
					$('#message').html('<span class="text-danger">'+data+'</span>');
				}
				$('#regulize_button').html('Request');
			}
		});
	});
});
</script>

    </body>
</html>