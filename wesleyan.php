<?php
/**
 * Created by PhpStorm.
 * User: wyettmacdonald
 * Date: 2019-01-08
 * Time: 18:20
 */
session_start();
require_once "config.php";
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
    <script language="JavaScript">
        document.title = "Wesleyan"

        function clic(variable)
        {
            var id = document.getElementById(variable);
            window.location.href="buying.php?nid=" + id.value;
        }
    </script>
</head>
<body>
<div >
    <h2>Buy Wesleyan Player Shares</h2>
    <h2>Take your pick of players, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h2>
</div>
<div class="page-header">
    <div class="player-feed" style="width: 30%; margin: 0 auto;">
        <p>
            <?php
            $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

            $query = mysqli_query($link, "SELECT * FROM players WHERE school='wesleyan' ORDER BY price DESC");
            echo "<tr>";

            $id_counter = 0;
            while ($row = mysqli_fetch_array($query, MYSQLI_NUM)) { ?>
                <tr>
                    <?php
                    echo $row[1] . "<br>";
                    echo $row[3] . " College" . "<br>";
                    echo "<strong>" . $row[2] . "</strong>";
                    ?>
                    <td>
                        <br>
                        <button id="<?php echo $row[0]; ?>" onclick="clic(<?php echo $row[0]; ?>)" name="buy" style="width:auto;" value="<?php echo $row[1]; ?>">Buy Shares</button>
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
</div>
<br>
<p>
    <a href="logout.php" class="sign-out-button">Sign Out of Your Account</a>
</p>
</body>
</html>