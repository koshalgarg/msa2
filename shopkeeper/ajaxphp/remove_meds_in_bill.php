<?php
require('../../connect.php');
session_start();
$id = $_POST['id'];
$bill_id=$_SESSION['bill_id'];


$qry = "delete from bill_medicine where id='$id'";

$r = mysqli_query($conn, $qry);
?>

