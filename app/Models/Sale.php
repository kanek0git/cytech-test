<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    // モデルに紐づくテーブル
    protected $table = 'sales';

    // 主キー
    protected $primaryKey = 'id';

    // 変更可能なカラムの指定
    protected $fillable = [
        'id',
        'product_id',
        'created_at',
        'updated_at'
    ];

    // 外部キー
    public function product() {
        return $this->belongsTo('App\Models\Product');
    }

    // salesテーブルへの新規登録処理
    public function InsertSale($request) {
        return $this->create([
            'product_id' => $request->product_id,
        ]);
    }
}
