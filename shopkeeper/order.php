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
   			 <div class="navbar-header">
      			<a class="navbar-brand" href="shopowner.php">Shop Name</a>
    			</div>
    				<ul class="navbar-nav mr-auto">
      					<li  class="nav-item"><a class="nav-link"  href="index.php">Home</a></li>
     					  <li  class="nav-item"><a class="nav-link"  href="stock.php">Stock</a></li>
      					<li class="nav-item"><a class="nav-link"  href="customers.php">Customer</a></li>
      					<li class="nav-item"><a class="nav-link" href="Prescriptions.php">Prescriptions</a></li>
						<li class=" nav-item active"><a class="nav-link"  href="#">Order</a></li>
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
<div id="orderModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
        <h4 class="modal-title">Order Confirmation</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal-body">
        <p id="txt">Please Select Some items</p>
        <input type="text" name="sups" id="sups" tabindex="1" class="form-control input-sm" placeholder="Enter supplier name" autocomplete="off">
          <br/>
               <button type="button" class="btn btn-primary" id="f3" onclick="choose_sup()">Choose Supplier</button>
      

      </div>
      <div class="modal-footer">
       <button type="button" id="ok" class="btn btn-success"  data-dismiss="modal" onclick="place_order()">Confirm Order</button></a>
    <button type="button" id="cancel" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>  

<!-- Card -->
<div class="card mx-auto w-50 text-center" >
  <!-- Card body -->
  <div class="card-body">
  <h3 class="card-title">Add Items</h5>
     <form class="form" id="myForm">
        <div class="form-group">
          <div>
            <input type="text" name="meds" id="meds" tabindex="1" class="form-control input-sm" placeholder="Enter medicine name" autocomplete="off">
            <br>
            <input type="text" name="quantity" id="qty" tabindex="1" class="form-control input-sm"  placeholder="Quantity" >
            <br>
            
            <button type="button" tabindex="1" class=" text-center mt-4 indigo btn btn-primary center-block" id="addrow">Go</button>
          </div>
        </div>
      </form>
  </div>
  <!-- Card body -->

</div>
<!-- Card -->
                      
<br/>
<table id="olist" class="table table-bordered table-striped table-hover" >
  <thead class="thead-dark"  >
  <th class="text-center">Medicine Id</th>
    <th class="text-center">Medicine Name</th>
    <th class="text-center">Quantity</th>
    <th></th>
  </thead>
  <tbody id="o_body"></tbody>
</table>

<div class="text-center"> 

<button type="button" tabindex="1" class="btn btn-primary"  id="fetch" onclick="additems()">Place Order</button>
 </div>

                      
                      
</body>
<script type="text/javascript">
 var medicine_id="a";
var sendobj={};
//var pd=-1;
$(document).ready(function(){
  var i=1;
  $("#addrow").click(function(){
  //alert('hi');
    var med_name=$('#meds').val();
    //var words = str.split(" ");
    //var med_name=words[1];
    var qt=$('#qty').val();
    if (qt=="")
    {
      alert('Please Fill Some Quantity');
    }
    else
    {
      $('#olist').append('<tr id="addr'+(i)+'"></tr>');
      $('#addr'+i).html('<td>'+medicine_id+'</td><td>'+med_name+ '</td><td>'+qt+ '</td><td> <button type="button" id="b'+(i) +'"class="btn btn-default btn-sm"><span class="glyphicon glyphicon-remove"></span> Remove</button></td>');
      i++; 
      var form = document.getElementById("myForm");
      form.reset();
    }

  });
 
 $('#meds').typeahead({
	
  source: function(query, result)
  {
   $.ajax({
    url:"fetch_meds.php",
    method:"POST",
    data:{query:query},
    dataType:"json",
    success:function(data)
    {
      //var d2=JSON.parse(data)
      //alert(d2);
     result($.map(data, function(item){
      //pd=d2.product_id
      //medicine_id=item['name']
      return item;
     }));
    }
   })
  }

 });

$('#meds').change(function() {
  var current = $('#meds').typeahead("getActive");
   medicine_id=current['product_id'];
});

//important
$("#olist").on('click','button',function(){
  var id=this.id;
   $(this).closest('tr').remove();


});
 
});


function additems()
{

	var med_name=$('#meds').val();
  //var sup_name=$('#sups').val()
	var qt=$('#qty').val();
  jsonarr=[]
  var table = document.getElementById("olist");
  
  for (var i = 1, row; row = table.rows[i]; i++) 
  {
      pd=table.rows[i].cells[0].innerHTML;
      qt=table.rows[i].cells[2].innerHTML;
      obj={};
      obj["pid"]=pd; 
      obj["qty"]=qt;
      jsonarr.push(obj);  
  }
   sendobj["meds"]=JSON.stringify(jsonarr);
   sendobj["status"]="1";
   //sendobj["sup"]="for_testing";
   //var sendobj2=JSON.stringify(sendobj);
    //alert(sendobj2);
 

    if (table.rows.length<=1){
      $('#txt').css('visibility', 'visible');
      $('#sups').css('visibility', 'hidden');
      $('#f3').css('visibility', 'hidden');
      $('#ok').css('visibility', 'hidden');
      $('#orderModal').modal('show')
    } 
    else{
      $('#txt').css('visibility', 'hidden');
      $('#sups').css('visibility', 'visible');
      $('#f3').css('visibility', 'visible');
      $('#ok').css('visibility', 'visible');
      $('#orderModal').modal('show')
    }

	
}
 $('#sups').typeahead({
  
  source: function(query, result)
  {
   $.ajax({
    url:"fetch_sups.php",
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


 function choose_sup()
{
  sup_name=$('#sups').val();
  //console.log(sup_name);
  sendobj["sup"]=sup_name;
  
}

function place_order()
{

  //console.log(sendobj.meds[0].pid);
   //console.log(sendobj.meds[0].qty);
   var sendobj2=JSON.stringify(sendobj);
    //alert(sendobj2);
    $.ajax({
    url:"orderplace.php",
    method:"POST",
    data:{query:sendobj2},
    dataType:"json",
    success:function(data)
    {
    }
   });

  
}

</script>

<style>

.dropdown-menu {
 position:relative;
 width:100%;
 top: 0px !important;
    left: 0px !important;
}
</style>