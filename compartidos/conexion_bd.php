<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "casadearte";

    $conn2 = new mysqli($servername, $username, $password, $dbname);

    if($conn2->connect_error){
        echo $conn2->connect_error;
    }
    
?>