<?php
    include './connect.php';
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Game Library</title>
</head>
<body>
    <?php
        if(isset($_SESSION['user_id'])){
            echo "Hello" . $_SESSION['username'];
        }
    ?>
</body>
</html>