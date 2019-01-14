<?php
/**
 * Created by PhpStorm.
 * User: wyettmacdonald
 * Date: 2019-01-07
 * Time: 18:44
 */

include "vars.php";
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="Segomo.css"">
</head>
<body>

<div class="header">
    <a href="welcome.php" class="logo">Segomo</a>
    <div class="header-right">
        <a class="coins">Coins: <?php echo $user_coins; ?></a>
        <a class="active" href="welcome.php">Home</a>
        <a href="feed.php">Feed</a>
        <a href="profile.php">Profile</a>
    </div>
</div>
</body>
</html>
