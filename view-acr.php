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
        <title>View ACR | GB Pant</title>
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
                                    <h4 class="page-title">View ACR</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">ACR</a></li>
                                            <li class="breadcrumb-item active">View ACR</li>
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
										<?php
										if($_SESSION['astro_role']=='Admin'){
										?>
											<div class="col-lg-12">
												<form id="department_form">
													<div class="row">
														<div class="col-md-4 mb-2">
															<label>Work Location</label>
															<select name="work_location" id="work_location" onchange="action_work_location_view_post(this.value)" class="form-control">
																<option value="">~~~Choose~~~</option>
																<?php
																$query="select * from work_location";
																$row=$db->select($query);
																while($record=$row->fetch_array()){
																?>
																	<option value="<?= $record['work_location']; ?>"><?= $record['work_location_name']; ?></option>
																<?php
																}
																?>
															</select>
														</div>
														<div class="col-md-8" id="work_location_name">
															<br />
															<input type="hidden" name="search_acr_data" value="search_acr_data">
															<button type="submit" id="search_button" class="btn btn-success">Search</button>
														</div>
													</div>
												</form>
											</div>
										<?php
										}
										?>
										
										<div class="col-lg-12">
											<div class="responsive-table-plugin" id="employee_data">
												<div class="table-responsive">
													<table class="table table-bordered">
														<thead>
															<tr class="text-nowrap bg-primary text-white">
																<th>#</th>
																<th>ए० सी० आर० वर्ष</th>
																<th>पदनाम</th>
																<th>कार्य स्थल</th>
																<th>कॉलेज का नाम</th>
																<th>प्रतिवेदक प्राधिकारी</th>
																<th>समीक्षक प्राधिकारी</th>
																<th>स्वीकर्ता प्राधिकारी</th>
																<?php
																if($_SESSION['astro_role']=='Admin'){
																	echo '<th>Action</th>';
																}
																?>
															</tr>
														</thead>
														<tbody>
															<?php
															$i=1;
															if($_SESSION['astro_role']=='Division'){
																$query21="select id from division where phone='".$_SESSION['astro_email']."'";
																$row21=$db->select($query21);
																$record21=$row21->fetch_array();
																$office_name=$record21['id'];
																
																$query="select * from acr where work_location='".$_SESSION['astro_role']."' and office_name='$office_name' order by id desc";
															}else if($_SESSION['astro_role']=='Deport'){
																$query21="select id from deport where phone='".$_SESSION['astro_email']."'";
																$row21=$db->select($query21);
																$record21=$row21->fetch_array();
																$office_name=$record21['id'];
																
																$query="select * from acr where work_location='Depot' and office_name='$office_name' order by id desc";
															}else if($_SESSION['astro_role']=='Head Quarter'){
																$office_name='';
																
																$query="select * from acr where work_location='".$_SESSION['astro_role']."' and office_name='$office_name' order by id desc";
															}else{
																$query="select * from acr order by id desc";
															}
															//$query="select * from acr order by id desc";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
																$query2="select * from post where id='".$record['present_post']."'";
																$row2=$db->select($query2);
																$record2=$row2->fetch_array();
																
																$query1="select * from employee where employee_code='".$record['reporting_authority_name']."'";
																$row1=$db->select($query1);
																$record1=$row1->fetch_array();
																
																$query3="select * from employee where employee_code='".$record['reviewing_authority_name']."'";
																$row3=$db->select($query3);
																$record3=$row3->fetch_array();
																
																$query4="select * from employee where employee_code='".$record['accepting_authority_name']."'";
																$row4=$db->select($query4);
																$record4=$row4->fetch_array();
																
																$query5="select * from post where id='".$record['reporting_authority_post']."'";
																$row5=$db->select($query5);
																$record5=$row5->fetch_array();
																
																$query6="select * from post where id='".$record['reviewing_authority_post']."'";
																$row6=$db->select($query6);
																$record6=$row6->fetch_array();
																
																$query7="select * from post where id='".$record['accepting_authority_post']."'";
																$row7=$db->select($query7);
																$record7=$row7->fetch_array();
																
																if($record['work_location']=='Division'){
																	$query8="select * from division where id='".$record['office_name']."'";
																	$row8=$db->select($query8);
																	if($row8->num_rows > 0){
																		$record8=$row8->fetch_array();
																		$office_name = $record8['division'];
																	}else{
																		$office_name = '';
																	}
																}else if($record['work_location']=='Depot'){
																	$query8="select * from deport where id='".$record['office_name']."'";
																	$row8=$db->select($query8);
																	if($row8->num_rows > 0){
																		$record8=$row8->fetch_array();
																		$office_name = $record8['deport'];
																	}else{
																		$office_name = '';
																	}
																}else{
																	$office_name = '';
																}
															?>
																<tr>
																	<td><?= $i; ?></td>
																	<td class="nowrap"><?= $record['year']; ?></td>
																	<td><?= $record2['post_name']; ?></td>
																	<td><?= $record['work_location']; ?></td>
																	<td><?= $office_name; ?></td>
																	<td><?= $record1['employee_name'].' ('.$record5['post_name'].')'; ?></td>
																	<td><?= $record3['employee_name'].' ('.$record6['post_name'].')'; ?></td>
																	<td><?= $record4['employee_name'].' ('.$record7['post_name'].')'; ?></td>
																	<td>
																		<?php
																		if($_SESSION['astro_role']=='Admin'){
																		?>
																			<form method="POST" action="acr" target="_blank">
																				<input type="hidden" name="id" value="<?= base64_encode($record['id']); ?>">
																				<button type="submit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></button>
																			</form>
																		<?php
																		}?>
																		
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
function action_work_location_view_post(query_work_location){
	var action_work_location_view_post = 'fetch_work_location_name3';
	$.ajax({
		url:"query.php",
		method:"POST",
		data:{action_work_location_view_post:action_work_location_view_post, query_work_location:query_work_location},
		success:function(data){
			//alert(data);
			$('#work_location_name').html(data);
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
			data:$('#department_form').serialize(),
			/*data:new FormData(this),  
			contentType:false,  
			processData:false,*/
			beforeSend:function(){
				$('#search_button').html('Please Wait...');
			},
			success:function(data){
				//alert(data);
				$('#employee_data').html(data);
				$('#search_button').html('Search');
			}
		});
	});
});
</script> 
 
    </body>
</html>