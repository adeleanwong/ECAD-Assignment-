<?php

session_start();

include("mysql_conn.php");
include("feedback.php");

$qry = "SELECT * FROM feedback";
$result = $conn->query($qry);
$MainContent .= "<hr>";
$MainContent .= "<h2 style='text-align:center; margin-bottom:40px; color:#e63232'>Feedbacks</h2>";
$MainContent .= "<div class='container justify-content-md-center'>"; //this is container


while ($row = $result->fetch_array())
{
    $subject = $row['Subject'];
    $content = $row['Content'];
    $rating = $row['Rank'];
    // Content
    $MainContent .= "<div class='row'>"; //content wrapper
    $MainContent .= "<div class='col-10'><b>$subject</b>
    <br>
    $content
    </div>";
    $MainContent .= "<div class='col-2 text-center'>$rating out of 5 stars</div>";
    $MainContent .= "</div>
                    <br>"; //end of content wrapper


} 
//$conn->close();
$MainContent .= "</div>"; //end of container

include("MasterTemplate.php");

?>