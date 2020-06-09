<?php 
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = "CASADEARTE";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if($conn === false){
        die("Error: could not connect. ".mysqli_connect_error());
        
    }
?>