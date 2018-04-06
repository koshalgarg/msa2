<?php
session_start();
unset($_SESSION['email']);
unset($_SESSION['usertype']);
if(isset($_SESSION['bill_id']))
{
	unset($_SESSION['bill_id']);
}
if(isset($_SESSION['pres_id'])){
	unset($_SESSION['pres_id']);
}

header("Location:index.php");
exit;


?>