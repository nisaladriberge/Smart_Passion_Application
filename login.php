<?php //Formation of login 
session_start();
$pagename = "Sign Up"; // Set the page name

echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; // Call in stylesheet
echo "<title>" . $pagename . "</title>"; // Display name of the page as window title
echo "<body>";
include ("headfile.html"); // Include header layout file

echo "<h4>" . $pagename . "</h4>"; // Display name of the page on the web page

// Display login form
echo "<form action='login_process.php' method='post'>";
echo "<table id='baskettable'>";
// Email field
echo "<tr>";
echo "<td>Email</td>";
echo "<td><input type='text' name='l_email' size='40'></td>";
echo "</tr>";
// Password field
echo "<tr>";
echo "<td>Password</td>";
echo "<td><input type='password' name='l_password' size='40'></td>";
echo "</tr>";
// Submit and Reset buttons
echo "<tr>";
echo "<td><input type='submit' value='Login' id='submitbtn'></td>";
echo "<td><input type='reset' value='Clear Form' id='submitbtn'></td>";
echo "</tr>";
echo "</table>";
echo "</form>";

include("footfile.html"); // Include footer layout
echo "</body>";
?>
