<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/phone.css">
    <title>My Plants</title>
</head>
<body>
    <header>
        <h1>myPlants</h1>
        <div><div>Home</div><div>Plants</div><div>Calender</div></div>
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
        <div>
        <?php 
        $sql = 'SELECT * FROM plant';
        $result = mysqli_query($conn, $sql);
        $rad = mysqli_fetch_assoc($result);
        
        while ($rad) {
            $name = $rad['name'];
            // Create plant boxes
            echo "  <div>
                        <div>
                            <img src='images/test.jpeg' alt='Tradescandia'>
                        </div>
                        <div>
                            <h2>$name</h2>
                        </div>
                    </div>";
            
            $rad = mysqli_fetch_assoc($result);
        }
        ?>
        </div>
        <div>
            <!-- Next box -->
        </div>
    </main>
    <script src="" async defer></script>
</body>
</html>