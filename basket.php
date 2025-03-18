<?php
session_start(); // Start the session
include("db.php"); // Connect to database
$pagename = "Smart Basket"; // Create and populate a variable called $pagename

echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; // Call in stylesheet
echo "<title>".$pagename."</title>"; // Display name of the page as window title
echo "<body>";
include("headfile.html"); // Include header layout file
include("detectlogin.php");

echo "<h4>".$pagename."</h4>"; // Display name of the page on the web page

// Check if the POST variables are set before using them
if (isset($_POST['h_prodid']) && isset($_POST['p_quantity'])) {
    $newprodid = intval($_POST['h_prodid']); // Sanitize and store product ID
    $reququantity = intval($_POST['p_quantity']); // Sanitize and store quantity

    // Update the session array to store the product ID and quantity
    $_SESSION['basket'][$newprodid] = $reququantity;
    echo "<p>1 item added</p>"; // Confirm item addition to the basket
}

// Check if the product ID to be deleted is set
if (isset($_POST['del_prodid'])) {
    $delprodid = intval($_POST['del_prodid']); // Sanitize and store the product ID to delete
    unset($_SESSION['basket'][$delprodid]); // Remove item from basket
    echo "<p>1 item removed from the basket.</p>"; // Confirmation message
}

$total = 0; // Create a variable $total and initialize it to zero
$basketNotEmpty = false; // Flag to check if the basket has items

// Create an HTML table with header to display the content of the shopping basket
echo "<table id='baskettable'>";
echo "<tr>";
echo "<th>Product Name</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Action</th>";
echo "</tr>";

// Check if the session array $_SESSION['basket'] is set and not empty
if (isset($_SESSION['basket']) && !empty($_SESSION['basket'])) {
    $basketNotEmpty = true;
    foreach ($_SESSION['basket'] as $index => $value) {
        // SQL query to retrieve product details
        $SQL = "SELECT prodId, prodName, prodPrice FROM products WHERE prodId=" . intval($index);
        $exeSQL = mysqli_query($conn, $SQL) or die(mysqli_error($conn));

        if ($arrayp = mysqli_fetch_array($exeSQL)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($arrayp['prodName']) . "</td>";
            echo "<td>&pound" . number_format($arrayp['prodPrice'], 2) . "</td>";
            echo "<td style='text-align:center;'>" . htmlspecialchars($value) . "</td>";
            
            $subtotal = $arrayp['prodPrice'] * $value;
            echo "<td>&pound" . number_format($subtotal, 2) . "</td>";

            // Form to remove item from basket
            echo "<td>";
            echo "<form action='basket.php' method='post'>";
            echo "<input type='hidden' name='del_prodid' value='".$arrayp['prodId']."'>"; 
            echo "<input type='submit' value='Remove' id='submitbtn'>";
            echo "</form>";
            echo "</td>";

            echo "</tr>";
            $total += $subtotal;
        } else {
            echo "<tr><td colspan='5'>Product not found.</td></tr>";
        }
    }
} else {
    echo "<tr><td colspan='5'>Your basket is empty.</td></tr>";
}

echo "<tr>";
echo "<td colspan=3><b>TOTAL</b></td>";
echo "<td><b>&pound" . number_format($total, 2) . "</b></td>";
echo "<td></td>"; // Empty cell for Action column
echo "</tr>";
echo "</table>"; // Close the table

// Add the link to clear the basket
echo "<br><p><a href='clearbasket.php'>CLEAR BASKET</a></p>";

// Show appropriate options based on login status
if (isset($_SESSION['userid'])) {
    if ($basketNotEmpty) {
        echo "<br><p><a href='checkout.php'>CHECKOUT</a></p>";
    }
} else {
    echo "<br><p>New homteq customers: <a href='signup.php'>Sign up</a></p>";
    echo "<p>Returning homteq customers: <a href='login.php'>Login</a></p>";
}

include("footfile.html"); // Include footer layout
echo "</body>";
?>
