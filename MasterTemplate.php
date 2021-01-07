<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Giftany & Co.</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/site.css">

</head>
<body>
    <div class="container-fluid">
    <!-- 2nd row -->
        <div class="row">
            <div class="col-sm-12">
                <?php include("navbar.php"); ?>
            </div>
        </div>
    <!-- 3rd row -->
        <div class="row">
            <div class="col-sm-12" style="padding:0 20%;"> 
                <?php echo $MainContent; ?>
            </div>
        </div>
    <!-- 4th row -->
        <div class="row">
            <div class="col-sm-12" style="text-align: center;">
                <hr>
                Do you need help? Please email to:
                <a href="mailto:giftany@np.edu.sg">giftany@np.edu.sg</a>
                <p style="font-size:12px">&copy;Copyright by Giftany & Co.</p>
            </div>
        </div>
    </div>  
</body>
</html>