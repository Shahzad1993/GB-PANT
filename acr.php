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
        <title>ACR | GB Pant</title>
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
                                    <h4 class="page-title">New ACR</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">ACR</a></li>
                                            <li class="breadcrumb-item active">New ACR</li>
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
											<?php
											if(isset($_POST['id']) && $_SESSION['astro_role']=='Admin'){
												$query_acr="select * from acr where id='".base64_decode($_POST['id'])."'";
												$row_acr=$db->select($query_acr);
												$record_acr=$row_acr->fetch_array();
												
												$year = explode('-',$record_acr['year']);
												$year_p = $year[0];
												$year_c = $year[1];
											?>
												<div class="row">
													<div class="col-md-3">
														<label class="form-label">ए० सी० आर० वर्ष</label>
														<select name="year" class="form-control" required>
															<option value="">---</option>
															<option value="<?= $record_acr['year']; ?>" selected>1 April <?= $year_p; ?> - 31 March <?= $year_c; ?></option>
														</select>
													</div>
													
													<div class="col-md-3">
														<label class="form-label">कार्य स्थल</label>
														<select name="work_location" id="work_location" onchange="action3_1(this.value)" class="form-control" required>
															<option value="">---</option>
															<?php
															$query="select * from work_location";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
																if($record_acr['work_location']==$record['work_location']){
																?>
																	<option value="<?= $record['work_location']; ?>" selected><?= $record['work_location_name']; ?></option>
																<?php
																}else{
																?>
																	<option value="<?= $record['work_location']; ?>"><?= $record['work_location_name']; ?></option>
																<?php	
																}
															}
															?>
														</select>
													</div>
													
													<div class="col-md-6" id="dep_div_data">
													<?php
													$output = '';
													$output .= '<div class="row">';
													if($record_acr['work_location']=='Division'){
														$output .= '<div class="col-md-6">';
															$output .='<label class="form-label">कॉलेज का नाम </label>
															<select name="office_name" id="office_name" onchange="action3_3(this.value)" class="form-control" required>';
															$output .= '<option value="">---</option>';
															$query="select * from division";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
																if($record_acr['office_name']==$record['id']){
																	$output .= '<option value="'.$record['id'].'" selected>'.$record['division'].'</option>';
																}else{
																	$output .= '<option value="'.$record['id'].'">'.$record['division'].'</option>';
																}
															}
														$output .='</select></div>
														<div class="col-md-6" id="present_post">';
															$output .= '<label class="form-label">पदनाम</label>
																<select name="present_post" id="present_post" onchange="action20_21(this.value)" class="form-control" required>
																	<option value="">---</option>';
																	$query="select employee.post, post.post_name_en from employee inner join post on employee.post=post.id where employee.work_location = '".$record_acr['work_location']."' and office_name='".$record_acr['office_name']."' group by post.post_name_en asc";
																	$row=$db->select($query);
																	while($record=$row->fetch_array()){
																		if($record_acr['present_post']==$record['post']){
																			$output .= '<option value="'.$record['post'].'" selected>'.$record['post_name_en'].'</option>';
																		}else{
																			$output .= '<option value="'.$record['post'].'">'.$record['post_name_en'].'</option>';
																		}
																	}
																$output .='</select>';
														$output .='</div>';
													}else if($record_acr['work_location']=='Depot'){
														$output .= '<div class="col-md-6">';
															$output .='<label class="form-label">कॉलेज का नाम </label>
															<select name="office_name" id="office_name" onchange="action3_3(this.value)" class="form-control" required>';
															$output .= '<option value="">---</option>';
															$query="select * from deport";
															$row=$db->select($query);
															while($record=$row->fetch_array()){
																if($record_acr['office_name']==$record['id']){
																	$output .= '<option value="'.$record['id'].'" selected>'.$record['deport'].'</option>';
																}else{
																	$output .= '<option value="'.$record['id'].'">'.$record['deport'].'</option>';
																}
															}
														$output .='</select></div>
														<div class="col-md-6" id="present_post">';
															$output .= '<label class="form-label">पदनाम</label>
															<select name="present_post" id="present_post" onchange="action20_21(this.value)" class="form-control" required>
																<option value="">---</option>';
																$query="select employee.post, post.post_name_en from employee inner join post on employee.post=post.id where employee.work_location = '".$record_acr['work_location']."' and office_name='".$record_acr['office_name']."' group by post.post_name_en asc";
																$row=$db->select($query);
																while($record=$row->fetch_array()){
																	if($record_acr['present_post']==$record['post']){
																		$output .= '<option value="'.$record['post'].'" selected>'.$record['post_name_en'].'</option>';
																	}else{
																		$output .= '<option value="'.$record['post'].'">'.$record['post_name_en'].'</option>';
																	}
																}
															$output .='</select>';
														$output .='</div>';
													}else if($record_acr['work_location']=='Head Quarter'){
														$output .= '<div class="col-md-6">
																<label class="form-label">पदनाम </label>
																<select name="present_post" id="present_post" onchange="action20_2(this.value)" class="form-control" required>';
																$output .= '<option value="">---</option>';
																$query="select employee.post, post.post_name_en from employee inner join post on employee.post=post.id where employee.work_location = '".$record_acr['work_location']."' group by post.post_name_en asc";
																$row=$db->select($query);
																while($record=$row->fetch_array()){
																	if($record_acr['present_post']==$record['post']){
																		$output .= '<option value="'.$record['post'].'" selected>'.$record['post_name_en'].'</option>';
																	}else{
																		$output .= '<option value="'.$record['post'].'">'.$record['post_name_en'].'</option>';
																	}
																}
															$output .='</select>
														</div>';
													}
													$output .='</div>';
													echo $output;
													?>
													</div>
												</div>
												
												<div class="row mb-3">	
													<div class="col-md-12">
														<hr>
														<label class="form-label">प्रतिवेदक, समीक्षक एवं स्वीकर्ता प्राधिकारी</label>
													</div>
													
													<div class="col-md-12">
														<div class="table-responsive">
															<table class="table table-bordered">
																<thead>
																	<tr>
																		<th style="width:5%">#</th>
																		<th style="width:19%"></th>
																		<th style="width:19%">कार्य स्थल</th>
																		<th style="width:19%">कॉलेज</th>
																		<th style="width:19%">पदनाम</th>
																		<th style="width:19%">नाम </th>
																		<!--th>समयावधि</th-->
																	</tr>
																</thead>
																<tbody id="authority_post">
																	<tr>
																		<td>1</td>
																		<td>प्रतिवेदक प्राधिकारी</td>
																		<td>
																			<select name="reporting_authority_work_location" id="work_location1" onchange="action3_11(this.value,1)" class="form-control" required>
																				<option value="">---</option>
																				<?php
																				$query="select * from work_location";
																				$row=$db->select($query);
																				while($record=$row->fetch_array()){
																					if($record_acr['reporting_authority_work_location']==$record['work_location']){
																					?>
																						<option value="<?= $record['work_location']; ?>" selected><?= $record['work_location_name']; ?></option>
																					<?php
																					}else{
																					?>
																						<option value="<?= $record['work_location']; ?>"><?= $record['work_location_name']; ?></option>
																					<?php	
																					}
																				}
																				?>
																			</select>
																		</td>
																		<td id="dep_div_data1">
																			<?php
																			$output1 = '';
																			if($record_acr['reporting_authority_work_location']=='Division'){
																				$output1 .='<select name="reporting_office_name" id="acr_office_name1" onchange="action3_3_1(this.value,1)" class="form-control" required>';
																					$output1 .= '<option value="">---कॉलेज---</option>';
																					$query="select * from division";
																					$row=$db->select($query);
																					while($record=$row->fetch_array()){
																						if($record_acr['reporting_office_name']==$record['id']){
																							$output1 .= '<option value="'.$record['id'].'" selected>'.$record['division'].'</option>';
																						}else{
																							$output1 .= '<option value="'.$record['id'].'">'.$record['division'].'</option>';
																						}
																					}
																				$output1 .='</select>';
																			}else if($record_acr['reporting_authority_work_location']=='Depot'){
																				$output1 .='<select name="reporting_office_name" id="acr_office_name1" onchange="action3_3_1(this.value,1)" class="form-control" required>';
																					$output1 .= '<option value="">---कॉलेज---</option>';
																					$query="select * from deport";
																					$row=$db->select($query);
																					while($record=$row->fetch_array()){
																						if($record_acr['reporting_office_name']==$record['id']){
																							$output1 .= '<option value="'.$record['id'].'" selected>'.$record['deport'].'</option>';
																						}else{
																							$output1 .= '<option value="'.$record['id'].'">'.$record['deport'].'</option>';
																						}
																					}
																				$output1 .='</select>';
																			}else if($record_acr['reporting_authority_work_location']=='Head Quarter'){
																				$output1 .= ' --- ';
																			}
																			echo $output1;
																			?>
																		</td>
																		<td id="post_name_data1">
																			<select name="reporting_authority_post" id="present_post1" onchange="action21_00(this.value,1)" class="form-control" required>
																				<option value="">---</option>
																				<?php
																				if($record_acr['reporting_office_name']==''){
																					$query="select employee.post, post.post_name_en from employee inner join post on employee.post=post.id where employee.work_location = '".$record_acr['reporting_authority_work_location']."' group by post.post_name_en asc";
																				}else{
																					$query="select employee.post, post.post_name_en from employee inner join post on employee.post=post.id where employee.work_location = '".$record_acr['reporting_authority_work_location']."' and office_name='".$record_acr['reporting_office_name']."' group by post.post_name_en asc";
																				}
																				$row=$db->select($query);
																				while($record=$row->fetch_array()){
																					if($record_acr['reporting_authority_post']==$record['post']){
																						echo '<option value="'.$record['post'].'" selected>'.$record['post_name_en'].'</option>';
																					}else{
																						echo '<option value="'.$record['post'].'">'.$record['post_name_en'].'</option>';
																					}
																				}
																				?>
																			</select>
																		</td>
																		
																		<td>
																			<select name="reporting_authority_name" id="authority_name1" class="form-control" required>
																				<option value="">---</option>
																				<?php
																				if($record_acr['reporting_office_name']==''){
																					$query="select * from employee where post='".$record_acr['reporting_authority_post']."' and work_location='".$record_acr['reporting_authority_work_location']."'";
																				}else{
																					$query="select * from employee where post='".$record_acr['reporting_authority_post']."' and work_location='".$record_acr['reporting_authority_work_location']."' and office_name='".$record_acr['reporting_office_name']."'";
																				}
																				$row=$db->select($query);
																				while($record=$row->fetch_array()){
																					if($record_acr['reporting_authority_name']==$record['employee_code']){
																						echo '<option value="'.$record['employee_code'].'" selected>'.$record['employee_name'].'</option>';
																					}else{
																						echo '<option value="'.$record['employee_code'].'">'.$record['employee_name'].'</option>';
																					}
																				}
																				?>
																			</select>
																		</td>
																	</tr>
																	
																	<tr>
																		<td>2</td>
																		<td>समीक्षक प्राधिकारी</td>
																		<td>
																			<select name="reviewing_authority_work_location" id="work_location2" onchange="action3_11(this.value,2)" class="form-control" required>
																				<option value="">---</option>
																				<?php
																				$query="select * from work_location";
																				$row=$db->select($query);
																				while($record=$row->fetch_array()){
																					if($record_acr['reviewing_authority_work_location']==$record['work_location']){
																					?>
																						<option value="<?= $record['work_location']; ?>" selected><?= $record['work_location_name']; ?></option>
																					<?php
																					}else{
																					?>
																						<option value="<?= $record['work_location']; ?>"><?= $record['work_location_name']; ?></option>
																					<?php	
																					}
																				}
																				?>
																			</select>
																		</td>
																		<td id="dep_div_data2">
																			<?php
																			$output1 = '';
																			if($record_acr['reviewing_authority_work_location']=='Division'){
																				$output1 .='<select name="reviewing_office_name" id="acr_office_name2" onchange="action3_3_1(this.value,2)" class="form-control" required>';
																					$output1 .= '<option value="">---कॉलेज---</option>';
																					$query="select * from division";
																					$row=$db->select($query);
																					while($record=$row->fetch_array()){
																						if($record_acr['reviewing_office_name']==$record['id']){
																							$output1 .= '<option value="'.$record['id'].'" selected>'.$record['division'].'</option>';
																						}else{
																							$output1 .= '<option value="'.$record['id'].'">'.$record['division'].'</option>';
																						}
																					}
																				$output1 .='</select>';
																			}else if($record_acr['reviewing_authority_work_location']=='Depot'){
																				$output1 .='<select name="reviewing_office_name" id="acr_office_name2" onchange="action3_3_1(this.value,2)" class="form-control" required>';
																					$output1 .= '<option value="">---Depot---</option>';
																					$query="select * from deport";
																					$row=$db->select($query);
																					while($record=$row->fetch_array()){
																						if($record_acr['reviewing_office_name']==$record['id']){
																							$output1 .= '<option value="'.$record['id'].'" selected>'.$record['deport'].'</option>';
																						}else{
																							$output1 .= '<option value="'.$record['id'].'">'.$record['deport'].'</option>';
																						}
																					}
																				$output1 .='</select>';
																			}else if($record_acr['reviewing_authority_work_location']=='Head Quarter'){
																				$output1 .= ' --- ';
																			}
																			echo $output1;
																			?>
																		</td>
																		<td id="post_name_data2">
																			<select name="reviewing_authority_post" id="present_post2" onchange="action21_00(this.value,2)" class="form-control" required>
																				<option value="">---</option>
																				<?php
																				if($record_acr['reviewing_office_name']==''){
																					$query="select employee.post, post.post_name_en from employee inner join post on employee.post=post.id where employee.work_location = '".$record_acr['reviewing_authority_work_location']."' group by post.post_name_en asc";
																				}else{
																					$query="select employee.post, post.post_name_en from employee inner join post on employee.post=post.id where employee.work_location = '".$record_acr['reviewing_authority_work_location']."' and office_name='".$record_acr['reviewing_office_name']."' group by post.post_name_en asc";
																				}
																				$row=$db->select($query);
																				while($record=$row->fetch_array()){
																					if($record_acr['reviewing_authority_post']==$record['post']){
																						echo '<option value="'.$record['post'].'" selected>'.$record['post_name_en'].'</option>';
																					}else{
																						echo '<option value="'.$record['post'].'">'.$record['post_name_en'].'</option>';
																					}
																				}
																				?>
																			</select>
																		</td>
																		
																		<td>
																			<select name="reviewing_authority_name" id="authority_name2" class="form-control" required>
																				<option value="">---</option>
																				<?php
																				if($record_acr['reviewing_office_name']==''){
																					$query="select * from employee where post='".$record_acr['reviewing_authority_post']."' and work_location='".$record_acr['reviewing_authority_work_location']."'";
																				}else{
																					$query="select * from employee where post='".$record_acr['reviewing_authority_post']."' and work_location='".$record_acr['reviewing_authority_work_location']."' and office_name='".$record_acr['reviewing_office_name']."'";
																				}
																				$row=$db->select($query);
																				while($record=$row->fetch_array()){
																					if($record_acr['reviewing_authority_name']==$record['employee_code']){
																						echo '<option value="'.$record['employee_code'].'" selected>'.$record['employee_name'].'</option>';
																					}else{
																						echo '<option value="'.$record['employee_code'].'">'.$record['employee_name'].'</option>';
																					}
																				}
																				?>
																			</select>
																		</td>
																	</tr>
																	
																	<tr>
																		<td>3</td>
																		<td>स्वीकर्ता प्राधिकारी</td>
																		<td>
																			<select name="accepting_authority_work_location" id="work_location3" onchange="action3_11(this.value,3)" class="form-control" required>
																				<option value="">---</option>
																				<?php
																				$query="select * from work_location";
																				$row=$db->select($query);
																				while($record=$row->fetch_array()){
																					if($record_acr['accepting_authority_work_location']==$record['work_location']){
																					?>
																						<option value="<?= $record['work_location']; ?>" selected><?= $record['work_location_name']; ?></option>
																					<?php
																					}else{
																					?>
																						<option value="<?= $record['work_location']; ?>"><?= $record['work_location_name']; ?></option>
																					<?php	
																					}
																				}
																				?>
																			</select>
																		</td>
																		<td id="dep_div_data3">
																			<?php
																			$output1 = '';
																			if($record_acr['accepting_authority_work_location']=='Division'){
																				$output1 .='<select name="accepting_office_name" id="acr_office_name3" onchange="action3_3_1(this.value,3)" class="form-control" required>';
																					$output1 .= '<option value="">---कॉलेज---</option>';
																					$query="select * from division";
																					$row=$db->select($query);
																					while($record=$row->fetch_array()){
																						if($record_acr['accepting_office_name']==$record['id']){
																							$output1 .= '<option value="'.$record['id'].'" selected>'.$record['division'].'</option>';
																						}else{
																							$output1 .= '<option value="'.$record['id'].'">'.$record['division'].'</option>';
																						}
																					}
																				$output1 .='</select>';
																			}else if($record_acr['accepting_authority_work_location']=='Depot'){
																				$output1 .='<select name="accepting_office_name" id="acr_office_name3" onchange="action3_3_1(this.value,3)" class="form-control" required>';
																					$output1 .= '<option value="">---Depot---</option>';
																					$query="select * from deport";
																					$row=$db->select($query);
																					while($record=$row->fetch_array()){
																						if($record_acr['accepting_office_name']==$record['id']){
																							$output1 .= '<option value="'.$record['id'].'" selected>'.$record['deport'].'</option>';
																						}else{
																							$output1 .= '<option value="'.$record['id'].'">'.$record['deport'].'</option>';
																						}
																					}
																				$output1 .='</select>';
																			}else if($record_acr['accepting_authority_work_location']=='Head Quarter'){
																				$output1 .= ' --- ';
																			}
																			echo $output1;
																			?>
																		</td>
																		<td id="post_name_data3">
																			<select name="accepting_authority_post" id="present_post3" onchange="action21_00(this.value,3)" class="form-control" required>
																				<option value="">---</option>
																				<?php
																				if($record_acr['accepting_office_name']==''){
																					$query="select employee.post, post.post_name_en from employee inner join post on employee.post=post.id where employee.work_location = '".$record_acr['accepting_authority_work_location']."' group by post.post_name_en asc";
																				}else{
																					$query="select employee.post, post.post_name_en from employee inner join post on employee.post=post.id where employee.work_location = '".$record_acr['accepting_authority_work_location']."' and office_name='".$record_acr['accepting_office_name']."' group by post.post_name_en asc";
																				}
																				$row=$db->select($query);
																				while($record=$row->fetch_array()){
																					if($record_acr['accepting_authority_post']==$record['post']){
																						echo '<option value="'.$record['post'].'" selected>'.$record['post_name_en'].'</option>';
																					}else{
																						echo '<option value="'.$record['post'].'">'.$record['post_name_en'].'</option>';
																					}
																				}
																				?>
																			</select>
																		</td>
																		<td>
																			<select name="accepting_authority_name" id="authority_name3" class="form-control" required>
																				<option value="">---</option>
																				<?php
																				if($record_acr['accepting_office_name']==''){
																					$query="select * from employee where post='".$record_acr['accepting_authority_post']."' and work_location='".$record_acr['accepting_authority_work_location']."'";
																				}else{
																					$query="select * from employee where post='".$record_acr['accepting_authority_post']."' and work_location='".$record_acr['accepting_authority_work_location']."' and office_name='".$record_acr['accepting_office_name']."'";
																				}
																				$row=$db->select($query);
																				while($record=$row->fetch_array()){
																					if($record_acr['accepting_authority_name']==$record['employee_code']){
																						echo '<option value="'.$record['employee_code'].'" selected>'.$record['employee_name'].'</option>';
																					}else{
																						echo '<option value="'.$record['employee_code'].'">'.$record['employee_name'].'</option>';
																					}
																				}
																				?>
																			</select>
																		</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</div>
												
												<input type="hidden" name="id" value="<?= $record_acr['id']; ?>">
												<input type="hidden" name="update_acr" value="update_acr">
												<button id="acr_button" class="btn btn-primary" type="submit">जमा करना</button>
											<?php
											}else{
											?>
												<div class="row">
													<div class="col-md-3">
														<label class="form-label">ए० सी० आर० वर्ष</label>
														<select name="year" class="form-control" required>
															<option value="">---</option>
															<option value="<?= date("Y") - 1; ?>-<?= date("Y"); ?>">1 April <?= date("Y") - 1; ?> - 31 March <?= date("Y"); ?></option>
														</select>
													</div>
													<?php
													if($_SESSION['astro_role']=='Admin'){
													?>
														<div class="col-md-3">
															<label class="form-label">कार्य स्थल</label>
															<select name="work_location" id="work_location" onchange="action3_1(this.value)" class="form-control" required>
																<option value="">---</option>
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
														
														<div class="col-md-6" id="dep_div_data"></div>
													<?php
													}else{
														if($_SESSION['astro_role']=='Division'){
															$query21="select id from division where phone='".$_SESSION['astro_email']."'";
															$row21=$db->select($query21);
															$record21=$row21->fetch_array();
															$office_name=$record21['id'];
															
															$office_location = '<input type="hidden" name="office_name" id="office_name" value="'.$office_name.'">';
															
															$query="select employee.post, post.post_name_en from employee inner join post on employee.post=post.id where employee.work_location = '".$_SESSION['astro_role']."' and office_name='$office_name' group by post.post_name_en asc";
															$work_location = 'Division';
														}else if($_SESSION['astro_role']=='Deport'){
															$query21="select id from deport where phone='".$_SESSION['astro_email']."'";
															$row21=$db->select($query21);
															$record21=$row21->fetch_array();
															$office_name=$record21['id'];
															
															$office_location = '<input type="hidden" name="office_name" id="office_name" value="'.$office_name.'">';
															$work_location = 'Depot';
															
															$query="select employee.post, post.post_name_en from employee inner join post on employee.post=post.id where employee.work_location = '".$work_location."' and office_name='$office_name' group by post.post_name_en asc";
														}else if($_SESSION['astro_role']=='Head Quarter'){
															$office_name='';
															$work_location = 'Head Quarter';
															$query="select employee.post, post.post_name_en from employee inner join post on employee.post=post.id where employee.work_location = '".$_SESSION['astro_role']."' and office_name='$office_name' group by post.post_name_en asc";
														}
													?>
														<div class="col-md-3">
															<?= $office_location; ?>
															<input type="hidden" name="work_location" id="work_location" value="<?= $work_location; ?>">
															<label class="form-label">पदनाम </label>
															<select name="present_post" id="present_post" onchange="action20_2(this.value)" class="form-control" required>';
																<option value="">---</option>
																<?php
																//echo $query="select employee.post, post.post_name_en from employee inner join post on employee.post=post.id where employee.work_location = '".$_SESSION['astro_role']."' group by post.post_name_en asc";
																$row=$db->select($query);
																while($record=$row->fetch_array()){
																?>
																	<option value="<?= $record['post']; ?>"><?= $record['post_name_en']; ?></option>
																<?php
																}
																?>
															</select>
														</div>
													<?php
													}
													?>
													
												</div>
												
												<div class="row mb-3">	
													<div class="col-md-12">
														<hr>
														<label class="form-label">प्रतिवेदक, समीक्षक एवं स्वीकर्ता प्राधिकारी</label>
													</div>
													
													<div class="col-md-12">
														<div class="table-responsive">
															<table class="table table-bordered">
																<thead>
																	<tr>
																		<th style="width:5%">#</th>
																		<th style="width:19%"></th>
																		<th style="width:19%">कार्य स्थल</th>
																		<th style="width:19%">कॉलेज</th>
																		<th style="width:19%">पदनाम</th>
																		<th style="width:19%">नाम </th>
																		<!--th>समयावधि</th-->
																	</tr>
																</thead>
																<tbody id="authority_post">
																	<tr>
																		<td>1</td>
																		<td>प्रतिवेदक प्राधिकारी</td>
																		<td>
																			<select name="reporting_authority_work_location" onchange="action3_1(this.value,1)" class="form-control" required>
																				<option value="">---</option>
																			</select>
																		</td>
																		<td>
																			<select name="reporting_authority_post" onchange="action21_00(this.value,1)" class="form-control" required>
																				<option value="">---</option>
																			</select>
																		</td>
																		<td>
																			<select name="reporting_authority_post" onchange="action21_00(this.value,1)" class="form-control" required>
																				<option value="">---</option>
																			</select>
																		</td>
																		
																		<td>
																			<select name="reporting_authority_name" id="authority_name1" class="form-control" required>
																				<option value="">---</option>
																			</select>
																		</td>
																	</tr>
																	
																	<tr>
																		<td>2</td>
																		<td>समीक्षक प्राधिकारी</td>
																		<td>
																			<select name="reviewing_authority_work_location" onchange="action21_00(this.value,2)" class="form-control" required>
																				<option value="">---</option>
																			</select>
																		</td>
																		<td>
																			<select name="reviewing_authority_post" onchange="action21_00(this.value,2)" class="form-control" required>
																				<option value="">---</option>
																			</select>
																		</td>
																		<td>
																			<select name="reviewing_authority_post" onchange="action21_00(this.value,2)" class="form-control" required>
																				<option value="">---</option>
																			</select>
																		</td>
																		
																		<td>
																			<select name="reviewing_authority_name" id="authority_name2" class="form-control" required>
																				<option value="">---</option>
																			</select>
																		</td>
																	</tr>
																	
																	<tr>
																		<td>3</td>
																		<td>स्वीकर्ता प्राधिकारी</td>
																		<td>
																			<select name="accepting_authority_work_location" onchange="action21_00(this.value,3)" class="form-control" required>
																				<option value="">---</option>
																			</select>
																		</td>
																		<td>
																			<select name="accepting_authority_post" onchange="action21_00(this.value,3)" class="form-control" required>
																				<option value="">---</option>
																			</select>
																		</td>
																		<td>
																			<select name="accepting_authority_post" onchange="action21_00(this.value,3)" class="form-control" required>
																				<option value="">---</option>
																			</select>
																		</td>
																		<td>
																			<select name="accepting_authority_name" id="authority_name3" class="form-control" required>
																				<option value="">---</option>
																			</select>
																		</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</div>
												
												<input type="hidden" name="add_acr" value="add_acr">
												<button id="acr_button" class="btn btn-primary" type="submit">जमा करना</button>
											<?php
											}
											?>
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
function action20(query20){
	if(query20 != ''){
		var action20 = 'fetch_acr_employee';
		if($('#office_name').length){
			var office_name = $('#office_name').val();
		}else{
			var office_name = '';
		}
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action20:action20, query20:query20, office_name:office_name},
			success:function(data){
				$('#employee_name').html(data);
			}
		})
	}
}
</script>

<script>
function action20_2(query20_2){
	if(query20_2 != ''){
		var action20_2 = 'fetch_authority_post';
		var work_location = $('#work_location').val();
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action20_2:action20_2, query20_2:query20_2, work_location:work_location},
			success:function(data){
				//alert(data);
				$('#authority_post').html(data);
			}
		})
	}
}
</script>

<script>
function action20_21(query20_21){
	if(query20_21 != ''){
		var action20_21 = 'fetch_authority_post';
		var work_location = $('#work_location').val();
		var office_name = $('#office_name').val();
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action20_21:action20_21, query20_21:query20_21, work_location:work_location, office_name:office_name},
			success:function(data){
				//alert(data);
				$('#authority_post').html(data);
			}
		})
	}
}
</script>


<script>
function action21(query21){
	if(query21 != ''){
		var action21 = 'fetch_acr_employee_data';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action21:action21, query21:query21},
			success:function(data){
				//alert(data);
				$('#employee_data').html(data);
			}
		})
	}
}
</script>

<script>
function action21_00(query21_00,sn){
	if(query21_00 != ''){
		var work_location = $('#work_location'+sn).val();
		if($('#acr_office_name'+sn).length){
			var acr_office_name = $('#acr_office_name'+sn).val();
		}else{
			var acr_office_name = '';
		}
		var action21_00 = 'fetch_authority_name';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action21_00:action21_00, query21_00:query21_00, acr_office_name:acr_office_name, work_location:work_location, sn:sn},
			success:function(data){
				//alert(data);
				$('#authority_name'+sn).html(data);
			}
		})
	}
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
				//alert(data);
				if(data=='Success'){
					$('#message').html('<p class="text-success">ACR Created Successfully!</p>');
					$('#acr_form')[0].reset();
				}else if(data=='Success1'){
					$('#message').html('<p class="text-success">ACR Updated Successfully!</p>');
				}else if(data=='Error'){
					$('#message').html('<p class="text-success">ACR Already Exist!</p>');
				}else{
					$('#message').html('<p class="text-danger">'+data+'</p>');
				}
				$('#acr_button').html('Save');
			}
		});
	});
});
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
			htmlRows += '<td><input type="date" name="training_from_date[]" class="form-control"></td>'; 
			htmlRows += '<td><input type="date" name="training_to_date[]" class="form-control"></td>'; 
			htmlRows += '<td><input type="text" name="training_institute[]" class="form-control"></td>'; 
			htmlRows += '<td><input type="text" name="training_subject[]" class="form-control"></td>'; 
			
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
function action3_1(query3_1){
	if(query3_1 != ''){
		var action3_1 = 'fetch_division';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action3_1:action3_1, query3_1:query3_1},
			success:function(data){
				//alert(data);
				$('#dep_div_data').html(data);
			}
		})
	}else{
		$('#dep_div_data').html('');
	}
}
</script>

<script>
function action3_11(query3_11,sn){
	if(query3_11 != ''){
		var action3_11 = 'fetch_division';
		var work_location = $('#work_location'+sn).val();
		var present_post = $('#present_post'+sn).val();
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action3_11:action3_11, query3_11:query3_11, work_location:work_location, present_post:present_post, sn:sn},
			success:function(data){
				var result = data.split('@');
				$('#dep_div_data'+sn).html(result[0]);
				$('#present_post'+sn).html(result[1]);
				if(typeof result[1]=='undefined'){
					$('#present_post'+sn).html('<option value="">---</option>');
				}
				$('#authority_name'+sn).html('<option value="">---</option>');
			}
		})
	}else{
		$('#dep_div_data'+sn).html('');
	}
}
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
				if(query3_2!='Head Quarter'){
					$('#present_post').html('<option value="">~~~Choose~~~</option>');
				}else{
					$('#present_post').html(data);
				}
			}
		})
	}else{
		$('#present_post').html('<option value="">~~~Choose~~~</option>');
	}
}
</script>
 
<script>
function action3_3(query3_3){
	if(query3_3 != ''){
		var action3_3 = 'fetch_post';
		var work_location = $('#work_location').val();
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action3_3:action3_3, query3_3:query3_3, work_location:work_location},
			success:function(data){
				//alert(data);
				$('#present_post').html(data);
			}
		})
	}else{
		$('#present_post').html('<option value="">~~~Choose~~~</option>');
	}
}
</script>


<script>
function action3_3_1(query3_3_1,sn){
	if(query3_3_1 != ''){
		var action3_3_1 = 'fetch_post';
		var work_location = $('#work_location'+sn).val();
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action3_3_1:action3_3_1, query3_3_1:query3_3_1, work_location:work_location, sn:sn},
			success:function(data){
				//alert(data);
				$('#present_post'+sn).html(data);
			}
		})
	}else{
		$('#present_post'+sn).html('<option value="">~~~Choose~~~</option>');
	}
}
</script>



 

    </body>
</html>