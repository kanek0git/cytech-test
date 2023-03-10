<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    // 外部キー
    public function products() {
        return $this->hasMany('App\Models\Product');
    }
}
