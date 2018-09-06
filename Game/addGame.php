<?php
    require("../connect.php");
    require("../requireLogin.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="./css/style.css"/>
    <title>Add Game</title>
</head>
<body>
    <form action="" method="post">
        <label>Title:</label><input type="text" name="title"/>
        <label>Description:</label><input type="text" name="about"/>
        <label>Genre</label><input type="text" name="genre"/>
        <label>Release year:</label><input type="text" name="release_year"/> <!-- TODO: Modify to accept only year -->
        <label>Developer:</label><input type="text" name="developer"/>
        <label>Website:</label><input type="text" name="website_url"/>
        <button type="submit" name="submit">Add Game</button>
    </form>

    <?php
        if(isset($_POST['submit'])){
            $title = $_POST['title'];
            $about = $_POST['about'];
            $genre = $_POST['genre'];
            $release_year = $_POST['release_year'];
            $developer = $_POST['developer'];
            $website = $_POST['website_url'];
            $user_id = $_SESSION['user_id'];
            $image_id = 0;

            $sql = $conn->prepare("INSERT INTO games(user_id, image_id, title, about, genre, release_year, developer, website_url) VALUES (?,?,?,?,?,?,?,?)");
            try{
                $sql->execute(array($user_id, $image_id, $title, $about, $genre, $release_year, $developer, $website));
                
                $sql2 = $conn->prepare("SELECT id FROM games WHERE user_id=? AND title=?");
                $sql2->execute(array($user_id, $title));
                $result = $sql2->fetch();
                header("Location: ./gameDetails.php?game_id=".$result['id']);
            }catch(PDOException $err){
                echo "Error";
            }
        }
    ?>
</body>
</html>