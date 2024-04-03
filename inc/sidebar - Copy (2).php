<div class="left-side-menu">

	<!-- LOGO -->
	<div class="logo-box">
		<a href="./" class="logo logo-dark text-center">
			<span class="logo-sm">
				<img src="assets/images/logo-sm-dark.png" alt="" height="24">
				<!-- <span class="logo-lg-text-light">Minton</span> -->
			</span>
			<span class="logo-lg">
				<img src="assets/images/logo-dark.png" alt="" height="65">
				<!-- <span class="logo-lg-text-light">M</span> -->
			</span>
		</a>

		<a href="dashboard" class="logo logo-light text-center">
			<span class="logo-sm">
				<img src="assets/images/logo-sm.png" alt="" height="24">
			</span>
			<span class="logo-lg">
				<img src="assets/images/logo-light.png" alt="" height="65">
			</span>
		</a>
	</div>

	<div class="h-100" data-simplebar>

		<!-- User box -->
		<div class="user-box text-center">
			
			<div class="dropdown">
				<a href="#" class="text-reset dropdown-toggle h5 mt-2 mb-1 d-block"
					data-bs-toggle="dropdown">Welcome</a>
				<div class="dropdown-menu user-pro-dropdown">
					<a href="javascript:void(0);" class="dropdown-item notify-item">
						<i class="fe-log-out me-1"></i>
						<span>Logout</span>
					</a>

				</div>
			</div>
			<p class="text-reset">Admin Head</p>
		</div>

		<!--- Sidemenu -->
		<div id="sidebar-menu">

			<ul id="side-menu">
				
				<li>
					<a href="dashboard">
						<i class="ri-dashboard-line"></i>
						<span>Dashboard </span>
					</a>
				</li>
				<?php
				if($_SESSION['astro_role']=='User'){
				?>
					<li>
						<a href="#attendance" data-bs-toggle="collapse" aria-expanded="false" aria-controls="attendance">
							<i class="ri-calendar-line"></i>
							<span>Attendance </span>
							<span class="menu-arrow"></span>
						</a>
						<div class="collapse" id="attendance">
							<ul class="nav-second-level">
								<li>
									<a href="attendance">Attendance</a>
								</li>
								<li>
									<a href="leave">Leave</a>
								</li>
								<!--li>
									<a href="view-division">Upcomig Birthday</a>
								</li>
								<li>
									<a href="view-division">Work Anniversary</a>
								</li!-->
								<!--li>
									<a href="#">Holidays</a>
								</li-->
								
							</ul>
						</div>
					</li>
					<li>
						<a href="#self-appraisal" data-bs-toggle="collapse" aria-expanded="false" aria-controls="self-appraisal">
							<i class="ri-line-chart-line"></i>
							<span>Self Appraisal</span>
							<span class="menu-arrow"></span>
						</a>
						<div class="collapse" id="self-appraisal">
							<ul class="nav-second-level">
								<li>
									<a href="self-appraisal">New Self Appraisal</a>
								</li>
								<li>
									<a href="view-self-appraisal">View Self Appraisal</a>
								</li>
								
							</ul>
						</div>
					</li>
					<?php
					$sql_acr = "SELECT * FROM `acr` WHERE reporting_authority_name = '".$_SESSION['astro_email']."'";
					$exe_acr = $db->select($sql_acr);
					if ($exe_acr->num_rows > 0) {
						$record_acr=$exe_acr->fetch_array();
						$sql_acr1 = "SELECT * FROM `post` WHERE id = '".$record_acr['present_post']."'";
						$exe_acr1 = $db->select($sql_acr1);
						if ($exe_acr1->num_rows > 0) {
							$record_acr1=$exe_acr1->fetch_array();
							if($record_acr1['post_name_en']=='DRIVER'){
							?>
							<li>
								<a href="#driver_appraisal" data-bs-toggle="collapse" aria-expanded="false" aria-controls="driver_appraisal">
									<i class="fa fa-bus"></i>
									<span>Driver/Conductor</span>
									<span class="menu-arrow"></span>
								</a>
								<div class="collapse" id="driver_appraisal">
									<ul class="nav-second-level">
										<li>
											<a href="view-driver-self-conductor-appraisal-list">New Self Appraisal</a>
										</li>
										<li>
											<a href="view-driver-conductor-self-appraisal">View Self Appraisal</a>
										</li>
										
									</ul>
								</div>
							</li>
						<?php
							}
						}
					?>
						<li>
							<a href="#appraisal" data-bs-toggle="collapse" aria-expanded="false" aria-controls="appraisal">
								<i class="ri-line-chart-line"></i>
								<span>Appraisal</span>
								<span class="menu-arrow"></span>
							</a>
							<div class="collapse" id="appraisal">
								<ul class="nav-second-level">
									<li>
										<a href="view-self-appraisal-list">New Appraisal</a>
									</li>
									<li>
										<a href="view-appraisal-list">View Appraisal</a>
									</li>
									
								</ul>
							</div>
						</li>
					<?php
					}
					$sql_acr = "SELECT * FROM `acr` WHERE reviewing_authority_name = '".$_SESSION['astro_email']."'";
					$exe_acr = $db->select($sql_acr);
					if ($exe_acr->num_rows > 0) {
					?>
						<li>
							<a href="#review" data-bs-toggle="collapse" aria-expanded="false" aria-controls="review">
								<i class="ri-line-chart-line"></i>
								<span>Review ACR</span>
								<span class="menu-arrow"></span>
							</a>
							<div class="collapse" id="review">
								<ul class="nav-second-level">
									<li>
										<a href="appraisal-list">New Review</a>
									</li>
									<li>
										<a href="view-acr-review-list">View Review</a>
									</li>
									
								</ul>
							</div>
						</li>
					<?php
					}
					$sql_acr = "SELECT * FROM `acr` WHERE accepting_authority_name = '".$_SESSION['astro_email']."'";
					$exe_acr = $db->select($sql_acr);
					if ($exe_acr->num_rows > 0) {
					?>
						<li>
							<a href="#acceptance" data-bs-toggle="collapse" aria-expanded="false" aria-controls="acceptance">
								<i class="ri-line-chart-line"></i>
								<span>Acceptance</span>
								<span class="menu-arrow"></span>
							</a>
							<div class="collapse" id="acceptance">
								<ul class="nav-second-level">
									<li>
										<a href="acr-review-list">New Acceptance</a>
									</li>
									<li>
										<a href="view-acr-acceptance-list">View Acceptance</a>
									</li>
									
								</ul>
							</div>
						</li>
					<?php
					}
					
					
					?>
				<?php
				}else if($_SESSION['astro_role']=='Division' || $_SESSION['astro_role']=='Deport' || $_SESSION['astro_role']=='Head Quarter'){
				?>
					<li>
						<a href="#attendance-list" data-bs-toggle="collapse" aria-expanded="false" aria-controls="attendance-list">
							<i class="ri-calendar-line"></i>
							<span>Attendance </span>
							<span class="menu-arrow"></span>
						</a>
						<div class="collapse" id="attendance-list">
							<ul class="nav-second-level">
								<li><a href="todays-attendance">Today's </a></li>
								<li><a href="montly-attendance-status">Montly Status</a></li>
								<li><a href="attendance-list">List</a></li>
								<li><a href="attendance-request">Regulize</a></li>
								<li><a href="manual-attendance">Manual</a></li>
								<li><a href="leave-request">Leave Request</a></li>
								
							</ul>
						</div>
					</li>
					
					<li>
						<a href="#service_record" data-bs-toggle="collapse" aria-expanded="false" aria-controls="service_record">
							<i class="ri-dashboard-line"></i>
							<span>Service Record </span>
							<span class="menu-arrow"></span>
						</a>
						<div class="collapse" id="service_record">
							<ul class="nav-second-level">
								<li>
									<a href="service-book">Service Book</a>
								</li>
								<li><a href="#">Form 11-A</a></li>
							</ul>
						</div>
					</li>
					
					<li>
						<a href="#Transfer" data-bs-toggle="collapse" aria-expanded="false" aria-controls="Transfer">
							<i class="ri-dashboard-line"></i>
							<span>Transfer </span>
							<span class="menu-arrow"></span>
						</a>
						<div class="collapse" id="Transfer">
							<ul class="nav-second-level">
								<li><a href="transfer">New Transfer</a></li>
								<li><a href="view-transfer">View Transfer</a></li>
								<li><a href="joining">Joining</a></li>
							</ul>
						</div>
					</li>
					<li>
						<a href="#Promotion" data-bs-toggle="collapse" aria-expanded="false" aria-controls="Promotion">
							<i class="ri-dashboard-line"></i>
							<span>Promotion </span>
							<span class="menu-arrow"></span>
						</a>
						<div class="collapse" id="Promotion">
							<ul class="nav-second-level">
								<li><a href="promotion">New Promotion</a></li>
								<li><a href="view-promotion">View Promotion</a></li>
								<li><a href="promotion-joining">Joining</a></li>
							</ul>
						</div>
					</li>
					<li>
						<a href="#Retirement" data-bs-toggle="collapse" aria-expanded="false" aria-controls="Retirement">
							<i class="ri-dashboard-line"></i>
							<span>Retirement </span>
							<span class="menu-arrow"></span>
						</a>
						<div class="collapse" id="Retirement">
							<ul class="nav-second-level">
								<li><a href="retirement">New Retirement</a></li>
								<li><a href="view-retirement">View Retirement</a></li>
							</ul>
						</div>
					</li>
					<li>
						<a href="#Order" data-bs-toggle="collapse" aria-expanded="false" aria-controls="Order">
							<i class="ri-dashboard-line"></i>
							<span>Order </span>
							<span class="menu-arrow"></span>
						</a>
						<div class="collapse" id="Order">
							<ul class="nav-second-level">
								<li><a href="#">New Order</a></li>
								<li><a href="#">View Order</a></li>
							</ul>
						</div>
					</li>
					
					<li>
						<a href="employee-history">
							<i class="mdi mdi-account-clock-outline"></i>
							<span>Employee History </span>
						</a>
					</li>
				<?php
				}else if($_SESSION['astro_role']=='Admin'){
				?>
					<li>
						<a href="#hq" data-bs-toggle="collapse" aria-expanded="false" aria-controls="hq">
							<i class="ri-bus-line"></i>
							<span>Head Quarter </span>
							<span class="menu-arrow"></span>
						</a>
						<div class="collapse" id="hq">
							<ul class="nav-second-level">
								<li>
									<a href="view-hq">View Head Quarter</a>
								</li>
							</ul>
						</div>
					</li>
					<li>
						<a href="#Division" data-bs-toggle="collapse" aria-expanded="false" aria-controls="Division">
							<i class="ri-bus-line"></i>
							<span>Division </span>
							<span class="menu-arrow"></span>
						</a>
						<div class="collapse" id="Division">
							<ul class="nav-second-level">
								<li>
									<a href="division1">New Division</a>
								</li>
								<li>
									<a href="view-division">View Division</a>
								</li>
							</ul>
						</div>
					</li>
					
					<li>
						<a href="#deport" data-bs-toggle="collapse" aria-expanded="false" aria-controls="deport">
							<i class="ri-bus-line"></i>
							<span> Depot </span>
							<span class="menu-arrow"></span>
						</a>
						<div class="collapse" id="deport">
							<ul class="nav-second-level">
								<li>
									<a href="depot1">New Depot</a>
								</li>
								<li>
									<a href="view-deport">View Depot</a>
								</li>
							</ul>
						</div>
					</li>
					
					<li>
						<a href="#sidebarForms" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarForms">
							<i class="ri-eraser-line"></i>
							<span> Departmnet </span>
							<span class="menu-arrow"></span>
						</a>
						<div class="collapse" id="sidebarForms">
							<ul class="nav-second-level">
								<li>
									<a href="department">New Departmnet</a>
								</li>
								<li>
									<a href="view-department">View Departmnet</a>
								</li>
								
							</ul>
						</div>
					</li>
					
					<li>
						<a href="#sidebarTables" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarTables">
							<i class="ri-table-line"></i>
							<span> Post </span>
							<span class="menu-arrow"></span>
						</a>
						<div class="collapse" id="sidebarTables">
							<ul class="nav-second-level">
								<li>
									<a href="post">New Post</a>
								</li>
								<li>
									<a href="view-post">View Post</a>
								</li>
							</ul>
						</div>
					</li>
					
					<li>
						<a href="#employee" data-bs-toggle="collapse" aria-expanded="false" aria-controls="employee">
							<i class="ri-user-line"></i>
							<span> Employee </span>
							<span class="menu-arrow"></span>
						</a>
						<div class="collapse" id="employee">
							<ul class="nav-second-level">
								<li>
									<a href="employee">New Employee</a>
								</li>
								<li>
									<a href="view-employee">View Employee</a>
								</li>
							</ul>
						</div>
					</li>
					
					<li>
						<a href="#allowence" data-bs-toggle="collapse" aria-expanded="false" aria-controls="allowence">
							<i class="ri-add-box-line"></i>
							<span> Allowance </span>
							<span class="menu-arrow"></span>
						</a>
						<div class="collapse" id="allowence">
							<ul class="nav-second-level">
								<li>
									<a href="allowence">Allowance</a>
								</li>
								<li>
									<a href="special-allowence">Special Allowence</a>
								</li>
								<li>
									<a href="view-special-allowence">View Special Allowence</a>
								</li>
							</ul>
						</div>
					</li>
					
					<li>
						<a href="#deduction" data-bs-toggle="collapse" aria-expanded="false" aria-controls="deduction">
							<i class="ri-checkbox-indeterminate-line"></i>
							<span>Deduction </span>
							<span class="menu-arrow"></span>
						</a>
						<div class="collapse" id="deduction">
							<ul class="nav-second-level">
								<li>
									<a href="deduction">Deduction</a>
								</li>
								<li>
									<a href="special-deduction">Special Deduction</a>
								</li>
								<li>
									<a href="view-special-deduction">View Special Deduction</a>
								</li>
							</ul>
						</div>
					</li>
					
					<li>
						<a href="#attendance-list" data-bs-toggle="collapse" aria-expanded="false" aria-controls="attendance-list">
							<i class="ri-calendar-line"></i>
							<span>Attendance </span>
							<span class="menu-arrow"></span>
						</a>
						<div class="collapse" id="attendance-list">
							<ul class="nav-second-level">
								<li><a href="todays-attendance">Today's </a></li>
								<li><a href="montly-attendance-status">Montly Status</a></li>
								<li><a href="attendance-list">List</a></li>
								<li><a href="attendance-request">Regulize</a></li>
								<li><a href="manual-attendance">Manual</a></li>
								<li><a href="leave-request">Leave Request</a></li>
								
							</ul>
						</div>
					</li>
					
					<li>
						<a href="#service_record" data-bs-toggle="collapse" aria-expanded="false" aria-controls="service_record">
							<i class="ri-dashboard-line"></i>
							<span>Service Record </span>
							<span class="menu-arrow"></span>
						</a>
						<div class="collapse" id="service_record">
							<ul class="nav-second-level">
								<li>
									<a href="service-book">Service Book</a>
								</li>
								<li><a href="#">Form 11-A</a></li>
								<li><a href="view-transfer">Transfer</a></li>
								<li><a href="view-promotion">Promotion</a></li>
								<li><a href="view-retirement">Retirement</a></li>
								<li><a href="order">Order</a></li>
								
							</ul>
						</div>
					</li>
					<li>
						<a href="#acr" data-bs-toggle="collapse" aria-expanded="false" aria-controls="acr">
							<i class="ri-dashboard-line"></i>
							<span>ACR </span>
							<span class="menu-arrow"></span>
						</a>
						<div class="collapse" id="acr">
							<ul class="nav-second-level">
								<li><a href="acr">New ACR</a></li>
								<li><a href="view-acr">View ACR</a></li>
								<li><a href="view-self-appraisal-list">Employee Self Appraisal</a></li>
								<li><a href="view-appraisal-list">View Appraisal</a></li>
								<li><a href="view-acr-review-list">ACR Review</a></li>
								<li><a href="view-acr-acceptance-list">ACR Acceptance</a></li>
							</ul>
						</div>
					</li>
					
					<!--li>
						<a href="#self-appraisal" data-bs-toggle="collapse" aria-expanded="false" aria-controls="self-appraisal">
							<i class="ri-line-chart-line"></i>
							<span>Appraisal</span>
							<span class="menu-arrow"></span>
						</a>
						<div class="collapse" id="self-appraisal">
							<ul class="nav-second-level">
								
								
							</ul>
						</div>
					</li-->
					
					<li>
						<a href="#salary-list" data-bs-toggle="collapse" aria-expanded="false" aria-controls="salary-list">
							<i class="ri-currency-line"></i>
							<span>Report </span>
							<span class="menu-arrow"></span>
						</a>
						<div class="collapse" id="salary-list">
							<ul class="nav-second-level">
								<li><a href="salary-for-bank">Salary for Bank</a></li>
								<li><a href="salary-report">Salary</a></li>
								<li><a href="lic-report">LIC</a></li>
							</ul>
						</div>
					</li>
					
					<li>
						<a href="#working-hour" data-bs-toggle="collapse" aria-expanded="false" aria-controls="working-hour">
							<i class="ri-time-line"></i>
							<span>Working Shift </span>
							<span class="menu-arrow"></span>
						</a>
						<div class="collapse" id="working-hour">
							<ul class="nav-second-level">
								<li><a href="view-shift">Shift Hour</a></li>
								<li><a href="#">Assign Shift</a></li>
								<li><a href="#">Modify Shift</a></li>
							</ul>
						</div>
					</li>
					
					<li>
						<a href="employee-history">
							<i class="mdi mdi-account-clock-outline"></i>
							<span>Employee History </span>
						</a>
					</li>
				<?php
				}
				?>
				

				<!--li>
					<a href="#sidebarMultilevel" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarMultilevel">
						<i class="ri-share-line"></i>
						<span> Multi Level </span>
						<span class="menu-arrow"></span>
					</a>
					<div class="collapse" id="sidebarMultilevel">
						<ul class="nav-second-level">
							<li>
								<a href="#sidebarMultilevel2" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarMultilevel2">
									Second Level <span class="menu-arrow"></span>
								</a>
								<div class="collapse" id="sidebarMultilevel2">
									<ul class="nav-second-level">
										<li>
											<a href="javascript: void(0);">Item 1</a>
										</li>
										<li>
											<a href="javascript: void(0);">Item 2</a>
										</li>
									</ul>
								</div>
							</li>

							<li>
								<a href="#sidebarMultilevel3" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarMultilevel3">
									Third Level <span class="menu-arrow"></span>
								</a>
								<div class="collapse" id="sidebarMultilevel3">
									<ul class="nav-second-level">
										<li>
											<a href="javascript: void(0);">Item 1</a>
										</li>
										<li>
											<a href="#sidebarMultilevel4" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarMultilevel4">
												Item 2 <span class="menu-arrow"></span>
											</a>
											<div class="collapse" id="sidebarMultilevel4">
												<ul class="nav-second-level">
													<li>
														<a href="javascript: void(0);">Item 1</a>
													</li>
													<li>
														<a href="javascript: void(0);">Item 2</a>
													</li>
												</ul>
											</div>
										</li>
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</li-->
			</ul>

		</div>
		<!-- End Sidebar -->

		<div class="clearfix"></div>

	</div>
	<!-- Sidebar -left -->

</div>