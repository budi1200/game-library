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
    <?php echo "<title>Edit Game</title>"?>
</head>
<body>
    <?php
        $sql = $conn->prepare("SELECT * FROM games WHERE id=?");
        $sql->execute(array($_POST['game_id']));
        $result = $sql->fetch();
        echo "asdddddd " . $result['title'];
    ?>
    <form action="" method="post">
        <label>Title:</label><input type="text" name="title" <?php echo 'value="'.$result['title'].'"'?> />
        <label>Description:</label><input type="text" name="about" <?php echo 'value="'.$result['about'].'"'?> />
        <label>Genre</label><input type="text" name="genre" <?php echo 'value="'.$result['genre'].'"'?> />
        <label>Release year:</label><input type="text" name="release_year" <?php echo 'value="'.$result['release_year'].'"'?> /> <!-- TODO: Modify to accept only year -->
        <label>Developer:</label><input type="text" name="developer" <?php echo 'value="'.$result['developer'].'"'?> />
        <label>Website:</label><input type="text" name="website_url" <?php echo 'value="'.$result['website_url'].'"'?> />
        <input type="hidden" name="game_id" <?php echo 'value="'.$_POST['game_id'].'"'?> />
        <button type="submit" name="submit">Save</button>
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
            $id = $_POST['game_id'];

            try{
                $sql2 = $conn->prepare("UPDATE games SET title=?, about=?, genre=?, release_year=?, developer=?, website_url=? WHERE id=?");
                $sql2->execute(array($title, $about, $genre, $release_year, $developer, $website, $id));
                header("Location: ./gameDetails.php?game_id=$id");
            }catch(PDOException $err){
                echo "Error editing game";
            }
        }
    ?>
</body>
</html>