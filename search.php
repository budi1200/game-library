<?php
    require("./connect.php");
    
    $title = "Game Library | Search Results";
    require("./components/header.php");

    if(isset($_GET['s'])){
        $string = strtolower($_GET['s']);

        $sql = $conn->prepare("SELECT * FROM games WHERE LOWER(title) LIKE ?");
        $sql->execute(array("%$string%"));
        $result = $sql->fetchAll();

        foreach($result as $row){
            echo $row['title'];
            echo '<a href="./game/gameDetails.php?game_id=' . $row['id'] . '">More</a>';
        }
    }

?>
</body>
</html>