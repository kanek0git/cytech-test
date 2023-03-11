@extends('layouts.app')

@section('title', '商品情報一覧画面')

@section('content')
<div class="content-area product-list">
    <div class="content-title title-with-btn">
        <p>商品一覧</p>
        <nav class="header-nav">
            <div class="nav-list sort" onclick="toggleSortMenu()">並び替え</div>
            <div class="nav-list search" onclick="toggleSearchMenu()">絞り込み</div>
            <a class="ps-btn new-btn" href="{{ route('new') }}">新規登録</a>
        </nav>
        <div id="search-nav-contents">
            <div class="nav-table">
                <table>
                    <tr>
                        <th>商品名</th>
                        <td><input id="search-form-product-name" type="text" name="product_name" placeholder="商品名を入力"></td>
                    </tr>
                    <tr>
                        <th>メーカー名</th>
                        <td>
                            <select id="search-form-company" class="select-form" name="company_id" onchange="changeSelectColor()">
                                <option class="non-selectable" value="" selected>メーカー名を選択</option>
                                @foreach ($companies as $company)
                                <option class="selectable" value="{{ $company->id }}">{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>価格</th>
                        <td>
                            <input id="search-form-price-lower" type="number" name="price-lower" placeholder="下限">
                            円 ～ 
                            <input id="search-form-price-upper" type="number" name="price-upper" placeholder="上限">
                            円
                        </td>
                    </tr>
                    <tr>
                        <th>在庫数</th>
                        <td>
                            <input id="search-form-stock-lower" type="number" name="stock-lower" placeholder="下限">
                            個 ～ 
                            <input id="search-form-stock-upper" type="number" name="stock-upper" placeholder="上限">
                            個 
                        </td>
                    </tr>
                    <tr>
                        <td class="search-btn-area" colspan="2">
                            <button id="search-form-submit" class="ps-btn search-btn">検索</button>
                            <button id="search-form-reset" class="ps-btn reset-btn">リセット</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="sort-nav-contents">
            <div class="nav-table">
                <table>
                    <tr>
                        <th onclick="toggleDirection('id')">ID</th><td class="direction-column id asc">昇順</td><td class="direction-column id desc is-active">降順</td>
                    </tr>
                    <tr>
                        <th onclick="toggleDirection('product_name')">商品名</th><td class="direction-column product_name asc">昇順</td><td class="direction-column product_name desc">降順</td>
                    </tr>
                    <tr>
                        <th onclick="toggleDirection('price')">価格</th><td class="direction-column price asc">昇順</td><td class="direction-column price desc">降順</td>
                    </tr>
                    <tr>
                        <th onclick="toggleDirection('stock')">在庫数</th><td class="direction-column stock asc">昇順</td><td class="direction-column stock desc">降順</td>
                    </tr>
                    <tr>
                        <th onclick="toggleDirection('company_id')">メーカー名</th><td class="direction-column company_id asc">昇順</td><td class="direction-column company_id desc">降順</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="product-contents" onclick="closeNav()">
        <div id="contents-list"></div>
    </div>
    <script type="application/javascript" src="{{ asset('js/list.js') }}"></script>
</div>
@endsection
