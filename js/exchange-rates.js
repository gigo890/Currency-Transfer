const apiKey = '3c8926bff129de21d35b07a1';
const BASE_URL = `https://v6.exchangerate-api.com/v6/${apiKey}`;

const base = "USD";
const currencyArray = ['USD','GBP','AUD','EUR','JPY'];
for(let i of currencyArray){
    console.log("THIS DOES SOMETHING");
    const url = `${BASE_URL}/pair/${base}/${i}`;
    fetch(url)
        .then((resp) => resp.json())
        .then((data) => {
            const conversionResult = (1 * data.conversion_rate).toFixed(2);
            const formattedResult = conversionResult.replace(
                /\B(?=(\d{3})+(?!\d))/g,
                ","
            );
            document.getElementById(i+"-rate").innerHTML = formattedResult + " " + i;
        })
        .catch(() =>{

    })
}

