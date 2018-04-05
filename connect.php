
<?php
$servername = "localhost";
$username = "root";
$password = "";
$db="msa";

// Create connection
$conn = mysqli_connect($servername, $username, $password,$db);

// Check connection
if (!$conn) {
	die("Connection failed: " );
	
}
    

?>