<?php
    include './connect.php';
    session_start();

    // define title for the page
    $title = "Game Library";
    require("./components/header.php");
    
    // echo all games in database
    $result = $conn->query("SELECT * FROM games")->fetchAll();
    foreach($result as $row){
        echo $row['title'];
        echo '<a href="./game/gameDetails.php?game_id=' . $row['id'] . '">More</a>';
    }
?>
</body>
</html>