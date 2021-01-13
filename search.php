<?php 
// Detect the current session
session_start();

// HTML Form to collect search keyword and submit it to the same page 
// in server
$MainContent = "<div style='width:80%; margin:auto;'>"; // Container
$MainContent .= "<form name='frmSearch' method='get' action=''>";
$MainContent .= "<div class='form-group row'>"; // 1st row
$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<span class='page-title'>Product Search</span>";
$MainContent .= "</div>";
$MainContent .= "</div>"; // End of 1st row
$MainContent .= "<div class='form-group row'>"; // 2nd row
$MainContent .= "<label for='keywords' 
                  class='col-sm-3 col-form-label'>Product Title:</label>";
$MainContent .= "<div class='col-sm-6'>";
$MainContent .= "<input class='form-control' name='keywords' id='keywords' 
                  type='search' />";
$MainContent .= "</div>";
$MainContent .= "<div class='col-sm-3'>";
$MainContent .= "<button type='submit'>Search</button>";
$MainContent .= "</div>";
$MainContent .= "</div>";  // End of 2nd row
$MainContent .= "</form>";

// The search keyword is sent to server
if (isset($_GET['keywords'])) {
	$SearchText=$_GET["keywords"];
	$Search="%$_GET[keywords]%";

    // To Do (DIY): Retrieve list of product records with "ProductTitle" 
    // contains the keyword entered by shopper, and display them in a table.
        include_once("mysql_conn.php");
        $MainContent .= "</p><table>";
        $MainContent .= "<tr><th>Search results for $_GET[keywords]:</th></tr>";
    
        $qry = "SELECT ProductID, ProductTitle FROM product 
                WHERE ProductTitle LIKE ? OR ProductDesc LIKE ?";
        $stmt = $conn->prepare($qry);
        $stmt->bind_param("ss", $Search, $Search); // "s" - string
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $conn->close(); // Close database connnection
    
        if ($result->num_rows > 0) { 
            
                while($row = $result->fetch_array())
                { 
                    $product =  "productDetails.php?pid=$row[ProductID]";
                    $MainContent .= "<tr><td><a href=$product>$row[ProductTitle]</a><td></tr><br />";
           
                }
        }
        else {
            $MainContent .= "No record found";
        }
        // To Do (DIY): End of Code
        $MainContent .= "</table>";
        
}

$MainContent .= "</div>"; // End of Container
include("MasterTemplate.php");
?>