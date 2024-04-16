<?php
    require_once "config.php";
    require_once "session.php";

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){

        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $confirmPassword = trim($_POST['confirmPassword']);
        $passwordhash = password_hash($password, PASSWORD_BCRYPT);
        $phoneNum = trim($_POST['phoneNum']);
        $dob = trim($_POST['dob']);
        
        if($query = $db->prepare("SELECT * FROM users WHERE email = ?")){
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
                    $insertQuery->bind_param("sss", $fname, $lname, $email, $password, $phoneNum, $dob, $passwordHash);
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
        $insertQuery->close();
        mysqli_close($db);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="form-container">

            <form type="" method="post">
                <div class="form-box">
                    <label for="fname">First Name:</label>
                    <input type="text" name="fname" class="form-input" required>

                    <label for="lname">Last Name</label>
                    <input type="text" name="lname" class="form-input" required>

                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form=input" required>

                    <label for="password">Password:</label>
                    <input type="text" name="password" class="form-input" required>

                    <label for="confirmPassword">Confirm Password:</label>
                    <input type="text" name="confirmPassword" class="form-input" required>

                    <label for="phoneNum">Phone Number: </label>
                    <input type="text" name="phoneNum" class="form-input" required>
                    
                    <label for="dob">Date Of Birth</label>
                    <input type="date" name="dob" class="form-input" required>


                </div>
            </form>
        </div>
    </div>
</body>
</html>