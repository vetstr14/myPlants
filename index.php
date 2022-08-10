<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/myPlants/css/main.css" type="text/css">
    <!-- <link rel="stylesheet" href="css/phone.css"> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <title>My Plants</title>
</head>
<body>
    <header class="main">
        <h1>myPlants</h1>
        <div class="head-container">
            <?php
            $page = $_GET['p'];

            if ($page == "plants") {
                echo "
                    <a href='./?p=home'><span class='material-symbols-outlined'>home</span></a>
                    <a href='./?p=plants' class='current'><span class='material-symbols-outlined'>yard</span></a>
                    <a href='./?p=calendar'><span class='material-symbols-outlined'>calendar_month</span></a>
                    ";
            }
            else if ($page == "calendar") {
                echo "
                    <a href='./?p=home'><span class='material-symbols-outlined'>home</span></a>
                    <a href='./?p=plants'><span class='material-symbols-outlined'>yard</span></a>
                    <a href='./?p=calendar' class='current'><span class='material-symbols-outlined'>calendar_month</span></a>
                    ";
            }
            else {
                if ($page == NULL) {
                    $page = "home";
                }
                echo "
                    <a href='./?p=home' class='current'><span class='material-symbols-outlined'>home</span></a>
                    <a href='./?p=plants'><span class='material-symbols-outlined'>yard</span></a>
                    <a href='./?p=calendar'><span class='material-symbols-outlined'>calendar_month</span></a>
                    ";
            }
            ?>
        </div>
    </header>

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

    /**
     * Functions that creates plant containers for the website,
     * by fetshing data from the database
     */
    function create_plant_box(string $sql, mysqli $conn, string $page) {
        $result = mysqli_query($conn, $sql);
        $rad = mysqli_fetch_assoc($result);

        if (!$rad) {
            echo "<p>Ingen planter å vanne</p>";
        }
        
        while ($rad) {
            // Get values
            $id = $rad['ID'];
            $name = $rad['name'];
            $image = $rad['picture'];
            $date = $rad['next_irrigation'];

            // Create plant boxes
            echo "  <form action='/myPlants/vanning'>
                        <input type='hidden' name='p' value='$page'>
                        <input type='hidden' name='id' value='$id'>
                        <button class='plant_box' type='submit'>
                            <div class='image_container'>
                                <img src='images/$image.jpg' alt='$name'>
                            </div>
                            <div class='image_text'>
                                <h2>$name</h2>
                                <p>Vanning: $date</p>
                            </div>
                        </button>
                    </form>";
            
            // Update $rad
            $rad = mysqli_fetch_assoc($result);
        }
    }

    function main_start() {
        echo "<main class='main'>";
    }
    function main_end() {
        echo "</main>";
    }

    function container_start(string $class) {
        echo "<div class='$class'>";
    }
    function container_end() {
        echo "</div>";
    }

    function h2(string $text) {
        echo "<h2>$text</h2>";
    }



    /* Web site */

    if ($page == "home") {
        main_start();
        container_start("main_container");

        h2("Vannes i dag");

        // I dag
        container_start("plant_container");
        $sql = 'SELECT * FROM `plant` 
                WHERE next_irrigation <= CURRENT_DATE() 
                ORDER BY next_irrigation;';
        create_plant_box($sql, $conn, $page);
        container_end();

        container_end();

        // Neste 3 dager
        container_start("main_container");

        h2("Vannes det neste 3 dagene");

        container_start("plant_container");
        $sql = 'SELECT * FROM `plant` 
                WHERE next_irrigation <= CURRENT_DATE() + 3 
                AND NOT next_irrigation <= CURRENT_DATE() 
                ORDER BY next_irrigation;';
        create_plant_box($sql, $conn, $page);
        container_end();

        container_end();
        main_end();
    }
    else if ($page == "plants") {
        main_start();
        container_start("main_container center");

        //h2("Planter");
        container_start("plant_container");
        $sql = "SELECT * FROM `plant` ORDER BY name;";
        create_plant_box($sql, $conn, $page);

        container_end();
        container_end();
        main_end();
    }
    else if ($page == "calendar") {
        main_start();
        container_start("main_container");
        h2("Page does not exist yet");
        container_end();
        main_end();
    }
    else {
        main_start();
        container_start("main_container");
        h2("404: Page not found");
        container_end();
        main_end();
    }

    ?>
    <script src="" async defer></script>
</body>
</html>