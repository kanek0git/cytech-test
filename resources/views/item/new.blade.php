@extends('layouts.app')

@section('title', '商品新規登録画面')

@section('content')
<div class="content-area regist-form">
    <div class="content-title">
        <p>商品新規登録フォーム</p>
    </div>
    <div class="content-main">
        <div class="msg">
            <ul>
                <div class="success">
                    @if ($msg)
                    <li>SUCCESS: {{ $msg }}</li>
                    @endif
                </div>
                <div class="error">
                    @foreach ($errors->all() as $error)
                    <li>ERROR: {{ $error }}</li>
                    @endforeach
                </div>
            </ul>
        </div>
        <form action="{{ route('regist') }}" method="post" enctype="multipart/form-data">
            @csrf
            <table>
                <tr><th>商品名<span class="required">必須</span></th><td><input type="text" name="product_name" value="{{ old('product_name') }}" placeholder="商品名を入力"></td></tr>
                <tr><th>メーカー<span class="required">必須</span></th>
                    <td>
                        <select name="company_id" onchange="changeSelectColor(this)">
                            <option value="" selected disabled>メーカー名を選択</option>
                            @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr><th>価格<span class="required">必須</span></th><td class="td-price"><input type="text" name="price" value="{{ old('price') }}" placeholder="価格を入力"><span class="price-unit">円</span></td></tr>
                <tr><th>在庫数<span class="required">必須</span></th><td><input type="text" name="stock" value="{{ old('stock') }}" placeholder="在庫数を入力"></td></tr>
                <tr><th>コメント</th><td><textarea name="comment" placeholder="コメントを入力">{{ old('comment') }}</textarea></td></tr>
                <tr><th>商品画像</th><td><input type="file" name="img_file"></td></tr>
            </table>
            <div class="btn-area">
                <input class="ps-btn regist-btn" type="submit" value="登録">
                <a class="ps-btn return-btn" href="{{ route('index') }}">戻る</a>
            </div>
        </form>
    </div>
</div>
@endsection
