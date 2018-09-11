<?php
    require("../connect.php");
    require("../requireLogin.php");

    // Get game info
    $sql = $conn->prepare("SELECT * FROM games WHERE id=?");
    $sql->execute(array($_POST['game_id']));
    $result = $sql->fetch();

    //Check if logged in user is the owner of the game
    if($_SESSION['user_id'] != $result['user_id']){
        header("Location: /game-library/index.php");
    }

    // include header
    $title = 'Game Library | Edit Game';
    require('../components/header.php');
?>
    <form action="" method="post" enctype="multipart/form-data">
        <label>Title:</label><input type="text" name="title" <?php echo 'value="'.$result['title'].'"'?> required/>
        <label>Description:</label><input type="text" name="about" <?php echo 'value="'.$result['about'].'"'?> required/>
        <label>Genre</label><input type="text" name="genre" <?php echo 'value="'.$result['genre'].'"'?> required/>
        <label>Release year:</label><input type="number" name="release_year" <?php echo 'value="'.$result['release_year'].'"'?> required/>
        <label>Developer:</label><input type="text" name="developer" <?php echo 'value="'.$result['developer'].'"'?> required/>
        <label>Website:</label><input type="text" name="website_url" <?php echo 'value="'.$result['website_url'].'"'?> required/>
        <label>Change image:</label><input type="file" name="new-img"/>
        <input type="hidden" name="current_img_id" <?php echo 'value="' . $result['image_id'] . '"'?> />
        <input type="hidden" name="game_id" <?php echo 'value="'.$_POST['game_id'].'"'?> />
        <button type="submit" name="submit">Save</button>
    </form>

    <?php
        // handle save button press
        if(isset($_POST['submit'])){
            $title = $_POST['title'];
            $about = $_POST['about'];
            $genre = $_POST['genre'];
            $release_year = $_POST['release_year'];
            $developer = $_POST['developer'];
            $website = $_POST['website_url'];
            $user_id = $_SESSION['user_id'];
            $img_id = $_POST['current_img_id'];
            $id = $_POST['game_id'];
            $error = false;


            // Check if a new file was choosen, then delete the old image on disk and database then add new image
            if(strlen($_FILES['new-img']['name']) > 0){
                $sql_old_img = $conn->prepare("SELECT url FROM images WHERE id=?");
                $sql_old_img->execute(array($_POST['current_img_id']));
                $result_old_img = $sql_old_img->fetch();
                $old_img_path =  "../" . substr($result_old_img['url'], 14);
                unlink(realpath($old_img_path));
                $conn->prepare("DELETE FROM images WHERE id=?")->execute(array($img_id));

                if($_FILES['new-img']['error'] > 0){
                    echo 'Error uploading image';
                    $error = true;
                }else{
                    $extsAllowed = array( 'jpg', 'jpeg', 'png', 'gif' );
                    $extUpload = strtolower( substr( strrchr($_FILES['new-img']['name'], '.') ,1) ) ;
                    $name = "/game-library/img/{$_FILES['new-img']['name']}";
                    $result_img = move_uploaded_file($_FILES['new-img']['tmp_name'], "../img/{$_FILES['new-img']['name']}");
                    $sql_img = $conn->prepare("INSERT INTO images(url) VALUES (?)");
                    $sql_img->execute(array($name));
                    $new_img_id = $conn->lastInsertId();
                }
            }else{
                $new_img_id = $img_id;
            }

            // Check if image upload had erros and then update game
            if(!$error){
                try{
                    $sql2 = $conn->prepare("UPDATE games SET image_id=?, title=?, about=?, genre=?, release_year=?, developer=?, website_url=? WHERE id=?");
                    $sql2->execute(array($new_img_id, $title, $about, $genre, $release_year, $developer, $website, $id));
                    header("Location: ./gameDetails.php?game_id=$id");
                }
                catch(PDOException $err){
                    echo "Error editing game";
                }
            }
        }
    ?>
</body>
</html>