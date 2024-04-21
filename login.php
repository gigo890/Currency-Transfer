<?php
require_once('includes/config.php');
require_once('includes/session.php');

$error = ''; 
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($POST['submit'])){

    $email = trim($POST['email']);
    $password = trim($POST['password']);

    if(empty($email)){
        $error .= '<p class="error">Please Enter Email.</p>';
    }

    if(empty($password)){
        $error .= '<p class="error">Please enter your password.</p>';
    }

    if(empty($error)){
        if($query = $db->prepare('SELECT * FROM users WHERE email = ?')){
            $query->bind_param('s', $email);
            $query->execute();
            $row = $query->fetch();
            if($row){
                if(password_verify($password, $row['password'])){
                    $_SESSION["userid"] = $row['user_id'];
                    $_SESSION['user'] = $row;

                    header("location:index.php");
                    exit;
                }else{
                    $error .= '<p class="Error">The Password is not valid.</p>';
                }
            }else{
                $error .= '<p class="error">That Email is not registered.</p>';
            }
        }
        $query->close();
    }
    mysqli_close($db);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/mobile.css">
    <link rel="stylesheet" href="css/desktop.css" media="only screen and (min-width: 700px)"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <?php include("includes/header.php") ?>
    <div class='container'>
        <div class='form-container'>
            <form class="form-box" action="" method="post">
                <label for="email">Email:</label>
                <input type="text" placeholder="Enter Email" name="email" required>

                <label for="password">Password:</label>
                <input type="text" placeholder="Enter Password" name="password" required>
            </form>
            <p>Don't have an account? <a href="register.php">Register Here</a></p>
        </div>
                
    </div>
</body>
</html>