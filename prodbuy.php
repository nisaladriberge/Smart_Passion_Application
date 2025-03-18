<?php
session_start();
include("db.php"); // Connect to database
$pagename = "A smart passion for a smart life"; // Updated page name

echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; // Call in stylesheet
echo "<title>".$pagename."</title>"; // Display the name of the page as the window title
echo "<body>";
include("headfile.html"); // Include header layout file
include ("detectlogin.php");

echo "<h4>".$pagename."</h4>"; // Display the name of the page on the web page

// Retrieve the product ID passed from the previous page using the GET method and the  $_GET superglobal variable
//applied to the query string u_prod_id
//store the value in a local variable called $prodid
if (isset($_GET['u_prod_id'])) {
    $prodid = $_GET['u_prod_id'];
    echo "<p>Selected product Id: ".$prodid."</p>"; // Display product ID for debugging

    // SQL query to get product details
    $SQL = "SELECT prodId, prodName, prodPicNameLarge, prodDescripLong, prodPrice, prodQuantity 
            FROM products 
            WHERE prodId = $prodid"; // Filter by selected product ID

    // Execute the SQL query or display an error message
    $exeSQL = mysqli_query($conn, $SQL) or die(mysqli_error($conn));

    // Fetch product details
    if ($arrayp = mysqli_fetch_array($exeSQL)) {
        echo "<table style='border: 0px'>";
        echo "<tr>";

        // Display large product image
        echo "<td style='border: 0px'>";
        echo "<img src='images/".$arrayp['prodPicNameLarge']."' height=300 width=300>";
        echo "</td>";

        echo "<td style='border: 0px'>";
        echo "<p><h2>".$arrayp['prodName']."</h2></p>"; // Display product name
        echo "<p>".$arrayp['prodDescripLong']."</p>"; // Display long description
        echo "<p><b>Price: $".$arrayp['prodPrice']."</b></p>"; // Display price
        echo "<p><b>Stock Available: ".$arrayp['prodQuantity']."</b></p>"; // Display stock

        echo "</td>";
        echo "</tr>";
        echo "</table>";

         // Quantity drop-down menu to purchased products
         echo "<br><p>Number to be purchased: ";
         echo "<form action='basket.php' method='post'>";
         echo "<select name='p_quantity'>";
         
         // Loop to create options based on stock level
         for ($i = 1; $i <= $arrayp['prodQuantity']; $i++) {
             echo "<option value='$i'>$i</option>";
         }
         
         echo "</select>";
         echo "<input type='submit' name='submitbtn' value='ADD TO BASKET' id='submitbtn'>";
         // Pass the product id to the next page basket.php as a hidden value
         echo "<input type='hidden' name='h_prodid' value='$prodid'>";
         echo "</form>";
         echo "</p>";
     } else {
         echo "<p>Product not found.</p>";
     }
 } else {
     echo "<p>No product selected.</p>";
 }
 
 include("footfile.html"); // Include footer layout
 echo "</body>";
 ?>