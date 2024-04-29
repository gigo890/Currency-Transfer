<?php
    session_start();
    include('includes/config.php');

    
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['review-details'])){
        $_SESSION['review_id'] = $_POST['review-details'];
        header("Location: review-details.php");
    }
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['transfer-submit'])){

        $limit = $_POST['transfer-limit'];

        $db->query("UPDATE adminconfig SET transfer_limit = $limit WHERE 1");
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
    <?php include('includes/admin-header.php')?>
    <div class="container">
        <div class="limit-container">
            <form method="post">
                <label for="transfer-limit">Set Transfer Limit: </label>
                <input type="number" name="transfer-limit" id="transfer-limit" required>
 
                <input type="submit" name="transfer-submit" class="btn" value="Submit">
            </form>
        </div>
        <div class="table-container">
        <form class="table-filters" method="post">
            <select name="status" id="status">
                <option value="all">All</option>
                <option value="complete">Complete</option>
                <option value="incomplete">Incomplete</option>
            </select>
            <input type="submit" name="submit" value="Confirm Filters">
        </form>
            <table>
            <thead>
                <tr>
                    <th>Review ID</th>
                    <th>Amount Sent</th>
                    <th>Time of Transaction</th>
                    <th>Evidence Submitted</th>
                    <th>details</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){
                switch($_POST['status']){
                    case("all"):
                        $sql = "SELECT * FROM reviews";
                        break;
                    case("complete"):
                        $sql = "SELECT * FROM reviews WHERE case_closed = 0";
                        break;
                    case("incomplete"):
                        $sql = "SELECT * FROM reviews WHERE case_closed = 1";
                    break;
                }
                $result = mysqli_query($db, $sql);
                $queryResult = mysqli_num_rows($result);

                if($queryResult>0){
                    while($row = mysqli_fetch_assoc($result)){

                        $transferID = $row['transfer'];
                        $sql = "SELECT * FROM transfers WHERE transfer_id = $transferID";
                        $transferResult = mysqli_query($db, $sql);
                        $transfer = mysqli_fetch_assoc($transferResult);

                        
                        echo "
                        <tr>
                            <td>".$row['review_id']."</d>
                            <td>".$transfer['amount_sent']." ".$transfer['currency_sent']."</d>
                            <td>".$transfer['transfer_time']."</d>
                            <td>";
                            if($row['evidence']){ 
                                echo "YES";
                            }else{
                                echo "NO";
                            }
                            echo 
                            "</td>
                            <td><form method='post'><button name='review-details' value='".$row['review_id']."'>Details</button></d>
                        </tr>
                        ";
                    }
                }
            }
            ?>
            </tbody>
        </table>
        </div>
        
    </div>
</body>
</html>