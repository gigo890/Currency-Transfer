<?php
    session_start();
    $userID = $_SESSION['user_id'];
    include("includes/config.php");

    $sql = "SELECT * FROM adminconfig WHERE 1";
    $result = mysqli_query($db, $sql);
    $limit = mysqli_fetch_object();

    $errorSuccess = "";
    $receivedAmount = 0;

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['transfer'])){
        
        $senderID = $_POST['sender'];
        $receiverID = $_POST['receiver'];
        $amount = $_POST['amount'];

        if(isset($_POST['resultStore'])){
            $receivedAmount = explode(" ", $_POST['resultStore'])[0];
        }
        if($query = $db->prepare('SELECT balance, currency_type FROM accounts WHERE account_id = ?')){
            $query->bind_param('s', $senderID);
            $query->execute();
            $result = $query->get_result();

            if($result->num_rows > 0){
                $sender = $result->fetch_assoc();
                $balance = $sender['balance'];
                $sentCurrency = $sender['currency_type'];
                echo $sentCurrency;

                if($balance >= $amount){
                        $newBalance = $balance - $amount;
                        $db->query("UPDATE accounts SET balance = $newBalance WHERE account_id = $senderID");

                        if($query = $db->prepare('SELECT balance, currency_type FROM accounts WHERE account_id = ?')){
                            $query->bind_param('s', $receiverID);
                            $query->execute();
                            $result = $query->get_result();

                            if($result->num_rows > 0){
                                $receiver = $result->fetch_assoc();
                                $balance = $receiver['balance'];
                                $currentTime = date("Y-m-d h:i:sa");
                                $newBalance = (float)$balance + (float)$receivedAmount;
                                $db->query("UPDATE accounts SET balance = $newBalance WHERE account_id = $receiverID");
                                $sus = 0;

                                if($_POST['is-suspiscious']){
                                    $db->query("UPDATE accounts SET is_suspended = 1 WHERE account_id = $senderID");
                                    $sus = 1;
                                }

                                $insertQuery = $db->prepare("INSERT INTO transfers (sender, receiver, amount_sent, amount_received, currency_sent, currency_received, transfer_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                                $insertQuery->bind_param("iiddsssi", $senderID, $receiverID, $amount, $receivedAmount, $sender['currency_type'], $receiver['currency_type'], $currentTime, $sus);
                                $result = $insertQuery->execute();
                                
                                if($result){
                                $errorSuccess = "<p class='success'>Your transfer has been successful!</p>";
                                header('location: user-index.php');
                                }
                            }
                        }
                    }
                    
                }else{
                    $errorSuccess = "<p class='error'>Insufficient balance</p>";
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

    <title>Document</title>
</head>

<body>
    <?php 
        $includeOption = 'default';
        include("includes/header.php") 
    ?>
    <div class="container" id="exchange">
        <div id="transfer-container">
            <form id="exchange" action="" method="post">
                <div class="form-group">
                    <input id="limit" style="display:none;"value=<?phpecho $limit?>>
                    <label for="sender">Enter Sender Account:</label>
                    <select name="sender" id="fromAccount">
                        <?php
                            $sql = "SELECT * FROM accounts WHERE owner = $userID AND is_suspended = 0 AND is_disabled = 0";
                            $result = mysqli_query($db, $sql);
                            $queryResult = mysqli_num_rows($result);

                            if($queryResult > 0){
                                while($row = mysqli_fetch_assoc($result)){
                                    $senderID = $row["account_id"];
                                    $name = $row["account_name"];
                                    $currency = $row["currency_type"];
                                    $balance = $row["balance"];
                                    echo"<option value=$senderID ";
                                    if (isset($_POST['sender'])) {
                                        if ($_POST['sender'] == $senderID) {
                                            echo "selected";
                                        }
                                    }
                                    echo '>'.$name.' - '.$currency.'</option>
                                    ';
                                }
                            }
                        ?>
                    </select>
                    <?php 
                        if(isset($_POST['sender'])){
                        $sql = "SELECT currency_type FROM accounts WHERE account_id = ".$_POST['sender'];
                        $result = mysqli_query($db, $sql);
                        $queryResult = mysqli_num_rows($result);
                        $currency = $result->fetch_object()->currency_type;
                        echo "<input id='fromCurrency' style='display: none;' value='" . $currency . "'>";
                        }
                        ?>
                </div>
                <div class="form-group">
                    <label for="output-amount">Transfer to:</label>
                    <select name="receiver" id="toAccount">
                        <?php
                            $sql = "SELECT * FROM accounts WHERE owner = $userID AND is_suspended = 0 AND is_disabled = 0";
                            $result = mysqli_query($db, $sql);
                            $queryResult = mysqli_num_rows($result);

                            if($queryResult > 0){ /* PREFERABLY EXCLUDES SENDER ACCOUNT, SO NEEDS SOME SORT OF SELECTION */
                                while($row = mysqli_fetch_assoc($result)){
                                    $receiverID = $row["account_id"];
                                    $name = $row["account_name"];
                                    $currency = $row["currency_type"];
                                    $balance = $row["balance"];
                                    echo"<option value=$receiverID ";
                                    if (isset($_POST['receiver'])) {
                                        if ($_POST['receiver'] == $receiverID) {
                                            echo "selected";
                                        }
                                    }
                                    echo '>'.$name.' - '.$currency.'</option>
                                    ';
                                }
                            }
                        ?>
                    </select>
                    <?php 
                        if(isset($_POST['receiver'])){
                        $sql = "SELECT currency_type FROM accounts WHERE account_id = ".$_POST['receiver'];
                        $result = mysqli_query($db, $sql);
                        $queryResult = mysqli_num_rows($result);
                        $currency = $result->fetch_object()->currency_type;
                        echo "<input id='toCurrency' style='display: none;' value='" . $currency . "'>";
                        }
                    ?>
                </div>
                <div class="form-group">
                    <label for="amount">Enter amount:</label>
                    <input type="number" step="0.01" name= "amount" id="amount" <?php if (isset($_POST['amount'])) { echo "value='".$_POST['amount']."'"; } ?> placeholder="Enter Amount">
                    <br>
                </div>
                
                <div class="form-group">
                    <label for="result">Amount Received: </label>
                    <div id="result" class="result-box" name='result'></div>
                    <input type="hidden" id="resultStore" name="resultStore" method="post">
                    <input type="hidden" id="is-suspiscious" name="is-suspiscious" method="post">
                </div>
                <button type="submit" name="convert" id="convert-button">Update Conversion</button>
                <button type="submit" name="transfer">Confirm Transfer</button>
                <div id="error" class="error"><?php echo $errorSuccess?></div>
                </form>
            </div>
        </div>
            
    </div>

    <?php
    if (isset($_POST['receiver'])) {
        echo "<script src='js/exchange-api.js'></script>";
    }
    ?>
</body>

</html>