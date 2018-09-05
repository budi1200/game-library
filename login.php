<?php
    include './connect.php';
    session_start();

    if(isset($_POST['submit'])){
        $username = mysqli_real_escape_string($conn, trim($_POST['username']));
        $password = mysqli_real_escape_string($conn, trim($_POST['password']));

        $sql = "SELECT password, id FROM users WHERE username= '$username'";
        $query = mysqli_query($conn, $sql);
        echo "<br>";
        while($row = mysqli_fetch_array($query)){
            $hash = $row["password"];
            $user_id = $row['id'];
        }

        if(password_verify($password, $hash)){
            echo "password is valid";
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
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