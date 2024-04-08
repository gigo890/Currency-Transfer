function convertCurrency() {
    const apiKey = '3c8926bff129de21d35b07a1';
    const BASE_URL = `https://v6.exchangerate-api.com/v6/${apiKey}`;

    const fromCurrencyCode = document.getElementById("fromCurrency").value;
    const toCurrencyCode = document.getElementById("toCurrency").value;
    const amountInput = document.getElementById("amount");
    const result = document.getElementById("result");
    const error = document.getElementById("error");

    const amount = amountInput.value;

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

                result.innerHTML = `${amount} ${fromCurrencyCode} = ${formattedResult} ${toCurrencyCode}`;
                amountInput.value = ""; // Clear the amount input after conversion
                error.textContent = ""; // Clear any previous error message
            })
            .catch(() => {
                error.textContent = "An error occurred, please try again later";
            });
    } else {
        error.textContent = "Please enter a valid amount";
    }
}
