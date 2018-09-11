<?php
    require("../connect.php");
    require("../requireLogin.php");

    $sql = $conn->prepare("SELECT id, title, about FROM games WHERE user_id=?");
    $sql->execute(array($_SESSION['user_id']));
    $result = $sql->fetchAll();

    // include header
    $title = "Game Library | User Games";
    require("../components/header.php");
    require("./userHeader.php");

    foreach($result as $row){
        echo $row['title'] . "<br/>";
        echo $row['about'] . "<br/>";
        echo '<a href="../game/gameDetails.php?game_id=' . $row["id"] . '">More</a><br/><br/>';
    }
    ?>
</body>
</html>