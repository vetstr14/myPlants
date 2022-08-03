<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/myPlants/css/main.css" type="text/css">
    <link rel="stylesheet" href="/myPlants/css/vanning.css" type="text/css">
    <!-- <link rel="stylesheet" href="css/phone.css"> -->
    <title>Vanning</title>
</head>
<body>

    <!-- Tilbake knapp -->

    <div class="tilbake">
        <form action="/myPlants">
            <input type="submit" value="<-- Tilbake">   <!-- Fiks icon -->
        </form>
    </div>

    <div class="vanning">
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

        // Insert plant name as header
        $plant = $_GET['id'];
        $sql = "SELECT * FROM `plant` WHERE ID = $plant";
        $result = mysqli_query($conn, $sql);
        $rad = mysqli_fetch_assoc($result);
        $image = $rad['picture'];
        $name = $rad['name'];

        // Create header
        echo "
        <header class='vanning'>
            <img src='/myPlants/images/$image.jpg' alt='$name'>
            <h1>$name</h1>
        </header>";
        ?>

        <!-- Web site  -->

        <main class='vanning'>
            <form class="vanning_btn_container" action="irrigation_action.php">
                <input type="hidden" name="vanning" value="true">
                <?php
                    echo "<input type='hidden' name='planteID' value='$plant'>";
                ?>
                <input type="submit" value="Vann Planten">
                <!-- Vann planten / Planten er vannet -->
            </form>
        </main>
    </div>
    <script src="" async defer></script>
</body>
</html>