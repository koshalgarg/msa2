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
header('Location:../index.php');
}

$email=$_SESSION['email'];
$pres_id=$_GET['pres_id']; 

  $qry="Select * from users u,prescriptions p where p.pres_id='$pres_id' AND u.user_id=p.patient_id"; 
  $t=mysqli_query($conn,$qry);
  $row=mysqli_fetch_assoc($t);

$qr2="SELECT * FROM pres_meds p,medicine m WHERE p.pres_id='$pres_id' and p.product_id=m.product_id"; 
  $t=mysqli_query($conn,$qr2);

 
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
                <li  class="nav-item active"><a class="nav-link"  href="#">Home</a></li>
                <li  class="nav-item"><a class="nav-link"  href="stock.php">Stock</a></li>
                <li class="nav-item"><a class="nav-link"  href="customers.php">Customer</a></li>
               
                <li class="nav-item"><a class="nav-link" href="Prescriptions.php">Prescriptions<span id="notif" class="badge"></span></a></li>

            <li class=" nav-item "><a class="nav-link"  href="order.php">Order</a></li>
            </ul>

            <a href="queryPhp/newBill.php"><button  type="button" class="btn btn-primary navbar-btn pull-right"  >New Bill</button> </a>

          
            <button  type="button" class="btn btn-danger navbar-btn pull-right" data-toggle="modal" data-target="#myModal">Logout</button> 
          </div>
  </nav>
	


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
              <th>Sl.No</th>
              <th>Name</th>
              <th>Quantity</th>
              
            </tr>
        </thead>
        <tbody id="tbody">
  <?php 
  $var=1;
if(mysqli_num_rows($t) > 0)
{
 while($row = mysqli_fetch_assoc($t))
 {
    ?>
        <tr>
        <td><?php echo $var;?></td> 
        <td><?php echo $row['name'] ?></td>    
        <td><?php echo $row['quantity'] ?></td>


      </tr>
   <?php
    $var=$var+1;
 }

}
?>


      </tbody>
        </table>


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


  <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Logout Confirmation</h4>
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

<div id="table_div">
 
 <?php
include('bill_show.php');
 ?>
 
</div>

</body>

<script type="text/javascript">

$(document).ready(function(){

  $("#name").focus();


 $('#name').typeahead({

  source: function(query, result)
  {
   $.ajax({
    url:"ajaxphp/fetch_customer_details.php",
    method:"POST",
    data:{query:query},
    dataType:"json",
    success:function(data)
    {
     result($.map(data, function(item){
      return item;
     }));
    }
   })
  }

 });

$('#name').change(function() {
    var current = $('#name').typeahead("getActive");
    $('#email').val(current['user_id']);
    $('#address').val(current['address']);

    
    $.ajax({
    url:"ajaxphp/update_user_in_bill.php",
    method:"POST",
    data: {'user_id':current['user_id']}
    });
});

 $('#meds_name').typeahead({

  source: function(query, result)
  {
   $.ajax({
    url:"ajaxphp/fetch_meds.php",
    method:"POST",
    data:{query:query},
    dataType:"json",
    success:function(data)
    {
     result($.map(data, function(item){
     return item;
     }));
    }
   })
  }

 });

 /*$('#add').click(function() {

    


});
*/
 $("#table_div").on('click','.remove',function(){
    $.ajax({
    url:"ajaxphp/remove_meds_in_bill.php",
    method:"POST",
    data: {'id':this.id},
    success:function(data)
    {
      updateTable();
    }
    });
});


$('#date').change(function() {
  
  var date = new Date($('#date').val());
  day = date.getDate();
  month = date.getMonth() + 1;
  year = date.getFullYear();
  date=[year, month, day].join('-');
  date=document.getElementById("date").value;

    $.ajax({
    url:"ajaxphp/update_date_in_bill.php",
    method:"POST",
    data: {'date':date}
    });

});


 
});

function updateTable(){
 $.ajax({
    url:"bill_show.php",
    success:function(data)
    {
      $("#table_div").html(data);
    }
   });
}


function addMeds(){
var current = $('#meds_name').typeahead("getActive");
var qty=$("#qty").val();
var stock=current['quantity'];


if(qty=="0" || qty==""){
  return false;
}
/*if(qty>stock){
  alert("aa");
  return false;
}*/
    var id=current['product_id'];
    var batch_no=current['batch_no'];

     $.ajax({
    url:"ajaxphp/add_meds_in_bill.php",
    method:"POST",
    data: {'product_id':id,'batch_no':batch_no, 'qty':qty },
    success:function(data)
    {
      updateTable();
      document.getElementById("new_med").reset();

      $("#meds_name").focus();

    }
    });

     return false;
}

function billPay(){


total=$("#total").html();
paid=document.getElementById("paid").value;


window.location = "ajaxphp/update_total_in_bill.php?total="+total+"&paid="+paid;

}

setInterval(function() {
 

  $.ajax({
    url:"ajaxphp/prescription_notification.php",
     method:"POST",
    data: {'product_id':"1"},
   
    success:function(data)
    {
      /*if(data.localeCompare("0")){
      document.getElementById("notif").innerHTML='';
        }
        else{*/
      document.getElementById("notif").innerHTML=data;
          
        //}
    }
    });




}, 3000);


</script>