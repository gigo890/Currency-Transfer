<?php
    session_start();
    include('includes/config.php');
    $reviewID = $_SESSION['review_id'];
    $sql = "SELECT * FROM reviews WHERE review_id = $reviewID";
    $result = mysqli_query($db, $sql);
    $queryResult = mysqli_num_rows($result);


    if($queryResult > 0){
        $review = mysqli_fetch_assoc($result);
        $transferID = $review['transfer'];

        $sql = "SELECT * FROM transfers WHERE transfer_id = $transferID";
        $result = mysqli_query($db,$sql);
        $transfer = mysqli_fetch_assoc($result);
        $senderID = $transfer['sender'];
        $receiverID = $transfer['receiver'];

        $sql = "SELECT * FROM accounts WHERE account_id = $senderID";
        $result = mysqli_query($db,$sql);
        $sender = mysqli_fetch_assoc($result);
        
        $sql = "SELECT * FROM accounts WHERE account_id = $receiverID";
        $result = mysqli_query($db,$sql);
        $receiver = mysqli_fetch_assoc($result);

        $ownerID = $sender['owner'];
        $sql = "SELECT first_name, last_name, email, phone_number FROM users WHERE user_id = $ownerID";
        $result = mysqli_query($db,$sql);
        $owner = mysqli_fetch_assoc($result);

        if(isset($_POST['approve'])){
            $db->query("UPDATE accounts SET is_suspended = 0 WHERE account_id = $senderID");
            $db->query("UPDATE transfers SET is_suspicious = 0 WHERE transfer_id = $transferID");
            $db->query("UPDATE reviews SET case_closed = 1 WHERE review_id = $reviewID");
        }
        if(isset($_POST['decline'])){

            $newSenderBal = $transfer['amount_sent'] + $sender['balance'];
            $newReceiverBal = $receiver['balance'] - $transfer['amount_received'];

            $db->query("UPDATE accounts SET balance = $newSenderBal WHERE account_id = $senderID");
            $db->query("UPDATE accounts SET balance = $newReceiverBal WHERE account_id = $receiverID");


            $db->query("UPDATE reviews SET case_closed = 1 WHERE review_id = $reviewID");
        }
        if(isset($_POST['reopen'])){
            $db->query("UPDATE reviews SET case_closed = 0 WHERE review_id = $reviewID");
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
    <title>Review Details</title>
</head>
<body>
    <?php 
    if(isset($_SESSION['user_id'])){ include('includes/header.php'); }
    else{ include('includes/admin-header.php'); }
    ?>

    <div class="container" id="review">
        <div class="back-button">
            <?php if(isset($_SESSION['user_id'])){ echo "<a href='view-account.php'>Back</a>"; }
            else{ echo "<a href='admin-index.php'>Back</a>";}
            ?>
        </div>
        <div class="review-container">
            <h1>REVIEW DETAILS</h1>
            <?php
                echo"
                    <p>Review ID: ".$reviewID."</p>
                <div class='review-owner-details'>
                    <h2>Owner Details</h2>
                    <p><span style='font-weight:bold;'>Name: </span>".$owner['first_name']." ".$owner['last_name']."</p>
                    <p><span style='font-weight:bold;'>Email: </span>".$owner['email']."</p>
                    <p><span style='font-weight:bold;'>Phone Number: </span>".$owner['phone_number']."</p>
                </div>
                <div class='transaction-container'>
                <h2>Transaction</h2>
                <p>transfer ID:</p>
                <p> ".$transferID."</p>
                    <table>
                        <thead>
                            <tr>
                                <th>Sender Account</th>
                                <th>Amount Sent</th>
                                <th>Receiver Account</th>
                                <th>Amount Received</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>".$sender['account_name']."</td>
                                <td>".$transfer['amount_sent']." ".$transfer['currency_sent']."</td>
                                <td>".$receiver['account_name']."</td>
                                <td>".$transfer['amount_received']." ".$transfer['currency_received']."</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class='evidence'>
                    <h2>Evidence</h2>
                ";
                if($review['evidence']!="None"){
                    echo "
                    <div class='image-container'>
                        <img src='".$review['evidence']."'>
                    </div>
                    ";
                }
                else{
                    if(isset($_SESSION['admin_id'])){
                        echo "<p>No Evidence has been uploaded.</p>";
                    }else{
                        echo"
                        <form action='upload-evidence.php' method='post' enctype='multipart/form-data'>
                            <label for='file-upload'>File: </label>
                            <input type='file' name='file-upload' id='file-upload' required>

                            <input type='submit' name='submit' class='btn' value='Submit'>
                        </form>        
                        ";
                    }
                }
                echo'
                <div class="manage-review">';
                if(isset($_SESSION['admin_id']) && !$review['case_closed']){
                    echo'
                        <form action="" method="post">
                            <input type="submit" id="approve" name="approve" value="Approve">
                            <input type="submit" id="decline" name="decline" value="decline">
                        </form>';
                }else{
                    echo'<form method="post">
                            <input type="submit" id="reopen" name="reopen" value="Reopen Review">
                        </form>
                        </div>';

                }
            ?>
        </div>
    </div>
</body>
</html>