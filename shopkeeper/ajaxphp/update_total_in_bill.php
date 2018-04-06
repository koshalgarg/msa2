<?php
require('../../connect.php');
session_start();
$total = $_GET['total'];
$paid=$_GET['paid'];
$bill_id=$_SESSION['bill_id'];
$shop_id=$_SESSION['email'];


$qry="update stock s ,bill_medicine bm set s.quantity=s.quantity-bm.qty WHERE s.shop_id='$shop_id' AND bm.bill_id='$bill_id' AND S.product_id=BM.product_id AND s.batch_no=bm.batch_no";

$r = mysqli_query($conn, $qry);

$qry = "update  bill set total='$total', paid='$paid', processed='1'  where bill_id='$bill_id'";

$r = mysqli_query($conn, $qry);

unset($_SESSION['bill_id']);
header("Location:../index.php");

?>

