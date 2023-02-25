@extends('layouts.app')

@section('title', '商品情報編集画面')

@section('content')
<div class="content-area edit-form">
    <form action="{{ route('update', ['id' => $product->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="content-title title-with-btn">
            <p>商品詳細情報編集フォーム</p>
            <div class="btn-area">
                <input class="ps-btn update-btn" type="submit" value="保存">
                <a class="ps-btn cancel-btn" href="{{ route('show', ['id' => $product->id]) }}">戻る</a>
            </div>
        </div>
        <div class="content-main">
            <div class="msg">
                <ul>
                    <div class="success">
                        @if (session('msg'))
                        <li>SUCCESS: {{ session('msg') }}</li>
                        @endif
                    </div>
                    <div class="error">
                        @foreach ($errors->all() as $error)
                        <li>ERROR: {{ $error }}</li>
                        @endforeach
                    </div>
                </ul>
            </div>
            <table>
                <tr><th>商品情報ID</th><td>{{ $product->id }}</td></tr>
                <tr><th>商品名<span class="required">必須</span></th><td><input type="text" name="product_name" value="{{ $product->product_name }}"></td></tr>
                <tr><th>メーカー<span class="required">必須</span></th>
                    <td>
                        <select name="company_id">
                            @foreach ($companies as $company)
                                @if ($company->id === $product->company_id)
                                <option value="{{ $company->id }}" selected>{{ $company->company_name }}</option>
                                @else
                                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr><th>価格<span class="required">必須</span></th><td class="td-price"><input type="text" name="price" value="{{ $product->price }}"><span class="price-unit">円</span></td></tr>
                <tr><th>在庫数<span class="required">必須</span></th><td><input type="text" name="stock" value="{{ $product->stock }}"></td></tr>
                <tr><th>コメント</th><td><textarea name="comment">{{ $product->comment }}</textarea></td></tr>
                <tr><th>商品画像</th><td><input type="file" name="img_file"></td></tr>
                <tr><th colspan="2"><span class="center-th">現在設定されている商品画像</span></th></tr>
            </table>
            <img class="product-img" src="{{ '../'.$product->img_path }}" alt="商品画像">
        </div>
    </form>
</div>
@endsection
