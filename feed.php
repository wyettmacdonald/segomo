<?php
/**
 * Created by PhpStorm.
 * User: wyettmacdonald
 * Date: 2018-12-22
 * Time: 14:47
 */


// Initialize the session
session_start();

include "header.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

if (isset($_GET['Message'])) {
    print '<script type="text/javascript">alert("' . $_GET['Message'] . '");</script>';
}

require_once "config.php";

include "vars.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feed</title>
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
    <link rel="stylesheet" href="Segomo.css">
    <script language="JavaScript">
        document.title = "Feed";
        function clic(variable)
        {
            var id = document.getElementById(variable);
            window.location.href="buying.php?nid=" + id.value;
        }
    </script>
</head>
<body>
<h2>Buy Shares</h2>
<h2>Take your pick of players, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h2>


<div class="page-header">
    <div class="player-feed">
        <p>
        <?php
        $link = new PDO("pgsql:dbname='d9gpjimto8jmv4';host='ec2-54-225-121-235.compute-1.amazonaws.com'", DB_USERNAME, DB_PASSWORD);

        $query = $link->query("SELECT * FROM players ORDER BY price DESC");
        echo "<tr>";

        $id_counter = 0;
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
                <?php
                echo $row['name'] . "<br>";
                echo $row['school'] . " College" . "<br>";
                echo "<strong>" . $row['price'] . "</strong>";
                ?>
                <td>
                    <br>
                    <button id="<?php echo $row['id']; ?>" onclick="clic(<?php echo $row['id']; ?>)" name="buy" style="width:auto;" value="<?php echo $row['name']; ?>">Buy Shares</button>
                    <br>
                    <!--                    --><?php $id_counter++; ?>
                </td>
            </tr>
            <br>
            <?php
        }
            ?>
        </p>
    </div>
    <div class="wb-twitter" style="float: margin: auto" >
        <a class="twitter-timeline" href="https://twitter.com/NESCACicehockey?ref_src=twsrc%5Etfw">NESCAC Ice Hockey Tweets</a>
        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
    <div class="teams">
    <table bgcolor="FFFFFF" width="100%" >
        <tbody>
        <tr>
            <th bgcolor="#9370db"><font face="Verdana,Arial,Helvetica" size="-1" color="FEFEFE">NESCAC Teams</font></th>
        </tr>
        <tr>
            <td valign="top"><font face="Verdana,Arial,Helvetica" size="5">
                    <a href="amherst.php">Amherst</a><br>
                    <a href="bowdoin.php">Bowdoin</a><br>
                    <a href="colby.php">Colby</a><br>
                    <a href="conn.php">Connecticut College</a><br>
                    <a href="hamilton.php">Hamilton</a><br>
                    <a href="midd.php">Middlebury</a><br>
                    <a href="trinity.php">Trinity</a><br>
                    <a href="tufts.php">Tufts</a><br>
                    <a href="wesleyan.php">Wesleyan</a><br>
                    <a href="williams.php">Williams</a><br>
                </font>
            </td>
        </tr>
        </tbody>
    </table>
    </div>
    <span></span>
</div>
<a href="logout.php" class="sign-out-button">Sign Out of Your Account</a>
</body>
</html>
