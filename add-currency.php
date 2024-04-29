<?php
    session_start();
    require_once('includes/config.php');
    $accountID = $_SESSION['viewAccount'];

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){
        if($query = $db->prepare("SELECT * FROM accounts WHERE account_id = $accountID")){

            $amount = $_POST['amount'];

            if($query = $db->prepare("SELECT * FROM accounts WHERE account_id = ?")){
                $query->bind_param('i', $accountID);
                $query->execute();
                $result = $query->get_result();

                if($result->num_rows > 0){
                    $account = $result->fetch_assoc();
                    $newBalance = $amount + $account['balance'];
                    $currentTime = date("Y-m-d h:i:sa");

                    $db->query("UPDATE accounts SET balance = $newBalance WHERE account_id = $accountID");

                    $insertQuery = $db->prepare("INSERT INTO transfers (sender, receiver, amount_sent, amount_received, currency_sent, currency_received, transfer_time) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $insertQuery->bind_param("iiddsss", $accountID, $accountID, $amount, $amount, $account['currency_type'], $account['currency_type'], $currentTime);
                    $result = $insertQuery->execute();
                    if($result){
                    $errorSuccess = "<p class='success'>Your top-up has been successful!</p>";
                    header('location: view-account.php');
                    }
                }
            }
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
    <title>Add Funds</title>
</head>
<body>
    <?php include('includes/header.php');?>
    <div class="container" id="add-currency">
        <div class="form-container">
            <div class="form-box">
                <h1>Add Funds</h1>
                <form method="post">
                    <label for="cardNum">Card Number:</label>
                    <input type="text" name = "cardNum" class="form-input" required>

                    <label for="expiryDate">Expiry Date:</label>
                    <input type="month" name="Expiry Date" class="form-input" required>

                    <label for="cvv">CVV:</label>
                    <input type="text" name="cvv" class="form-input" required>

                    <label for="amount">Amount:</label>
                    <input type="text" name="amount" class="form-input" required>

                    <input type="submit" name="submit" class="btn" value="Submit">
                </form>
            </div>
        </div>
    </div>
</body>
</html>