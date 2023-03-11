<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    /* 商品購入処理
     * 
     * API呼び出し用URL　   ：http://localhost:8888/test/public/api/purchase
     * リクエストボディの例  ：{"product_id":1}
    */
    public function purchase(Request $request) {
        $msg = '';

        // 製品在庫確認
        $product = Product::find($request->product_id);
        if (!$product) {
            $msg = config('const.purchase_msg.not_exist_product');
            return $msg;
        } else if ($product->stock <= 0) {
            $msg = config('const.purchase_msg.not_exist_stock');
            return $msg;
        }

        // トランザクション開始
        DB::beginTransaction();
        try {
            // 購入情報をDB登録
            $sale = new Sale();
            $sale->InsertSale($request);
            DB::commit();

            // 商品在庫数を減らす
            $product->stock --;
            $product->save();

            // 正常終了メッセージ格納
            $msg = config('const.purchase_msg.success');
        } catch (\Exception $e) {
            DB::rollback();
            info($e->getMessage());

            // 異常終了メッセージ格納
            $msg = config('const.purchase_msg.error');
        }
        return $msg;
    }
}
