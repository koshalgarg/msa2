<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
 <link href="typeaheadjs.css" rel="stylesheet">

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <script src="../js/typeahead.js"></script>
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.0/css/mdb.min.css" rel="stylesheet">
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.0/js/mdb.min.js"></script>


</head>

<body>
  
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
       <!--  <div class="navbar-header">
            <a class="navbar-brand" href="shopowner.php">Shop Name</a>
          </div> -->
            <ul class="navbar-nav mr-auto">
                <li  class="nav-item active"><a class="nav-link"  href="#">Home</a></li>
                <li  class="nav-item"><a class="nav-link"  href="doctors.php">Doctors</a></li>
                <li class="nav-item"><a class="nav-link"  href="credits.php">Credits</a></li>
            </ul>

            <button  type="button" class="btn btn-danger navbar-btn pull-right" data-toggle="modal" data-target="#myModal">Logout</button> 
          </div>
  </nav>
  
  
<div id="myModal" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
        <h4 class="modal-title">Logout Confirmation</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you surely want to logout?.</p>
      </div>
      <div class="modal-footer">
       <a href="/msa/logout.php"> <button type="button" class="btn btn-default" >Confirm</button></a>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>


<?php
require('../connect.php');
session_start();
$uid=$_SESSION['email'];
$req = mysqli_real_escape_string($conn, $_GET["bill_id"]);

$qr1 = "SELECT * FROM bill WHERE bill_id='".$req."' and patient_id='".$uid."'";

$r = mysqli_query($conn, $qr1);



if(mysqli_num_rows($r) > 0)
{?>

<table class="table" id="myTable">
    <thead>
      <tr>

        <th>Medicine Name</th>
        <th>Quantity</th>
        
        
        
      </tr>
    </thead>
    <tbody>
<?php
$qr2 = "SELECT * FROM bill_medicine b,medicine m WHERE bill_id='".$req."' and b.product_id=m.product_id";
$r2 = mysqli_query($conn, $qr2);

 $data = array();	
 while($row = mysqli_fetch_assoc($r2))
 {?>
 	<tr class="active">
     <td><?php echo $row['name'] ?></td>    
     <td><?php echo $row['qty'] ?></td>
   </tr>
 <?php 
}

 echo "</tbody>";
 echo "</table>";
 while($rz = mysqli_fetch_assoc($r))
 {
 	$var=$rz['total'];
 	$v2=$rz['paid'];
 }
 echo "<div class='card mx-auto w-50 text-center'>";
 echo "<div class='card-body'>";
 echo "<h4 class='text-primary text-center'>Total Amount = ".$var."</h4>";
 echo "<h4 class='text-primary text-center'>Amount Paid = ".$v2."</h4>";
  echo "</div>"; 
 
echo "</div>";


}
else
{
	echo "<h1>Wrong Details</h1>";
}

?>
 
</body>