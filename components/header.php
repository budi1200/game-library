<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="/game-library/css/style.css"/>
    <title><?php echo $title ?></title>
</head>

<body>
    <div class="header-wrapper">
        <h3>Game Library</h3>
        <div class="header-links-wrapper">
            <div class="header-links">
                <a href="/game-library/index.php">Home</a>
                <?php
                    if(isset($_SESSION['user_id'])){
                        echo '<a class="' . (isset($add) ? "active" : null) . '" href="/game-library/game/addGame.php">Add Game</a>';
                        echo '<a class="' . (isset($profile) ? "active" : null) . '" href="/game-library/user/userProfile.php">Profile</a>';
                        echo '<a href="/game-library/logout.php">Logout</a>';
                    }else{
                        echo '<a href="/game-library/login.php">Login</a>';
                        echo '<a href="/game-library/register.php">Register</a>';
                    }
                ?>
            </div>
            <form action="/game-library/search.php" method="get">
                <input type="text" required name="s"/>
                <button type="submit">Seach</button>
            </form>
        </div>
    </div>