function changeSelectColor(el) {
    if (el.value) {
        el.style.color = '#606060';
    } else {
        el.style.color = '#999';
    }
}

function showDeleteConfirm() {
    return confirm('この商品情報を削除しますか？');
}
