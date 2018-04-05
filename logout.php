<?php
session_start();
unset($_SESSION['email']);
unset($_SESSION['usertype']);

header("Location:index.php");
exit;


?>