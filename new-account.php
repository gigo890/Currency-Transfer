<?php 
    require_once "includes/config.php";
    require_once "includes/session.php";

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){

        $accountName = trim($_POST['accountName']);
        $currency = trim($_POST['currency']);

        $insertQuery = null;

        if($query = $db->prepare("SELECT * FROM accounts WHERE account_name = ?")){
            $error='';

            $query->bind_param('s',$email);
            $query->execute();

            $query->store_result();
            if($query->num_rows > 0){
                $error .= '<p class="error">That account name has already been used</p>';
            }else{
                
                $insertQuery = $db->prepare("INSERT INTO accounts (owner, account_name, currency_type) VALUES (?,?,?);");
                $insertQuery->bind_param("sss", $_SESSION['user_id'], $accountName, $currency);
                $result = $insertQuery->execute();
                if($result){
                    $error.='<p class="success">Your Account has been created successfully!</p>';
                }else{
                    $error.='<p class="error">Something went wrong!</p>';
                }
            }
        }
        $query->close();
        if($insertQuery !== null){
            $insertQuery->close();
        }
        mysqli_close($db);
        sleep(1);
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
    <?php include("includes/header.php")?>

    <div class="container">
        <div class="form-container">
            <div class="form-box">
                <h1>Create New Account</h1>
                <form action="" method="post">
                    <label for="accountName">Account Name</label>
                    <input type="text" placeholder="Enter account name" name="accountName" required>

                    <label for="currency">Currency: </label>
                    <select name="currency">
                        <option value="GBP">GBP</option>
                        <option value="USD">USD</option>
                        <option value="EUR">EUR</option>
                        <option value="AUD">AUD</option>
                        <option value="JPY">JPY</option>
                    </select>
                    <input type="submit" name="submit" class="btn" value="submit">
                </form>
            </div>

        </div>
    </div>
    
</body>
</html>