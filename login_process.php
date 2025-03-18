<?php //formation of login process
session_start();
include("db.php");
$pagename = "Your Login Results"; // Set the page name

echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; // Call in stylesheet
echo "<title>" . $pagename . "</title>"; // Display name of the page as window title
echo "<body>";
include("headfile.html"); // Include header layout file

echo "<h4>" . $pagename . "</h4>"; // Display name of the page on the web page

// Capture the values entered in the form
$email = $_POST['l_email'];
$password = $_POST['l_password'];

// Check if fields are empty
if (empty($email) or empty($password)) {
    echo "<p><b>Login failed!</b></p>";
    echo "<p>Login form incomplete. Make sure you provide all the required details.</p>";
    echo "<p>Go back to <a href='login.php'>login</a></p>";
} else {
    // SQL query to retrieve user details
    $SQL = "SELECT * FROM Users WHERE userEmail = '" . mysqli_real_escape_string($conn, $email) . "'";//retrieve record if email matches 
    $exeSQL = mysqli_query($conn, $SQL) or die(mysqli_error($conn));//execute SQL query
    $nbrecs = mysqli_num_rows($exeSQL);//retrieve the number of records
    
    if ($nbrecs == 0) {//if nb of records is 0 i.e. if no records were located for which email matches entered email
        echo "<p><b>Login failed!</b></p>";
        echo "<p>Email not recognised.</p>";
        echo "<p>Go back to <a href='login.php'>login</a></p>";
    } else {
        $arrayuser = mysqli_fetch_array($exeSQL);//create array of user for this email
        
        if ($arrayuser['userPassword'] !== $password) {//if the pwd in the array matches the pwd entered in the form
            echo "<p><b>Login failed!</b></p>";
            echo "<p>Password not valid.</p>";
            echo "<p>Go back to <a href='login.php'>login</a></p>";
        } else {
            echo "<p><b>Login success!</b></p>";
            
            // Store session variables
            $_SESSION['userid'] = $arrayuser['userId'];
            $_SESSION['fname'] = $arrayuser['userFName'];
            $_SESSION['sname'] = $arrayuser['userSName'];
            $_SESSION['usertype'] = $arrayuser['userType'];
            
            echo "<p>Welcome, " . $_SESSION['fname'] . " " . $_SESSION['sname'] . "</p>";
            
            if ($_SESSION['usertype'] == 'C') {
                echo "<p>User Type: homteq Customer</p>";
            } elseif ($_SESSION['usertype'] == 'A') {
                echo "<p>User Type: homteq Administrator</p>";
            }
            
            echo "<br><p>Continue shopping for <a href='index.php'>Home Tech</a></p>";
            echo "<br><p>View your <a href='basket.php'>Smart Basket</a></p>";
        }
    }
}

include("footfile.html"); // Include footer layout
echo "</body>";
?>
