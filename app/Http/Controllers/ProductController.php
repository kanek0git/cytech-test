<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

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
        $img_name = $this->saveImgFile($request);

        // 製品情報をDB登録
        $product = new Product();
        $product->InsertProduct($request, 'storage/img/'.$img_name);
        
        // メーカー情報を全件取得
        $companies = Company::get();
        return view('item.new', [
            'msg' => '商品情報が正常に登録されました。',
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
        $product = Product::find($id);
        $product->delete();
        
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
        $img_name = $this->saveImgFile($request);

        $product = Product::find($id);
        $product->updateProduct($request, 'storage/img/'.$img_name);
        
        // メーカー情報を全件取得
        $companies = Company::get();
        
        return view('item.edit', [
            'msg' => '商品情報が正常に更新されました。',
            'product' => $product,
            'companies' => $companies
        ]);
    }

    // 画像保存処理
    private function saveImgFile($request) {
        // 画像ファイル名にデフォルト値設定
        $img_name = 'default_img.svg';
    
        $img_file = $request->file('img_file');
        if ($img_file) {
            // 画像ファイル添付ありの時は画像ファイル名を差し替え
            $img_name = $img_file->getClientOriginalName();
    
            // 取得したファイル名で保存
            $request->file('img_file')->storeAs('public/img', $img_name);
        }
        return $img_name;
    }
}
