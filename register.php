<?php
    require_once "includes/config.php";
    require_once "includes/session.php";

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){

        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $confirmPassword = trim($_POST['confirmPassword']);
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $phoneNum = trim($_POST['phoneNum']);
        $dob = trim($_POST['dob']);

        $insertQuery = null;
        
        if($query = $db->prepare("SELECT * FROM users, admins WHERE email = ?")){
            $error='';

            $query->bind_param('s', $email);
            $query->execute();

            $query->store_result();
            if($query->num_rows > 0){
                $error .= '<p class="error">The Email Address is already registered!</p>';
            }else{
                if(strlen($password) < 6){
                    $error .= '<p class="error">The password must be 6 characters long</p>';
                }

                if(empty($confirmPassword)){
                    $error .= '<p class="error">Please confirm your password</p>';
                }else{
                    if(empty($error) && ($password != $confirmPassword)){
                        $error .= '<p class="error">Password did not match.</p>';
                    }
                }
                if(empty($error)){
                    $insertQuery = $db->prepare("INSERT INTO users (first_name, last_name, email, password, phone_number, dob) VALUES (?, ?, ?, ?, ?, ?);");
                    $insertQuery->bind_param("ssssss", $fname, $lname, $email, $passwordHash, $phoneNum, $dob);
                    $result = $insertQuery->execute();
                    if( $result){
                        $error .= '<p class="success">Your Registration has been successful!</p>';
                    }else{
                        $error .= '<p class="error">Something went wrong!</p>';
                    }
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
    <?php 
        $includeOption = 'form';
        include("includes/header.php") 
    ?>
    <div class="container">
        <div class="form-container">
            <div class="form-box">
                <h1>Register</h1>
                <form method="post">
                        <label for="fname">First Name:</label>
                        <input type="text" name="fname" class="form-input" required>

                        <label for="lname">Last Name</label>
                        <input type="text" name="lname" class="form-input" required>

                        <label for="email">Email:</label>
                        <input type="email" name="email" class="form-input" required>

                        <label for="password">Password:</label>
                        <input type="password" name="password" class="form-input" required>

                        <label for="confirmPassword">Confirm Password:</label>
                        <input type="password" name="confirmPassword" class="form-input" required>

                        <label for="phoneNum">Phone Number: </label>
                        <input type="text" name="phoneNum" class="form-input" required>
                        
                        <label for="dob">Date Of Birth</label>
                        <input type="date" name="dob" class="form-input" required>

                        <input type="submit" name="submit" class="btn" value="Submit">
                </form>
                <p>Already have an account? <a href="login.php">Login</a></p>
                <?php if(isset($_POST['submit'])){echo($error);}?>
            </div>
            
        </div>
    </div>
</body>
</html>