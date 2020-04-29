const calculatePrice = () => alert('Calculate Price')


const calculatePrice2 = () => {
    alert('Calculate Price 2')
    event.stopPropagation()
}


const clickP3 = () => alert('P3 clicked')


var myButton = document.getElementById('price2')
myButton.onclick = calculatePrice2;
myButton.onclick = calculatePrice;

var myButton = document.getElementById('price3')
myButton.addEventListener('click', calculatePrice2)
myButton.addEventListener('click', calculatePrice)

var myP3 = document.getElementById('p3')
myP3.addEventListener('click', clickP3)