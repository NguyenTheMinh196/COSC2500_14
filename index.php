<?php
require_once('config.php');
define('humidity_level', 125);
define('light_level', 125);
define('standard_water_level', 125);
define('motion_sensor_distance', 250);
// create and give variable a name and a value according to the data given
if($_GET['water_level'] != '' and  $_GET['humidity'] != '' and $_GET['water'] != 'false'){
//  when it is created. auto add to database
    $post_sql = $sql->prepare('INSERT INTO plant_humidity_water_level(humidity, water_level) VALUES(?, ?)');
    $post_sql->execute([$_GET['humidity'], $_GET['water_level']]) or die ('Errant query');
}


?>
<!DOCTYPE html>
<head>
<meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Homepage</title>
  <!-- Link CSS -->
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <nav>
        <div class = "nav_bar">
            <div class = "sections" onclick = "click_on_link(1);" >
                Home
            </div>
            <div class = "sections" onclick = "click_on_link(2);">
                About us
            </div>
            <div class = "sections" onclick = "click_on_link(3);">
                Our Project
            </div>
            <div id = "test">
                
            </div>
        </div>
    </nav>
    <div class = "body_part">
        <div class = "overview">
            <div class = "current_data">
                Hello
                <?php
                if(isset($_GET["humidity"])){
                    echo('<div>
                    The humidity level is : 
                    '.$_GET["humidity"].'
                    </div>
                    ');
                }
                else{
                    echo("<div>
                    No humidity is recorded! Something is wrong with the program!
                    </div>");
                }
                if(isset($_GET["water_level"])){
                    echo('
                    <div>
                    The water level is:
                    '
                    .$_GET["water_level"].
                    '
                    </div>
                    ');
                }
                else{
                    echo("<div>
                        No water level is recorded! Something is wrong with the program!
                    </div>");
                }
                if(isset($_GET["water"])){
                    echo(
                        ' 
                        Water or not:
                        <div>
                        '
                        .$_GET["water"].
                        '
                        </div>
                        '
                    );
                }
                else{
                    echo('<div>No water data is recorded! Something is wrong with the program!</div>');
                }
                if(isset($_POST['light']))
                {
                    if($_POST['light'] > 122)
                    {
                        echo(
                            '<div>
                            Too bright
                            </div>'
                        );
                    }
                    else{
                        echo('
                            <div>
                            Too dark
                            </div>
                        ');
                    }
                }
                else{
                    echo('<div>No light data is recorded! Something is wrong with the program!</div>');
                }
                ?>
            </div>

            <div class = "conclusion">
                <?php
                    if(isset($_POST['light']))
                    {
                        if($_POST['light'] > constant('light_level'))
                        {
                            echo(
                                '<div>
                                Too bright
                                </div>'
                            );
                        }
                        else{
                            echo('
                                <div>
                                Too dark
                                </div>
                            ');
                        }
                    }
                    else{
                        echo("
                        <div>
                            There is no warning on light level because there is no data being sent
                        </div>
                        ");
                    }
                    if(isset($_GET['humidity']))
                    {
                        if($_GET['humidity'] > constant('humidity_level'))
                        {
                            echo(
                                '<div>
                                Moist enough
                                </div>'
                            );
                        }
                        else{
                            echo('
                                <div>
                                Need more water
                                </div>
                            ');
                        }
                    }
                    else{
                        echo("
                        <div>
                            There is no warning on humidity level because there is no data being sent
                        </div>
                        ");
                    }
                    if(isset($_GET['water_level']))
                    {
                        if($_GET['water_level'] > constant('standard_water_level'))
                        {
                            echo(
                                '<div>
                                Enough water in the tank
                                </div>'
                            );
                        }
                        else{
                            echo('
                                <div>
                                Not enough water in the tank
                                </div>
                            ');
                        }
                    }
                    else{
                        echo("
                        <div>
                            There is no warning on water level in the tank because there is no data being sent
                        </div>
                        ");
                    }
                    if(isset($_GET['water']))
                    {
                        if($_GET['water'] == "True")
                        {
                            echo(
                                '<div>
                                Plant is being watered
                                </div>'
                            );
                        }
                        else{
                            echo('
                                <div>
                                Plant does not need water right now
                                </div>
                            ');
                        }
                    }
                    else{
                        echo("
                        <div>
                            There is no warning on is the plant is being watered or not because there is no data being sent
                        </div>
                        ");
                    }
                ?>
            </div>
        </div>
        <div class = "data" >
            <div class = "section" style = "margin-top: 3vh">
                    <?php
                     $last_30_days = $sql->query("SELECT * FROM plant_humidity_water_level pl where DATE_SUB(NOW(), INTERVAL 30 DAY)");
                    // --  'Time' >= DATEADD(day,-30,GETDATE()) 
                    // --  and 'Time' <= getdate()");
                     $thirty_days_count = $last_30_days->rowCount();
                    //  if your plant has enough humidity
                     $total_humidity = 0;
                    //  if you fill your tank enough
                     $total_water_level = 0; 
                    //  how many time did the machine water your plant
                     foreach($last_30_days as $row){
                        $total_humidity = $total_humidity + $row['humidity'];
                        $total_water_level = $total_humidity + $row['water_level'];
                        // for calculation and stuff...
                     }
                     $average_humidity = $total_humidity / $thirty_days_count;
                     $average_water_level = $total_water_level / $thirty_days_count;
                     echo("
                     <div>
                     Average humidity in the last 30 days:".$average_humidity." 

                     </div>
                     <div>
                     Average water level in the last 30 days:".$average_water_level."

                     </div>
                     <div>
                    Total amount of time that the plant was watered: ".$thirty_days_count."
                     </div>
                     ")
                    ?>
            </div>
            <div class  = "section">
            <?php
                     $last_7_days = $sql->query("SELECT * FROM plant_humidity_water_level pl where DATE_SUB(NOW(), INTERVAL 7 DAY)");
                    // --  'Time' >= DATEADD(day,-7,GETDATE()) 
                    // --  and 'Time' <= getdate()");
                     $seven_days_count = $last_7_days->rowCount();
                    //  if your plant has enough humidity
                     $total_humidity = 0;
                    //  if you fill your tank enough
                     $total_water_level = 0; 
                    //  how many time did the machine water your plant
                     foreach($last_7_days as $row){
                        $total_humidity = $total_humidity + $row['humidity'];
                        $total_water_level = $total_humidity + $row['water_level'];
                        // for calculation and stuff...
                     }
                     $average_humidity = $total_humidity / $seven_days_count;
                     $average_water_level = $total_water_level / $seven_days_count;
                     echo("
                     <div>
                     Average humidity in the last 30 days:".$average_humidity." 

                     </div>
                     <div>
                     Average water level in the last 30 days:".$average_water_level."

                     </div>
                     <div>
                    Total amount of time that the plant was watered: ".$seven_days_count."
                     </div>
                     ")
                    ?>
            </div>
            <div class = "section" style = "margin-bottom: 3vh">
            <?php
                     $yesterday = $sql->query("SELECT * FROM plant_humidity_water_level pl where DATE_SUB(NOW(), INTERVAL 1 DAY)");
                    // --  'Time' >= DATEADD(day,-1,GETDATE()) 
                    // --  and 'Time' <= getdate()");
                     $yesterday_count = $yesterday->rowCount();
                    //  if your plant has enough humidity
                     $total_humidity = 0;
                    //  if you fill your tank enough
                     $total_water_level = 0; 
                    //  how many time did the machine water your plant
                     foreach($yesterday as $row){
                        $total_humidity = $total_humidity + $row['humidity'];
                        $total_water_level = $total_humidity + $row['water_level'];
                        // for calculation and stuff...
                     }
                     $average_humidity = $total_humidity / $yesterday_count;
                     $average_water_level = $total_water_level / $yesterday_count;
                     echo("
                     <div>
                     Average humidity in the last 30 days:".$average_humidity." 

                     </div>
                     <div>
                     Average water level in the last 30 days:".$average_water_level."

                     </div>
                     <div>
                    Total amount of time that the plant was watered: ".$yesterday_count."
                     </div>
                     ")
                    ?>
            </div>
            <?php
                // $display = $sql->query("SELECT * FROM plant_humidity_water_level pl");
                // $count = $display->rowCount();
                // foreach($display as $row){
                //     echo("<div>");
                //     echo($row['humidity']);
                //     echo("</div>");
                // }
            ?>
        </div>
    </div>
</body>
<script src = "script/script.js">

</script>
<footer>

</footer>
