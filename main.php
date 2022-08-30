<?php
require_once('config.php');
if($_GET['water_level'] != '' and  $_GET['humidity'] != '' and $_GET['water'] != 'false'){
//  when it is created. auto add to database
    $post_sql = $sql->prepare('INSERT INTO plant_humidity_water_level(humidity, water_level) VALUES(?, ?)');
    $post_sql->execute([$_GET['humidity'], $_GET['water_level']]) or die ('Errant query');
}


?>
<div>
    Hello
    <?php
    echo('<div>
    The humidity level is : 
    '.$_GET["humidity"].'
    </div>
    ');
    echo('
    <div>
    The water level is:
    '
    .$_GET["water_level"].
    '
    </div>
    ');
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
    ?>
</div>