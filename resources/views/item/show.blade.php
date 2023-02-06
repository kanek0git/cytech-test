@extends('layouts.app')

@section('title', '商品情報詳細画面')

@section('content')
<div class="content-area show-form">
    <div class="content-title title-with-btn">
        <p>商品詳細情報</p>
        <div class="btn-area">
            <a class="ps-btn edit-btn" href="{{ route('edit', ['id' => $product->id]) }}">編集</a>
            <a class="ps-btn cancel-btn" href="{{ route('index') }}">戻る</a>
        </div>
    </div>
    <div class="content-main">
        <table>
            <tr><th colspan="2">商品情報ID</th><td>{{ $product->id }}</td></tr>
            <tr><th colspan="2">商品名</th><td>{{ $product->product_name }}</td></tr>
            <tr><th rowspan="3">メーカー</th>
                <th>名称</th>
                <td>{{ $product->company->company_name }}</td>
            </tr>
            <tr><th>住所</th><td>{{ $product->company->street_address }}</td></tr>
            <tr><th>代表者名</th><td>{{ $product->company->representative_name }}</td></tr>
            <tr><th colspan="2">価格</th><td>{{ number_format($product->price) }} 円</td></tr>
            <tr><th colspan="2">在庫数</th><td>{{ number_format($product->stock) }}</td></tr>
            <tr><th colspan="2">コメント</th><td>{{ $product->comment }}</td></tr>
            <tr><th colspan="3"><span class="center-th">商品画像</span></th></tr>
        </table>
        <img class="product-img" src="{{ '../'.$product->img_path }}" alt="商品画像">
    </div>
</div>
@endsection
