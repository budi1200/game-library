<?php
    include './connect.php';

    if(isset($_POST['submit'])){
        $name = trim($_POST['name']);
        $username = trim($_POST['username']); 
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $sql = $conn->prepare("SELECT * FROM users WHERE username=?");
        $sql->execute(array($username));
        $result = $sql->fetch();

        // Check if username exists and password is less than 6 chars.
        if($result){
            echo "Username exists";
        }else if(strlen($password) < 6){
            echo "Password is too short";
        }

        if(!$result && strlen($password) >= 6){
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            $sql2 = $conn->prepare("INSERT INTO users(name, username, email, password) VALUES (?,?,?,?)");
            try{
                $sql2->execute(array($name, $username, $email, $pass_hash));
                header("Location: ./");
            }catch(PDOException $err){
                echo "Error";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>
<body>
    <form action="" method="post">
        <label>Name:</label><input type="text" name="name"/>
        <label>Username:</label><input type="text" name="username"/>
        <label>Email:</label><input type="email" name="email"/>
        <label>Password:</label><input type="password" name="password"/>
        <button type="submit" name="submit">Register</button>
</body>
</html>