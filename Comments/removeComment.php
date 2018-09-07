<?php
    require("../connect.php");
    require("../requireLogin.php");

    $sql = $conn->prepare("DELETE FROM comments WHERE user_id=? AND game_id=? AND addedTime=?");
    try{
        $sql->execute(array($_SESSION['user_id'], $_POST['game_id'], $_POST['time']));
        header("Location: /game-library/game/gameDetails.php?game_id=".$_POST['game_id']);
    }catch(PDOException $err){
        echo "Error";
    }


?>