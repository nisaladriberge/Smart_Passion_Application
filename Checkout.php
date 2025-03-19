<?php
session_start();
include("db.php");
mysqli_report(MYSQLI_REPORT_OFF);
$pagename = "checkout";

echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";
echo "<title>" . $pagename . "</title>";
echo "<body>";
include("headfile.html");
include("detectlogin.php");

echo "<h4>" . $pagename . "</h4>";

$currentdatetime = date('Y-m-d H:i:s');
$SQL = "INSERT INTO Orders (userId, orderDateTime, orderStatus) VALUES ('" . $_SESSION['userid'] . "', '" . $currentdatetime . "', 'Placed')";

if (mysqli_query($conn, $SQL) && isset($_SESSION['basket']) && count($_SESSION['basket']) > 0) {
    echo "<p><b>Order successfully placed!</b></p>";
    
    $maxSQL = "SELECT MAX(orderNo) AS maxOrderNo FROM Orders WHERE userId = " . $_SESSION['userid'];
    $exemaxSQL = mysqli_query($conn, $maxSQL) or die(mysqli_error($conn));
    $arrayo = mysqli_fetch_array($exemaxSQL);
    $orderno = $arrayo['maxOrderNo'];
    
    echo "<p>Order No: <b>" . $orderno . "</b></p>";
    
    $total = 0;
    echo "<table id='checkouttable'>";
    echo "<tr><th>Product name</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr>";
    
    foreach ($_SESSION['basket'] as $index => $value) {
        $SQLb = "SELECT prodId, prodName, prodPrice FROM Product WHERE prodId = " . $index;
        $exeSQLb = mysqli_query($conn, $SQLb) or die(mysqli_error($conn));
        $arrayb = mysqli_fetch_array($exeSQLb);
        
        $subtotal = $value * $arrayb['prodPrice'];
        
        $SQLol = "INSERT INTO Order_Line (orderNo, prodId, quantityOrdered, subTotal) VALUES ('" . $orderno . "', '" . $index . "', '" . $value . "', '" . $subtotal . "')";
        mysqli_query($conn, $SQLol) or die(mysqli_error($conn));
        
        echo "<tr><td>" . $arrayb['prodName'] . "</td><td>&pound" . $arrayb['prodPrice'] . "</td><td>" . $value . "</td><td>&pound" . $subtotal . "</td></tr>";
        
        $total += $subtotal;
    }
    
    echo "<tr><th colspan='3'>TOTAL</th><th>&pound" . $total . "</th></tr>";
    echo "</table>";
    
    $SQLo = "UPDATE Orders SET orderTotal = " . $total . " WHERE orderNo = " . $orderno;
    mysqli_query($conn, $SQLo) or die(mysqli_error($conn));
    
    unset($_SESSION['basket']);
} else {
    echo "<p><b>Error with the placing of your order!</b></p>";
}

include("footfile.html");
echo "</body>";
?>