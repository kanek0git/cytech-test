/* 共通JavaScript */

function changeSelectColor() {
    if ($('.select-form').val()) {
        $('.select-form').css('color', '#606060');
    } else {
        $('.select-form').css('color', '#999');
    }
}
