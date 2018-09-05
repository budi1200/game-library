<?php
    include './connect.php';

    if(isset($_POST['submit'])){
        $name = mysqli_real_escape_string($conn, trim($_POST['name']));
        $username = mysqli_real_escape_string($conn, trim($_POST['username'])); 
        $email = mysqli_real_escape_string($conn, trim($_POST['email']));
        $password = mysqli_real_escape_string($conn, trim($_POST['password']));

        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $sql);

        // Check if username exists and password is less than 6 chars.
        if(mysqli_fetch_row($result)){
            echo "username exists";
        }else if(strlen($password) < 6){
            echo "password too short";
        }

        if(!mysqli_fetch_row($result) && strlen($password) >= 6){
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            $sql2 = "INSERT INTO users(name, username, email, password) VALUES ('$name', '$username', '$email', '$pass_hash')";
            if(mysqli_query($conn, $sql2)){
                echo "Success";
            }else{
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