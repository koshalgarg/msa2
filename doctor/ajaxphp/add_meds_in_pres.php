<?php
require('../../connect.php');
session_start();
$product_id = $_POST['product_id'];

$qty=$_POST['qty'];
$pres_id=$_SESSION['pres_id'];

$qry = "INSERT INTO `pres_meds` (`pres_id`, `product_id`, `quantity`, `purchased`) VALUES ('$pres_id', '$product_id', '$qty', '1');";

$r = mysqli_query($conn, $qry);

?>

