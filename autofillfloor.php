<?php
    
 	include('includes/dbconn.php');
    if(!empty($_POST["block"])) {
   
     $sdata=$_POST['block'];
    #$sql = "SELECT * FROM tblvisitor WHERE MobileNumber = .$id."; 
    
    $ret=mysqli_query($con,"SELECT * from apartment where apartment_number = '$sdata'");
 
    while ($row=mysqli_fetch_array($ret)) {
   echo $row['building_number'];
    echo " ,";
    

    
    }
    
    
     
    }  
    ?>