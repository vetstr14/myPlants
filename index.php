<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/myPlants/css/main.css" type="text/css">
    <!-- <link rel="stylesheet" href="css/phone.css"> -->
    <title>My Plants</title>
</head>
<body>
    <header>
        <h1>myPlants</h1>
        <div class="head-container">
            <div>Home</div>
            <div>Plants</div>
            <div>Calender</div>
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
    ?>

    <!-- Web site  -->

    <main>
        <div class="plant_container">
        <?php 
        $sql = 'SELECT * FROM plant';
        $result = mysqli_query($conn, $sql);
        $rad = mysqli_fetch_assoc($result);
        
        while ($rad) {
            // Get values
            $name = $rad['name'];
            $image = $rad['picture'];

            // Create plant boxes
            echo "  <div class='plant_box'>
                        <div>
                            <img src='images/$image.jpg' alt='$name'>
                        </div>
                        <div>
                            <h2>$name</h2>
                            <p>Vanning: 07/08/22</p>
                        </div>
                    </div>";
            
            // Update $rad
            $rad = mysqli_fetch_assoc($result);
        }
        ?>
        </div>
        <div class="plant_container">
            <!-- Next box -->
        </div>
    </main>
    <script src="" async defer></script>
</body>
</html>