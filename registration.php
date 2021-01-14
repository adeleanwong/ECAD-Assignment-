<?php 
// Detect the current session 
session_start();
$MainContent = "";

// Read the data input from previous page
$name = $_POST["name"];
$birthDate = $_POST["birthDate"];
$address = $_POST["address"];
$country = $_POST["country"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
$pwdQuestion = $_POST["pwdQuestion"];
$pwdAnswer = $_POST["pwdAnswer"];
$activeStatus = 0;

$todaysDate = new DateTime('now', new DateTimeZone('Asia/Singapore'));
$dateEntered = $todaysDate->format('Y-m-d\TH:i:s');

// Include the PHP file that establishes database connection handle: $conn 
include_once("mysql_conn.php");

// Define the INSERT SQL statement
$qry = "INSERT INTO Shopper (Name, BirthDate, Address, Country, Phone, Email, Password, PwdQuestion, PwdAnswer, ActiveStatus, DateEntered)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($qry);
// "ssssss" - 6 string parameters
$stmt->bind_param("sssssssssis", $name, $birthDate, $address, $country, $phone, $email, $password, $pwdQuestion, $pwdAnswer, $activeStatus, $dateEntered);

if ($stmt->execute()) { // SQL statement executed successfully
    // Retrive the Shopper ID assigned t the new shopper
    $qry = "SELECT LAST_INSERT_ID() AS ShopperID";
    $result = $conn->query($qry);
    while ($row = $result->fetch_array()) {
        $_SESSION["ShopperID"] = $row["ShopperID"];
    }
    // Display successful message and shopper ID
    $MainContent .= "Registration successful!<br/>";
    $MainContent .= "Your ShopperID is $_SESSION[ShopperID]<br/>";
    // Save the shopper name in a session variable
    $_SESSION["ShopperName"] = $name;
}
else { // Display error message
    $MainContent .= "<h3 style='color:red'>Error in inserting recrod</h3>";
}

// Release the resoruce allocated for prepared statement 
$stmt->close();
// Close database connection 
$conn->close();
// Include the master template file for this page
include ("MasterTemplate.php");
?>