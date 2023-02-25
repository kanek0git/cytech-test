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
            'product_name.required' => config('const.error_msg.product_name_required'),
            'company_id.required' => config('const.error_msg.company_id_required'),
            'price.required' => config('const.error_msg.price_required'),
            'price.numeric' => config('const.error_msg.price_numeric'),
            'stock.required' => config('const.error_msg.stock_required'),
            'stock.numeric' => config('const.error_msg.stock_numeric'),
        ];
    }
}
