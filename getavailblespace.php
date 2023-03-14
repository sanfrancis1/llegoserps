<?php
    
 	include('includes/dbconn.php');
    if(!empty($_POST["office"])) {
   
     $sdata=$_POST['office'];
    #$sql = "SELECT * FROM tblvisitor WHERE MobileNumber = .$id."; 
    
    $ret=mysqli_query($con,"SELECT available_space from apartment where apartment_status = '$sdata'");
 
    while ($row=mysqli_fetch_array($ret)) {
   echo $row['available_space'];
    }
    
    
     
    }  
    ?>