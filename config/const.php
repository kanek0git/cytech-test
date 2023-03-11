<?php
return [
    'success_msg' => [
        'regist' => '商品情報が正常に登録されました。',
        'update' => '商品情報が正常に更新されました。',
    ],
    'error_msg' => [
        'regist' => '商品情報の登録に失敗しました。',
        'update' => '商品情報の更新に失敗しました。',
        'product_name_required' => '商品名は必ず入力してください。',
        'company_id_required' => 'メーカーは必ず選択してください。',
        'price_required' => '価格は必ず入力してください。',
        'price_numeric' => '価格は数値で入力してください。',
        'stock_required' => '在庫数は必ず入力してください。',
        'stock_numeric' => '在庫数は数値で入力してください。',
    ],
    'img' => [
        'default_img_name' => 'default_img.svg',
        'path_public' => 'public/img',
        'path_storage' => 'storage/img/',
        'path_default' => 'img/',
    ],
    'purchase_msg' => [
        'not_exist_product' => 'お求めの商品は存在しません。',
        'not_exist_stock' => 'お求めの商品の在庫がありません。',
        'success' => '購入処理が正常に完了しました。',
        'error' => '購入処理に失敗しました。',
    ]
];
