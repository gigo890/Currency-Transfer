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
    <?php include ("includes/header.php") ?>
    <div class="container" id="exchange">
        <div id="transfer-container">
            <div id="currency-input">
                <label for="amount">Enter Amount:</label>
                <select id="fromCurrency">
                    <option value="GBP">GBP</option>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <option value="AUD">AUD</option>
                </select>
                <input type="number" id="amount" placeholder="Enter Amount">
                <br>
            </div>
            <div id="currency-output">
                <label for="output-amount">Transfer to:</label>
                <select id="toCurrency">
                    <option value="GBP">GBP</option>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <option value="AUD">AUD</option>
                </select>
                <div id="result" class="result-box"></div>
                <div id="error" class="error"></div>

            </div>
            <div id="result" class="result-box"></div>
            <button id="convert-button">Convert</button>
        </div>
    </div>

    <script src="js/exchange-api.js"></script>
    <script>
        document.getElementById("convert-button").addEventListener("click", convertCurrency);
    </script>
</body>

</html>