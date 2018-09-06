<?php
    require('../connect.php');
    session_start();

    if(isset($_GET['game_id'])){
        $game_id = $_GET['game_id'];
        
        $sql = $conn->prepare("SELECT * FROM games WHERE id=?");
        $sql->execute(array($game_id));
        $result = $sql->fetch();
        if(!$result){
            header("Location: ../404.php");
        }
    }else{
        //header("Location: ../404.php");
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php echo "<title>Game Library | " . $result['title'] . "</title>"; ?>
</head>
<body>
    <?php
        require("../components/header.php");
        echo $result['title'] . "<br/>";
        echo $result['about'] . "<br/>";
        echo $result['genre'] . "<br/>";
        echo $result['release_year'] . "<br/>";
        echo $result['developer'] . "<br/>";
        echo $result['website_url'] . "<br/>";

        if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $result['user_id']){
            echo '<form action="editGame.php" method="post"> <input type="hidden" name="game_id" value="' . $result['id'] . '"/> <button type="submit">Edit Game</button></form>';
            echo '<form action="removeGame.php" method="post"> <input type="hidden" name="id" value="' . $result['id'] . '"/> <button type="submit">Delete Game</button></form>';
        }
    ?>
</body>
</html>