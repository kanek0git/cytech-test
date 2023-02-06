@extends('layouts.app')

@section('title', '商品情報一覧画面')

@section('content')
<div class="content-area search-form">
    <div class="content-title">
        <p>商品検索</p>
    </div>
    <div class="content-main search-content">
        <form action="{{ route('search') }}" method="post">
            <table>
                @csrf
                <tr>
                    <th>商品名</th>
                    <td><input type="text" name="product_name" placeholder="商品名を入力"></td>
                    <th>メーカー名</th>
                    <td>
                        <select name="company_id" onchange="changeSelectColor(this)">
                            <option value="" selected>メーカー名を選択</option>
                            @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </table>
            <input class="ps-btn search-btn" type="submit" value="検索">
        </form>
    </div>
</div>
<div class="content-area product-list">
    <div class="content-title title-with-btn">
        <p>商品一覧</p>
        <a class="ps-btn new-btn" href="{{ route('new') }}">新規登録</a>
    </div>
    <div class="product-contents">
        @foreach ($products as $product)
        @include('item.product', ['product' => $product])
        @endforeach
    </div>
</div>
@endsection
