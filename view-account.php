<?php
    session_start();
    include("includes/config.php");
    $userID = $_SESSION['user_id'];
    $accountID = $_SESSION['viewAccount'];

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete-account'])){
        header('location: delete.php');
    }
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['review'])){
        $sql = "SELECT review_id 
                FROM reviews 
                WHERE transfer = ( SELECT transfer_id FROM transfers WHERE sender = $accountID AND is_suspicious = 1)";
        $result = mysqli_query($db, $sql);
        $review = mysqli_fetch_assoc($result);
        $_SESSION['review_id'] = $review['review_id'];

        header('location: review-details.php');
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
        include("includes/header.php")
    ?>

    <div class="container" id="view-account">
        <div class="back-button">
            <a href="user-index.php">Back</a>
        </div>
        <div class="account-container">
            <div class="account-detail">
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
                    </div>";
            ?>
            <div class="buttons">
                <?php 
                if($account['is_suspended']){
                echo '<form method="post"><input type="submit" id="review" name="review" value="View Review"></form>';
                }else{
                echo'<form action="add-currency.php"><input type="submit" id="add" name="add-funds" value="Add Funds"></form>
                <form method="post"><input type="submit" id="delete" name="delete-account" value="delete account"></form>';
                }
                ?>
            </div>
        </div>
        </div>
            <div class='history-container'>
                <table>
                    <thead>
                        <tr>
                        <th>Account Reference</th>
                        <th>Transaction</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
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

                                    echo "
                                    <tr class='transfer'>
                                        <td class='history-column'>";
                                            if($account['account_name'] == $receiver['account_name'] || $account['account_name'] == $account['account_name']){
                                                echo "<p>".$sender['account_name']."</p>";
                                            }else{
                                                echo "<p>".$receiver['account_name']."</p>";
                                            }echo "
                                        </td>
                                        <td class='history-column'>";
                                            if($account['account_name'] == $sender['account_name']){
                                                echo "<p class='sent'>-".$row['amount_sent']." ".$row['currency_sent']."</p>";
                                            }else{
                                                echo "<p class='received'>+".$row['amount_received']." ".$row['currency_received']."</p>";
                                            } echo"
                                        </td>
                                    </tr>";
                                        

                                        
                                        


                                    /* SCRAP ECHOES ABOVE AND MAKE THE TRANSFERS DISPLAY IN A TABLE (IT'S BED TIME NOW, SO DO IT TOMORROW YOU LAZY ASS) */
                                }
                            }
                            
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </body>
</html>