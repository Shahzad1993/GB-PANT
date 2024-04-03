<?php
if(empty($_POST)){
    header("Location: ./");
}
include 'config/main.php';
$db = new Main;

date_default_timezone_set("Asia/Kolkata");

if(isset($_POST['login'])) {
    if(isset($_POST['g-recaptcha-response'])){
		$secret_key = '6Lc-uaspAAAAACoDGoOtg35KwRmlaSW5dF-IyTy_';
		$ip = $_SERVER['REMOTE_ADDR'];
		$response = $_POST['g-recaptcha-response'];
		$url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$response&remoteip=$ip";
		$result = file_get_contents($url);
		$result1 = json_decode($result,TRUE);
		
		if($result1['success']==1){
		    $mobile  	= mysqli_real_escape_string($db->link, $_POST['phone']);
        	$password1  = mysqli_real_escape_string($db->link, $_POST['password']);
        	
        	$password = md5($password1);
        	
        	$sql = "SELECT * FROM `login` WHERE mobile = '$mobile' and password='$password'";
        	$exe = $db->select($sql);
        	if ($exe->num_rows > 0) {
        		$record = $exe->fetch_array();
        		session_regenerate_id();
        		if($record['role']=='User'){
        			$sql1 = "SELECT * FROM `employee` WHERE phone = '".$record['mobile']."'";
        			$exe1 = $db->select($sql1);
        			$record1 = $exe1->fetch_array();
        			
        			$_SESSION['astro_email']= $record1['employee_code'];
        			$_SESSION['astro_role']	= $record['role'];
        		}else{
        			$_SESSION['astro_email']= $record['mobile'];
        			$_SESSION['astro_role']	= $record['role'];
        		}
        		$_SESSION['astro_name']	= $record['name'];
        		echo 'Success';
        		
        	}
        	else {
        		echo 'Invalid Mobile Number or Password!';
        	}
		}else{
		    echo "Captcha Not Verified!";
		}
		
	}else{
	    echo "Captcha Not Verified!";
	}
}

if(isset($_POST['verify_otp_admin'])){
	$mobile	= $_SESSION['mobile_otp'];
	$otp   = mysqli_real_escape_string($db->link, $_POST['otp']);
	
	$sql2 = "SELECT * FROM `otp` WHERE mobile = '$mobile' and otp='$otp'";
	$exe2 = $db->select($sql2);
	if ($exe2->num_rows > 0) {
		$qry4 = "DELETE from `otp` where mobile='$mobile'";
			if($db->delete($qry4)){
				$sql21 = "SELECT * FROM `login` WHERE mobile = '$mobile'";
				$exe21 = $db->select($sql21);
				$record21 = $exe21->fetch_array();
				
				unset($_SESSION['mobile_otp']);
				
				session_regenerate_id(true);

				if($record21['role']=='User'){
					$sql1 = "SELECT * FROM `employee` WHERE phone = '".$record21['mobile']."'";
					$exe1 = $db->select($sql1);
					$record1 = $exe1->fetch_array();
					
					$_SESSION['astro_email']= $record1['employee_code'];
					$_SESSION['astro_role']	= $record21['role'];
				}else{
					$_SESSION['astro_email']= $record21['mobile'];
					$_SESSION['astro_role']	= $record21['role'];
				}
				$_SESSION['astro_name']	= $record21['name'];
				echo 'Success';
			}else{
				echo 'Something went wrong!';
			}
	}else{
		echo 'Error';
	}
}

if(isset($_POST['add_department'])){
	$department			= mysqli_real_escape_string($db->link, $_POST['department']);
	$department     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$department);
	
	$department_head	= mysqli_real_escape_string($db->link, $_POST['department_head']);
	$department_head     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$department_head);
	
	$qry = "INSERT INTO `department` (`department`, `department_head`) VALUES ('$department', '$department_head')";
	if ($db->insert($qry)) {
		echo "Success";
	}else{
		echo "Something went wrong!";
	}
}

if(isset($_POST['update_department'])){
	$id					= mysqli_real_escape_string($db->link, $_POST['id']);
	$department			= mysqli_real_escape_string($db->link, $_POST['department']);
	$department     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$department);
	
	$department_head	= mysqli_real_escape_string($db->link, $_POST['department_head']);
	$department_head     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$department_head);
	
	$qry = "UPDATE `department` set `department`='$department', `department_head`='$department_head' where id='$id'";
	if ($db->insert($qry)) {
		echo "Success1";
	}else{
		echo "Something went wrong!";
	}
}



if(isset($_POST['add_division'])){
	$division		= mysqli_real_escape_string($db->link, $_POST['division']);
	$division     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$division);
	
	$mobile			= mysqli_real_escape_string($db->link, $_POST['mobile']);
	$mobile     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$mobile);
	
	$email			= mysqli_real_escape_string($db->link, $_POST['email']);
	$email     		= str_replace(array(":","<",">","~","!","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$email);
	
	$core_pass		= mysqli_real_escape_string($db->link, $_POST['password']);
	$password		= md5($core_pass);
	$location		= mysqli_real_escape_string($db->link, $_POST['location']);
	$lat_long		= mysqli_real_escape_string($db->link, $_POST['lat_long']);
	
	if($_POST['lat_long']==''){
		echo 'Please Draw a Location on Map!';
	}else{
		$sql = "SELECT * FROM `login` WHERE mobile = '$mobile'";
		$exe = $db->select($sql);
		if ($exe->num_rows > 0) {
			echo 'Mobile Number Already Exist!';
		}else{
			$qry = "INSERT INTO `division` (`division`,`location`,`lat_long`,`email`,`phone`) VALUES ('$division','$location','$lat_long','$email','$mobile')";
			if ($db->insert($qry)) {
				$qry1 = "INSERT INTO `login` (`name`,`password`,`core_pass`,`role`,`mobile`) VALUES ('$division','$password','$core_pass','Division','$mobile')";
				$db->insert($qry1);
				
				echo "Success";
			}else{
				echo "Something went wrong!";
			}
		}
	}
}

if(isset($_POST['update_division'])){
	$id				= mysqli_real_escape_string($db->link, $_POST['id']);
	$division		= mysqli_real_escape_string($db->link, $_POST['division']);
	$division     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","+","|","/","?","{","}","[","]",";",",",'"'),"",$division);
	
	$mobile			= mysqli_real_escape_string($db->link, $_POST['mobile']);
	$mobile     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$mobile);
	
	$email			= mysqli_real_escape_string($db->link, $_POST['email']);
	$email     		= str_replace(array(":","<",">","~","!","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$email);
	
	//$core_pass		= mysqli_real_escape_string($db->link, $_POST['password']);
	//$password		= md5($core_pass);
	$location		= mysqli_real_escape_string($db->link, $_POST['location']);
	$lat_long		= mysqli_real_escape_string($db->link, $_POST['lat_long']);
	
	if($_POST['lat_long']==''){
		echo 'Please Draw a Location on Map!';
	}else{
		$sql1 = "SELECT * FROM `division` WHERE id = '$id'";
		$exe1 = $db->select($sql1);
		$record1 = $exe1->fetch_array();
		$old_phone = $record1['phone'];
		
		$sql = "SELECT * FROM `login` WHERE mobile = '$mobile' and mobile!='$old_phone'";
		$exe = $db->select($sql);
		if ($exe->num_rows > 0) {
			echo 'Mobile Number Already Exist!';
		}else{
			$qry = "update `division` set `division`='$division', `location`='$location', `lat_long`='$lat_long', email='$email', phone='$mobile' where id='$id'";
			if ($db->insert($qry)) {
				
				$sql2 = "SELECT * FROM `login` WHERE mobile='$old_phone'";
				$exe2 = $db->select($sql2);
				if ($exe2->num_rows > 0) {
					//$qry1 = "UPDATE `login` set `name`='$division',`password`='$password',`core_pass`='$core_pass', mobile='$mobile' where mobile='$old_phone'";
					
					$qry1 = "UPDATE `login` set `name`='$division', mobile='$mobile' where mobile='$old_phone'";
					$db->insert($qry1);
				}else{
					//$qry1 = "INSERT INTO `login` (`name`,`password`,`core_pass`,`role`,`mobile`) VALUES ('$division','$password','$core_pass','Division','$mobile')";
					
					$qry1 = "INSERT INTO `login` (`name`,`role`,`mobile`) VALUES ('$division','Division','$mobile')";
					$db->insert($qry1);
				}
				
				echo "Success1";
			}else{
				echo "Something went wrong!";
			}
		}
	}
}

if(isset($_POST['update_hq'])){
	$id				= mysqli_real_escape_string($db->link, $_POST['id']);
	$division		= mysqli_real_escape_string($db->link, $_POST['division']);
	$division     = str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$division);
	
	$mobile			= mysqli_real_escape_string($db->link, $_POST['mobile']);
	$mobile     = str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$mobile);
	
	$email			= mysqli_real_escape_string($db->link, $_POST['email']);
	$email     = str_replace(array(":","<",">","~","!","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$email);
	
	//$core_pass		= mysqli_real_escape_string($db->link, $_POST['password']);
	//$password		= md5($core_pass);
	$location		= mysqli_real_escape_string($db->link, $_POST['location']);
	$lat_long		= mysqli_real_escape_string($db->link, $_POST['lat_long']);
	
	if($_POST['lat_long']==''){
		echo 'Please Draw a Location on Map!';
	}else{
		$sql1 = "SELECT * FROM `head_quarter` WHERE id = '$id'";
		$exe1 = $db->select($sql1);
		$record1 = $exe1->fetch_array();
		$old_phone = $record1['phone'];
		
		$sql = "SELECT * FROM `login` WHERE mobile = '$mobile' and mobile!='$old_phone'";
		$exe = $db->select($sql);
		if ($exe->num_rows > 0) {
			echo 'Phone Number Already Exist!';
		}else{
			$qry = "update `head_quarter` set `hq`='$division', `location`='$location', `lat_long`='$lat_long', email='$email', phone='$mobile' where id='$id'";
			if ($db->insert($qry)) {
				
				$sql2 = "SELECT * FROM `login` WHERE mobile='$old_phone'";
				$exe2 = $db->select($sql2);
				if ($exe2->num_rows > 0) {
					//$qry1 = "UPDATE `login` set `name`='$division',`mobile`='$mobile',`password`='$password',`core_pass`='$core_pass' where mobile='$old_phone'";
					
					$qry1 = "UPDATE `login` set `name`='$division',`mobile`='$mobile' where mobile='$old_phone'";
					$db->insert($qry1);
				}else{
					//$qry1 = "INSERT INTO `login` (`name`,`mobile`,`password`,`core_pass`,`role`) VALUES ('$division','$mobile','$password','$core_pass','Admin')";
					
					$qry1 = "INSERT INTO `login` (`name`,`mobile`,`role`) VALUES ('$division','$mobile','Admin')";
					$db->insert($qry1);
				}
				
				echo "Success1";
			}else{
				echo "Something went wrong!";
			}
		}
	}
}

if(isset($_POST['add_post'])){
	$post_name				= mysqli_real_escape_string($db->link, $_POST['post_name']);
	$post_name     = str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$post_name);
	
	$post_name_en			= mysqli_real_escape_string($db->link, $_POST['post_name_en']);
	$post_name_en     = str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$post_name_en);
	
	$no_of_post				= mysqli_real_escape_string($db->link, $_POST['no_of_post']);
	$reporting_authority	= mysqli_real_escape_string($db->link, $_POST['reporting_authority']);
	
	$qry = "INSERT INTO `post` (`post_name`, `post_name_en`, `no_of_post`, `reporting_authority`) VALUES ('$post_name', '$post_name_en', '$no_of_post', '$reporting_authority')";
	if ($db->insert($qry)) {
		echo "Success";
	}else{
		echo "Something went wrong!";
	}
}


if(isset($_POST['update_post'])){
	$id					= mysqli_real_escape_string($db->link, $_POST['id']);
	
	$post_name				= mysqli_real_escape_string($db->link, $_POST['post_name']);
	$post_name     = str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$post_name);
	
	$post_name_en			= mysqli_real_escape_string($db->link, $_POST['post_name_en']);
	$post_name_en     = str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$post_name_en);
	
	$no_of_post			= mysqli_real_escape_string($db->link, $_POST['no_of_post']);
	$reporting_authority	= mysqli_real_escape_string($db->link, $_POST['reporting_authority']);
	
	$qry = "UPDATE `post` set `post_name`='$post_name', `post_name_en`='$post_name_en', `no_of_post`='$no_of_post', reporting_authority='$reporting_authority' where id='$id'";
	if ($db->insert($qry)) {
		echo "Success1";
	}else{
		echo "Something went wrong!";
	}
}


if(isset($_POST['add_deport'])){
	$deport			= mysqli_real_escape_string($db->link, $_POST['deport']);
	$mobile			= mysqli_real_escape_string($db->link, $_POST['mobile']);
	$email			= mysqli_real_escape_string($db->link, $_POST['email']);
	$core_pass		= mysqli_real_escape_string($db->link, $_POST['password']);
	$password		= md5($core_pass);
	$location		= mysqli_real_escape_string($db->link, $_POST['location']);
	$lat_long		= mysqli_real_escape_string($db->link, $_POST['lat_long']);
	
	if($_POST['lat_long']==''){
		echo 'Please Draw a Location on Map!';
	}else{
		$sql = "SELECT * FROM `login` WHERE email = '$email'";
		$exe = $db->select($sql);
		if ($exe->num_rows > 0) {
			echo 'Email Already Exist!';
		}else{
			$qry = "INSERT INTO `deport` (`deport`,`location`,`lat_long`,`email`,`phone`) VALUES ('$deport','$location','$lat_long','$email','$mobile')";
			if ($db->insert($qry)) {
				$qry1 = "INSERT INTO `login` (`name`,`email`,`password`,`core_pass`,`role`,`mobile`) VALUES ('$deport','$email','$password','$core_pass','Depot','$mobile')";
				$db->insert($qry1);
				
				echo "Success";
			}else{
				echo "Something went wrong!";
			}
		}
	}
}


if(isset($_POST['update_deport'])){
	$id				= mysqli_real_escape_string($db->link, $_POST['id']);
	$deport			= mysqli_real_escape_string($db->link, $_POST['deport']);
	$mobile			= mysqli_real_escape_string($db->link, $_POST['mobile']);
	$email			= mysqli_real_escape_string($db->link, $_POST['email']);
	$core_pass		= mysqli_real_escape_string($db->link, $_POST['password']);
	$password		= md5($core_pass);
	$location		= mysqli_real_escape_string($db->link, $_POST['location']);
	$lat_long		= mysqli_real_escape_string($db->link, $_POST['lat_long']);
	
	if($_POST['lat_long']==''){
		echo 'Please Draw a Location on Map!';
	}else{
		$sql1 = "SELECT * FROM `deport` WHERE id = '$id'";
		$exe1 = $db->select($sql1);
		$record1 = $exe1->fetch_array();
		$old_email = $record1['email'];
		
		$sql = "SELECT * FROM `login` WHERE email = '$email' and email!='$old_email'";
		$exe = $db->select($sql);
		if ($exe->num_rows > 0) {
			echo 'Email Already Exist!';
		}else{
			$qry = "update `deport` set `deport`='$deport', `location`='$location', `lat_long`='$lat_long', email='$email', phone='$mobile' where id='$id'";
			if ($db->insert($qry)) {
				
				$sql2 = "SELECT * FROM `login` WHERE email='$old_email'";
				$exe2 = $db->select($sql2);
				if ($exe2->num_rows > 0) {
					$qry1 = "UPDATE `login` set `name`='$deport',`email`='$email',`password`='$password',`core_pass`='$core_pass', mobile='$mobile' where email='$old_email'";
					$db->insert($qry1);
				}else{
					$qry1 = "INSERT INTO `login` (`name`,`email`,`password`,`core_pass`,`role`,`mobile`) VALUES ('$deport','$email','$password','$core_pass','Depot','$mobile')";
					$db->insert($qry1);
				}
				
				echo "Success1";
			}else{
				echo "Something went wrong!";
			}
		}
	}
}

if(isset($_POST['add_employee'])){
	$employee_code		= mysqli_real_escape_string($db->link, $_POST['employee_code']);
	$employee_code     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$employee_code);
	
	$employee_name		= mysqli_real_escape_string($db->link, $_POST['employee_name']);
	$employee_name     = str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$employee_name);
	
	$department			= mysqli_real_escape_string($db->link, $_POST['department']);
	$employee_category	= mysqli_real_escape_string($db->link, $_POST['employee_category']);
	$post				= mysqli_real_escape_string($db->link, $_POST['post']);
	$work_location		= mysqli_real_escape_string($db->link, $_POST['work_location']);
	if(isset($_POST['office_name'])){
		$office_name	= mysqli_real_escape_string($db->link, $_POST['office_name']);
	}else{
		$office_name	= '';
	}
	
	$father_name		= mysqli_real_escape_string($db->link, $_POST['father_name']);
	$father_name     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$father_name);
	
	$mother_name		= mysqli_real_escape_string($db->link, $_POST['mother_name']);
	$mother_name     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$mother_name);
	
	$phone				= mysqli_real_escape_string($db->link, $_POST['phone']);
	$phone     			= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$phone);
	
	$gender				= mysqli_real_escape_string($db->link, $_POST['gender']);
	$dob				= mysqli_real_escape_string($db->link, $_POST['dob']);
	$address			= mysqli_real_escape_string($db->link, $_POST['address']);
	$address     		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$address);
	
	$state				= mysqli_real_escape_string($db->link, $_POST['state']);
	$state     			= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$state);
	
	$district			= mysqli_real_escape_string($db->link, $_POST['district']);
	$district     		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$district);
	
	$city				= mysqli_real_escape_string($db->link, $_POST['city']);
	$city     			= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$city);
	
	$cast				= mysqli_real_escape_string($db->link, $_POST['cast']);
	$grade_pay			= mysqli_real_escape_string($db->link, $_POST['grade_pay']);
	$grade_pay     		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$grade_pay);
	
	$basic_salary		= mysqli_real_escape_string($db->link, $_POST['basic_salary']);
	$basic_salary     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$basic_salary);
	
	$doj				= mysqli_real_escape_string($db->link, $_POST['doj']);
	$nominee			= mysqli_real_escape_string($db->link, $_POST['nominee']);
	$nominee     		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$nominee);
	
	$nominee_relation	= mysqli_real_escape_string($db->link, $_POST['nominee_relation']);
	$nominee_relation   = str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$nominee_relation);
	
	$no_of_dependent	= mysqli_real_escape_string($db->link, $_POST['no_of_dependent']);
	$no_of_dependent    = str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$no_of_dependent);
	
	$epf_no				= mysqli_real_escape_string($db->link, $_POST['epf_no']);
	$epf_no    			= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$epf_no);
	
	$esi_no				= mysqli_real_escape_string($db->link, $_POST['esi_no']);
	$esi_no   	 		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$esi_no);
	
	$pan_no				= mysqli_real_escape_string($db->link, $_POST['pan_no']);
	$pan_no    			= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$pan_no);
	
	$aadhaar_no			= mysqli_real_escape_string($db->link, $_POST['aadhaar_no']);
	$aadhaar_no    		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$aadhaar_no);
	
	$bank_name			= mysqli_real_escape_string($db->link, $_POST['bank_name']);
	$bank_name    		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$bank_name);
	
	$ifsc_code			= mysqli_real_escape_string($db->link, $_POST['ifsc_code']);
	$ifsc_code    		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$ifsc_code);
	
	$account_no			= mysqli_real_escape_string($db->link, $_POST['account_no']);
	$account_no    		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$account_no);
	
	$ir					= mysqli_real_escape_string($db->link, $_POST['ir']);
	$ir    				= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$ir);
	
	$cycle_ph_allowence	= mysqli_real_escape_string($db->link, $_POST['cycle_ph_allowence']);
	$cycle_ph_allowence = str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$cycle_ph_allowence);
	
	$cash_handling_allowence= mysqli_real_escape_string($db->link, $_POST['cash_handling_allowence']);
	$cash_handling_allowence= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$cash_handling_allowence);
	
	$pollution_allowence= mysqli_real_escape_string($db->link, $_POST['pollution_allowence']);
	$pollution_allowence= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$pollution_allowence);
	
	$washing_allowence	= mysqli_real_escape_string($db->link, $_POST['washing_allowence']);
	$washing_allowence  = str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$washing_allowence);
	
	$society			= mysqli_real_escape_string($db->link, $_POST['society']);
	$society    		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$society);
	
	$staff_car			= mysqli_real_escape_string($db->link, $_POST['staff_car']);
	$staff_car    		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$staff_car);
	
	$house_maintenance	= mysqli_real_escape_string($db->link, $_POST['house_maintenance']);
	$house_maintenance  = str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$house_maintenance);
	
	$electricity		= mysqli_real_escape_string($db->link, $_POST['electricity']);
	$electricity    	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$electricity);
	
	$attendance_type	= mysqli_real_escape_string($db->link, $_POST['attendance_type']);
	$weekly_rest		= mysqli_real_escape_string($db->link, $_POST['weekly_rest']);
	
	$sql = "SELECT * FROM `employee` WHERE employee_code = '$employee_code'";
	$exe = $db->select($sql);
	if ($exe->num_rows > 0) {
		echo 'Employee Code Already Exist!';
	}else{
		$sql1 = "SELECT * FROM `login` WHERE mobile = '$phone'";
		$exe1 = $db->select($sql1);
		if ($exe1->num_rows > 0) {
			echo 'Phone Number Already Exist!';
		}else{
			$qry = "INSERT INTO `employee` (`employee_code`, `employee_name`, `department`, `employee_category`, `post`, `work_location`, `office_name`, `father_name`, `mother_name`, `phone`, `gender`, `dob`, `address`, `state`, `district`, `city`, `cast`, `doj`, `nominee`, `nominee_relation`, `no_of_dependent`, `grade_pay`, `basic_salary`, `epf_no`, `esi_no`, `pan_no`, `aadhaar_no`, `bank_name`, `ifsc_code`, `account_no`,`ir`,`cycle_ph_allowence`,`cash_handling_allowence`,`pollution_allowence`,`washing_allowence`,`society`,`staff_car`,`house_maintenance`,`electricity`,`attendance_type`,`weekly_rest`) VALUES ('$employee_code', '$employee_name', '$department', '$employee_category', '$post', '$work_location', '$office_name', '$father_name', '$mother_name', '$phone', '$gender', '$dob', '$address', '$state', '$district', '$city', '$cast', '$doj', '$nominee', '$nominee_relation', '$no_of_dependent', '$grade_pay', '$basic_salary', '$epf_no', '$esi_no', '$pan_no', '$aadhaar_no', '$bank_name', '$ifsc_code', '$account_no', '$ir', '$cycle_ph_allowence', '$cash_handling_allowence', '$pollution_allowence', '$washing_allowence', '$society', '$staff_car', '$house_maintenance', '$electricity','$attendance_type','$weekly_rest')";
			if ($db->insert($qry)) {
				$last_id = $db->link->insert_id;
				$password = md5($phone);
				$qry1 = "INSERT into `login` (employee_code,name,password,core_pass,role,mobile) values ('$employee_code','$employee_name','$password','$phone','User','$phone')";
				$db->insert($qry1);
				
				if(isset($_POST['member_name'])){
					$size = sizeof($_POST['member_name']);
					for($i=0; $i < $size; $i++){
						$member_name		= $_POST['member_name'][$i];
						$member_name    	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$member_name);
						
						$relation			= $_POST['relation'][$i];
						$relation    		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$relation);
						
						$member_age			= $_POST['member_age'][$i];
						$member_age    		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$member_age);
						
						$member_aadhaar_no	= $_POST['member_aadhaar_no'][$i];
						$member_aadhaar_no  = str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$member_aadhaar_no);
						
						$qry2 = "INSERT INTO `family_member` (`employee_code`, `member_name`, `relation`, `member_age`, `member_aadhaar_no`) VALUES ('$employee_code', '$member_name', '$relation', '$member_age', '$member_aadhaar_no')";
						if($db->insert($qry2)){
							$last_id1 = $db->link->insert_id;
							/*if($_FILES["member_aadhaar_copy"]["name"][$i] != '')
							{
								$test = explode('.', $_FILES["member_aadhaar_copy"]["name"][$i]);
								$ext = end($test);
								$name = rand(10000, 99999) . '.' . $ext;
								$location = 'assets/images/employee_pic/' . $name;  
								if(move_uploaded_file($_FILES["member_aadhaar_copy"]["tmp_name"][$i], $location))
								{
									$query="update family_member set member_aadhaar_copy='$location' where id='$last_id1'";
									$db->insert($query);
								}
							}*/
							
							if($_FILES["member_aadhaar_copy"]["name"][$i] != '') {
								$allowedExtensions = array('jpg', 'jpeg', 'png'); // Allowed file extensions
								$maxFileSize = 1 * 1024 * 1024; // Maximum file size in bytes (1 MB)

								$test = explode('.', $_FILES["member_aadhaar_copy"]["name"][$i]);
								$ext = strtolower(end($test)); // Get the file extension and convert to lowercase
								$name = rand(10000, 99999) . '.' . $ext;
								$location = 'assets/images/employee_pic/' . $name;

								if (!in_array($ext, $allowedExtensions)) {
									// File extension is not allowed
								} elseif ($_FILES["member_aadhaar_copy"]["size"][$i] > $maxFileSize) {
									// Check if the file size exceeds the maximum allowed size
								} elseif (move_uploaded_file($_FILES["member_aadhaar_copy"]["tmp_name"][$i], $location)) {
									$query = "UPDATE family_member SET member_aadhaar_copy='$location' WHERE id='$last_id1'";
									$db->insert($query);
								} else {
									// Error occurred while uploading the file
								}
							}
							
						}
					}
				}
				
				if(isset($_POST['lic_number'])){
					$size1 = sizeof($_POST['lic_number']);
					for($i=0; $i < $size1; $i++){
						$lic_number		= $_POST['lic_number'][$i];
						$lic_premium			= $_POST['lic_premium'][$i];
						
						$qry2 = "INSERT INTO `lic_data` (`employee_code`, `lic_number`, `lic_premium`) VALUES ('$employee_code', '$lic_number', '$lic_premium')";
						$db->insert($qry2);
					}
				}
				
				if($_FILES["employee_pic"]["name"] != '') {
					$allowedExtensions = array('jpg', 'jpeg', 'png'); // Allowed file extensions
					$maxFileSize = 1 * 1024 * 1024; // Maximum file size in bytes (1 MB)

					$test = explode('.', $_FILES["employee_pic"]["name"]);
					$ext = strtolower(end($test)); // Get the file extension and convert to lowercase
					$name = rand(10000, 99999) . '.' . $ext;
					$location = 'assets/images/employee_pic/' . $name;

					if (!in_array($ext, $allowedExtensions)) {
						// File extension is not allowed
					} elseif ($_FILES["employee_pic"]["size"] > $maxFileSize) {
						// Check if the file size exceeds the maximum allowed size
					} elseif (move_uploaded_file($_FILES["employee_pic"]["tmp_name"], $location)) {
						$query="update employee set employee_pic='$location' where id='$last_id'";
						$db->insert($query);
					} else {
						// Error occurred while uploading the file
					}
				}
				
				if($_FILES["aadhaar_card_copy"]["name"] != '') {
					$allowedExtensions = array('jpg', 'jpeg', 'png'); // Allowed file extensions
					$maxFileSize = 1 * 1024 * 1024; // Maximum file size in bytes (1 MB)

					$test = explode('.', $_FILES["aadhaar_card_copy"]["name"]);
					$ext = strtolower(end($test)); // Get the file extension and convert to lowercase
					$name = rand(10000, 99999) . '.' . $ext;
					$location = 'assets/images/employee_pic/' . $name;

					if (!in_array($ext, $allowedExtensions)) {
						// File extension is not allowed
					} elseif ($_FILES["aadhaar_card_copy"]["size"] > $maxFileSize) {
						// Check if the file size exceeds the maximum allowed size
					} elseif (move_uploaded_file($_FILES["aadhaar_card_copy"]["tmp_name"], $location)) {
						$query="update employee set aadhaar_card_copy='$location' where id='$last_id'";
						$db->insert($query);
					} else {
						// Error occurred while uploading the file
					}
				}
				
				if($_FILES["pan_card_copy"]["name"] != '') {
					$allowedExtensions = array('jpg', 'jpeg', 'png'); // Allowed file extensions
					$maxFileSize = 1 * 1024 * 1024; // Maximum file size in bytes (1 MB)

					$test = explode('.', $_FILES["pan_card_copy"]["name"]);
					$ext = strtolower(end($test)); // Get the file extension and convert to lowercase
					$name = rand(10000, 99999) . '.' . $ext;
					$location = 'assets/images/employee_pic/' . $name;

					if (!in_array($ext, $allowedExtensions)) {
						// File extension is not allowed
					} elseif ($_FILES["pan_card_copy"]["size"] > $maxFileSize) {
						// Check if the file size exceeds the maximum allowed size
					} elseif (move_uploaded_file($_FILES["pan_card_copy"]["tmp_name"], $location)) {
						$query="update employee set pan_card_copy='$location' where id='$last_id'";
						$db->insert($query);
					} else {
						// Error occurred while uploading the file
					}
				}
				
				echo "Success";
			}else{
				echo "Something went wrong!";
			}
		}
	}
}

if(isset($_POST['update_employee'])){
	//$id					= mysqli_real_escape_string($db->link, $_POST['id']);
	$employee_code		= mysqli_real_escape_string($db->link, $_POST['employee_code']);
	
	$employee_name		= mysqli_real_escape_string($db->link, $_POST['employee_name']);
	$employee_name     = str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$employee_name);
	
	$department			= mysqli_real_escape_string($db->link, $_POST['department']);
	$employee_category	= mysqli_real_escape_string($db->link, $_POST['employee_category']);
	$post				= mysqli_real_escape_string($db->link, $_POST['post']);
	$work_location		= mysqli_real_escape_string($db->link, $_POST['work_location']);
	if(isset($_POST['office_name'])){
		$office_name	= mysqli_real_escape_string($db->link, $_POST['office_name']);
	}else{
		$office_name	= '';
	}
	
	$father_name		= mysqli_real_escape_string($db->link, $_POST['father_name']);
	$father_name     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$father_name);
	
	$mother_name		= mysqli_real_escape_string($db->link, $_POST['mother_name']);
	$mother_name     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$mother_name);
	
	$phone				= mysqli_real_escape_string($db->link, $_POST['phone']);
	$phone     			= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$phone);
	
	$gender				= mysqli_real_escape_string($db->link, $_POST['gender']);
	$dob				= mysqli_real_escape_string($db->link, $_POST['dob']);
	$address			= mysqli_real_escape_string($db->link, $_POST['address']);
	$address     		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$address);
	
	$state				= mysqli_real_escape_string($db->link, $_POST['state']);
	$state     			= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$state);
	
	$district			= mysqli_real_escape_string($db->link, $_POST['district']);
	$district     		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$district);
	
	$city				= mysqli_real_escape_string($db->link, $_POST['city']);
	$city     			= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$city);
	
	$cast				= mysqli_real_escape_string($db->link, $_POST['cast']);
	$grade_pay			= mysqli_real_escape_string($db->link, $_POST['grade_pay']);
	$grade_pay     		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$grade_pay);
	
	$basic_salary		= mysqli_real_escape_string($db->link, $_POST['basic_salary']);
	$basic_salary     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$basic_salary);
	
	$doj				= mysqli_real_escape_string($db->link, $_POST['doj']);
	$nominee			= mysqli_real_escape_string($db->link, $_POST['nominee']);
	$nominee     		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$nominee);
	
	$nominee_relation	= mysqli_real_escape_string($db->link, $_POST['nominee_relation']);
	$nominee_relation   = str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$nominee_relation);
	
	$no_of_dependent	= mysqli_real_escape_string($db->link, $_POST['no_of_dependent']);
	$no_of_dependent    = str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$no_of_dependent);
	
	$epf_no				= mysqli_real_escape_string($db->link, $_POST['epf_no']);
	$epf_no    			= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$epf_no);
	
	$esi_no				= mysqli_real_escape_string($db->link, $_POST['esi_no']);
	$esi_no   	 		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$esi_no);
	
	$pan_no				= mysqli_real_escape_string($db->link, $_POST['pan_no']);
	$pan_no    			= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$pan_no);
	
	$aadhaar_no			= mysqli_real_escape_string($db->link, $_POST['aadhaar_no']);
	$aadhaar_no    		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$aadhaar_no);
	
	$bank_name			= mysqli_real_escape_string($db->link, $_POST['bank_name']);
	$bank_name    		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$bank_name);
	
	$ifsc_code			= mysqli_real_escape_string($db->link, $_POST['ifsc_code']);
	$ifsc_code    		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$ifsc_code);
	
	$account_no			= mysqli_real_escape_string($db->link, $_POST['account_no']);
	$account_no    		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$account_no);
	
	$ir					= mysqli_real_escape_string($db->link, $_POST['ir']);
	$ir    				= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$ir);
	
	$cycle_ph_allowence	= mysqli_real_escape_string($db->link, $_POST['cycle_ph_allowence']);
	$cycle_ph_allowence = str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$cycle_ph_allowence);
	
	$cash_handling_allowence= mysqli_real_escape_string($db->link, $_POST['cash_handling_allowence']);
	$cash_handling_allowence= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$cash_handling_allowence);
	
	$pollution_allowence= mysqli_real_escape_string($db->link, $_POST['pollution_allowence']);
	$pollution_allowence= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$pollution_allowence);
	
	$washing_allowence	= mysqli_real_escape_string($db->link, $_POST['washing_allowence']);
	$washing_allowence  = str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$washing_allowence);
	
	$society			= mysqli_real_escape_string($db->link, $_POST['society']);
	$society    		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$society);
	
	$staff_car			= mysqli_real_escape_string($db->link, $_POST['staff_car']);
	$staff_car    		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$staff_car);
	
	$house_maintenance	= mysqli_real_escape_string($db->link, $_POST['house_maintenance']);
	$house_maintenance  = str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$house_maintenance);
	
	$electricity		= mysqli_real_escape_string($db->link, $_POST['electricity']);
	$electricity    	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$electricity);
	
	
	$attendance_type	= mysqli_real_escape_string($db->link, $_POST['attendance_type']);
	$weekly_rest		= mysqli_real_escape_string($db->link, $_POST['weekly_rest']);
	
	$sql = "SELECT * FROM `employee` WHERE phone = '$phone' and employee_code != '$employee_code'";
	$exe = $db->select($sql);
	if ($exe->num_rows > 0) {
		echo 'Phone Number Already Exist!';
	}else{
		$qry = "UPDATE `employee` set `employee_name`='$employee_name', `department`='$department', `employee_category`='$employee_category', `post`='$post', `work_location`='$work_location', `office_name`='$office_name', `father_name`='$father_name', `mother_name`='$mother_name', `phone`='$phone', `gender`='$gender', `dob`='$dob', `address`='$address', `state`='$state', `district`='$district', `city`='$city', `cast`='$cast', `doj`='$doj', `nominee`='$nominee', `nominee_relation`='$nominee_relation', `no_of_dependent`='$no_of_dependent', `grade_pay`='$grade_pay', `basic_salary`='$basic_salary', `epf_no`='$epf_no', `esi_no`='$esi_no', `pan_no`='$pan_no', `aadhaar_no`='$aadhaar_no', `bank_name`='$bank_name', `ifsc_code`='$ifsc_code', `account_no`='$account_no',`ir`='$ir',`cycle_ph_allowence`='$cycle_ph_allowence',`cash_handling_allowence`='$cash_handling_allowence',`pollution_allowence`='$pollution_allowence',`washing_allowence`='$washing_allowence',`society`='$society',`staff_car`='$staff_car',`house_maintenance`='$house_maintenance',`electricity`='$electricity',`attendance_type`='$attendance_type', weekly_rest='$weekly_rest' where employee_code='$employee_code'";
		if ($db->insert($qry)) {
			$password = md5($phone);
			$qry1 = "UPDATE `login` set name='$employee_name', password='$password', core_pass='$phone', role='User', mobile='$phone' where employee_code='$employee_code'";
			$db->insert($qry1);
			
			$qry4="delete from family_member where employee_code='$employee_code'";
			$db->delete($qry4);
			
			if(isset($_POST['member_name'])){
				$size = sizeof($_POST['member_name']);
				for($i=0; $i < $size; $i++){
					$member_name		= $_POST['member_name'][$i];
					$member_name    	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$member_name);
					
					$relation			= $_POST['relation'][$i];
					$relation    		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$relation);
					
					$member_age			= $_POST['member_age'][$i];
					$member_age    		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$member_age);
					
					$member_aadhaar_no	= $_POST['member_aadhaar_no'][$i];
					$member_aadhaar_no  = str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$member_aadhaar_no);
					
					$qry2 = "INSERT INTO `family_member` (`employee_code`, `member_name`, `relation`, `member_age`, `member_aadhaar_no`) VALUES ('$employee_code', '$member_name', '$relation', '$member_age', '$member_aadhaar_no')";
					if($db->insert($qry2)){
						$last_id1 = $db->link->insert_id;
						/*if($_FILES["member_aadhaar_copy"]["name"][$i] != '')
						{
							$test = explode('.', $_FILES["member_aadhaar_copy"]["name"][$i]);
							$ext = end($test);
							$name = rand(10000, 99999) . '.' . $ext;
							$location = 'assets/images/employee_pic/' . $name;  
							if(move_uploaded_file($_FILES["member_aadhaar_copy"]["tmp_name"][$i], $location))
							{
								$query="update family_member set member_aadhaar_copy='$location' where id='$last_id1'";
								$db->insert($query);
							}
						}*/
						
						if($_FILES["member_aadhaar_copy"]["name"][$i] != '') {
							$allowedExtensions = array('jpg', 'jpeg', 'png'); // Allowed file extensions
							$maxFileSize = 1 * 1024 * 1024; // Maximum file size in bytes (1 MB)

							$test = explode('.', $_FILES["member_aadhaar_copy"]["name"][$i]);
							$ext = strtolower(end($test)); // Get the file extension and convert to lowercase
							$name = rand(10000, 99999) . '.' . $ext;
							$location = 'assets/images/employee_pic/' . $name;

							// Check if the file extension is allowed
							if (!in_array($ext, $allowedExtensions)) {
								// File extension is not allowed
								// Handle the error or reject the file
							} elseif ($_FILES["member_aadhaar_copy"]["size"][$i] > $maxFileSize) {
								// Check if the file size exceeds the maximum allowed size
								// Handle the error or reject the file
							} elseif (move_uploaded_file($_FILES["member_aadhaar_copy"]["tmp_name"][$i], $location)) {
								// File uploaded successfully
								$query = "UPDATE family_member SET member_aadhaar_copy='$location' WHERE id='$last_id1'";
								$db->insert($query);
							} else {
								// Error occurred while uploading the file
							}
						}
						
					}
				}
			}
			
			$qry5="delete from lic_data where employee_code='$employee_code'";
			$db->delete($qry5);
			if(isset($_POST['lic_number'])){
				$size1 = sizeof($_POST['lic_number']);
				for($i=0; $i < $size1; $i++){
					$lic_number		= $_POST['lic_number'][$i];
					$lic_premium			= $_POST['lic_premium'][$i];
					
					$qry2 = "INSERT INTO `lic_data` (`employee_code`, `lic_number`, `lic_premium`) VALUES ('$employee_code', '$lic_number', '$lic_premium')";
					$db->insert($qry2);
				}
			}
			
			if($_FILES["employee_pic"]["name"] != '') {
					$allowedExtensions = array('jpg', 'jpeg', 'png'); // Allowed file extensions
					$maxFileSize = 1 * 1024 * 1024; // Maximum file size in bytes (1 MB)

					$test = explode('.', $_FILES["employee_pic"]["name"]);
					$ext = strtolower(end($test)); // Get the file extension and convert to lowercase
					$name = rand(10000, 99999) . '.' . $ext;
					$location = 'assets/images/employee_pic/' . $name;

					if (!in_array($ext, $allowedExtensions)) {
						// File extension is not allowed
					} elseif ($_FILES["employee_pic"]["size"] > $maxFileSize) {
						// Check if the file size exceeds the maximum allowed size
					} elseif (move_uploaded_file($_FILES["employee_pic"]["tmp_name"], $location)) {
						$query="update employee set employee_pic='$location' where id='$last_id'";
						$db->insert($query);
					} else {
						// Error occurred while uploading the file
					}
				}
				
				if($_FILES["aadhaar_card_copy"]["name"] != '') {
					$allowedExtensions = array('jpg', 'jpeg', 'png'); // Allowed file extensions
					$maxFileSize = 1 * 1024 * 1024; // Maximum file size in bytes (1 MB)

					$test = explode('.', $_FILES["aadhaar_card_copy"]["name"]);
					$ext = strtolower(end($test)); // Get the file extension and convert to lowercase
					$name = rand(10000, 99999) . '.' . $ext;
					$location = 'assets/images/employee_pic/' . $name;

					if (!in_array($ext, $allowedExtensions)) {
						// File extension is not allowed
					} elseif ($_FILES["aadhaar_card_copy"]["size"] > $maxFileSize) {
						// Check if the file size exceeds the maximum allowed size
					} elseif (move_uploaded_file($_FILES["aadhaar_card_copy"]["tmp_name"], $location)) {
						$query="update employee set aadhaar_card_copy='$location' where id='$last_id'";
						$db->insert($query);
					} else {
						// Error occurred while uploading the file
					}
				}
				
				if($_FILES["pan_card_copy"]["name"] != '') {
					$allowedExtensions = array('jpg', 'jpeg', 'png'); // Allowed file extensions
					$maxFileSize = 1 * 1024 * 1024; // Maximum file size in bytes (1 MB)

					$test = explode('.', $_FILES["pan_card_copy"]["name"]);
					$ext = strtolower(end($test)); // Get the file extension and convert to lowercase
					$name = rand(10000, 99999) . '.' . $ext;
					$location = 'assets/images/employee_pic/' . $name;

					if (!in_array($ext, $allowedExtensions)) {
						// File extension is not allowed
					} elseif ($_FILES["pan_card_copy"]["size"] > $maxFileSize) {
						// Check if the file size exceeds the maximum allowed size
					} elseif (move_uploaded_file($_FILES["pan_card_copy"]["tmp_name"], $location)) {
						$query="update employee set pan_card_copy='$location' where id='$last_id'";
						$db->insert($query);
					} else {
						// Error occurred while uploading the file
					}
				}
			
			echo "Success1";
		}else{
			echo "Something went wrong!";
		}
	}
}



if(isset($_POST['action1'])){
	if($_POST['action1']=='fetch_reporting_manager'){
		$output = '<option value="">~~~Choose~~~</option>';
		
		$query="select * from post where id='".$_POST['query1']."'";
		$row=$db->select($query);
		while($record=$row->fetch_array()){
			$query1="select * from post where id='".$record['reporting_manager']."'";
			$row1=$db->select($query1);
			if ($row1->num_rows > 0) {
				$record1=$row1->fetch_array();
				
				$output .= '<option value="'.$record1['id'].'">'.$record1['post_name'].'</option>';
			}
		}
		echo $output;
	}	
}


if(isset($_POST['action2'])){
	if($_POST['action2']=='fetch_deport'){
		$output = '<option value="">~~~Choose~~~</option>';
		
		$query="select * from deport where division='".$_POST['query2']."'";
		$row=$db->select($query);
		while($record=$row->fetch_array()){
			$output .= '<option value="'.$record['id'].'">'.$record['deport'].'</option>';
		}
		echo $output;
	}	
}


if(isset($_POST['action3'])){
	if($_POST['action3']=='fetch_division'){
		$output = '';
		if($_POST['query3']=='Division'){
			$output .='<label class="form-label">College Name</label>
			<select name="office_name" id="office_name" class="form-control" required>';
			$output .= '<option value="">---</option>';
			$query="select * from division";
			$row=$db->select($query);
			while($record=$row->fetch_array()){
				$output .= '<option value="'.$record['id'].'">'.$record['division'].'</option>';
			}
			$output .='</select>';
		}else if($_POST['query3']=='Depot'){
			$output .='<label class="form-label">Depot</label>
			<select name="office_name" id="office_name" class="form-control" required>';
			$output .= '<option value="">---</option>';
			$query="select * from deport";
			$row=$db->select($query);
			while($record=$row->fetch_array()){
				$output .= '<option value="'.$record['id'].'">'.$record['deport'].'</option>';
			}
			$output .='</select>';
		}
		
		echo $output;
	}	
}

if(isset($_POST['action3_2'])){
	if($_POST['action3_2']=='fetch_post'){
		$output = '<option value="">---</option>';
		$query="select * from post order by post_name_en asc";
		$row=$db->select($query);
		while($record=$row->fetch_array()){
			$output .= '<option value="'.$record['id'].'">'.$record['post_name_en'].'</option>';
		}
		echo $output;
	}	
}

if(isset($_POST['action3_3'])){
	if($_POST['action3_3']=='fetch_post'){
		$output = '';
		$output .= '<label class="form-label">पदनाम</label>
			<select name="present_post" id="present_post" onchange="action20_21(this.value)" class="form-control" required>
				<option value="">---</option>';
				$query="select employee.post, post.post_name_en from employee inner join post on employee.post=post.id where employee.work_location = '".$_POST['work_location']."' and office_name='".$_POST['query3_3']."' group by post.post_name_en asc";
				$row=$db->select($query);
				while($record=$row->fetch_array()){
					$output .= '<option value="'.$record['post'].'">'.$record['post_name_en'].'</option>';
				}
			$output .='</select>';
		echo $output;
	}	
}


if(isset($_POST['action3_3_1'])){
	if($_POST['action3_3_1']=='fetch_post'){
		$output = '';
		$output .= '<label class="form-label">पदनाम</label>
			<select name="present_post'.$_POST['sn'].'" id="present_post'.$_POST['sn'].'" onchange="action21_00(this.value,'.$_POST['sn'].')" class="form-control" required>
				<option value="">---</option>';
				$query="select employee.post, post.post_name_en from employee inner join post on employee.post=post.id where employee.work_location = '".$_POST['work_location']."' and office_name='".$_POST['query3_3_1']."' group by post.post_name_en asc";
				$row=$db->select($query);
				while($record=$row->fetch_array()){
					$output .= '<option value="'.$record['post'].'">'.$record['post_name_en'].'</option>';
				}
			$output .='</select>';
		echo $output;
	}	
}


if(isset($_POST['action20_2'])){
	if($_POST['action20_2']=='fetch_authority_post'){
		$output = '';
		$post = '';
		$query="select employee.post, post.post_name_en from employee inner join post on employee.post=post.id where employee.work_location = '".$_POST['work_location']."' and employee.post!='".$_POST['query20_2']."' group by post.post_name_en asc";
		$row=$db->select($query);
		while($record=$row->fetch_array()){
			$post .= '<option value="'.$record['post'].'">'.$record['post_name_en'].'</option>';
		}
		
		$work_location = '';
		$query1="select * from work_location";
		$row1=$db->select($query1);
		while($record1=$row1->fetch_array()){
			$work_location .='<option value="'.$record1['work_location'].'">'.$record1['work_location_name'].'</option>';
		}
		
		$output .= '<tr>
			<td>1</td>
			<td>प्रतिवेदक प्राधिकारी</td>
			<td>
				<select name="reporting_authority_work_location" id="work_location1" onchange="action3_11(this.value,1)" class="form-control" required>
					<option value="">---</option>'.
					$work_location
				.'</select>
			</td>
			<td id="dep_div_data1">
				<select class="form-control" required>
					<option value="">---</option>
				</select>
			</td>
			<td id="post_name_data1">
				<select name="reporting_authority_post" id="present_post1" onchange="action21_00(this.value,1)" class="form-control authority_post" required>
					<option value="">---</option></select>
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
				<select name="reviewing_authority_work_location" id="work_location2" onchange="action3_11(this.value,2)" class="form-control" required>
					<option value="">---</option>'.
					$work_location
				.'</select>
			</td>
			<td id="dep_div_data2">
				<select class="form-control" required>
					<option value="">---</option>
				</select>
			</td>
			<td id="post_name_data2">
				<select name="reviewing_authority_post" id="present_post2" onchange="action21_00(this.value,2)" class="form-control authority_post" required>
					<option value="">---</option></select>
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
				<select name="accepting_authority_work_location" id="work_location3" onchange="action3_11(this.value,3)" class="form-control" required>
					<option value="">---</option>'.
					$work_location
				.'</select>
			</td>
			<td id="dep_div_data3">
				<select class="form-control" required>
					<option value="">---</option>
				</select>
			</td>
			<td id="post_name_data3">
				<select name="accepting_authority_post" id="present_post3" onchange="action21_00(this.value,3)" class="form-control authority_post" required>
					<option value="">---</option></select>
			</td>
			<td>
				<select name="accepting_authority_name" id="authority_name3" class="form-control" required>
					<option value="">---</option>
				</select>
			</td>
		</tr>';
		
		echo $output;
	}	
}

if(isset($_POST['action20_21'])){
	if($_POST['action20_21']=='fetch_authority_post'){
		$output = '';
		$post = '';
		$query="select employee.post, post.post_name_en from employee inner join post on employee.post=post.id where employee.work_location = '".$_POST['work_location']."' and employee.office_name = '".$_POST['office_name']."' and employee.post!='".$_POST['query20_21']."' group by post.post_name_en asc";
		$row=$db->select($query);
		while($record=$row->fetch_array()){
			$post .= '<option value="'.$record['post'].'">'.$record['post_name_en'].'</option>';
		}
		
		$work_location = '';
		$query1="select * from work_location";
		$row1=$db->select($query1);
		while($record1=$row1->fetch_array()){
			$work_location .='<option value="'.$record1['work_location'].'">'.$record1['work_location_name'].'</option>';
		}
		
		$output .= '<tr>
			<td>1</td>
			<td>प्रतिवेदक प्राधिकारी</td>
			<td>
				<select name="reporting_authority_work_location" id="work_location1" onchange="action3_11(this.value,1)" class="form-control" required>
					<option value="">---</option>'.
					$work_location
				.'</select>
			</td>
			<td id="dep_div_data1">
				<select class="form-control" required>
					<option value="">---</option>
				</select>
			</td>
			<td id="post_name_data1">
				<select name="reporting_authority_post" id="present_post1" onchange="action21_00(this.value,1)" class="form-control authority_post" required>
					<option value="">---</option></select>
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
				<select name="reviewing_authority_work_location" id="work_location2" onchange="action3_11(this.value,2)" class="form-control" required>
					<option value="">---</option>'.
					$work_location
				.'</select>
			</td>
			<td id="dep_div_data2">
				<select class="form-control" required>
					<option value="">---</option>
				</select>
			</td>
			<td id="post_name_data2">
				<select name="reviewing_authority_post" id="present_post2" onchange="action21_00(this.value,2)" class="form-control authority_post" required>
					<option value="">---</option></select>
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
				<select name="accepting_authority_work_location" id="work_location3" onchange="action3_11(this.value,3)" class="form-control" required>
					<option value="">---</option>'.
					$work_location
				.'</select>
			</td>
			<td id="dep_div_data3">
				<select class="form-control" required>
					<option value="">---</option>
				</select>
			</td>
			<td id="post_name_data3">
				<select name="accepting_authority_post" id="present_post3" onchange="action21_00(this.value,3)" class="form-control authority_post" required>
					<option value="">---</option></select>
			</td>
			<td>
				<select name="accepting_authority_name" id="authority_name3" class="form-control" required>
					<option value="">---</option>
				</select>
			</td>
		</tr>';
		
		echo $output;
	}	
}

if(isset($_POST['action3_1'])){
	if($_POST['action3_1']=='fetch_division'){
		$output = '';
		$output .= '<div class="row">';
		if($_POST['query3_1']=='Division'){
			$output .= '<div class="col-md-6">';
				$output .='<label class="form-label">कॉलेज का नाम </label>
				<select name="office_name" id="office_name" onchange="action3_3(this.value)" class="form-control" required>';
				$output .= '<option value="">---</option>';
				$query="select * from division";
				$row=$db->select($query);
				while($record=$row->fetch_array()){
					$output .= '<option value="'.$record['id'].'">'.$record['division'].'</option>';
				}
			$output .='</select></div>
			<div class="col-md-6" id="present_post"></div>';
		}else if($_POST['query3_1']=='Depot'){
			$output .= '<div class="col-md-6">';
				$output .='<label class="form-label">डिपो का नाम </label>
				<select name="office_name" id="office_name" onchange="action3_3(this.value)" class="form-control" required>';
				$output .= '<option value="">---</option>';
				$query="select * from deport";
				$row=$db->select($query);
				while($record=$row->fetch_array()){
					$output .= '<option value="'.$record['id'].'">'.$record['deport'].'</option>';
				}
			$output .='</select></div>
			<div class="col-md-6" id="present_post"></div>';
		}else if($_POST['query3_1']=='Head Quarter'){
			$output .= '<div class="col-md-6">
					<label class="form-label">पदनाम </label>
					<select name="present_post" id="present_post" onchange="action20_2(this.value)" class="form-control" required>';
					$output .= '<option value="">---</option>';
					$query="select employee.post, post.post_name_en from employee inner join post on employee.post=post.id where employee.work_location = '".$_POST['query3_1']."' group by post.post_name_en asc";
					$row=$db->select($query);
					while($record=$row->fetch_array()){
						$output .= '<option value="'.$record['post'].'">'.$record['post_name_en'].'</option>';
					}
				$output .='</select>
			</div>';
		}
		$output .='</div>';
		echo $output;
	}	
}




if(isset($_POST['action3_11'])){
	if($_POST['action3_11']=='fetch_division'){
		$output = '';
		
		if($_POST['sn']=='1'){
			$acr_office_name = 'reporting_office_name';
		}else if($_POST['sn']=='2'){
			$acr_office_name = 'reviewing_office_name';
		}else if($_POST['sn']=='3'){
			$acr_office_name = 'accepting_office_name';
		}
		if($_POST['query3_11']=='Division'){
			$output .='<select name="'.$acr_office_name.'" id="acr_office_name'.$_POST['sn'].'" onchange="action3_3_1(this.value,'.$_POST['sn'].')" class="form-control" required>';
				$output .= '<option value="">---कॉलेज---</option>';
				$query="select * from division";
				$row=$db->select($query);
				while($record=$row->fetch_array()){
					$output .= '<option value="'.$record['id'].'">'.$record['division'].'</option>';
				}
			$output .='</select>';
		}else if($_POST['query3_11']=='Depot'){
			$output .='<select name="'.$acr_office_name.'" id="acr_office_name'.$_POST['sn'].'" onchange="action3_3_1(this.value,'.$_POST['sn'].')" class="form-control" required>';
				$output .= '<option value="">---Depot---</option>';
				$query="select * from deport";
				$row=$db->select($query);
				while($record=$row->fetch_array()){
					$output .= '<option value="'.$record['id'].'">'.$record['deport'].'</option>';
				}
			$output .='</select>';
		}else if($_POST['query3_11']=='Head Quarter'){
			$output .= ' ---@';
			$output .= '<option value="">---</option>';
				$query="select employee.post, post.post_name_en from employee inner join post on employee.post=post.id where employee.work_location = '".$_POST['query3_11']."' group by post.post_name_en asc";
				$row=$db->select($query);
				while($record=$row->fetch_array()){
					$output .= '<option value="'.$record['post'].'">'.$record['post_name_en'].'</option>';
				}
		}
		echo $output;
	}	
}






if(isset($_POST['action31'])){
	if($_POST['action31']=='fetch_division'){
		$output = '';
		if($_POST['query31']=='Division'){
			$output .='<label class="form-label">Division Name</label>
			<select name="office_name" id="office_name" onchange="action22(this.value)" class="form-control" required>';
			$output .= '<option value="">~~~Choose~~~</option>';
			$query="select * from division";
			$row=$db->select($query);
			while($record=$row->fetch_array()){
				$output .= '<option value="'.$record['id'].'">'.$record['division'].'</option>';
			}
			$output .='</select>';
		}else if($_POST['query31']=='Depot'){
			$output .='<label class="form-label">Depot</label>
			<select name="office_name" id="office_name" onchange="action22(this.value)" class="form-control" required>';
			$output .= '<option value="">~~~Choose~~~</option>';
			$query="select * from deport";
			$row=$db->select($query);
			while($record=$row->fetch_array()){
				$output .= '<option value="'.$record['id'].'">'.$record['deport'].'</option>';
			}
			$output .='</select>';
		}else{
			$output .='<label class="form-label">Employee</label>
			<select name="employee" id="employee_name" onchange="action23(this.value)" class="form-control" required>';
			$output .= '<option value="">~~~Choose~~~</option>';
			$query="select * from employee where work_location='".$_POST['query31']."'";
			$row=$db->select($query);
			while($record=$row->fetch_array()){
				$query1="select * from post where id='".$record['post']."'";
				$row1=$db->select($query1);
				$record1=$row1->fetch_array();
				
				$query2="select * from transfer_request where employee='".$record['employee_code']."' and is_transfer='0'";
				$row2=$db->select($query2);
				if($row2->num_rows > 0){
					$output .= '<option value="'.$record['employee_code'].'" class="text-danger" disabled>'.$record['employee_code'].' - '.$record['employee_name'].' &nbsp;&nbsp;&nbsp;&nbsp;( '.$record1['post_name'].' )</option>';
				}else{
					$output .= '<option value="'.$record['employee_code'].'">'.$record['employee_code'].' - '.$record['employee_name'].' &nbsp;&nbsp;&nbsp;&nbsp;( '.$record1['post_name'].' )</option>';
				}
				
				//$output .= '<option value="'.$record['employee_code'].'">'.$record['employee_code'].' - '.$record['employee_name'].' &nbsp;&nbsp;&nbsp;&nbsp;( '.$record1['post_name'].' )</option>';
			}
			$output .='</select>';
		}
		
		echo $output;
	}	
}


if(isset($_POST['action31'])){
	if($_POST['action31']=='fetch_division1'){
		$output = '';
		if($_POST['query31']=='Division'){
			$output .='<label class="form-label">Division Name</label>
			<select name="office_name" id="office_name" onchange="action22(this.value)" class="form-control" required>';
			$output .= '<option value="">~~~Choose~~~</option>';
			$query="select * from division";
			$row=$db->select($query);
			while($record=$row->fetch_array()){
				$output .= '<option value="'.$record['id'].'">'.$record['division'].'</option>';
			}
			$output .='</select>';
		}else if($_POST['query31']=='Depot'){
			$output .='<label class="form-label">Depot</label>
			<select name="office_name" id="office_name" onchange="action22(this.value)" class="form-control" required>';
			$output .= '<option value="">~~~Choose~~~</option>';
			$query="select * from deport";
			$row=$db->select($query);
			while($record=$row->fetch_array()){
				$output .= '<option value="'.$record['id'].'">'.$record['deport'].'</option>';
			}
			$output .='</select>';
		}else{
			$output .='<label class="form-label">Employee</label>
			<select name="employee" id="employee_name" onchange="action23(this.value)" class="form-control" required>';
			$output .= '<option value="">~~~Choose~~~</option>';
			$query="select * from employee where work_location='".$_POST['query31']."' order by employee_name asc";
			$row=$db->select($query);
			while($record=$row->fetch_array()){
				$query1="select * from post where id='".$record['post']."'";
				$row1=$db->select($query1);
				$record1=$row1->fetch_array();
				
				$output .= '<option value="'.$record['employee_code'].'">'.$record['employee_code'].' - '.$record['employee_name'].' &nbsp;&nbsp;&nbsp;&nbsp;( '.$record1['post_name'].' )</option>';
			}
			$output .='</select>';
		}
		
		echo $output;
	}	
}

if(isset($_POST['action23'])){
	if($_POST['action23']=='fetch_transfer_to'){
		$output = '';
		$output .='<div class="col-md-12">
			<label style="font-size: 18px;">Transfer to</label>
		</div>
		<div class="col-md-3 mb-3">
			<label class="form-label">Work Location</label>
			<select name="to_work_location" id="to_work_location" onchange="action311(this.value)" class="form-control" required>
				<option value="">~~~Choose~~~</option>';
				if($_POST['work_location']=='Head Quarter'){
					$query="select * from work_location where work_location!='Head Quarter'";
				}else{
					$query="select * from work_location";
				}
				$row=$db->select($query);
				while($record=$row->fetch_array()){
					$output .='<option value="'.$record['work_location'].'">'.$record['work_location'].'</option>';
				}
			$output .='</select>
		</div>
		<div class="col-md-3 mb-3" id="to_dep_div_data"></div>
		<div class="col-md-3 mb-3" id="to_employee_data"></div>
		<div class="col-md-3 mb-3" id="to_appointment_officer_name"></div>';
		
		echo $output;
	}
	
	if($_POST['action23']=='fetch_promotion_to'){
		$output = '';
		$output .='<div class="col-md-12">
			<label style="font-size: 18px;">Promote to</label>
		</div>
		<div class="col-md-3 mb-3">
			<label class="form-label">Designation</label>
			<select name="post" id="post" onchange="action511(this.value)" class="form-control" required>
				<option value="">~~~Choose~~~</option>';
				$query="select * from post where id!='1'";
				$row=$db->select($query);
				while($record=$row->fetch_array()){
					$output .='<option value="'.$record['id'].'">'.$record['post_name'].'</option>';
				}
			$output .='</select>
		</div>
		<div class="col-md-3 mb-3" id="to_dep_div_data_promotion"></div>
		<div class="col-md-3 mb-3" id="to_dep_div_data"></div>
		<div class="col-md-3 mb-3" id="to_employee_data"></div>
		<div class="col-md-3 mb-3" id="to_appointment_officer_name"></div>';
		
		echo $output;
	}
}

if(isset($_POST['action511'])){
	if($_POST['action511']=='fetch_promotion_to'){
		$output = '';
		$output .='<label class="form-label">Work Location</label>
			<select name="to_work_location" id="to_work_location" onchange="action311(this.value)" class="form-control" required>
				<option value="">~~~Choose~~~</option>';
				$query="select * from work_location";
				$row=$db->select($query);
				while($record=$row->fetch_array()){
					$output .='<option value="'.$record['work_location'].'">'.$record['work_location'].'</option>';
				}
			$output .='</select>';
		echo $output;
	}
	
}

if(isset($_POST['action22'])){
	if($_POST['action22']=='fetch_employee'){
		$output = '';
		$output .='<label class="form-label">Employee</label>
		<select name="employee" id="employee_name" onchange="action23(this.value)" class="form-control" required>';
		$output .= '<option value="">~~~Choose~~~</option>';
		$query="select * from employee where work_location='".$_POST['work_location']."' and office_name='".$_POST['query22']."'";
		$row=$db->select($query);
		while($record=$row->fetch_array()){
			$query1="select * from post where id='".$record['post']."'";
			$row1=$db->select($query1);
			$record1=$row1->fetch_array();
			
			$query2="select * from transfer_request where employee='".$record['employee_code']."' and is_transfer='0'";
			$row2=$db->select($query2);
			if($row2->num_rows > 0){
				$output .= '<option value="'.$record['employee_code'].'" class="text-danger" disabled>'.$record['employee_code'].' - '.$record['employee_name'].' &nbsp;&nbsp;&nbsp;&nbsp;( '.$record1['post_name'].' )</option>';
			}else{
				$output .= '<option value="'.$record['employee_code'].'">'.$record['employee_code'].' - '.$record['employee_name'].' &nbsp;&nbsp;&nbsp;&nbsp;( '.$record1['post_name'].' )</option>';
			}
		}
		$output .='</select>';
		
		echo $output;
	}	
}

if(isset($_POST['action22'])){
	if($_POST['action22']=='fetch_employee1'){
		$output = '';
		$output .='<label class="form-label">Employee</label>
		<select name="employee" id="employee_name" onchange="action23(this.value)" class="form-control" required>';
		$output .= '<option value="">~~~Choose~~~</option>';
		$query="select * from employee where work_location='".$_POST['work_location']."' and office_name='".$_POST['query22']."' order by employee_name asc";
		$row=$db->select($query);
		while($record=$row->fetch_array()){
			$query1="select * from post where id='".$record['post']."'";
			$row1=$db->select($query1);
			$record1=$row1->fetch_array();
			
			$output .= '<option value="'.$record['employee_code'].'">'.$record['employee_code'].' - '.$record['employee_name'].' &nbsp;&nbsp;&nbsp;&nbsp;( '.$record1['post_name'].' )</option>';
		}
		$output .='</select>';
		
		echo $output;
	}	
}

if(isset($_POST['action221'])){
	if($_POST['action221']=='fetch_employee'){
		$output = '';
	
		$output .='<label class="form-label">Appointment Officer Post</label>
		<select name="to_appointment_officer" id="to_appointment_officer" onchange="action411(this.value)" class="form-control" required>';
		$output .= '<option value="">~~~Choose~~~</option>';
		
		$query="select * from post where id!='1'";
		$row=$db->select($query);
		while($record=$row->fetch_array()){
			$output .= '<option value="'.$record['id'].'">'.$record['post_name'].'</option>';
		}
		$output .='</select>';
	
		echo $output;
	}	
}


if(isset($_POST['action311'])){
	if($_POST['action311']=='fetch_division'){
		$output = '';
		if($_POST['query311']=='Division'){
			$output .='<label class="form-label">Division Name</label>
			<select name="to_office_name" id="to_office_name" onchange="action221(this.value)" class="form-control" required>';
			$output .= '<option value="">~~~Choose~~~</option>';
			$query="select * from division where id!='".$_POST['office_name']."'";
			$row=$db->select($query);
			while($record=$row->fetch_array()){
				$output .= '<option value="'.$record['id'].'">'.$record['division'].'</option>';
			}
			$output .='</select>';
		}else if($_POST['query311']=='Depot'){
			$output .='<label class="form-label">Depot</label>
			<select name="to_office_name" id="to_office_name" onchange="action221(this.value)" class="form-control" required>';
			$output .= '<option value="">~~~Choose~~~</option>';
			$query="select * from deport where id!='".$_POST['office_name']."'";
			$row=$db->select($query);
			while($record=$row->fetch_array()){
				$output .= '<option value="'.$record['id'].'">'.$record['deport'].'</option>';
			}
			$output .='</select>';
		}else{
			$output .='<label class="form-label">Appointment Officer Post</label>
			<select name="to_appointment_officer" id="to_appointment_officer" onchange="action411(this.value)" class="form-control" required>';
			$output .= '<option value="">~~~Choose~~~</option>';
			
			$query="select * from post where id!='1'";
			$row=$db->select($query);
			while($record=$row->fetch_array()){
				$output .= '<option value="'.$record['id'].'">'.$record['post_name'].'</option>';
			}
			$output .='</select>';
		}
		echo $output;
	}
	
	if($_POST['action311']=='fetch_division1'){
		$output = '';
		if($_POST['query311']=='Division'){
			$output .='<label class="form-label">Division Name</label>
			<select name="to_office_name" id="to_office_name" onchange="action221(this.value)" class="form-control" required>';
			$output .= '<option value="">~~~Choose~~~</option>';
			$query="select * from division";
			$row=$db->select($query);
			while($record=$row->fetch_array()){
				$output .= '<option value="'.$record['id'].'">'.$record['division'].'</option>';
			}
			$output .='</select>';
		}else if($_POST['query311']=='Depot'){
			$output .='<label class="form-label">Depot</label>
			<select name="to_office_name" id="to_office_name" onchange="action221(this.value)" class="form-control" required>';
			$output .= '<option value="">~~~Choose~~~</option>';
			$query="select * from deport";
			$row=$db->select($query);
			while($record=$row->fetch_array()){
				$output .= '<option value="'.$record['id'].'">'.$record['deport'].'</option>';
			}
			$output .='</select>';
		}else{
			$output .='<label class="form-label">Appointment Officer Post</label>
			<select name="to_appointment_officer" id="to_appointment_officer" onchange="action411(this.value)" class="form-control" required>';
			$output .= '<option value="">~~~Choose~~~</option>';
			
			$query="select * from post where id!='1'";
			$row=$db->select($query);
			while($record=$row->fetch_array()){
				$output .= '<option value="'.$record['id'].'">'.$record['post_name'].'</option>';
			}
			$output .='</select>';
		}
		echo $output;
	}
}

if(isset($_POST['action4'])){
	if($_POST['action4']=='fetch_reporting_manager_name'){
		$work_location	= mysqli_real_escape_string($db->link, $_POST['work_location']);
		if($work_location=='Division' || $work_location=='Depot'){
			if($_POST['office_name']!=''){
				$output = '<option value="">~~~Choose~~~</option>';
				$query="select * from employee where post='".$_POST['query4']."' and work_location='$work_location' and office_name='".$_POST['office_name']."'";
				$row=$db->select($query);
				while($record=$row->fetch_array()){
					$output .= '<option value="'.$record['employee_code'].'">'.$record['employee_name'].'</option>';
				}
			}
		}else{
			$output = '<option value="">~~~Choose~~~</option>';
			$query="select * from employee where post='".$_POST['query4']."' and work_location='$work_location'";
			$row=$db->select($query);
			while($record=$row->fetch_array()){
				$output .= '<option value="'.$record['employee_code'].'">'.$record['employee_name'].'</option>';
			}
		}
		
		
		echo $output;
	}	
}

if(isset($_POST['action41'])){
	if($_POST['action41']=='fetch_appointment_officer_name'){
		$work_location	= mysqli_real_escape_string($db->link, $_POST['work_location']);
		if($work_location=='Division' || $work_location=='Depot'){
			if($_POST['office_name']!=''){
				$output = '<option value="">~~~Choose~~~</option>';
				$query="select * from employee where post='".$_POST['query41']."' and work_location='$work_location' and office_name='".$_POST['office_name']."'";
				$row=$db->select($query);
				while($record=$row->fetch_array()){
					$output .= '<option value="'.$record['employee_code'].'">'.$record['employee_name'].'</option>';
				}
			}
		}else{
			$output = '<option value="">~~~Choose~~~</option>';
			$query="select * from employee where post='".$_POST['query41']."' and work_location='$work_location'";
			$row=$db->select($query);
			while($record=$row->fetch_array()){
				$output .= '<option value="'.$record['employee_code'].'">'.$record['employee_name'].'</option>';
			}
		}
		
		
		echo $output;
	}	
}

if(isset($_POST['action411'])){
	if($_POST['action411']=='fetch_appointment_officer_name'){
		$work_location	= mysqli_real_escape_string($db->link, $_POST['to_work_location']);
		
		$output = '<label class="form-label">Appointment Officer Name</label>
			<select name="to_appointment_officer_name" id="to_appointment_officer_name" class="form-control" required>';
				if($work_location=='Division' || $work_location=='Depot'){
					if($_POST['to_office_name']!=''){
						$output .= '<option value="">~~~Choose~~~</option>';
						$query="select * from employee where post='".$_POST['query411']."' and work_location='$work_location' and office_name='".$_POST['to_office_name']."' and employee_code!='".$_POST['employee']."'";
						$row=$db->select($query);
						while($record=$row->fetch_array()){
							$output .= '<option value="'.$record['employee_code'].'">'.$record['employee_name'].'</option>';
						}
					}
				}else{
					$output .= '<option value="">~~~Choose~~~</option>';
					$query="select * from employee where post='".$_POST['query411']."' and work_location='$work_location' and employee_code!='".$_POST['employee']."'";
					$row=$db->select($query);
					while($record=$row->fetch_array()){
						$output .= '<option value="'.$record['employee_code'].'">'.$record['employee_name'].'</option>';
					}
				}
			$output .= "</select>";
		echo $output;
	}	
}





if(isset($_POST['add_allowence'])){
	$da						= mysqli_real_escape_string($db->link, $_POST['da']);
	$da     				= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$da);
	$da_type				= mysqli_real_escape_string($db->link, $_POST['da_type']);
	$personal_pay			= mysqli_real_escape_string($db->link, $_POST['personal_pay']);
	$personal_pay     		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$personal_pay);
	$personal_pay_type		= mysqli_real_escape_string($db->link, $_POST['personal_pay_type']);
	$medical_allowence		= mysqli_real_escape_string($db->link, $_POST['medical_allowence']);
	$medical_allowence     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$medical_allowence);
	$medical_allowence_type	= mysqli_real_escape_string($db->link, $_POST['medical_allowence_type']);
	$hra					= mysqli_real_escape_string($db->link, $_POST['hra']);
	$hra     				= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$hra);
	$hra_type				= mysqli_real_escape_string($db->link, $_POST['hra_type']);
	$hill_allowence			= mysqli_real_escape_string($db->link, $_POST['hill_allowence']);
	$hill_allowence     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$hill_allowence);
	$hill_allowence_type	= mysqli_real_escape_string($db->link, $_POST['hill_allowence_type']);
	$border_allowence		= mysqli_real_escape_string($db->link, $_POST['border_allowence']);
	$border_allowence     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$border_allowence);
	$border_allowence_type	= mysqli_real_escape_string($db->link, $_POST['border_allowence_type']);
	$cca					= mysqli_real_escape_string($db->link, $_POST['cca']);
	$cca     				= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$cca);
	$cca_type				= mysqli_real_escape_string($db->link, $_POST['cca_type']);
	
	$qry = "UPDATE `allowence` set `da`='$da', `da_type`='$da_type', `personal_pay`='$personal_pay', `personal_pay_type`='$personal_pay_type', `medical_allowence`='$medical_allowence', `medical_allowence_type`='$medical_allowence_type', `hra`='$hra', `hra_type`='$hra_type', `hill_allowence`='$hill_allowence', `hill_allowence_type`='$hill_allowence_type', `border_allowence`='$border_allowence', `border_allowence_type`='$border_allowence_type', `cca`='$cca', `cca_type`='$cca_type' where id='1'";
	if ($db->insert($qry)) {
		echo "Success";
	}else{
		echo "Something went wrong!";
	}
}



if(isset($_POST['add_deduction'])){
	$epf						= mysqli_real_escape_string($db->link, $_POST['epf']);
	$epf     					= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$epf);
	$epf_type					= mysqli_real_escape_string($db->link, $_POST['epf_type']);
	$gpf						= mysqli_real_escape_string($db->link, $_POST['gpf']);
	$gpf     					= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$gpf);
	$gpf_type					= mysqli_real_escape_string($db->link, $_POST['gpf_type']);
	$gis_1						= mysqli_real_escape_string($db->link, $_POST['gis_1']);
	$gis_1     					= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$gis_1);
	$gis_1_type					= mysqli_real_escape_string($db->link, $_POST['gis_1_type']);
	$gis_2						= mysqli_real_escape_string($db->link, $_POST['gis_2']);
	$gis_2     					= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$gis_2);
	$gis_2_type					= mysqli_real_escape_string($db->link, $_POST['gis_2_type']);
	$ewf						= mysqli_real_escape_string($db->link, $_POST['ewf']);
	$ewf     					= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$ewf);
	$ewf_type					= mysqli_real_escape_string($db->link, $_POST['ewf_type']);
	$income_tax					= mysqli_real_escape_string($db->link, $_POST['income_tax']);
	$income_tax     			= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$income_tax);
	$income_tax_type			= mysqli_real_escape_string($db->link, $_POST['income_tax_type']);
	$other_recovery				= mysqli_real_escape_string($db->link, $_POST['other_recovery']);
	$other_recovery     		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$other_recovery);
	$other_recovery_type		= mysqli_real_escape_string($db->link, $_POST['other_recovery_type']);
	$recovery_day				= mysqli_real_escape_string($db->link, $_POST['recovery_day']);
	$recovery_day     			= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$recovery_day);
	$recovery_day_type			= mysqli_real_escape_string($db->link, $_POST['recovery_day_type']);
	$corporation_recovery		= mysqli_real_escape_string($db->link, $_POST['corporation_recovery']);
	$corporation_recovery     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$corporation_recovery);
	$corporation_recovery_type	= mysqli_real_escape_string($db->link, $_POST['corporation_recovery_type']);
	
	$qry = "UPDATE `deduction` set `epf`='$epf', `epf_type`='$epf_type', `gpf`='$gpf', `gpf_type`='$gpf_type', `gis_1`='$gis_1', `gis_1_type`='$gis_1_type', `gis_2`='$gis_2', `gis_2_type`='$gis_2_type', `ewf`='$ewf', `ewf_type`='$ewf_type', `income_tax`='$income_tax', `income_tax_type`='$income_tax_type', `other_recovery`='$other_recovery', `other_recovery_type`='$other_recovery_type', `recovery_day`='$recovery_day', `recovery_day_type`='$recovery_day_type', `corporation_recovery`='$corporation_recovery', `corporation_recovery_type`='$corporation_recovery_type' where id='1'";
	if ($db->insert($qry)) {
		echo "Success";
	}else{
		echo "Something went wrong!";
	}
}


if(isset($_POST['action_no_of_family'])) {
	if($_POST['action_no_of_family']=='fetch_no_of_family'){
		
		$output = '';
		$output .= '<div class="row">';
		for($i=1; $i <= $_POST['query_no_of_family']; $i++){
			$output .= '<div class="col-md-12"><h5>Member '.$i.'</h5></div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Name</label>
					<input type="text" name="member_name[]" class="form-control block_special" placeholder="Name " required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Relation</label>
					<input type="text" name="relation[]" class="form-control block_special" placeholder="Relation " required>
				</div>
				<div class="col-md-2 mb-3">
					<label class="form-label">Age</label>
					<input type="text" name="member_age[]" class="form-control allow_number" maxlength="2" placeholder="Age" required>
				</div>
				<div class="col-md-2 mb-3">
					<label class="form-label">Aadhaar Number</label>
					<input type="text" name="member_aadhaar_no[]" class="form-control allow_number" maxlength="12" placeholder="Aadhaar Number" required>
				</div>
				<div class="col-md-2 mb-3">
					<label class="form-label">Aadhaar Card Doc</label>
					<input type="file" name="member_aadhaar_copy[]" maxlength="12" placeholder="Aadhaar Number" required>
				</div>';
		}
		
		$output .= '</div>';
		
		$output .= '<script type="text/javascript">
			$(function () {
				$(".allow_float").keypress(function (e) {
					var keyCode = e.keyCode || e.which;
					var regex = /^[.0-9]+$/;
					var isValid = regex.test(String.fromCharCode(keyCode));
					return isValid;
				});
			});
		</script>';
		$output .= '<script type="text/javascript">
			$(function () {
				$(".allow_number").keypress(function (e) {
					var keyCode = e.keyCode || e.which;
					var regex = /^[0-9]+$/;
					var isValid = regex.test(String.fromCharCode(keyCode));
					return isValid;
				});
			});
		</script>';
		$output .= '<script type="text/javascript">
			$(function () {
				$(".block_special").keypress(function (e) {
					var keyCode = e.keyCode || e.which;
					var regex = /^[0-9 A-Za-z_,]+$/;
					var isValid = regex.test(String.fromCharCode(keyCode));
					return isValid;
				});
			});
		</script>';
		
		echo $output;
	}
}


if(isset($_POST['action5'])) {
	if($_POST['action5']=='fetch_employee_details'){
		$output = '';
		$sql21 = "SELECT * FROM `employee` WHERE employee_code = '".$_POST['query5']."'";
		$exe21 = $db->select($sql21);
		if ($exe21->num_rows > 0) {
			$record21 = $exe21->fetch_array();
			
			$sql22 = "SELECT * FROM `cast` WHERE id = '".$record21['cast']."'";
			$exe22 = $db->select($sql22);
			if ($exe22->num_rows > 0) {
				$record22 = $exe22->fetch_array();
				$caste = $record22['cast'];
			}else{
				$caste = '';
			}
			
			
			$output .= '<div class="col-md-12">
				<div class="row">
					
					<div class="col-md-12 mb-3">
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Name</th>
										<th>Caste</th>
										<th>Residence</th>
										<th>Fathers Name</th>
										<th>Date of Birth</th>
										<th>Height</th>
										<th>Identification Mark</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>'.$record21['employee_name'].'</td>
										<td>'.$caste.'</td>
										<td>'.$record21['address'].'</td>
										<td>'.$record21['father_name'].'</td>
										<td>'.date("d M, Y", strtotime($record21['dob'])).'</td>
										<td>'.$record21['height'].' cm</td>
										<td>'.$record21['identity_mark'].'</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
				<div class="row">
					
					<div class="col-md-12 mb-3">
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Name of Appointment</th>
										<th>Type</th>
										<th>Substantive</th>
										<th>Pay in Substantive</th>
										<th>Additional Pay</th>
										<th>Other Emoluments Falling</th>
										<th>Date of Appointment</th>
										<th>Date of Termination</th>
										<th>Reasons of Termination</th>
									</tr>
								</thead>
								<tbody id="service_book_data_all">';
									$i=1;
									$sql219 = "SELECT * FROM `service_book` WHERE employee_code = '".$_POST['query5']."'";
									$exe219 = $db->select($sql219);
									while($record219 = $exe219->fetch_array()){
										$output .= '<tr>
											<td>'.$i.'</td>
											<td>'.$record219['post_name'].'</td>
											<td>'.$record219['types'].'</td>
											<td>'.$record219['officiating'].'</td>
											<td>'.$record219['pay_in_substantive'].'</td>
											<td>'.$record219['additional_pay'].'</td>
											<td>'.$record219['other_emoluments'].'</td>
											<td>'.$record219['date_of_appointment'].'</td>
											<td>'.$record219['date_of_termination'].'</td>
											<td>'.$record219['reasons_of_termination'].'</td>
										</tr>';
										$i++;
									}
								$output .= '</tbody>
							</table>
						</div>
					</div>
				</div>
				
				<div class="row">
					<h4 id="message"></h4>
					<div class="col-md-4 mb-3">
						<label class="form-label">Choose</label>
						<select name="types" class="form-control" placeholder="Employee Code" required>
							<option value="">~~~Choose~~~</option>
							<option value="Substantive">Substantive</option>
							<option value="Officiating">Officiating</option>
							<option value="Permanent">Permanent</option>
							<option value="Temporary">Temporary</option>
						</select>
					</div>
					
					<div class="col-md-4 mb-3">
						<label class="form-label">If Officiating here state Substantive</label>
						<input type="text" name="officiating" class="form-control" placeholder="" required>
					</div>
					<div class="col-md-4 mb-3">
						<label class="form-label">Pay in Substantive Appointment</label>
						<input type="text" name="pay_in_substantive" class="form-control" placeholder="" required>
					</div>
					<div class="col-md-4 mb-3">
						<label class="form-label">Additional Pay of Officiating</label>
						<input type="text" name="additional_pay" class="form-control" placeholder="" required>
					</div>
					<div class="col-md-4 mb-3">
						<label class="form-label">Other Emoluments Falling Under the Terms Pay</label>
						<input type="text" name="other_emoluments" class="form-control" placeholder="" required>
					</div>
					<div class="col-md-4 mb-3">
						<label class="form-label">Date of Appointment</label>
						<input type="date" name="date_of_appointment" class="form-control" placeholder="" required>
					</div>
					<div class="col-md-4 mb-3">
						<label class="form-label">Date of Termination of Appointment</label>
						<input type="date" name="date_of_termination" class="form-control" placeholder="" required>
					</div>
					<div class="col-md-4 mb-3">
						<label class="form-label">Reasons of Termination</label>
						<select name="reasons_of_termination" class="form-control" placeholder="Employee Code" required>
							<option value="">~~~Choose~~~</option>
							<option value="Promotion">Promotion</option>
							<option value="Transfer">Transfer</option>
							<option value="Dismissal">Dismissal</option>
						</select>
					</div>
					<div class="col-md-4 mb-3">
						<label class="form-label">Document</label>
						<input type="file" name="documents" class="form-control" required>
					</div>
					<div class="col-md-12 mb-3">
						<input type="hidden" name="add_service_book" value="add_service_book">
						<input type="hidden" name="post_name" value="'.$record21['post'].'">
						<input type="hidden" name="employee_code" value="'.$_POST['query5'].'">
						<button id="department_button" class="btn btn-primary" type="submit">Save</button>
					</div>
					
				</div>
				
				
				
			</div>';
			
		}else{
			echo "Employee Doesn't Exist!";
		}
		
		echo $output;
		
		
	}
}


if(isset($_POST['action6'])) {
	if($_POST['action6']=='fetch_special_allowence'){
		$output = '';
		
		$sql212 = "SELECT * FROM `employee` WHERE employee_code = '".$_POST['query6']."'";
		$exe212 = $db->select($sql212);
		if ($exe212->num_rows > 0) {
			$sql21 = "SELECT * FROM `special_allowence` WHERE employee_code = '".$_POST['query6']."'";
			$exe21 = $db->select($sql21);
			if ($exe21->num_rows > 0) {
				$record = $exe21->fetch_array();
				
				$output .= '<div class="col-md-3 mb-3">
					<label class="form-label">DA (INR / %)</label>
					<select name="da_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>';
						if($record['da_type']=='INR'){
							$output .= '<option value="INR" selected>INR</option>
							<option value="%">%</option>';
						}else if($record['da_type']=='%'){
							$output .= '<option value="INR">INR</option>
							<option value="%" selected>%</option>';
						}else{
							$output .= '<option value="INR">INR</option>
							<option value="%">%</option>';
						}
					$output .= '</select>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">DA</label>
					<input type="text" name="da" value="'.$record['da'].'" class="form-control allow_float" placeholder="DA" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Personal Pay (INR / %)</label>
					<select name="personal_pay_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>';
						if($record['personal_pay_type']=='INR'){
							$output .= '<option value="INR" selected>INR</option>
							<option value="%">%</option>';
						}else if($record['personal_pay_type']=='%'){
							$output .= '<option value="INR">INR</option>
							<option value="%" selected>%</option>';
						}else{
							$output .= '<option value="INR">INR</option>
							<option value="%">%</option>';
						}
					$output .= '</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">Personal Pay</label>
					<input type="text" name="personal_pay" value="'.$record['personal_pay'].'" class="form-control allow_float" placeholder="Personal Pay" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">IR (INR / %)</label>
					<select name="ir_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>';
						if($record['ir_type']=='INR'){
							$output .= '<option value="INR" selected>INR</option>
							<option value="%">%</option>';
						}else if($record['ir_type']=='%'){
							$output .= '<option value="INR">INR</option>
							<option value="%" selected>%</option>';
						}else{
							$output .= '<option value="INR">INR</option>
							<option value="%">%</option>';
						}
					$output .= '</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">IR</label>
					<input type="text" name="ir" value="'.$record['ir'].'" class="form-control allow_float" placeholder="IR" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Medical Allowance (INR / %)</label>
					<select name="medical_allowence_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>';
						if($record['medical_allowence_type']=='INR'){
							$output .= '<option value="INR" selected>INR</option>
							<option value="%">%</option>';
						}else if($record['medical_allowence_type']=='%'){
							$output .= '<option value="INR">INR</option>
							<option value="%" selected>%</option>';
						}else{
							$output .= '<option value="INR">INR</option>
							<option value="%">%</option>';
						}
					$output .= '</select>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Medical Allowance</label>
					<input type="text" name="medical_allowence" value="'.$record['medical_allowence'].'" class="form-control allow_float" placeholder="Medical Allowance" required>
				</div>
				
				
				<div class="col-md-3 mb-3">
					<label class="form-label">HRA (INR / %)</label>
					<select name="hra_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>';
						if($record['hra_type']=='INR'){
							$output .= '<option value="INR" selected>INR</option>
							<option value="%">%</option>';
						}else if($record['hra_type']=='%'){
							$output .= '<option value="INR">INR</option>
							<option value="%" selected>%</option>';
						}else{
							$output .= '<option value="INR">INR</option>
							<option value="%">%</option>';
						}
					$output .= '</select>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">HRA</label>
					<input type="text" name="hra" value="'.$record['hra'].'" class="form-control allow_float" placeholder="HRA" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Hill Allowance (INR / %)</label>
					<select name="hill_allowence_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>';
						if($record['hill_allowence_type']=='INR'){
							$output .= '<option value="INR" selected>INR</option>
							<option value="%">%</option>';
						}else if($record['hill_allowence_type']=='%'){
							$output .= '<option value="INR">INR</option>
							<option value="%" selected>%</option>';
						}else{
							$output .= '<option value="INR">INR</option>
							<option value="%">%</option>';
						}
					$output .= '</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">Hill Allowance</label>
					<input type="text" name="hill_allowence" value="'.$record['hill_allowence'].'" class="form-control allow_float" placeholder="Hill Allowance" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Border Allowance (INR / %)</label>
					<select name="border_allowence_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>';
						if($record['border_allowence_type']=='INR'){
							$output .= '<option value="INR" selected>INR</option>
							<option value="%">%</option>';
						}else if($record['border_allowence_type']=='%'){
							$output .= '<option value="INR">INR</option>
							<option value="%" selected>%</option>';
						}else{
							$output .= '<option value="INR">INR</option>
							<option value="%">%</option>';
						}
					$output .= '</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">Border Allowance</label>
					<input type="text" name="border_allowence" value="'.$record['border_allowence'].'" class="form-control allow_float" placeholder="Border Allowance" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">CCA (INR / %)</label>
					<select name="cca_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>';
						if($record['cca_type']=='INR'){
							$output .= '<option value="INR" selected>INR</option>
							<option value="%">%</option>';
						}else if($record['cca_type']=='%'){
							$output .= '<option value="INR">INR</option>
							<option value="%" selected>%</option>';
						}else{
							$output .= '<option value="INR">INR</option>
							<option value="%">%</option>';
						}
					$output .= '</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">CCA</label>
					<input type="text" name="cca" value="'.$record['cca'].'" class="form-control allow_float" placeholder="CCA" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Cycle / P.H Allowance (INR / %)</label>
					<select name="cycle_ph_allowence_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>';
						if($record['cycle_ph_allowence_type']=='INR'){
							$output .= '<option value="INR" selected>INR</option>
							<option value="%">%</option>';
						}else if($record['cycle_ph_allowence_type']=='%'){
							$output .= '<option value="INR">INR</option>
							<option value="%" selected>%</option>';
						}else{
							$output .= '<option value="INR">INR</option>
							<option value="%">%</option>';
						}
					$output .= '</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">Cycle / P.H Allowance</label>
					<input type="text" name="cycle_ph_allowence" value="'.$record['cycle_ph_allowence'].'" class="form-control allow_float" placeholder="Cycle / P.H Allowance" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Cash Handling Allowance (INR / %)</label>
					<select name="cash_handling_allowence_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>';
						if($record['cash_handling_allowence_type']=='INR'){
							$output .= '<option value="INR" selected>INR</option>
							<option value="%">%</option>';
						}else if($record['cash_handling_allowence_type']=='%'){
							$output .= '<option value="INR">INR</option>
							<option value="%" selected>%</option>';
						}else{
							$output .= '<option value="INR">INR</option>
							<option value="%">%</option>';
						}
					$output .= '</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">Cash Handling Allowance</label>
					<input type="text" name="cash_handling_allowence" value="'.$record['cash_handling_allowence'].'" class="form-control allow_float" placeholder="Cash Handling Allowance" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Pollution Allowance (INR / %)</label>
					<select name="pollution_allowence_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>';
						if($record['pollution_allowence_type']=='INR'){
							$output .= '<option value="INR" selected>INR</option>
							<option value="%">%</option>';
						}else if($record['pollution_allowence_type']=='%'){
							$output .= '<option value="INR">INR</option>
							<option value="%" selected>%</option>';
						}else{
							$output .= '<option value="INR">INR</option>
							<option value="%">%</option>';
						}
					$output .= '</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">Pollution Allowance</label>
					<input type="text" name="pollution_allowence" value="'.$record['pollution_allowence'].'" class="form-control allow_float" placeholder="Pollution Allowance" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Washing Allowance (INR / %)</label>
					<select name="washing_allowence_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>';
						if($record['washing_allowence_type']=='INR'){
							$output .= '<option value="INR" selected>INR</option>
							<option value="%">%</option>';
						}else if($record['washing_allowence_type']=='%'){
							$output .= '<option value="INR">INR</option>
							<option value="%" selected>%</option>';
						}else{
							$output .= '<option value="INR">INR</option>
							<option value="%">%</option>';
						}
					$output .= '</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">Washing Allowance</label>
					<input type="text" name="washing_allowence" value="'.$record['washing_allowence'].'" class="form-control allow_float" placeholder="Washing Allowance" required>
				</div>
				
				<div class="col-md-12 mb-3">
					<input type="hidden" name="update_special_allowence" value="update_special_allowence">
                    <button id="department_button" class="btn btn-primary" type="submit">Update</button>
				</div>';
				
			}else{
				$output .= '<div class="col-md-3 mb-3">
					<label class="form-label">DA (INR / %)</label>
					<select name="da_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">DA</label>
					<input type="text" name="da" class="form-control allow_float" placeholder="DA" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Personal Pay (INR / %)</label>
					<select name="personal_pay_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">Personal Pay</label>
					<input type="text" name="personal_pay" class="form-control allow_float" placeholder="Personal Pay" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">IR (INR / %)</label>
					<select name="ir_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">IR</label>
					<input type="text" name="ir" class="form-control allow_float" placeholder="IR" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Medical Allowance (INR / %)</label>
					<select name="medical_allowence_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Medical Allowance</label>
					<input type="text" name="medical_allowence" class="form-control allow_float" placeholder="Medical Allowance" required>
				</div>
				
				
				<div class="col-md-3 mb-3">
					<label class="form-label">HRA (INR / %)</label>
					<select name="hra_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">HRA</label>
					<input type="text" name="hra" class="form-control allow_float" placeholder="HRA" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Hill Allowance (INR / %)</label>
					<select name="hill_allowence_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">Hill Allowance</label>
					<input type="text" name="hill_allowence" class="form-control allow_float" placeholder="Hill Allowance" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Border Allowance (INR / %)</label>
					<select name="border_allowence_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">Border Allowance</label>
					<input type="text" name="border_allowence" class="form-control allow_float" placeholder="Border Allowance" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">CCA (INR / %)</label>
					<select name="cca_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">CCA</label>
					<input type="text" name="cca" class="form-control allow_float" placeholder="CCA" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Cycle / P.H Allowance (INR / %)</label>
					<select name="cycle_ph_allowence_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">Cycle / P.H Allowance</label>
					<input type="text" name="cycle_ph_allowence" class="form-control allow_float" placeholder="Cycle / P.H Allowance" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Cash Handling Allowance (INR / %)</label>
					<select name="cash_handling_allowence_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">Cash Handling Allowance</label>
					<input type="text" name="cash_handling_allowence" class="form-control allow_float" placeholder="Cash Handling Allowance" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Pollution Allowance (INR / %)</label>
					<select name="pollution_allowence_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">Pollution Allowance</label>
					<input type="text" name="pollution_allowence" class="form-control allow_float" placeholder="Pollution Allowance" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Washing Allowance (INR / %)</label>
					<select name="washing_allowence_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">Washing Allowance</label>
					<input type="text" name="washing_allowence" class="form-control allow_float" placeholder="Washing Allowance" required>
				</div>
				
				<div class="col-md-12 mb-3">
					<input type="hidden" name="add_special_allowence" value="add_special_allowence">
                    <button id="department_button" class="btn btn-primary" type="submit">Save</button>
				</div>';
			}
			
			$output .= '<script type="text/javascript">
				$(function () {
					$(".allow_float").keypress(function (e) {
						var keyCode = e.keyCode || e.which;
						var regex = /^[.0-9]+$/;
						var isValid = regex.test(String.fromCharCode(keyCode));
						return isValid;
					});
				});
			</script>';
			$output .= '<script type="text/javascript">
				$(function () {
					$(".allow_number").keypress(function (e) {
						var keyCode = e.keyCode || e.which;
						var regex = /^[0-9]+$/;
						var isValid = regex.test(String.fromCharCode(keyCode));
						return isValid;
					});
				});
			</script>';
			$output .= '<script type="text/javascript">
				$(function () {
					$(".block_special").keypress(function (e) {
						var keyCode = e.keyCode || e.which;
						var regex = /^[0-9 A-Za-z_,]+$/;
						var isValid = regex.test(String.fromCharCode(keyCode));
						return isValid;
					});
				});
			</script>';
			
		}else{
			echo "Employee doesn't Exist!";
		}
		echo $output;
	}
}


if(isset($_POST['add_special_allowence'])){
	$employee_code			= mysqli_real_escape_string($db->link, $_POST['employee_code']);
	$da						= mysqli_real_escape_string($db->link, $_POST['da']);
	$da     				= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$da);
	$da_type				= mysqli_real_escape_string($db->link, $_POST['da_type']);
	$personal_pay			= mysqli_real_escape_string($db->link, $_POST['personal_pay']);
	$personal_pay     		= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$personal_pay);
	$personal_pay_type		= mysqli_real_escape_string($db->link, $_POST['personal_pay_type']);
	$ir						= mysqli_real_escape_string($db->link, $_POST['ir']);
	$ir     				= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$ir);
	$ir_type				= mysqli_real_escape_string($db->link, $_POST['ir_type']);
	$medical_allowence		= mysqli_real_escape_string($db->link, $_POST['medical_allowence']);
	$medical_allowence     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$medical_allowence);
	$medical_allowence_type	= mysqli_real_escape_string($db->link, $_POST['medical_allowence_type']);
	$hra					= mysqli_real_escape_string($db->link, $_POST['hra']);
	$hra     				= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$hra);
	$hra_type				= mysqli_real_escape_string($db->link, $_POST['hra_type']);
	$hill_allowence			= mysqli_real_escape_string($db->link, $_POST['hill_allowence']);
	$hill_allowence     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$hill_allowence);
	$hill_allowence_type	= mysqli_real_escape_string($db->link, $_POST['hill_allowence_type']);
	$border_allowence		= mysqli_real_escape_string($db->link, $_POST['border_allowence']);
	$border_allowence     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$border_allowence);
	$border_allowence_type	= mysqli_real_escape_string($db->link, $_POST['border_allowence_type']);
	$cca					= mysqli_real_escape_string($db->link, $_POST['cca']);
	$cca					= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$cca);
	$cca_type				= mysqli_real_escape_string($db->link, $_POST['cca_type']);
	$cycle_ph_allowence		= mysqli_real_escape_string($db->link, $_POST['cycle_ph_allowence']);
	$cycle_ph_allowence     = str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$cycle_ph_allowence);
	$cycle_ph_allowence_type= mysqli_real_escape_string($db->link, $_POST['cycle_ph_allowence_type']);
	$cash_handling_allowence= mysqli_real_escape_string($db->link, $_POST['cash_handling_allowence']);
	$cash_handling_allowence= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$cash_handling_allowence);
	$cash_handling_allowence_type= mysqli_real_escape_string($db->link, $_POST['cash_handling_allowence_type']);
	$pollution_allowence	= mysqli_real_escape_string($db->link, $_POST['pollution_allowence']);
	$pollution_allowence    = str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$pollution_allowence);
	$pollution_allowence_type= mysqli_real_escape_string($db->link, $_POST['pollution_allowence_type']);
	$washing_allowence		= mysqli_real_escape_string($db->link, $_POST['washing_allowence']);
	$washing_allowence     	= str_replace(array(":","<",">","~","!","@","#","$","%","^","&","*","(",")","-","+","|","/","?","{","}","[","]",";",",",'"'),"",$washing_allowence);
	$washing_allowence_type	= mysqli_real_escape_string($db->link, $_POST['washing_allowence_type']);
	
	$qry = "INSERT into `special_allowence` (`employee_code`,`da`,`da_type`,`personal_pay`,`personal_pay_type`,`ir`,`ir_type`,`medical_allowence`,`medical_allowence_type`,`hra`,`hra_type`,`hill_allowence`,`hill_allowence_type`,`border_allowence`,`border_allowence_type`,`cca`,`cca_type`,`cycle_ph_allowence`,`cycle_ph_allowence_type`,`cash_handling_allowence`,`cash_handling_allowence_type`,`pollution_allowence`,`pollution_allowence_type`,`washing_allowence`,`washing_allowence_type`) values ('$employee_code','$da','$da_type','$personal_pay','$personal_pay_type','$ir','$ir_type','$medical_allowence','$medical_allowence_type','$hra','$hra_type','$hill_allowence','$hill_allowence_type','$border_allowence','$border_allowence_type','$cca','$cca_type','$cycle_ph_allowence','$cycle_ph_allowence_type','$cash_handling_allowence','$cash_handling_allowence_type','$pollution_allowence','$pollution_allowence_type','$washing_allowence','$washing_allowence_type')";
	if ($db->insert($qry)) {
		echo "Success";
	}else{
		echo "Something went wrong!";
	}
}


if(isset($_POST['update_special_allowence'])){
	$employee_code			= mysqli_real_escape_string($db->link, $_POST['employee_code']);
	$da						= mysqli_real_escape_string($db->link, $_POST['da']);
	$da_type				= mysqli_real_escape_string($db->link, $_POST['da_type']);
	$personal_pay			= mysqli_real_escape_string($db->link, $_POST['personal_pay']);
	$personal_pay_type		= mysqli_real_escape_string($db->link, $_POST['personal_pay_type']);
	$ir						= mysqli_real_escape_string($db->link, $_POST['ir']);
	$ir_type				= mysqli_real_escape_string($db->link, $_POST['ir_type']);
	$medical_allowence		= mysqli_real_escape_string($db->link, $_POST['medical_allowence']);
	$medical_allowence_type	= mysqli_real_escape_string($db->link, $_POST['medical_allowence_type']);
	$hra					= mysqli_real_escape_string($db->link, $_POST['hra']);
	$hra_type				= mysqli_real_escape_string($db->link, $_POST['hra_type']);
	$hill_allowence			= mysqli_real_escape_string($db->link, $_POST['hill_allowence']);
	$hill_allowence_type	= mysqli_real_escape_string($db->link, $_POST['hill_allowence_type']);
	$border_allowence		= mysqli_real_escape_string($db->link, $_POST['border_allowence']);
	$border_allowence_type	= mysqli_real_escape_string($db->link, $_POST['border_allowence_type']);
	$cca					= mysqli_real_escape_string($db->link, $_POST['cca']);
	$cca_type				= mysqli_real_escape_string($db->link, $_POST['cca_type']);
	$cycle_ph_allowence		= mysqli_real_escape_string($db->link, $_POST['cycle_ph_allowence']);
	$cycle_ph_allowence_type= mysqli_real_escape_string($db->link, $_POST['cycle_ph_allowence_type']);
	$cash_handling_allowence= mysqli_real_escape_string($db->link, $_POST['cash_handling_allowence']);
	$cash_handling_allowence_type= mysqli_real_escape_string($db->link, $_POST['cash_handling_allowence_type']);
	$pollution_allowence	= mysqli_real_escape_string($db->link, $_POST['pollution_allowence']);
	$pollution_allowence_type= mysqli_real_escape_string($db->link, $_POST['pollution_allowence_type']);
	$washing_allowence		= mysqli_real_escape_string($db->link, $_POST['washing_allowence']);
	$washing_allowence_type	= mysqli_real_escape_string($db->link, $_POST['washing_allowence_type']);
	
	$qry = "UPDATE `special_allowence` set `da`='$da', `da_type`='$da_type', `personal_pay`='$personal_pay', `personal_pay_type`='$personal_pay_type', `ir`='$ir', `ir_type`='$ir_type', `medical_allowence`='$medical_allowence', `medical_allowence_type`='$medical_allowence_type', `hra`='$hra', `hra_type`='$hra_type', `hill_allowence`='$hill_allowence', `hill_allowence_type`='$hill_allowence_type', `border_allowence`='$border_allowence', `border_allowence_type`='$border_allowence_type', `cca`='$cca', `cca_type`='$cca_type', `cycle_ph_allowence`='$cycle_ph_allowence', `cycle_ph_allowence_type`='$cycle_ph_allowence_type', `cash_handling_allowence`='$cash_handling_allowence', `cash_handling_allowence_type`='$cash_handling_allowence_type', `pollution_allowence`='$pollution_allowence', `pollution_allowence_type`='$pollution_allowence_type', `washing_allowence`='$washing_allowence', `washing_allowence_type`='$washing_allowence_type' where employee_code='$employee_code'";
	if ($db->insert($qry)) {
		echo "Success1";
	}else{
		echo "Something went wrong!";
	}
}



if(isset($_POST['add_service_book'])){
	$employee_code			= mysqli_real_escape_string($db->link, $_POST['employee_code']);
	$post_name				= mysqli_real_escape_string($db->link, $_POST['post_name']);
	$types					= mysqli_real_escape_string($db->link, $_POST['types']);
	$officiating			= mysqli_real_escape_string($db->link, $_POST['officiating']);
	$pay_in_substantive		= mysqli_real_escape_string($db->link, $_POST['pay_in_substantive']);
	$additional_pay			= mysqli_real_escape_string($db->link, $_POST['additional_pay']);
	$other_emoluments		= mysqli_real_escape_string($db->link, $_POST['other_emoluments']);
	$date_of_appointment	= mysqli_real_escape_string($db->link, $_POST['date_of_appointment']);
	$date_of_termination	= mysqli_real_escape_string($db->link, $_POST['date_of_termination']);
	$reasons_of_termination	= mysqli_real_escape_string($db->link, $_POST['reasons_of_termination']);
	
	$output='';
	
	$qry = "INSERT into `service_book` (`employee_code`,`post_name`,`types`,`officiating`,`pay_in_substantive`,`additional_pay`,`other_emoluments`,`date_of_appointment`,`date_of_termination`,`reasons_of_termination`) values ('$employee_code','$post_name','$types','$officiating','$pay_in_substantive','$additional_pay','$other_emoluments','$date_of_appointment','$date_of_termination','$reasons_of_termination')";
	if ($db->insert($qry)) {
		$i=1;
		$sql219 = "SELECT * FROM `service_book` WHERE employee_code = '".$employee_code."'";
		$exe219 = $db->select($sql219);
		while($record219 = $exe219->fetch_array()){
			$output .= '<tr>
				<td>'.$i.'</td>
				<td>'.$record219['post_name'].'</td>
				<td>'.$record219['types'].'</td>
				<td>'.$record219['officiating'].'</td>
				<td>'.$record219['pay_in_substantive'].'</td>
				<td>'.$record219['additional_pay'].'</td>
				<td>'.$record219['other_emoluments'].'</td>
				<td>'.$record219['date_of_appointment'].'</td>
				<td>'.$record219['date_of_termination'].'</td>
				<td>'.$record219['reasons_of_termination'].'</td>
			</tr>';
			$i++;
		}
		
		echo $output;
	}else{
		echo "Error";
	}
}



if(isset($_POST['action7'])) {
	if($_POST['action7']=='fetch_special_deduction'){
		$output = '';
		
		$sql212 = "SELECT * FROM `employee` WHERE employee_code = '".$_POST['query7']."'";
		$exe212 = $db->select($sql212);
		if ($exe212->num_rows > 0) {
			$sql21 = "SELECT * FROM `special_deduction` WHERE employee_code = '".$_POST['query7']."'";
			$exe21 = $db->select($sql21);
			if ($exe21->num_rows > 0) {
				$record = $exe21->fetch_array();
				
				$output .= '<div class="col-md-3 mb-3">
						<label class="form-label">EPF (INR / %)</label>
						<select name="epf_type" class="form-control" required>
							<option value="">~~~Choose~~~</option>';
							if($record['epf_type']=='INR'){
								$output .= '<option value="INR" selected>INR</option>
								<option value="%">%</option>';
							}else if($record['epf_type']=='%'){
								$output .= '<option value="INR">INR</option>
								<option value="%" selected>%</option>';
							}else{
								$output .= '<option value="INR">INR</option>
								<option value="%">%</option>';
							}
						$output .= '</select>
					</div>
					<div class="col-md-3 mb-3">
						<label class="form-label">EPF</label>
						<input type="text" name="epf" value="'.$record['epf'].'" class="form-control allow_float" placeholder="EPF" required>
					</div>
					<div class="col-md-3 mb-3">
						<label class="form-label">GPF (INR / %)</label>
						<select name="gpf_type" class="form-control" required>
							<option value="">~~~Choose~~~</option>';
							if($record['gpf_type']=='INR'){
								$output .= '<option value="INR" selected>INR</option>
								<option value="%">%</option>';
							}else if($record['gpf_type']=='%'){
								$output .= '<option value="INR">INR</option>
								<option value="%" selected>%</option>';
							}else{
								$output .= '<option value="INR">INR</option>
								<option value="%">%</option>';
							}
						$output .= '</select>
					</div>
					
					<div class="col-md-3 mb-3">
						<label class="form-label">GPF</label>
						<input type="text" name="gpf" value="'.$record['gpf'].'" class="form-control allow_float" placeholder="GPF" required>
					</div>
					<div class="col-md-3 mb-3">
						<label class="form-label">GIS I (INR / %)</label>
						<select name="gis_1_type" class="form-control" required>
							<option value="">~~~Choose~~~</option>';
							if($record['gis_1_type']=='INR'){
								$output .= '<option value="INR" selected>INR</option>
								<option value="%">%</option>';
							}else if($record['gis_1_type']=='%'){
								$output .= '<option value="INR">INR</option>
								<option value="%" selected>%</option>';
							}else{
								$output .= '<option value="INR">INR</option>
								<option value="%">%</option>';
							}
						$output .= '</select>
					</div>
					
					<div class="col-md-3 mb-3">
						<label class="form-label">GIS I</label>
						<input type="text" name="gis_1" value="'.$record['gis_1'].'" class="form-control allow_float" placeholder="GIS I" required>
					</div>
					<div class="col-md-3 mb-3">
						<label class="form-label">GIS II (INR / %)</label>
						<select name="gis_2_type" class="form-control" required>
							<option value="">~~~Choose~~~</option>';
							if($record['gis_2_type']=='INR'){
								$output .= '<option value="INR" selected>INR</option>
								<option value="%">%</option>';
							}else if($record['gis_2_type']=='%'){
								$output .= '<option value="INR">INR</option>
								<option value="%" selected>%</option>';
							}else{
								$output .= '<option value="INR">INR</option>
								<option value="%">%</option>';
							}
						$output .= '</select>
					</div>
					
					<div class="col-md-3 mb-3">
						<label class="form-label">GIS II</label>
						<input type="text" name="gis_2" value="'.$record['gis_2'].'" class="form-control allow_float" placeholder="GIS II" required>
					</div>
					<div class="col-md-3 mb-3">
						<label class="form-label">EWF (INR / %)</label>
						<select name="ewf_type" class="form-control" required>
							<option value="">~~~Choose~~~</option>';
							if($record['ewf_type']=='INR'){
								$output .= '<option value="INR" selected>INR</option>
								<option value="%">%</option>';
							}else if($record['ewf_type']=='%'){
								$output .= '<option value="INR">INR</option>
								<option value="%" selected>%</option>';
							}else{
								$output .= '<option value="INR">INR</option>
								<option value="%">%</option>';
							}
						$output .= '</select>
					</div>
					
					<div class="col-md-3 mb-3">
						<label class="form-label">EWF</label>
						<input type="text" name="ewf" value="'.$record['ewf'].'" class="form-control allow_float" placeholder="EWF" required>
					</div>
					<div class="col-md-3 mb-3">
						<label class="form-label">Society (INR / %)</label>
						<select name="society_type" class="form-control" required>
							<option value="">~~~Choose~~~</option>';
							if($record['society_type']=='INR'){
								$output .= '<option value="INR" selected>INR</option>
								<option value="%">%</option>';
							}else if($record['society_type']=='%'){
								$output .= '<option value="INR">INR</option>
								<option value="%" selected>%</option>';
							}else{
								$output .= '<option value="INR">INR</option>
								<option value="%">%</option>';
							}
						$output .= '</select>
					</div>
					
					<div class="col-md-3 mb-3">
						<label class="form-label">Society</label>
						<input type="text" name="society" value="'.$record['society'].'" class="form-control allow_float" placeholder="Society" required>
					</div>
					<div class="col-md-3 mb-3">
						<label class="form-label">House Maintenance (INR / %)</label>
						<select name="house_maintenance_type" class="form-control" required>
							<option value="">~~~Choose~~~</option>';
							if($record['house_maintenance_type']=='INR'){
								$output .= '<option value="INR" selected>INR</option>
								<option value="%">%</option>';
							}else if($record['house_maintenance_type']=='%'){
								$output .= '<option value="INR">INR</option>
								<option value="%" selected>%</option>';
							}else{
								$output .= '<option value="INR">INR</option>
								<option value="%">%</option>';
							}
						$output .= '</select>
					</div>
					
					<div class="col-md-3 mb-3">
						<label class="form-label">House Maintenance</label>
						<input type="text" name="house_maintenance" value="'.$record['house_maintenance'].'" class="form-control allow_float" placeholder="House Maintenance" required>
					</div>
					<div class="col-md-3 mb-3">
						<label class="form-label">Electricity Bill (INR / %)</label>
						<select name="electricity_type" class="form-control" required>
							<option value="">~~~Choose~~~</option>';
							if($record['electricity_type']=='INR'){
								$output .= '<option value="INR" selected>INR</option>
								<option value="%">%</option>';
							}else if($record['electricity_type']=='%'){
								$output .= '<option value="INR">INR</option>
								<option value="%" selected>%</option>';
							}else{
								$output .= '<option value="INR">INR</option>
								<option value="%">%</option>';
							}
						$output .= '</select>
					</div>
					
					<div class="col-md-3 mb-3">
						<label class="form-label">Electricity Bill</label>
						<input type="text" name="electricity" value="'.$record['electricity'].'" class="form-control allow_float" placeholder="Electricity Bill" required>
					</div>
					<div class="col-md-3 mb-3">
						<label class="form-label">Staff Car (INR / %)</label>
						<select name="staff_car_type" class="form-control" required>
							<option value="">~~~Choose~~~</option>';
							if($record['staff_car_type']=='INR'){
								$output .= '<option value="INR" selected>INR</option>
								<option value="%">%</option>';
							}else if($record['staff_car_type']=='%'){
								$output .= '<option value="INR">INR</option>
								<option value="%" selected>%</option>';
							}else{
								$output .= '<option value="INR">INR</option>
								<option value="%">%</option>';
							}
						$output .= '</select>
					</div>
					
					<div class="col-md-3 mb-3">
						<label class="form-label">Staff Car</label>
						<input type="text" name="staff_car" value="'.$record['staff_car'].'" class="form-control allow_float" placeholder="Staff Car" required>
					</div>
					<div class="col-md-3 mb-3">
						<label class="form-label">Income Tax (INR / %)</label>
						<select name="income_tax_type" class="form-control" required>
							<option value="">~~~Choose~~~</option>';
							if($record['income_tax_type']=='INR'){
								$output .= '<option value="INR" selected>INR</option>
								<option value="%">%</option>';
							}else if($record['income_tax_type']=='%'){
								$output .= '<option value="INR">INR</option>
								<option value="%" selected>%</option>';
							}else{
								$output .= '<option value="INR">INR</option>
								<option value="%">%</option>';
							}
						$output .= '</select>
					</div>
					
					<div class="col-md-3 mb-3">
						<label class="form-label">Income Tax</label>
						<input type="text" name="income_tax" value="'.$record['income_tax'].'" class="form-control allow_float" placeholder="Income Tax" required>
					</div>
					<div class="col-md-3 mb-3">
						<label class="form-label">Other Recovery (INR / %)</label>
						<select name="other_recovery_type" class="form-control" required>
							<option value="">~~~Choose~~~</option>';
							if($record['other_recovery_type']=='INR'){
								$output .= '<option value="INR" selected>INR</option>
								<option value="%">%</option>';
							}else if($record['other_recovery_type']=='%'){
								$output .= '<option value="INR">INR</option>
								<option value="%" selected>%</option>';
							}else{
								$output .= '<option value="INR">INR</option>
								<option value="%">%</option>';
							}
						$output .= '</select>
					</div>
					
					<div class="col-md-3 mb-3">
						<label class="form-label">Other Recovery</label>
						<input type="text" name="other_recovery" value="'.$record['other_recovery'].'" class="form-control allow_float" placeholder="Other Recovery" required>
					</div>
					<div class="col-md-3 mb-3">
						<label class="form-label">Recovery Day (INR / %)</label>
						<select name="recovery_day_type" class="form-control" required>
							<option value="">~~~Choose~~~</option>';
							if($record['recovery_day_type']=='INR'){
								$output .= '<option value="INR" selected>INR</option>
								<option value="%">%</option>';
							}else if($record['recovery_day_type']=='%'){
								$output .= '<option value="INR">INR</option>
								<option value="%" selected>%</option>';
							}else{
								$output .= '<option value="INR">INR</option>
								<option value="%">%</option>';
							}
						$output .= '</select>
					</div>
					
					<div class="col-md-3 mb-3">
						<label class="form-label">Recovery Day</label>
						<input type="text" name="recovery_day" value="'.$record['recovery_day'].'" class="form-control allow_float" placeholder="Recovery Day" required>
					</div>
					<div class="col-md-3 mb-3">
						<label class="form-label">Corporation Recovery (INR / %)</label>
						<select name="corporation_recovery_type" class="form-control" required>
							<option value="">~~~Choose~~~</option>';
							if($record['corporation_recovery_type']=='INR'){
								$output .= '<option value="INR" selected>INR</option>
								<option value="%">%</option>';
							}else if($record['corporation_recovery_type']=='%'){
								$output .= '<option value="INR">INR</option>
								<option value="%" selected>%</option>';
							}else{
								$output .= '<option value="INR">INR</option>
								<option value="%">%</option>';
							}
						$output .= '</select>
					</div>
					
					<div class="col-md-3 mb-3">
						<label class="form-label">Corporation Recovery</label>
						<input type="text" name="corporation_recovery" value="'.$record['corporation_recovery'].'" class="form-control allow_float" placeholder="Corporation Recovery" required>
					</div>
				</div>
				
				<div class="col-md-12 mb-3">
					<input type="hidden" name="update_special_deduction" value="update_special_deduction">
                    <button id="department_button" class="btn btn-primary" type="submit">Update</button>
				</div>';
				
			}else{
				$output .= '<div class="col-md-3 mb-3">
					<label class="form-label">EPF (INR / %)</label>
					<select name="epf_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">EPF</label>
					<input type="text" name="epf" class="form-control allow_float" placeholder="EPF" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">GPF (INR / %)</label>
					<select name="gpf_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">GPF</label>
					<input type="text" name="gpf" class="form-control allow_float" placeholder="GPF" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">GIS I (INR / %)</label>
					<select name="gis_1_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">GIS I</label>
					<input type="text" name="gis_1" class="form-control allow_float" placeholder="GIS I" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">GIS II (INR / %)</label>
					<select name="gis_2_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">GIS II</label>
					<input type="text" name="gis_2" class="form-control allow_float" placeholder="GIS II" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">EWF (INR / %)</label>
					<select name="ewf_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">EWF</label>
					<input type="text" name="ewf" class="form-control allow_float" placeholder="EWF" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Society (INR / %)</label>
					<select name="society_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">Society</label>
					<input type="text" name="society" class="form-control allow_float" placeholder="Society" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">House Maintenance (INR / %)</label>
					<select name="house_maintenance_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">House Maintenance</label>
					<input type="text" name="house_maintenance" class="form-control allow_float" placeholder="House Maintenance" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Electricity Bill (INR / %)</label>
					<select name="electricity_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">Electricity Bill</label>
					<input type="text" name="electricity" class="form-control allow_float" placeholder="Electricity Bill" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Staff Car (INR / %)</label>
					<select name="staff_car_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">Staff Car</label>
					<input type="text" name="staff_car" class="form-control allow_float" placeholder="Staff Car" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Income Tax (INR / %)</label>
					<select name="income_tax_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">Income Tax</label>
					<input type="text" name="income_tax" class="form-control allow_float" placeholder="Income Tax" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Other Recovery (INR / %)</label>
					<select name="other_recovery_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">Other Recovery</label>
					<input type="text" name="other_recovery" class="form-control allow_float" placeholder="Other Recovery" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Recovery Day (INR / %)</label>
					<select name="recovery_day_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">Recovery Day</label>
					<input type="text" name="recovery_day" class="form-control allow_float" placeholder="Recovery Day" required>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label">Corporation Recovery (INR / %)</label>
					<select name="corporation_recovery_type" class="form-control" required>
						<option value="">~~~Choose~~~</option>
						<option value="INR">INR</option>
						<option value="%">%</option>
					</select>
				</div>
				
				<div class="col-md-3 mb-3">
					<label class="form-label">Corporation Recovery</label>
					<input type="text" name="corporation_recovery" class="form-control allow_float" placeholder="Corporation Recovery" required>
				</div>
			</div>
				
				<div class="col-md-12 mb-3">
					<input type="hidden" name="add_special_decution" value="add_special_decution">
                    <button id="department_button" class="btn btn-primary" type="submit">Save</button>
				</div>';
			}
			
			$output .= '<script type="text/javascript">
				$(function () {
					$(".allow_float").keypress(function (e) {
						var keyCode = e.keyCode || e.which;
						var regex = /^[.0-9]+$/;
						var isValid = regex.test(String.fromCharCode(keyCode));
						return isValid;
					});
				});
			</script>';
			$output .= '<script type="text/javascript">
				$(function () {
					$(".allow_number").keypress(function (e) {
						var keyCode = e.keyCode || e.which;
						var regex = /^[0-9]+$/;
						var isValid = regex.test(String.fromCharCode(keyCode));
						return isValid;
					});
				});
			</script>';
			$output .= '<script type="text/javascript">
				$(function () {
					$(".block_special").keypress(function (e) {
						var keyCode = e.keyCode || e.which;
						var regex = /^[0-9 A-Za-z_,]+$/;
						var isValid = regex.test(String.fromCharCode(keyCode));
						return isValid;
					});
				});
			</script>';
		}else{
			echo "Employee doesn't Exist!";
		}
		echo $output;
	}
}


if(isset($_POST['add_special_decution'])){
	$employee_code				= mysqli_real_escape_string($db->link, $_POST['employee_code']);
	$epf						= mysqli_real_escape_string($db->link, $_POST['epf']);
	$epf_type					= mysqli_real_escape_string($db->link, $_POST['epf_type']);
	$gpf						= mysqli_real_escape_string($db->link, $_POST['gpf']);
	$gpf_type					= mysqli_real_escape_string($db->link, $_POST['gpf_type']);
	$gis_1						= mysqli_real_escape_string($db->link, $_POST['gis_1']);
	$gis_1_type					= mysqli_real_escape_string($db->link, $_POST['gis_1_type']);
	$gis_2						= mysqli_real_escape_string($db->link, $_POST['gis_2']);
	$gis_2_type					= mysqli_real_escape_string($db->link, $_POST['gis_2_type']);
	$ewf						= mysqli_real_escape_string($db->link, $_POST['ewf']);
	$ewf_type					= mysqli_real_escape_string($db->link, $_POST['ewf_type']);
	$society					= mysqli_real_escape_string($db->link, $_POST['society']);
	$society_type				= mysqli_real_escape_string($db->link, $_POST['society_type']);
	$house_maintenance			= mysqli_real_escape_string($db->link, $_POST['house_maintenance']);
	$house_maintenance_type		= mysqli_real_escape_string($db->link, $_POST['house_maintenance_type']);
	$electricity				= mysqli_real_escape_string($db->link, $_POST['electricity']);
	$electricity_type			= mysqli_real_escape_string($db->link, $_POST['electricity_type']);
	$staff_car					= mysqli_real_escape_string($db->link, $_POST['staff_car']);
	$staff_car_type				= mysqli_real_escape_string($db->link, $_POST['staff_car_type']);
	$income_tax					= mysqli_real_escape_string($db->link, $_POST['income_tax']);
	$income_tax_type			= mysqli_real_escape_string($db->link, $_POST['income_tax_type']);
	$other_recovery				= mysqli_real_escape_string($db->link, $_POST['other_recovery']);
	$other_recovery_type		= mysqli_real_escape_string($db->link, $_POST['other_recovery_type']);
	$recovery_day				= mysqli_real_escape_string($db->link, $_POST['recovery_day']);
	$recovery_day_type			= mysqli_real_escape_string($db->link, $_POST['recovery_day_type']);
	$corporation_recovery		= mysqli_real_escape_string($db->link, $_POST['corporation_recovery']);
	$corporation_recovery_type	= mysqli_real_escape_string($db->link, $_POST['corporation_recovery_type']);
	
	$qry = "insert into `special_deduction` (employee_code,epf,epf_type,gpf,gpf_type,gis_1,gis_1_type,gis_2,gis_2_type,ewf,ewf_type,society,society_type,house_maintenance,house_maintenance_type,electricity,electricity_type,staff_car,staff_car_type,income_tax,income_tax_type,other_recovery,other_recovery_type,recovery_day,recovery_day_type,corporation_recovery,corporation_recovery_type) values ('$employee_code','$epf','$epf_type','$gpf','$gpf_type','$gis_1','$gis_1_type','$gis_2','$gis_2_type','$ewf','$ewf_type','$society','$society_type','$house_maintenance','$house_maintenance_type','$electricity','$electricity_type','$staff_car','$staff_car_type','$income_tax','$income_tax_type','$other_recovery','$other_recovery_type','$recovery_day','$recovery_day_type','$corporation_recovery','$corporation_recovery_type')";
	if ($db->insert($qry)) {
		echo "Success";
	}else{
		echo "Something went wrong!";
	}
}

if(isset($_POST['update_special_decution'])){
	$employee_code				= mysqli_real_escape_string($db->link, $_POST['employee_code']);
	$epf						= mysqli_real_escape_string($db->link, $_POST['epf']);
	$epf_type					= mysqli_real_escape_string($db->link, $_POST['epf_type']);
	$gpf						= mysqli_real_escape_string($db->link, $_POST['gpf']);
	$gpf_type					= mysqli_real_escape_string($db->link, $_POST['gpf_type']);
	$gis_1						= mysqli_real_escape_string($db->link, $_POST['gis_1']);
	$gis_1_type					= mysqli_real_escape_string($db->link, $_POST['gis_1_type']);
	$gis_2						= mysqli_real_escape_string($db->link, $_POST['gis_2']);
	$gis_2_type					= mysqli_real_escape_string($db->link, $_POST['gis_2_type']);
	$ewf						= mysqli_real_escape_string($db->link, $_POST['ewf']);
	$ewf_type					= mysqli_real_escape_string($db->link, $_POST['ewf_type']);
	$society					= mysqli_real_escape_string($db->link, $_POST['society']);
	$society_type				= mysqli_real_escape_string($db->link, $_POST['society_type']);
	$house_maintenance			= mysqli_real_escape_string($db->link, $_POST['house_maintenance']);
	$house_maintenance_type		= mysqli_real_escape_string($db->link, $_POST['house_maintenance_type']);
	$electricity				= mysqli_real_escape_string($db->link, $_POST['electricity']);
	$electricity_type			= mysqli_real_escape_string($db->link, $_POST['electricity_type']);
	$staff_car					= mysqli_real_escape_string($db->link, $_POST['staff_car']);
	$staff_car_type				= mysqli_real_escape_string($db->link, $_POST['staff_car_type']);
	$income_tax					= mysqli_real_escape_string($db->link, $_POST['income_tax']);
	$income_tax_type			= mysqli_real_escape_string($db->link, $_POST['income_tax_type']);
	$other_recovery				= mysqli_real_escape_string($db->link, $_POST['other_recovery']);
	$other_recovery_type		= mysqli_real_escape_string($db->link, $_POST['other_recovery_type']);
	$recovery_day				= mysqli_real_escape_string($db->link, $_POST['recovery_day']);
	$recovery_day_type			= mysqli_real_escape_string($db->link, $_POST['recovery_day_type']);
	$corporation_recovery		= mysqli_real_escape_string($db->link, $_POST['corporation_recovery']);
	$corporation_recovery_type	= mysqli_real_escape_string($db->link, $_POST['corporation_recovery_type']);
	
	$qry = "UPDATE `special_deduction` set `epf`='$epf', `epf_type`='$epf_type', `gpf`='$gpf', `gpf_type`='$gpf_type', `gis_1`='$gis_1', `gis_1_type`='$gis_1_type', `gis_2`='$gis_2', `gis_2_type`='$gis_2_type', `ewf`='$ewf', `ewf_type`='$ewf_type', `society`='$society', `society_type`='$society_type', `house_maintenance`='$house_maintenance', `house_maintenance_type`='$house_maintenance_type', `electricity`='$electricity', `electricity_type`='$electricity_type', `staff_car`='$staff_car', `staff_car_type`='$staff_car_type', `income_tax`='$income_tax', `income_tax_type`='$income_tax_type', `other_recovery`='$other_recovery', `other_recovery_type`='$other_recovery_type', `recovery_day`='$recovery_day', `recovery_day_type`='$recovery_day_type', `corporation_recovery`='$corporation_recovery', `corporation_recovery_type`='$corporation_recovery_type' where employee_code='$employee_code'";
	if ($db->insert($qry)) {
		echo "Success";
	}else{
		echo "Something went wrong!";
	}
}


if(isset($_POST['action41'])){
	if($_POST['action41']=='employee_checkin'){
		$employee = $_SESSION['astro_email'];
		
		$lat   	= mysqli_real_escape_string($db->link, $_POST['lat']);
		$long1	= mysqli_real_escape_string($db->link, $_POST['long1']);
		
		$attendance_date=date("Y-m-d");
		$check_in=date("h:i A");
		if($_POST['query41']=='2'){
			$query="update attendance set check_out='$check_in', check_out_lat='$lat', check_out_lng='$long1' where employee='$employee'and attendance_date='$attendance_date'";
			$db->insert($query);
		}else{
			$query="insert into attendance (employee,attendance_date,check_in,check_in_lat,check_in_lng) values ('$employee','$attendance_date','$check_in','$lat','$long1')";
			$db->insert($query);
		}
	}
	//echo $output;
}


if(isset($_POST['action8'])){
	if($_POST['action8']=='regulize_popup'){
	    $employee       = $_SESSION['astro_email'];
	    
		$output = '';
		$output .= '<div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Request Attendance Regularization - '.date("d M, Y",strtotime($_POST['query8'])).'</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">';
                    
                    $sql = "SELECT * FROM `regulization_request` WHERE employee = '$employee' and requested_date='".$_POST['query8']."'";
            		$exe = $db->select($sql);
            		if ($exe->num_rows > 0) {
            		    $record = $exe->fetch_array();
            		    
            		    if($record['is_approved']=='0'){
            		        $output .= '<p class="text-warning">Attendance regularization already requested.</p>';
            		    }else{
            		        $output .= '<p class="text-warning">Attendance regularization request is already approved.</p>';
            		    }
            		}else{
            		    $output .= '<p>Raise regularization request to exempt this day from tracking policy penalization.</p>';
            		}
                    
                $output .= '<span class="text-success" id="message"></span>
                    </div>
                    <div class="col-md-12 mb-3">
                        <textarea class="form-control" rows="5" name="request"></textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <input type="hidden" name="requested_date" value="'.$_POST['query8'].'">
                        <input type="hidden" name="regulization_request" value="regulization_request">
                        <button type="submit" id="regulize_button" class="btn btn-primary">Request</button>
                    </div>
                </div>
            </div>';
		echo $output;
	}	
}

if(isset($_POST['action_appoint'])){
	if($_POST['action_appoint']=='appoint_popup'){
	    $employee       = $_SESSION['astro_email'];
	    
		$output = '';
		$output .= '<div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Appoint Employee</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">';
                    if($_SESSION['astro_role']=='Head Quarter'){
						$output .= '<input type="hidden" id="work_location" name="work_location" value="Head Quarter">';
					}else if($_SESSION['astro_role']=='Division'){
						$sql = "SELECT * FROM `division` WHERE phone = '$employee'";
						$exe = $db->select($sql);
						$record1 = $exe->fetch_array();
						
						$output .= '<input type="hidden" id="work_location" name="work_location" value="Division">';
						$output .= '<input type="hidden" id="office_name" name="office_name" value="'.$record1['id'].'">';
					}else if($_SESSION['astro_role']=='Depot'){
						$sql = "SELECT * FROM `deport` WHERE phone = '$employee'";
						$exe = $db->select($sql);
						$record1 = $exe->fetch_array();
						
						$output .= '<input type="hidden" id="work_location" name="work_location" value="Depot">';
						$output .= '<input type="hidden" id="office_name" name="office_name" value="'.$record1['id'].'">';
					}
					
                $output .= '<span id="message"></span>
                    </div>
                    <div class="col-md-12 mb-3">
						<label class="form-label">Reporting Manager Post</label>
                        <select name="reporting_manager" id="reporting_manager" onchange="action41(this.value)" class="form-control" required>
							<option value="">~~~Choose~~~</option>';
							$query="select * from post where id!='1'";
							$row=$db->select($query);
							while($record=$row->fetch_array()){
								$output .= '<option value="'.$record['id'].'">'.$record['post_name'].'</option>';
							}
						$output .= '</select>
                    </div>
					<div class="col-md-12 mb-3">
						<label class="form-label">Reporting Manager Name</label>
                        <select name="reporting_manager_name" id="reporting_manager_name" class="form-control" required>
							<option value="">~~~Choose~~~</option>
							
						</select>
                    </div>
					
					<div class="col-md-12 mb-3">
						<label class="form-label">Appointment Letter</label>
                        <input type="file" name="appointment_letter" class="form-control" required>
                    </div>
					
                    <div class="col-md-12 mb-3">
                        <input type="hidden" name="request_id" value="'.$_POST['query_appoint'].'">
                        <input type="hidden" name="appoint_employee" value="appoint_employee">
                        <button type="submit" id="regulize_button" class="btn btn-primary">Appoint Now</button>
                    </div>
                </div>
            </div>';
		echo $output;
	}	
}

if(isset($_POST['action_appoint1'])){
	if($_POST['action_appoint1']=='appoint_popup1'){
	    $employee       = $_SESSION['astro_email'];
	    
		$output = '';
		$output .= '<div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Appoint Employee</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">';
                    if($_SESSION['astro_role']=='Head Quarter'){
						$output .= '<input type="hidden" id="work_location" name="work_location" value="Head Quarter">';
					}else if($_SESSION['astro_role']=='Division'){
						$sql = "SELECT * FROM `division` WHERE phone = '$employee'";
						$exe = $db->select($sql);
						$record1 = $exe->fetch_array();
						
						$output .= '<input type="hidden" id="work_location" name="work_location" value="Division">';
						$output .= '<input type="hidden" id="office_name" name="office_name" value="'.$record1['id'].'">';
					}else if($_SESSION['astro_role']=='Depot'){
						$sql = "SELECT * FROM `deport` WHERE phone = '$employee'";
						$exe = $db->select($sql);
						$record1 = $exe->fetch_array();
						
						$output .= '<input type="hidden" id="work_location" name="work_location" value="Depot">';
						$output .= '<input type="hidden" id="office_name" name="office_name" value="'.$record1['id'].'">';
					}
					
                $output .= '<span id="message"></span>
                    </div>
                    <div class="col-md-12 mb-3">
						<label class="form-label">Reporting Manager Post</label>
                        <select name="reporting_manager" id="reporting_manager" onchange="action41(this.value)" class="form-control" required>
							<option value="">~~~Choose~~~</option>';
							$query="select * from post where id!='1'";
							$row=$db->select($query);
							while($record=$row->fetch_array()){
								$output .= '<option value="'.$record['id'].'">'.$record['post_name'].'</option>';
							}
						$output .= '</select>
                    </div>
					<div class="col-md-12 mb-3">
						<label class="form-label">Reporting Manager Name</label>
                        <select name="reporting_manager_name" id="reporting_manager_name" class="form-control" required>
							<option value="">~~~Choose~~~</option>
							
						</select>
                    </div>
					
					<div class="col-md-12 mb-3">
						<label class="form-label">Appointment Letter</label>
                        <input type="file" name="appointment_letter" class="form-control" required>
                    </div>
					
                    <div class="col-md-12 mb-3">
                        <input type="hidden" name="request_id" value="'.$_POST['query_appoint1'].'">
                        <input type="hidden" name="appoint_employee1" value="appoint_employee1">
                        <button type="submit" id="regulize_button" class="btn btn-primary">Appoint Now</button>
                    </div>
                </div>
            </div>';
		echo $output;
	}	
}


if(isset($_POST['regulization_request'])){
	$employee       = $_SESSION['astro_email'];
	$request		= mysqli_real_escape_string($db->link, $_POST['request']);
	$requested_date	= mysqli_real_escape_string($db->link, $_POST['requested_date']);
	$requested_on	= date("Y-m-d");
	$requested_on_time = date("H:i:s");
	
	$query="insert into regulization_request (employee,request,requested_date,requested_on,requested_on_time) values ('$employee','$request','$requested_date','$requested_on','$requested_on_time')";
	if ($db->insert($query)) {
		echo "Success";
	}else{
		echo "Something went wrong!";
	}
}

if(isset($_POST['appoint_employee'])){
	$joining_date   = date("Y-m-d");
	$joined_by      = $_SESSION['astro_email'];
	$request_id		= mysqli_real_escape_string($db->link, $_POST['request_id']);
	
	$sql1 = "SELECT * FROM `transfer_request` WHERE id='".$request_id."'";
	$exe1 = $db->select($sql1);
	$record1 = $exe1->fetch_array();
	
	$sql = "SELECT * FROM `employee` WHERE employee_code='".$record1['employee']."'";
	$exe = $db->select($sql);
	$record = $exe->fetch_array();
	
	$curr_work_location 			= $record['work_location'];
	$curr_office_name 				= $record['office_name'];
	$curr_reporting_manager 		= $record['reporting_manager'];
	$curr_reporting_manager_name 	= $record['reporting_manager_name'];
	$curr_appointment_officer 		= $record['appointment_officer'];
	$curr_appointment_officer_name	= $record['appointment_officer_name'];
	
	$post 							= $record1['post'];
	$employee 						= $record1['employee'];
	$new_work_location 				= $record1['to_work_location'];
	$new_office_name 				= $record1['to_office_name'];
	$new_reporting_manager 			= $_POST['reporting_manager'];
	$new_reporting_manager_name 	= $_POST['reporting_manager_name'];
	$new_appointment_officer 		= $record1['appointment_officer'];
	$new_appointment_officer_name	= $record1['appointment_officer_name'];
	
	$query="insert into transfer_history (request_id,employee,work_location,office_name,post,reporting_manager,reporting_manager_name,appointment_officer,appointment_officer_name,joined_by,joining_date) values ('$request_id','$employee','$curr_work_location','$curr_office_name','$post','$curr_reporting_manager','$curr_reporting_manager_name','$curr_appointment_officer','$curr_appointment_officer_name','$joined_by','$joining_date')";
	if ($db->insert($query)) {
		
		if($_FILES["appointment_letter"]["name"] != '')
		{
			$test = explode('.', $_FILES["appointment_letter"]["name"]);
			$ext = end($test);
			$name = rand(10000, 99999) . '.' . $ext;
			$location = 'assets/images/appointment_letter/' . $name;  
			$location1 = 'assets/images/appointment_letter/' . $name;  
			if(move_uploaded_file($_FILES["appointment_letter"]["tmp_name"], $location))
			{
				$query3="update transfer_history set appointment_letter='$location1' where request_id='$request_id'";
				$db->insert($query3);
			}
		}
		
		$query1="update employee set current_post_date='$joining_date', work_location='$new_work_location', office_name='$new_office_name', reporting_manager='$new_reporting_manager', reporting_manager_name='$new_reporting_manager_name', appointment_officer='$new_appointment_officer',appointment_officer_name='$new_appointment_officer_name' where employee_code='$employee'";
		$db->insert($query1);
		
		$query2="update transfer_request set is_transfer='1', joined_by='$joined_by', joining_date='$joining_date' where id='$request_id'";
		$db->insert($query2);
		
		echo "Success";
	}else{
		echo "Something went wrong!";
	}
}

if(isset($_POST['appoint_employee1'])){
	$joining_date   = date("Y-m-d");
	$joined_by      = $_SESSION['astro_email'];
	$request_id		= mysqli_real_escape_string($db->link, $_POST['request_id']);
	
	$sql1 = "SELECT * FROM `promotion_request` WHERE id='".$request_id."'";
	$exe1 = $db->select($sql1);
	$record1 = $exe1->fetch_array();
	
	$sql = "SELECT * FROM `employee` WHERE employee_code='".$record1['employee']."'";
	$exe = $db->select($sql);
	$record = $exe->fetch_array();
	
	$curr_post 						= $record['post'];
	$curr_work_location 			= $record['work_location'];
	$curr_office_name 				= $record['office_name'];
	$curr_reporting_manager 		= $record['reporting_manager'];
	$curr_reporting_manager_name 	= $record['reporting_manager_name'];
	$curr_appointment_officer 		= $record['appointment_officer'];
	$curr_appointment_officer_name	= $record['appointment_officer_name'];
	
	$new_to_post 					= $record1['to_post'];
	$employee 						= $record1['employee'];
	$new_work_location 				= $record1['to_work_location'];
	$new_office_name 				= $record1['to_office_name'];
	$new_reporting_manager 			= $_POST['reporting_manager'];
	$new_reporting_manager_name 	= $_POST['reporting_manager_name'];
	$new_appointment_officer 		= $record1['appointment_officer'];
	$new_appointment_officer_name	= $record1['appointment_officer_name'];
	
	$query="insert into promotion_history (request_id,post,employee,work_location,office_name,reporting_manager,reporting_manager_name,appointment_officer,appointment_officer_name,joined_by,joining_date) values ('$request_id','$curr_post','$employee','$curr_work_location','$curr_office_name','$curr_reporting_manager','$curr_reporting_manager_name','$curr_appointment_officer','$curr_appointment_officer_name','$joined_by','$joining_date')";
	if ($db->insert($query)) {
		
		if($_FILES["appointment_letter"]["name"] != '')
		{
			$test = explode('.', $_FILES["appointment_letter"]["name"]);
			$ext = end($test);
			$name = rand(10000, 99999) . '.' . $ext;
			$location = 'assets/images/appointment_letter/' . $name;  
			$location1 = 'assets/images/appointment_letter/' . $name;  
			if(move_uploaded_file($_FILES["appointment_letter"]["tmp_name"], $location))
			{
				$query3="update promotion_history set appointment_letter='$location1' where request_id='$request_id'";
				$db->insert($query3);
			}
		}
		
		$query1="update employee set current_post_date='$joining_date', post='$new_to_post', work_location='$new_work_location', office_name='$new_office_name', reporting_manager='$new_reporting_manager', reporting_manager_name='$new_reporting_manager_name', appointment_officer='$new_appointment_officer',appointment_officer_name='$new_appointment_officer_name' where employee_code='$employee'";
		$db->insert($query1);
		
		$query2="update promotion_request set is_transfer='1', post='$curr_post', joined_by='$joined_by', joining_date='$joining_date' where id='$request_id'";
		$db->insert($query2);
		
		echo "Success";
	}else{
		echo "Something went wrong!";
	}
}


if(isset($_POST['action9'])){
	if($_POST['action9']=='regulize_popup'){
	    $employee       = $_SESSION['astro_email'];
	    
		$sql = "SELECT * FROM `regulization_request` WHERE id='".$_POST['query9']."'";
		$exe = $db->select($sql);
		$record = $exe->fetch_array();
		
		$sql1 = "SELECT * FROM `employee` WHERE phone='".$record['employee']."'";
		$exe1 = $db->select($sql1);
		$record1 = $exe1->fetch_array();
		
		$output = '';
		$output .= '<div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Request Attendance Details - '.date("d M, Y",strtotime($record['requested_date'])).'</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                
            </div>
            <div class="modal-body">
                <div class="row">
                    
                    <div class="col-md-12 mb-3">
                        
						<div class="text-muted">
							 <div class="row">
								<div class="col-lg-12">
									<div class="d-flex align-items-start mt-3">
										<div class="me-2 align-self-center">
											<i class="ri-calendar-event-line h2 m-0 text-muted"></i>
										</div>
										<div class="flex-1 overflow-hidden">
											<p class="mb-1">'.date("l",strtotime($record['requested_date'])).'</p>
											<h5 class="mt-0 text-truncate">
												'.date("d M",strtotime($record['requested_date'])).'
											</h5>
										</div>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="d-flex align-items-start mt-3">
										<div class="me-2 align-self-center">
											<img src="assets/images/dummy.webp" alt="" class="avatar-sm rounded-circle">
										</div>
										<div class="flex-1 overflow-hidden">
											<p class="mb-1">Requested by</p>
											<h5 class="mt-0 text-truncate">
												'.$record1['employee_name'].' on '.date("d M, Y h:i A",strtotime($record['requested_on'])).'
											</h5>
										</div>
									</div>
								</div>';
								
								if($record['is_approved']=='1'){
									$output .= '<div class="col-lg-12">
										<div class="d-flex align-items-start mt-3">
											<div class="me-2 align-self-center">
												<i class="fa fa-check-circle h2 m-0 text-success"></i>
											</div>
											<div class="flex-1 overflow-hidden">
												<p class="mb-1">Approved by</p>
												<h5 class="mt-0 text-truncate">
													'.$record['action_taken_by'].' on '.date("d M, y",strtotime($record['action_taken_on'])).'
												</h5>
											</div>
										</div>
									</div>';
								}else{
									$output .= '<div class="col-lg-12">
										<div class="d-flex align-items-start mt-3">
											<div class="me-2 align-self-center">
												<i class="fa fa-exclamation-triangle h2 m-0 text-warning"></i>
											</div>
											<div class="flex-1 overflow-hidden">
												<p class="mb-1">Request Status</p>
												<h5 class="mt-0 text-truncate">
													Pending
												</h5>
											</div>
										</div>
									</div>';
								}
								
								
								
							$output .= '</div>
						</div>

                    </div>
                    
                </div>
            </div>';
		echo $output;
	}	
}


if(isset($_POST['add_leave'])){
	$employee       = $_SESSION['astro_email'];
	$from_date		= mysqli_real_escape_string($db->link, $_POST['from_date']);
	$to_date		= mysqli_real_escape_string($db->link, $_POST['to_date']);
	$leave_type		= mysqli_real_escape_string($db->link, $_POST['leave_type']);
	$notes			= mysqli_real_escape_string($db->link, $_POST['notes']);
	$requested_on	= date("Y-m-d");
	
	$date1=date_create($from_date);
	$date2=date_create($to_date);
	$diff=date_diff($date1,$date2);
	$no_of_days = $diff->format("%a");
	
	$query="insert into leave_request (employee,from_date,to_date,no_of_days,leave_type,notes,requested_on) values ('$employee','$from_date','$to_date','$no_of_days','$leave_type','$notes','$requested_on')";
	if ($db->insert($query)) {
		$last_id1 = $db->link->insert_id;
		if($_FILES["documents"]["name"] != '')
		{
			$test = explode('.', $_FILES["documents"]["name"]);
			$ext = end($test);
			$name = rand(10000, 99999) . '.' . $ext;
			$location = 'assets/images/documents/' . $name;  
			if(move_uploaded_file($_FILES["documents"]["tmp_name"], $location))
			{
				$query="update leave_request set documents='$location' where id='$last_id1'";
				$db->insert($query);
			}
		}
		
		echo "Success";
	}else{
		echo "Something went wrong!";
	}
}


if(isset($_POST['action10'])){
	if($_POST['action10']=='fetch_end_date'){
		$this_value = "this.type='date'";
		echo '<label>To Date</label><input type="text" name="to_date" class="form-control" onfocus="('.$this_value.')" onchange="action11(this.value)" min="'.$_POST['query10'].'">';
	}
}


if(isset($_POST['action11'])){
	if($_POST['action11']=='fetch_leave_type'){
		$output = '';
		
		$today = date("Y-m-d");
		$start_date1 = date("Y")."-01-01";
		$end_date1 = date("Y")."-06-30";


		$start_date2 = date("Y")."-07-01";
		$end_date2 = date("Y")."-12-31";

		if($today >= $start_date1 && $today <= $end_date1){
			$total_el= '16';
		}else if($today >= $start_date2 && $today <= $end_date2){
			$total_el= '15';
		}
		
		$date1=date_create($_POST['from_date']);
		$date2=date_create($_POST['query11']);
		$diff=date_diff($date1,$date2);
		$day_diffrence = $diff->format("%a");
		
		$output .= '<option value="">Select</option>';
		
		$sql = "SELECT sum(no_of_days) as cl_count FROM `leave_request` WHERE employee = '".$_SESSION['astro_email']."' and leave_type='CL' and is_approved='1'";
		$exe = $db->select($sql);
		$record = $exe->fetch_array();
		
		$total_cl_count = 14 - $record['cl_count'];
		
		if($total_cl_count > 0){
			if($day_diffrence <= $total_cl_count){
				$output .= '<option value="CL">CL ( '.$total_cl_count.' Available )</option>';
			}else{
				$output .= '<option value="CL" class="text-danger" disabled>CL ( Not Available )</option>';
			}
		}else{
			$output .= '<option value="CL" class="text-danger" disabled>CL ( Not Available )</option>';
		}
		$sql1 = "SELECT sum(no_of_days) as el_count FROM `leave_request` WHERE employee = '".$_SESSION['astro_email']."' and leave_type='EL' and is_approved='1'";
		$exe1 = $db->select($sql1);
		$record1 = $exe1->fetch_array();
		
		$total_el_count = $total_el - $record1['el_count'];
		
		if($total_el_count > 0){
			if($day_diffrence <= $total_el_count){
				$output .= '<option value="EL">EL ( '.$total_el_count.' Available )</option>';
			}else{
				$output .= '<option value="EL" class="text-danger" disabled>EL ( Not Available )</option>';
			}
		}else{
			$output .= '<option value="EL" class="text-danger" disabled>EL ( Not Available )</option>';
		}
		
		$sql2 = "SELECT sum(no_of_days) as ml_count FROM `leave_request` WHERE employee = '".$_SESSION['astro_email']."' and leave_type='ML' and is_approved='1'";
		$exe2 = $db->select($sql2);
		$record2 = $exe2->fetch_array();
		
		$output .= '<option value="ML">ML ( &#x221E; Available )</option>
					<option value="LW">Leave Without Pay ( &#x221E; Available )</option>';
	
		echo $output;
	
	}
}

if(isset($_POST['action12'])){
	if($_POST['action12']=='fetch_attendance'){
		$output = '';
		
		if($_SESSION['astro_role']=='Division'){
			$query1="select * from division where phone='".$_SESSION['astro_email']."'";
			$row1=$db->select($query1);
			$record1=$row1->fetch_array();
			
			$query5 = "SELECT * FROM `employee` where employee_code='".$_POST['query12']."' and work_location='Division' and office_name='".$record1['id']."' and (attendance_type!='Manual' or attendance_type!=NULL)";
		}else if($_SESSION['astro_role']=='Depot'){
			$query1="select * from deport where phone='".$_SESSION['astro_email']."'";
			$row1=$db->select($query1);
			$record1=$row1->fetch_array();
			
			$query5 = "SELECT * FROM `employee` where employee_code='".$_POST['query12']."' and work_location='Depot' and office_name='".$record1['id']."' and (attendance_type!='Manual' or attendance_type!=NULL)";
		}else if($_SESSION['astro_role']=='Head Quarter'){
			$query5 = "SELECT * FROM `employee` where employee_code='".$_POST['query12']."' and work_location='Head Quarter' and (attendance_type!='Manual' or attendance_type!=NULL)";
		}else{
			$query5 = "SELECT * FROM `employee` where employee_code='".$_POST['query12']."' and (attendance_type!='Manual' or attendance_type!=NULL)";
		}
		$row5 = $db->select($query5);
		if ($row5->num_rows > 0) {
			$record5 = $row5->fetch_array();
			$today=date('Y-m-d');
			$last_date=date('Y-m-d', strtotime('-30 days'));
			for($i=$today; $i > $last_date; ($i = date('Y-m-d', strtotime('-1 days', strtotime($i))))){
				
				$a = "'".$i."'";
				
				$day_name = date('D', strtotime($i));
			
				if($day_name == 'Sun'){
					$output .= '<tr class="bg-info text-white">
						<td>'.date("D - d M, y",strtotime($i)).'</td>
						<td colspan="4" class="text-center">Weekly Off</td>
						<td colspan="2"></td>
					</tr>';
				}else{
					$query4 = "SELECT * FROM `attendance` WHERE employee='".$record5['phone']."' and attendance_date='$i'";
					$row4 = $db->select($query4);
					if ($row4->num_rows > 0) {
						$record4 = $row4->fetch_array();
						
						
						/*$query6 = "SELECT * FROM `department` where id='".$record5['department']."'";
						$row6 = $db->select($query6);
						$record6 = $row6->fetch_array();*/
						
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
							$mins1 = $tmins%60;
							
							$arrival = $hours1.'h '.$mins1.'m late';
						}
						
					$output .= '<tr>
							<td>'.date("D - d M, y",strtotime($i)).'</td>
							<td><i class="fa fa-arrow-right text-success" style="transform: rotate(135deg);"></i> &nbsp;'.$record4['check_in'].'</td>';
							if($record4['check_out']==NULL){
								$output .= '<td>--:--</td>';
							}else{
								$output .= '<td><i class="fa fa-arrow-right text-danger" style="transform: rotate(315deg);"></i> &nbsp;'.$record4['check_out'].'</td>';
							}
							$output .= '<td><a href="javascript:void(0)" onclick="action_map('.$record4['id'].')"><i class="fa fa-map-marker-alt"></i></a></td>
							<td>'.$hour.'</td>
							<td>'.$arrival.'</td>
							
						</tr>';
					}else{
						$output .= '<tr>
							<td>'.date("D - d M, y",strtotime($i)).'</td>
							<td>--:--</td>
							<td>--:--</td>
							<td>-----</td>
							<td>-----</td>
							<td>-----</td>
							
						</tr>';
					}
				}
			
			}
		}else{
			$output .="Employee Doesn't Exist!";
		}
		echo $output;
	}
}


if(isset($_POST['action13'])){
	if($_POST['action13']=='fetch_attendance_request'){
		$output = '';
		
		$query="select * from regulization_request where requested_on='".$_POST['query13']."'";
		$row=$db->select($query);
		if ($row->num_rows > 0) {
			while($record=$row->fetch_array()){
				if($_SESSION['astro_role']=='Division'){
					$query11="select * from division where phone='".$_SESSION['astro_email']."'";
					$row11=$db->select($query11);
					$record11=$row11->fetch_array();
					
					//$sql1 = "SELECT * FROM `employee` WHERE email='".$record['employee']."'";
					$sql1 = "SELECT * FROM `employee` where phone='".$record['employee']."' and work_location='Division' and office_name='".$record11['id']."' and (attendance_type!='Manual' or attendance_type!=NULL)";
				}else if($_SESSION['astro_role']=='Depot'){
					$query11="select * from deport where phone='".$_SESSION['astro_email']."'";
					$row11=$db->select($query11);
					$record11=$row11->fetch_array();
					
					$sql1 = "SELECT * FROM `employee` where phone='".$record['employee']."' and work_location='Depot' and office_name='".$record11['id']."' and (attendance_type!='Manual' or attendance_type!=NULL)";
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
					
					
					$output .= '<tr>
							<td>';
							if($record['is_approved']=='1'){
								
							}else{
								$output .='<input type="checkbox" class="checkAllData" name="request_id[]" value="'.$record['id'].'">';
							}
					$output .='</td>
						<td>'.date("D - d M, y",strtotime($record['requested_date'])).'</td>
						<td>Attendance Regulization</td>
						<td>'.date("d M, Y h:i A",strtotime($record['requested_on'])).'
							<br />'.$record1['employee_name'].'
						</td>
						<td>'.$record['request'].'</td>
						<td>';
							if($record['is_approved']=='1'){
								$output .= '<span class="text-success">Approved</span>';
							}else{
								$output .= '<span class="text-danger">Pending</span>';
							}
						$output .= '</td>
						<td>'.
							$action_taken_by.'
							<br />'.$action_taken_on.'
						</td>
						<td>
							<div class="dropdown float-end">
								<a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false" title="Absent" style="line-height: 1;">
									<i class="mdi mdi-dots-horizontal"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									<a href="javascript:void(0);" onclick="action9('.$record['id'].')" class="dropdown-item">View Request</a>
								</div>
							</div>
						</td>
					</tr>';
				}
			}
			
			$output .= '<tr>
					<td colspan="8">
						<input type="hidden" name="attendance_request_approval" value="attendance_request_approval">
						<button type="submit" id="attendance_request_approval_button" class="btn btn-primary btn-sm">Approve</button></td>
				</tr>';
		}
		
		echo $output;
	}
}


if(isset($_POST['attendance_request_approval'])){
	if(isset($_POST['request_id'])){
		$size = sizeof($_POST['request_id']);
	
		if($size > 0){
			$date = date("Y-m-d");
			for($i = 0; $i < $size; $i++){
				$request_id		= mysqli_real_escape_string($db->link, $_POST['request_id'][$i]);
				
				$query="update regulization_request set is_approved='1', action_taken_by='".$_SESSION['astro_email']."', action_taken_on='$date' where id='$request_id'";
				$db->insert($query);
			}
			echo 'Success';
		}else{
			echo "Please Select Atleast One Data!";
		}
	}else{
		echo "Please Select Atleast One Data!";
	}
}


if(isset($_POST['leave_request_approval'])){
	if(isset($_POST['request_id'])){
		$size = sizeof($_POST['request_id']);
	
		if($size > 0){
			$date = date("Y-m-d");
			for($i = 0; $i < $size; $i++){
				$request_id		= mysqli_real_escape_string($db->link, $_POST['request_id'][$i]);
				
				$query="update leave_request set is_approved='1', action_taken_by='".$_SESSION['astro_email']."', action_taken_on='$date' where id='$request_id'";
				$db->insert($query);
			}
			echo 'Success';
		}else{
			echo "Please Select Atleast One Data!";
		}
	}else{
		echo "Please Select Atleast One Data!";
	}
}

if(isset($_POST['action14'])){
	if($_POST['action14']=='fetch_leave_request'){
		$output = '';
			
		$query="select * from leave_request where requested_on='".$_POST['query14']."'";
		$row=$db->select($query);
		if ($row->num_rows > 0) {
			while($record=$row->fetch_array()){
				if($_SESSION['astro_role']=='Division'){
					$query11="select * from division where phone='".$_SESSION['astro_email']."'";
					$row11=$db->select($query11);
					$record11=$row11->fetch_array();
					
					$sql1 = "SELECT * FROM `employee` where phone='".$record['employee']."' and work_location='Division' and office_name='".$record11['id']."' and (attendance_type!='Manual' or attendance_type!=NULL)";
				}else if($_SESSION['astro_role']=='Depot'){
					$query11="select * from deport where phone='".$_SESSION['astro_email']."'";
					$row11=$db->select($query11);
					$record11=$row11->fetch_array();
					
					$sql1 = "SELECT * FROM `employee` where phone='".$record['employee']."' and work_location='Depot' and office_name='".$record11['id']."' and (attendance_type!='Manual' or attendance_type!=NULL)";
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
				
					/*$sql2 = "SELECT * FROM `login` WHERE email='".$record['action_taken_by']."'";
					$exe2 = $db->select($sql2);
					if ($exe2->num_rows > 0) {
						$record2 = $exe2->fetch_array();
						
						$name = $record2['name'];
					}else{
						$name ='';
					}*/
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
						<td>'.date("d M, Y",strtotime($record['requested_on'])).'
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
	}
}


if(isset($_POST['add_manual_attendance'])){
	if(isset($_POST['employee'])){
		$size = sizeof($_POST['employee']);
		
		$make_attendance_by	= $_SESSION['astro_email'];
		$attendance_date	= mysqli_real_escape_string($db->link, $_POST['attendance_date']);
		
		for($i=0; $i < $size; $i++){
			$employee			= mysqli_real_escape_string($db->link, $_POST['employee'][$i]);
			
			$query="insert into manual_attendance (employee,attendance_date,make_attendance_by) values ('$employee','$attendance_date','$make_attendance_by')";
			$db->insert($query);
		}
		echo 'Success';
	}else{
		echo "Please Select Atleast One Data!";
	}
}


if(isset($_POST['action16'])){
	if($_POST['action16']=='fetch_manual_attendance'){
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
			
			$query="select * from employee where attendance_type='Manual' and work_location='Depot' and office_name='".$record1['id']."'";
			$division_deport = $record2['deport'];
		}else if($_SESSION['astro_role']=='Head Quarter'){
			$query="select * from employee where attendance_type='Manual' and work_location='Head Quarter'";
			$division_deport = '';
		}else{
			$query="select * from employee where attendance_type='Manual'";
			$division_deport = '';
		}
		
		//$query="select * from employee where attendance_type='Manual'";
		$row=$db->select($query);
		if ($row->num_rows > 0) {
			while($record=$row->fetch_array()){
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
				
				$query4="select * from manual_attendance where employee='".$record['email']."' and attendance_date='".$_POST['query16']."'";
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
						<td><input type="checkbox" class="checkAllData" name="employee[]" value="'.$record['email'].'"></td>
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
	}
}



if(isset($_POST['action17'])){
	if($_POST['action17']=='fetch_order_list_data'){
		$output = '';
		
		$query5 = "SELECT * FROM `employee` where employee_code='".$_POST['query17']."'";
		$row5 = $db->select($query5);
		if ($row5->num_rows > 0) {
			$record5 = $row5->fetch_array();
		$output .= '<div class="col-lg-12 mb-2">
			<div class="row">
				<div class="col-md-3 pb-2">
					<label>Order Date</label>
					<input type="date" class="form-control" name="order_date">
				</div>
				
				<div class="col-md-3 pb-2">
					<label>Total Recovery</label>
					<input type="text" class="form-control block_alpha" name="total_recovery">
				</div>
				<div class="col-md-3 pb-2">
					<label>Recovery Installment</label>
					<input type="text" class="form-control block_alpha" name="recovery_installment">
				</div>
				<div class="col-md-3 pb-2">
					<label>No of Month</label>
					<input type="text" class="form-control block_alpha" name="no_of_month">
				</div>
				<div class="col-md-3 pb-2">
					<label>Starting Month</label>
					<select class="form-control" name="starting_month">
						<option value="">Month</option>';
						$query51 = "SELECT * FROM `month`";
						$row51 = $db->select($query51);
						while($record51 = $row51->fetch_array()){
							$output .= '<option value="'.$record51['month_no'].'">'.$record51['month_name'].'</option>';
						}
						
					$output .= '</select>
				</div>
				<div class="col-md-6 pb-2">
					<label>Order Summary</label>
					<input type="text" class="form-control" name="order_summary">
				</div>
				<div class="col-md-3 pb-2">
					<label>Upload Document</label>
					<input type="file" class="form-control" name="upload_doc">
				</div>
				
				<div class="col-md-3 pb-2">
					<br />
					<input type="hidden" name="employee" value="'.$record5['email'].'">
					<input type="hidden" name="add_order" value="add_order">
					<button type="submit" class="btn btn-primary" id="add_order_button">Submit</button>
				</div>
				
				
			</div>
		</div>
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-sm mb-0">
					<thead>
						<tr class="table-active">
							<th>Order Date</th>
							<th>Order Summary</th>
							<th>Total Recovery</th>
							<th>Recovery Installment</th>
							<th>No of Month</th>
							<th>Starting Month</th>
							<th>Document</th>
						</tr>
					</thead>
					<tbody id="order_list_data_all">';
						$query4 = "SELECT * FROM `orders` WHERE employee='".$record5['email']."'";
						$row4 = $db->select($query4);
						while($record4 = $row4->fetch_array()){
							$output .= '<tr>
								<td>'.date("d M, Y",strtotime($record4['order_date'])).'</td>
								<td>'.$record4['order_summary'].'</td>
								<td>'.$record4['total_recovery'].'</td>
								<td>'.$record4['recovery_installment'].'</td>
								<td>'.$record4['no_of_month'].'</td>
								<td>'.$record4['starting_month'].'</td>
								<td><a href="'.$record4['upload_doc'].'" target="_blank"><i class="fa fa-eye" class="btn btn-sm btn-primary"></i></a></td>
							</tr>';
						}
					$output .= '</tbody>
				</table>
			</div> 
		</div>
		
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
		</script>';
		}else{
			$output .="Employee Doesn't Exist!";
		}
		
		echo $output;
	}
}


if(isset($_POST['add_order'])){
	$ordered_by      		= $_SESSION['astro_email'];
	$employee				= mysqli_real_escape_string($db->link, $_POST['employee']);
	$order_date				= mysqli_real_escape_string($db->link, $_POST['order_date']);
	$order_summary			= mysqli_real_escape_string($db->link, $_POST['order_summary']);
	$total_recovery			= mysqli_real_escape_string($db->link, $_POST['total_recovery']);
	$recovery_installment	= mysqli_real_escape_string($db->link, $_POST['recovery_installment']);
	$no_of_month			= mysqli_real_escape_string($db->link, $_POST['no_of_month']);
	$starting_month			= mysqli_real_escape_string($db->link, $_POST['starting_month']);
	
	$query="insert into orders (ordered_by,employee,order_date,order_summary,total_recovery,recovery_installment,no_of_month,starting_month) values ('$ordered_by','$employee','$order_date','$order_summary','$total_recovery','$recovery_installment','$no_of_month','$starting_month')";
	if ($db->insert($query)) {
		$last_id1 = $db->link->insert_id;
		if($_FILES["upload_doc"]["name"] != '')
		{
			$test = explode('.', $_FILES["upload_doc"]["name"]);
			$ext = end($test);
			$name = rand(10000, 99999) . '.' . $ext;
			$location = 'assets/images/documents/' . $name;  
			if(move_uploaded_file($_FILES["upload_doc"]["tmp_name"], $location))
			{
				$query="update orders set upload_doc='$location' where id='$last_id1'";
				$db->insert($query);
			}
		}
		
		$output='';
		$query4 = "SELECT * FROM `orders` WHERE employee='".$employee."'";
		$row4 = $db->select($query4);
		while($record4 = $row4->fetch_array()){
			$output .= '<tr>
				<td>'.date("d M, Y",strtotime($record4['order_date'])).'</td>
				<td>'.$record4['order_summary'].'</td>
				<td>'.$record4['total_recovery'].'</td>
				<td>'.$record4['recovery_installment'].'</td>
				<td>'.$record4['no_of_month'].'</td>
				<td>'.$record4['starting_month'].'</td>
				<td><a href="'.$record4['upload_doc'].'" target="_blank"><i class="fa fa-eye" class="btn btn-sm btn-primary"></i></a></td>
			</tr>';
		}
		echo $output;
	}else{
		echo "Error";
	}
}


if(isset($_POST['salary_search'])){
	$month		= mysqli_real_escape_string($db->link, $_POST['month']);
	$year		= mysqli_real_escape_string($db->link, $_POST['year']);
	$salary_month = $year.'-'.$month;
	$no_of_days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
	
	$start_date = $year.'-'.$month.'-01';
	$end_date	= $year.'-'.$month.'-'.$no_of_days;
	
	$sundays=0;
    $total_days=cal_days_in_month(CAL_GREGORIAN, $month, $year);
    for($i=1;$i<=$total_days;$i++)
    if(date('N',strtotime($year.'-'.$month.'-'.$i))==7){
		$sundays++;
	}
    
	$output='';
	$current_month = date("Y-m");
	if($current_month >= $salary_month){
		$i= 1;
		$query4 = "SELECT * FROM `employee` where attendance_type='Geofence' order by employee_name asc";
		$row4 = $db->select($query4);
		while($record4 = $row4->fetch_array()){
			if($record4['basic_salary']=='' || $record4['basic_salary']==NULL){
				$basic_salary = 0;
			}else{
				$basic_salary = $record4['basic_salary'];
			}
			if($record4['grade_pay']=='' || $record4['grade_pay']==NULL){
				$grade_pay = 0;
			}else{
				$grade_pay = $record4['grade_pay'];
			}
			$query = "SELECT * FROM `allowence`";
			$row = $db->select($query);
			$record = $row->fetch_array();
			
			if($record['da_type']=='INR'){
				$da = $record['da'];
			}else{
				$da = ($basic_salary * $record['da'] )/100;
			}
			
			if($record['personal_pay_type']=='INR'){
				$personal_pay = $record['personal_pay'];
			}else{
				$personal_pay = ($basic_salary * $record['personal_pay'] )/100;
			}
			
			if($record['medical_allowence_type']=='INR'){
				$medical_allowence = $record['medical_allowence'];
			}else{
				$medical_allowence = ($basic_salary * $record['medical_allowence'] )/100;
			}
			
			if($record['hra_type']=='INR'){
				$hra	 = $record['hra'];
			}else{
				$hra	 = ($basic_salary * $record['hra'] )/100;
			}
			
			if($record['hill_allowence_type']=='INR'){
				$hill_allowence	 = $record['hill_allowence'];
			}else{
				$hill_allowence	 = ($basic_salary * $record['hill_allowence'] )/100;
			}
			
			if($record['border_allowence_type']=='INR'){
				$border_allowence	 = $record['border_allowence'];
			}else{
				$border_allowence	 = ($basic_salary * $record['border_allowence'] )/100;
			}
			
			if($record['cca_type']=='INR'){
				$cca	 = $record['cca'];
			}else{
				$cca	 = ($basic_salary * $record['cca'] )/100;
			}
			
			
			$query1 = "SELECT * FROM `deduction`";
			$row1 = $db->select($query1);
			$record1 = $row1->fetch_array();
			
			if($record1['epf_type']=='INR'){
				$epf = $record1['epf'];
			}else{
				$epf = ($basic_salary * $record1['epf'] )/100;
			}
			
			if($record1['gpf_type']=='INR'){
				$gpf = $record1['gpf'];
			}else{
				$gpf = ($basic_salary * $record1['gpf'] )/100;
			}
			
			if($record1['gpf_type']=='INR'){
				$gpf = $record1['gpf'];
			}else{
				$gpf = ($basic_salary * $record1['gpf'] )/100;
			}
			
			if($record1['gis_1_type']=='INR'){
				$gis_1 = $record1['gis_1'];
			}else{
				$gis_1 = ($basic_salary * $record1['gis_1'] )/100;
			}
			
			if($record1['gis_2_type']=='INR'){
				$gis_2 = $record1['gis_2'];
			}else{
				$gis_2 = ($basic_salary * $record1['gis_2'] )/100;
			}
			
			if($record1['ewf_type']=='INR'){
				$ewf = $record1['ewf'];
			}else{
				$ewf = ($basic_salary * $record1['ewf'] )/100;
			}
			
			if($record1['income_tax_type']=='INR'){
				$income_tax = $record1['income_tax'];
			}else{
				$income_tax = ($basic_salary * $record1['income_tax'] )/100;
			}
			
			$total_allowence = 0;
			$total_deduction = 0;
			
			$total_allowence = $da + $personal_pay + $medical_allowence + $hra + $hill_allowence + $border_allowence + $cca;
			
			$total_deduction = $epf + $gpf + $gis_1 + $gis_2 + $ewf + $income_tax;
			
			$total_salary = $basic_salary + ($total_allowence - $total_deduction) + $grade_pay;
			
			$salary_per_day = $total_salary / $no_of_days;
			
			$query1 = "SELECT count(id) as attendance_count FROM `attendance` where employee='".$record4['phone']."' and attendance_date LIKE '$salary_month%' and check_out!='NULL'";
			$row1 = $db->select($query1);
			$record1 = $row1->fetch_array();
			
			$query2 = "SELECT count(id) as regulization_count FROM `regulization_request` where employee='".$record4['phone']."' and requested_date LIKE '$salary_month%' and is_approved='1'";
			$row2 = $db->select($query2);
			$record2 = $row2->fetch_array();
			
			$query3 = "SELECT sum(lic_premium) as lic_premium_amount FROM `lic_data` where employee_code='".$record4['phone']."'";
			$row3 = $db->select($query3);
			$record3 = $row3->fetch_array();
			
			$leave_count =0;
			$query5 = "SELECT * FROM `leave_request` where employee='".$record4['phone']."' and ((from_date >= '$start_date' and from_date <= '$end_date') or (to_date >= '$start_date' and to_date <= '$end_date')) and is_approved='1'";
			$row5 = $db->select($query5);
			if ($row5->num_rows > 0) {
				while($record5 = $row5->fetch_array()){
					
					if($record5['leave_type']=='LW'){
						$no_of_days = 0;
					}else{
						if($record5['from_date'] <= $start_date){
							$date1=date_create($start_date);
							$date2=date_create($record5['to_date']);
							$diff=date_diff($date1,$date2);
							$no_of_days = $diff->format("%a");
							
							$no_of_days = $no_of_days + 1;
						}else if($record5['to_date'] >= $end_date){
							$date1=date_create($record5['from_date']);
							$date2=date_create($end_date);
							$diff=date_diff($date1,$date2);
							$no_of_days = $diff->format("%a");
							
							$no_of_days = $no_of_days + 1;
						}else if($record5['from_date'] >= $start_date && $record5['to_date'] <= $end_date){
							$date1=date_create($record5['from_date']);
							$date2=date_create($record5['to_date']);
							$diff=date_diff($date1,$date2);
							$no_of_days = $diff->format("%a");
							
							$no_of_days = $no_of_days + 1;
						}else{
							$no_of_days = 0;
						}
					}
					
					
					$leave_count = $leave_count + $no_of_days;
				}
			}
			
			if($record1['attendance_count'] > 0){
				$attendance_count = $record1['attendance_count'] + $sundays;
				$lic_premium_amount = $record3['lic_premium_amount'];
			}else{
				$attendance_count = $record1['attendance_count'];
				$lic_premium_amount = 0;
			}
			
			
			$attendance_count = $attendance_count + $record2['regulization_count'] + $leave_count;
			
			
			$gross_salary = ($salary_per_day * $attendance_count) - $lic_premium_amount;
			
			$output .= '<tr>
				<td>'.$i.'</td>
				<td>'.$record4['employee_code'].'</td>
				<td>'.$record4['employee_name'].'</td>
				<td><i class="fa fa-inr"></i> '.number_format($basic_salary,2).'</td>
				<td><i class="fa fa-inr"></i> '.number_format($grade_pay,2).'</td>
				<td><i class="fa fa-inr"></i> '.number_format($total_allowence,2).'</td>
				<td><i class="fa fa-inr"></i> '.number_format($total_deduction,2).'</td>
				<td><i class="fa fa-inr"></i> '.number_format($lic_premium_amount,2).'</td>
				<td><i class="fa fa-inr"></i> '.number_format($total_salary,2).'</td>
				<td><i class="fa fa-inr"></i> '.number_format($gross_salary,2).'</td>
				<td>
					<form method="POST" action="payslip" target="_blank">
						<input type="hidden" name="employee" value="'.base64_encode($record4['phone']).'">
						<input type="hidden" name="month" value="'.base64_encode($month).'">
						<input type="hidden" name="year" value="'.base64_encode($year).'">
						<button type="submit" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></button>
					</form>
				</td>
			</tr>';
			$i++;
		}
		$output .='<tr>
				<td colspan="11" class="text-center"><button type="button" class="btn btn-primary btn-sm" onclick="window.print()"><i class="fa fa-printer"></i> Print Now</button></td>
			</tr>';
	}else{
		echo 'Error';
	}
		
	echo $output;
}


if(isset($_POST['action19'])) {
	if($_POST['action19']=='fetch_tranfer_form'){
		$output = '';
		$sql21 = "SELECT * FROM `employee` WHERE employee_code = '".$_POST['query19']."'";
		$exe21 = $db->select($sql21);
		if ($exe21->num_rows > 0) {
			$record21 = $exe21->fetch_array();
			
			$output .= '<div class="row">
					<h4 id="message"></h4>';
					if($record21['work_location']=='Division'){
						$output .='<div class="col-md-3 mb-3" id="dep_div_data">
							<label class="form-label">Division Name</label>
							<select name="division" id="division" class="form-control" required>';
								$output .= '<option value="">~~~Choose~~~</option>';
								$query="select * from division";
								$row=$db->select($query);
								while($record=$row->fetch_array()){
									if($record21['division']==$record['id']){
										$output .= '<option value="'.$record['id'].'" selected>'.$record['division'].'</option>';
									}else{
										$output .= '<option value="'.$record['id'].'">'.$record['division'].'</option>';
									}
								}
								$output .='</select>
						</div>';
					}else if($record21['work_location']=='Depot'){
						$output .='<div class="col-md-3 mb-3" id="dep_div_data">
							<label class="form-label">Depot Name</label>
							<select name="deport" id="deport" class="form-control" required>';
								$output .= '<option value="">~~~Choose~~~</option>';
								$query="select * from deport";
								$row=$db->select($query);
								while($record=$row->fetch_array()){
									if($record21['deport']==$record['id']){
										$output .= '<option value="'.$record['id'].'" selected>'.$record['deport'].'</option>';
									}else{
										$output .= '<option value="'.$record['id'].'">'.$record['deport'].'</option>';
									}
								}
								$output .='</select>
						</div>';
					}else{
						
					}
					
					
			$output .='<div class="col-md-3 mb-3">
						<label class="form-label">Reporting Manager Name</label>
						<select name="reporting_manager_name" id="reporting_manager_name" class="form-control" required>
							<option value="">~~~Choose~~~</option>';
							$query="select * from employee where post='".$record21['reporting_manager']."'";
							$row=$db->select($query);
							while($record=$row->fetch_array()){
								if($record21['reporting_manager_name']==$record['id']){
									$output .= '<option value="'.$record['id'].'" selected>'.$record['employee_name'].'</option>';
								}else{
									$output .= '<option value="'.$record['id'].'">'.$record['employee_name'].'</option>';
								}
							}
			$output .='</select>
					</div>
					<div class="col-md-12 mb-3">
						<input type="hidden" name="add_transfer_data" value="add_transfer_data">
						<input type="hidden" name="employee" value="'.$record21['email'].'">
						<button id="department_button" class="btn btn-primary" type="submit">Save</button>
					</div>
					
				</div>
			</div>';
		}else{
			echo "Employee Doesn't Exist!";
		}
		
		echo $output;
		
		
	}
}

if(isset($_POST['action191'])) {
	if($_POST['action191']=='fetch_promotion_form'){
		$output = '';
		$sql21 = "SELECT * FROM `employee` WHERE employee_code = '".$_POST['query191']."'";
		$exe21 = $db->select($sql21);
		if ($exe21->num_rows > 0) {
			$record21 = $exe21->fetch_array();
			
			$output .= '<div class="row">
					<h4 id="message"></h4>
					<div class="col-md-3 mb-3">
						<label class="form-label">Department</label>
						<select name="department" class="form-control" required>
							<option value="">~~~Choose~~~</option>';
							$query="select * from department";
							$row=$db->select($query);
							while($record=$row->fetch_array()){
								$output .= '<option value="'.$record['id'].'">'.$record['department'].'</option>';
							}
						$output .= '</select>
					</div>
					
					<div class="col-md-3 mb-3">
						<label class="form-label">Post Name</label>
						<select name="post" onchange="action1(this.value)" class="form-control" required>
							<option value="">~~~Choose~~~</option>';
							$query="select * from post where id!='1'";
							$row=$db->select($query);
							while($record=$row->fetch_array()){
								$output .= '<option value="'.$record['id'].'">'.$record['post_name'].'</option>';
							}
						$output .= '</select>
					</div>
					<div class="col-md-3 mb-3">
						<label class="form-label">Work Location</label>
						<select name="work_location" onchange="action3(this.value)" class="form-control" required>
							<option value="">~~~Choose~~~</option>
							<option value="Head Quarter">Head Quarter</option>
							<option value="Division">Division</option>
							<option value="Depot">Depot</option>
							<option value="ISBT">ISBT</option>
						</select>
					</div>
					
					<div class="col-md-3 mb-3" id="dep_div_data"></div>
					
					<div class="col-md-3 mb-3">
						<label class="form-label">Reporting Manager</label>
						<select name="reporting_manager" id="reporting_manager" onchange="action4(this.value)" class="form-control" required>
							<option value="">~~~Choose~~~</option>
							
						</select>
					</div>
					<div class="col-md-3 mb-3">
						<label class="form-label">Reporting Manager Name</label>
						<select name="reporting_manager_name" id="reporting_manager_name" class="form-control" required>
							<option value="">~~~Choose~~~</option>
							
						</select>
					</div>
					<div class="col-md-12 mb-3">
						<input type="hidden" name="add_promotion_data" value="add_promotion_data">
						<input type="hidden" name="employee" value="'.$record21['email'].'">
						<button id="department_button" class="btn btn-primary" type="submit">Save</button>
					</div>
					
				</div>
				
				
				
			</div>';
			
		}else{
			echo "Employee Doesn't Exist!";
		}
		echo $output;
	}
}


if(isset($_POST['add_transfer_data'])){
	$employee				= mysqli_real_escape_string($db->link, $_POST['employee']);
	$department				= mysqli_real_escape_string($db->link, $_POST['department']);
	$post					= mysqli_real_escape_string($db->link, $_POST['post']);
	$work_location			= mysqli_real_escape_string($db->link, $_POST['work_location']);
	$reporting_manager		= mysqli_real_escape_string($db->link, $_POST['reporting_manager']);
	$reporting_manager_name	= mysqli_real_escape_string($db->link, $_POST['reporting_manager_name']);
	
	if(isset($_POST['division'])){
		$division	= mysqli_real_escape_string($db->link, $_POST['division']);
	}else{
		$division	= '';
	}
	
	if(isset($_POST['deport'])){
		$deport	= mysqli_real_escape_string($db->link, $_POST['deport']);
	}else{
		$deport	= '';
	}
	
	$sql21 = "SELECT * FROM `employee` WHERE email = '".$employee."'";
	$exe21 = $db->select($sql21);
	if ($exe21->num_rows > 0) {
		$record21 = $exe21->fetch_array();
		
		$department 			= $record21['department'];
		$post 					= $record21['post'];
		$work_location 			= $record21['work_location'];
		$reporting_manager 		= $record21['reporting_manager'];
		$reporting_manager_name = $record21['reporting_manager_name'];
		$division 				= $record21['division'];
		$deport 				= $record21['deport'];
		$add_date				= date("Y-m-d");
		
		$query="insert into transfer_request (employee,department,post,work_location,reporting_manager,reporting_manager_name,division,deport,add_date) values ('$employee','$department','$post','$work_location','$reporting_manager','$reporting_manager_name','$division','$deport','$add_date')";
		if ($db->insert($query)) {
			$query1="update employee set reporting_manager_name='$reporting_manager_name', division='$division', deport='$deport' where email='$employee'";
			$db->insert($query1);
			
			echo 'Success';
		}
	}
}

if(isset($_POST['add_promotion_data'])){
	$employee				= mysqli_real_escape_string($db->link, $_POST['employee']);
	$department				= mysqli_real_escape_string($db->link, $_POST['department']);
	$post					= mysqli_real_escape_string($db->link, $_POST['post']);
	$work_location			= mysqli_real_escape_string($db->link, $_POST['work_location']);
	$reporting_manager		= mysqli_real_escape_string($db->link, $_POST['reporting_manager']);
	$reporting_manager_name	= mysqli_real_escape_string($db->link, $_POST['reporting_manager_name']);
	
	if(isset($_POST['division'])){
		$division	= mysqli_real_escape_string($db->link, $_POST['division']);
	}else{
		$division	= '';
	}
	
	if(isset($_POST['deport'])){
		$deport	= mysqli_real_escape_string($db->link, $_POST['deport']);
	}else{
		$deport	= '';
	}
	
	$sql21 = "SELECT * FROM `employee` WHERE email = '".$employee."'";
	$exe21 = $db->select($sql21);
	if ($exe21->num_rows > 0) {
		$record21 = $exe21->fetch_array();
		
		$department 			= $record21['department'];
		$post 					= $record21['post'];
		$work_location 			= $record21['work_location'];
		$reporting_manager 		= $record21['reporting_manager'];
		$reporting_manager_name = $record21['reporting_manager_name'];
		$division 				= $record21['division'];
		$deport 				= $record21['deport'];
		$add_date				= date("Y-m-d");
		
		$query="insert into transfer_request (employee,department,post,work_location,reporting_manager,reporting_manager_name,division,deport,add_date) values ('$employee','$department','$post','$work_location','$reporting_manager','$reporting_manager_name','$division','$deport','$add_date')";
		if ($db->insert($query)) {
			$query1="update employee set department='$department', post='$post', work_location='$work_location', reporting_manager='$reporting_manager', reporting_manager_name='$reporting_manager_name', division='$division', deport='$deport' where email='$employee'";
			$db->insert($query1);
			
			echo 'Success';
		}
	}
}


if(isset($_POST['action20'])){
	if($_POST['action20']=='fetch_acr_employee'){
		$output = '<option value="">~~~Choose~~~</option>';
		if($_POST['office_name']==''){
			$query="select * from employee where post='".$_POST['query20']."'";
		}else{
			$query="select * from employee where post='".$_POST['query20']."' and office_name='".$_POST['office_name']."'";
		}
		
		$row=$db->select($query);
		while($record=$row->fetch_array()){
			$output .= '<option value="'.$record['employee_code'].'">'.$record['employee_name'].'</option>';
		}
		echo $output;
	}	
}

if(isset($_POST['action21_00'])){
	if($_POST['action21_00']=='fetch_authority_name'){
		$output = '<option value="">---</option>';
		if($_POST['acr_office_name']==''){
			$query="select * from employee where post='".$_POST['query21_00']."' and work_location='".$_POST['work_location']."'";
		}else{
			$query="select * from employee where post='".$_POST['query21_00']."' and work_location='".$_POST['work_location']."' and office_name='".$_POST['acr_office_name']."'";
		}
		$row=$db->select($query);
		while($record=$row->fetch_array()){
			$output .= '<option value="'.$record['employee_code'].'">'.$record['employee_name'].'</option>';
		}
		echo $output;
	}	
}


if(isset($_POST['action21'])){
	if($_POST['action21']=='fetch_acr_employee_data'){
		$output = '';
		
		$query="select * from employee where employee_code='".$_POST['query21']."'";
		$row=$db->select($query);
		$record=$row->fetch_array();
		
		$output .= '<div class="col-md-4 mb-3">
				<label class="form-label">Date of Birth</label>
				<input type="date" name="dob" value="'.$record['dob'].'" class="form-control">
			</div>
			
			<div class="col-md-4 mb-3">
				<label class="form-label">Presnt Pay Scale</label>
				<input type="text" name="present_pay_sacle" value="'.$record['grade_pay'].'" class="form-control">
			</div>
			
			<div class="col-md-4">
				<label class="form-label">Date of Appointment to the Present Post</label>
				<input type="date" name="present_post_appointment_date" value="'.$record['doj'].'" class="form-control">
			</div>';
		
		echo $output;
	}	
}


if(isset($_POST['add_acr'])){
	$year					= mysqli_real_escape_string($db->link, $_POST['year']);
	$work_location			= mysqli_real_escape_string($db->link, $_POST['work_location']);
	if(isset($_POST['office_name'])){
		$office_name		= mysqli_real_escape_string($db->link, $_POST['office_name']);
	}else{
		$office_name		= '';
	}
	$present_post					= mysqli_real_escape_string($db->link, $_POST['present_post']);
	
	$reporting_authority_work_location		= mysqli_real_escape_string($db->link, $_POST['reporting_authority_work_location']);
	$reviewing_authority_work_location		= mysqli_real_escape_string($db->link, $_POST['reviewing_authority_work_location']);
	$accepting_authority_work_location		= mysqli_real_escape_string($db->link, $_POST['accepting_authority_work_location']);
	
	if(isset($_POST['reporting_office_name'])){
		$reporting_office_name		= mysqli_real_escape_string($db->link, $_POST['reporting_office_name']);
	}else{
		$reporting_office_name		= '';
	}
	
	if(isset($_POST['reviewing_office_name'])){
		$reviewing_office_name		= mysqli_real_escape_string($db->link, $_POST['reviewing_office_name']);
	}else{
		$reviewing_office_name		= '';
	}
	
	if(isset($_POST['accepting_office_name'])){
		$accepting_office_name		= mysqli_real_escape_string($db->link, $_POST['accepting_office_name']);
	}else{
		$accepting_office_name		= '';
	}
	
	$reporting_authority_name		= mysqli_real_escape_string($db->link, $_POST['reporting_authority_name']);
	$reporting_authority_post		= mysqli_real_escape_string($db->link, $_POST['reporting_authority_post']);
	$reviewing_authority_name		= mysqli_real_escape_string($db->link, $_POST['reviewing_authority_name']);
	$reviewing_authority_post		= mysqli_real_escape_string($db->link, $_POST['reviewing_authority_post']);
	$accepting_authority_name		= mysqli_real_escape_string($db->link, $_POST['accepting_authority_name']);
	$accepting_authority_post		= mysqli_real_escape_string($db->link, $_POST['accepting_authority_post']);
	
	$date = date("Y-m-d");
	
	$sql21 = "SELECT * FROM `acr` WHERE present_post = '".$present_post."' and year='$year' and work_location='$work_location' and office_name='$office_name'";
	$exe21 = $db->select($sql21);
	if ($exe21->num_rows > 0) {
		echo 'Error';
	}else{
		$query="insert into acr (work_location,office_name,present_post,reporting_authority_name,reporting_authority_post,reviewing_authority_name,reviewing_authority_post,accepting_authority_name,accepting_authority_post,year,date,reporting_authority_work_location,reviewing_authority_work_location,accepting_authority_work_location,reporting_office_name,reviewing_office_name,accepting_office_name) values ('$work_location','$office_name','$present_post','$reporting_authority_name','$reporting_authority_post','$reviewing_authority_name','$reviewing_authority_post','$accepting_authority_name','$accepting_authority_post','$year','$date','$reporting_authority_work_location','$reviewing_authority_work_location','$accepting_authority_work_location','$reporting_office_name','$reviewing_office_name','$accepting_office_name')";
		if ($db->insert($query)) {
			echo 'Success';
		}else{
			echo 'Something Went Wrong!';
		}
	}
}

if(isset($_POST['update_acr'])){
	$id						= mysqli_real_escape_string($db->link, $_POST['id']);
	$year					= mysqli_real_escape_string($db->link, $_POST['year']);
	$work_location			= mysqli_real_escape_string($db->link, $_POST['work_location']);
	if(isset($_POST['office_name'])){
		$office_name		= mysqli_real_escape_string($db->link, $_POST['office_name']);
	}else{
		$office_name		= '';
	}
	$present_post					= mysqli_real_escape_string($db->link, $_POST['present_post']);
	
	$reporting_authority_work_location		= mysqli_real_escape_string($db->link, $_POST['reporting_authority_work_location']);
	$reviewing_authority_work_location		= mysqli_real_escape_string($db->link, $_POST['reviewing_authority_work_location']);
	$accepting_authority_work_location		= mysqli_real_escape_string($db->link, $_POST['accepting_authority_work_location']);
	
	if(isset($_POST['reporting_office_name'])){
		$reporting_office_name		= mysqli_real_escape_string($db->link, $_POST['reporting_office_name']);
	}else{
		$reporting_office_name		= '';
	}
	
	if(isset($_POST['reviewing_office_name'])){
		$reviewing_office_name		= mysqli_real_escape_string($db->link, $_POST['reviewing_office_name']);
	}else{
		$reviewing_office_name		= '';
	}
	
	if(isset($_POST['accepting_office_name'])){
		$accepting_office_name		= mysqli_real_escape_string($db->link, $_POST['accepting_office_name']);
	}else{
		$accepting_office_name		= '';
	}
	
	$reporting_authority_name		= mysqli_real_escape_string($db->link, $_POST['reporting_authority_name']);
	$reporting_authority_post		= mysqli_real_escape_string($db->link, $_POST['reporting_authority_post']);
	$reviewing_authority_name		= mysqli_real_escape_string($db->link, $_POST['reviewing_authority_name']);
	$reviewing_authority_post		= mysqli_real_escape_string($db->link, $_POST['reviewing_authority_post']);
	$accepting_authority_name		= mysqli_real_escape_string($db->link, $_POST['accepting_authority_name']);
	$accepting_authority_post		= mysqli_real_escape_string($db->link, $_POST['accepting_authority_post']);
	
	$date = date("Y-m-d");
	
	$sql21 = "SELECT * FROM `acr` WHERE present_post = '".$present_post."' and year='$year' and work_location='$work_location' and office_name='$office_name' and id!='$id'";
	$exe21 = $db->select($sql21);
	if ($exe21->num_rows > 0) {
		echo 'Error';
	}else{
		$query="update acr set work_location='$work_location',office_name='$office_name',present_post='$present_post',reporting_authority_name='$reporting_authority_name',reporting_authority_post='$reporting_authority_post',reviewing_authority_name='$reviewing_authority_name',reviewing_authority_post='$reviewing_authority_post',accepting_authority_name='$accepting_authority_name',accepting_authority_post='$accepting_authority_post',year='$year',date='$date',reporting_authority_work_location='$reporting_authority_work_location',reviewing_authority_work_location='$reviewing_authority_work_location',accepting_authority_work_location='$accepting_authority_work_location',reporting_office_name='$reporting_office_name',reviewing_office_name='$reviewing_office_name',accepting_office_name='$accepting_office_name' where id='$id'";
		if ($db->insert($query)) {
			echo 'Success1';
		}else{
			echo 'Something Went Wrong!';
		}
	}
}


if(isset($_POST['add_self_appraisal'])){
	$acr_id			= mysqli_real_escape_string($db->link, $_POST['acr_id']);
	$employee		= mysqli_real_escape_string($db->link, $_POST['employee']);
	$year			= mysqli_real_escape_string($db->link, $_POST['year']);
	$from_date		= mysqli_real_escape_string($db->link, $_POST['from_date']);
	$to_date		= mysqli_real_escape_string($db->link, $_POST['to_date']);
	$description	= mysqli_real_escape_string($db->link, $_POST['description']);
	
	$sql21 = "SELECT * FROM `self_appraisal` WHERE employee = '".$employee."' and year='$year'";
	$exe21 = $db->select($sql21);
	if ($exe21->num_rows > 0) {
		echo 'Error';
	}else{
		//$query="insert into self_appraisal (employee,year,from_date,to_date,description,filed_property_retun,filed_property_retun_date,medical_check_up,medical_check_up_date,enclosed_note,is_previous_years_acr_reason,previous_years_acr_reason) values ('$employee','$year','$from_date','$to_date','$description','$filed_property_retun','$filed_property_retun_date','$medical_check_up','$medical_check_up_date','$enclosed_note','$is_previous_years_acr_reason','$previous_years_acr_reason')";
		$query="insert into self_appraisal (acr_id,employee,year,from_date,to_date,description) values ('$acr_id','$employee','$year','$from_date','$to_date','$description')";
		if ($db->insert($query)) {
			$self_appraisal_id = $db->link->insert_id;
			
			if($_FILES["self_appraisal_copy"]["name"] != ''){
				$test = explode('.', $_FILES["self_appraisal_copy"]["name"]);
				$ext = end($test);
				$name = rand(10000000, 99999999) . '.' . $ext;
				$location = 'assets/images/award/' . $name;  
				if(move_uploaded_file($_FILES["self_appraisal_copy"]["tmp_name"], $location)){
					$query="update self_appraisal set self_appraisal_copy='$location' where id='$self_appraisal_id'";
					$db->insert($query);
				}
			}
			
			if($_FILES["award"]["name"] != ''){
				$test = explode('.', $_FILES["award"]["name"]);
				$ext = end($test);
				$name = rand(10000000, 99999999) . '.' . $ext;
				$location = 'assets/images/award/' . $name;  
				if(move_uploaded_file($_FILES["award"]["tmp_name"], $location)){
					$query="update self_appraisal set award='$location' where id='$self_appraisal_id'";
					$db->insert($query);
				}
			}
			
			$size = sizeof($_POST['period']);
			for($i=0; $i < $size; $i++){
				$period		= mysqli_real_escape_string($db->link, $_POST['period'][$i]);
				$alloted_responsibility		= mysqli_real_escape_string($db->link, $_POST['alloted_responsibility'][$i]);
				
				if($period!='' && $alloted_responsibility!=''){
					$query1="insert into summary_responsibilities_alloted (self_appraisal_id,period,alloted_responsibility) values ('$self_appraisal_id','$period','$alloted_responsibility')";
					$db->insert($query1);
				}
			}
			
			$size1 = sizeof($_POST['task_to_be_performed']);
			for($j=0; $j < $size1; $j++){
				$task_to_be_performed	= mysqli_real_escape_string($db->link, $_POST['task_to_be_performed'][$j]);
				//$target					= mysqli_real_escape_string($db->link, $_POST['target'][$j]);
				$actual_achievement		= mysqli_real_escape_string($db->link, $_POST['actual_achievement'][$j]);
				
				$query1="insert into annual_work_plan (self_appraisal_id,task_to_be_performed,actual_achievement) values ('$self_appraisal_id','$task_to_be_performed','$actual_achievement')";
				$db->insert($query1);
			}
			echo 'Success';
		}else{
			echo 'Something Went Wrong!';
		}
	}
}

if(isset($_POST['add_self_appraisal1'])){
	$acr_id			= mysqli_real_escape_string($db->link, $_POST['acr_id']);
	$employee		= mysqli_real_escape_string($db->link, $_POST['employee']);
	$year			= mysqli_real_escape_string($db->link, $_POST['year']);
	$from_date		= mysqli_real_escape_string($db->link, $_POST['from_date']);
	$to_date		= mysqli_real_escape_string($db->link, $_POST['to_date']);
	$marg			= mysqli_real_escape_string($db->link, $_POST['marg']);
	
	$sql21 = "SELECT * FROM `self_appraisal` WHERE employee = '".$employee."' and year='$year'";
	$exe21 = $db->select($sql21);
	if ($exe21->num_rows > 0) {
		echo 'Error';
	}else{
		//$query="insert into self_appraisal (employee,year,from_date,to_date,description,filed_property_retun,filed_property_retun_date,medical_check_up,medical_check_up_date,enclosed_note,is_previous_years_acr_reason,previous_years_acr_reason) values ('$employee','$year','$from_date','$to_date','$description','$filed_property_retun','$filed_property_retun_date','$medical_check_up','$medical_check_up_date','$enclosed_note','$is_previous_years_acr_reason','$previous_years_acr_reason')";
		$query="insert into self_appraisal (acr_id,employee,year,from_date,to_date,marg) values ('$acr_id','$employee','$year','$from_date','$to_date','$marg')";
		if ($db->insert($query)) {
			$self_appraisal_id = $db->link->insert_id;
			
			if($_FILES["award"]["name"] != ''){
				$test = explode('.', $_FILES["award"]["name"]);
				$ext = end($test);
				$name = rand(10000000, 99999999) . '.' . $ext;
				$location = 'assets/images/award/' . $name;  
				if(move_uploaded_file($_FILES["award"]["tmp_name"], $location)){
					$query="update self_appraisal set award='$location' where id='$self_appraisal_id'";
					$db->insert($query);
				}
			}
			
			$size1 = sizeof($_POST['task_to_be_performed']);
			for($j=0; $j < $size1; $j++){
				$task_to_be_performed	= mysqli_real_escape_string($db->link, $_POST['task_to_be_performed'][$j]);
				$actual_achievement		= mysqli_real_escape_string($db->link, $_POST['actual_achievement'][$j]);
				
				$query1="insert into annual_work_plan (self_appraisal_id,task_to_be_performed,actual_achievement) values ('$self_appraisal_id','$task_to_be_performed','$actual_achievement')";
				$db->insert($query1);
			}
			
			echo $self_appraisal_id;
		}else{
			echo 'Error1';
		}
	}
}

if(isset($_POST['add_self_appraisal2'])){
	$acr_id			= mysqli_real_escape_string($db->link, $_POST['acr_id']);
	$employee		= mysqli_real_escape_string($db->link, $_POST['employee']);
	$year			= mysqli_real_escape_string($db->link, $_POST['year']);
	$from_date		= mysqli_real_escape_string($db->link, $_POST['from_date']);
	$to_date		= mysqli_real_escape_string($db->link, $_POST['to_date']);
	
	$sql21 = "SELECT * FROM `self_appraisal` WHERE employee = '".$employee."' and year='$year'";
	$exe21 = $db->select($sql21);
	if ($exe21->num_rows > 0) {
		echo 'Error';
	}else{
		//$query="insert into self_appraisal (employee,year,from_date,to_date,description,filed_property_retun,filed_property_retun_date,medical_check_up,medical_check_up_date,enclosed_note,is_previous_years_acr_reason,previous_years_acr_reason) values ('$employee','$year','$from_date','$to_date','$description','$filed_property_retun','$filed_property_retun_date','$medical_check_up','$medical_check_up_date','$enclosed_note','$is_previous_years_acr_reason','$previous_years_acr_reason')";
		$query="insert into self_appraisal (acr_id,employee,year,from_date,to_date) values ('$acr_id','$employee','$year','$from_date','$to_date')";
		if ($db->insert($query)) {
			$self_appraisal_id = $db->link->insert_id;
			
			if($_FILES["award"]["name"] != ''){
				$test = explode('.', $_FILES["award"]["name"]);
				$ext = end($test);
				$name = rand(10000000, 99999999) . '.' . $ext;
				$location = 'assets/images/award/' . $name;  
				if(move_uploaded_file($_FILES["award"]["tmp_name"], $location)){
					$query="update self_appraisal set award='$location' where id='$self_appraisal_id'";
					$db->insert($query);
				}
			}
			
			$size1 = sizeof($_POST['task_to_be_performed']);
			for($j=0; $j < $size1; $j++){
				$task_to_be_performed	= mysqli_real_escape_string($db->link, $_POST['task_to_be_performed'][$j]);
				$actual_achievement		= mysqli_real_escape_string($db->link, $_POST['actual_achievement'][$j]);
				
				$query1="insert into annual_work_plan (self_appraisal_id,task_to_be_performed,actual_achievement) values ('$self_appraisal_id','$task_to_be_performed','$actual_achievement')";
				$db->insert($query1);
			}
			
			echo 'Success';
		}else{
			echo 'Something Went Wrong!';
		}
	}
}


if(isset($_POST['add_employee_appraisal'])){
	$self_appraisal_id	= mysqli_real_escape_string($db->link, $_POST['self_appraisal_id']);
	$employee		= mysqli_real_escape_string($db->link, $_POST['employee']);
	$year			= mysqli_real_escape_string($db->link, $_POST['year']);
	$pen_picture	= mysqli_real_escape_string($db->link, $_POST['pen_picture']);
	$integrity		= mysqli_real_escape_string($db->link, $_POST['integrity']);
	$overall_grade	= mysqli_real_escape_string($db->link, $_POST['overall_grade']);
	$shreni			= mysqli_real_escape_string($db->link, $_POST['shreni']);
	$created_by		= $_SESSION['astro_email'];
	$created_date	= date("Y-m-d");
	
	$sql21 = "SELECT * FROM `employee_appraisal` WHERE employee = '".$employee."' and year='$year' and self_appraisal_id='$self_appraisal_id'";
	$exe21 = $db->select($sql21);
	if ($exe21->num_rows > 0) {
		echo 'Error';
	}else{
		$query="insert into employee_appraisal (self_appraisal_id,employee,year,pen_picture,integrity,overall_grade,created_by,created_date,shreni) values ('$self_appraisal_id','$employee','$year','$pen_picture','$integrity','$overall_grade','$created_by','$created_date','$shreni')";
		if ($db->insert($query)) {
			$employee_appraisal_id = $db->link->insert_id;
			
			$size = sizeof($_POST['personal_attribute']);
			for($i=0; $i < $size; $i++){
				$personal_attribute	= mysqli_real_escape_string($db->link, $_POST['personal_attribute'][$i]);
				$grade				= mysqli_real_escape_string($db->link, $_POST['grade'][$i]);
				
				$query1="insert into assestment_of_personal_attributes_data (employee_appraisal_id,assestment_of_personal_attributes_id,employee,grade) values ('$employee_appraisal_id','$personal_attribute','$employee','$grade')";
				$db->insert($query1);
			}
			echo $employee_appraisal_id;
		}else{
			echo 'Error1';
		}
	}
}

if(isset($_POST['add_employee_appraisal1'])){
	$self_appraisal_id	= mysqli_real_escape_string($db->link, $_POST['self_appraisal_id']);
	$employee		= mysqli_real_escape_string($db->link, $_POST['employee']);
	$year			= mysqli_real_escape_string($db->link, $_POST['year']);
	$integrity		= mysqli_real_escape_string($db->link, $_POST['integrity']);
	$overall_grade	= mysqli_real_escape_string($db->link, $_POST['overall_grade']);
	$shreni			= mysqli_real_escape_string($db->link, $_POST['shreni']);
	$pen_picture	= mysqli_real_escape_string($db->link, $_POST['pen_picture']);
	$created_by		= $_SESSION['astro_email'];
	$created_date	= date("Y-m-d h:i:s A");
	
	$sql21 = "SELECT * FROM `employee_appraisal` WHERE employee = '".$employee."' and year='$year' and self_appraisal_id='$self_appraisal_id'";
	$exe21 = $db->select($sql21);
	if ($exe21->num_rows > 0) {
		echo 'Error';
	}else{
		$query="insert into employee_appraisal (self_appraisal_id,employee,year,integrity,overall_grade,created_by,created_date,shreni,pen_picture) values ('$self_appraisal_id','$employee','$year','$integrity','$overall_grade','$created_by','$created_date','$shreni','$pen_picture')";
		if ($db->insert($query)) {
			$employee_appraisal_id = $db->link->insert_id;
			
			$size = sizeof($_POST['annual_work_plan_id']);
			for($i=0; $i < $size; $i++){
				$annual_work_plan_id	= mysqli_real_escape_string($db->link, $_POST['annual_work_plan_id'][$i]);
				$grade				= mysqli_real_escape_string($db->link, $_POST['grade'][$i]);
				
				if($annual_work_plan_id=='Behaviour'){
					$query1="insert into annual_work_plan (self_appraisal_id,task_to_be_performed,grade) values ('$self_appraisal_id','$annual_work_plan_id','$grade')";
					$db->insert($query1);
				}else{
					$query1="update annual_work_plan set grade='$grade' where id='$annual_work_plan_id'";
					$db->insert($query1);
				}
			}
			echo $employee_appraisal_id;
		}else{
			echo 'Error1';
		}
	}
}


if(isset($_POST['add_acr_review'])){
	$employee_appraisal_id	= mysqli_real_escape_string($db->link, $_POST['employee_appraisal_id']);
	$employee				= mysqli_real_escape_string($db->link, $_POST['employee']);
	$agree_with_assestment	= mysqli_real_escape_string($db->link, $_POST['agree_with_assestment']);
	
	if($agree_with_assestment=='Yes'){
		$query4="select * from employee_appraisal where id='".$employee_appraisal_id."'";
		$row4=$db->select($query4);
		$record4=$row4->fetch_array();
		$overall_grade = $record4['overall_grade'];
		$shreni = $record4['shreni'];
		$diffrent_openion		= '';
		$additional_comment		= '';
	}else{
		if(isset($_POST['diffrent_openion'])){
			$diffrent_openion		= mysqli_real_escape_string($db->link, $_POST['diffrent_openion']);
		}else{
			$diffrent_openion		= '';
		}
		
		if(isset($_POST['overall_grade'])){
			$overall_grade		= mysqli_real_escape_string($db->link, $_POST['overall_grade']);
		}else{
			$overall_grade		= '';
		}
		
		if(isset($_POST['shreni'])){
			$shreni		= mysqli_real_escape_string($db->link, $_POST['shreni']);
		}else{
			$shreni		= '';
		}
	}
	$created_by				= $_SESSION['astro_email'];
	$created_date			= date("Y-m-d h:i:s A");
	
	$sql21 = "SELECT * FROM `review_appraisal` WHERE employee = '".$employee."' and employee_appraisal_id='$employee_appraisal_id'";
	$exe21 = $db->select($sql21);
	if ($exe21->num_rows > 0) {
		echo 'Error';
	}else{
		$query="insert into review_appraisal (employee_appraisal_id,employee,agree_with_assestment,diffrent_openion,overall_grade,created_by,created_date,shreni) values ('$employee_appraisal_id','$employee','$agree_with_assestment','$diffrent_openion','$overall_grade','$created_by','$created_date','$shreni')";
		if ($db->insert($query)) {
			$id = $db->link->insert_id;
			echo $id;
		}else{
			echo 'Error1';
		}
	}
}


if(isset($_POST['add_acr_acceptance'])){
	$review_appraisal_id	= mysqli_real_escape_string($db->link, $_POST['review_appraisal_id']);
	$employee				= mysqli_real_escape_string($db->link, $_POST['employee']);
	$agree_with_remark		= mysqli_real_escape_string($db->link, $_POST['agree_with_remark']);
	
	if($agree_with_remark=='Yes'){
		$query4="select * from review_appraisal where id='".$review_appraisal_id."'";
		$row4=$db->select($query4);
		$record4=$row4->fetch_array();
		$overall_grade = $record4['overall_grade'];
		$shreni = $record4['shreni'];
		$diffrent_openion		= '';
		$additional_comment		= '';
	}else{
		if(isset($_POST['diffrent_openion'])){
			$diffrent_openion		= mysqli_real_escape_string($db->link, $_POST['diffrent_openion']);
		}else{
			$diffrent_openion		= '';
		}
		
		if(isset($_POST['additional_comment'])){
			$additional_comment		= mysqli_real_escape_string($db->link, $_POST['additional_comment']);
		}else{
			$additional_comment		= '';
		}
		
		if(isset($_POST['overall_grade'])){
			$overall_grade		= mysqli_real_escape_string($db->link, $_POST['overall_grade']);
		}else{
			$overall_grade		= '';
		}
		
		if(isset($_POST['shreni'])){
			$shreni		= mysqli_real_escape_string($db->link, $_POST['shreni']);
		}else{
			$shreni		= '';
		}
	}
	$created_by				= $_SESSION['astro_email'];
	$created_date			= date("Y-m-d h:i:s A");
	
	$sql21 = "SELECT * FROM `acceptance_appraisal` WHERE employee = '".$employee."' and review_appraisal_id='$review_appraisal_id'";
	$exe21 = $db->select($sql21);
	if ($exe21->num_rows > 0) {
		echo 'Error';
	}else{
		$query="insert into acceptance_appraisal (review_appraisal_id,employee,agree_with_remark,diffrent_openion,additional_comment,overall_grade,created_by,created_date,shreni) values ('$review_appraisal_id','$employee','$agree_with_remark','$diffrent_openion','$additional_comment','$overall_grade','$created_by','$created_date','$shreni')";
		if ($db->insert($query)) {
			$id = $db->link->insert_id;
			
			$query="select review_appraisal_id from acceptance_appraisal where id='".$id."'";
			$row=$db->select($query);
			$record=$row->fetch_array();
			
			$query1="select employee_appraisal_id from review_appraisal where id='".$record['review_appraisal_id']."'";
			$row1=$db->select($query1);
			$record1=$row1->fetch_array();
			
			$query2="select self_appraisal_id from employee_appraisal where id='".$record1['employee_appraisal_id']."'";
			$row2=$db->select($query2);
			$record2=$row2->fetch_array();
			
			echo $record2['self_appraisal_id'];
		}else{
			echo 'Error1';
		}
	}
}




if(isset($_POST['action_map'])){
	if($_POST['action_map']=='fetch_attendance_map'){
		$sql21 = "SELECT * FROM `attendance` WHERE id = '".$_POST['query_map']."'";
		$exe21 = $db->select($sql21);
		$record = $exe21->fetch_array();
		
		$check_in_lat = $record['check_in_lat'];
		$check_in_lng = $record['check_in_lng'];
		
		$check_out_lat = $record['check_out_lat'];
		$check_out_lng = $record['check_out_lng'];
		
		
		$output = '';
		$output .= '
			<div class="col-md-6">
				<label>Check-In</label>
				<iframe src = "https://maps.google.com/maps?q='.$check_in_lat.','.$check_in_lng.'&hl=es;z=14&amp;output=embed" style="width:100%;height:400px"></iframe>
			</div>
			<div class="col-md-6">
				<label>Check-Out</label>
				<iframe src = "https://maps.google.com/maps?q='.$check_out_lat.','.$check_out_lng.'&hl=es;z=14&amp;output=embed" style="width:100%;height:400px"></iframe>
			</div>
		';
		echo $output;
	}
}

if(isset($_POST['action_from_date'])){
	if($_POST['action_from_date']=='fetch_to_date'){
		$output ='';
		
		$min_date=$_POST['query_from_date'];
		$today = date("Y-m-d");
		
		$date1=date_create($min_date);
		$date2=date_create($today);
		$diff=date_diff($date1,$date2);
		$no_of_days = $diff->format("%a");
		
		if($no_of_days > 30){
			$max_date = date('Y-m-d', strtotime('+30 days', strtotime($min_date)));
		}else{
			$max_date=$today;
		}
		
		$output .='<label>To Date</label>
			<input type="date" name="to_date" value="'.$max_date.'" id="to_date" class="form-control" min="'.$min_date.'" max="'.$max_date.'">';
			
		echo $output;
	}
}

if(isset($_POST['action_work_location'])){
	if($_POST['action_work_location']=='fetch_work_location_name'){
		$output ='';
		
		$output .='<div class="row">';
			if($_POST['query_work_location']=='Division'){
				$output .='<div class="col-md-4 mb-2">
				<label>Division Name</label>
				<select name="office_name" id="office_name" class="form-control">';
				$output .= '<option value="">~~~Choose~~~</option>';
				$query="select * from division";
				$row=$db->select($query);
				while($record=$row->fetch_array()){
					$output .= '<option value="'.$record['id'].'">'.$record['division'].'</option>';
				}
				$output .='</select>
				</div>
				<div class="col-md-4 mb-2">
					<br />
					<input type="hidden" id="search_monthly_attendance_status" value="search_monthly_attendance_status">
					<a id="search_button" onclick="action_montly_print()" class="btn btn-success">Search</a>
				</div>';
			}else if($_POST['query_work_location']=='Depot'){
				$output .='<div class="col-md-4 mb-2">
				<label>Depot</label>
				<select name="office_name" id="office_name" class="form-control">';
				$output .= '<option value="">~~~Choose~~~</option>';
				$query="select * from deport";
				$row=$db->select($query);
				while($record=$row->fetch_array()){
					$output .= '<option value="'.$record['id'].'">'.$record['deport'].'</option>';
				}
				$output .='</select>
				</div>
				<div class="col-md-4 mb-2">
					<br />
					<input type="hidden" id="search_monthly_attendance_status" value="search_monthly_attendance_status">
					<a id="search_button" onclick="action_montly_print()" class="btn btn-success">Search</a>
				</div>';
			}else{
				$output .='<div class="col-md-4 mb-2">
						<br />
						<input type="hidden" id="search_monthly_attendance_status" value="search_monthly_attendance_status">
						<a id="search_button" onclick="action_montly_print()" class="btn btn-success">Search</a>
					</div>';
			}
			$output .='</div>';
		echo $output;
	}
	
	if($_POST['action_work_location']=='fetch_work_location_name1'){
		$output ='';
		
		$output .='<div class="row">';
			if($_POST['query_work_location']=='Division'){
				$output .='<div class="col-md-4 mb-2">
				<label>Division Name</label>
				<select name="office_name" id="office_name" class="form-control">';
				$output .= '<option value="">~~~Choose~~~</option>';
				$query="select * from division";
				$row=$db->select($query);
				while($record=$row->fetch_array()){
					$output .= '<option value="'.$record['id'].'">'.$record['division'].'</option>';
				}
				$output .='</select>
				</div>
				<div class="col-md-4 mb-2">
					<br />
					<input type="hidden" id="search_today_attendance_status" value="search_today_attendance_status">
					<a id="search_button" onclick="action_montly_print()" class="btn btn-success">Search</a>
				</div>';
			}else if($_POST['query_work_location']=='Depot'){
				$output .='<div class="col-md-4 mb-2">
				<label>Depot</label>
				<select name="office_name" id="office_name" class="form-control">';
				$output .= '<option value="">~~~Choose~~~</option>';
				$query="select * from deport";
				$row=$db->select($query);
				while($record=$row->fetch_array()){
					$output .= '<option value="'.$record['id'].'">'.$record['deport'].'</option>';
				}
				$output .='</select>
				</div>
				<div class="col-md-4 mb-2">
					<br />
					<input type="hidden" id="search_today_attendance_status" value="search_today_attendance_status">
					<a id="search_button" onclick="action_montly_print()" class="btn btn-success">Search</a>
				</div>';
			}else{
				$output .='<div class="col-md-4 mb-2">
						<br />
						<input type="hidden" id="search_today_attendance_status" value="search_today_attendance_status">
						<a id="search_button" onclick="action_montly_print()" class="btn btn-success">Search</a>
					</div>';
			}
			$output .='</div>';
		echo $output;
	}
	
	
	
}

if(isset($_POST['action_work_location_view_post'])){
	$output ='';
	if($_POST['action_work_location_view_post']=='fetch_work_location_name'){
		$output .='<div class="row">';
			if($_POST['query_work_location']=='Division'){
				$output .='<div class="col-md-6 mb-2">
				<label>College Name</label>
				<select name="office_name" id="office_name" class="form-control">';
				$output .= '<option value="">~~~Choose~~~</option>';
				$query="select * from division";
				$row=$db->select($query);
				while($record=$row->fetch_array()){
					$output .= '<option value="'.$record['id'].'">'.$record['division'].'</option>';
				}
				$output .='</select>
				</div>
				<div class="col-md-6 mb-2">
					<br />
					<input type="hidden" name="search_employee" value="search_employee">
					<button type="submit" id="search_button" class="btn btn-success">Search</button>
				</div>';
			}else if($_POST['query_work_location']=='Depot'){
				$output .='<div class="col-md-6 mb-2">
				<label>Depot</label>
				<select name="office_name" id="office_name" class="form-control">';
				$output .= '<option value="">~~~Choose~~~</option>';
				$query="select * from deport";
				$row=$db->select($query);
				while($record=$row->fetch_array()){
					$output .= '<option value="'.$record['id'].'">'.$record['deport'].'</option>';
				}
				$output .='</select>
				</div>
				<div class="col-md-6 mb-2">
					<br />
					<input type="hidden" name="search_employee" value="search_employee">
					<button type="submit" id="search_button" class="btn btn-success">Search</button>
				</div>';
			}else{
				$output .='<div class="col-md-12 mb-2">
						<br />
						<input type="hidden" name="search_employee" value="search_employee">
						<button type="submit" id="search_button" class="btn btn-success">Search</button>
					</div>';
			}
			$output .='</div>';
	}
	
	if($_POST['action_work_location_view_post']=='fetch_work_location_name2'){
		$output .='<div class="row">';
			if($_POST['query_work_location']=='Division'){
				$output .='<div class="col-md-6 mb-2">
				<label>College Name</label>
				<select name="office_name" id="office_name" class="form-control">';
				$output .= '<option value="">~~~Choose~~~</option>';
				$query="select * from division";
				$row=$db->select($query);
				while($record=$row->fetch_array()){
					$output .= '<option value="'.$record['id'].'">'.$record['division'].'</option>';
				}
				$output .='</select>
				</div>
				<div class="col-md-6 mb-2">
					<br />
					<input type="hidden" name="search_acr_report" value="search_acr_report">
					<button type="submit" id="search_button" class="btn btn-success">Search</button>
				</div>';
			}else if($_POST['query_work_location']=='Depot'){
				$output .='<div class="col-md-6 mb-2">
				<label>Depot</label>
				<select name="office_name" id="office_name" class="form-control">';
				$output .= '<option value="">~~~Choose~~~</option>';
				$query="select * from deport";
				$row=$db->select($query);
				while($record=$row->fetch_array()){
					$output .= '<option value="'.$record['id'].'">'.$record['deport'].'</option>';
				}
				$output .='</select>
				</div>
				<div class="col-md-6 mb-2">
					<br />
					<input type="hidden" name="search_acr_report" value="search_acr_report">
					<button type="submit" id="search_button" class="btn btn-success">Search</button>
				</div>';
			}else{
				$output .='<div class="col-md-12 mb-2">
						<br />
						<input type="hidden" name="search_acr_report" value="search_acr_report">
						<button type="submit" id="search_button" class="btn btn-success">Search</button>
					</div>';
			}
			$output .='</div>';
	}
	
	
	if($_POST['action_work_location_view_post']=='fetch_work_location_name3'){
		$output .='<div class="row">';
			if($_POST['query_work_location']=='Division'){
				$output .='<div class="col-md-6 mb-2">
				<label>College Name</label>
				<select name="office_name" id="office_name" class="form-control">';
				$output .= '<option value="">~~~Choose~~~</option>';
				$query="select * from division";
				$row=$db->select($query);
				while($record=$row->fetch_array()){
					$output .= '<option value="'.$record['id'].'">'.$record['division'].'</option>';
				}
				$output .='</select>
				</div>
				<div class="col-md-6 mb-2">
					<br />
					<input type="hidden" name="search_acr_data" value="search_acr_report">
					<button type="submit" id="search_button" class="btn btn-success">Search</button>
				</div>';
			}else if($_POST['query_work_location']=='Depot'){
				$output .='<div class="col-md-6 mb-2">
				<label>Depot</label>
				<select name="office_name" id="office_name" class="form-control">';
				$output .= '<option value="">~~~Choose~~~</option>';
				$query="select * from deport";
				$row=$db->select($query);
				while($record=$row->fetch_array()){
					$output .= '<option value="'.$record['id'].'">'.$record['deport'].'</option>';
				}
				$output .='</select>
				</div>
				<div class="col-md-6 mb-2">
					<br />
					<input type="hidden" name="search_acr_data" value="search_acr_data">
					<button type="submit" id="search_button" class="btn btn-success">Search</button>
				</div>';
			}else{
				$output .='<div class="col-md-12 mb-2">
						<br />
						<input type="hidden" name="search_acr_data" value="search_acr_data">
						<button type="submit" id="search_button" class="btn btn-success">Search</button>
					</div>';
			}
			$output .='</div>';
	}
	
	
	
	echo $output;
}

if(isset($_POST['search_monthly_attendance_status'])){
	$from_date		= mysqli_real_escape_string($db->link, $_POST['from_date']);
	$to_date		= mysqli_real_escape_string($db->link, $_POST['to_date']);
	$work_location	= mysqli_real_escape_string($db->link, $_POST['work_location']);
	
	$output = '';
	
	if($work_location=='Division' || $work_location=='Depot'){
		if($_POST['office_name']!=''){
			$output .='<div class="table-responsive">
				<table class="table table-sm mb-0">
					<thead>
						<tr class="bg-primary text-white">
							<th>#</th>
							<th>Employee Code</th>
							<th>Employee Phone</th>
							<th>Employee Name</th>
							';
							for($i=$to_date; $i >= $from_date; ($i = date('Y-m-d', strtotime('-1 days', strtotime($i))))){
								$query4 = "SELECT * FROM `holiday` where date='".$i."'";
								$row4 = $db->select($query4);
								if ($row4->num_rows > 0) {
									$output .='<th class="bg-success">H</th>';
								}else{
									$output .='<th>'.date("d M",strtotime($i)).'</th>';
								}
							}
				$output .='</tr>
					</thead>
					<tbody>';
			$z=1;
			$query = "SELECT * FROM `employee` where work_location='".$_POST['work_location']."' and office_name='".$_POST['office_name']."'";
			$row = $db->select($query);
			if ($row->num_rows > 0) {
				while($record = $row->fetch_array()){
					
					$query1 = "SELECT * FROM `post` where id='".$record['post']."'";
					$row1 = $db->select($query1);
					$record1 = $row1->fetch_array();
					
					$output .='<tr>
							<td>'.$z.'</td>
							<td>'.$record['employee_code'].'</td>
							<td>'.$record['phone'].'</td>
							<td>'.$record['employee_name'].'</td>';
							for($i=$to_date; $i >= $from_date; ($i = date('Y-m-d', strtotime('-1 days', strtotime($i))))){
								
								$query2 = "SELECT * FROM `attendance` where employee='".$record['phone']."' and attendance_date='".$i."'";
								$row2 = $db->select($query2);
								if ($row2->num_rows > 0) {
									$record2 = $row2->fetch_array();
									
									if($record2['check_out']==NULL){
										$status = '<td class="bg-warning text-white font-weight-bold">PE</td>';
									}else{
										$status = '<td class="bg-success text-white font-weight-bold">P</td>';
									}
								}else{
									$query3 = "SELECT * FROM `leave_request` where from_date<='".$i."' and to_date>='".$i."' and employee='".$record['phone']."' and is_approved='1'";
									$row3 = $db->select($query3);
									if ($row3->num_rows > 0) {
										$status = '<td class="bg-primary text-white font-weight-bold">L</td>';
									}else{
										$status = '<td class="bg-danger text-white font-weight-bold">A</td>';
									}
								}
								
								if(strtoupper(date('D',strtotime($i)))==$record['weekly_rest']){
									$output .='<td class="bg-warning text-white">W-OFF</td>';
								}else{
									
									$query4 = "SELECT * FROM `holiday` where date='".$i."'";
									$row4 = $db->select($query4);
									if ($row4->num_rows > 0) {
										$output .='<td class="bg-success text-white">--</td>';
									}else{
										$output .=$status;
									}
								}
							}
					$output .='</tr>';
					$z++;
				}
					$output .='<tr>
							<td><button onclick="action_montly_print1()">Export</button></td>
						</tr>';
			}else{
				$output .='<tr>
							<td colspan="3">Data Not Found</td>
						</tr>';
			}
			$output .='</tbody></table></div>';
		}else{
			$output .= 'Error';
		}
	}else{
		$output .='<div class="table-responsive">
			<table class="table table-sm mb-0">
				<thead>
					<tr class="bg-primary text-white">
						<th>#</th>
						<th>Employee Code</th>
						<th>Employee Name</th>
						';
						for($i=$to_date; $i >= $from_date; ($i = date('Y-m-d', strtotime('-1 days', strtotime($i))))){
							$query4 = "SELECT * FROM `holiday` where date='".$i."'";
							$row4 = $db->select($query4);
							if ($row4->num_rows > 0) {
								$output .='<th class="bg-success">H</th>';
							}else{
								$output .='<th>'.date("d M",strtotime($i)).'</th>';
							}
						}
				$output .='</tr>
				</thead>
				<tbody>';
		$z=1;
		$query = "SELECT * FROM `employee` where work_location='".$_POST['work_location']."'";
		$row = $db->select($query);
		if ($row->num_rows > 0) {
			while($record = $row->fetch_array()){
				
				$query1 = "SELECT * FROM `post` where id='".$record['post']."'";
				$row1 = $db->select($query1);
				$record1 = $row1->fetch_array();
				
				$output .='<tr>
						<td>'.$z.'</td>
						<td>'.$record['employee_code'].'</td>
						<td>'.$record['employee_name'].'</td>';
						for($i=$to_date; $i >= $from_date; ($i = date('Y-m-d', strtotime('-1 days', strtotime($i))))){
							
							$query2 = "SELECT * FROM `attendance` where employee='".$record['phone']."' and attendance_date='".$i."'";
							$row2 = $db->select($query2);
							if ($row2->num_rows > 0) {
								$record2 = $row2->fetch_array();
								
								if($record2['check_out']==NULL){
									$status = '<td class="bg-warning text-white font-weight-bold">PE</td>';
								}else{
									$status = '<td class="bg-success text-white font-weight-bold">P</td>';
								}
							}else{
								$query3 = "SELECT * FROM `leave_request` where from_date<='".$i."' and to_date>='".$i."' and employee='".$record['phone']."' and is_approved='1'";
								$row3 = $db->select($query3);
								if ($row3->num_rows > 0) {
									$status = '<td class="bg-primary text-white font-weight-bold">L</td>';
								}else{
									$status = '<td class="bg-danger text-white font-weight-bold">A</td>';
								}
							}
							
							if(strtoupper(date('D',strtotime($i)))==$record['weekly_rest']){
								$output .='<td class="bg-warning text-white">W-OFF</td>';
							}else{
								
								$query4 = "SELECT * FROM `holiday` where date='".$i."'";
								$row4 = $db->select($query4);
								if ($row4->num_rows > 0) {
									$output .='<td class="bg-success text-white">--</td>';
								}else{
									$output .=$status;
								}
							}
						}
				$output .='</tr>';
				$z++;
			}
			$output .='<tr>
						<td><button onclick="action_montly_print1()">Export</button></td>';
						
			$output .='</tr>';
		}else{
			$output .='<tr>
						<td colspan="3">Data Not Found</td>
					</tr>';
		}
		$output .='</tbody></table></div>';
	}
	
	
	echo $output;
}
	
if(isset($_POST['add_transfer'])){
	$transfer_by				= $_SESSION['astro_email'];
	$relieving_date				= mysqli_real_escape_string($db->link, $_POST['relieving_date']);
	$employee					= mysqli_real_escape_string($db->link, $_POST['employee']);
	$work_location				= mysqli_real_escape_string($db->link, $_POST['work_location']);
	if(isset($_POST['office_name'])){
		$office_name			= mysqli_real_escape_string($db->link, $_POST['office_name']);
	}else{
		$office_name			= '';
	}
	
	$query2 = "SELECT * FROM `employee` where employee_code='".$employee."'";
	$row2 = $db->select($query2);
	$record2 = $row2->fetch_array();
	
	$post					= $record2['post'];
	$reporting_manager		= $record2['reporting_manager'];
	$reporting_manager_name	= $record2['reporting_manager_name'];
	$appointment_officer		= $record2['appointment_officer'];
	$appointment_officer_name	= $record2['appointment_officer_name'];
	
	$to_work_location			= mysqli_real_escape_string($db->link, $_POST['to_work_location']);
	if(isset($_POST['to_office_name'])){
		$to_office_name			= mysqli_real_escape_string($db->link, $_POST['to_office_name']);
	}else{
		$to_office_name			= '';
	}
	
	$to_appointment_officer		= mysqli_real_escape_string($db->link, $_POST['to_appointment_officer']);
	$to_appointment_officer_name= mysqli_real_escape_string($db->link, $_POST['to_appointment_officer_name']);
	
	$qry = "INSERT INTO `transfer_request` (`relieving_date`, `employee`, `work_location`, `office_name`, `post`, `reporting_manager`, `reporting_manager_name`, `appointment_officer`, `appointment_officer_name`, `to_work_location`, `to_office_name`, `to_appointment_officer`, `to_appointment_officer_name`, `transfer_by`) VALUES ('$relieving_date', '$employee', '$work_location', '$office_name', '$post', '$reporting_manager', '$reporting_manager_name', '$appointment_officer', '$appointment_officer_name', '$to_work_location', '$to_office_name', '$to_appointment_officer', '$to_appointment_officer_name', '$transfer_by')";
	if ($db->insert($qry)) {
		echo "Success";
	}else{
		echo "Something went wrong!";
	}
}

if(isset($_POST['add_promotion'])){
	$transfer_by				= $_SESSION['astro_email'];
	$relieving_date				= mysqli_real_escape_string($db->link, $_POST['relieving_date']);
	$employee					= mysqli_real_escape_string($db->link, $_POST['employee']);
	$work_location				= mysqli_real_escape_string($db->link, $_POST['work_location']);
	if(isset($_POST['office_name'])){
		$office_name			= mysqli_real_escape_string($db->link, $_POST['office_name']);
	}else{
		$office_name			= '';
	}
	
	$query2 = "SELECT * FROM `employee` where employee_code='".$employee."'";
	$row2 = $db->select($query2);
	$record2 = $row2->fetch_array();
	
	$reporting_manager		= $record2['reporting_manager'];
	$reporting_manager_name	= $record2['reporting_manager_name'];
	$appointment_officer		= $record2['appointment_officer'];
	$appointment_officer_name	= $record2['appointment_officer_name'];
	
	$post						= mysqli_real_escape_string($db->link, $_POST['post']);
	$to_work_location			= mysqli_real_escape_string($db->link, $_POST['to_work_location']);
	if(isset($_POST['to_office_name'])){
		$to_office_name			= mysqli_real_escape_string($db->link, $_POST['to_office_name']);
	}else{
		$to_office_name			= '';
	}
	
	$to_appointment_officer		= mysqli_real_escape_string($db->link, $_POST['to_appointment_officer']);
	$to_appointment_officer_name= mysqli_real_escape_string($db->link, $_POST['to_appointment_officer_name']);
	
	$qry = "INSERT INTO `promotion_request` (`to_post`, `relieving_date`, `employee`, `work_location`, `office_name`, `reporting_manager`, `reporting_manager_name`, `appointment_officer`, `appointment_officer_name`, `to_work_location`, `to_office_name`, `to_appointment_officer`, `to_appointment_officer_name`, `transfer_by`) VALUES ('$post', '$relieving_date', '$employee', '$work_location', '$office_name', '$reporting_manager', '$reporting_manager_name', '$appointment_officer', '$appointment_officer_name', '$to_work_location', '$to_office_name', '$to_appointment_officer', '$to_appointment_officer_name', '$transfer_by')";
	if ($db->insert($qry)) {
		echo "Success";
	}else{
		echo "Something went wrong!";
	}
}

if(isset($_POST['add_retirement'])){
	$retired_by			= $_SESSION['astro_email'];
	$retirement_order_date	= date("Y-m-d");
	$retirement_date	= mysqli_real_escape_string($db->link, $_POST['retirement_date']);
	$employee			= mysqli_real_escape_string($db->link, $_POST['employee']);
	
	$qry = "UPDATE `employee` set is_retired='1', retirement_date='$retirement_date', retired_by='$retired_by', retirement_order_date='$retirement_order_date' where employee_code='$employee'";
	if ($db->insert($qry)) {
		echo "Success";
	}else{
		echo "Something went wrong!";
	}
}


if(isset($_POST['action23'])){
	if($_POST['action23']=='fetch_employee_history'){
		$output = '';
		$output .='<div class="accordion accordion-flush" id="accordionFlushExample">
			<div class="accordion-item">
				<h2 class="accordion-header" id="flush-headingOne">
					<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
						Employee Details
					</button>
				</h2>
				<div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
					<div class="accordion-body">
						<div class="table-responsive">
							<table class="table table-bordered">
								<tbody>';
									$i=1;
									$query="select * from employee where employee_code='".$_POST['query23']."'";
									$row=$db->select($query);
									$record=$row->fetch_array();
									if($record['work_location']=='Head Quarter'){
										$office_name = '';
									}else if($record['work_location']=='Division'){
										$query3="select * from division where id='".$record['office_name']."'";
										$row3=$db->select($query3);
										$record3=$row3->fetch_array();
										
										$office_name = $record3['division'];
									}elseif($record['work_location']=='Depot'){
										$query3="select * from deport where id='".$record['office_name']."'";
										$row3=$db->select($query3);
										$record3=$row3->fetch_array();
										
										$office_name = $record3['deport'];
									}
									
									$query2="select * from post where id='".$record['post']."'";
									$row2=$db->select($query2);
									if($row2->num_rows > 0){
										$record2=$row2->fetch_array();
										$post = $record2['post_name'];
									}else{
										$post = '';
									}
									
									$query4="select * from department where id='".$record['department']."'";
									$row4=$db->select($query4);
									if($row4->num_rows > 0){
										$record4=$row4->fetch_array();
										$department = $record4['department'];
									}else{
										$department = '';
									}
									
									$query9="select * from cast where id='".$record['cast']."'";
									$row9=$db->select($query9);
									if($row9->num_rows > 0){
										$record9=$row9->fetch_array();
										$cast = $record9['cast'];
									}else{
										$cast = '';
									}
									
									$query10="select * from work_location where work_location='".$record['work_location']."'";
									$row10=$db->select($query10);
									if($row10->num_rows > 0){
										$record10=$row10->fetch_array();
										$work_location = $record10['work_location_name'];
									}else{
										$work_location = '';
									}
									
									
									
									$output .='<tr>
											<th>Employee Code</th>
											<td>'.$record['employee_code'].'</td>
											<th>Employee Name</th>
											<td>'.$record['employee_name'].'</td>
										</tr>
										<tr>
											<th>Work Location</th>
											<td>'.$work_location.'</td>';
											if($office_name == ''){
												$output .='<th colspan="2"></th>';
											}else{
												$output .='<th>College Name</th>
												<td>'.$office_name.'</td>';
											}
											
										$output .='</tr>
										<tr>
											<th>Designation</th>
											<td>'.$post.'</td>
											<th>Department</th>
											<td>'.$department.'</td>
										</tr>
										
										<tr>
											<th>Father Name</th>
											<td>'.$record['father_name'].'</td>
											<th>Mother Name</th>
											<td>'.$record['mother_name'].'</td>
										</tr>
										<tr>
											<th>Gender</th>
											<td>'.$record['gender'].'</td>
											<th>DOB</th>
											<td>'.date("d M, Y",strtotime($record['dob'])).'</td>
										</tr>
										<tr>
											<th>Address</th>
											<td colspan="3">'.$record['address'].'</td>
										</tr>
										<tr>
											<th>City</th>
											<td>'.$record['city'].'</td>
											<th>District</th>
											<td>'.$record['district'].'</td>
										</tr>
										<tr>
											<th>State</th>
											<td>'.$record['state'].'</td>
										</tr>
										<tr>
											<th>Cast</th>
											<td>'.$cast.'</td>
											<th>DOJ</th>
											<td>'.date("d M, Y",strtotime($record['doj'])).'</td>
										</tr>
										<tr>
											<th>Nominee</th>
											<td>'.$record['nominee'].'</td>
											<th>Nominee Relation</th>
											<td>'.$record['nominee_relation'].'</td>
										</tr>
										
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="accordion-item">
				<h2 class="accordion-header" id="flush-headingTwo">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
						Leave History
					</button>
				</h2>
				<div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
					<div class="accordion-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>From Date</th>
										<th>To Date</th>
										<th>Request Type</th>
										<th>Requested ON</th>
										<th>Note</th>
										<th>Status</th>
										<th>Action Taken By</th>
									</tr>
								</thead>
								<tbody>';
									$i=1;
									$query="select * from leave_request where employee='".$_POST['query23']."' order by id desc";
									$row=$db->select($query);
									while($record=$row->fetch_array()){
										$output .='<tr>
											<td>'.date("d M, y",strtotime($record['from_date'])).'</td>
											<td>'.date("d M, y",strtotime($record['to_date'])).'</td>
											<td>'.$record['leave_type'].'</td>
											<td>
												'.date("d M, Y h:i A",strtotime($record['requested_on'])).'
												<br />'.$_SESSION['astro_name'].'
											</td>
											<td>'.$record['notes'].'</td>
											<td>';
												if($record['is_approved']=='1'){
													$output .='<span class="text-success">Approved</span>';
												}else{
													$output .='<span class="text-danger">Pending</span>';
												}
											$output .='</td>
											<td>
												'.$record['action_taken_by'].'
												<br />';
												if($record['action_taken_on']!=NULL){
													$output .='On '.date("d M, y",strtotime($record['action_taken_on']));
												}
											$output .='</td>
										</tr>';
									$i++;
									}
								$output .='</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="accordion-item">
				<h2 class="accordion-header" id="flush-headingThree">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
						Transfer History
					</button>
				</h2>
				<div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
					<div class="accordion-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Order Date</th>
										<th>Designation</th>
										<th>From Work Location</th>
										<th>Relieving Date</th>
										<th>To Work Location</th>
										<th>Transfered By</th>
									</tr>
								</thead>
								<tbody>';
									$i=1;
									$query="select * from transfer_request where employee='".$_POST['query23']."' and is_transfer='1'";
									$row=$db->select($query);
									while($record=$row->fetch_array()){
										$query1="select * from employee where employee_code='".$record['employee']."'";
										$row1=$db->select($query1);
										$record1=$row1->fetch_array();
										
										$query2="select * from post where id='".$record['post']."'";
										$row2=$db->select($query2);
										$record2=$row2->fetch_array();
										
										if($record['work_location']=='Head Quarter'){
											$work_location = $record['work_location'];
										}else if($record['work_location']=='Division'){
											$query3="select * from division where id='".$record['office_name']."'";
											$row3=$db->select($query3);
											$record3=$row3->fetch_array();
											
											$work_location = $record['work_location'].' ('.$record3['division'].')';
										}elseif($record['work_location']=='Depot'){
											$query3="select * from deport where id='".$record['office_name']."'";
											$row3=$db->select($query3);
											$record3=$row3->fetch_array();
											
											$work_location = $record['work_location'].' ('.$record3['deport'].')';
										}
										
										if($record['to_work_location']=='Head Quarter'){
											$to_work_location = $record['to_work_location'];
										}else if($record['to_work_location']=='Division'){
											$query3="select * from division where id='".$record['to_office_name']."'";
											$row3=$db->select($query3);
											$record3=$row3->fetch_array();
											
											$to_work_location = $record['to_work_location'].' ('.$record3['division'].')';
										}elseif($record['to_work_location']=='Depot'){
											$query3="select * from deport where id='".$record['to_office_name']."'";
											$row3=$db->select($query3);
											$record3=$row3->fetch_array();
											
											$to_work_location = $record['to_work_location'].' ('.$record3['deport'].')';
										}
										
										$query4="select * from login where mobile='".$record['transfer_by']."'";
										$row4=$db->select($query4);
										$record4=$row4->fetch_array();
										$output .='<tr>
											<td>'.$i.'</td>
											<td>'.date("d M, Y",strtotime($record['add_date'])).'</td>
											<td>'.$record2['post_name'].'</td>
											<td>'.$work_location.'</td>
											<td>'.date("d M, Y",strtotime($record['relieving_date'])).'</td>
											<td>'.$to_work_location.'</td>
											<td>'.$record4['name'].'</td>
										</tr>';
									$i++;
									}
								$output .='</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="accordion-item">
				<h2 class="accordion-header" id="flush-headingFour">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
						Promotion History
					</button>
				</h2>
				<div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour"
					data-bs-parent="#accordionFlushExample">
					<div class="accordion-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Order Date</th>
										<th>Current Post</th>
										<th>Current Work Location</th>
										<th>Relieving Date</th>
										<th>New Post</th>
										<th>New Work Location</th>
										<th>Transfered By</th>
									</tr>
								</thead>
								<tbody>';
									$i=1;
									$query="select * from promotion_request where employee='".$_POST['query23']."' and is_transfer='1'";
									$row=$db->select($query);
									while($record=$row->fetch_array()){
										$query1="select * from employee where employee_code='".$record['employee']."'";
										$row1=$db->select($query1);
										$record1=$row1->fetch_array();
										
										$query2="select * from post where id='".$record['post']."'";
										$row2=$db->select($query2);
										$record2=$row2->fetch_array();
										
										$query5="select * from post where id='".$record['to_post']."'";
										$row5=$db->select($query5);
										$record5=$row5->fetch_array();
										
										if($record['work_location']=='Head Quarter'){
											$work_location = $record['work_location'];
										}else if($record['work_location']=='Division'){
											$query3="select * from division where id='".$record['office_name']."'";
											$row3=$db->select($query3);
											$record3=$row3->fetch_array();
											
											$work_location = $record['work_location'].' ('.$record3['division'].')';
										}elseif($record['work_location']=='Depot'){
											$query3="select * from deport where id='".$record['office_name']."'";
											$row3=$db->select($query3);
											$record3=$row3->fetch_array();
											
											$work_location = $record['work_location'].' ('.$record3['deport'].')';
										}
										
										if($record['to_work_location']=='Head Quarter'){
											$to_work_location = $record['to_work_location'];
										}else if($record['to_work_location']=='Division'){
											$query3="select * from division where id='".$record['to_office_name']."'";
											$row3=$db->select($query3);
											$record3=$row3->fetch_array();
											
											$to_work_location = $record['to_work_location'].' ('.$record3['division'].')';
										}elseif($record['to_work_location']=='Depot'){
											$query3="select * from deport where id='".$record['to_office_name']."'";
											$row3=$db->select($query3);
											$record3=$row3->fetch_array();
											
											$to_work_location = $record['to_work_location'].' ('.$record3['deport'].')';
										}
										
										$query4="select * from login where mobile='".$record['transfer_by']."'";
										$row4=$db->select($query4);
										$record4=$row4->fetch_array();
										$output .='<tr>
											<td>'.$i.'</td>
											<td>'.date("d M, Y",strtotime($record['add_date'])).'</td>
											<td>'.$record2['post_name'].'</td>
											<td>'.$work_location.'</td>
											<td>'.date("d M, Y",strtotime($record['relieving_date'])).'</td>
											<td>'.$record5['post_name'].'</td>
											<td>'.$to_work_location.'</td>
											<td>'.$record4['name'].'</td>
										</tr>';
									$i++;
									}
								$output .='</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>';
		
		echo $output;
	}
}


if(isset($_POST['search_post'])){
	$work_location				= mysqli_real_escape_string($db->link, $_POST['work_location']);
	
	$i=1;
	$output = '';
	$query="select * from post where work_location='$work_location' order by post_name_en asc";
	$row=$db->select($query);
	while($record=$row->fetch_array()){
		$query1="select post_name as reporting_authority from post where id='".$record['reporting_authority']."'";
		$row1=$db->select($query1);
		if ($row1->num_rows > 0) {
			$record1=$row1->fetch_array();
			$reporting_authority = $record1['reporting_authority'];
		}else{
			$reporting_authority = '';
		}
		
		$query1="select post_name as reviewing_authority from post where id='".$record['reviewing_authority']."'";
		$row1=$db->select($query1);
		if ($row1->num_rows > 0) {
			$record1=$row1->fetch_array();
			$reviewing_authority = $record1['reviewing_authority'];
		}else{
			$reviewing_authority = '';
		}
		
		$query1="select post_name as accepting_authority from post where id='".$record['accepting_authority']."'";
		$row1=$db->select($query1);
		if ($row1->num_rows > 0) {
			$record1=$row1->fetch_array();
			$accepting_authority = $record1['accepting_authority'];
		}else{
			$accepting_authority = '';
		}
		
		
		
		$output .= '<tr>
			<td>'.$i.'</td>
			<td>'.$record['post_name_en'].'</td>
			<td>'.$record['post_name'].'</td>
			<td>'.$record['work_location'].'</td>
			<td>'.$reporting_authority.'</td>
			<td>'.$reviewing_authority.'</td>
			<td>'.$accepting_authority.'</td>
			<td>
				<a href="post?id='.$record['id'].'" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-edit"></i></a>
				<a href="javascript:;" class="btn btn-danger btn-sm" onclick="return deleteconfig('.$record['id'].')"><i class="fa fa-trash"></i></a>
			</td>
		</tr>';
	$i++;
	}
	echo $output;
}


if(isset($_POST['search_employee'])){
	$work_location				= mysqli_real_escape_string($db->link, $_POST['work_location']);
	if(isset($_POST['office_name'])){
		$office_name			= mysqli_real_escape_string($db->link, $_POST['office_name']);
		if($office_name == ''){
			$query="select * from employee where work_location='$work_location' order by employee_name asc";
		}else{
			$query="select * from employee where work_location='$work_location' and office_name='$office_name' order by employee_name asc";
		}
	}else{
		$office_name			= '';
		$query="select * from employee where work_location='$work_location' order by employee_name asc";
	}
	
	$i=1;
	$output = '';
	
	$output .= '<div class="row">
		<div class="col-md-9 mb-3"></div>
		<div class="col-md-3 mb-3">
			<input type="text" class="form-control" placeholder="Search..." onkeyup="action_search(this.value)">
		</div>
	</div>
	<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr class="text-nowrap bg-primary text-white">
						<th>#</th>
						<th>Profile Pic</th>
						<th>Employee Code</th>
						<th>Employee Name</th>
						<th>Work Location</th>
						<th>Post Name</th>
						<th>Mobile</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="employee_data_search">';
	
	$row=$db->select($query);
	while($record=$row->fetch_array()){
		$query1="select * from post where id='".$record['post']."'";
		$row1=$db->select($query1);
		if($row1->num_rows > 0){
			$record1=$row1->fetch_array();
			$post_name_en = $record1['post_name'];
		}else{
			$post_name_en = '';
		}
		
		
		$query2="select * from login where mobile='".$record['phone']."'";
		$row2=$db->select($query2);
		if($row2->num_rows > 0){
			$record2=$row2->fetch_array();
			$core_pass = $record2['core_pass'];
		}else{
			$core_pass = '';
		}
		
		
		if(file_exists($record['profile_pic'])){
			$profile_pic	= $record['profile_pic'];
		}else{
			$profile_pic	= 'assets/images/logo-light.png';
		}
		$output .='<tr>
			<td>'.$i.'</td>
			<td><img src="'.$profile_pic.'" style="width:100px;height:99px;object-fit:cover;border-radius:50%;"></td>
			<td>'.$record['employee_code'].'</td>
			<td>'.$record['employee_name'].'</td>
			<td>'.$record['work_location'].'</td>
			<td>'.$post_name_en.'</td>
			<td>'.$record['phone'].'</td>
			<td class="text-nowrap">
				<form method="POST" action="view-employee-detials" target="_blank">
					<input type="hidden" name="id" value="'.base64_encode($record['employee_code']).'">
					<button type="submit" class="btn btn-info btn-xs" target="_blank"><i class="fa fa-eye"></i></button>
				</form>
				<form method="POST" action="employee" target="_blank">
					<input type="hidden" name="id" value="'.base64_encode($record['employee_code']).'">
					<button type="submit" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-edit"></i></button>
				</form>
				<a href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
			</td>
		</tr>';
	$i++;
	}
	$output .='</tbody></table></div>';
	echo $output;
}

if(isset($_POST['search_today_attendance_status'])){
	$work_location	= mysqli_real_escape_string($db->link, $_POST['work_location']);
	
	$output = '';
	$today=date('Y-m-d');
	$day_name = date('D', strtotime($today));
																
	if($_POST['work_location']=='Division'){
		$query1="select * from division where id='".$_POST['office_name']."'";
		$row1=$db->select($query1);
		$record1=$row1->fetch_array();
		
		$query5="select * from employee where (attendance_type!='Manual' or attendance_type!=NULL) and work_location='Division' and office_name='".$record1['id']."'";
	}else if($_POST['work_location']=='Depot'){
		$query2="select * from deport where id='".$_POST['office_name']."'";
		$row2=$db->select($query2);
		$record2=$row2->fetch_array();
		
		$query5="select * from employee where (attendance_type!='Manual' or attendance_type!=NULL) and work_location='Deport' and office_name='".$record1['id']."'";
	}else if($_POST['work_location']=='Head Quarter'){
		$query2="select * from head_quarter";
		$row2=$db->select($query2);
		$record2=$row2->fetch_array();
		
		$query5="select * from employee where (attendance_type!='Manual' or attendance_type!=NULL) and work_location='Head Quarter'";
	}
	$i=1;
	$row5 = $db->select($query5);
	if ($row5->num_rows > 0) {
		while($record5 = $row5->fetch_array()){
			$query2_1="select * from work_location where work_location='".$record5['work_location']."'";
			$row2_1=$db->select($query2_1);
			if($row2_1->num_rows > 0){
				$record2_1=$row2_1->fetch_array();
				
				$work_location_name = $record2_1['work_location_name'];
			}else{
				
			}
			
			
			if(strtoupper($day_name)==$record5['weekly_rest']){
				$output .= '<tr class="bg-warning text-white">
						<td>'.$i.'</td>
						<td>'.$record5['employee_code'].'</td>
						<td>'.$record5['employee_name'].'</td>
						<td>'.$work_location_name.'</td>
						<td colspan="5">Weekly Off</td>
					</tr>';
			}else{
				$query4 = "SELECT * FROM `attendance` WHERE employee='".$record5['phone']."' and attendance_date='$today'";
				$row4 = $db->select($query4);
				if ($row4->num_rows > 0) {
					$record4 = $row4->fetch_array();
					
					$check_in = $record4['check_in'];
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
						$mins1 = $tmins%60;
						
						$arrival = $hours1.'h '.$mins1.'m late';
					}
					
				$output .= '<tr>
						<td>'.$i.'</td>
						<td>'.$record5['employee_code'].'</td>
						<td>'.$record5['employee_name'].'</td>
						<td>'.$work_location_name.'</td>
						<td><i class="fa fa-arrow-right text-success" style="transform: rotate(135deg);"></i> &nbsp;'.$record4['check_in'].'</td>';
						if($record4['check_out']==NULL){
							$output .= '<td>--:--</td>';
						}else{
							$output .= '<td><i class="fa fa-arrow-right text-danger" style="transform: rotate(315deg);"></i> &nbsp;'.$record4['check_out'].'</td>';
						}
						$output .= '<td><a href="javascript:void(0)" onclick="action_map('.$record4['id'].')"><i class="fa fa-map-marker-alt"></i></a></td>
						<td>'.$hour.'</td>
						<td>'.$arrival.'</td>
						
					</tr>';
				}else{
					$output .= '<tr>
						<td>'.$i.'</td>
						<td>'.$record5['employee_code'].'</td>
						<td>'.$record5['employee_name'].'</td>
						<td>'.$work_location_name.'</td>
						<td>--:--</td>
						<td>--:--</td>
						<td>-----</td>
						<td>-----</td>
						<td>-----</td>
					</tr>';
				}
			}																		
			$i++;
		}
	}else{
		$output .="Employee Doesn't Exist!";
	}
	
	echo $output;
}

if(isset($_POST['action_acr_date_range'])){
	if($_POST['action_acr_date_range'] == 'fetch_acr_date_range'){
		if($_POST['query_acr_date_range']!=''){
			$query_acr_date_range = explode('-',$_POST['query_acr_date_range']);
			$start_date = $query_acr_date_range[0].'-04-01';
			$end_date = $query_acr_date_range[1].'-03-31';
		}else{
			$start_date = '';
			$end_date = '';
		}
		
		$output = '';
		$output .= '<div class="col-md-6">
					<label class="form-label">दिनांक </label>
					<input type="date" name="from_date" value="'.$start_date.'" class="form-control" readonly required>
				</div>
				<div class="col-md-6">
					<label class="form-label">से दिनांक </label>
					<input type="date" name="to_date" value="'.$end_date.'" class="form-control" readonly required>
				</div>';
		echo $output;
	}
}


if(isset($_POST['action_acr_review'])){
	if($_POST['action_acr_review']=='review_section_show_hide'){
		
		$query="select * from employee_appraisal where id='".$_POST['id']."'";
		$row=$db->select($query);
		$record=$row->fetch_array();
		
		$output = '';
		if($record['shreni'] == 'A'){
			$shreni1 = 'A - उत्कृष्ट';
		}else if($record['shreni'] == 'B'){
			$shreni1 = 'B - अतिउत्तम';
		}else if($record['shreni'] == 'C'){
			$shreni1 = 'C - उत्तम';
		}else if($record['shreni'] == 'D'){
			$shreni1 = 'D - अच्छा';
		}else if($record['shreni'] == 'E'){
			$shreni1 = 'E - ख़राब';
		}else{
			$shreni1 = '';
		}
		if($_POST['query_acr_review']=='Yes'){
			$output .= '<div class="col-md-12">
					<hr>
					<div class="row">
						<div class="col-md-6">
							<label class="form-label">समग्र ग्रेड (अंक 1 से 10 तक)</label>
							<select name="overall_grade" id="overall_grade" class="form-control" required disabled>';
								for($i = 1; $i <= 10; $i++){
									if($record['overall_grade']==$i){
										$output .='<option value="'.$i.'" selected>'.$i.'</option>';
									}else{
										$output .='<option value="'.$i.'">'.$i.'</option>';
									}
								}
							$output .='</select>
						</div>
						<div class="col-md-6">
							<label class="form-label">श्रेणी </label>
							<input type="hidden" name="shreni" id="shreni" value="'.$record['shreni'].'" class="form-control" readonly>
							<input type="text" value="'.$shreni1.'" class="form-control" readonly>';
							/*$output .='<select name="shreni" id="shreni" class="form-control" readonly>';
								$query2="select * from grading";
								$row2=$db->select($query2);
								while($record2=$row2->fetch_array()){
									if($record2['shreni']==$record['shreni']){
										$output .='<option value="'.$record2['shreni'].'" selected>'.$record2['shreni'].' - '.$record2['shreni_name'].'</option>';
									}else{
										$output .='<option value="'.$record2['shreni'].'">'.$record2['shreni'].' - '.$record2['shreni_name'].'</option>';
									}
								}
							$output .='</select>';*/
						$output .='</div>
					</div>
				</div>';
		}else if($_POST['query_acr_review']=='No'){
			$output .='<div class="col-md-12">
					<hr>
					<label class="form-label">मत भिन्नता में सकारण विवरण अंकित किया जाये । (न्यूनतम 50 अक्षरों में )</label>
					<textarea name="diffrent_openion" class="form-control" rows="5" required onkeyup="countChar(this)"></textarea>
					<span id="charNum">50</span>
				</div>
				<div class="col-md-12">
					<hr>
					<div class="row">
						<div class="col-md-6">
							<label class="form-label">समग्र ग्रेड (अंक 1 से 10 तक)</label>
							<select name="overall_grade" id="overall_grade" class="form-control" onchange="action_count_grade(this.value)" required>';
								for($i = 1; $i <= 10; $i++){
									if($record['overall_grade']==$i){
										$output .='<option value="'.$i.'" selected>'.$i.'</option>';
									}else{
										$output .='<option value="'.$i.'">'.$i.'</option>';
									}
								}
							$output .='</select>
						</div>
						<div class="col-md-6">
							<label class="form-label">श्रेणी </label>
							<input type="hidden" name="shreni" id="shreni" value="'.$record['shreni'].'" class="form-control" readonly>
							<input type="text" id="shreni1" value="'.$shreni1.'" class="form-control" readonly>';
						$output .='</div>
					</div>
				</div>';
		}else{
			
		}
		echo $output;
	}
}


if(isset($_POST['action_acr_accept'])){
	if($_POST['action_acr_accept']=='accept_section_show_hide'){
		$query="select * from review_appraisal where id='".$_POST['id']."'";
		$row=$db->select($query);
		$record=$row->fetch_array();
		
		if($record['shreni'] == 'A'){
			$shreni1 = 'A - उत्कृष्ट';
		}else if($record['shreni'] == 'B'){
			$shreni1 = 'B - अतिउत्तम';
		}else if($record['shreni'] == 'C'){
			$shreni1 = 'C - उत्तम';
		}else if($record['shreni'] == 'D'){
			$shreni1 = 'D - अच्छा';
		}else if($record['shreni'] == 'E'){
			$shreni1 = 'E - ख़राब';
		}else{
			$shreni1 = '';
		}
		$output = '';
		if($_POST['query_acr_accept']=='Yes'){
			$output .= '<div class="col-md-12">
					<hr>
					<div class="row">
						<div class="col-md-6">
							<label class="form-label">समग्र ग्रेड (अंक 1 से 10 तक)</label>
							<select name="overall_grade" id="overall_grade" class="form-control" required disabled>';
								for($i = 1; $i <= 10; $i++){
									if($record['overall_grade']==$i){
										$output .='<option value="'.$i.'" selected>'.$i.'</option>';
									}else{
										$output .='<option value="'.$i.'">'.$i.'</option>';
									}
								}
							$output .='</select>
						</div>
						<div class="col-md-6">
							<label class="form-label">श्रेणी </label>
							<input type="hidden" name="shreni" id="shreni" value="'.$record['shreni'].'" class="form-control" readonly>
							<input type="text" value="'.$shreni1.'" class="form-control" readonly>';
						$output .='</div>
					</div>
				</div>';
		}else if($_POST['query_acr_accept']=='No'){
			$output .='<div class="col-md-12">
					<hr>
					<label class="form-label">मत भिन्नता में सकारण विवरण अंकित किया जाये ।  (न्यूनतम 50 अक्षरों में )</label>
					<textarea name="diffrent_openion" class="form-control" rows="5" required onkeyup="countChar(this)"></textarea>
					<span id="charNum">100</span>
				</div>
				<div class="col-md-12">
					<hr>
					<div class="row">
						<div class="col-md-6">
							<label class="form-label">समग्र ग्रेड (अंक 1 से 10 तक)</label>
							<select name="overall_grade" id="overall_grade" class="form-control" onchange="action_count_grade(this.value)" required>';
								for($i = 1; $i <= 10; $i++){
									if($record['overall_grade']==$i){
										$output .='<option value="'.$i.'" selected>'.$i.'</option>';
									}else{
										$output .='<option value="'.$i.'">'.$i.'</option>';
									}
								}
							$output .='</select>
						</div>
						<div class="col-md-6">
							<label class="form-label">श्रेणी </label>
							<input type="hidden" name="shreni" id="shreni" value="'.$record['shreni'].'" class="form-control" readonly>
							<input type="text" id="shreni1" value="'.$shreni1.'" class="form-control" readonly>';
						$output .='</div>
					</div>
				</div>';
		}else{
			
		}
		echo $output;
	}
}



if(isset($_POST['action_001'])){
	if($_POST['action_001']=='fetch_authority_post'){
		$output = '<option value="">~~~Choose~~~</option>';
		
		$query="select * from post where work_location='".$_POST['work_location']."'";
		$row=$db->select($query);
		while($record=$row->fetch_array()){
			$output .= '<option value="'.$record['id'].'">'.$record['post_name'].'</option>';
		}
		echo $output;
	}
}


if(isset($_POST['action_post'])){
	if($_POST['action_post']=='delete_post'){
		$query="delete from post where id='".$_POST['id']."'";
		if($row=$db->select($query)){
			echo "Success";
		}else{
			echo "Something went wrong!";
		}
	}
}

if(isset($_POST['action_post'])){
	if($_POST['action_post']=='delete_department'){
		$query="delete from department where id='".$_POST['id']."'";
		if($row=$db->select($query)){
			echo "Success";
		}else{
			echo "Something went wrong!";
		}
	}
}




if(isset($_POST['update_password'])){
	$old_password		= mysqli_real_escape_string($db->link, $_POST['old_password']);
	$new_password		= mysqli_real_escape_string($db->link, $_POST['new_password']);
	$confirm_password	= mysqli_real_escape_string($db->link, $_POST['confirm_password']);
	
	
	if($new_password==$confirm_password){
		$sql = "SELECT * FROM `login` WHERE employee_code = '".$_SESSION['astro_email']."' and password='".md5($old_password)."'";
		$exe = $db->select($sql);
		if ($exe->num_rows > 0) {
			$record = $exe->fetch_array();
			
			$password = md5($new_password);
			
			$qry = "update `login` set `password`='$password', `core_pass`='$new_password' where employee_code='".$_SESSION['astro_email']."'";
			if ($db->insert($qry)) {
				echo "Success";
			}else{
				echo "Something Went Wrong!";
			}
		}else{
			echo "error1";
		}
	}else{
		echo "error";
	}
}


if(isset($_POST['action_search'])){
	if($_POST['action_search']=='fetch_search_data'){
		$output = '';
		$i=1;
		
		$work_location			= mysqli_real_escape_string($db->link, $_POST['work_location']);
		$office_name			= mysqli_real_escape_string($db->link, $_POST['office_name']);
		
		if($_POST['employee_no']==''){
			if($office_name == ''){
				$query="select * from employee where work_location='$work_location' order by employee_name asc";
			}else{
				$query="select * from employee where work_location='$work_location' and office_name='$office_name' order by employee_name asc";
			}
		}else{
			if($office_name == ''){
				$query="select * from employee where work_location='$work_location' and (phone LIKE '%".$_POST['employee_no']."%' or employee_name LIKE '%".$_POST['employee_no']."%' or employee_code LIKE '%".$_POST['employee_no']."%') order by employee_name asc";
			}else{
				$query="select * from employee where work_location='$work_location' and office_name='$office_name' and (phone LIKE '%".$_POST['employee_no']."%' or employee_name LIKE '%".$_POST['employee_no']."%' or employee_code LIKE '%".$_POST['employee_no']."%') order by employee_name asc";
			}
		}
		
		$row=$db->select($query);
		while($record=$row->fetch_array()){
			$query1="select * from post where id='".$record['post']."'";
			$row1=$db->select($query1);
			if($row1->num_rows > 0){
				$record1=$row1->fetch_array();
				$post_name_en = $record1['post_name'];
			}else{
				$post_name_en = '';
			}
			
			
			$query2="select * from login where mobile='".$record['phone']."'";
			$row2=$db->select($query2);
			if($row2->num_rows > 0){
				$record2=$row2->fetch_array();
				$core_pass = $record2['core_pass'];
			}else{
				$core_pass = '';
			}
			
			
			if(file_exists($record['profile_pic'])){
				$profile_pic	= $record['profile_pic'];
			}else{
				$profile_pic	= 'assets/images/logo-light.png';
			}
			$output .='<tr>
				<td>'.$i.'</td>
				<td><img src="'.$profile_pic.'" style="width:100px;height:99px;object-fit:cover;border-radius:50%;"></td>
				<td>'.$record['employee_code'].'</td>
				<td>'.$record['employee_name'].'</td>
				<td>'.$record['work_location'].'</td>
				<td>'.$post_name_en.'</td>
				<td>'.$record['phone'].'</td>
				<td style="text-transform:none">'.$core_pass.'</td>
				<td class="text-nowrap">
					<a href="view-employee-detials?employee_code='.$record['employee_code'].'" class="btn btn-info btn-xs" target="_blank"><i class="fa fa-eye"></i></a>
					<a href="employee?employee_code='.$record['employee_code'].'" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-edit"></i></a>
					<a href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
				</td>
			</tr>';
		$i++;
		}
		echo $output;
	}
}

if(isset($_POST['search_acr_report'])){
	$work_location				= mysqli_real_escape_string($db->link, $_POST['work_location']);
	$i=1;
	$output = '';
	/*$output .= '<div class="row">
		<div class="col-md-9 mb-3"></div>
		<div class="col-md-3 mb-3">
			<input type="text" class="form-control" placeholder="Search..." onkeyup="action_search_acr(this.value)">
		</div>
	</div>';*/
	$output .= '<div class="table-responsive">
		<table class="table table-striped">
			<thead class="text-nowrap bg-primary text-white">
				<tr>
					<th>#</th>
					<th>Employee Code</th>
					<th>Employee</th>
					<th>WORK LOCATION</th>
					<th>POST</th>
					<th>Mobile</th>
					<th>Year</th>
					<th>From Date</th>
					<th>To Date</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody id="employee_acr_data_search">';
	
	if(isset($_POST['office_name'])){
		$office_name			= mysqli_real_escape_string($db->link, $_POST['office_name']);
		if($office_name == ''){
			$query3="select * from acr where work_location='$work_location'";
		}else{
			$query3="select * from acr where work_location='$work_location' and office_name='$office_name'";
		}
	}else{
		$office_name			= '';
		$query3="select * from acr where work_location='$work_location'";
	}
	$row3=$db->select($query3);
	if($row3->num_rows > 0){
		while($record3=$row3->fetch_array()){
			$query="select * from self_appraisal where acr_id='".$record3['id']."'";
			$row=$db->select($query);
			if($row->num_rows > 0){
				while($record=$row->fetch_array()){
				
					$query1="select * from employee where employee_code='".$record['employee']."'";
					$row1=$db->select($query1);
					$record1=$row1->fetch_array();
					
					$query11="select * from post where id='".$record1['post']."'";
					$row11=$db->select($query11);
					$record11=$row11->fetch_array();
					
					if($_SESSION['astro_role']!='Admin'){
						$query2="select * from employee_appraisal where self_appraisal_id='".$record['id']."'";
						$row2=$db->select($query2);
						if($row2->num_rows > 0){
							$record2=$row2->fetch_array();
							$create_button = '<a href="view-appraisal-details?id='.$record2['id'].'" class="btn btn-success btn-sm" target="_blank">View Appraisal</a>';
						}else{
							$create_button = '<a href="appraisal?id='.$record['id'].'" class="btn btn-success btn-sm" target="_blank">Create Appraisal</a>';
						}
						$view_button = '<a href="view-self-appraisal-details.php?id='.$record['id'].'" class="btn btn-info btn-sm" target="_blank">View Self Appraisal Details</a>';
					}else{
						$create_button = '';
						$view_button = '<form method="POST" action="view-acr-details" target="_blank">
								<input type="hidden" name="id" value="'.base64_encode($record['id']).'">
								<button type="submit" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></button>
							</form>';
					}
					$output .='<tr>
						<td>'.$i.'</td>
						<td>'.$record1['employee_code'].'</td>
						<td>'.$record1['employee_name'].'</td>
						<td>'.$record1['work_location'].'</td>
						<td>'.$record11['post_name'].'</td>
						<td>'.$record1['phone'].'</td>
						<td>'.$record['year'].'</td>
						<td>'.date("d M, Y", strtotime($record['from_date'])).'</td>
						<td>'.date("d M, Y", strtotime($record['to_date'])).'</td>
						<td>
							'.$view_button.'
							'.$create_button.'
						</td>
					</tr>';
				$i++;
				}
			}
		}
	}
	$output .='</tbody></table></div>';
	
	echo $output;
}


if(isset($_POST['action_search_acr'])){
	if($_POST['action_search_acr']=='fetch_search_acr_data'){
		$output = '';
		$i=1;
		
		$work_location			= mysqli_real_escape_string($db->link, $_POST['work_location']);
		$office_name			= mysqli_real_escape_string($db->link, $_POST['office_name']);
		
		if($office_name == ''){
			$query="select * from acr where work_location='$work_location'";
		}else{
			$query="select * from acr where work_location='$work_location' and office_name='$office_name'";
		}
		$row=$db->select($query);
		while($record=$row->fetch_array()){
			if($_POST['employee_no']==''){
				$query1="select * from employee";
			}else{
				$query1="select * from employee where (phone LIKE '%".$_POST['employee_no']."%' or employee_name LIKE '%".$_POST['employee_no']."%' or employee_code LIKE '%".$_POST['employee_no']."%')";
			}
			$row1=$db->select($query1);
			if ($row1->num_rows > 0) {
				$record1=$row1->fetch_array();
			
				$query11="select * from post where id='".$record1['post']."'";
				$row11=$db->select($query11);
				$record11=$row11->fetch_array();
				
				if($_SESSION['astro_role']!='Admin'){
					$query2="select * from employee_appraisal where self_appraisal_id='".$record['id']."'";
					$row2=$db->select($query2);
					if($row2->num_rows > 0){
						$record2=$row2->fetch_array();
						$create_button = '<a href="view-appraisal-details?id='.$record2['id'].'" class="btn btn-success btn-sm" target="_blank">View Appraisal</a>';
					}else{
						$create_button = '<a href="appraisal?id='.$record['id'].'" class="btn btn-success btn-sm" target="_blank">Create Appraisal</a>';
					}
					$view_button = '<a href="view-self-appraisal-details.php?id='.$record['id'].'" class="btn btn-info btn-sm" target="_blank">View Self Appraisal Details</a>';
				}else{
					$create_button = '';
					$view_button = '<a href="view-acr-details.php?id='.$record['id'].'" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-eye"></i></a>';
				}
				$output .='<tr>
					<td>'.$i.'</td>
					<td>'.$record1['employee_code'].'</td>
					<td>'.$record1['employee_name'].'</td>
					<td>'.$record1['work_location'].'</td>
					<td>'.$record11['post_name'].'</td>
					<td>'.$record1['phone'].'</td>
					<td>'.$record['year'].'</td>
					<td>'.date("d M, Y", strtotime($record['from_date'])).'</td>
					<td>'.date("d M, Y", strtotime($record['to_date'])).'</td>
					<td>
						'.$view_button.'
						'.$create_button.'
					</td>
				</tr>';
			$i++;
			}
		}
		echo $output;
	}
}


if(isset($_POST['search_acr_data'])){
	$work_location				= mysqli_real_escape_string($db->link, $_POST['work_location']);
	$i=1;
	$output = '';
	$output .= '<div class="table-responsive">
		<table class="table table-striped">
			<thead class="text-nowrap bg-primary text-white">
				<tr>
					<tr class="text-nowrap bg-primary text-white">
					<th>#</th>
					<th>ए० सी० आर० वर्ष</th>
					<th>पदनाम</th>
					<th>कार्य स्थल</th>
					<th>डिवीज़न / डिपो का नाम</th>
					<th>प्रतिवेदक प्राधिकारी</th>
					<th>समीक्षक प्राधिकारी</th>
					<th>स्वीकर्ता प्राधिकारी</th>';
					if($_SESSION['astro_role']=='Admin'){
						$output .= '<th>Action</th>';
					}
					
				$output .= '</tr>
			</thead>
			<tbody id="employee_acr_data_search">';
	
	if(isset($_POST['office_name'])){
		$office_name			= mysqli_real_escape_string($db->link, $_POST['office_name']);
		if($office_name == ''){
			$query="select * from acr where work_location='$work_location'";
		}else{
			$query="select * from acr where work_location='$work_location' and office_name='$office_name'";
		}
	}else{
		$office_name			= '';
		$query="select * from acr where work_location='$work_location'";
	}
	$row=$db->select($query);
	if($row->num_rows > 0){
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
		$output .= '<tr>
				<td>'.$i.'</td>
				<td class="nowrap">'.$record['year'].'</td>
				<td>'.$record2['post_name'].'</td>
				<td>'.$record['work_location'].'</td>
				<td>'.$office_name.'</td>
				<td>'.$record1['employee_name'].' ('.$record5['post_name'].')'.'</td>
				<td>'.$record3['employee_name'].' ('.$record6['post_name'].')'.'</td>
				<td>'.$record4['employee_name'].' ('.$record7['post_name'].')'.'</td>
				<td>';
					if($_SESSION['astro_role']=='Admin'){
						$output .= '<form method="POST" action="acr" target="_blank">
								<input type="hidden" name="id" value="'.base64_encode($record['id']).'">
								<button type="submit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></button>
							</form>';
					}
				$output .= '</td>
			</tr>';
		$i++;
		}
	}
	$output .='</tbody></table></div>';
	
	echo $output;
}


if(isset($_POST['action_self_appraisal1'])){
	if($_POST['action_self_appraisal1']=='fetch_self_appraisal_popup_data'){
	    $output = '';
		$output .= '<div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Edit Self Appraisal</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">';
                    
                $output .= '<span class="text-success" id="message"></span>
                    </div>
                    <div class="col-md-12 mb-3">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr class="bg-primary text-white">
										<th colspan="3">वार्षिक कार्य योजना और उपलब्धि:</th>
									</tr>
									<tr>
										<th>#</th>
										<th>विषय</th>
										<th>वर्तमान वर्ष</th>
									</tr>
								</thead>
								<tbody>';
									$i=1;
									$query4="select * from annual_work_plan where self_appraisal_id='".$_POST['self_appraisal_id']."'";
									$row4=$db->select($query4);
									if ($row4->num_rows > 0) {
										while($record4=$row4->fetch_array()){
											$output .= '<tr>
												<th>'.$i.'</th>
												<td>'.$record4['task_to_be_performed'].'</td>
												<td>
													<input type="text" name="actual_achievement[]" value="'.$record4['actual_achievement'].'" class="form-control" required>
													<input type="hidden" name="annual_work_plan_id[]" value="'.$record4['id'].'">
												</td>
											</tr>';
											$i++;
										}
									}
                    $output .= '</tbody></table></div></div>
                    <div class="col-md-12 mb-3">
                        <input type="hidden" name="self_appraisal_id" value="'.$_POST['self_appraisal_id'].'">
                        <input type="hidden" name="update_annual_work_plan" value="update_annual_work_plan">
                        <button type="submit" id="button_id" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>';
		echo $output;
	}	
}

if(isset($_POST['action_self_appraisal'])){
	if($_POST['action_self_appraisal']=='fetch_self_appraisal_popup_data'){
	    $output = '';
		$output .= '<div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Edit Self Appraisal</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">';
                    
                $output .= '<span class="text-success" id="message"></span>
                    </div>
                    <div class="col-md-12 mb-3">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr class="bg-primary text-white">
										<th colspan="3">वार्षिक कार्य योजना और उपलब्धि:</th>
									</tr>
									<tr>
										<th>#</th>
										<th>विषय</th>
										<th>वर्तमान वर्ष</th>
									</tr>
								</thead>
								<tbody>';
									$i=1;
									$query4="select * from annual_work_plan where self_appraisal_id='".$_POST['self_appraisal_id']."'";
									$row4=$db->select($query4);
									if ($row4->num_rows > 0) {
										while($record4=$row4->fetch_array()){
											$query41="select * from deport_level_annual_work where id='".$record4['task_to_be_performed']."'";
											$row41=$db->select($query41);
											if ($row41->num_rows > 0) {
												$record41=$row41->fetch_array();
												$output .= '<tr>
													<th>'.$i.'</th>
													<td>'.$record41['work'].'</td>
													<td>
														<input type="text" name="actual_achievement[]" value="'.$record4['actual_achievement'].'" class="form-control" required>
														<input type="hidden" name="annual_work_plan_id[]" value="'.$record4['id'].'">
													</td>
												</tr>';
												$i++;
											}
										}
									}
                    $output .= '</tbody></table></div></div>
                    <div class="col-md-12 mb-3">
                        <input type="hidden" name="self_appraisal_id" value="'.$_POST['self_appraisal_id'].'">
                        <input type="hidden" name="update_annual_work_plan" value="update_annual_work_plan">
                        <button type="submit" id="button_id" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>';
		echo $output;
	}	
}

if(isset($_POST['update_annual_work_plan'])){
	$self_appraisal_id		= mysqli_real_escape_string($db->link, $_POST['self_appraisal_id']);
	
	$qry21 = "UPDATE `self_appraisal` set is_updated='0' where id='$self_appraisal_id'";
	$db->insert($qry21);
	
	$x=0;
	$size = sizeof($_POST['annual_work_plan_id']);
	for($i=0; $i < $size; $i++){
		$annual_work_plan_id	= $_POST['annual_work_plan_id'][$i];
		$actual_achievement		= $_POST['actual_achievement'][$i];
		
		$qry2 = "UPDATE `annual_work_plan` set actual_achievement='$actual_achievement' where id='$annual_work_plan_id' and self_appraisal_id='$self_appraisal_id'";
		if($db->insert($qry2)){
			$x++;
		}
	}
	
	if($x > 0){
		echo "Success";
	}else{
		echo "Not Updated!";
	}
}

if(isset($_POST['action_appraisal'])){
	if($_POST['action_appraisal']=='fetch_appraisal_popup_data'){
	    $output = '';
		$output .= '<div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Edit Grade</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">';
                    
                $output .= '<span class="text-success" id="message1"></span>
                    </div>
                    <div class="col-md-12 mb-3">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr class="bg-primary text-white">
										<th colspan="5">वार्षिक कार्य योजना और उपलब्धि:</th>
									</tr>
									<tr>
										<th>#</th>
										<th>विषय </th>
										<th>वर्तमान वर्ष </th>
										<th>ग्रेड (1 to 10)</th>
									</tr>
								</thead>
								<tbody>';
									$a=1;
									
									$query3="select * from self_appraisal where id='".$_POST['self_appraisal_id']."'";
									$row3=$db->select($query3);
									$record3=$row3->fetch_array();
									
									$query31="select pen_picture from employee_appraisal where self_appraisal_id='".$_POST['self_appraisal_id']."'";
									$row31=$db->select($query31);
									$record31=$row31->fetch_array();
									
									$query41="select * from annual_work_plan where self_appraisal_id='".$_POST['self_appraisal_id']."'";
									$row41=$db->select($query41);
									
									$total_yojna = ($row41->num_rows);
									
									while($record41=$row41->fetch_array()){
										$query4="select * from deport_level_annual_work where id='".$record41['task_to_be_performed']."'";
										$row4=$db->select($query4);
										$record4=$row4->fetch_array();
										
										if($record41['task_to_be_performed']=='Behaviour'){
											$work = 'सामान्य व्यवहार';
										}else{
											$query4="select * from deport_level_annual_work where id='".$record41['task_to_be_performed']."'";
											$row4=$db->select($query4);
											$record4=$row4->fetch_array();
											$work = $record4['work'];
										}
										
										$actual_achievement = $record41['actual_achievement'];
										
										$grade_data = '';
										
										if($record41['task_to_be_performed']=='98' || $record41['task_to_be_performed']=='103'){
											$query42="select * from kilometers where marg='".$record3['marg']."' and min_km <= $actual_achievement and max_km >= $actual_achievement";
											$row42=$db->select($query42);
											$record42=$row42->fetch_array();
											
											$min_grade = $record42['min_grade'];
											$grade_data .='<option value="'.$min_grade.'" selected>'.$min_grade.'</option>';
										}else if($record41['task_to_be_performed']=='99'){
											$query42="select * from diesel_average where marg='".$record3['marg']."' and min_average <= $actual_achievement and max_average >= $actual_achievement";
											$row42=$db->select($query42);
											$record42=$row42->fetch_array();
											
											$min_grade = $record42['min_grade'];
											$grade_data .='<option value="'.$min_grade.'" selected>'.$min_grade.'</option>';
										}else if($record41['task_to_be_performed']=='114' || $record41['task_to_be_performed']=='105'){
											$query42="select * from attendance_days where min_days <= $actual_achievement and max_days >= $actual_achievement";
											$row42=$db->select($query42);
											$record42=$row42->fetch_array();
											
											$min_grade = $record42['min_grade'];
											$grade_data .='<option value="'.$min_grade.'" selected>'.$min_grade.'</option>';
										}else if($record41['task_to_be_performed']=='104'){
											$query42="select * from load_factor where min_load <= $actual_achievement and max_load >= $actual_achievement";
											$row42=$db->select($query42);
											$record42=$row42->fetch_array();
											
											$grade = $record42['grade'];
											$grade_data .='<option value="'.$grade.'" selected>'.$grade.'</option>';
										}else if($record41['task_to_be_performed']=='100'){
											if($actual_achievement==0){
												$accident = '10';
											}else if($actual_achievement==1){
												$accident = '5';
											}else{
												$accident = '0';
											}
											$grade_data .='<option value="'.$accident.'" selected>'.$accident.'</option>';
										}else{
											for($i = 1; $i <= 10; $i++){
												if($record41['grade']==$i){
													$grade_data .='<option value="'.$i.'" selected>'.$i.'</option>';
												}else{
													$grade_data .='<option value="'.$i.'">'.$i.'</option>';
												}
											}
										}
									$output .= '<tr>
											<td>'.$a.'</td>
											<td>
												'.$work.'
												<input type="hidden" name="annual_work_plan_id[]" value="'.$record41['id'].'" class="form-control">
											</td>
											<td>'.$record41['actual_achievement'].'</td>
											<td>
												<select name="grade[]" class="form-control allot_qty_class" onchange="action_count_grade(this.value)" required>
													<option value="">---</option>
													'.$grade_data.'
												</select>
											</td>
										</tr>';
										
									
									$a++;
									}
									
									$output .= '<tr class="bg-primary text-white">
											<th colspan="4">प्रतिवेदक प्राधिकारी कि टिप्पणी (अधिकतम 100 अक्षर) :<br />
												<small>ग्रेडिंग कि प्रणाली अपनाते हुए कार्मिक / अधिकारी के व्यक्तिगत गुण एवं कार्यक्षमता तथा आउटपुट का संज्ञान लिया जाये </small>
											</th>
										</tr>';
									$output .= '<tr>
											<td colspan="4">
												<textarea name="pen_picture" class="form-control" rows="5" onkeyup="countChar(this)">'.$record31['pen_picture'].'</textarea>
												<span id="charNum">'.(100 - strlen($record31['pen_picture'])).'</span>
											</td>
										</tr>';
									
                    $output .= '</tbody></table></div></div>
                    <div class="col-md-12 mb-3">
                        <input type="hidden" name="total_yojna" id="total_yojna" value="'.$total_yojna.'">
                        <input type="hidden" name="self_appraisal_id" value="'.$_POST['self_appraisal_id'].'">
                        <input type="hidden" name="update_annual_work_plan_grade" value="update_annual_work_plan_grade">
                        <button type="submit" id="button_id1" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>';
		echo $output;
	}	
}


if(isset($_POST['update_annual_work_plan_grade'])){
	$self_appraisal_id	= mysqli_real_escape_string($db->link, $_POST['self_appraisal_id']);
	$total_yojna	= mysqli_real_escape_string($db->link, $_POST['total_yojna']);
	$pen_picture	= mysqli_real_escape_string($db->link, $_POST['pen_picture']);
	
	$query="UPDATE self_appraisal set is_updated='1' where id='$self_appraisal_id'";
	$db->insert($query);
	
	$x=0;
	$total_grade = 0;
	$size = sizeof($_POST['annual_work_plan_id']);
	for($i=0; $i < $size; $i++){
		$annual_work_plan_id	= $_POST['annual_work_plan_id'][$i];
		$grade		= $_POST['grade'][$i];
		
		$qry2 = "UPDATE `annual_work_plan` set grade='$grade' where id='$annual_work_plan_id' and self_appraisal_id='$self_appraisal_id'";
		if($db->insert($qry2)){
			$x++;
		}
		$total_grade = $total_grade + $grade;
	}
	
	$overall_grade = number_format($total_grade / $total_yojna,0);
	
	$query42="select * from grading where min_grade <= $overall_grade and max_grade >= $overall_grade";
	$row42=$db->select($query42);
	$record42=$row42->fetch_array();
	$shreni		= $record42['shreni'];
	
	$query="UPDATE employee_appraisal set overall_grade=$overall_grade, shreni='$shreni', pen_picture='$pen_picture', is_updated='0' where self_appraisal_id='$self_appraisal_id'";
	$db->insert($query);
	
	echo "Success";
}

if(isset($_POST['action_appraisal1'])){
	if($_POST['action_appraisal1']=='fetch_appraisal_popup_data'){
	    $output = '';
		$output .= '<div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Edit Grade</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">';
                    
                $output .= '<span class="text-success" id="message1"></span>
                    </div>
                    <div class="col-md-12 mb-3">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr class="bg-primary text-white">
										<th colspan="5">वार्षिक कार्य योजना और उपलब्धि:</th>
									</tr>
									<tr>
										<th>#</th>
										<th>विषय </th>
										<th>ग्रेड (1 to 10)</th>
									</tr>
								</thead>
								<tbody>';
									$a=1;
									
									$query31="select pen_picture from employee_appraisal where id='".$_POST['employee_appraisal_id']."'";
									$row31=$db->select($query31);
									$record31=$row31->fetch_array();
									
									$query_05="select * from assestment_of_personal_attributes_data where employee_appraisal_id='".$_POST['employee_appraisal_id']."'";
									$row_05=$db->select($query_05);
									$total_yojna = ($row_05->num_rows);
									while($record_05=$row_05->fetch_array()){
										$query_06="select * from assestment_of_personal_attributes where id='".$record_05['assestment_of_personal_attributes_id']."'";
										$row_06=$db->select($query_06);
										$record_06=$row_06->fetch_array();
										
										$grade_data = '';
										for($i = 1; $i <= 10; $i++){
											if($record_05['grade']==$i){
												$grade_data .='<option value="'.$i.'" selected>'.$i.'</option>';
											}else{
												$grade_data .='<option value="'.$i.'">'.$i.'</option>';
											}
										}
										$output .= '<tr>
												<td>'.$a.'</td>
												<td>
													'.$record_06['personal_attribute'].'
													<input type="hidden" name="assestment_of_personal_attributes_data_id[]" value="'.$record_05['id'].'" class="form-control">
												</td>
												<td>
													<select name="grade[]" class="form-control allot_qty_class" onchange="action_count_grade(this.value)" required>
														<option value="">---</option>
														'.$grade_data.'
													</select>
												</td>
											</tr>';
											
										
										$a++;
									}
									
									$output .= '<tr class="bg-primary text-white">
											<th colspan="4">प्रतिवेदक प्राधिकारी कि टिप्पणी (अधिकतम 100 अक्षर) :<br />
												<small>ग्रेडिंग कि प्रणाली अपनाते हुए कार्मिक / अधिकारी के व्यक्तिगत गुण एवं कार्यक्षमता तथा आउटपुट का संज्ञान लिया जाये </small>
											</th>
										</tr>';
									$output .= '<tr>
											<td colspan="4">
												<textarea name="pen_picture" class="form-control" rows="5" onkeyup="countChar1(this)">'.$record31['pen_picture'].'</textarea>
												<span id="charNum">'.(100 - strlen($record31['pen_picture'])).'</span>
											</td>
										</tr>';
									
                    $output .= '</tbody></table></div></div>
                    <div class="col-md-12 mb-3">
                        <input type="hidden" name="total_yojna" id="total_yojna" value="'.$total_yojna.'">
                        <input type="hidden" name="employee_appraisal_id" value="'.$_POST['employee_appraisal_id'].'">
                        <input type="hidden" name="update_annual_work_plan_grade1" value="update_annual_work_plan_grade1">
                        <button type="submit" id="button_id1" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>';
		echo $output;
	}	
}

if(isset($_POST['update_annual_work_plan_grade1'])){
	$employee_appraisal_id	= mysqli_real_escape_string($db->link, $_POST['employee_appraisal_id']);
	$total_yojna	= mysqli_real_escape_string($db->link, $_POST['total_yojna']);
	$pen_picture	= mysqli_real_escape_string($db->link, $_POST['pen_picture']);
	
	$x=0;
	$total_grade = 0;
	$size = sizeof($_POST['assestment_of_personal_attributes_data_id']);
	for($i=0; $i < $size; $i++){
		$assestment_of_personal_attributes_data_id	= $_POST['assestment_of_personal_attributes_data_id'][$i];
		$grade		= $_POST['grade'][$i];
		
		$qry2 = "UPDATE `assestment_of_personal_attributes_data` set grade='$grade' where id='$assestment_of_personal_attributes_data_id' and employee_appraisal_id='$employee_appraisal_id'";
		if($db->insert($qry2)){
			$x++;
		}
		$total_grade = $total_grade + $grade;
	}
	
	$overall_grade = number_format($total_grade / $total_yojna,0);
	
	$query42="select * from grading where min_grade <= $overall_grade and max_grade >= $overall_grade";
	$row42=$db->select($query42);
	$record42=$row42->fetch_array();
	$shreni		= $record42['shreni'];
	
	$created_date = date("Y-m-d h:i:s A");
	
	$query="UPDATE employee_appraisal set overall_grade=$overall_grade, shreni='$shreni', pen_picture='$pen_picture', created_date='$created_date' where id='$employee_appraisal_id'";
	if($db->insert($query)){
		echo "Success";
	}else{
		echo "Something Went Wrong!";
	}
	
	
}


if(isset($_POST['action_review'])){
	if($_POST['action_review']=='fetch_review_popup_data'){
		$query1="select * from review_appraisal where id='".$_POST['review_id']."'";
		$row1=$db->select($query1);
		if ($row1->num_rows > 0) {
			$record1=$row1->fetch_array();
			
			$query="select * from employee_appraisal where id='".$_POST['employee_appraisal_id']."'";
			$row=$db->select($query);
			$record=$row->fetch_array();
			
			if($record['is_updated']==0){
				$overall_grade = $record['overall_grade'];
				$shreni = $record['shreni'];
			}else{
				$shreni = $record1['shreni'];
				$overall_grade = $record1['overall_grade'];
			}
		}else{
			$query="select * from employee_appraisal where id='".$_POST['employee_appraisal_id']."'";
			$row=$db->select($query);
			$record=$row->fetch_array();
			
			$overall_grade = $record['overall_grade'];
			$shreni = $record['shreni'];
		}
		
	    $output = '';
		$output .= '<div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Edit Review</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">';
                    
                $output .= '<span class="text-success" id="message2"></span>
                    </div>
                    <div class="col-md-12">
						<label class="form-label">क्या आप प्रतिवेदक प्राधिकारी द्वारा किये गए मूल्यांकन से सहमत हैं ?</label>
						<select name="agree_with_assestment" id="agree_with_assestment" class="form-control" onchange="action_acr_review(this.value,'.$_POST['employee_appraisal_id'].')">
							<option value="">---</option>';
							if($record1['agree_with_assestment']=='Yes'){
								$output .= '<option value="Yes" selected>हाँ</option>
									<option value="No">नहीं</option>';
							}else if($record1['agree_with_assestment']=='No'){
								$output .= '<option value="Yes">हाँ</option>
									<option value="No" selected>नहीं</option>';
							}else{
								$output .= '<option value="Yes">हाँ</option>
									<option value="No">नहीं</option>';
							}
						$output .= '</select>
					</div>
					<div class="col-md-12 mb-3">
						<div class="row" id="review_section_id">';
							if($shreni == 'A'){
								$shreni1 = 'A - उत्कृष्ट';
							}else if($shreni == 'B'){
								$shreni1 = 'B - अतिउत्तम';
							}else if($shreni == 'C'){
								$shreni1 = 'C - उत्तम';
							}else if($shreni == 'D'){
								$shreni1 = 'D - अच्छा';
							}else if($shreni == 'E'){
								$shreni1 = 'E - ख़राब';
							}else{
								$shreni1 = 'E - ख़राब';
							}
							if($record1['agree_with_assestment']=='Yes'){
								$output .= '<div class="col-md-12">
										<hr>
										<div class="row">
											<div class="col-md-6">
												<label class="form-label">समग्र ग्रेड (अंक 1 से 10 तक)</label>
												<select name="overall_grade" id="overall_grade" class="form-control" required readonly>';
													for($i = 1; $i <= 10; $i++){
														if($overall_grade==$i){
															$output .='<option value="'.$i.'" selected>'.$i.'</option>';
														}else{
															$output .='<option value="'.$i.'">'.$i.'</option>';
														}
													}
												$output .='</select>
											</div>
											<div class="col-md-6">
												<label class="form-label">श्रेणी </label>
												<input type="hidden" name="shreni" id="shreni" value="'.$record['shreni'].'" class="form-control" readonly>
												<input type="text" value="'.$shreni1.'" class="form-control" readonly>';
											$output .='</div>
										</div>
									</div>';
							}else if($record1['agree_with_assestment']=='No'){
								$output .='<div class="col-md-12">
										<hr>
										<label class="form-label">मत भिन्नता में सकारण विवरण अंकित किया जाये । (न्यूनतम 50 अक्षरों में )</label>
										<textarea name="diffrent_openion" class="form-control" rows="5" required onkeyup="countChar(this)">'.$record1['diffrent_openion'].'</textarea>
										<span id="charNum">50</span>
									</div>
									<div class="col-md-12">
										<hr>
										<div class="row">
											<div class="col-md-6">
												<label class="form-label">समग्र ग्रेड (अंक 1 से 10 तक)</label>
												<select name="overall_grade" id="overall_grade" class="form-control" onchange="action_count_grade(this.value)" required>';
													for($i = 1; $i <= 10; $i++){
														if($overall_grade==$i){
															$output .='<option value="'.$i.'" selected>'.$i.'</option>';
														}else{
															$output .='<option value="'.$i.'">'.$i.'</option>';
														}
													}
												$output .='</select>
											</div>
											<div class="col-md-6">
												<label class="form-label">श्रेणी </label>
												<input type="hidden" name="shreni" id="shreni" value="'.$record['shreni'].'" class="form-control" readonly>
												<input type="text" id="shreni1" value="'.$shreni1.'" class="form-control" readonly>';
											$output .='</div>
										</div>
									</div>';
							}
						$output .='</div>
					</div>
                    <div class="col-md-12 mb-3">
                        <input type="hidden" name="review_id" value="'.$_POST['review_id'].'">
                        <input type="hidden" name="employee_appraisal_id" value="'.$_POST['employee_appraisal_id'].'">
                        <input type="hidden" name="update_review" value="update_review">
                        <button type="submit" id="department_button" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>';
		echo $output;
	}	
}


if(isset($_POST['action_accept'])){
	if($_POST['action_accept']=='fetch_accept_popup_data'){
		$query1="select * from acceptance_appraisal where id='".$_POST['accept_id']."'";
		$row1=$db->select($query1);
		if ($row1->num_rows > 0) {
			$record1=$row1->fetch_array();
			
			$query="select * from review_appraisal where id='".$_POST['review_id']."'";
			$row=$db->select($query);
			$record=$row->fetch_array();
			
			if($record['is_updated']==0){
				$overall_grade = $record['overall_grade'];
				$shreni = $record['shreni'];
			}else{
				$shreni = $record1['shreni'];
				$overall_grade = $record1['overall_grade'];
			}
		}else{
			$query="select * from review_appraisal where id='".$_POST['review_id']."'";
			$row=$db->select($query);
			$record=$row->fetch_array();
			
			$overall_grade = $record['overall_grade'];
			$shreni = $record['shreni'];
		}
		
	    $output = '';
		$output .= '<div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Edit Review</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">';
                    
                $output .= '<span class="text-success" id="message3"></span>
                    </div>
                    <div class="col-md-12">
						<label class="form-label">क्या आप समीक्षक  प्राधिकारी द्वारा किये गए मूल्यांकन से सहमत हैं ?</label>
						<select name="agree_with_remark" id="agree_with_remark" class="form-control" onchange="action_acr_accept(this.value,'.$_POST['review_id'].')">
							<option value="">---</option>';
							if($record1['agree_with_remark']=='Yes'){
								$output .= '<option value="Yes" selected>हाँ</option>
									<option value="No">नहीं</option>';
							}else if($record1['agree_with_remark']=='No'){
								$output .= '<option value="Yes">हाँ</option>
									<option value="No" selected>नहीं</option>';
							}else{
								$output .= '<option value="Yes">हाँ</option>
									<option value="No">नहीं</option>';
							}
						$output .= '</select>
					</div>
					<div class="col-md-12 mb-3">
						<div class="row" id="accept_section_id">';
							if($shreni == 'A'){
								$shreni1 = 'A - उत्कृष्ट';
							}else if($shreni == 'B'){
								$shreni1 = 'B - अतिउत्तम';
							}else if($shreni == 'C'){
								$shreni1 = 'C - उत्तम';
							}else if($shreni == 'D'){
								$shreni1 = 'D - अच्छा';
							}else if($shreni == 'E'){
								$shreni1 = 'E - ख़राब';
							}else{
								$shreni1 = 'E - ख़राब';
							}
							if($record1['agree_with_remark']=='Yes'){
								$output .= '<div class="col-md-12">
										<hr>
										<div class="row">
											<div class="col-md-6">
												<label class="form-label">समग्र ग्रेड (अंक 1 से 10 तक)</label>
												<select name="overall_grade" id="overall_grade" class="form-control" required readonly>';
													for($i = 1; $i <= 10; $i++){
														if($overall_grade==$i){
															$output .='<option value="'.$i.'" selected>'.$i.'</option>';
														}else{
															$output .='<option value="'.$i.'">'.$i.'</option>';
														}
													}
												$output .='</select>
											</div>
											<div class="col-md-6">
												<label class="form-label">श्रेणी </label>
												<input type="hidden" name="shreni" id="shreni" value="'.$record['shreni'].'" class="form-control" readonly>
												<input type="text" value="'.$shreni1.'" class="form-control" readonly>';
											$output .='</div>
										</div>
									</div>';
							}else if($record1['agree_with_remark']=='No'){
								$output .='<div class="col-md-12">
										<hr>
										<label class="form-label">मत भिन्नता में सकारण विवरण अंकित किया जाये । (न्यूनतम 50 अक्षरों में )</label>
										<textarea name="diffrent_openion" class="form-control" rows="5" required onkeyup="countChar(this)">'.$record1['diffrent_openion'].'</textarea>
										<span id="charNum">50</span>
									</div>
									<div class="col-md-12">
										<hr>
										<div class="row">
											<div class="col-md-6">
												<label class="form-label">समग्र ग्रेड (अंक 1 से 10 तक)</label>
												<select name="overall_grade" id="overall_grade" class="form-control" onchange="action_count_grade(this.value)" required>';
													for($i = 1; $i <= 10; $i++){
														if($overall_grade==$i){
															$output .='<option value="'.$i.'" selected>'.$i.'</option>';
														}else{
															$output .='<option value="'.$i.'">'.$i.'</option>';
														}
													}
												$output .='</select>
											</div>
											<div class="col-md-6">
												<label class="form-label">श्रेणी </label>
												<input type="hidden" name="shreni" id="shreni" value="'.$record['shreni'].'" class="form-control" readonly>
												<input type="text" id="shreni1" value="'.$shreni1.'" class="form-control" readonly>';
											$output .='</div>
										</div>
									</div>';
							}
						$output .='</div>
					</div>
                    <div class="col-md-12 mb-3">
                        <input type="hidden" name="review_id" value="'.$_POST['review_id'].'">
                        <input type="hidden" name="accept_id" value="'.$_POST['accept_id'].'">
                        <input type="hidden" name="update_accept" value="update_accept">
                        <button type="submit" id="department_button" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>';
		echo $output;
	}	
}



if(isset($_POST['update_review'])){
	$review_id				= mysqli_real_escape_string($db->link, $_POST['review_id']);
	$employee_appraisal_id	= mysqli_real_escape_string($db->link, $_POST['employee_appraisal_id']);
	$agree_with_assestment	= mysqli_real_escape_string($db->link, $_POST['agree_with_assestment']);
	
	if($agree_with_assestment=='Yes'){
		$query4="select * from employee_appraisal where id='".$employee_appraisal_id."'";
		$row4=$db->select($query4);
		$record4=$row4->fetch_array();
		$overall_grade = $record4['overall_grade'];
		$shreni = $record4['shreni'];
		$diffrent_openion		= '';
		$additional_comment		= '';
	}else{
		if(isset($_POST['diffrent_openion'])){
			$diffrent_openion		= mysqli_real_escape_string($db->link, $_POST['diffrent_openion']);
		}else{
			$diffrent_openion		= '';
		}
		
		if(isset($_POST['overall_grade'])){
			$overall_grade		= mysqli_real_escape_string($db->link, $_POST['overall_grade']);
		}else{
			$overall_grade		= '';
		}
		
		if(isset($_POST['shreni'])){
			$shreni		= mysqli_real_escape_string($db->link, $_POST['shreni']);
		}else{
			$shreni		= '';
		}
	}
	
	$query="update employee_appraisal set is_updated='1' where id='$employee_appraisal_id'";
	$db->insert($query);
	
	$created_date = date("Y-m-d h:i:s A");
	$query="update review_appraisal set agree_with_assestment='$agree_with_assestment', diffrent_openion='$diffrent_openion', overall_grade='$overall_grade', shreni='$shreni', created_date='$created_date', is_updated='0' where employee_appraisal_id='$employee_appraisal_id' and id='$review_id'";
	if ($db->insert($query)) {
		echo "Success";
	}else{
		echo 'Something Went Wrong!';
	}
}


if(isset($_POST['update_accept'])){
	$review_id				= mysqli_real_escape_string($db->link, $_POST['review_id']);
	$accept_id				= mysqli_real_escape_string($db->link, $_POST['accept_id']);
	$agree_with_remark		= mysqli_real_escape_string($db->link, $_POST['agree_with_remark']);
	
	if($agree_with_remark=='Yes'){
		$query4="select * from review_appraisal where id='".$review_id."'";
		$row4=$db->select($query4);
		$record4=$row4->fetch_array();
		$overall_grade = $record4['overall_grade'];
		$shreni = $record4['shreni'];
		$diffrent_openion		= '';
		$additional_comment		= '';
	}else{
		if(isset($_POST['diffrent_openion'])){
			$diffrent_openion		= mysqli_real_escape_string($db->link, $_POST['diffrent_openion']);
		}else{
			$diffrent_openion		= '';
		}
		
		if(isset($_POST['overall_grade'])){
			$overall_grade		= mysqli_real_escape_string($db->link, $_POST['overall_grade']);
		}else{
			$overall_grade		= '';
		}
		
		if(isset($_POST['shreni'])){
			$shreni		= mysqli_real_escape_string($db->link, $_POST['shreni']);
		}else{
			$shreni		= '';
		}
	}
	$created_date = date("Y-m-d h:i:s A");
	$query="update acceptance_appraisal set agree_with_remark='$agree_with_remark', diffrent_openion='$diffrent_openion', overall_grade='$overall_grade', shreni='$shreni', created_date='$created_date' where review_appraisal_id='$review_id' and id='$accept_id'";
	if ($db->insert($query)) {
		echo "Success";
	}else{
		echo 'Something Went Wrong!';
	}
	
	$query="update review_appraisal set is_updated='1' where id='$review_id'";
	$db->insert($query);
	
}













