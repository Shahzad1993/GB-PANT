<?php
include 'config/main.php';
$db = new Main;
	//print_invoice.php
	//if(isset($_REQUEST["id"]))
	//{
	 require_once 'pdf.php';
	 
	 
	
	/*echo $query11="select * from self_appraisal where id='".$_REQUEST['id']."'";
	$row11=$db->select($query11);
	$record11=$row11->fetch_array();

	/*if(file_exists($record11['award'])){
		$award = '<img src="'.$record11['award'].'" style="width:50%">';
	}else{
		$award = '';
	}

	$query="select * from acr where id='".$record11['acr_id']."'";
	$row=$db->select($query);
	$record=$row->fetch_array();

	$query1="select employee_name,employee_code,phone from employee where employee_code='".$record11['employee']."'";
	$row1=$db->select($query1);
	$record1=$row1->fetch_array();

	$query2="select post_name,post_name_en from post where id='".$record['present_post']."'";
	$row2=$db->select($query2);
	$record2=$row2->fetch_array();*/
	
	 
	 $output = '';
	 
	 $pdf = new Pdf();
	 $file_name = 'ACR.pdf';
	 $pdf->loadHtml($output);
	 $pdf->render();
	 $pdf->stream($file_name, array("Attachment" => false));
	//}
?>