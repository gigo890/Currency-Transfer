
const apiKey = '3c8926bff129de21d35b07a1';
const BASE_URL = `https://v6.exchangerate-api.com/v6/${apiKey}`;
const fromCurrencyCode = document.getElementById("fromCurrency").value;
const toCurrencyCode = document.getElementById("toCurrency").value;
const amount = document.getElementById("amount").value;
const result = document.getElementById("result");
const error = document.getElementById("error");
console.log(fromCurrencyCode);
console.log(toCurrencyCode);
if (amount !== "" && parseFloat(amount) >= 1) {
    const url = `${BASE_URL}/pair/${fromCurrencyCode}/${toCurrencyCode}`;

    fetch(url)
        .then((resp) => resp.json())
        .then((data) => {
            const conversionResult = (amount * data.conversion_rate).toFixed(2);
            const formattedResult = conversionResult.replace(
                /\B(?=(\d{3})+(?!\d))/g,
                ","
            );
            result.innerHTML = `${formattedResult} ${toCurrencyCode}`;
            document.getElementById("resultStore").value = `${formattedResult} ${toCurrencyCode}`;

            console.log("test");
        })
        .catch(() => {
            error.textContent = "An error occurred, please try again later";
        });
} else {
    error.textContent = "Please enter a valid amount";
}
