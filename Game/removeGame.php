<?php
    require("../connect.php");
    require("../requireLogin.php");

    // owner verification
    $sql_verify = $conn->prepare("SELECT user_id FROM games WHERE id=?");
    $sql_verify->execute(array($_POST['id']));
    $result_verfy = $sql_verify->fetch();
    if($_SESSION['user_id'] != $result_verfy['user_id']){
        header("Location: /game-library/");
    }else{
        try{
            // handle deleting game image
            $sql_image = $conn->prepare("SELECT i.* FROM images i INNER JOIN games g ON g.image_id=i.id WHERE g.id=?");
            $sql_image->execute(array($_POST['id']));
            $result_img = $sql_image->fetch();

            $img_path = "../" . substr($result_img['url'], 14);
            unlink(realpath($img_path));
            $sql_delete_image = $conn->query("DELETE FROM images WHERE id=" . $result_img['id']);

            // handle deleting of game ratings
            $sql_rating = $conn->prepare("DELETE FROM ratings WHERE game_id=?");
            $sql_rating->execute(array($_POST['id']));

            // Handle deleting game comments
            $sql_comments = $conn->prepare("DELETE FROM comments WHERE game_id=?");
            $sql_comments->execute(array($_POST['id']));

            // Handle deleting game
            $sql = $conn->prepare("DELETE FROM games WHERE id=? AND user_id=?");
            $sql->execute(array($_POST['id'], $_SESSION['user_id']));
            header("Location: /game-library/index.php");

        }catch(PDOException $err){
            echo "Error";
        }
    }
?>