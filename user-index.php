
<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/mobile.css">
    <link rel="stylesheet" href="css/desktop.css" media="only screen and (min-width: 700px)"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Transfer | Home</title>
</head>
<body>
    <?php 
        $includeOption = 'userIndex';
        include("includes/header.php")
    ?>
        
    <div class="container">
        <div class="welcome-container">
            <h1>Welcome, <?php echo($_SESSION['user']['first_name']);?></h1>
        </div>

        <div class="grid" id="account-container">
            <div class="account">
                <h1>Account Name</h1>
                <p>currency type:</p>
                <p>PLACEHOLDER</p>
                <p>balance:</p>
                <p>£0.00</p>
            </div>
            <div class="account" id="new">
                
            </div>
        </div>
    </div>
    <!-- <?php include("includes/footer.php")?> -->
    <script defer src="js/main.js"></script>
</body>
</html>