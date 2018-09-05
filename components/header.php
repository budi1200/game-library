<div>
    <h3>Game Library</h3>
    <div>
        <?php
            if(isset($_SESSION['user_id'])){
                echo '<a href="logout.php">Logout</a>';
            }else{
                echo '<a href="login.php">Login</a>';
                echo '<a href="register.php">Register</a>';
            }
        ?>
    </div>
</div>