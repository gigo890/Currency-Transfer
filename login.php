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
    <?php include("includes/header.php") ?>
    <div class='container'>
        <div class='form-container'>
            <div class='form-box'>
                <form class="form-box" action="" method="post">
                    <label for="email">Email:</label>
                <input type="text" placeholder="Enter Email" name="email" required>

                <label for="password">Password:</label>
                <input type="text" placeholder="Enter Password" name="password" required>
                </form>
                
            </div>
        </div>
    </div>
</body>
</html>