<?php
session_start();
$MainContent = "";

$name = $_POST["name"];
$birthDate = $_POST["birthDate"];
$address = $_POST["address"];
$country = $_POST["country"];
$phone = $_POST["phone"];
$email = $_POST["email"];

include_once("mysql_conn.php");
$qry = "UPDATE shopper 
        SET name = ?, BirthDate=?, Address = ?, Country = ?, Phone = ?, Email = ? 
        WHERE ShopperID = ?";
$stmt = $conn->prepare($qry);
$stmt->bind_param("ssssssi", $name, $birthDate, $address, $country, $phone, $email, $_SESSION['ShopperID']);
$stmt->execute();
$stmt->close();
$conn->close();

$MainContent .= "<div class='form-group row'>";       
$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent = "<h3 style='text-align:center; color:green'>Profile updated!</h3>";
$MainContent .= "</div>";
$MainContent .= "</div>";

include("MasterTemplate.php"); 
?>