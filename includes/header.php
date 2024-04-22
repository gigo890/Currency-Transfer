<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class = "nav">
        <div class="navlist">
        <?php 
        if(basename($_SERVER['PHP_SELF']) == 'user-index.php'  
        || basename($_SERVER['PHP_SELF']) == 'exchange.php'
        || basename($_SERVER['PHP_SELF']) == 'new-account.php'){
                        echo('<a href="user-index.php">Currency Transfer</a>');
                    }else{
                        echo('<a href="index.php">Currency Transfer</a>');
                    }
                    ?>
            <div class="links" id='left'>
                <a href="exchange.php">Exchange</a>
                <a href="">Placeholder</a>
                <a href="">Placeholder</a>
            </div>
            <div class="links" id='right'>
                <?php
                    if(basename($_SERVER['PHP_SELF']) == 'user-index.php' 
                    || basename($_SERVER['PHP_SELF']) == 'exchange.php'
                    || basename($_SERVER['PHP_SELF']) == 'new-account.php'){
                        echo('<a href="logout.php">Log Out</a>');
                    }else if(basename($_SERVER['PHP_SELF']) == 'register.php' || basename($_SERVER['PHP_SELF']) == 'login.php'){
                        echo('<a href="index.php">Return</a>');
                    }
                    else{
                    echo('<a href="login.php">Login / Sign Up</a>');
                    }
                ?>
                
            </div>
        </div>
        <div class="icon-container">
            <div href="javascript:void(0);" class="menu" alt="open menu" onclick ="myFunction()">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
        </div>
    </div>
    <script defer src="js/main.js"></script>
</body>
</html>