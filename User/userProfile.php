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
    <title>User Profile</title>
</head>
<body>
    <?php
        require("../components/header.php");
        require("./userHeader.php");

        // get user data
        $sql = $conn->prepare("SELECT u.name, u.username, u.email, i.url, i.id AS img_id FROM users u INNER JOIN images i ON u.image_id=i.id WHERE u.id=?");
        $sql->execute(array($_SESSION['user_id']));
        $result = $sql->fetch();

        echo '<img height=150 src="' . $result['url'] . '"/><br/>';
    ?>
        <form action="" method="post" enctype="multipart/form-data">
            <label>Change profile image: </label><input type="file" name="new-img"/> <br/>
            <label>Name: </label><input type="text" name="name" <?php echo 'value="'.$result['name'].'"'?> required/> <br/>
            <label>Username: </label><input type="text" name="username" <?php echo 'value="'.$result['username'].'"'?> required/> <br/>
            <input type="hidden" name="current_img_id" <?php echo 'value="' . $result['img_id'] . '"' ?> /> <br/>
            <button type="submit" name="submit">Save</button>
        </form>

    <?php

        // handle submit button
        if(isset($_POST['submit'])){
            $user_name = $_POST['name'];
            $username = $_POST['username'];
            $error = false;
            $current_img_id = $_POST['current_img_id'];

            // check if new image was chosen
            if(strlen($_FILES['new-img']['name']) > 0){
                if($_POST['current_img_id'] != 1){
                    $sql_old_img = $conn->prepare("SELECT url FROM images WHERE id=?");
                    $sql_old_img->execute(array($_POST['current_img_id']));
                    $result_old_img = $sql_old_img->fetch();
                    $old_img_path =  "../" . substr($result_old_img['url'], 14);
                    unlink(realpath($old_img_path));
                    $conn->prepare("DELETE FROM images WHERE id=?")->execute(array($current_img_id));
                }

                // check for image upload errors
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
                $new_img_id = $current_img_id;
            }

            // if no errors, execute query
            if(!$error){
                try{
                    $sql2 = $conn->prepare("UPDATE users SET image_id=?, name=?, username=? WHERE id=?");
                    $sql2->execute(array($new_img_id, $user_name, $username, $_SESSION['user_id']));
                    header("Location: ./userprofile.php");
                }
                catch(PDOException $err){
                    echo "Error editing profile";
                }
            }


        }

    ?>
</body>
</html>