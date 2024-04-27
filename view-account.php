<?php
    session_start();
    $userID = $_SESSION['user_id'];
    $accountID = $_SESSION['viewAccount'];
    include("includes/config.php");
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
        include("includes/header.php")
    ?>

    <div class="container" id="view-account">
        <?php 
            $sql = "SELECT * FROM accounts WHERE account_id = $accountID";
            $result = mysqli_query($db, $sql);
            $account = mysqli_fetch_assoc($result);
            $accountName = $account['account_name'];
            echo "
                <h1>".$account['account_name']."</h1>
                <p>ID:" .$account['account_id']."</p>
                <p>Currency Type:" .$account['currency_type']."</p>
                <div class='balance-container'>
                <h2>Balance</h2>
                <p>".$account['balance']. " " .$account['currency_type']."</p>
                </div>
                <div class='history-container'>";
            $sql = "SELECT * FROM transfers WHERE sender = $accountID OR receiver = $accountID";
            $result = mysqli_query($db, $sql);
            $queryResult = mysqli_num_rows($result);

            if($queryResult > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $senderID = $row['sender'];
                    $sql = "SELECT account_name FROM accounts WHERE account_id = $senderID";
                    $senderResult = mysqli_query($db,$sql);
                    $sender = mysqli_fetch_assoc($senderResult);

                    $receiverID = $row['receiver'];
                    $sql = "SELECT account_name FROM accounts WHERE account_id = $receiverID";
                    $receiverResult = mysqli_query($db, $sql);
                    $receiver = mysqli_fetch_assoc($receiverResult);
                    echo"
                        <div class='transfer'>
                            <div class='transfer-column'>
                                <h2> Sender</h2>
                                <p>".$sender['account_name']."</p>
                            </div>    
                            <div class='transfer-column'>
                                <h2> Receiver</h2>
                                <p>".$receiver['account_name']."</p>
                            </div>  
                            <div class='transfer-column'>
                                <h2>Transaction</h2>";
                    if($sender['account_name'] == $account['account_name'])
                    {
                        echo "<p class='sent'>-".$row['amount_sent'] ." ". $row['currency_sent']."</p>";
                    }else{
                        echo "<p class='received'>+".$row['amount_received']." ".$row['currency_received']."</p>";
                    }
                    echo "</div>
                    </div>";

                    /* SCRAP ECHOES ABOVE AND MAKE THE TRANSFERS DISPLAY IN A TABLE (IT'S BED TIME NOW, SO DO IT TOMORROW YOU LAZY ASS) */
                }
            }

        ?>
    </div>
    </body>
</html>