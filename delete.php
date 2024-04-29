<?php 
    session_start();
    include('includes/config.php');
    $accountID = $_SESSION['viewAccount'];

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['return'])){
        header('location: view-account.php');
    }
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm'])){

        $deleteQuery = $db->prepare("UPDATE accounts SET is_disabled = 1 WHERE account_id = $accountID");
        $result = $deleteQuery->execute();
        if($result){
            header('location: user-index.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/mobile.css">
    <link rel="stylesheet" href="css/desktop.css" media="only screen and (min-width: 700px)">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include('includes/header.php');?>
    <div class="form-container">
        <div class="form-box" id="delete">
            <?php
                $sql = "SELECT * FROM accounts WHERE account_id = $accountID";
                $result = mysqli_query($db, $sql);
                $account = mysqli_fetch_assoc($result);
                
                if($account['balance']==0){
                    echo'
                    <h1>DELETE ACCOUNT</h1>
                    <h2>Are you sure you want to delete this account?</h2>
                    <form method="post">
                        <input type="submit" name="confirm" value="confirm"class="form-input" id="confirm">
                        <input type="submit" name="return" value="return" class="form-input" id="return">
                    </form>';
                }else{
                    echo'
                    <h1>CANNOT DELETE ACCOUNT</h1>
                    <h2>Please ensure the account balance is empty before deleting.</h2>
                    <form method="post">
                        <input type="submit" name="return" value="return" class="form-input">
                    </form>';
                }
            ?>
        </div>
    </div>
</body>
</html>