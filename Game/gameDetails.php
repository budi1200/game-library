<?php
    require('../connect.php');
    session_start();

    // checks if game id is set and exists or sends to 404 page
    if(isset($_GET['game_id'])){
        $game_id = $_GET['game_id'];
        
        $sql = $conn->prepare("SELECT * FROM games WHERE id=?");
        $sql->execute(array($game_id));
        $result = $sql->fetch();
        if(!$result){
            header("Location: ../404.php");
        }
    }else{
        header("Location: ../404.php");
    }

    // Checks if user has already rated this game
    $sql_checkRating = $conn->prepare("SELECT id FROM ratings WHERE user_id=? AND game_id=?");
    $sql_checkRating->execute(array($_SESSION['user_id'], $result['id']));
    $rating_result = $sql_checkRating->fetch();
    if($rating_result){
        $rateString = "Update Rating";
    }else{
        $rateString = "Rate";
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
        echo "Average user rating: " . $result_avgRating['avgRating'] . "<br/>";
        echo '<form action="" method="post"><label>Rating: </label><input type="number" max=5 min=1 value=3 name="rating"/><br/><button type="submit">'.$rateString.'</button></form>';

        if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $result['user_id']){
            echo '<form action="editGame.php" method="post"> <input type="hidden" name="game_id" value="' . $result['id'] . '"/> <button type="submit">Edit Game</button></form>';
            echo '<form action="removeGame.php" method="post"> <input type="hidden" name="id" value="' . $result['id'] . '"/> <button type="submit">Delete Game</button></form>';
        }
    ?>
</body>
</html>