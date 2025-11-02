const myButton = document.getElementById('item-card__nice-btn');
const images = ['../../../star8.png', '../../../star8red.png'];
let currentIndex = 0;

// myButton.addEventListener('click', () => {
//     currentIndex = (currentIndex + 1) % images.length;

//     myButton.style.backgroundImage = `url('${images[currentIndex]}')`;
// });
function myFunction(newvalue) {
    console.log("here", newvalue);
    if (newvalue == 1) {
        setTimeout(function () {
            myButton.style.backgroundImage = `url('${images[0]}')`;
        }, 2000);
    } else {
        setTimeout(function () {
            myButton.style.backgroundImage = `url('${images[1]}')`;
        }, 2000);
    }        
}
