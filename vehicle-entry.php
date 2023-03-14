<?php
session_start();
error_reporting(0);
include "includes/dbconn.php";
if (strlen($_SESSION["avmsaid"] == 0)) {
    header("location:logout.php");
} else {
    if (isset($_POST["submit"])) {
        
        
        $company        = $_POST["office"];
        $Vehicletype    = $_POST["vehicletype"];
        $Vehiclenumber  = $_POST["vehiclenumber"];
        $vehiclemodel   = $_POST["vehiclemodel"];
        $intime         = $_POST["checkintime"];
        $usertype       = $_POST["parkingusertype"];
     
        
        $query = mysqli_query($con, "INSERT into vehicleregistry(Company, Vehicletype, Vehiclenumber, vehiclemodel, usertype, Intime)
               value('$company','$Vehicletype','$Vehiclenumber','$vehiclemodel','$usertype', CONVERT_TZ(sysdate(), '+00:00','+05:30') )");
        echo "<script>console.log('Debug Objects: " . $query . "' );</script>";
        echo "<script>console.log('Query Objects: " . $tes . "' );</script>";
        
        
        if ($query) {
            $msg            = "Vehicle entry details has been added";
            $availablespace = $availablespace - 1;
            $ret            = mysqli_query($con, "update apartment set available_space = available_space -1 where apartment_status = '$company'");
            $visitorId      = "";
          
            
        } else {
            $msg = "Something Went Wrong";
        }
    }
?>
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
          
           
                      
                      
                         function getAvailblesapce(val){
                             var vehicletype = $("#vehicletype").val();
                             var vehiclenumber = $("#vehiclenumber").val();
                             var parkingusertype = $("#parkingusertype").val();
                             var office = $("#office").val();
                             var checkintime = $("#checkintime").val();
                             var vehiclemodel = $("#vehiclemodel").val();
          
           $.ajax({
               type: "POST",
               url: "getavailblespace.php",
               data:'office='+val,
               success: function(data){
              
               console.log(data);
              
               $("#vehiclecount").val(data);
              
               if(data == "0"){
                   alert("No More Space Available");
                       document.getElementById("submit").disabled = true;
               }else {
                       document.getElementById("submit").disabled = false;
               }
                  
               }
    
          
                     });     }
                      
          
           function validatedata(){
            if(vehicletype != "" && vehiclenumber != "" && vehiclemodel != "" 
                        && parkingusertype != "" && office != "" ){
                                document.getElementById("submit").disabled = false;
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
          
  

  
          
          
          
          
          
      </script>
   </head>
   <body class="hold-transition skin-blue sidebar-mini" onload="startTime()">
      <div class="wrapper">
      <?php
    include "includes/header.php";
?>
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
            Vehicle Entry Form
            <!-- <small>Control panel</small> -->
         </h1>
         <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Vehicle Entry</li>
         </ol>
      </section>
      <!-- Main content -->
      <section class="content">
         <!-- Small boxes (Stat box) -->
         <?php
    if ($msg) {
        echo "<div class='alert alert-success alert-dismissible'>
                  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                  <h4><i class='icon fa fa-info-circle'></i> Alert!</h4>
                  $msg
            </div>";
    }
?>
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
          

               <div class="row">
                  <form method="POST" class="">
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Vehicle Type</label>
                           <select class="form-control" name="vehicletype" id = "vehicletype"  required>
                              <option value="">Choose</option>
                              <option value="Two Wheeler">Two Wheeler </option>
                              <option value="Four Wheeler">Four Wheeler</option>
                            
                           </select>
                        </div>
                        <div class="form-group">
                           <label>Vehicle Number</label>
                           <input type="text" class="form-control" name="vehiclenumber" id="vehiclenumber" required>
                        </div>
                        
                        
                        
                     <div class="form-group">
                           <label>Parking User Type</label>
                           <select class="form-control" name="parkingusertype" id = "parkingusertype"  required>
                              <option value="">Choose</option>
                              <option value="Staff">Staff</option>
                              <option value="Visitor">Visitor</option>
                              
                           </select>
                        </div>
                        
                        <div class="form-group">
                           <label>Office</label>
                           <select class="form-control select2" name="office" id="office" onChange="getAvailblesapce(this.value);" style="width: 100%;" required>
                              <option value="">Choose....</option>
                              <?php
    $query = mysqli_query($con, "SELECT distinct(apartment_status) from apartment");
    while ($row = mysqli_fetch_array($query)) {
?>    
                              <option value="<?php
        echo $row["apartment_status"];
?>"><?php
        echo $row["apartment_status"];
?></option>
                              <?php
    }
?> 
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
                            <label>Vehicle Model</label>
                           <input type="text" class="form-control" name="vehiclemodel" id="vehiclemodel">
                        </div>
                      
                        <div class="form-group">
                             <label>Available space for selected office</label>
                           <input type= "text" class="form-control" name="vehiclecount" id="vehiclecount" disabled>
                        </div>
                        
                        
                        <!-- /.row -->
                     </div>
                     <!-- /.box-body -->
                     <div class="box-footer">
                         <button type="submit" id ="submit" class="btn btn-block btn-primary btn-lg" onclick ="validatedata();" name="submit" >Submit Vehicle Details</button>
                                
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
      <?php
    include "includes/footer.php";
?>
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
   </body>
</html>
<?php
}
?>