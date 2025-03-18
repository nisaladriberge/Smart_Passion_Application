<?php
session_start();
include("db.php");

mysqli_report(MYSQLI_REPORT_OFF); // Disable automatic error reporting

$pagename = "Sign Up Results";

echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";
echo "<title>" . $pagename . "</title>";
echo "<body>";
include("headfile.html");

echo "<h4>" . $pagename . "</h4>";

// Capture and trim form inputs
$fname = trim($_POST['r_firstname']);
$lname = trim($_POST['r_lastname']);
$address = trim($_POST['r_address']);
$postcode = trim($_POST['r_postcode']);
$telno = trim($_POST['r_telno']);
$email = trim($_POST['r_email']);
$password1 = trim($_POST['r_password1']);
$password2 = trim($_POST['r_password2']);

// Define email validation regex
$reg = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";

// Check if any field is empty
if (empty($fname) || empty($lname) || empty($address) || empty($postcode) || empty($telno) || empty($email) || empty($password1) || empty($password2)) {
    echo "<p><b>Sign-up failed!</b></p>";
    echo "<br><p>Your signup form is incomplete. All fields are mandatory.</p>";
    echo "<br><p>Go back to <a href=signup.php>sign up</a></p>";
} elseif ($password1 !== $password2) {
    echo "<p><b>Sign-up failed!</b></p>";
    echo "<br><p>The two passwords do not match. Please try again.</p>";
    echo "<br><p>Go back to <a href=signup.php>sign up</a></p>";
} elseif (!preg_match($reg, $email)) {
    echo "<p><b>Sign-up failed!</b></p>";
    echo "<br><p>Email not valid. Please enter a correct email address.</p>";
    echo "<br><p>Go back to <a href=signup.php>sign up</a></p>";
} else {
    // Hash password for security
    $hashed_password = password_hash($password1, PASSWORD_DEFAULT);
    
    // Prepare SQL statement to insert new user
    $SQL = "INSERT INTO Users (userType, userFName, userSName, userAddress, userPostCode, userTelNo, userEmail, userPassword) 
            VALUES ('C', ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $SQL);
    mysqli_stmt_bind_param($stmt, "sssssss", $fname, $lname, $address, $postcode, $telno, $email, $hashed_password);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<p><b>Sign-up successful!</b></p>";
        echo "<br><p>To continue, please <a href=login.php>login</a></p>";
    } else {
        $error_code = mysqli_errno($conn);
        echo "<p><b>Sign-up failed!</b></p>";
        if ($error_code == 1062) {
            echo "<br><p>Email already in use. Please try another email address.</p>";
        } elseif ($error_code == 1064) {
            echo "<br><p>Invalid characters entered in the form. Avoid apostrophes (') and backslashes (\\).</p>";
        } else {
            echo "<br><p>Database error. Please try again later.</p>";
        }
        echo "<br><p>Go back to <a href=signup.php>sign up</a></p>";
    }
    mysqli_stmt_close($stmt);
}

include("footfile.html");
echo "</body>";
?>
