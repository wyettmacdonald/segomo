<?php
/**
 * Created by PhpStorm.
 * User: wyettmacdonald
 * Date: 2019-01-18
 * Time: 16:15
 */

session_start();

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$email = "";
$email_err = "";
$username = $_SESSION['username'];

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    }
    else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";

//        echo mysqli_prepare($link, $sql);

        if($stmt = $link->prepare($sql)) {

//            $stmt->execute(array($_POST["username"]));
            // Bind variables to the prepared statement as parameters
//            pg_send_query_params($stmt, "s", $param_username);

            // Set parameters
            $param_email = strtolower(trim($_POST["email"]));

//            mysqli_stmt_close($stmt);

            // Attempt to execute the prepared statement
            if($stmt->execute(array($_POST["email"]))) {


                /* store result */
//                mysqli_stmt_store_result($stmt);


                if($stmt->rowCount() == 1){
                    $email_err = "This email is already taken.";
                }
                else{
                    $email = strtolower(trim($_POST["email"]));
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

    // Check input errors before inserting in database
    if( empty($email_err)) {

        // Prepare an insert statement
        $sql = "UPDATE users SET email=? WHERE username='$username'";

        /* Attempt to connect to MySQL database */
//        $link = mysqli_connect($_SERVER['RDS_HOSTNAME'], $_SERVER['RDS_USERNAME'], $_SERVER['RDS_PASSWORD'], $_SERVER['RDS_DB_NAME'], $_SERVER['RDS_PORT']);

//        $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if($stmt = $link->prepare($sql)){

            // Bind variables to the prepared statement as parameters
            // Set parameters
//            $param_username = $username;
//            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_email = $email;
//            mysqli_stmt_close($stmt);
            // Attempt to execute the prepared statement
//            mysqli_stmt_error($stmt);
//            echo $stmt;
            if($stmt->execute(array($param_email))) {
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
    <h2>Add Email</h2>
    <p>Please add an email to your account.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
            <span class="help-block"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group">
            <input class="login-register-button" type="submit" class="btn btn-primary" value="Submit">
            <input class="login-register-button" type="reset" class="btn btn-default" value="Reset">
        </div>
    </form>
</div>
</body>
</html>