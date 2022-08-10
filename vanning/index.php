<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/myPlants/css/main.css" type="text/css">
    <link rel="stylesheet" href="/myPlants/css/vanning.css" type="text/css">
    <!-- <link rel="stylesheet" href="css/phone.css"> -->
    <!--Icons-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <title>Vanning</title>
</head>
<body>

    <!-- Tilbake knapp -->

    <div class="tilbake">
        <form action="/myPlants">
            <?php
            $page = $_GET['p'];
            echo "<input type='hidden' name='p' value='$page'>";
            ?>
            <button>
                <span style="padding-right: 0.3rem;" class="material-symbols-outlined">
                    arrow_back
                </span>
                Tilbake
            </button>
        </form>
    </div>

    <!-- Web site  -->

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
        $size = $rad['pot_size'];
        $irrigation = $rad['next_irrigation'];

        // Create header
        echo "
        <header class='vanning'>
            <div class='image_frame_vanning'>
                <img src='/myPlants/images/$image.jpg' alt='$name'>
                <h1>$name</h1>";

        if ($size != NULL) {
            echo "
                <p>
                    <span style='font-size: medium;' class='material-symbols-outlined'>
                    potted_plant
                    </span> 
                    $size cm
                </p>";
        }

        echo "
                <p>
                <span style='font-size: medium;' class='material-symbols-outlined'>
                water_drop
                </span> 
                $irrigation
            </p>
        </div>
        </header>";
        ?>

        <main class='vanning'>
            <div class="vanning_devider vanning_btn_container">
                <form class="vanning_btn_container" action="irrigation_action.php">
                    <input type="hidden" name="vanning" value="true">
                    <?php
                        echo "<input type='hidden' name='planteID' value='$plant'>";
                        
                        $sql = "SELECT COUNT(*) as nr FROM `irrigation` WHERE plant_id = $plant AND dato = CURRENT_DATE();";
                        $result = mysqli_query($conn, $sql);
                        $rad = mysqli_fetch_assoc($result);
                        $nr = $rad['nr'];
                        
                        if ($nr == 0) {
                            echo "<input type='submit' value='Vann Planten'>";
                        }
                        else {
                            echo "<input type='submit' disabled value='Planten er vannet'>";
                        }
                    ?>
                    <!-- Vann planten / Planten er vannet -->
                </form>
            </div>
            <div class="vanning_devider vanning_notater">
                <h1>Notater</h1>
                <ul>
                    <?php
                        $sql = "SELECT * FROM `notes` WHERE plant_id = $plant AND applicable = 1 order BY date DESC, severity DESC;";
                        $result = mysqli_query($conn, $sql);
                        $rad = mysqli_fetch_assoc($result);

                        // If !rad 
                        if (!$rad) {
                            echo "<p>Ingen notater</p>";
                        }

                        while ($rad) {
                            // Get values
                            $id = $rad['ID'];
                            $severity = $rad['severity'];
                            $text = $rad['text'];
                            $date = $rad['date'];

                            $severity_class = "";
                            // Severity
                            if ($severity == 0) {
                                $severity_class = "success";
                            } else if ($severity == 1) {
                                $severity_class = "warning";
                            } else if ($severity == 2) {
                                $severity_class = "danger";
                            } else {
                                exit('Severity ERROR');
                            }
            
                            // Create list item
                            echo "
                                <li>
                                    <div class='list_elm_container $severity_class'>
                                        <p>$date</p>
                                        <p>$text</p>
                                    </div>
                                </li>
                            ";
                            
                            // Update $rad
                            $rad = mysqli_fetch_assoc($result);
                        }
                    ?>
                </ul>
            </div>
        </main>
    </div>
    <script src="" async defer></script>
</body>
</html>