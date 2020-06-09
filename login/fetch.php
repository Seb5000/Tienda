<?php
    include('database_connection.php');

    $query = "SELECT * FROM CATEGORIA";

    $statement = $connect->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    $total_row = $statement->rowCount();

    $output = "";

    if($total_row>0){
        foreach($result as $row){
            $output .= "
            <div>".$row["NOMBRE_CATEGORIA"]."</div>
            ";
        }
    }

    echo $output;

?>