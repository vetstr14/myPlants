<?php 
    /* 
        Database configuration 
    */

    // Connection parameters
    $host       = 'localhost';
    $user       = 'root';
    $password   = '';
    $db         = 'my_plants';

    // Connect to database
    $conn = mysqli_connect($host, $user, $password, $db);
    
    // Connection check
    if (!$conn) {
        exit('ERROR: Could not connect to database');
    }

    // Send vannings info
    $plant = $_GET['planteID'];
    $vannet = $_GET['vanning'];

    if ($vannet == 'true') {
        $sql = "INSERT INTO irrigation (plant_id, dato, klokke) 
                VALUES ($plant, CURRENT_DATE(), CURRENT_TIME());";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "ERROR: Insert error";
        }
        else {
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }
    else {
        echo 'ERROR: Wrong "vanning" value';
    }
    
    ?>