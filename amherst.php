<?php
/**
 * Created by PhpStorm.
 * User: wyettmacdonald
 * Date: 2019-01-08
 * Time: 16:23
 */
session_start();
require_once "config.php";
include "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Amherst</title>
    <link rel="stylesheet" href="Segomo.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
    <script language="JavaScript">
        document.title = "Amherst"
        function clic(variable)
        {
            var id = document.getElementById(variable);
            window.location.href="buying.php?nid=" + id.value;
        }
    </script>
</head>
<body>
<div >
    <h2>Buy Amherst Player Shares</h2>
    <h2>Take your pick of players, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h2>
</div>
<div class="page-header">
    <div class="player-feed" style="width: 30%; margin: 0 auto;">
        <p>
            <?php
            $link = new PDO("pgsql:dbname='d9gpjimto8jmv4';host='ec2-54-225-121-235.compute-1.amazonaws.com'", DB_USERNAME, DB_PASSWORD);

            $query = $link->query("SELECT * FROM players WHERE school='Amherst' ORDER BY price DESC");
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
                        <button id="<?php echo $row['id']; ?>" onclick="clic(<?php echo $row['id']; ?>)" name="buy" style="width:auto;" value="<?php echo $row['id']; ?>">Buy Shares</button>
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