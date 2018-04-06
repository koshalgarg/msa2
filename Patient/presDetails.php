<?php
require('../../connect.php');
$req = mysqli_real_escape_string($conn, $_GET["pres_id"]);

$qry = "SELECT * FROM users WHERE name LIKE '%".$req."%' and type='2'";

$r = mysqli_query($conn, $qry);

$data = array();

if(mysqli_num_rows($r) > 0)
{
 while($row = mysqli_fetch_assoc($r))
 {
  $data[] = $row;
 }
 echo json_encode($data);
}

?>

