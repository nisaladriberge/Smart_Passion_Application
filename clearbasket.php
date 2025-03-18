<?php
session_start(); // Start the session
include("db.php"); // Include db.php file to connect to DB
$pagename = "Clear Smart Basket"; // Create and populate a variable called $pagename

echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; // Call in stylesheet
echo "<title>".$pagename."</title>"; // Display name of the page as window title
echo "<body>";
include("headfile.html"); // Include header layout file
include ("detectlogin.php");

echo "<h4>".$pagename."</h4>"; // Display name of the page on the web page
unset($_SESSION['basket']); // Clear the session array
echo "<p>Your basket has been cleared!</p>"; // Display confirmation message

include("footfile.html"); // Include footer layout
echo "</body>";
?>
