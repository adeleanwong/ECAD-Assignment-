<?php
// Detect the current session
session_start();

// Reading inputs entered in previous page
$email = $_POST["email"];
$pwd = $_POST["password"];

// To Do 1 (Practical 2): Validate login credentials with database
$checkLogin = FALSE;

// Include the PHP file that establishes database connection handle: $conn 
include_once("mysql_conn.php");
$qry = "SELECT * FROM Shopper WHERE Email=?";
$stmt = $conn->prepare($qry);
$stmt->bind_param("s", $email); 
$stmt->execute();
$result1 = $stmt->get_result();
$stmt->close();

if ($result1->num_rows > 0){
	$row1 = $result1->fetch_array();

	if ($pwd == $row1["Password"]){
		 $checkLogin = TRUE;
		 // Save user's info in session variables 
		 $_SESSION["ShopperName"] = $row1["Name"];
		 $_SESSION["ShopperID"] = $row1["ShopperID"];
	
	
		// To Do 2 (Practical 4): Get active shopping cart
		$qry = "SELECT ShopCartID FROM ShopCart WHERE ShopperID = ? AND OrderPlaced=0";
		$stmt = $conn->prepare($qry);
		$stmt->bind_param("i", $_SESSION["ShopperID"]);
		$stmt->execute();
		$result2 = $stmt->get_result();
		$stmt->close();
		$row = $result2->fetch_array();
		if ($row["ShopCartID"] != NULL){
			$_SESSION["Cart"] = $row["ShopCartID"]; 
		}

		$qry = "SELECT count(*) FROM ShopCartItem WHERE ShopCartID = ?";
		$stmt = $conn->prepare($qry);
		$stmt->bind_param("i", $row["ShopCartID"]);
		$stmt->execute();
		$result3 = $stmt->get_result();
		$stmt->close();
		$row = $result3->fetch_array();
		$_SESSION["NumCartItem"] = $row["count(*)"];
	}
	else{
		$MainContent = "<h3 style='color:red'>Invalid Login Credentials - <br/>
		password is incorrect!</h3>";
	}
}
else {
	$MainContent = "<h3 style='color:red'>Invalid Login Credentials</h3>";
}

$conn->close();

if ($checkLogin == TRUE){
	// Redirect to home page
	header("Location: index.php");
	exit;
}
	
include("MasterTemplate.php");
?>