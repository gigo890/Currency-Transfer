<?php
    session_start();
    $userID = $_SESSION['user_id'];
    include("includes/config.php");

    $accountID = null;
    $name = null;
    $currency = null;
    $balance = null;

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){
        
        $accountID = $_POST['sender'];
        $amount = $_POST['amount'];
        
        $balance = mysql_query($db, "SELECT balance FROM accounts WHERE account_id = $accountID");
        if($balance >= $amount){
            echo'<p class="success">Your transfer has been successful!</p>';
            /* ADDING AND SUBTRACTING MONEY (NEEDS RECIEVER CODED IN SELECT) */
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
                    <label for="sender">Enter Sender Account:</label>
                    <select name="sender" id="fromAccount">
                        <?php
                            $sql = "SELECT * FROM accounts WHERE owner = $userID";
                            $result = mysqli_query($db, $sql);
                            $queryResult = mysqli_num_rows($result);

                            if($queryResult > 0){
                                while($row = mysqli_fetch_assoc($result)){
                                    $accountID = $row["account_id"];
                                    $name = $row["account_name"];
                                    $currency = $row["currency_type"];
                                    $balance = $row["balance"];
                                    echo'
                                    <option value='.$userID.'>'.$name.' - '.$currency.'</option>
                                    ';
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="amount">Enter amount:</label>
                    <input type="number" id="amount" placeholder="Enter Amount">
                    <br>
                </div>
                <div class="form-group">
                    <label for="output-amount">Transfer to:</label>
                    <select name="receiver" id="toCurrency">
                        <?php
                            $sql = "SELECT * FROM accounts WHERE owner = $userID";
                            $result = mysqli_query($db, $sql);
                            $queryResult = mysqli_num_rows($result);
                            if($queryResult > 0){ /* PREFERABLY EXCLUDES SENDER ACCOUNT, SO NEEDS SOME SORT OF SELECTION */
                                while($row = mysqli_fetch_assoc($result)){
                                    if($row['account_id'] == $_POST['sender'])
                                    $accountID = $row["account_id"];
                                    $name = $row["account_name"];
                                    $currency = $row["currency_type"];
                                    $balance = $row["balance"];
                                    echo'
                                    <option value='.$userID.'>'.$name.' - '.$currency.'</option>
                                    ';
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <div id="result" class="result-box"></div>
                    <div id="error" class="error"></div>
                </div>
                <button id="convert-button">Convert</button>

                 <!-- MAKE CONVERT ACT AS A PREVIEW OF THE AMOUNT AFTER CONVERSION
                      ADD NEW BUTTON TO ACTUALLY TRANSFER THE MONEY-->
                </form>
            </div>
        </div>
            
    </div>

    <script src="js/exchange-api.js"></script>
    <script>
        document.getElementById("convert-button").addEventListener("click", convertCurrency);
    </script>
</body>

</html>