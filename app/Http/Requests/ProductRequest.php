<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        // ログイン認証済みであればtrue
        if (Auth::check())
        {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'product_name' => 'required',
            'company_id' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric'
        ];
    }

    public function messages() {
        return [
            'product_name.required' => '商品名は必ず入力してください。',
            'company_id.required' => 'メーカーは必ず選択してください。',
            'price.required' => '価格は必ず入力してください。',
            'price.numeric' => '価格は数値で入力してください。',
            'stock.required' => '在庫数は必ず入力してください。',
            'stock.numeric' => '在庫数は数値で入力してください。'
        ];
    }
}
