<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <!-- <script src="bower_components/jquery/dist/jquery.min.js" type="text/javascript"></script> -->
   <script src="bower_components/print.min.js" type="text/javascript"></script>
   <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="bower_components/print.min.css">-->
   
   <style type="text/css">
      tr.header
      {
      font-weight:bold;
      }
      tr.alt
      {
      background-color: #777777;
      }
   </style>
   <script type="text/javascript">
      $(document).ready(function(){
         $('.striped tr:even').addClass('alt');
      });
      
      
      
       function CallPrint() {
             var divToPrint = document.getElementById('box');
           var popupWin = window.open('', '_blank', 'width=300,height=300');
           popupWin.document.open();
           popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
            popupWin.document.close();
        }
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
   </script>
   <title></title>
   <style>
      #box {
      border: 5px solid black;
      padding: 50px;
      margin: 20px;
      }
      #comphead, #comphead1  {
      border: 1px solid black;
      
      }
.col-md-6{
    border:1px solid black
}

.row{
    font-size: 15px;
    font-family: ui-rounded;
}

lable{
    font-weight: bold;
}
#comname{
    font-style: oblique;
    font-family: fangsong;
    font-weight: bolder;
    font-size: 25px;
    background-color: #4d85cb;
}
@media print {
    @page {
        margin-top: 0;
        margin-bottom: 0;
    }
    .col-md-6{
        padding:5px;
    }
  #comname{
      font-size: 15px;
  }
  
  #box *{
        padding:0px;
       font-size: 12px;
  }
  
  #box  {
      
    height : 148mm;
    width  : 105mm;
    padding: 25px;
    
  }
  #vistorimg{
      
       display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
  }
  #submit{
   display: none;
  }
  #cancel, #sign{
   display: none;
  }
  #comphead, #comphead1{
      padding: 0px;
 
  }
  a{
      display: none;
  }
}


          </style> 
 
</head>
<body>
   <div class="row">
      <div class="col-md-3">
      </div>
      <div class="col-md-6" id="box">
         <div class="row" id="comphead">
            <div class="col-md-12 text-center" id="comname">
               <p >Briley One</p>
               <p >Visitor Pass</p>
            </div>
         </div>
		 <div class="row" id="comphead1">
            
			<!--<div class="col-md-12 text-center">
               <p >QR Code</p>
            </div> -->
         </div>
         <?php
            include('includes/dbconn.php');
            if(isset($_GET["visitorId"])){
            $visitorid = $_GET["visitorId"];
            
               $ret=mysqli_query($con,"SELECT * from tblvisitor where ID = $visitorid");
                       
                   ?>
         
         <?php
            while($row = mysqli_fetch_array($ret)) {
                echo "<div class='row'>";               
              	echo "<div class='col-md-6'><lable>Visitor Id:</lable></lable>$row[ID] </div>"; 
                echo "<div class='col-md-6'><lable>Check In Time:</lable>$row[checkintime]</div>";
                echo "</div>";
            
            
           		echo "<div class='row'>";               
              	echo "<div class='col-md-6'><lable>Visitor Name: </lable>$row[visitorname]</div>"; 
                echo "<div class='col-md-6'><lable>Mobile Number:</lable>$row[mobilenumber]</div>";
                echo "</div>";
            
            echo "<div class='row'>";               
              	echo "<div class='col-md-6'><lable>Gender: </lable>$row[gender]</div>"; 
                echo "<div class='col-md-6'><lable>Visitor Address:</lable>$row[address]</div>";
                echo "</div>";
            
            echo "<div class='row'>";               
              	echo "<div class='col-md-6'><lable>City: </lable>$row[city]</div>"; 
                echo "<div class='col-md-6'><lable>Pincooe:</lable>$row[pincode]</div>";
                echo "</div>";
            
            echo "<div class='row'>";               
              	echo "<div class='col-md-6'><lable>Block: </lable>$row[block]</div>"; 
                echo "<div class='col-md-6'><lable>Floor:</lable>$row[floor]</div>";
                echo "</div>";
            
            echo "<div class='row'>";               
              	echo "<div class='col-md-6'><lable>Company: </lable>$row[company]</div>"; 
                echo "<div class='col-md-6'><lable>Whom To Meet:</lable>$row[whomtomeet]</div>";
                echo "</div>";
            
            echo "<div class='row'>";               
              	echo "<div class='col-md-6'><lable>Vehicle Type: </lable>$row[vtype]</div>"; 
                echo "<div class='col-md-6'><lable>Vehicle Number:</lable>$row[vnumber]</div>";
                echo "</div>";
            
            echo "<div class='row'>";               
              	echo "<div class='col-md-6'><lable>Reason: </lable>$row[reason]</div>"; 
            echo "<div class='col-md-6' ><lable>Visitor Signature:</div>"; 
                 
                echo "</div>";
            
            $filepath= 'upload/'.$row[mobilenumber].'.jpeg'; 
             echo "<div class='row'>";    
            	
            	
              	 echo "<div class='col-md-6'><img id= 'vistorimg'class='rounded' src = ".$filepath."></div>";     
             echo "<div class='col-md-6' id='sign' style='padding: 100px;'></div>";   
                 
                echo "</div>";
            
       
            	 echo "<div class='row'>";    
            echo "<div class='col-md-5'></div>";
            	echo "<div class='col-md-1'><button class='btn btn-primary' onclick='window.print();' id='submit' type='submit'>Print</button></div>";
            
              	 echo "<div class='col-md-1'><button class='btn btn-danger'  id='cancel' type='submit'><a href='visitor-entry.php' >Cancel</button></div>"; 
                 
            echo "<div class='col-md-5'></div>";
                echo "</div>";

                        }
            }
            ?>
        </div>
   </div>
</body>
</html>