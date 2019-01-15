<?php
/**
 * Created by PhpStorm.
 * User: macdonaldw15
 * Date: 11/21/18
 * Time: 6:26 PM
 */

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    }
    else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

//        echo mysqli_prepare($link, $sql);

        if($stmt = $link->prepare($sql)){

//            $stmt->execute(array($_POST["username"]));
            // Bind variables to the prepared statement as parameters
//            pg_send_query_params($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

//            mysqli_stmt_close($stmt);

            // Attempt to execute the prepared statement
            if($stmt->execute(array($_POST["username"]))) {


                /* store result */
//                mysqli_stmt_store_result($stmt);


                if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                }
                else{
                    $username = trim($_POST["username"]);
//                    mysqli_stmt_close($stmt);
                }
            }
            else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
//        mysqli_stmt_close($stmt);
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, coins) VALUES (?,?, 1000)";

        /* Attempt to connect to MySQL database */
//        $link = mysqli_connect($_SERVER['RDS_HOSTNAME'], $_SERVER['RDS_USERNAME'], $_SERVER['RDS_PASSWORD'], $_SERVER['RDS_DB_NAME'], $_SERVER['RDS_PORT']);

//        $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if($stmt = $link->prepare($sql)){

            // Bind variables to the prepared statement as parameters

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
//            mysqli_stmt_close($stmt);
            // Attempt to execute the prepared statement
//            mysqli_stmt_error($stmt);
//            echo $stmt;
            if($stmt->execute(array($param_username, $param_password))){
                // Redirect to login page
                header("location: login.php");
//                mysqli_stmt_close($stmt);
            } else{
//                echo pg_result_error($stmt);
                echo "Something went wrong. Please try again later.";
            }
        }
        else {
            echo "error";
        }

        // Close statement
//        mysqli_stmt_close($stmt);
    }

    // Close connection
//    pg_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">-->
    <link rel="stylesheet" href="Segomo.css">

    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
<div class="wrapper" style="width: 30%; margin: 0 auto;">
    <h1 class="login-register" align="center">Segomo</h1>
    <h2>Sign Up</h2>
    <p>Please fill this form to create an account.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <input class="login-register-button" type="submit" class="btn btn-primary" value="Submit">
            <input class="login-register-button" type="reset" class="btn btn-default" value="Reset">
        </div>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </form>
</div>
</body>
</html>