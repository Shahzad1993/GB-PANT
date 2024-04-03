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
        <title>Change Password | UKPN</title>
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
            <?php include "inc/sidebar.php"; ?>
            <div class="content-page">
                <div class="content">
					<div class="container-fluid">
						
							<div class="row">
								<div class="col-12">
									<div class="page-title-box">
										<h4 class="page-title">Change Password</h4>
										<div class="page-title-right">
											<ol class="breadcrumb m-0">
												<li class="breadcrumb-item"><a href="javascript: void(0);">Employee</a></li>
												<li class="breadcrumb-item active">New Employee</li>
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
												<div class="row">
													<div class="col-md-4">
														<div class="row">
															<div class="col-md-12"></div>
															<div class="col-md-12 mb-3">
																<label class="form-label">Old Password</label>
																<input type="password" name="old_password" id="old_password" class="form-control" placeholder="******">
															</div>
															<div class="col-md-12 mb-3">
																<label class="form-label">New Password</label>
																<input type="password" name="new_password" id="new_password" class="form-control" placeholder="******">
															</div>
															<div class="col-md-12 mb-3">
																<label class="form-label">Confirm Password</label>
																<input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="******">
																
															</div>
															
														</div>
													</div>
													
												</div>
												
												<input type="hidden" name="update_password" value="update_password">
												<button id="department_button" class="btn btn-primary" type="submit">Update</button>
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
		if($('#old_password').val() == ''){
			//$('.form-control').css('border', '1px solid #ced4da');
			$('#old_password').css('border', '1px solid #ff0000');
			$('#old_password').focus();
		}else if($('#new_password').val() == ''){
			$('.form-control').css('border', '1px solid #ced4da');
			$('#new_password').css('border', '1px solid red');
			$('#new_password').focus();
		}else if($('#confirm_password').val() == ''){
			$('.form-control').css('border', '1px solid #ced4da');
			$('#confirm_password').css('border', '1px solid red');
			$('#confirm_password').focus();
		}else{
			$('.form-control').css('border', '1px solid #ced4da');
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
						$('#message').html('<p class="text-success">Password Updated Successfully!</p>');
						$('#department_form')[0].reset();
					}else if(data=='error'){
						$('#message').html('<p class="text-danger">New Password and Confirm Password not Maching!</p>');
					}else if(data=='error1'){
						$('#message').html('<p class="text-danger">Invalid Password!</p>');
					}else{
						$('#message').html('<p class="text-danger">'+data+'</p>');
					}
					$('#department_button').html('Update');
					
				}
			});
		}
		
		
	});
});
</script>

<script type="text/javascript">
    $(function () {
        $(".block_alpha").keypress(function (e) {
            var keyCode = e.keyCode || e.which;
			var regex = /^[.0-9]+$/;
			//var regex = /^[0-9]+$/;
			var isValid = regex.test(String.fromCharCode(keyCode));
            return isValid;
        });
    });
</script>

<script>
function action_no_of_family(query_no_of_family){
	var action_no_of_family = 'fetch_no_of_family';
	
	if(query_no_of_family > 6){
		$('#dependent_error').html('Dependent can not more than 6!');
	}else{
		$('#dependent_error').html('');
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action_no_of_family:action_no_of_family, query_no_of_family:query_no_of_family},
			success:function(data){
				//alert(data);
				$('#no_of_family_data').html(data);
			}
		})
	}
	
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
		
		var htmlRows = '';
		htmlRows += '<tr id="lic_list_'+count+'">';
			htmlRows += '<td><input class="itemRow" type="checkbox" value="delivery_id'+count+'"></td>';
			htmlRows += '<td><input type="text" name="lic_number[]" class="form-control" placeholder="LIC Number"></td>';          
			htmlRows += '<td><input type="text" name="lic_premium[]" class="form-control block_alpha" placeholder="LIC Premium"></td>';          
		htmlRows += '</tr>';
		$('#lic_list_data').append(htmlRows);
	}); 
	$(document).on('click', '#removeRows', function(){
		$(".itemRow:checked").each(function() {
			$(this).closest('tr').remove();
		});
		$('#checkAll').prop('checked', false);
		calculateTotal();
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

<script>
function action3_2(query3_2){
	if(query3_2 != ''){
		var action3_2 = 'fetch_post';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action3_2:action3_2, query3_2:query3_2},
			success:function(data){
				//alert(data);
				$('#post').html(data);
			}
		})
	}else{
		$('#post').html('<option value="">~~~Choose~~~</option>');
	}
}
</script>
      
    </body>
</html>