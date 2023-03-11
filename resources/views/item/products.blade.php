@foreach ($products as $product)
@include('item.product', ['product' => $product])
@endforeach
