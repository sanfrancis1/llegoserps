<?php
  session_start();
  error_reporting(0);
  include('includes/dbconn.php');
echo"DELETED";

echo "<script>alert('Are You Sure to delete?');</script>";

  if (strlen($_SESSION['avmsaid']==0)) {
    header('location:logout.php');
    } else {

if(isset($_GET['editid'])){
$id=$_GET['editid'];

include 'includes/dbcon.php';


$qry="DELETE from departments where id=$id";
$result=mysqli_query($con,$qry);

if($result){
    echo"DELETED";
 	echo "<script>window.location.href='manage-department.php';</script>";
	echo "<script>console.log('Test');</script>";
    header('location:manage-apartment.php');
	exit;
}else{
    echo"ERROR!!";
}
}
    }
?>