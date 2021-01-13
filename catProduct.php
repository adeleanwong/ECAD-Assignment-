<?php 
// Detect the current session
session_start();
// Create a container, 60% width of viewport
$MainContent = "<div style='width:60%; margin:auto;'>";
// Display Page Header - 
// Category's name is read from query string passed from previous page.
$MainContent .= "<div class='row' style='padding:5px'>";
$MainContent .= "<div class='col-12'>";
$MainContent .= "<span class='page-title'>$_GET[catName]</span>";
$MainContent .= "</div>";
$MainContent .= "</div>";

// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php"); 

// To Do:  Starting ....
$cid = $_GET["cid"]; //Read category ID from query string
// form SQL to retrieve list of products associated to the category ID
$qry = "SELECT p.ProductID, p.ProductTitle, p.ProductImage, p.Price, p.Quantity
        FROM CatProduct cp INNER JOIN product p ON cp.ProductID = p.ProductID
        WHERE cp.CategoryID=?" ;
$stmt = $conn->prepare($qry);
$stmt->bind_param("i", $cid);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

$MainContent .= "<div class='card-deck flex-wrap justify-content-center'>";

// display each product in a row 
while ($row = $result->fetch_array())
{
    // start card
    $MainContent .= "<div class='card flex-wrap' style='min-width:280px; max-width:280px; margin-bottom:10px;'>";

    // Product details
    $product = "productDetails.php?pid=$row[ProductID]";
    $formattedPrice = number_format($row["Price"], 2);
    $img="./Images/products/$row[ProductImage]";

    // Content
    $MainContent .= "<img class='card-img-top' src='$img' alt='Product Image'>"; 
    $MainContent .= "<div class='card-body'>"; //67% of row width
    $MainContent .= "<h5 class='cart-title'>$row[ProductTitle]</h5>";
    $MainContent .= "<p class='card-text text-primary' style='font-size:1.2em'>Price: $ $formattedPrice</p>";
    $MainContent .= "<a href='$product' class='btn btn-danger'>Product Details</a>";
    $MainContent .= "</div>"; //end of card body 
    $MainContent .= "</div>"; //end of card

}
$MainContent .= "</div>"; //end of card
$MainContent .= "</div>"; //end of card

// To Do:  Ending ....

$conn->close(); // Close database connnection
$MainContent .= "</div>"; // End of container
include("MasterTemplate.php");  
?>
