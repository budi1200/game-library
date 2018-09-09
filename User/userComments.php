<?php
    require("../connect.php");
    require("../requireLogin.php");

    $sql = $conn->prepare("SELECT id, game_id, comment FROM comments WHERE user_id=?");
    $sql->execute(array($_SESSION['user_id']));
    $result = $sql->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Profile</title>
</head>
<body>
    <?php
        require("../components/header.php");
        require("./userHeader.php");

        foreach($result as $row){
            echo $row['comment'] . "<br/>";
            echo '<a href="../game/gameDetails.php?game_id=' . $row["game_id"] . '">More</a><br/><br/>';
        }
    ?>
</body>
</html>