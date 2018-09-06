<div>
    <h3>Game Library</h3>
    <div class="header-wrapper">
        <a href="/game-library/index.php">Home</a>
        <?php
            if(isset($_SESSION['user_id'])){
                echo '<a href="/game-library/game/addGame.php">Add Game</a>';
                echo '<a href="/game-library/logout.php">Logout</a>';
            }else{
                echo '<a href="/game-library/login.php">Login</a>';
                echo '<a href="/game-library/register.php">Register</a>';
            }
        ?>
    </div>
</div>