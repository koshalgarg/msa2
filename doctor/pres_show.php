<?php 
require('../connect.php');
@session_start();
if(!isset($_SESSION['email'])){
header('Location:../index.php');
}

$email=$_SESSION['email'];
$pres_id=$_SESSION['pres_id'];



?>
<table style="padding: 5px margin:5px" class="table" id="bill">
    <thead>
      <tr>

        <th>Sl No</th>
        <th>Name</th>
        <th>Quantity</th>
        <th></th>
        
        
        
      </tr>
    </thead>

    <tbody id="bdy">

      <?php

      $qry="select P.id, P.pres_id,M.name,P.Quantity as qty from pres_meds P, medicine M where P.pres_id='$pres_id' and P.product_id=M.product_id";
      $r=mysqli_query($conn,$qry);
      $var=1;
      $total=0;

      if ($r->num_rows > 0) 
      {
   
      
      while($p = mysqli_fetch_assoc($r)) {
    
      ?>

     

         <tr>

        <td><?php echo $var;?></td>
        <td><b><?php echo $p['name']; ?> </b></td>
        <td><?php echo $p['qty']; ?> </td>

        
        
        <td><button id="<?php echo($p['id']); ?>" class="remove">X</button></td>

      </tr>


     <?php    
        $var=$var+1;
      }
    }
  ?>



    

      

  </tbody>


</table>  



