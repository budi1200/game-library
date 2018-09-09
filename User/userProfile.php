<?php
    require("../connect.php");
    require("../requireLogin.php");

    $sql = $conn->prepare("SELECT name, username, email FROM users WHERE id=?");
    $sql->execute(array($_SESSION['user_id']));
    $result = $sql->fetch();
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

        echo $result['name'] . "<br/>";
        echo $result['username'] . "<br/>";
        echo $result['email'] . "<br/>";
    ?>
</body>
</html>