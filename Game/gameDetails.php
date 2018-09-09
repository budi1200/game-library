<?php
    require('../connect.php');
    session_start();

    // checks if game id is set and exists or sends to 404 page
    if(isset($_GET['game_id'])){
        $game_id = $_GET['game_id'];
        
        $sql = $conn->prepare("SELECT g.*, i.url FROM games g INNER JOIN images i ON g.image_id=i.id WHERE g.id=?");
        $sql->execute(array($game_id));
        $result = $sql->fetch();
        if(!$result){
            header("Location: ../404.php");
        }
    }else{
        header("Location: ../404.php");
    }

    // Checks if user has already rated this game
    if(isset($_SESSION['user_id'])){
        $sql_checkRating = $conn->prepare("SELECT id FROM ratings WHERE user_id=? AND game_id=?");
        $sql_checkRating->execute(array($_SESSION['user_id'], $result['id']));
        $rating_result = $sql_checkRating->fetch();
        if($rating_result){
            $rateString = "Update Rating";
        }else{
            $rateString = "Rate";
        }
    }
    // handles user rating the game
    if(isset($_POST['rating'])){
        $rating = $_POST['rating'];
        if($rating_result){
            $sql_rate = $conn->prepare("UPDATE ratings SET rating=? WHERE user_id=? AND game_id=?");
            $sql_rate->execute(array($rating, $_SESSION['user_id'], $_GET['game_id']));
        }else{
            $sql_rate = $conn->prepare("INSERT INTO ratings(game_id, user_id, rating) VALUES (?,?,?)");
            $sql_rate->execute(array($_GET['game_id'], $_SESSION['user_id'], $rating));
            header("Refresh:0");
        }
    }

    //gets average user rating
    $sql_avgRating = $conn->prepare("SELECT AVG(rating) AS avgRating FROM ratings WHERE game_id=?");
    $sql_avgRating->execute(array($_GET['game_id']));
    $result_avgRating = $sql_avgRating->fetch();

    // handles comment button
    if(isset($_POST['text'])){
        $sql_comment = $conn->prepare("INSERT INTO comments(user_id, game_id, comment) VALUES (?,?,?)");
        $sql_comment->execute(array($_SESSION['user_id'], $_GET['game_id'], $_POST['text']));
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
        // include header
        require("../components/header.php");

        echo $result['title'] . "<br/>";
        echo $result['about'] . "<br/>";
        echo $result['genre'] . "<br/>";
        echo $result['release_year'] . "<br/>";
        echo $result['developer'] . "<br/>";
        echo $result['website_url'] . "<br/>";
        echo '<img src="' . $result['url'] . '"/><br/>';
        echo "Average user rating: " . $result_avgRating['avgRating'] . "<br/>";
        // if logged in show rate button
        if(isset($_SESSION['user_id'])){
            echo '<form action="" method="post"><label>Rating: </label><input type="number" max=5 min=1 value=3 name="rating"/><br/><button type="submit">'.$rateString.'</button></form>';
        }

        // if owner show edit and delete buttons
        if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $result['user_id']){
            echo '<form action="editGame.php" method="post"> <input type="hidden" name="game_id" value="' . $result['id'] . '"/> <button type="submit">Edit Game</button></form>';
            echo '<form action="removeGame.php" method="post"> <input type="hidden" name="id" value="' . $result['id'] . '"/> <button type="submit">Delete Game</button></form>';
        }

        // **COMMENT SECTION**
        echo '<form action="" method="post">';
            echo '<textarea name="text"></textarea>';
            echo '<button type="submit">Comment</button>';
        echo '</form>';

        $sql_comments = $conn->prepare("SELECT c.comment, c.addedTime, u.username, i.url FROM comments c INNER JOIN users u ON u.id=c.user_id INNER JOIN images i ON u.image_id=i.id WHERE c.game_id=? ORDER BY c.addedTime DESC");
        $sql_comments->execute(array($_GET['game_id']));
        $result_comments = $sql_comments->fetchAll();

        foreach($result_comments as $row){
            echo '<img height=50 src="' . $row['url'] . '"/>';
            echo $row['username'] . "<br/>";
            echo $row['addedTime'] . "<br/>";
            echo $row['comment'] . "<br/>";
            if(isset($_SESSION['user_id']) && $_SESSION['username'] == $row['username']){
                echo '<form action="/game-library/comments/editComment.php" method="post">';
                    echo '<input type="hidden" name="game_id" value="' . $_GET['game_id'] . '"/>';
                    echo '<input type="hidden" name="time" value="' . $row['addedTime'] . '"/>';
                    echo '<button type="submit">Edit Comment</button>';
                echo '</form>';
                
                echo '<form action="/game-library/comments/removeComment.php" method="post">';
                    echo '<input type="hidden" name="game_id" value="' . $_GET['game_id'] . '"/>';
                    echo '<input type="hidden" name="time" value="' . $row['addedTime'] . '"/>';
                    echo '<button type="submit">Delete comment</button>';
                echo '</form>';
            }
        }
    ?>
</body>
</html>