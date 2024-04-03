<?php 
include 'config/main.php';
$db = new Main;

$from_date		= mysqli_real_escape_string($db->link, $_POST['from_date']);
$to_date		= mysqli_real_escape_string($db->link, $_POST['to_date']);
$work_location	= mysqli_real_escape_string($db->link, $_POST['work_location']);

if($work_location=='Division' || $work_location=='Deport'){
	if($_POST['office_name']!=''){
		
		for($i=$to_date; $i >= $from_date; ($i = date('Y-m-d', strtotime('-1 days', strtotime($i))))){
			if(date('D',strtotime($i))=='Sun'){
				$dates[] ='Sun';
			}else{
				$query4 = "SELECT * FROM `holiday` where date='".$i."'";
				$row4 = $db->select($query4);
				if ($row4->num_rows > 0) {
					$dates[] ='Holiday';
				}else{
					$dates[] = date("d M",strtotime($i));
				}
			}
		}
		
		$delimiter = ","; 
		$filename = "export-lottary-Data_" . date('Y-m-d-h-i') . ".csv";
		$f = fopen('php://memory', 'w'); 
		$fields1 = array('#', 'Employee Code', 'Employee Name'); 
		$fields = array_merge($fields1,$dates);
		
		fputcsv($f, $fields, $delimiter); 
		$z=1;
		$query = "SELECT * FROM `employee` where work_location='".$_POST['work_location']."' and office_name='".$_POST['office_name']."'";
		$row = $db->select($query);
		if ($row->num_rows > 0) {
			while($record = $row->fetch_array()){
				$attendance = array();
				$query1 = "SELECT * FROM `post` where id='".$record['post']."'";
				$row1 = $db->select($query1);
				$record1 = $row1->fetch_array();
				
				for($i=$to_date; $i >= $from_date; ($i = date('Y-m-d', strtotime('-1 days', strtotime($i))))){
					$query2 = "SELECT * FROM `attendance` where employee='".$record['phone']."' and attendance_date='".$i."'";
					$row2 = $db->select($query2);
					if ($row2->num_rows > 0) {
						$record2 = $row2->fetch_array();
						
						if($record2['check_out']==NULL){
							$status = 'PE';
						}else{
							$status = 'P';
						}
					}else{
						$query3 = "SELECT * FROM `leave_request` where from_date<='".$i."' and to_date>='".$i."' and employee='".$record['phone']."' and is_approved='1'";
						$row3 = $db->select($query3);
						if ($row3->num_rows > 0) {
							$status = 'L';
						}else{
							$status = 'A';
						}
					}
					
					if(date('D',strtotime($i))=='Sun'){
						$attendance[] = '--';
					}else{
						$query4 = "SELECT * FROM `holiday` where date='".$i."'";
						$row4 = $db->select($query4);
						if ($row4->num_rows > 0) {
							$attendance[] = '--';
						}else{
							$attendance[] = $status;
						}
					}
				}
				$lineData1 = array($z, $record['employee_code'], $record['employee_name']); 
				$lineData = array_merge($lineData1,$attendance);
				fputcsv($f, $lineData, $delimiter); 
				$z++;
			}
			fseek($f, 0); 
			header('Content-Type: text/csv'); 
			header('Content-Disposition: attachment; filename="' . $filename . '";'); 
			fpassthru($f); 
		}else{
			echo "Data Not Found!";
		}
	}else{
		echo "Data Not Found!";
	}
}else{
	for($i=$to_date; $i >= $from_date; ($i = date('Y-m-d', strtotime('-1 days', strtotime($i))))){
		if(date('D',strtotime($i))=='Sun'){
			$dates[] ='Sun';
		}else{
			$query4 = "SELECT * FROM `holiday` where date='".$i."'";
			$row4 = $db->select($query4);
			if ($row4->num_rows > 0) {
				$dates[] ='Holiday';
			}else{
				$dates[] = date("d M",strtotime($i));
			}
		}
	}
	
	$delimiter = ","; 
	$filename = "export-lottary-Data_" . date('Y-m-d-h-i') . ".csv";
	$f = fopen('php://memory', 'w'); 
	$fields1 = array('#', 'Employee Code', 'Employee Name'); 
	$fields = array_merge($fields1,$dates);
	
	fputcsv($f, $fields, $delimiter); 
	$z=1;
	$query = "SELECT * FROM `employee` where work_location='".$_POST['work_location']."'";
	$row = $db->select($query);
	if ($row->num_rows > 0) {
		while($record = $row->fetch_array()){
			$attendance = array();
			$query1 = "SELECT * FROM `post` where id='".$record['post']."'";
			$row1 = $db->select($query1);
			$record1 = $row1->fetch_array();
			
			for($i=$to_date; $i >= $from_date; ($i = date('Y-m-d', strtotime('-1 days', strtotime($i))))){
				$query2 = "SELECT * FROM `attendance` where employee='".$record['phone']."' and attendance_date='".$i."'";
				$row2 = $db->select($query2);
				if ($row2->num_rows > 0) {
					$record2 = $row2->fetch_array();
					
					if($record2['check_out']==NULL){
						$status = 'PE';
					}else{
						$status = 'P';
					}
				}else{
					$query3 = "SELECT * FROM `leave_request` where from_date<='".$i."' and to_date>='".$i."' and employee='".$record['phone']."' and is_approved='1'";
					$row3 = $db->select($query3);
					if ($row3->num_rows > 0) {
						$status = 'L';
					}else{
						$status = 'A';
					}
				}
				
				if(date('D',strtotime($i))=='Sun'){
					$attendance[] = '--';
				}else{
					$query4 = "SELECT * FROM `holiday` where date='".$i."'";
					$row4 = $db->select($query4);
					if ($row4->num_rows > 0) {
						$attendance[] = '--';
					}else{
						$attendance[] = $status;
					}
				}
			}
			$lineData1 = array($z, $record['employee_code'], $record['employee_name']); 
			$lineData = array_merge($lineData1,$attendance);
			fputcsv($f, $lineData, $delimiter); 
			$z++;
		}
		fseek($f, 0); 
		header('Content-Type: text/csv'); 
		header('Content-Disposition: attachment; filename="' . $filename . '";'); 
		fpassthru($f); 
	}else{
		echo "Data Not Found!";
	}
}
