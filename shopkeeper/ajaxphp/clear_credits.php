<?php

require_once("../../connect.php");
session_start();

if(!isset($_SESSION['email'])){
	die("error");
}

$email=$_POST['patient_id'];


$qry="update patient p set `paid`=`total` where `patient_id`='$email' ";
$r=mysqli_query($conn,$qry);
if ($r)
{
	echo "1";
}


?>