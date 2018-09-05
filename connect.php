<?php
    $conn = mysqli_connect("localhost", "root", "", "game-library");
    mysqli_set_charset($conn, 'utf-8');
    if($conn){
        //echo 'connected';
    }else{
        echo 'Database connection error';
    }
?>