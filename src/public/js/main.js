const fileNameDisplay = document.getElementById('fileNameDisplay');

function previewFile(item) {
    var fr = new FileReader();
    fr.onload = (function () {
        document.getElementById('preview').src = fr.result;
        document.getElementById('preview').style.display = 'block';
        document.getElementById('dummy').style.display = 'none';
    });
    fr.readAsDataURL(item.files[0]);
    fileNameDisplay.textContent = item.files[0].name;
}
