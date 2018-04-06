<?php

require('../connect.php');
session_start();
if(!isset($_SESSION['email'])){
header('Location:../index.php');

}

$email=$_SESSION["email"];

?>
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
       <a href="../logout.php"> <button type="button" class="btn btn-default" >Confirm</button></a>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>

<input class="form-control" id="myInput" type="text" placeholder="Search..">
  <br>
  <script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>


<table class="table" id="myTable">
    <thead>
      <tr>

        <th>Date</th>
        <th>ShopKeeper</th>
        <th></th>
        
        
      </tr>
    </thead>
    <tbody>
<?php

$qry="SELECT * from bill b,users u where b.patient_id= '$email' and u.user_id=b.shop_id";


$r=mysqli_query($conn,$qry);


if ($r->num_rows > 0) 
{
   
   $var=1;
while($p = mysqli_fetch_assoc($r)) {
    
    ?>
          <tr class="active">
        <td><?php echo $p['date'] ?></td>    
      
        <td><?php echo $p['shop_id'] ?></td>
        <td><a href="viewBill.php?bill_id=<?php echo $p['bill_id']; ?> "><button type="button" id="b_<?php echo $p['bill_id']; ?>" class="btn btn-default btn-sm" ><span class="glyphicon glyphicon-remove"></span> view</button></td>
      

      </tr>




    <?php
    $var=$var+1;
  }

} 


?>



    </tbody>
  </table>


</body>
