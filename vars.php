<?php
/**
 * Created by PhpStorm.
 * User: wyettmacdonald
 * Date: 2019-01-07
 * Time: 14:10
 */


// Initialize the session
//session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";

$myname = $_SESSION['username'];
$buyer = $link->query("SELECT id FROM users WHERE username= '$myname'");
//$buyer = pg_query($link,"SELECT id FROM users WHERE username = '$myname'");
$row = $buyer->fetch(PDO::FETCH_ASSOC);
$buyer_id = $row['id'];

$coin_query = $link->query("SELECT coins FROM users WHERE id = '$buyer_id'");
$row2 = $coin_query->fetch(PDO::FETCH_ASSOC);
$user_coins = $row2['coins'];

//$num_shares_query = $link->query("SELECT shares_sold FROM players WHERE ")




?>