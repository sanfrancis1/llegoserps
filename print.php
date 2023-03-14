<html>
<head>
    
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <!-- <script src="bower_components/jquery/dist/jquery.min.js" type="text/javascript"></script> -->
   <script src="bower_components/print.min.js" type="text/javascript"></script>
   <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
   
   <style>
   
   #box {
      border: 5px solid black;
      padding: 50px;
      margin: 20px;
      }
       #vistorimg{
      
       display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
  }
   
       @media print{
           
            #box  {
                 padding:0px;
     
    height : 148mm;
    width  : 105mm;
    padding: 20px;
    
  }
  
    a[href]:after {
    content: none !important;
  }

  
  #printbtn{
      display:none;
  }
           
            #datatable *{
                 margin:0px;
               padding:0px;
                font-size:12px;
           }
            
            
           
          
           
          
       }
   </style>
   
</head>
<body>
   
  
  <?php    
  
   include('includes/dbconn.php');
            if(isset($_GET["visitorId"])){
            $visitorid = $_GET["visitorId"];
               $ret=mysqli_query($con,"SELECT * from tblvisitor where ID = $visitorid");
                
            }

while ($row = mysqli_fetch_array($ret))
{
    
    $visitorid = $row[ID];
     $checkintime .= '<td>'.$row[checkintime].'</td>';
      $visitorname .= '<td>'.$row[visitorname].'</td>';
       $mobilenumber = $row[mobilenumber];
        $gender .= '<td>'.$row[gender].'</td>';
         $address .= '<td>'.$row[address].'</td>';
          $city .= '<td>'.$row[city].'</td>';
           $pincode .= '<td>'.$row[pincode].'</td>';
            $block .= '<td>'.$row[block].'</td>';
             $floor .= '<td>'.$row[floor].'</td>';
              $company .= '<td>'.$row[company].'</td>';
               $whomtomeet .= '<td>'.$row[whomtomeet].'</td>';
               $vtype .= '<td>'.$row[vtype].'</td>';
               $vnumber .= '<td>'.$row[vnumber].'</td>';
               $reason .= '<td>'.$row[reason].'</td>';
    
    $dummy=rand();
}

echo '<div class="row">
<div class="col-md-3"></div>
<div class="col-md-6" id="box">
    <table class="table table-condensed table-bordered neutralize" id="datatable">     
    <thead>
    <tr ><td colspan="2" style="text-align: center;"><b>Briley One</td></tr>
        <tr ><td style="text-align: center;" colspan="2"><b>Visitor Pass</td></tr>
    </thead>
        <tbody>
            <tr>
                <th>Visitor ID:</th> <td>'.$visitorid.'</td>
            </tr>
            <tr>
                <th>Check In Time:</th>'.$checkintime .'
            </tr>
            <tr>
                <th>Visitor Name: </th>'.$visitorname .'
            </tr>
            <tr>
                <th>Mobile Number:</th><td>'.$mobilenumber .'</td>
            </tr>
            <tr>
                <th>Gender:</th>'.$gender .'
            </tr>
            <tr>
                <th>Address:</th>'.$address .'
            </tr>
            <tr>
                <th>City:</th>'.$city .'
            </tr>
            <tr>
                <th>Pincode: </th>'.$pincode .'
            </tr>
            <tr>
                <th>Block:</th>'.$block .'
            </tr>
            <tr>
                <th>Floor:</th>'.$floor .'
            </tr>
            <tr>
                <th>Company Name: </th>'.$company .'
            </tr>
            <tr>
                <th>Whom To Meet: </th>'.$whomtomeet .'
            </tr>
            <tr>
                <th>Vehicle Type: </th>'.$vtype .'
            </tr>
            <tr>
                <th>Vehicle Number: </th>'.$vnumber .'
            </tr>
            <tr>
                <th>Reason: </th>'.$reason .'
            </tr>
            <tr>
                <th>Visitor & Sign</th>
                <th>security & Sign</th>
                 
            </tr>
            <tr>
                <td ><img id= "vistorimg" class="rounded" src = "upload/'.$mobilenumber.'.jpeg?dummy='.$dummy.'" ></td>
                <td></td>
                 
            </tr>
             
        </tbody>
    </table>
    <div class="row" id="printbtn">  
    <div class="col-md-5">
    
    </div>
    <div class="col-md-6">
    <button class="btn btn-primary" onclick="window.print();" id="submit" type="submi">Print</button>
    <button class="btn btn-danger"  id="cancel" type="submit"><a href="visitor-entry.php" >Cancel</button>
    </div>
    </div>
    </div>
</div>    
';
?>
</body>
</html>