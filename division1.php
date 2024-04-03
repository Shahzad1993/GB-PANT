<?php
if(empty($_POST)){
    header("Location: view-division");
}

include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}

if(isset($_POST['id'])){
	$query="select * from division where id='".base64_decode($_POST['id'])."'";
	$row=$db->select($query);
	$record=$row->fetch_array();
	
	$location = $record['location'];
	
	if($record['lat_long']=='' || $record['lat_long']==NULL){
		$location = '';
		$lat = '30.290817';
		$lng = '78.053192';
	}else{
		$lat_long = explode(',',$record['lat_long']);
	
		$lat = $lat_long[0];
		$lng = $lat_long[1];
	}
	$id = $_POST['id'];
}else{
	$location = '';
	$lat = '30.290817';
	$lng = '78.053192';
	$id = '';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>College | GB Pant</title>
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
<style>
#pac-input{
	height: 40px;
	font-size: 16px;
	margin-top: 11px;
	padding: 5px 10px;
	width: 400px;
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
                                    <h4 class="page-title">New College</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">College</a></li>
                                            <li class="breadcrumb-item active">New College</li>
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
										<form action="division" method="POST">
											<div class="row form-group">
												<div class="col-md-12 mb-3">
													<?php
													if(isset($_SESSION['message'])){
													?>
														<span class="text-danger"><?= $_SESSION['message'] ?></span><br />
													<?php
														unset($_SESSION['message']);
													}
													?>
													
													<label style="margin-bottom: 10px;">Collage Location</label><br />
												
													<input id="pac-input" class="controls block_special" value="<?= $location; ?>" type="text" placeholder="Start typing a location..." required>
													<div id="map" style="height: 450px;width: 100%"></div>
													
													<input type="hidden" name="id" value="<?= $id; ?>" required>
													<input type="hidden" name="lat" id="lat" value="<?= $lat; ?>" required>
													<input type="hidden" name="lng" id="lng" value="<?= $lng; ?>" required>
													<input type="hidden" name="location" id="location" value="<?= $location; ?>" required>
												</div>
											</div>
                                            <!--input type="hidden" name="add_division" value="add_division"-->
                                            <button class="btn btn-primary" type="submit">Next</button>
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
		
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBfkkKGSZZ4Y7wiFpo09j77-hLjq3AzPVY&libraries=places&callback=initMap" async defer></script>

<script>
	function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {
            lat: <?= $lat ?>,
			lng: <?= $lng ?>
		  },
          zoom: 18
        });
        var input = /** @type {!HTMLInputElement} */(
            document.getElementById('pac-input'));

        var types = document.getElementById('type-selector');
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({
          map: map,
          anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener('place_changed', function() {
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();

          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          marker.setIcon(/** @type {google.maps.Icon} */({
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
          }));
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);
		
			var item_Lat =place.geometry.location.lat()
			var item_Lng= place.geometry.location.lng()
			var item_Location = place.formatted_address;
			
		//alert("Lat= "+item_Lat+"_____Lang="+item_Lng+"_____Location="+item_Location);
        $("#lat").val(item_Lat);
        $("#lng").val(item_Lng);
        $("#location").val(item_Location);
          var address = '';
          if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }

          infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
          infowindow.open(map, marker);
        });

        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, types) {
          var radioButton = document.getElementById(id);
          radioButton.addEventListener('click', function() {
            autocomplete.setTypes(types);
          });
        }

        setupClickListener('changetype-all', []);
        setupClickListener('changetype-address', ['address']);
        setupClickListener('changetype-establishment', ['establishment']);
        setupClickListener('changetype-geocode', ['geocode']);
      }
	  
	  
    </script>
    

<script type="text/javascript">
    $(function () {
        $(".block_special").keypress(function (e) {
            var keyCode = e.keyCode || e.which;
			var regex = /^[0-9 A-Za-z_,]+$/;
			var isValid = regex.test(String.fromCharCode(keyCode));
            return isValid;
        });
    });
</script>
      
    </body>
</html>