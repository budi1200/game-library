<?php
    require("../connect.php");
    require("../requireLogin.php");

    $sql = $conn->prepare("DELETE FROM games WHERE id=? AND user_id=?");
    try{
        $sql->execute(array($_POST['id'], $_SESSION['user_id']));
        header("Location: /game-library/index.php");
    }catch(PDOException $err){
        echo "Error";
    }


?>