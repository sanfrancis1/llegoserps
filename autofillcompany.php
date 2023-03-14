<?php
    
 	include('includes/dbconn.php');
    if(!empty($_POST["apartment"])) {
   
     $sdata=$_POST['apartment'];
    #$sql = "SELECT * FROM tblvisitor WHERE MobileNumber = .$id."; 
    
    $ret=mysqli_query($con,"SELECT * from apartment where building_number = '$sdata'");
 
    while ($row=mysqli_fetch_array($ret)) {
    echo $row['apartment_status'];
    echo " ,";
    }
    
    
     
    }  
    ?>