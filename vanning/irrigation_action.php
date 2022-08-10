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
        $p_inter = "SELECT irrigation_interval FROM `plant` WHERE ID = $plant;";
        $p_res = mysqli_query($conn, $p_inter);
        $p_rad = mysqli_fetch_assoc($p_res);
        $next_irrigation = "";
        if ($p_rad['irrigation_interval'] != NULL) {
            $next_irrigation = $p_rad['irrigation_interval'];
        } else {
            $next_irrigation = "7";
        }

        // Create irrigation element
        $sql = "INSERT INTO irrigation (plant_id, dato, klokke) 
                VALUES ($plant, CURRENT_DATE(), CURRENT_TIME());";
        $result = mysqli_query($conn, $sql);

        // Update plant last irrigation
        $plant_sql = "UPDATE `plant` SET `next_irrigation`= CURRENT_DATE() + $next_irrigation
                        WHERE ID = $plant;";
        $result_update = mysqli_query($conn, $plant_sql);

        // Check for error
        if (!$result) {
            echo "ERROR: Insert error";
        }
        else if (!$result_update) {
            echo "ERROR: Update error";
        }
        else {
            // Go back to previous page
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }
    else {
        echo 'ERROR: Wrong "vanning" value';
    }
    
    ?>