<?php
    include './connect.php';
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="./css/style.css"/>
    <title>Game Library</title>
</head>
<body>
    <?php
        require("./components/header.php");

        $result = $conn->query("SELECT * FROM games")->fetchAll();

        foreach($result as $row){
            echo $row['title'];
            echo '<a href="./game/gameDetails.php?game_id=' . $row['id'] . '">More</a>';
        }
    ?>
</body>
</html>