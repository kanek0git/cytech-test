<div class="product">
    <img src="{{ $product->img_path }}" alt="商品画像">
    <div class="product-info">
        <table>
            <tr>
                <th>ID</th><td>{{ $product->id }}</td>
            </tr>
            <tr>
                <th>商品名</th><td>{{ $product->product_name }}</td>
            </tr>
            <tr>
                <th>価格</th><td>{{ number_format($product->price) }} 円</td>
            </tr>
            <tr>
                <th>在庫数</th><td>{{ number_format($product->stock) }}</td>
            </tr>
            <tr>
                <th>メーカー名</th><td>{{ $product->company->company_name }}</td>
            </tr>
        </table>
        <div class="btn-area">
            <a class="ps-btn view-btn" href="{{ route('show', ['id' => $product->id]) }}">詳細表示</a>
            <a class="ps-btn delete-btn" href="{{ route('destroy', ['id' => $product->id]) }}" onclick='return showDeleteConfirm()'>削除</a>
        </div>
    </div>
</div>
