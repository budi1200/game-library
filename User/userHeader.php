<div class="header-links"> 
    <?php
        echo '<a class="' . (isset($userProfile) ? "active" : null) . '" href="./userProfile.php">User Info</a>';
        echo '<a class="' . (isset($userGames) ? "active" : null) . '" href="./userGames.php">User Games</a>';
        echo '<a class="' . (isset($userComments) ? "active" : null) . '" href="./userComments.php">User Comments</a>';
    ?>
</div>