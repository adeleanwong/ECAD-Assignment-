<?php 

$MainContent = "<div style='width:80%; margin:auto;'>";
$MainContent .= "<form method='post'>";

$MainContent .= "<div class='form-group row'>";
$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<span class='page-title'>Forget Password</span>";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='eMail'>
                 Email Address:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='eMail' id='eMail'
                        type='email' required />";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";       
$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<button type='submit' class='btn btn-danger'>Submit</button>";
$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .= "</form>";

// Process after user click the submit button
if (isset($_POST['eMail'])) {
	// Read email address entered by user
	$eMail = $_POST['eMail'];
	// Retrieve shopper record based on e-mail address
	include("mysql_conn.php");
	$qry = "SELECT * FROM Shopper WHERE Email=?" ;
	$stmt = $conn->prepare($qry);
	$stmt->bind_param("s", $eMail); 	// "s" - string 
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	if ($result->num_rows > 0) {
		// To Do 1: Update the default new password to shopper's account
		$row = $result->fetch_array();
		$shopperId = $row["ShopperID"];
		$email = $row["Email"];
		$pwdQuestion = $row["PwdQuestion"];
		$pwdAnswer = $row["PwdAnswer"];
/* 		$new_pwd = "password"; //Default password
		// Hash the default password
		$hashed_pwd = password_hash($new_pwd, PASSWORD_DEFAULT);
		$qry = "UPDATE Shopper SET Password=? WHERE ShopperID=?";
		$stmt = $conn->prepare($qry);
		$stmt->bind_param("si", $hashed_pwd, $shopperId);
		$stmt->execute();
		$stmt->close(); */
		// End of To Do 1

		$MainContent = "";
		$MainContent = "<div style='width:80%; margin:auto;'>";
		$MainContent .= "<form action='forgetPassword2.php' method='post' >";

		$MainContent .= "<div class='form-group row'>";
		$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
		$MainContent .= "<span class='page-title'>Forget Password</span>";
		$MainContent .= "</div>";
		$MainContent .= "</div>";

		$MainContent .= "<div class='form-group row'>";
		$MainContent .= "<label class='col-sm-3 col-form-label' for='eMail'>
		                 Email Address:</label>";
		$MainContent .= "<div class='col-sm-9'>";
		$MainContent .= "<input class='form-control' name='eMaild' id='eMaild'
								type='email' value='$email' disabled />";
		$MainContent .= "<input class='form-control' name='eMail' id='eMail'
		                        type='email' value='$email' hidden />";						
		$MainContent .= "</div>";
		$MainContent .= "</div>";

		$MainContent .= "<div class='form-group row'>";
		$MainContent .= "<label class='col-sm-3 col-form-label' for='pwdQuestion'>Security Question:</label>";
		$MainContent .= "<div class='col-sm-9'>";
		$MainContent .= "$pwdQuestion";
		$MainContent .= "</div>";
		$MainContent .= "</div>";

		$MainContent .= "<div class='form-group row'>";
		$MainContent .= "<label class='col-sm-3 col-form-label' for='pwdAnswer'>Security Answer:</label>";
		$MainContent .= "<div class='col-sm-9'>";
		$MainContent .= "<input class='form-control' name='pwdAnswer' id='pwdAnswer' type='text'/>";
		$MainContent .= "</div>";
		$MainContent .= "</div>";

		$MainContent .= "<div class='form-group row'>";       
		$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
		$MainContent .= "<button type='submit' class='btn btn-danger'>Submit</button>";
		$MainContent .= "</div>";
		$MainContent .= "</div>";
		$MainContent .= "</form>";

		
		
		/* // To Do 2: e-Mail the new password to user
		include("myMail.php");
		// The "Send To" should be the email address indicated
		// by the shopper, i.e $eMail. In this case, use a testing e-mail
		// address as the shopper's email address in our database 
		// may not be a valid account
		$to="johndounut1@gmail.com";
		$from="johndounut1@gmail.com";
		$from_name="Giftany & Co.";
		$subject="Giftany Login Password"; // email title
		// HTML body message
		$body="<span style='color:black; font-size:12px'>
				Your new password is <span style='font-weight:bold'>
				$new_pwd</span>.<br />
				Do change this default password.</span>";
		// Initiate the emailing sending process
		if(smtpmailer($to, $from, $from_name, $subject, $body)){
			$MainContent .= "<p>Your new password is sent to:
							<span style='font-weight:bold'>$to</span>.</p>";
		}
		else{
			$MainContent .= "<p><span style='color:red;'>
							Mailer Error: " . $error . "</span></p>";
		}
		// End of To Do 2 */
	}
	else {
		$MainContent .= "<p><span style='color:red;'>Wrong E-mail address!</span>";
	}
	$conn->close();
}

$MainContent .= "</div>";
include("MasterTemplate.php");
?>