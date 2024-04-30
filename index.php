
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
    <?php include("includes/header.php")?>
    <div class="banner" id = "index">
        <h1>Currency Transfer</h1>
    </div>
    <?php 
    include("includes/exchange-rates.php");
    ?>
    <script defer src="js/main.js"></script>
</body>
</html>