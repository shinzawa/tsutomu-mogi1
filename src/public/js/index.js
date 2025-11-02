function copySearchValue() {
    const mainSearch = document.getElementById('main-search');
    const hiddenSearch = document.getElementById('hidden-search');
    hiddenSearch.value = mainSearch.value;
}