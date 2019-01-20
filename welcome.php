<?php
/**
 * Created by PhpStorm.
 * User: macdonaldw15
 * Date: 11/21/18
 * Time: 6:28 PM
 */

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

include "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="Segomo.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<div >
    <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. <br> Welcome to Segomo.</h1>
    <h3 style="color: orangered;">Player stats updated as of January 19, 2019</h3>
    <h2>About Us</h2>
    <p id="about-us">
        Segomo is an application that allows its users to showcase their passion for their favorite sports teams and players.
        By linking market oriented principles to the passion people hold for sports, we strengthen the bond between your sports team and you.

        Our unique proposition connects economic incentive with the true passion behind sports. We further hope to demystify
        the stock market by connecting it to an aspect of life everyone understands.

        It is a live trading application that uses a proprietary algorithm to set up a new market around sports team,
        players, and coaches. We aim to really make the fan a part of the team.
    </p>
    <br>
    <h2 style="color: darkgray">Instructions</h2>
    <p id="instructions">
        <strong>Feed</strong> - The Feed includes a list of players from best to worst, the NESCAC Hockey Twitter account and links to the team pages for each team. To purchase a player either find them on the list of players on the feed or visit a team’s page to view the list of all of the players on that team. Up to 20 shares of a player can be bought at a time and as demand increases for a player their stock price increases correspondingly.
        <br>
        <strong>Profile</strong>- The Profile page shows your portfolio of all current assets and is where the users can sell their shares of different players. Users can sell some or all of the shares that they own of a player at a time and the resulting payout is added to that user’s coin wallet.
        <br>
        <strong style="alignment: left">Coins</strong>- The amount of coins that each user has is located at the top of each page and updates as that user buys and sells.
    </p>
</div>
<br>
<p>
    <a href="logout.php" class="sign-out-button">Sign Out of Your Account</a>
</p>
</body>
</html>