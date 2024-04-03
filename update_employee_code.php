<?php
include 'config/main.php';
$db = new Main;

$sql = "SELECT * FROM `employee`";
$exe = $db->select($sql);
while($record = $exe->fetch_array()){
	echo $qry = "update `login` set `employee_code`='".$record['employee_code']."' where mobile='".$record['phone']."' and employee_code IS NULL";
	$db->insert($qry);
}

//if ($exe->num_rows > 0) {
	

?>