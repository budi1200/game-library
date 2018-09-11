<?php
    require("../connect.php");
    require("../requireLogin.php");

    $sql = $conn->prepare("SELECT id, game_id, comment FROM comments WHERE user_id=?");
    $sql->execute(array($_SESSION['user_id']));
    $result = $sql->fetchAll();

    // include header
    $title = "Game Library | User Comments";
    $profile = true;
    require("../components/header.php");
    $userComments = true;
    require("./userHeader.php");

    foreach($result as $row){
        echo $row['comment'] . "<br/>";
        echo '<a href="../game/gameDetails.php?game_id=' . $row["game_id"] . '">More</a><br/><br/>';
    }
    ?>
</body>
</html>