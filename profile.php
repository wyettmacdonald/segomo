<?php
/**
 * Created by PhpStorm.
 * User: wyettmacdonald
 * Date: 2018-12-29
 * Time: 20:28
 */

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";

include "header.php";
include "vars.php";

if(isset($_POST['sell'])) {
    sellShares();
}

function sellShares() {
    $player_name = $_POST["player_name"];
    $shares = $_POST["shares"];
    $p_id = $_POST['pid'];
    $myname = $_SESSION['username'];


    /* Attempt to connect to MySQL database */
    $link = new PDO("pgsql:dbname='d9gpjimto8jmv4';host='ec2-54-225-121-235.compute-1.amazonaws.com'", DB_USERNAME, DB_PASSWORD);
    $buyer = $link->query("SELECT id FROM users WHERE username = '$myname'");
    $row = $buyer->fetch(PDO::FETCH_ASSOC);
    $buyer_id = $row['id'];

    $coins_query = $link->query("SELECT coins FROM users WHERE id=$buyer_id");
    $coins_fetch = $coins_query->fetch(PDO::FETCH_ASSOC);
    $coins = $coins_fetch["coins"];

    $price_query = $link->query("SELECT price FROM players WHERE name='$player_name'");
    $row2_fetch = $price_query->fetch(PDO::FETCH_ASSOC);
    $price = $row2_fetch['price'];

    $share_sold_query = $link->query("SELECT shares_sold FROM players WHERE name='$player_name'");
    $row2_fetch_sold = $share_sold_query->fetch(PDO::FETCH_ASSOC);
    $prev_shares_sold = $row2_fetch_sold['shares_sold'];

    $new_coins = $coins + ($shares*$price);


    $new_shares_sold = ($prev_shares_sold+$shares);
    $shares_sold_q = $link->query("UPDATE players SET shares_sold='$new_shares_sold' WHERE name='$player_name'");

    $coin_query = $link->query("UPDATE users SET coins=$new_coins WHERE id=$buyer_id");
    $sql = $link->query("UPDATE purchases SET buyer_id=NULL WHERE id=$p_id");

    $num_shares_query = $link->query("SELECT shares_sold FROM players WHERE name='$name'");
    $share_price = $num_shares_query->fetch(PDO::FETCH_ASSOC);
    $num_shares = $share_price['shares_sold'];

    $num_shares_query_sold = $link->query("SELECT shares_bought FROM players WHERE name='$player_name'");
    $share_price_sold = $num_shares_query_sold->fetch(PDO::FETCH_ASSOC);
    $num_shares_bought = $share_price_sold['shares_bought'];

    if((($num_shares_bought - $prev_shares_sold) >= 20) && (($num_shares_bought - $new_shares_sold) < 20) or (($num_shares_bought - $prev_shares_sold) >= 40) && (($num_shares_bought - $new_shares_sold) < 40)) {
        $new_price = $price*0.95;
        $num_shares_q = $link->query("UPDATE players SET price='$new_price' WHERE name='$player_name'");

    }



    $message = "Sucessfully Sold $player_name";
    header("Location: feed.php?Message=" . urlencode($message));

}

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
    <script>
        document.title = "Profile"
    </script>
</head>
<body>
<div >
    <h1><b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>'s Portfolio</h1>
    <div class="portfolio">
        <table id="port-table" align="center" cellpadding="15">
            <tr id="port-headers">
                <th>Player</th>
                <th>Purchased Price</th>
                <th>Current Price</th>
                <th>Shares</th>
                <th>Sell For</th>
            </tr>
            <?php

            $username = $_SESSION["username"];
            $link = new PDO("pgsql:dbname='d9gpjimto8jmv4';host='ec2-54-225-121-235.compute-1.amazonaws.com'", DB_USERNAME, DB_PASSWORD);
            $buyer = $link->query("SELECT users.id FROM users WHERE username='$username'");
            $row = $buyer->fetch(PDO::FETCH_ASSOC);
            $my_id = intval($row['id']);

            $port = $link->query("SELECT * FROM purchases WHERE buyer_id='$my_id'");

            //            $port = $link->query("SELECT purchases.* FROM users JOIN purchases ON (users.id = purchases.buyer_id) WHERE buyer_id='$my_id'");

            //            echo mysqli_errno($link);
//            $port_array = array();
            $counter = 0;
            $total = 0;
            while($row = $port->fetch(PDO::FETCH_ASSOC)) {
                $port_array[$counter] = $row['name'];
                $counter++;
                echo "<tr>";
                $the_name = $row['name'];
                $num_shares = $row['shares'];
                $purchase_id = $row['id'];
                echo "<td>" . $the_name . "</td>";
                echo "<td>" . floatval($row['price']) . "</td>";
                $current_price = $link->query("SELECT price FROM players WHERE name='$the_name'");
                $cp = $current_price->fetch(PDO::FETCH_ASSOC);;
                $cur_price = $cp['price'];
                if($cur_price > $row['price'] or $cur_price == $row['price']) {
                    echo "<td><font color='green'><strong>" . $cur_price . "</strong></font></td>";
                }
                else {
                    echo "<td><font color='red'><strong>" . $cur_price . "</strong></font></td>";
                }
                echo "<td>" . $row['shares'] . "</td>";
                echo "<td>" . ($row['shares']*$cur_price) . "</td>";
                echo "<td>";
                echo "<form action='profile.php' method='post'>";
                echo "<input class='sell-button' type='submit' name='sell' value='SELL' />";
                echo "<input type='hidden' name='player_name' value= '$the_name'/>";
                echo "<input type='hidden' name='shares' value= '$num_shares'/>";
                echo "<input type='hidden' name='pid' value= '$purchase_id'/>";
                echo "</form>";
                echo "</td>";
                $total += ($row['shares']*$cur_price);
                echo "</tr>";
            }

//            $counts = array_count_values($port_array);

            ?>
        </table>
        <h3 id="total">
            Total is <strong><?php echo $total; ?></strong>
        </h3>
    </div>
</div>
<br>
<p>
    <a href="logout.php" class="sign-out-button">Sign Out of Your Account</a>
</p>
</body>
</html>