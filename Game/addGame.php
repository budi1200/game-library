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
        <label>Developer:</label><input type="text" name="developer"/>
        <label>Website:</label><input type="text" name="website_url"/>
        <button type="submit" name="submit">Add Game</button>
    </form>

    <?php
        if(isset($_POST['submit'])){
            
        }
    ?>
</body>
</html>