<?php
if (isset($_POST['pwdAnswer']) && isset($_POST['eMail'])) {
    //  echo "hello there"; 
    include("mysql_conn.php");
    $qry = "SELECT * FROM Shopper WHERE Email=?";
    $stmt = $conn->prepare($qry);
    $stmt->bind_param("s", $_POST['eMail']); 	
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $row = $result->fetch_array();

    $shopperId = $row["ShopperID"];
    $email = $row["Email"];
    $pwdQuestion = $row["PwdQuestion"];
    $pwdAnswer = $row["PwdAnswer"];

    if ($_POST['pwdAnswer'] == $pwdAnswer){
        $new_pwd = "password"; 
        $hashed_pwd = password_hash($new_pwd, PASSWORD_DEFAULT);
        //include("mysql_conn.php");	
        $qry = "UPDATE Shopper SET Password=? WHERE ShopperID=?";
        $stmt = $conn->prepare($qry);
        $stmt->bind_param("si", $hashed_pwd, $shopperId);
        $stmt->execute();
        $stmt->close(); 

        $MainContent = "";
        $MainContent = "<h3 style='text-align:center; color:green;'>Your new password is '<b>$new_pwd</b>'. Please change your password once you have logged in.</h3>";
    }

    else{
        $MainContent = "<h3 style='text-align:center; color:red;'>You have entered the wrong answer.</h3>";
    }
    $conn->close();
}
include("MasterTemplate.php");
?>