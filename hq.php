<?php
if(empty($_POST)){
    header("Location: view-hq");
}

include 'config/main.php';
$db = new Main;

if(empty($_SESSION['astro_email'])){
	header("Location: ./");
}

if(empty($_POST['lat']) && empty($_POST['lng'])){
	$_SESSION['message'] = "Please Select Correct Location!";
	header("Location: hq1");
}

if($_POST['id']!=''){
	$query="select * from head_quarter where id='".base64_decode($_POST['id'])."'";
	$row=$db->select($query);
	if ($row->num_rows > 0) {
		$record=$row->fetch_array();
		
		$division = $record['hq'];
		$id = $record['id'];
		
		$query1="select * from login where mobile='".$record['phone']."'";
		$row1=$db->select($query1);
		if ($row1->num_rows > 0) {
			$record1=$row1->fetch_array();
			$email = $record['email'];
			$mobile = $record1['mobile'];
			$password = $record1['core_pass'];
		}else{
			$email = '';
			$mobile = '';
			$password = '';
		}
		$is_save = 'update_hq';
		
		if($record['lat_long']=='' || $record['lat_long']==NULL){
			$location = '';
			$lat = '30.290817';
			$lng = '78.053192';
		}else{
			$lat_long = explode(',',$record['lat_long']);
		
			$lat = $lat_long[0];
			$lng = $lat_long[1];
		}
	}else{
		$division = '';
		$email = '';
		$password = '';
		
		$id = '';
		
		$is_save = 'add_division';
		
		$location = '';
		$lat = '30.290817';
		$lng = '78.053192';
	}	
}else{
	$division = '';
	$email = '';
	$password = '';
	
	$id = '';
	
	$is_save = 'add_division';
	
	$lat = $_POST['lat'];
	$lng = $_POST['lng'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Headquarter | UKPN</title>
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
                                    <h4 class="page-title">Headquarter</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Headquarter</a></li>
                                            <li class="breadcrumb-item active">Headquarter</li>
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
                                        <form id="department_form" class="needs-validation" novalidate>
											<div class="row">
												<div class="col-md-4 mb-3">
													<label class="form-label">Headquarter</label>
													<input type="text" name="division" value="<?= $division; ?>" class="form-control block_special" placeholder="Headquarter" required>
												</div>
												<div class="col-md-4 mb-3">
													<label class="form-label">Phone</label>
													<input type="text" name="mobile" value="<?= $mobile; ?>" class="form-control allow_number" maxlength="10" placeholder="Phone" required>
												</div>
												<div class="col-md-4 mb-3">
													<label class="form-label">Email</label>
													<input type="email" name="email" value="<?= $email; ?>" class="form-control allow_email" placeholder="Email" required>
												</div>
												<!--div class="col-md-3 mb-3">
													<label class="form-label">Password</label>
													<input type="text" name="password" value="<?= $password; ?>" class="form-control" placeholder="******" required>
												</div-->
												
												
												<div class="col-md-12 mb-3" id="map-canvas" style="height: 400px; width: 100%"></div>
												
											</div>
											<input type="hidden" name="id" value="<?= $id; ?>">
                                            <input type="hidden" name="location" value="<?= $_POST['location']; ?>">
                                            <input type="hidden" name="lat_long" id="info">
                                            <input type="hidden" name="<?= $is_save; ?>" value="<?= $is_save; ?>">
                                            <button id="department_button" class="btn btn-primary" type="submit">Save</button>
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
		</div>
        <!-- END wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
		<script src="assets/js/vendor.min.js"></script>
		<script src="assets/libs/parsleyjs/parsley.min.js"></script>
		<script src="assets/js/pages/form-validation.init.js"></script>
		<script src="assets/js/app.min.js"></script>
		
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBfkkKGSZZ4Y7wiFpo09j77-hLjq3AzPVY&libraries=drawing"></script>
		<!--script src="assets/js/drawMap.js"></script-->

<script type="text/javascript">
    $(function () {
        $(".block_special").keypress(function (e) {
            var keyCode = e.keyCode || e.which;
			var regex = /^[0-9 A-Za-z_,.@]+$/;
			//var regex = /^[0-9]+$/;
			var isValid = regex.test(String.fromCharCode(keyCode));
            return isValid;
        });
    });
</script>

<script type="text/javascript">
    $(function () {
        $(".allow_number").keypress(function (e) {
            var keyCode = e.keyCode || e.which;
			var regex = /^[0-9]+$/;
			//var regex = /^[0-9]+$/;
			var isValid = regex.test(String.fromCharCode(keyCode));
            return isValid;
        });
    });
</script>

<script type="text/javascript">
    $(function () {
        $(".allow_email").keypress(function (e) {
            var keyCode = e.keyCode || e.which;
			var regex = /^[0-9A-Za-z.@]+$/;
			var isValid = regex.test(String.fromCharCode(keyCode));
            return isValid;
        });
    });
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
				$('#department_button').html('Please Wait...');
			},
			success:function(data){
				//alert(data);
				if(data=='Success'){
					$('#message').html('<p class="text-success">University Added Successfully!</p>');
					$('#department_form')[0].reset();
				}else if(data=='Success1'){
					$('#message').html('<p class="text-success">University Updated Successfully!</p>');
				}else{
					$('#message').html('<p class="text-danger">'+data+'</p>');
				}
				$('#department_button').html('Save');
			}
		});
	});
});
</script>

<script>
var mapOptions;
var map;

var coordinates = []
let new_coordinates = []
let lastElement

function InitMap() {
    var location = new google.maps.LatLng(<?= $lat; ?>, <?= $lng; ?>)
    mapOptions = {
        zoom: 18,
        center: location,
        mapTypeId: google.maps.MapTypeId.RoadMap
    }
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	
	var all_overlays = [];
    var selectedShape;
    var drawingManager = new google.maps.drawing.DrawingManager({
        //drawingMode: google.maps.drawing.OverlayType.MARKER,
        //drawingControl: true,
        drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: [
                //google.maps.drawing.OverlayType.MARKER,
                //google.maps.drawing.OverlayType.CIRCLE,
                google.maps.drawing.OverlayType.POLYGON,
                //google.maps.drawing.OverlayType.RECTANGLE
            ]
        },
        markerOptions: {
            //icon: 'images/beachflag.png'
        },
        circleOptions: {
            fillColor: '#ffff00',
            fillOpacity: 0.2,
            strokeWeight: 3,
            clickable: false,
            editable: true,
            zIndex: 1
        },
        polygonOptions: {
            clickable: true,
            draggable: false,
            editable: true,
            // fillColor: '#ffff00',
            fillColor: '#55ff00',
            fillOpacity: 0.5,

        },
        rectangleOptions: {
            clickable: true,
            draggable: true,
            editable: true,
            fillColor: '#ffff00',
            fillOpacity: 0.5,
        }
    });

    function clearSelection() {
        if (selectedShape) {
            selectedShape.setEditable(false);
            selectedShape = null;
        }
    }
    //to disable drawing tools
    function stopDrawing() {
        drawingManager.setMap(null);
    }

    function setSelection(shape) {
        clearSelection();
        stopDrawing()
        selectedShape = shape;
        shape.setEditable(true);
    }

    function deleteSelectedShape() {
        if (selectedShape) {
            selectedShape.setMap(null);
            drawingManager.setMap(map);
            coordinates.splice(0, coordinates.length)
            //document.getElementById('info1').innerHTML = ""
            document.getElementById('info').value = ""
        }
    }

    function CenterControl(controlDiv, map) {

        // Set CSS for the control border.
        var controlUI = document.createElement('div');
        controlUI.style.backgroundColor = '#fff';
        controlUI.style.border = '2px solid #fff';
        controlUI.style.borderRadius = '3px';
        controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
        controlUI.style.cursor = 'pointer';
        controlUI.style.marginBottom = '22px';
        controlUI.style.textAlign = 'center';
        controlUI.title = 'Select to delete the shape';
        controlDiv.appendChild(controlUI);

        // Set CSS for the control interior.
        var controlText = document.createElement('div');
        controlText.style.color = 'rgb(255,0,0)';
        controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
        controlText.style.fontSize = '14px';
        controlText.style.lineHeight = '30px';
        controlText.style.paddingLeft = '5px';
        controlText.style.paddingRight = '5px';
        controlText.innerHTML = 'Delete Selected Area';
        controlUI.appendChild(controlText);

        //to delete the polygon
        controlUI.addEventListener('click', function () {
            deleteSelectedShape();
        });
    }

    drawingManager.setMap(map);

    var getPolygonCoords = function (newShape) {

        coordinates.splice(0, coordinates.length)

        var len = newShape.getPath().getLength();

        for (var i = 0; i < len; i++) {
            coordinates.push(newShape.getPath().getAt(i).toUrlValue(6))
        }
        //document.getElementById('info1').innerHTML = coordinates
        document.getElementById('info').value = coordinates
    }

    google.maps.event.addListener(drawingManager, 'polygoncomplete', function (event) {
        event.getPath().getLength();
        google.maps.event.addListener(event, "dragend", getPolygonCoords(event));

        google.maps.event.addListener(event.getPath(), 'insert_at', function () {
            getPolygonCoords(event)
            
        });

        google.maps.event.addListener(event.getPath(), 'set_at', function () {
            getPolygonCoords(event)
        })
    })

    google.maps.event.addListener(drawingManager, 'overlaycomplete', function (event) {
        all_overlays.push(event);
        if (event.type !== google.maps.drawing.OverlayType.MARKER) {
            drawingManager.setDrawingMode(null);

            var newShape = event.overlay;
            newShape.type = event.type;
            google.maps.event.addListener(newShape, 'click', function () {
                setSelection(newShape);
            });
            setSelection(newShape);
        }
    })

    var centerControlDiv = document.createElement('div');
    var centerControl = new CenterControl(centerControlDiv, map);

    
    centerControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(centerControlDiv);

}

InitMap();
</script>


      
    </body>
</html>