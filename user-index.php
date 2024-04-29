
<?php
    session_start();
    $userID = $_SESSION['user_id'];
    include("includes/config.php");

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['account-id'])){
        echo "test";
        $_SESSION['viewAccount'] = $_POST['account-id'];
        header("Location: view-account.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
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
            <?php
                $sql = "SELECT * FROM accounts WHERE owner = $userID AND is_disabled = 0";
                $result = mysqli_query($db, $sql);
                $queryResult = mysqli_num_rows($result);

                if($queryResult > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo'
                        <div class="account">';
                        if($row['is_suspended']){ echo "<h1 style='color:red;'>SUSPENDED"; }
                            echo'
                            <h1>'.$row['account_name'].'</h1>
                            <p>Currency Type: '.$row["currency_type"].'</p>
                            <p>Balance:</p>
                            <p>'.$row["balance"].'</p>
                            <form method="post"><button name="account-id" value="'.$row['account_id'].'">View Account Details</buttton></form>
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