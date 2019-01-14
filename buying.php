<?php
/**
 * Created by PhpStorm.
 * User: wyettmacdonald
 * Date: 2019-01-02
 * Time: 14:24
 */
// Initialize the session
session_start();
include "header.php";
include "vars.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$play_name = $_GET["nid"];
$price_query = mysqli_query($link, "SELECT price FROM players WHERE name = '$play_name'");
$row2 = mysqli_fetch_assoc($price_query);
$the_price = $row2["price"];

//$name = $_GET["nid"];
require_once "config.php";

function addData() {
//    echo "hey there";
    $shares = $_POST["shares"];
//    $coins = $_SESSION['coins'];
//    echo $shares;
    $name = $_GET["nid"];
    $sql = "INSERT INTO purchases (name, price, shares, total, buyer_id) VALUES (?,100,1,100*1,1)";
    $myname = $_SESSION['username'];

    /* Attempt to connect to MySQL database */
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $buyer = mysqli_query($link, "SELECT id FROM users WHERE username = '$myname'");
    $row = mysqli_fetch_assoc($buyer);
//    echo $row;
    $buyer_name = $row["id"];

    $coins_q = mysqli_query($link, "SELECT coins FROM users WHERE id=$buyer_name");
    $coins_fetch = mysqli_fetch_assoc($coins_q);
    $coins = $coins_fetch["coins"];

    $shares_q = mysqli_query($link, "SELECT shares_bought FROM players WHERE name='$name'");
    $shares_fetch = mysqli_fetch_assoc($shares_q);
    $prev_shares = $shares_fetch["shares_bought"];

    $price_query = mysqli_query($link, "SELECT price FROM players WHERE name = '$name'");
    $row2 = mysqli_fetch_assoc($price_query);
    $price = $row2["price"];

    if($shares*$price > $coins) {
        echo '<script type="text/javascript"> alert("You need more funds!") </script>';

    }
    else {

        $new_coins = $coins - ($shares*$price);
        $new_shares = ($shares+$prev_shares);

        $num_shares_query_before = mysqli_query($link, "SELECT shares_bought FROM players WHERE name='$name'");
        $share_price_bought_before = mysqli_fetch_assoc($num_shares_query_before);
        $num_shares_bought_before = $share_price_bought_before["shares_bought"];

        $coin_query = mysqli_query($link, "UPDATE users SET coins=$new_coins WHERE id=$buyer_name");
        $share_query = mysqli_query($link, "UPDATE players SET shares_bought='$new_shares' WHERE name='$name'");

        $num_shares_query = mysqli_query($link, "SELECT shares_bought FROM players WHERE name='$name'");
        $share_price_bought = mysqli_fetch_assoc($num_shares_query);
        $num_shares_bought = $share_price_bought["shares_bought"];

        $num_shares_sold_query = mysqli_query($link, "SELECT shares_sold FROM players WHERE name='$name'");
        $share_price_sold = mysqli_fetch_assoc($num_shares_sold_query);
        $num_shares_sold = $share_price_sold["shares_sold"];

        if((($num_shares_bought_before - $num_shares_sold) < 10) && (($num_shares_bought - $num_shares_sold) >= 10) or (($num_shares_bought_before - $num_shares_sold) < 10) && (($num_shares_bought - $num_shares_sold) >= 10)) {
            $new_price = $price*1.1;
            $num_shares_q = mysqli_query($link, "UPDATE players SET price='$new_price' WHERE name='$name'");

        }
//        mysqli_fetch_assoc($coin_query);
        $sql = "INSERT INTO purchases (name, price, shares, total, buyer_id) VALUES (?,$price,$shares,$price*$shares,$buyer_name)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_name);

            // Set parameters
            $param_name = $name;

            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                $message = "Successfully Bought $name";
                header("Location: feed.php?Message=" . urlencode($message));

                mysqli_stmt_close($stmt);

            } else {
                echo mysqli_stmt_error($stmt);
                echo "Something went wrong. Please try again later.";
            }
        }
    }
}

if(isset($_POST['bought'])) {
    $val = $_POST['shares'];
    if($val == 0) { ?>
        <script>
            alert("Please select valid number of shares")
        </script>
        <?php
    }
    else {
        addData();
    }
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
        #about-us{ width: 50%; align-self: center;}
    </style>
    <script>
        document.title = "Buy Shares";
        function shareFunction(e) {
            document.getElementById("total_with_shares").innerHTML = (e.target.value*(<?php echo $the_price; ?>))
        }
    </script>
</head>
<body>
<div>
    <p id="buy-name"> Buy <strong><?php echo $_GET["nid"] ?></strong></p>
        <form action="" method="post">
        <select id="shares" name="shares" onchange="shareFunction(event)">
            <option selected="selected" value="0">Select Shares</option>
            <?php for ($i = 1; $i <= 20; $i++) : ?>
                <option name="share_num" value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select>
            <br>
            <h3><span id="total_with_shares"></span> Coins</h3>
        <input class="buy-button" type="submit" name="bought" value="BUY" />
        </form>
    <br>
</div>

<p>
    <a href="logout.php" class="sign-out-button">Sign Out of Your Account</a>
</p>
</body>
</html>