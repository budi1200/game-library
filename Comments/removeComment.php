<?php
    require("../connect.php");
    require("../requireLogin.php");

    // owner verification
    $sql_verify = $conn->prepare("SELECT user_id FROM comments WHERE game_id=?");
    $sql_verify->execute(array($_POST['game_id']));
    $result_verfy = $sql_verify->fetch();
    
    if($_SESSION['user_id'] != $result_verfy['user_id']){
        header("Location: /game-library/game/gameDetails.php?game_id=".$_POST['game_id']);
    }else{
        try{
            $sql = $conn->prepare("DELETE FROM comments WHERE user_id=? AND game_id=? AND addedTime=?");
            $sql->execute(array($_SESSION['user_id'], $_POST['game_id'], $_POST['time']));
            header("Location: /game-library/game/gameDetails.php?game_id=".$_POST['game_id']);
        }catch(PDOException $err){
            echo "Error";
        }
    }
?>