<div>
    <h3>Game Library</h3>
    <div class="header-wrapper">
        <?php
            if(isset($_SESSION['user_id'])){
                echo '<a href="addGame.php>Add Game</a>';
                echo '<a href="logout.php">Logout</a>';
            }else{
                echo '<a href="login.php">Login</a>';
                echo '<a href="register.php">Register</a>';
            }
        ?>
    </div>
</div>