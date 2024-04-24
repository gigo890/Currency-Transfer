<?php
require_once('includes/config.php');
require_once('includes/session.php');

$error = ''; 
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if(empty($email)){
        $error .= '<p class="error">Please Enter Email.</p>';
    }

    if(empty($password)){
        $error .= '<p class="error">Please enter your password.</p>';
    }

    if(empty($error)){
        if($query = $db->prepare("SELECT * FROM users WHERE email = ?")){
            $query->bind_param('s', $email);
            $query->execute();
            $result = $query->get_result();

            if($result->num_rows == 1){

                $user = $result->fetch_assoc();
                $_SESSION['user'] = $user;
                $userID = $user['user_id'];
                $passwordHash = $user['password'];

                if(password_verify($password, $passwordHash)){
                    $_SESSION["user_id"] = $userID;
                    $_SESSION["user"] = $user;
                    header("Location: user-index.php");
                    exit();
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
    <?php 
    $includeOption = 'form';
    include("includes/header.php");
    ?>
    <div class='form-container'>
        <div class="form-box">
            <h1 id="login">Log in</h1>
            <form action="" method="post">
                <label for="email">Email:</label>
                <input type="text" placeholder="Enter Email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" placeholder="Enter Password" name="password" required>

                <input type="submit" name="submit" class="btn" value="Submit">
            </form>
            <p>Don't have an account? <a href="register.php">Register Here</a></p>
        </div>
                
    </div>
</body>
</html>