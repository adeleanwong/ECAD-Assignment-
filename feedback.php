<?php
// Detect the current session   
//session_start();
$MainContent = "<div style='width:80%; margin:auto;'>";
$MainContent .= "<form name='feedback' id='feedback' action='feedbackAction.php' method='post'>";
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<span class='page-title'>Feedback Form</span>";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='subject'>Subject:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='subject' id='subject' 
                  type='text' required /> (required)";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='content'>Feedback:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input type='text' class='form-control' name='content' id='content' 
                  required /> (required)";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='rank'>Rating:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' type='number' id='rank' name='rank' min='1' max='5' required> (required)";

$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";       
$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<button type='submit' class='btn btn-danger'>Submit</button>";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "</form>";
$MainContent .= "</div>";
$MainContent .= "<br>";
$MainContent .= "<br>";


//include("MasterTemplate.php"); 




?>