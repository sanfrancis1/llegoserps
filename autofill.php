<?php
    
 	include('includes/dbconn.php');
    if(!empty($_POST["mobilenumber"])) {
   
     $sdata=$_POST['mobilenumber'];
    #$sql = "SELECT * FROM tblvisitor WHERE MobileNumber = .$id."; 
    
    $ret=mysqli_query($con,"SELECT * from tblvisitor where MobileNumber = '$sdata' order by ID desc limit 1 ");
 
    $result = array();
    while ($row=mysqli_fetch_array($ret)) {
        
$visitorname=$row[visitorname]; 
$mobilenumber=$row[mobilenumber];
$address=$row[address];   
$gender=$row[gender];
$block=$row[block];
$floor=$row[floor];
$whomtomeet=$row[whomtomeet];
$reason=$row[reason];
$city=$row[city];
$pincode=$row[pincode];
$vtype=$row[vtype];
$vnumber=$row[vnumber];
$company=$row[company];


$result = array("visitorname" => $visitorname,
                    "mobilenumber" => $mobilenumber,
                    "address" => $address,
                    "gender" => $gender,
                    "block" => $block,
                    "floor" => $floor,
                    "whomtomeet" => $whomtomeet,
                    "reason" => $reason,
                    "city" => $city,
                    "pincode" => $pincode,
                    "vtype" => $vtype,
                    "vnumber" => $vnumber,
                    "company" => $company
                    
                    );


	

    
    #echo $row[visitorname];
    #echo " ,";
	#echo $row[mobilenumber];
    #echo " ,";
	#echo $row[address];
    #echo " ,";
	#echo $row[gender];
    #echo " ,";
	#echo $row[block];
    #echo " ,";
	#echo $row[floor];
    #echo " ,";
	#echo $row[whomtomeet];
    #echo " ,";
	#echo $row[reason];
    #echo " ,";
	#echo $row[city];
    #echo " ,";
	#echo $row[pincode];
    #echo " ,";
	#echo $row[vtype];
    #echo " ,";
	#echo $row[vnumber];
    #echo " ,";
	#echo $row[company];
    
    
    }
    
    echo json_encode( $result );

    
    
     
    }  
    ?>