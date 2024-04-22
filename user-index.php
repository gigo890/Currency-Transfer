
<?php
    session_start();
    $userID = $_SESSION['user_id'];
    include("includes/config.php");
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
        include("includes/header.php")
    ?>
        
    <div class="container" id="user-index">
        <div class="welcome-container">
            <h1>Welcome, <?php echo($_SESSION['user']['first_name']);?></h1>
        </div>
        <h1>Accounts</h1>
        <div class="grid" id="account-container">
            <div class="account">
                <h1>Account Name</h1>
                <p>currency type:</p>
                <p>PLACEHOLDER</p>
                <p>balance:</p>
                <p>£0.00</p>
            </div>

            <?php
                $sql = "SELECT * FROM accounts WHERE owner = $userID";
                $result = mysqli_query($db, $sql);
                $queryResult = mysqli_num_rows($result);

                if($queryResult > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo'
                        <div class="account">
                            <h1>'.$row["account_name"].'</h1>
                            <p>Currency Type: '.$row["currency_type"].'</p>
                            <p>Balance:</p>
                            <p>'.$row["balance"].'</p>
                        </div>';
                    }
                }
            ?>
            <div class="account" id="new">
                <div class="image-container">
                <a href="new-account.php" class="new-image"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- <?php include("includes/footer.php")?> -->
    <script defer src="js/main.js"></script>
</body>
</html>