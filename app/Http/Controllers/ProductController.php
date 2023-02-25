<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

class ProductController extends Controller
{
    // ログイン判定
    public function __construct() {
        $this->middleware('auth');
    }

    /* 
     * 商品情報一覧画面表示
    */
    public function index() {
        // メーカー情報を全件取得
        $companies = Company::get();

        // 製品情報を全件取得
        $products = Product::get();

        return view('item.index', [
            'companies' => $companies,
            'products' => $products
        ]);
    }

    /* 
     * 商品検索機能
    */
    public function search(Request $request) {
        $product = new Product();
        $products = $product->searchProducts($request);
        
        // メーカー情報を全件取得
        $companies = Company::get();

        return view('item.index', [
            'companies' => $companies,
            'products' => $products
        ]);
    }

    /* 
     * 商品新規登録画面表示
    */
    public function new() {
        // メーカー情報を全件取得
        $companies = Company::get();
        return view('item.new', [
            'msg' => '',
            'companies' => $companies
        ]);
    }

    /* 
     * 商品新規登録機能
    */
    public function regist(ProductRequest $request) {
        // 画像をストレージに保存
        $img_path = $this->saveImgFile($request);

        // メーカー情報を全件取得
        $companies = Company::get();

        // トランザクション開始
        DB::beginTransaction();
        try {
            // 製品情報をDB登録
            $product = new Product();
            $product->InsertProduct($request, $img_path);
            DB::commit();

            // 正常終了メッセージ格納
            $request->session()->flash('msg', config('const.success_msg.regist'));
        } catch (\Exception $e) {
            DB::rollback();
            info($e->getMessage());

            // 異常終了メッセージ格納
            $error_msg = new MessageBag();
            $error_msg->add('', config('const.error_msg.regist'));
            $errors = new ViewErrorBag();
            $errors->put('default', $error_msg);
            $request->session()->flash('errors', $errors);

            return back();
        }
        
        return view('item.new', [
            'companies' => $companies
        ]);
    }
    
    /* 
     * 商品詳細画面表示
    */
    public function show($id) {
        $product = Product::find($id);
        return view('item.show', ['product' => $product]);
    }

    /* 
    * 商品削除機能
    */
    public function destroy($id) {
        // トランザクション開始
        DB::beginTransaction();
        try {
            $product = Product::find($id);
            $product->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            info($e->getMessage());
            return back();
        }
        
        return redirect()->route('index');
    }
    
    /* 
    * 商品編集画面表示
    */
    public function edit($id) {
        $product = Product::find($id);
        // メーカー情報を全件取得
        $companies = Company::get();
        
        return view('item.edit', [
            'msg' => '',
            'product' => $product,
            'companies' => $companies
        ]);
    }
    
    /* 
    * 商品情報更新処理
    */
    public function update(ProductRequest $request, $id) {
        // 画像をストレージに保存
        $img_path = $this->saveImgFile($request);

        // メーカー情報を全件取得
        $companies = Company::get();

        // トランザクション開始
        DB::beginTransaction();
        try {
            $product = Product::find($id);
            $product->updateProduct($request, $img_path);
            DB::commit();

            // 正常終了メッセージ格納
            $request->session()->flash('msg', config('const.success_msg.update'));
        } catch (\Exception $e) {
            DB::rollback();
            info($e->getMessage());

            // 異常終了メッセージ格納
            $error_msg = new MessageBag();
            $error_msg->add('', config('const.error_msg.update'));
            $errors = new ViewErrorBag();
            $errors->put('default', $error_msg);
            $request->session()->flash('errors', $errors);

            return back();
        }
        
        return view('item.edit', [
            'product' => $product,
            'companies' => $companies
        ]);
    }

    // 画像保存処理
    private function saveImgFile($request) {
        // 画像ファイル名にデフォルト値設定
        $img_name = config('const.img.default_img_name');
    
        $img_file = $request->file('img_file');
        if ($img_file) {
            // 画像ファイル添付ありの時は画像ファイル名を差し替え
            $img_name = $img_file->getClientOriginalName();
    
            // 取得したファイル名で保存
            $request->file('img_file')->storeAs(config('const.img.path_public'), $img_name);

            // ファイル格納場所のパスを返却
            return config('const.img.path_storage').$img_name;
        }
        // デフォルト画像格納場所のパスを返却
        return config('const.img.path_default').$img_name;
    }
}
