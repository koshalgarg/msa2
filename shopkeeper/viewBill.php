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

<?php

require('../connect.php');
session_start();
if(!isset($_SESSION['email'])){
header('Location:/msa/index.php');

}

$email=$_SESSION["email"];
$bill_id=$_GET['bill_id'];

$qry = "select * from bill where bill_id='$bill_id' AND shop_id='$email'";
$t=mysqli_query($conn,$qry);

if ($t->num_rows == 0) 
{
  ?>
  <div style="margin: 50px" class="alert alert-danger">
  <strong>Wrong Bill ID</strong> 
</div>
  <?php
  die("");

}


?>


<body>
	
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <div class="navbar-header">
            <a class="navbar-brand" href="index.php">Shop Name</a>
          </div>
            <ul class="navbar-nav mr-auto">
                <li  class="nav-item "><a class="nav-link"  href="index.php">Home</a></li>
                <li  class="nav-item"><a class="nav-link"  href="stock.php">Stock</a></li>
                <li class="nav-item active"><a class="nav-link"  href="customers.php">Customer</a></li>
                <li class="nav-item"><a class="nav-link" href="doctors.php">Doctors</a></li>
                <li class="nav-item"><a class="nav-link" href="bills.php">Bills</a></li>
                <li class="nav-item"><a class="nav-link" href="Prescriptions.php">Prescriptions</a></li>
            <li class=" nav-item "><a class="nav-link"  href="order.php">Order</a></li>
            </ul>

          
            <button  type="button" class="btn btn-danger navbar-btn pull-right" data-toggle="modal" data-target="#myModal">Logout</button> 
          </div>
  </nav>
  
  
  <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        
        <h4 class="modal-title">Logout Confirmation</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
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

  $qry="Select * from users u,bill b where b.bill_id='$bill_id' AND u.user_id=b.patient_id"; 
  $t=mysqli_query($conn,$qry);
  $row=mysqli_fetch_assoc($t);

   ?>

  <div class="container-fluid">
    
    <h5>Name       :<?php echo $row['name']; ?></h5> 
    <h5>Email      :<?php echo $row['user_id']; ?></h5> 
    <h5>Address    :<?php echo $row['address']; ?></h5> 
    <h5>Contact No :<?php echo $row['contact_no']; ?></h5> 
    <h5>Date       :<?php echo $row['date']; ?></h5>
    

  </div>

  <table class="table" id="myTable">
    <thead>
      <tr>

        <th>Name</th>
        <th>Batch No</th>
        <th>MFD</th>
        <th>EXP Date</th>
        <th>MRP</th>
        <th>Quantity</th>
        <th>Amount</th>
        
        
        
      </tr>
    </thead>
    <tbody id="tbody">
<?php

$qry=" Select m.name,bm.batch_no as bno,b.mfd,b.expd,b.mrp, bm.qty   from bill_medicine bm,medicine m, batch b  where bm.bill_id='$bill_id' AND bm.product_id=m.product_id AND b.product_id= bm.product_id AND bm.batch_no=b.batch_no ";


$r=mysqli_query($conn,$qry);
$total=0;


if ($r->num_rows > 0) 
{
   
   $var=1;
while($p = mysqli_fetch_assoc($r)) {
    
    ?>
        <tr>
        <td><?php echo $p['name'] ?></td>    
        <td><?php echo $p['bno'] ?></td>
        <td><?php echo $p['mfd'] ?></td>
        <td><?php echo $p['expd'] ?></td>
        <td><?php echo $p['mrp'] ?></td>
        <td><?php echo $p['qty'] ?></td>
        <td><?php $total=$total+$p['qty']*$p['mrp'];  echo $p['qty']*$p['mrp'] ?></td>
        
          
      </tr>




    <?php
    $var=$var+1;
  }

} 


?>

 <tr>
        <td></td>    
        <td></td>    
        <td></td>    
        <td></td>    
        <td></td>    
        <td></td>    
      
        <td><?php echo $total; ?></td>
        
          
      </tr>



    </tbody>
  </table>









	





</body>

