<?php
/**
 * Created by PhpStorm.
 * User: Wyett MacDonald
 * Date: 11/21/18
 * Time: 6:25 PM
 */

define('DB_SERVER', 'ec2-54-225-121-235.compute-1.amazonaws.com');
define('DB_USERNAME', 'fwavvcwcapfmli');
define('DB_PASSWORD', 'e21f9c2784210db0d6cae2591330acafa9e0840de683d6d0c774f4a9cc078c12');
define('DB_NAME', 'd9gpjimto8jmv4');
//define('RDS_HOSTNAME', 'segomo.cizo6tr1olvl.us-east-1.rds.amazonaws.com');
//define('RDS_USERNAME', 'root');
//define('RDS_PASSWORD', 'Kingtut1');
//define('RDS_DB_NAME', 'segomo');
//define('RDS_PORT', '3306');
//define('DB_SERVER', 'segomo.cizo6tr1olvl.us-east-1.rds.amazonaws.com');
//define('DB_NAME', 'd9gpjimto8jmv4');
//define('DB_USERNAME', 'root');
//define('DB_PASSWORD', 'Kingtut1');
//define('DB_NAME', 'segomo');
//$DB_NAME = "d9gpjimto8jmv4";
//$DB_SERVER = "ec2-54-225-121-235.compute-1.amazonaws.com";
//$DB_USERNAME = "fwavvcwcapfmli";
//$DB_PASSWORD = "e21f9c2784210db0d6cae2591330acafa9e0840de683d6d0c774f4a9cc078c12";

/* Attempt to connect to MySQL database */
//$link = new PDO("mysql:host='segomo.cizo6tr1olvl.us-east-1.rds.amazonaws.com';dbname='segomo'", DB_USERNAME, DB_PASSWORD);

$link = new PDO("pgsql:dbname='d9gpjimto8jmv4';host='ec2-54-225-121-235.compute-1.amazonaws.com'", DB_USERNAME, DB_PASSWORD);
//$link = mysqli_connect($_SERVER['RDS_HOSTNAME'], $_SERVER['RDS_USERNAME'], $_SERVER['RDS_PASSWORD'], $_SERVER['RDS_DB_NAME'], $_SERVER['RDS_PORT']);

//$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection

if($link === false){
    die("ERROR: Could not connect. ");
}
?>