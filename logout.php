<?php
/**
 * Created by PhpStorm.
 * User: macdonaldw15
 * Date: 11/21/18
 * Time: 6:28 PM
 */

// Initialize the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page
header("location: login.php");
exit;
?>