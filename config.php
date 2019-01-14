<?php
/**
 * Created by PhpStorm.
 * User: Wyett MacDonald
 * Date: 11/21/18
 * Time: 6:25 PM
 */

define('DB_SERVER', 'segomo.cizo6tr1olvl.us-east-1.rds.amazonaws.com');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'Kingtut1');
define('DB_NAME', 'segomo');
//define('RDS_HOSTNAME', 'segomo.cizo6tr1olvl.us-east-1.rds.amazonaws.com');
//define('RDS_USERNAME', 'root');
//define('RDS_PASSWORD', 'Kingtut1');
//define('RDS_DB_NAME', 'segomo');
//define('RDS_PORT', '3306');

/* Attempt to connect to MySQL database */
//$link = new PDO("mysql:dbname=Login.sql;host=localhost", "root", "");
//$link = mysqli_connect($_SERVER['RDS_HOSTNAME'], $_SERVER['RDS_USERNAME'], $_SERVER['RDS_PASSWORD'], $_SERVER['RDS_DB_NAME'], $_SERVER['RDS_PORT']);

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>