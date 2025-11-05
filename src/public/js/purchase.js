// HTML要素を取得する
const mySelect = document.getElementById('purchase-method-select');
const myHidden = document.getElementById('purchaseMethod');
const displayArea = document.getElementById('display-purchase-method');


// selectボックスの変更を監視する
mySelect.addEventListener('change', (event) => {
  // 選択された値を取得する
  const selectedValue = event.target.value;

  // spanタグに表示する場合
  displayArea.textContent = selectedValue;
  myHidden.value = selectedValue;
});