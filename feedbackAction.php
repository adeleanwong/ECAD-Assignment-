<?php
    //echo "hello there";  
    //echo  $_POST["subject"];
    session_start();
    $subject = $_POST["subject"];
    $content = $_POST["content"];
    $rank = $_POST["rank"];
    $todaysDate = new DateTime('now', new DateTimeZone('Asia/Singapore'));
    $dateEntered = $todaysDate->format('Y-m-d\TH:i:s');

    include("mysql_conn.php");
    $qry = "INSERT INTO feedback (ShopperID, Subject, Content, Rank, DateTimeCreated) VALUES (?, ?, ?, ?, ?)";
	$stmt = $conn->prepare($qry);
	$stmt->bind_param("issss", $_SESSION['ShopperID'], $subject, $content, $rank, $dateEntered); 
	$stmt->execute();
	$result = $stmt->get_result();
    $stmt->close();
    $conn->close();

    
    $MainContent = "<div class='form-group row'>";       
    $MainContent .= "<div class='col-sm-9 offset-sm-3'>";
    $MainContent = "<h3 style='text-align:center; color:blue'>Thank you for your feedback!</h3>";
    $MainContent .= "</div>";
    $MainContent .= "</div>";

    include("MasterTemplate.php")

?>