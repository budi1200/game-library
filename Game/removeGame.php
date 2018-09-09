<?php
    require("../connect.php");
    require("../requireLogin.php");

    // TODO: Add owner verification
    try{
        $sql = $conn->prepare("DELETE FROM games WHERE id=? AND user_id=?");
        $sql->execute(array($_POST['id'], $_SESSION['user_id']));
        $sql_comments = $conn->prepare("DELETE FROM comments WHERE game_id=?");
        $sql_comments->execute(array($_POST['id']));
        header("Location: /game-library/index.php");
    }catch(PDOException $err){
        echo "Error";
    }
?>