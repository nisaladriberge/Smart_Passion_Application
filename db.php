<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'w2052891';
//create a DB connection
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
//if the DB connection fails, display an error message and exit and checking the connection
if (!$conn)
{
die('Could not connect: ' . mysqli_connect_error($conn));
}
//select the database
mysqli_select_db($conn, $dbname);
?>