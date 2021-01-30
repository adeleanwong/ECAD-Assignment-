<?php 
// Detect the current session
session_start();
// Create a container, 60% width of viewport
$MainContent = "<div style='width:60%; margin:auto;'>";
// Display Page Header.
$MainContent .= "<div class='row' style='padding:5px'>"; // Start header row
$MainContent .= "<div class='col-12' style='text-align: center;'>";
$MainContent .= "<span class='page-title'>Product Categories</span>";
$MainContent .= "<p>Select a category listed below:</p>";
$MainContent .= "</div>";
$MainContent .= "</div>"; // End header row

// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php");

// To Do:  Starting ....
$qry = "SELECT * FROM Category";
$result = $conn->query($qry);
$MainContent .= "<div class='card-deck flex-wrap justify-content-center'>";
// Display each cateogry in a row 
while($row = $result->fetch_array())
{
    // start a new row 
    $MainContent .= "<div class='card flex-wrap' style='min-width:280px; max-width:280px; margin-bottom:10px;'>";
    // what is the urlencode for
    $catname = urlencode($row["CatName"]);
    $img ="./Images/category/$row[CatImage]";
    $catproduct = "catProduct.php?cid=$row[CategoryID]&catName=$catname"; 
    // Content
    $MainContent .= "<img class='card-img-top' src='$img' alt='Product Image'>"; 
    $MainContent .= "<div class='card-body' style='text-align: center;'>"; //67% of row width
    $MainContent .= "<h5 class='justify-content-center'>$row[CatName]</h5>";
    $MainContent .= "<p class='cart-title'>$row[CatDesc]</p>";
    $MainContent .= "</div>"; //end of card body 
    $MainContent .= "<div class='card-footer' style='background-color:white; text-align:center'>"; //67% of row width
    $MainContent .= "<a href='$catproduct' class='btn btn-danger'>Products</a>";
    $MainContent .= "</div>"; //end of card footer 
    $MainContent .= "</div>"; //end of card




}
$MainContent .= "</div>";
$MainContent .= "</div>";


// To Do:  Ending ....

$conn->close(); // Close database connnection
$MainContent .= "</div>"; // End of container
include("MasterTemplate.php"); 
?>
