<?php
    require("../connect.php");
    require("../requireLogin.php");

    // owner verification
    $sql_verify = $conn->prepare("SELECT user_id FROM comments WHERE game_id=?");
    $sql_verify->execute(array($_POST['game_id']));
    $result_verfy = $sql_verify->fetch();
    if($_SESSION['user_id'] != $result_verfy['user_id']){
        header("Location: /game-library/");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="./css/style.css"/>
    <?php echo "<title>Edit Game</title>"?>
</head>
<body>
    <?php
        $sql = $conn->prepare("SELECT * FROM comments WHERE user_id=? AND game_id=? AND addedTime=?");
        $sql->execute(array($_SESSION['user_id'], $_POST['game_id'], $_POST['time']));
        $result = $sql->fetch();
    ?>
    <form action="" method="post">
        <label>Comment:</label><input type="text" name="comment" <?php echo 'value="'.$result['comment'].'"'?> />
        <input type="hidden" name="game_id" <?php echo 'value="'.$_POST['game_id'].'"'?> />
        <input type="hidden" name="time" <?php echo 'value="' . $_POST['time'] . '"'?> />
        <button type="submit" name="submit">Save</button>
    </form>

    <?php
        if(isset($_POST['submit'])){
            $comment = $_POST['comment'];
            $id = $_POST['game_id'];
            $addedTime = $_POST['time'];
            try{
                $sql2 = $conn->prepare("UPDATE comments SET comment=? WHERE user_id=? AND game_id=? AND addedTime=?");
                $sql2->execute(array($comment, $_SESSION['user_id'], $id, $addedTime));
                header("Location: /game-library/game/gameDetails.php?game_id=$id");
            }catch(PDOException $err){
                echo "Error editing game";
            }
        }
    ?>
</body>
</html>