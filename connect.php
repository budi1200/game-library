<?php

    try{
    $conn = new PDO('mysql:dbname=game-library;host=localhost;charset=utf8', 'root', '');

    // dont parse statements before sending to mysql server; Continue on fatal error
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    }catch(PDOException $err){
        echo "Failed to connect to database: " . $err->getMessage();
    }
?>