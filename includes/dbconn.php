<?php
    $con=mysqli_connect("localhost", "brileyone", "brileyone", "brileyone_ams");
    if(mysqli_connect_errno()){
        echo "DB Connection Failed!".mysqli_connect_error();
    }
  ?>