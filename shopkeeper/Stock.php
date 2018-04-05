<?php
require('../connect.php');
session_start();
if(!isset($_SESSION['email'])){
header('Location:/msa/index.php');

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
                <li  class="nav-item active"><a class="nav-link"  href="#">Stock</a></li>
                <li class="nav-item"><a class="nav-link"  href="customers.php">Customer</a></li>
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

<br>

<input class="form-control mx-auto w-50 text-center" id="myInput" type="text" placeholder="Search..">
  <br>
  
<table  class="table table-bordered table-striped table-hover" id="myTable" >
  <thead>
      <tr>

        <th>Product Id</th>
        <th>Product Name</th>
        <th>Batch No.</th>
        <th>Quanity<input type="number" min="0" style="margin: 3"  width="48" id="quantity_filter" onchange="filterTableQuantity()"> </th>
        <th>Order</th>
		<th>Order Amount</th>
	
        
        
      </tr>
    </thead>
    <tbody id="tbody">
<?php

$qry="SELECT s.product_id,m.name,s.batch_no,s.quantity from stock s ,medicine m where s.shop_id= '$email' and s.product_id=m.product_id";


$r=mysqli_query($conn,$qry);


if ($r->num_rows > 0) 
{
   
   $var=1;
while($p = mysqli_fetch_assoc($r)) {
    
    ?>
          <tr class="active">
        <td><?php echo $p['product_id'] ?></td>    
        <td><?php echo $p['name'] ?></td>
        <td><?php echo $p['batch_no'] ?></td>
        <td><?php echo $p['quantity'] ?>  </td>
        <td><input  type="checkbox" class="check" id="<?php echo "c".$var; ?>"></td>
		<td><input disabled type="text" id="<?php echo "q".$var; ?>"></td>
		    
      

      </tr>




    <?php
    $var=$var+1;
  }

} 


?>



    </tbody>
  </table>
  <center> 
	<button class="btn btn-primary btn-lg" id="order"  >order now</button>
 </center>
</body>

<script>
var sendobj={};
//var sup_name="";
$(".check").change(function() {
    if(this.checked) {
     
	   var id=(this.id).replace('c','q');
	   //alert(id);
	   document.getElementById(id).removeAttribute("disabled");
	   
    }
});

$("#order").click(function()  {

		var selected = [];
		$('input.check:checkbox:checked').each(function() {
				selected.push($(this).attr('id'));
			});
		//console.log(selected[0]);
		jsonarr=[]
		for (var i = 0; i < selected.length; i++) {
			it=selected[i].replace('c','q');
			qt=document.getElementById(it).value;
			iz=selected[i].replace('c','');
			pd=document.getElementById('myTable').rows[iz].cells[0].innerHTML;
			//console.log(qt);
			//console.log(pid);
      obj={};
      obj["pid"]=pd;
      obj["qty"]=qt;
      jsonarr.push(obj);
			

		}
   sendobj["meds"]=JSON.stringify(jsonarr);
   sendobj["status"]="1";
    //sendobj.meds=jsonarr;
		//console.log(jsonarr);
		if (selected.length == 0){
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
		
		
	}); 
	

$(document).ready(function(){

  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
 
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
   })

  
}


function filterTableQuantity() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("quantity_filter");
  qty=input.value;
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");


  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[3];
    if (td) {
      if (td.innerHTML <= qty) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }

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
