<?php
session_start();
error_reporting(0);
include "includes/dbconn.php";
if (strlen($_SESSION["avmsaid"] == 0))
{
    header("location:logout.php");
}
else
{
    if (isset($_POST["submit"]))
    {
        
        $cvmsaid = $_SESSION["cvmsaid"];
        $visname = $_POST["visname"];
        $contactnumber = $_POST["mobilenumber"];
        $address = $_POST["address"];
        $gender = $_POST["gender"];
        $city = $_POST["city"];
        $pincode = $_POST["pincode"];
        $checkintime = $_POST["checkintime"];
        $apartmentno = $_POST["apartmentno"];
        $floor = $_POST["floor"];
        $company = $_POST["company"];
        $whomtomeet = $_POST["whomtomeet"];
        $reason = $_POST["reason"];
        $vtype = $_POST["vehicletype"];
        $vnumber = $_POST["vehiclenumber"];
        $img = $_POST["image"];
        if ($img != ''){
            
            $folderPath = "upload/";
        $fetch_imgParts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $fetch_imgParts[0]);
        $image_type = $image_type_aux[1];
        }
        
        $query = mysqli_query($con, "INSERT into tblvisitor(visitorname, mobilenumber, address, gender, block, floor, whomtomeet, reason, city, pincode, vtype, vnumber, company, checkintime)
               value('$visname','$contactnumber','$address','$gender','$apartmentno', '$floor', '$whomtomeet', '$reason', '$city', '$pincode', '$vtype', '$vnumber', '$company', CONVERT_TZ(sysdate(), '+00:00','+05:30') )");
        echo "<script>console.log('Debug Objects: " . $query . "' );</script>";
        echo "<script>console.log('Query Objects: " . $tes . "' );</script>";
        echo "<script>alert();</script>";
        if ($query)
        {
            $msg = "Visitor entry details has been added";
            $ret = mysqli_query($con, "SELECT * from tblvisitor where mobilenumber = '$contactnumber' order by 1 desc");
            $visitorId = "";
            if ($row = mysqli_fetch_array($ret))
            {
                  if ($img != ''){
                $image_base64 = base64_decode($fetch_imgParts[1]);
                $img_name = $contactnumber . ".jpeg";
                $file = $folderPath . $img_name;
                file_put_contents($file, $image_base64);
                  }
                $visitorId = $row["ID"];
                
                $url = "print.php?visitorId=" + $visitorId;
                header("Location: print.php?visitorId=" . $visitorId);
            }
        }
        else
        {
            $msg = "Something Went Wrong";
        }
    } ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Apartment Visitor Management System</title>
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <!-- Bootstrap 3.3.7 -->
       
       
      <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
      <!-- Ionicons -->
      <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
      <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
      <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
      <!-- Google Font -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
      <script>
         function validate(){
         
         if(document.getElementById("image") == null){
         
         alert("Please Capture Photo");
         return false;
         
         } else {
             return true;
         }
         
         
         
         
         }
           function getInfo(val) {
           if(val.length == 10){
           console.log(val);
               $.ajax({
               type: "POST",
               url: "autofill.php",
               datatype: "JSON",
               data:'mobilenumber='+val,
               success: function(data){
                   var len = data.length;
                   var results = jQuery.parseJSON(data);
                   console.log(results)
                   var mobile= results["mobilenumber"]
               
               if(len > 4){
            
               var confirmation = confirm("Existing Information availble for this vistor, Are you sure to insert?");
               if(confirmation){
                   var dummy = Math.floor((Math.random() * 1000000) + 1);
                   var img_id = "upload/" + mobile + ".jpeg"; 
                   document.getElementById('results').innerHTML = '<img id="snapimg" src="'+img_id+'?dummy='+dummy+' "/>';
                   document.getElementById('image1').src=img_id;
                   
                   document.getElementById("sendotp").disabled = true;
                  $('#otpsmsg').append('<strong><span class= "p-3 mb-2 bg-success text-white">OTP is not required</span> </strong>');
               
               var snapimage = document.getElementById('snapimg');
               
                    	document.getElementById("submit").disabled = false;
               
             $("#visname").val(results["visitorname"]);
               $("#address").val(results["address"]);
               $("#gender").val(results["gender"]);
               $("#apartmentno").val(results["block"]);
               $("#floor").val(results["floor"]);
               $("#whomtomeet").val(results["whomtomeet"]);
               $("#reason").val(results["reason"]);
               $("#city").val(results["city"]);
               $("#pincode").val(results["pincode"]);
               $("#vehicletype").val(results["vtype"]);
               $("#vehiclenumber").val(results["vnumber"]);
               $("#company").val(results["company"]);
               
               
               $('#floor').append($("<option></option>")
                    .attr("value", results["floor"])
                    .attr('selected','selected')
                    .text(results["floor"])); 
                    
                $('#company').append($("<option></option>")
                    .attr("value", results["floor"])
                    .attr('selected','selected')
                    .text(results["company"])); 


               }
               }
               
               } 
               });
               
           }
           }
                      
                      
                         function getBuilding(val){
           
           $.ajax({
               type: "POST",
               url: "autofillfloor.php",
               data:'block='+val,
               success: function(data){
               
               console.log(typeof data);
                data = data.split(',');
         
           
               var arrayLength = data.length;
                       $('#floor').empty();
                       $('#floor').append('<option value="" selected>Choose...</option>');
           for (var i = 0; i < arrayLength-1; i++) {
           			
         
               $('#floor').append('<option value="' + data[i]+ '">' +data[i] + '</option>');
           //Do something
           } }        });     }
                      
           
           function getCompany(val){
           
           
            $.ajax({
               type: "POST",
               url: "autofillcompany.php",
               data:'apartment='+val,
               success: function(data){
               console.log(typeof data);
               console.log(data);
                 data = data.split(',');
               
               var options = '';

               
               var arrayLength = data.length;
               for (var i = 0; i < arrayLength-1; i++) {
               
               options += '<option value="' + data[i] + '" />';

              // $('#company').append('<option value="' + data[i]+ '">' +data[i] + '</option>');
               }
               
               document.getElementById('companies').innerHTML = options;

               
               
               
           
                
               } }); 
           
           
           
           }
           
           function EnableDisableTextBox(value){
           var selectedValue = vehicletype.options[vehicletype.selectedIndex].value;
           
           
               if(selectedValue == "NA" || selectedValue == "Choose" ){
                $("#vehiclenumber").attr("disabled", "disabled");
                $("#vehiclenumber").val("");
               
               }else{
            
                    $("#vehiclenumber").removeAttr("disabled");
              		$("#vehiclenumber").attr('required', '');               
                       $("#vehiclenumber").focus();
               }
                
           
           }
           
           
           function startTime() {
           const today = new Date();
           let d = today.getDate();
           let mon = today.getMonth();
           
           let h = today.getHours();
           let m = today.getMinutes();
           let s = today.getSeconds();
           m = checkTime(m);
           s = checkTime(s);
           document.getElementById('checkintime').value = today.toLocaleString('en-IN');
           setTimeout(startTime, 1000);
           }
           
           function checkTime(i) {
           if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
           return i;
           }
           
   var otpval = Math.floor(100000 + Math.random() * 900000);
   function sendOTP() {
	$(".error").html("").hide();
	document.getElementById("otpsmsg").innerHTML = "";
	document.getElementById("otpnum").value=""
   var number = $("#mobilenumber").val();
   var apikey = 'CWLOYiaIMyQTjD18nX42kcrHEAbK9zSFdJR5Zuoxtm6q3BgU0l0NqpKecy42Rj9baxElXnfJtMoFvIi8';
   
   var apiurl = 'https://www.fast2sms.com/dev/bulkV2?authorization='+apikey+'&variables_values='+otpval + '&route=otp&numbers=' + number;
	
	if (number.length == 10 && number != null) {
	
		$.ajax({
			url : apiurl,
			type : 'GET',		 
			success : function(response) {
            if(response.return == true){            
             $('#otpmsg').append(response.message[0]);
            $('#myModal').modal('show');
           
            }
             
			}
		});
	} else {
		$(".error").html('Please enter a valid number!')
		$(".error").show();
	}
}

      function verifyOTP(){
      
      			var otpnum =  $('#otpnum').val();
      
      if(otpnum != undefined || otpnum != ''){
      				
      			if(otpval == otpnum ){
                $('#myModal').modal('hide');
                document.getElementById("sendotp").disabled = true;
                var snapimage = document.getElementById('snapimg');
                if(snapimage.naturalHeight != 0 && snapimage.naturalHeight != 0){
                    	document.getElementById("submit").disabled = false;
                }
                $('#otpsmsg').append('<strong><span class= "p-3 mb-2 bg-success text-white">OTP Validated Sucessfully</span> </strong>');
                }else{
                $('#myModal').modal('hide');
                $('#otpsmsg').append('<strong><span class= "p-3 mb-2 bg-danger text-white">OTP Validation Failed, Please try again</span></strong>');
                }
      
      }
      
      }
           
           
           
           
           
      </script>
   </head>
   <body class="hold-transition skin-blue sidebar-mini" onload="startTime()">
      <div class="wrapper">
      <?php include "includes/header.php"; ?>
      <?php
    $page = "visitors";
    include "includes/sidebar.php";
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
         <div id="timestamp"></div>
         <h1>
            Visitor's Entry Form
            <!-- <small>Control panel</small> -->
         </h1>
         <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Visitor Entry</li>
         </ol>
      </section>
      <!-- Main content -->
      <section class="content">
         <!-- Small boxes (Stat box) -->
         <?php if ($msg)
    {
        echo "<div class='alert alert-success alert-dismissible'>
                  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                  <h4><i class='icon fa fa-info-circle'></i> Alert!</h4>
                  $msg
            </div>";
    } ?>
         <!-- Forms -->
         <div class="box box-default">
            <div class="box-header with-border">
               <h3 class="box-title">Please fill up the details below</h3>
               <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
               </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">OTP Validation</h4>
      </div>
      <div class="modal-body">
      <p id="otpmsg"></p>
      <p ><input type='text' name='otpnum' placeholder ='Please Enter Your OTP 'id="otpnum"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick='verifyOTP();' >Validate OTP</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


               <div class="row">
                  <form method="POST" class="">
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Visitor's Contact Number</label>
                           <input type="number" class="form-control" name="mobilenumber"  onkeyup="getInfo(this.value);" id="mobilenumber" required>
         				   <input type="button" class='btn btn-primary' onclick='sendOTP();' id='sendotp' data-toggle="modal" value ="Send OTP">
                        	<p id='otpsmsg' class ='txt txt-primary'></p>
                        </div>
                        <div class="form-group">
                           <label>Visitor's Full Name</label>
                           <input type="text" class="form-control" name="visname" id="visname" required>
                        </div>
                        <div class="form-group">
                           <label>Gender</label>
                           <select class="form-control select2" name="gender" id="gender" style="width: 100%;" required>
                              <option value="">Choose</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                              <option value="Others">Others</option>
                           </select>
                        </div>
                        <div class="form-group">
                           <label>Visitor's Address</label>
                           <input type="text" class="form-control" name="address" id="address" required>
                        </div>
                        <div class="form-group">
                           <label>City </label>
                           <input type="text" class="form-control" name="city" id="city" required>
                        </div>
                        <div class="form-group">
                           <label>Pincode</label>
                           <input type="text" class="form-control" name="pincode" id="pincode" required>
                        </div>
                        <div class="form-group">
                           <label>Vehicle Type</label>
                           <select class="form-control" name="vehicletype" id = "vehicletype"  onchange = "EnableDisableTextBox(this)"  required>
                              <option value="">Choose</option>
                              <option value="NA">NA</option>
                              <option value="Two Wheeler">Two Wheeler </option>
                              <option value="Four Wheeler">Four Wheeler</option>
                              <option value="Others">Others</option>
                           </select>
                        </div>
                        <!-- /.form-group -->
                     </div>
                     <!-- /.col -->
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Check In Time</label>
                           <input type="text" class="form-control" name="checkintime" id="checkintime" disabled>  
                        </div>
                        <div class="form-group">
                           <label>Block</label>
                           <select class="form-control select2" name="apartmentno" id="apartmentno" onChange="getBuilding(this.value);" style="width: 100%;" required>
                              <option value="">Choose....</option>
                              <?php
    $query = mysqli_query($con, "SELECT distinct(apartment_number) from apartment");
    while ($row = mysqli_fetch_array($query))
    { ?>    
                              <option value="<?php echo $row["apartment_number"]; ?>"><?php echo $row["apartment_number"]; ?></option>
                              <?php
    }
?> 
                           </select>
                        </div>
                        <div class="form-group">
                           <label>Floor</label>
                           <select class="form-control" name="floor" id = "floor" onchange="getCompany(this.value);"  required>
                              <option value="">Choose....</option>
                           </select>
                        </div>
                        <div class="form-group">
                           <label>Company</label>
                           <!-- <select class="form-control" name="company" id = "company"    required>
                              <option value="">Choose....</option>
                           </select> -->
                           <input type= "text" class="form-control" list="companies" name="company" id="company" required>
                            <datalist id="companies"> </datalist>

                           
                        </div>
                        <div class="form-group">
                           <label>Whom to meet</label>
                        <!-- <select class="form-control select2" name="whomtomeet" id="whomtomeet"  style="width: 100%;" required>
                            <option value="">Choose....</option>
                              <?php
    $query = mysqli_query($con, "SELECT distinct(department) from departments");
    while ($row = mysqli_fetch_array($query))
    { ?>    
                              <option value="<?php echo $row["department"]; ?>"><?php echo $row["department"]; ?></option>
                              <?php
    }
?> 
                           </select> -->
                          <!-- <input type="text" class="form-control" name="whomtomeet" id="whomtomeet" required>  -->
                                
                                <input type= "text" class="form-control" list="whomtomeets" name="whomtomeet" id="whomtomeet" required>
                            <datalist id="whomtomeets"> 
                             <?php
    $query = mysqli_query($con, "SELECT distinct(department) from departments");
    while ($row = mysqli_fetch_array($query))
    { ?>    
                              <option value="<?php echo $row["department"]; ?>"><?php echo $row["department"]; ?></option>
                              <?php
    }
?> 
                            </datalist>
 
                                 
                                 
                        </div>
                        <div class="form-group">
                           <label>Reason</label>
                          <!-- <input type="text" class="form-control" name="reason" id="reason" required>  -->
                                 
                          <!--       <select class="form-control select2" name="reason" id="reason" style="width: 100%;" required>
                            <option value="">Choose....</option>
                              <?php
    $query = mysqli_query($con, "SELECT distinct(reason) from Reasons");
    while ($row = mysqli_fetch_array($query))
    { ?>    
                              <option value="<?php echo $row["reason"]; ?>"><?php echo $row["reason"]; ?></option>
                              <?php
    }
?> 
                           </select> -->
                           
                           
                            <input type= "text" class="form-control" list="reasons" name="reason" id="reason" required>
                            <datalist id="reasons"> 
                             <?php
    $query = mysqli_query($con, "SELECT distinct(reason) from Reasons");
    while ($row = mysqli_fetch_array($query))
    { ?>    
                              <option value="<?php echo $row["reason"]; ?>"><?php echo $row["reason"]; ?></option>
                              <?php
    }
?> 
                            </datalist>
                        </div>
                        <div class="form-group">
                           <label>Vehicle Number</label>
                           <input type="text" class="form-control" name="vehiclenumber" id="vehiclenumber" disabled="disabled">
                        </div>
                        <!-- /.row -->
                     </div>
                     <div class="col-md-4">
                        <div class="row">
                           <div class="col-md-12">
                              <div id="my_camera"></div>
                              <br/>
                              <input type=button value="Take Snapshot" onClick="take_snapshot()">
                              <input type="hidden" id ="image1" required name="image" class="image-tag" style="width: 250px; height: 250px;"> 
                           </div>
                           <div class="col-md-12">
                              <div id="results">Your captured image will appear here...</div>
                           </div>
                        </div>
                     </div>
                     <!-- /.box-body -->
                     <div class="box-footer">
                        <!--<button type="submit" id ="submit" onclick="validate();" data-toggle="modal" data-target="#exampleModal" class="btn btn-block btn-primary btn-lg" name="submit" >Submit Visitor Details</button> -->
                         <button type="submit" id ="submit" class="btn btn-block btn-primary btn-lg" disabled name="submit" >Submit Visitor Details</button>
                                 
                     </div>
               </div>
               </form>
               <!-- /Form -->
               <!-- Main row -->
               <!-- / Main row -->
      </section>

      <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <?php include "includes/footer.php"; ?>
      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark" style="display: none;">
      <!-- Create the tabs -->
      <!-- Tab panes -->
      <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
      </div>
      </div>
      </aside>
      <!-- /.control-sidebar -->
      <div class="control-sidebar-bg"></div>
      </div>
      <!-- ./wrapper -->
      <!-- jQuery 3 -->
      <script src="bower_components/jquery/dist/jquery.min.js"></script>
      <!-- jQuery UI 1.11.4 -->
      <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
      <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
      <script>
         $.widget.bridge('uibutton', $.ui.button);
      </script>
      <!-- Bootstrap 3.3.7 -->
      <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
      <!-- Morris.js charts -->
      <script src="bower_components/raphael/raphael.min.js"></script>
      <script src="bower_components/morris.js/morris.min.js"></script>
      <!-- Sparkline -->
      <script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
      <!-- jvectormap -->
      <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
      <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
      <!-- jQuery Knob Chart -->
      <script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
      <!-- daterangepicker -->
      <script src="bower_components/moment/min/moment.min.js"></script>
      <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
      <!-- datepicker -->
      <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
      <!-- Bootstrap WYSIHTML5 -->
      <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
      <!-- Slimscroll -->
      <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
      <!-- FastClick -->
      <script src="bower_components/fastclick/lib/fastclick.js"></script>
      <!-- AdminLTE App -->
      <script src="dist/js/adminlte.min.js"></script>
      <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
      <script src="dist/js/pages/dashboard.js"></script>
      <!-- AdminLTE for demo purposes -->
      <script src="dist/js/demo.js"></script>
      <script language="JavaScript">
         Webcam.set({
             width: 250,
             height: 200,
             image_format: 'jpeg',
             jpeg_quality: 90
         });
         
         Webcam.attach( '#my_camera' );
         
         function take_snapshot() {
             Webcam.snap( function(data_uri) {
             
                 $(".image-tag").val(data_uri);
                 document.getElementById('results').innerHTML = '<img required  id="snapimg" src="'+data_uri+'"/>';
             	if(document.getElementById("sendotp").disabled == true){	
             		document.getElementById("submit").disabled = false;
                }else{
                alert("Please Complete OTP Validation");
                
                }

             } );
         }
      </script>
   </body>
</html>
<?php
} ?>
