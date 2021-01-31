<?php
    include_once('mysql_conn.php');
    $existingEmail = array();
    $qry = 'SELECT * FROM Shopper';
    $result = $conn->query($qry);
    while ($row = $result->fetch_array()) {
        array_push($existingEmail, $row['Email']);
    }
    $conn->close();
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript">
function validateForm()
{
    var existingEmail = <?php echo '["' . implode('", "', $existingEmail) . '"]' ?>; //shits existingEmail from php out as an Array
    for (var i = 0; i < existingEmail.length; i++){
        console.log(existingEmail[i]);
        if (document.editProfile.email.value == existingEmail[i]){
            return false;
        }
    }
    
    // To Do 1 - Check if password matched
	if (document.editProfile.password.value != document.editProfile.password2.value){
        alert("Passwords not matched!");
        return false; 
    }
	// To Do 2 - Check if telephone number entered correctly
	//           Singapore telephone number consists of 8 digits,
	//           start with 6, 8 or 9
    if(document.editProfile.phone.value != ""){
        var str = document.editProfile.phone.value;
    
        if (str.length != 8){
            alert("Please enter a 8-digit phone number.");
            return false;
        }
        else if (str.substr(0,1) != "6" && str.substr(0,1) != "8" && str.substr(0,1) != "9"){
            alert("Phone number in Singapore should start with 6, 8 or 9.");
            return false;
        }
    }
    return true;  // No error found
}
</script>


<?php 
session_start();
//echo ($_SESSION['ShopperID']);
include("mysql_conn.php");
$qry = "SELECT * 
        FROM Shopper 
        WHERE ShopperID=?" ;
$stmt = $conn->prepare($qry);
$stmt->bind_param("i", $_SESSION["ShopperID"]);
$stmt->execute();
$result = $conn->query($qry);
$result = $stmt->get_result();	
$stmt->close();
$row = $result->fetch_array();

//echo $row['ShopperID'];

$name = $row['Name'];
$birthDate = $row['BirthDate'];
$address = $row['Address'];
$country = $row['Country'];
$phone = $row['Phone'];
$email = $row['Email'];

// Detect the current session   
$MainContent = "<div style='width:80%; margin:auto;'>";
$MainContent .= "<form name='editProfile' id='editProfileForm' action='editProfile.php' method='post' 
                       onsubmit='return validateForm()'>";
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<span class='page-title'>Edit Profile</span>";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='name'>Name:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='name' id='name' 
                  type='text' value='$name' /> ";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='birthDate'>Birth Date:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input type='date' name='birthDate' id='birthDate' value='$birthDate' />";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='address'>Address:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<textarea class='form-control' name='address' id='address'
                  cols='25' rows='4' >$address</textarea>";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='country'>Country:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='country' id='country' type='text' value='$country'/>";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='phone'>Phone:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='phone' id='phone' type='text' value='$phone'/>";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='email'>
                 Email Address:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='email' id='email' 
                  type='email' value='$email'/>";
$MainContent .= "<p> <a href='changePassword.php'>Change Password</a></p>";
$MainContent .= "<div id='emailInfo'>";
$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";       
$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<button type='submit' class='btn btn-danger'>Update</button>";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "</form>";



$MainContent .= "</div>";
include("MasterTemplate.php"); 
?>

<script>
function validateForm()
{
    var existingEmail = <?php echo '["' . implode('", "', $existingEmail) . '"]' ?>; //shits existingEmail from php out as an Array
    var email = <?php echo '"' . $email . '"'  ?>; 
        for (var i = 0; i < existingEmail.length; i++){
            //console.log(existingEmail[i]);
            if (document.editProfile.email.value == existingEmail[i] && document.editProfile.email.value != email){
                //console.log("Found existing email matched")
                var errorText = "Email already exist, please enter another email!";
                document.getElementById('emailInfo').innerHTML = errorText;
                return false;
            }
            else{
                //console.log("Email field is empty!");
                document.getElementById('emailInfo').innerHTML = "";
                
            }
        }

	// To Do 2 - Check if telephone number entered correctly
	//           Singapore telephone number consists of 8 digits,
	//           start with 6, 8 or 9
    if(document.editProfile.phone.value != ""){
        var str = document.editProfile.phone.value;
    
        if (str.length != 8 ){
            alert("Please enter a 8-digit phone number.");
            return false;
        }
        else if (str.substr(0,1) != "6" && str.substr(0,1) != "8" && str.substr(0,1) != "9" && str.substr(0,4) != "(65)"){
            alert("Phone number in Singapore should start with 6, 8 or 9.");
            return false;
        }
    }
    return true;  // No error found
}

function checkEmail(){
    //console.log("Checking every 1 second.");
    var flag = false;
    if (document.editProfile.email.value != ""){
        var existingEmail = <?php echo '["' . implode('", "', $existingEmail) . '"]' ?>; //outputs existingEmail from php out as an Array
        var email = <?php echo '"' . $email . '"'  ?>; 
        for (var i = 0; i < existingEmail.length; i++){
            //console.log(existingEmail[i]);
            if (document.editProfile.email.value == existingEmail[i] && document.editProfile.email.value != email){
                console.log("Found existing email matched")
                var errorText = "Email already exist, please enter another email!";
                document.getElementById('emailInfo').innerHTML = errorText;
                flag = false;
                return;
            }
            else{
                flag = true;
            }
        }
        if (flag == true){
            //console.log("Email field is empty!");
            document.getElementById('emailInfo').innerHTML = "";
                
        }
    }
}

$(document).ready(function(){
    console.log("Setting interval");
    setInterval(checkEmail, 500);
}); 
</script>