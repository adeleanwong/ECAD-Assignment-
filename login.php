<?php
session_start();
$MainContent = "<div style='width:80%; margin:auto;'>";
$MainContent .= "<form action='checkLogin.php' method='post'>";
// 1st row - Header Row
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<span class='page-title'>Member Login</span>";
$MainContent .= "</div>";
$MainContent .= "</div>";

// 2nd row - Entry of email address
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='email'>Email Address:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' type='email' name='email' id='email' required />";
$MainContent .= "</div>";
$MainContent .= "</div>";

// 3rd row - Entry of password 
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='password'>Password:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' type='password' name='password' id='password' required />";
$MainContent .= "</div>";
$MainContent .= "</div>";

// 4th row - Login button
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<button type='submit'>Login</button>";
$MainContent .= "<p>Please sign up if you do not have an account.</p>";
$MainContent .= "<p> <a href='forgetPassword.php'>Forget Password?</a></p>";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "</form>";
$MainContent .= "</div>";

include("MasterTemplate.php");
?>