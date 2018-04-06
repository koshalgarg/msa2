<?php
require('../../connect.php');
session_start();


$shop_id=$_SESSION['email'];

$qry = "select count(pres_id) as cnt from prescriptions WHERE shop_id='$shop_id' and seen='0'";

$cnt=0;
$r = mysqli_query($conn, $qry);
if(@mysqli_num_rows($r) > 0)
{

$p=mysqli_fetch_assoc($r);
$cnt=$p['cnt'];

}

echo $cnt;

?>

