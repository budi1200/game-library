<?php
    require("../connect.php");
    require("../requireLogin.php");

    // include header
    $title = "Game Library | Add Game";
    $add = true;
    require('../components/header.php');
?>

    <form action="" method="post" enctype="multipart/form-data">
        <label>Title:</label><input type="text" name="title" required/>
        <label>Description:</label><input type="text" name="about" required/>
        <label>Genre</label><input type="text" name="genre" required/>
        <label>Release year:</label><input type="number" name="release_year" required/>
        <label>Developer:</label><input type="text" name="developer" required/>
        <label>Website:</label><input type="text" name="website_url" required/>
        <label>Poster image:</label><input type="file" name="img-file" required/>
        <button type="submit" name="submit">Add Game</button>
    </form>

    <?php
        // handle add game button press
        if(isset($_POST['submit'])){
            $title = $_POST['title'];
            $about = $_POST['about'];
            $genre = $_POST['genre'];
            $release_year = $_POST['release_year'];
            $developer = $_POST['developer'];
            $website = $_POST['website_url'];
            $user_id = $_SESSION['user_id'];


            // Handle image upload
            if($_FILES['img-file']['error'] > 0){ 
                echo 'Error during uploading, try again'; 
            }
            
            $extsAllowed = array( 'jpg', 'jpeg', 'png', 'gif' );
            $extUpload = strtolower( substr( strrchr($_FILES['img-file']['name'], '.') ,1) ) ;
            $name = "/game-library/img/{$_FILES['img-file']['name']}";
            $result3 = move_uploaded_file($_FILES['img-file']['tmp_name'], "../img/{$_FILES['img-file']['name']}");
            $sql_img = $conn->prepare("INSERT INTO images(url) VALUES (?)");
            $sql_img->execute(array($name));
            $img_id = $conn->lastInsertId();

            // on successful upload insert game into database
            if($result3){                
                try{
                    $sql = $conn->prepare("INSERT INTO games(user_id, image_id, title, about, genre, release_year, developer, website_url) VALUES (?,?,?,?,?,?,?,?)");
                    $sql->execute(array($user_id, $img_id, $title, $about, $genre, $release_year, $developer, $website));
                    $sql2 = $conn->prepare("SELECT id FROM games WHERE user_id=? AND title=?");
                    $sql2->execute(array($user_id, $title));
                    $result = $sql2->fetch();
                    header("Location: ./gameDetails.php?game_id=".$result['id']);
                }catch(PDOException $err){
                    echo "Error";
                }
            }else{
                echo "Error";
            }
        }
    ?>
</body>
</html>