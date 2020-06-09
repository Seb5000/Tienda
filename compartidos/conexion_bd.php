<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "CASADEARTE";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if($conn->connect_error){
        echo $conn->connect_error;
    }
    
?>