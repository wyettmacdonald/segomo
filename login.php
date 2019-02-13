<?php
/**
 * Created by PhpStorm.
 * User: macdonaldw15
 * Date: 11/21/18
 * Time: 6:27 PM
 */

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
$coins = 0;

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password, coins FROM users WHERE username = ?";

        if($stmt = $link->prepare($sql)){

            // Bind variables to the prepared statement as parameters
//            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $stmt->bindParam(1, $param_username);

            // Set parameters
            $param_username = $username;
            $param_coins = $coins;

            // Attempt to execute the prepared statement
            if($stmt->execute(array($username))){
                // Store result
//                mysqli_stmt_store_result($stmt);


                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1) {
                    // Bind result variables
//                    $stmt = pg($stmt, $id, $username, $password, $coins);
                    $result = $stmt->fetchAll();
//                    print_r($result);
//                    echo strval($result[0][1]);
//                    if($stmt->execute(array($result[0][0], $result[0][1], $result[0][2], $coins))) {
                        if(password_verify($password, $result[0][2])) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
//                            echo "here";
//                            echo intval($coins);
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["coins"] = $coins;
                            $_SESSION["email"] = $email;

                            $email_sql = $link->query("SELECT email FROM users WHERE username = '$username'");
                            $email_row = $email_sql->fetch(PDO::FETCH_ASSOC);
                            if($email_row['email'] == '') {
                                header("location: add_email.php");
                            }

                            else {
                                // Redirect user to welcome page
                                header("location: welcome.php");
//                            mysqli_stmt_close($stmt);
                            }

                        }
                        else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                }
                else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            }
            else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
//        mysqli_stmt_close($stmt);
    }

    // Close connection
//    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input class="login-register-button" type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="index.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>