<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // モデルに紐づくテーブル
    protected $table = 'products';

    // 主キー
    protected $primaryKey = 'id';

    // 変更可能なカラムの指定
    protected $fillable = [
        'id',
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'img_path',
        'created_at',
        'updated_at'
    ];

    // 外部キー
    public function company() {
        return $this->belongsTo('App\Models\Company');
    }

    // 外部キー
    public function sales() {
        return $this->hasMany('App\Models\Sale');
    }

    // productsテーブルの全データ取得
    public function findAllProducts() {
        return Product::all();
    }

    // 商品検索処理
    public function searchProducts($request) {
        $query = $this->query();
        // 商品名の指定がある場合
        if ($request->input('product_name')) {
            // 全角スペースを半角スペースに変換
            $spaceConversion = mb_convert_kana($request->input('product_name'), 's');
            
            // 単語を半角スペースで区切り、配列化
            $searchWordsArr = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
            
            foreach ($searchWordsArr as $searchWord) {
                // 単語ごとに部分一致検索
                $query->where('product_name', 'like', '%'.$searchWord.'%');
            }
            
        }
        // メーカー名の指定がある場合
        if ($request->input('company_id')) {
            $query->where('company_id', $request->input('company_id'));
        }
        // 価格（下限）の指定がある場合
        if ($request->input('price_lower')) {
            $query->where('price', '>=', $request->input('price_lower'));
        }
        // 価格（上限）の指定がある場合
        if ($request->input('price_upper')) {
            $query->where('price', '<=', $request->input('price_upper'));
        }
        // 在庫数（下限）の指定がある場合
        if ($request->input('stock_lower')) {
            $query->where('stock', '>=', $request->input('stock_lower'));
        }
        // 在庫数（上限）の指定がある場合
        if ($request->input('stock_upper')) {
            $query->where('stock', '<=', $request->input('stock_upper'));
        }

        // 並び替え処理
        if ($request->input('sort_key') && $request->input('derection')) {
            $query->orderBy($request->input('sort_key'), $request->input('derection'));
        }

        return $query->get();
    }

    // productsテーブルへの新規登録処理
    public function InsertProduct($request, $img_path) {
        return $this->create([
            'company_id' => $request->company_id,
            'product_name' => $request->product_name,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => (is_null($request->comment)) ? '' : $request->comment,  // コメントNULLの場合は空文字を登録
            'img_path' => $img_path,
        ]);
    }

    // productsテーブルの更新処理
    public function updateProduct($request, $img_path) {
        // 更新データ連想配列
        $dataArr = [
            'company_id' => $request->company_id,
            'product_name' => $request->product_name,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => (is_null($request->comment)) ? '' : $request->comment // コメントNULLの場合は空文字を登録
        ];

        // 画像ファイルの指定がある場合のみimg_pathを更新
        if (!is_null($request->file('img_file'))) {
            $dataArr = array_merge($dataArr, ['img_path' => $img_path]);
        }

        // 更新実行
        $result = $this->fill($dataArr)->save();

        return $result;
    }
}
