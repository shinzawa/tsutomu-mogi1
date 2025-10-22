const myButton = document.getElementById('item-card__nice-btn');

myButton.addEventListener('click', function () {
    // 現在の背景色を取得して、次の色に切り替える
    if (myButton.style.backgroundColor === 'red') {
        myButton.style.backgroundColor = 'blue';
    } else {
        myButton.style.backgroundColor = 'red';
    }
});