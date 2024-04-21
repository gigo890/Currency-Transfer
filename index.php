
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/mobile.css">
    <link rel="stylesheet" href="css/desktop.css" media="only screen and (min-width: 700px)"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Transfer | Home</title>
</head>
<body>
    <?php 
        $includeOption = 'index';
        include("includes/header.php")
    ?>
    <div class="banner" id = "index">
        <h1>Currency Transfer</h1>
    </div>
    <div class="container">
        <div class="lineDivider"></div>
        <div class="sideContainer">
            <ul>
                <li class="exchangeRate"id="GDP">
                    <h1>GBP</h1>
                    <h2>Great British Pound</h2>
                </li>
                <li class="exchangeRate"id="USD">
                    <div class="exchangeTitle">
                        <h1>USD</h1>
                        <h2>United States Dollar</h2>
                    </div>
                    
                </li>
                <li class="exchangeRate"id="JPY">
                    <h1>JPY</h1>
                    <h2>Japanese Yen</h2>
                </li>
                <li class="exchangeRate"id="EUR">
                    <h1>EUR</h1>
                    <h2>Euro</h2>
                </li>
                <li class="exchangeRate" id="AUD">
                    <h1>AUD</h1>
                    <h2>Australian Dollar</h2>
                    <div class="info">
                        <p></p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- <?php include("includes/footer.php")?> -->
    <script defer src="js/main.js"></script>
</body>
</html>