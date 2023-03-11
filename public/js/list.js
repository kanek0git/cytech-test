/* 一覧表示画面用JavaScript */

// HTML読み込み時に実行する処理
window.onload = function() {
    searchList(true);
}

// 検索ボタン押下で検索処理実行
$('#search-form-submit').on('click', function() {
    searchList(false);
});

// リセットボタン押下で全件検索
$('#search-form-reset').on('click', function() {
    searchList(true);
})

// セッション格納処理
function setSession(product_name, company_id, price_lower, price_upper, stock_lower, stock_upper) {
    window.sessionStorage.setItem(['product_name'], [product_name]);
    window.sessionStorage.setItem(['company_id'], [company_id]);
    window.sessionStorage.setItem(['price_lower'], [price_lower]);
    window.sessionStorage.setItem(['price_upper'], [price_upper]);
    window.sessionStorage.setItem(['stock_lower'], [stock_lower]);
    window.sessionStorage.setItem(['stock_upper'], [stock_upper]);
}

// 並び替え処理
function sortProduct(sort_key, direction) {
    // セッションから検索情報を取得
    let product_name = window.sessionStorage.getItem(['product_name']);
    let company_id = window.sessionStorage.getItem(['company_id']);
    let price_lower = window.sessionStorage.getItem(['price_lower']);
    let price_upper = window.sessionStorage.getItem(['price_upper']);
    let stock_lower = window.sessionStorage.getItem(['stock_lower']);
    let stock_upper = window.sessionStorage.getItem(['stock_upper']);

    // 検索処理実行
    excuteSearch(product_name, company_id, price_lower, price_upper, stock_lower, stock_upper, sort_key, direction);
}

// 商品検索処理
function searchList(isInitial) {
    // 初期表示の場合は入力なし、それ以外の場合は入力内容を取得
    let product_name = isInitial ? '' : $('#search-form-product-name').val();
    let company_id = isInitial ? '' : $('#search-form-company').val();
    let price_lower = isInitial ? '' : $('#search-form-price-lower').val();
    let price_upper = isInitial ? '' : $('#search-form-price-upper').val();
    let stock_lower = isInitial ? '' : $('#search-form-stock-lower').val();
    let stock_upper = isInitial ? '' : $('#search-form-stock-upper').val();

    // 入力内容を更新
    $('#search-form-product-name').val(product_name);
    $('#search-form-company').val(company_id);
    $('#search-form-price-lower').val(price_lower);
    $('#search-form-price-upper').val(price_upper);
    $('#search-form-stock-lower').val(stock_lower);
    $('#search-form-stock-upper').val(stock_upper);

    // 並び替え項目初期値（ID 降順）
    let sort_key = 'id';
    let direction = 'desc';

    // 検索条件をセッションに格納
    setSession(product_name, company_id, price_lower, price_upper, stock_lower, stock_upper);

    // 検索処理実行
    excuteSearch(product_name, company_id, price_lower, price_upper, stock_lower, stock_upper, sort_key, direction);
}

// 検索処理
function excuteSearch(product_name, company_id, price_lower, price_upper, stock_lower, stock_upper, sort_key, direction) {
    $.ajax('/test/public/search', {
        type: 'post',
        data: {
            'product_name': product_name,
            'company_id': company_id,
            'price_lower': price_lower,
            'price_upper': price_upper,
            'stock_lower': stock_lower,
            'stock_upper': stock_upper,
            'sort_key' : sort_key,
            'derection': direction
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),}
    })
    .done(function(data) {
        $('#contents-list').html(data);
    })

    // セレクトボックスの文字色変更
    changeSelectColor();
}

// 昇順・降順の表示切替と並び替え実行
function toggleDirection(sort_key) {
    let sortKeyAsc;
    let sortKeyDesc;
    $('.direction-column').each(function(index, el) {
        if (el.classList.contains(sort_key) && el.classList.contains('asc')) {
            sortKeyAsc = el;
        } else if (el.classList.contains(sort_key) && el.classList.contains('desc')) {
            sortKeyDesc = el;
        } else {
            // 並び替え対象以外の要素は非アクティブ化
            el.classList.remove('is-active');
        }
    });

    // 昇順・降順の切替と並び替え処理実行
    if (sortKeyAsc.classList.contains('is-active')) {
        sortKeyAsc.classList.remove('is-active');
        sortKeyDesc.classList.add('is-active');
        sortProduct(sort_key, 'desc');
    } else {
        sortKeyAsc.classList.add('is-active');
        sortKeyDesc.classList.remove('is-active');
        sortProduct(sort_key, 'asc');
    }
}

// ナビゲーションを閉じる
function closeNav() {
    fadeOutSearchMenu();
    fadeOutSortMenu();
}

// 並び替えナビゲーション非表示
function fadeOutSortMenu() {
    $('.sort').removeClass('is-active');
    $('#sort-nav-contents').stop().slideUp(100);
}

// 並び替えナビゲーションの表示・非表示切替
function toggleSortMenu() {
    // 絞り込みナビゲーションを非表示
    fadeOutSearchMenu();

    // クリックした要素を表示させる
    $('.sort').toggleClass('is-active');
    $('#sort-nav-contents').stop().slideToggle(100);
}

// 絞り込みナビゲーション非表示
function fadeOutSearchMenu() {
    $('.search').removeClass('is-active');
    $('#search-nav-contents').stop().slideUp(100);
}

// 絞り込みナビゲーションの表示・非表示切替
function toggleSearchMenu() {
    // 並び替えナビゲーションの非表示
    fadeOutSortMenu();

    // クリックした要素を表示させる
    $('.search').toggleClass('is-active');
    $('#search-nav-contents').stop().slideToggle(100);
}

// 削除確認ダイアログ表示
function showDeleteConfirm(id) {
    let isDelete = confirm('この商品情報を削除しますか？');
    
    // OKの場合、削除処理実行
    if (isDelete) {
        let deferred = destroyProduct(id);
        // 削除処理が完了してから実行
        deferred.done(function() {
            // 商品一覧を更新
            showList(true);
        })
    }
}

// 削除処理
function destroyProduct(id) {
    let deferred = new $.Deferred();
    $.ajax(`/test/public/destroy/${id}`, {
        type: 'get'
    }).always(function() {
        deferred.resolve();
    });

    return deferred;
}
