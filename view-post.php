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
        <title>View Post | GB Pant</title>
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

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">View Post</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Post</a></li>
                                            <li class="breadcrumb-item active">View Post</li>
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
										<h4 id="message"></h4>
										<div class="row pt-2">
											
											<div class="col-lg-12">
												<div class="responsive-table-plugin">
													<div id="refesh_section">
														<div class="table-responsive">
															<table class="table table-striped" id="datatable">
																<thead>
																	<tr class="text-nowrap bg-primary text-white">
																		<th>#</th>
																		<th>Post ENGLISH</th>
																		<th>Post HINDI</th>
																		<th>Reporting Authority</th>
																		<th>No of Post Allowed</th>
																		<th>Action</th>
																	</tr>
																</thead>
																<tbody id="post_data">
																<?php
																$i=1;
																$output = '';
																$query="select * from post order by post_name_en asc";
																$row=$db->select($query);
																while($record=$row->fetch_array()){
																	
																	$query1="select post_name from post where id='".$record['reporting_authority']."'";
																	$row1=$db->select($query1);
																	if($row1->num_rows > 0){
																		$record1=$row1->fetch_array();
																		$reporting_authority = $record1['post_name'];
																	}else{
																		$reporting_authority = '';
																	}
																	
																	
																	$output .= '<tr>
																		<td>'.$i.'</td>
																		<td>'.$record['post_name_en'].'</td>
																		<td>'.$record['post_name'].'</td>
																		<td>'.$reporting_authority.'</td>
																		<td>'.$record['no_of_post'].'</td>
																		<td>
																			<form method="POST" action="post" target="_blank">
																				<input type="hidden" name="id" value="'.base64_encode($record['id']).'">
																				<button type="submit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></button>
																			</form>
																			
																			<a href="javascript:;" class="btn btn-danger btn-sm" onclick="return deleteconfig('.$record['id'].')"><i class="fa fa-trash"></i></a>
																		</td>
																	</tr>';
																$i++;
																}
																echo $output;
																?>
																</tbody>
															</table>
														</div>
													</div>
													
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
	var action_work_location_view_post = 'fetch_work_location_name';
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
				$('#post_data').html(data);
				$('#search_button').html('Search');
			}
		});
	});
});
</script>

<script>
	function deleteconfig(id){
		var del=confirm("Are you sure you want to delete this record?");
		if (del==true){
			var action_post = 'delete_post';
			$.ajax({
				url:"query.php",
				method:"POST",
				data:{action_post:action_post, id:id},
				success:function(data){
					if(data=='Success'){
						$('#refesh_section').load(' #refesh_section');
						$('#message').html('<p class="text-success">Post Deleted Successfully!</p>');
					}else{
						$('#message').html('<p class="text-danger">'+data+'</p>');
					}
					$('html, body').animate({ scrollTop: 0 }, 'slow');
				}
			})
		}
		else{}
		return del;
	}
</script>
       
    </body>
</html>