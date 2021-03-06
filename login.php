<?php
    include './connect.php';
    require("./components/header.php");
    require("../google_codes.php");
    session_start();

    // google auth
    require ("vendor/autoload.php");
    //

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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="./css/style.css"/>
    <title>Game Library | Login</title>
</head>
    <body>
        <form action="" method="post">
            <label>Username</label><input type="text" name="username"/>
            <label>Password</label><input type="password" name="password"/>
            <button type="submit" name="submit">login</button></form> <br/>
        </form>

        <?php

            //Step 1: Enter you google account credentials
            $g_client = new Google_Client();
            $g_client->setClientId($client_id);
            $g_client->setClientSecret($client_secret);
            $g_client->setRedirectUri("http://localhost/game-library/login.php");
            $g_client->setScopes(array(
                "https://www.googleapis.com/auth/userinfo.email",
                "https://www.googleapis.com/auth/userinfo.profile",
                "https://www.googleapis.com/auth/plus.me"
                ));
            
            //Step 2 : Create the url
            $auth_url = $g_client->createAuthUrl();
            echo "<a href='$auth_url'><img id='google_login' width=200 src='./img/btn_google_signin_light_normal_web2x.png'/></a>";
            
            //Step 3 : Get the authorization  code
            $code = isset($_GET['code']) ? $_GET['code'] : NULL;
            
            //Step 4: Get access token
            if(isset($code)) {
                try {
                    $token = $g_client->fetchAccessTokenWithAuthCode($code);
                    $g_client->setAccessToken($token);
                }catch (Exception $e){
                    echo $e->getMessage();
                }
                try {
                    $pay_load = $g_client->verifyIdToken();
                }catch (Exception $e) {
                    echo $e->getMessage();
                }
            } else{
                $pay_load = null;
            }
            // if payload is set execute login or register
            if(isset($pay_load)){
            
                $sql_check = $conn->prepare("SELECT id FROM users WHERE email=?");
                $sql_check->execute(array($pay_load['email']));
                $result_check = $sql_check->fetch();
                echo $result_check['id'];
            
                if($result_check){
                    // login
                    $sql = $conn->prepare("SELECT password, id FROM users WHERE email=?");
                    $sql->execute(array($pay_load['email'])); // insert email and execute
                    $result = $sql->fetch();
                
                    $hash = $result['password'];
                    $user_id = $result['id'];
                
                    if(password_verify($pay_load['sub'], $hash)){
                        $_SESSION['user_id'] = $user_id;
                        header("Location: ./");
                    }else{
                        echo "Password is invalid";
                    }
                }else{
                    //register
                    $token_hash = password_hash($pay_load['sub'], PASSWORD_DEFAULT);
                    try{
                        $sql_register = $conn->prepare("INSERT INTO users(name, username, email, password) VALUES (?,?,?,?)");
                        $sql_register->execute(array($pay_load['name'], $pay_load['email'], $pay_load['email'], $token_hash));
                        $_SESSION['user_id'] = $conn->lastInsertId();
                        header("Location: ./");
                    }catch(PDOException $e){
                        echo "Error: " . $e->getMessage();
                    }
                
                }

            }
        
        ?>
        <script src="./js/script.js"></script>
    </body>
</html>