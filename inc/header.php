<?php
//$file = basename($_SERVER['PHP_SELF']);
//echo $no_of_line = count(file($file));
?>
<?php
$sql_header = "SELECT * FROM `employee` WHERE phone = '".$_SESSION['astro_email']."'";
$exe_header = $db->select($sql_header);
if($exe_header -> num_rows > 0){
	$record_header = $exe_header->fetch_array();

	if(file_exists($record_header['profile_pic'])){
		$profile_pic_header	= $record_header['profile_pic'];
	}else{
		$profile_pic_header	= 'assets/images/logo-light.png';
	}
}else{
	$profile_pic_header	= 'assets/images/logo-light.png';
}
?>
<div class="navbar-custom">
	<div class="container-fluid">

		<ul class="list-unstyled topnav-menu float-end mb-0">
			<li class="dropdown d-none d-lg-inline-block">
				<a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen" href="#">
					<i class="fe-maximize noti-icon"></i>
				</a>
			</li>
			<li id="google_translate_element"></li>
			<li class="dropdown notification-list topbar-dropdown">
				<a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
					<img src="<?= $profile_pic_header; ?>" alt="user-image" class="rounded-circle">
					<span class="pro-user-name ms-1">
						<?= $_SESSION['astro_name']; ?> <i class="mdi mdi-chevron-down"></i>
					</span>
				</a>
				<div class="dropdown-menu dropdown-menu-end profile-dropdown ">
					<a href="change-password" class="dropdown-item notify-item">
						<i class="fa fa-key"></i>
						<span>Change Password</span>
					</a>
					<a href="logout" class="dropdown-item notify-item">
						<i class="ri-logout-box-line"></i>
						<span>Logout</span>
					</a>
					

				</div>
			</li>

		</ul>

		<!-- LOGO -->
		<div class="logo-box">
			<a href="dashboard" class="logo logo-dark text-center">
				<span class="logo-sm">
					<img src="assets/images/logo-sm-dark.png" alt="" height="24">
					<!-- <span class="logo-lg-text-light">Minton</span> -->
				</span>
				<span class="logo-lg">
					<img src="assets/images/logo-dark.png" alt="" height="20">
					<!-- <span class="logo-lg-text-light">M</span> -->
				</span>
			</a>

			<a href="index-2.html" class="logo logo-light text-center">
				<span class="logo-sm">
					<img src="assets/images/logo-sm.png" alt="" height="24">
				</span>
				<span class="logo-lg">
					<img src="assets/images/logo-light.png" alt="" height="20">
				</span>
			</a>
		</div>

		<ul class="list-unstyled topnav-menu topnav-menu-left m-0">
			<li>
				<button class="button-menu-mobile waves-effect waves-light">
					<i class="fe-menu"></i>
				</button>
			</li>
			
			<li>
				<!-- Mobile menu toggle (Horizontal Layout)-->
				<a class="navbar-toggle nav-link" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
					<div class="lines">
						<span></span>
						<span></span>
						<span></span>
					</div>
				</a>
				<!-- End mobile menu toggle-->
			</li>   

		</ul>
		<div class="clearfix"></div>
	</div>
</div>

<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages : 'hi,en'}, 'google_translate_element');
}
</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>