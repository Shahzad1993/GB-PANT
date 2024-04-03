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
	<title>Attendance | GB Pant</title>
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
<?php
$lat_long ='';
$x = 1;
$title = 'Noida';
$langitude = '28.6078909';
$longitude = '77.3054884';

$center_lat = '28.6078909';
$center_long = '77.3054884';

$lat_long .= "['".$title."', ".$langitude.", ".$longitude.", ".$x."]";
?>

<script type="text/javascript">
	var locations = [<?php echo $lat_long; ?>];
	function InitMap() {
		var map = new google.maps.Map(document.getElementById('my_map'), {
			zoom: 13,
			center: new google.maps.LatLng(<?php echo $center_lat; ?>, <?php echo $center_long; ?>),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		var infowindow = new google.maps.InfoWindow();
		var marker, i;
		for (i = 0; i < locations.length; i++) {
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(locations[i][1], locations[i][2]),
				map: map
			});
			google.maps.event.addListener(marker, 'click', (function (marker, i) {
				return function () {
					infowindow.setContent(locations[i][0]);
					infowindow.open(map, marker);
				}
			})(marker, i));
		}
	}
</script> 
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBfkkKGSZZ4Y7wiFpo09j77-hLjq3AzPVY"></script>
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
                                        
                                        <div class="row pt-2">
											<div class="col-lg-4">
												<label>Employee Code</label>
												<input type="text" class="form-control block_special" onkeyup="action12(this.value)" placeholder="Employee Code" required="">
											</div>
											<!--div class="col-lg-12" id="my_map" style="height: 300px; width: 500px;"-->
											
										</div>
                                        
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
															</tr>
														</thead>
														<tbody id="attendance_list_data"></tbody>
													</table>
												</div> 
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
function action12(query12){
	if(query12 != ''){
	    var action12 = 'fetch_attendance';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action12:action12, query12:query12},
			success:function(data){
				//alert(data);
			    $('#attendance_list_data').html(data);
			}
		})
	}
}
</script> 
 
<script>
function action_map(query_map){
	if(query_map != ''){
	    var action_map = 'fetch_attendance_map';
		$.ajax({
			url:"query.php",
			method:"POST",
			data:{action_map:action_map, query_map:query_map},
			success:function(data){
				//alert(data);
				$('#map_data').html(data);
				$("#centermodal").modal('show');
			}
		})
	}
}
</script>  

<div class="modal fade" id="centermodal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myCenterModalLabel">Attendance Location</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row" id="map_data"></div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
    $(function () {
        $(".block_special").keypress(function (e) {
            var keyCode = e.keyCode || e.which;
			var regex = /^[0-9 A-Za-z_,]+$/;
			//var regex = /^[0-9]+$/;
			var isValid = regex.test(String.fromCharCode(keyCode));
            return isValid;
        });
    });
</script>

    </body>
</html>