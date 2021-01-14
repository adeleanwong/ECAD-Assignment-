<?php 
//Display guest welcome message, Login and Registration links
//when shopper has yet to login,
$content1 = "<h2> Welcome Guest</h2>";
$content2 = "<li class='nav-item'>
		     <a class='nav-link' href='register.php'>Sign Up</a></li>
			 <li class='nav-item'>
		     <a class='nav-link' href='login.php'>Login</a></li>";

if(isset($_SESSION["ShopperName"])) { 
	//To Do 1 (Practical 2) - 
    //Display a greeting message, Change Password and logout links 
    //after shopper has logged in.
    $content1 = "<h2>Welcome <b> $_SESSION[ShopperName]</b></h2>";
    $content2 = "<li class='nav-item'>
                <a class='nav-link' href='profile.php'>Edit Profile</a></li>
                <li class='nav-item'>
                <a class='nav-link' href='logout.php'>Logout</a></li>";

	//To Do 2 (Practical 4) - 
    //Display number of item in cart
	if (isset($_SESSION["NumCartItem"])){
        $content1 .= ", $_SESSION[NumCartItem] item(s) in shopping cart";
        //$content1 .= ", $_SESSION[NumCartItem] item(s) in shopping cart";

    }
}
?>
<!-- To Do 3 (Practical 1) - 
     Display a navbar which is visible before or after collapsing -->

<nav class="navbar navbar-expand-md d-flex justify-content-center">
    <span class="navbar-text ml-md-2" style="color:white; max-width: 80%;">
        <?php echo $content1;?>
    </span>

    <button class="navbar-toggler" tyle="button" data-toggle="collapse" data-target="#collapsibleNavBar">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>
<!-- To Do 4 (Practical 1) - 
     Define a collapsible navbar -->
<nav class="navbar navbar-expand ">
    <a href="index.php"><h2 class="brand">Giftany</h2></a>
    <div class="p-2 flex-grow-1 bd-highlight">
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link"href="category.php">Product Categories</a></li>
        <li class="nav-item">
            <a class="nav-link" href="search.php">Product Search</a></li>
        <li class="nav-item">
            <a class="nav-link" href="shoppingCart.php">Shopping Cart</a></li>
    </ul>
    </div>
    <div class="p-2 bd-highlight">
        <ul class="nav navbar-nav navbar-right">
            <?php echo $content2; ?>    
        </ul>  
    </div>
     
</nav>
<!-- <nav class="navbar navbar-expand-md">
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="../ECAD-Assignment-/2-Products/category.php">Product Categories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="search.php">Product Search</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="shoppingCart.php">Shopping Cart</a>
            </li>
        </ul>
        
        <ul class="navbar-nav ml-auto">
        </ul>
    </div>
</nav> -->

