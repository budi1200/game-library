<?php
    include './connect.php';
    session_start();

    if(isset($_POST['submit'])){
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $sql = $conn->prepare("SELECT password, id FROM users WHERE username=?");
        $sql->execute(array($username)); // insert username and execute
        $result = $sql->fetch();

        $hash = $result['password'];
        $user_id = $result['id'];

        if(password_verify($password, $hash)){
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            header("Location: ./");
        }else{
            echo "Password is invalid";
        }

    }
?>

<form action="" method="post">
    <label>Username</label><input type="text" name="username"/>
    <label>Password</label><input type="password" name="password"/>
    <button type="submit" name="submit">login</form>
</form>